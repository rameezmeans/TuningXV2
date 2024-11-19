<?php

namespace App\Http\Controllers;

use ECUApp\SharedCode\Models\Language;
use ECUApp\SharedCode\Models\Credit;
use ECUApp\SharedCode\Models\File;
use ECUApp\SharedCode\Models\Tool;
use ECUApp\SharedCode\Models\User;
use ECUApp\SharedCode\Models\UserTool;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Client\ConnectionException;

class AccountController extends Controller
{
    private $frontendID;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->frontendID = 2;
        $this->middleware('auth');
    }

    public function boschECU(){
        
        $user = Auth::user();

        return view('bosch');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();

        $languages = Language::where('user_id', $user->id)->get();
        $credits = Credit::orderBy('created_at', 'desc')->where('is_evc', 0)->where('user_id', $user->id)->get();
        $evcCredits = Credit::orderBy('created_at', 'desc')->where('is_evc', 1)->where('user_id', $user->id)->get();
        
        $masterTools = $user->tools_master;

        $masterToolsArray = [];
        if($masterTools){
            foreach($masterTools as $m){
                $masterToolsArray []= $m->tool_id;
            }
        }   

        $slaveTools =  $user->tools_slave;

        $slaveToolsArray = [];
        if($slaveTools){
            foreach($slaveTools as $s){
                $slaveToolsArray []= $s->tool_id;
            }
        }   

        $allMasterTools = Tool::where('type', 'master')->get();
        $allSlaveTools = Tool::where('type', 'slave')->get();
        
        return view('account', [ 'user' => $user, 'allMasterTools' => $allMasterTools, 'allSlaveTools' => $allSlaveTools, 'languages' => $languages, 'credits' => $credits,'evcCredits' => $evcCredits, 'masterTools' =>  $masterToolsArray,'slaveTools' => $slaveToolsArray ]);
    }

    function editAccount(Request $request){

        $user = Auth::user();
        
        $anyOtherUserWithSameUniqueEVCCustomerID = User::where('evc_customer_id', $request->evc_customer_id)
        ->where('id','!=', $user->id)
        ->first();
        

        if($anyOtherUserWithSameUniqueEVCCustomerID && $request->evc_customer_id){

            $validated = $request->validate([
                // 'company_name' => 'required|max:255',
                // 'company_id' => 'required|max:255',
                'name' => 'required|max:255',
                'phone' => 'required|max:255',
                'evc_customer_id' => 'unique:users',
            ]);

        }
        else{

            $validated = $request->validate([
                // 'company_name' => 'required|max:255',
                // 'company_id' => 'required|max:255',
                'name' => 'required|max:255',
                'phone' => 'required|max:255',
            ]);

        }
        
        $user->company_name = $request->company_name;
        $user->company_id = $request->company_id;
        $user->name = $request->name;
        $user->phone = $request->phone;
        
        $user->evc_customer_id = $request->evc_customer_id;
        $user->save();

        $files = File::where('user_id', $user->id)->get();

        foreach($files as $file){
            $file->name = $user->name;
            $file->phone = $user->phone;
            $file->email = $user->email;
            $file->save();
        }

        $data []= ['name' => 'first_name','contents' => $user->name];
        
        if($user->elorus_id){
            
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.elorus.com/v1.1/contacts/'.$user->elorus_id.'/');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"first_name\":\"$user->name\", \"last_name\":\"\", \"vat_number\":\"$user->company_id\",\"company\":\"$user->company_name\",\"active\":true, \"is_supplier\":false}");

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: Token 32fd4c0b90ac267da4c548ea4410b126db2eaf53';
            $headers[] = 'X-Elorus-Organization: 1357060486331368800';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

        }
        

        try{

            $response = Http::get('https://evc.de/services/api_resellercredits.asp?apiid=j34sbc93hb90&username=161134&password=MAgWVTqhIBitL0wn&verb=addcustomer&customer='.$user->evc_customer_id);

            $body = $response->body();

            $ok = substr($body, 0, 2);
            
            if($ok == 'ok'){
                return redirect()->route('account')->with('success', 'EVC account is created, successfully!');
            }
            else{
                return redirect()->route('account')->with('success', 'Account updated but EVC function remained unchanged!');
            }

        }

        catch(ConnectionException $e){
            return redirect()->route('account')->with('danger', 'EVC account is not created!');
        }

        return redirect()->route('account')->with('success', 'account edited, successfully!');
    }

    /**
     * get tools icons
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getToolsIcons(Request $request)
    {
        $tools = Tool::all();

        $toolsArray = [];

        foreach($tools as $tool){
           
            $toolsArray[$tool->id] = "https://backend.ecutech.gr/icons/".$tool->icon;
           
        }

        return response()->json($toolsArray);
    }

    /**
     * Update Tools.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateTools(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        UserTool::where('user_id', $user->id)->where('type', 'master')->delete();

        $masterTools = $request->master_tools;

        if($masterTools){
        
            foreach($masterTools as $mid){

                $record = new UserTool();
                $record->type = 'master';
                $record->user_id = $user->id;
                $record->tool_id = $mid;
                $record->save();
               
            }
        }

        UserTool::where('user_id', $user->id)->where('type', 'slave')->delete();

        $slaveTools = $request->slave_tools;

        if($slaveTools){

            foreach($slaveTools as $sid){

                $record = new UserTool();
                $record->type = 'slave';
                $record->user_id = $user->id;
                $record->tool_id = $sid;
                $record->save();
                
            }
        }
        
        return redirect()->route('account',['success' => 'Tools edited, successfully!']);
        
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changePassword(Request $request)
    {

        $customValidationMessages = [
            'password.required' => 'We thought you wanted to change your password. Please provide a new password.',
            'password.min' => 'Please provide a password at least 8 characters long. Your account will be safer this way!',
            'password.confirm' => 'Nope! You did not confirm you want to use that password. Please confirm your password.'
        ];

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|same:confirm_password',
            'confirm_password' => 'required',
          ], $customValidationMessages);
  
          $user = \Auth::user();

          if (!\Hash::check($request->current_password, $user->password)) {
            return redirect()->route('account',['error' => 'Password does not match!']);
          }
  
          $user->password = \Hash::make($request->new_password);
  
          $user->save();
  
          return redirect()->route('account',['success' => 'Password udpated, successfully!']);
    }
}
