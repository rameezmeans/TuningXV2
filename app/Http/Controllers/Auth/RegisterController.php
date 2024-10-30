<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\ReCaptcha;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Cache\Adapter\PHPArray\ArrayCachePool;
use ECUApp\SharedCode\Controllers\AuthMainController;
use ECUApp\SharedCode\Models\NewsFeed;
use ECUApp\SharedCode\Models\Tool;
use ECUApp\SharedCode\Models\User;
use ECUApp\SharedCode\Models\UserTool;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing;
use Mailchimp_Error;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    private $authMainObj;
    private $frontEndID;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->frontEndID = 2;
        $this->authMainObj = new AuthMainController();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {

        $masterTools = Tool::where('type', 'master')->get();
        $slaveTools = Tool::where('type', 'slave')->get();
        return view('auth.register', ['masterTools' => $masterTools, 'slaveTools' => $slaveTools]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   

        $unique = User::where('email', $data['email'])
        ->where('front_end_id', 2)->first();

        // if($data['evc_customer_id']){
        //     return Validator::make($data, [
        //         'name' => ['required', 'string', 'max:255'],
        //         'phone' => ['required', 'string', 'max:255'],
        //         'language' => ['required', 'string', 'max:255'],
        //         'address' => ['required', 'string', 'max:255'],
        //         'zip' => ['required', 'string', 'max:255'],
        //         'city' => ['required', 'string', 'max:255'],
        //         'country' => ['required', 'string', 'max:255'],
        //         'status' => ['required', 'string', 'max:255'],
        //         'company_name' => ['max:255'],
        //         'company_id' => ['max:255'],
        //         'slave_tools_flag' => ['string', 'max:255'],
        //         'master_tools' => [],
        //         'slave_tools' => [],
        //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //         'evc_customer_id' => ['required','unique:users', 'string'],
        //         'password' => ['required', 'string', 'min:8', 'confirmed'],
        //         'g-recaptcha-response' => ['required', new ReCaptcha]
        //     ]);
        // }
        // else{

            if($unique != NULL){
                    
                    return Validator::make($data, [
                        'name' => ['required', 'string', 'max:255'],
                        'phone' => ['required', 'string', 'max:255'],
                        'language' => ['required', 'string', 'max:255'],
                        'address' => ['required', 'string', 'max:255'],
                        'zip' => ['required', 'string', 'max:255'],
                        'city' => ['required', 'string', 'max:255'],
                        'country' => ['required', 'string', 'max:255'],
                        'status' => ['required', 'string', 'max:255'],
                        'company_name' => ['max:255'],
                        'company_id' => ['max:255'],
                        'slave_tools_flag' => ['string', 'max:255'],
                        'master_tools' => [],
                        'slave_tools' => [],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                        'g-recaptcha-response' => ['required', new ReCaptcha]
                    ]);

            }

            else{
                return Validator::make($data, [
                    'name' => ['required', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'max:255'],
                    'language' => ['required', 'string', 'max:255'],
                    'address' => ['required', 'string', 'max:255'],
                    'zip' => ['required', 'string', 'max:255'],
                    'city' => ['required', 'string', 'max:255'],
                    'country' => ['required', 'string', 'max:255'],
                    'status' => ['required', 'string', 'max:255'],
                    'company_name' => ['max:255'],
                    'company_id' => ['max:255'],
                    'slave_tools_flag' => ['string', 'max:255'],
                    'master_tools' => [],
                    'slave_tools' => [],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'g-recaptcha-response' => ['required', new ReCaptcha]
                ]);
        }
        // }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $alreadyThereUser = User::where('email', $data['email'])->first();

        if(isset( $data['slave_tools_flag'])){
            $slaveToolsFlag = $data['slave_tools_flag'];

            if(isset($data['slave_tools'])){
                $slaveTools = $data['slave_tools'];
            }
            else{
                $slaveTools = [];
            }
        }
        else{
            $slaveToolsFlag = 0;
            $slaveTools = [];
        }
        
        if(isset( $data['master_tools'])){
            $masterTools = $data['master_tools'];
        }
        else{
            $masterTools = [];
        }

        $feeds = NewsFeed::where('active', 1)
        ->whereNull('subdealer_group_id')
        ->where('front_end_id', 2)
        ->get();

        foreach($feeds as $feed){
            Session::put('feed', $feed);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'language' => $data['language'],
            'address' => $data['address'],
            'zip' => $data['zip'],
            'city' => $data['city'],
            'country' => $data['country'],
            'status' => $data['status'],
            'company_name' => $data['company_name'],
            'company_id' => $data['company_id'],
            'front_end_id' => 2,
            // 'evc_customer_id' => $data['evc_customer_id'],
            'slave_tools_flag' => $slaveToolsFlag,
            'password' => Hash::make($data['password']),
        ]);

        
        if( count($user->tools) == 0 ){
            $userTool = new UserTool();
            $userTool->user_id = $user->id;
            $userTool->tool_id = 20;
            $userTool->type = 'master';
            $userTool->save();
        }
        
        // if($user->evc_customer_id){

        //     try{

        //         $response = Http::get('https://evc.de/services/api_resellercredits.asp?apiid=j34sbc93hb90&username=161134&password=MAgWVTqhIBitL0wn&verb=addcustomer&customer='.$user->evc_customer_id);

        //         $body = $response->body();

        //     }

        //     catch(ConnectionException $e){
                
        //     }

        // }

        if(count($masterTools) > 0){
        
            foreach($masterTools as $mid){

                $record = new UserTool();
                $record->type = 'master';
                $record->user_id = $user->id;
                $record->tool_id = $mid;
                $record->save();
               
            }
        }

        if(count($slaveTools) > 0){
        
            foreach($slaveTools as $sid){

                $record = new UserTool();
                $record->type = 'slave';
                $record->user_id = $user->id;
                $record->tool_id = $sid;
                $record->save();
               
            }
        }

        if($alreadyThereUser != NULL){
            $user->zohobooks_id = $alreadyThereUser->zohobooks_id;
            $user->elorus_id = $alreadyThereUser->elorus_id;
            $user->save();
        }

        else{

        $psr6CachePool = new ArrayCachePool();

        $oAuthClient = new \Weble\ZohoClient\OAuthClient('1000.4YI5VY0ZVV0RULDS2BEWFU0GGTVYBL', '51c344a63a6a5de0630f64e87ea3676ced55722589');

        $oAuthClient->setRefreshToken('1000.4c53b2c0d581b45ceac3f380cb37dc99.b95732ec540ced24f044dcffee32dfa7');
        
        $oAuthClient->setRegion('eu');
        $oAuthClient->useCache($psr6CachePool);

        // setup the zoho books client
        $client = new \Webleit\ZohoBooksApi\Client($oAuthClient);
        $client->setOrganizationId('8745725');

        $zohoBooks = new \Webleit\ZohoBooksApi\ZohoBooks($client);

        try{

            $sarchContact = $zohoBooks->contacts->getList(['contact_name_contains' => $user->name])->toArray();

            if(empty($sarchContact)){

                $contact = $zohoBooks->contacts->create(
        
                    [
                        "contact_name" => $user->name,
                        "contact_email" => $user->email,
                        "company_name" => $user->company_name,
                        "contact_type" => "customer",
                        "customer_sub_type" => "business",
                        "is_portal_enabled" => false,
                        "billing_address" => [
                            "attention" =>  "Mr. ".$user->name,
                            "address" => $user->address,
                            "city" => $user->city,
                            "zip" =>  $user->zip,
                            "country" =>  $user->country,
                            "phone" =>  $user->phone,
                        ],
                    ]
        
                );

                $user->zohobooks_id = $contact->contact_id;
                $user->save();
            }
            else{

                $value = reset($sarchContact);
                $user->zohobooks_id = $value['contact_id'];
                $user->save();

            }

            
        }
        catch(ClientException $e){
            Log::info($e->getMessage());
        }
        
        try{
        
            $client = new MailchimpMarketing\ApiClient();

            $client->setConfig([
                'apiKey' => 'cdc22134ee97dfedeaa7a85838784b4c-us21',
                'server' => 'us21'
                ]);
        
            //id: cac79dc83a
        
            $member = $client->lists->addListMember("cac79dc83a", [
                "email_address" => $user->email,
                "status" => "pending",
                "tags" => ["portal"],
            ]);

            $user->mailchimp_id = $member->id;
            $user->save();
        
            $response = $client->lists->setListMember("cac79dc83a", $member->id, [
            
            "status" => "subscribed",
            "merge_fields" => [

                "FNAME" => $user->name,
                
               "ADDRESS" => [
                    "addr1" => $user->address,
                    "city" => $user->city,
                    "state" => $user->country,
                    "zip" => $user->zip
                  ]
               ],
            
            ]);
        }

        catch(\Exception $e){

        }
    }

        $this->authMainObj->VATCheckPolicy($user);

        return $user;
        
    }   
}
