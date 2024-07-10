<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use ECUApp\SharedCode\Controllers\AuthMainController;
use ECUApp\SharedCode\Models\File;
use ECUApp\SharedCode\Models\Tool;
use ECUApp\SharedCode\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DateTime;
use ECUApp\SharedCode\Models\Credit;

class AuthController extends Controller
{

    private $authMainObj;
    private $frontEndID;

    public function __construct()
    {   
        $this->frontEndID = 2;
        $this->authMainObj = new AuthMainController();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        $masterTools = Tool::where('type', 'master')->get();
        $slaveTools = Tool::where('type', 'slave')->get();
        return view('auth.registration', ['masterTools' => $masterTools, 'slaveTools' => $slaveTools]);
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $user = User::where('email', $request->email)->first();
        if($user){

            if( $this->authMainObj->loginRule($this->frontEndID, $user) ){

                $credentials = $request->only('email', 'password');

                if (Auth::attempt($credentials)) {

                    return redirect()->intended('home')
                                ->withSuccess('You have Successfully loggedin!');
                }
            }
            else{

                return redirect("login")->with('danger','You have entered invalid credentials!');
            }
        }
  
        return redirect("login")->with('danger','You have entered invalid credentials!');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {   
        $data = $request->all();
        
        $validationArray = $this->authMainObj->getValidationRules($data);
        $request->validate($validationArray);

        $user = $this->authMainObj->registration($data, 2);
         
        if( $this->authMainObj->loginRule($this->frontEndID, $user) ){

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {

                return redirect()->intended('home')
                            ->withSuccess('You have Successfully loggedin!');
            }
        }
        else{

            return redirect("login")->withSuccess('You have entered invalid credentials!');
        }
  
        return redirect("login")->withSuccess('You have entered invalid credentials!');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function home()
    {
        if(Auth::check()){

            $user = Auth::user();
            $users = User::whereNull('subdealer_group_id')->where('role_id', 4)->where('front_end_id', 2)->get();
            $todaysFilesCount = File::where('created_at', '>=', Carbon::today())->where('user_id', $user->id)->count();
            $yesterdaysFilesCount = File::whereDate('created_at', Carbon::yesterday())->where('user_id', $user->id)->count();
            $previousYearsFilesCount = File::whereYear('created_at', now()->subYear()->year)->where('user_id', $user->id)->count();
            $twoYearsAgoFilesCount = File::whereYear('created_at', now()->subYears(2)->year)->where('user_id', $user->id)->count();
            
            $startPrevWeek = Carbon::now()->subWeek()->startOfWeek(); 
            $endPrevWeek   = Carbon::now()->subWeek()->endOfWeek();  

            $previousWeeksFilesCount    = File::query()->whereBetween('created_at',[ $startPrevWeek,$endPrevWeek ])->where('user_id', $user->id)->count();

            $previousMonthsFilesCount = File::whereMonth(
                'created_at', '=', Carbon::now()->subMonth()->month
            )->where('user_id', $user->id)->count();

            $thisWeeksFilesCount = File::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('user_id', $user->id)->count();
            $thisMonthsFilesCount = File::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->where('user_id', $user->id)->count();
            
            $thisWeeksCreditsCount = - (Credit::whereMonth('created_at',Carbon::now()->month)
            ->WhereNotNull('file_id')->where('user_id', $user->id)
            ->sum('credits'));

            $thisYearsFilesCount = File::whereYear('created_at', Carbon::now()->year)->where('user_id', $user->id)->count();
            $thisYearsCreditsCount = -(Credit::whereYear('created_at', Carbon::now()->year)->where('user_id', $user->id)
            ->WhereNotNull('file_id')->sum('credits'));

            $twoFiles = File::orderBy('created_at', 'desc')->where('user_id', $user->id)->take(2)->get();

            $items = File::select('id', 'created_at')->where('user_id', $user->id)
            ->get()
            ->groupBy(function($date) {

                if(Carbon::parse($date->created_at)->format('Y') == date('Y')){
                    //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                    return Carbon::parse($date->created_at)->format('m'); // grouping by months
                }
            });

            $count = [];
            $countYear = [];
            
            foreach ($items as $key => $value) {
                $count[(int)$key] = count($value);
            }
            
            for($i = 1; $i <= 12; $i++){
                if(!empty($count[$i])){
                    $countYear[$i] = $count[$i];    
                }else{
                    $countYear[$i] = 0;    
                }
            }

            $datesMonth = [];
            $datesMonthCount = [];

            for($i = 1; $i <=  date('t'); $i++){
                // add the date to the dates array
                $datesMonth[] =  str_pad($i, 2, '0', STR_PAD_LEFT).'-'. date('M');
                $datesMonthCount []= File::whereMonth('created_at',date('m'))->whereDay('created_at',$i)->where('user_id', $user->id)->count();
            }

            $thisWeekStart = Carbon::now()->startOfWeek();
            $thisWeekEnd = Carbon::now()->endOfWeek();

            $weekRange = $this->authMainObj->createDateRangeArray($thisWeekStart, $thisWeekEnd);

            $weekCount = [];
            foreach($weekRange as $r) {
                $date = DateTime::createFromFormat('d/m/Y', $r);
                $day = $date->format('d');
                $month = $date->format('m');
                $weekCount []= File::whereMonth('created_at',$month)->whereDay('created_at',$day)->where('user_id', $user->id)->count();
            }

            $invoices = Credit::orderBy('created_at', 'desc')->where('credits','!=', 0)->where('user_id', $user->id)->get();
            
            return view('home', [
                'user' => $user, 
                'users' => $users, 
                'invoices' => $invoices, 
                'todaysFilesCount' => $todaysFilesCount, 
                'yesterdaysFilesCount'  => $yesterdaysFilesCount, 
                'previousYearsFilesCount'  => $previousYearsFilesCount, 
                'previousWeeksFilesCount'  => $previousWeeksFilesCount,
                'previousMonthsFilesCount'  => $previousMonthsFilesCount,
                'thisWeeksFilesCount'  => $thisWeeksFilesCount,
                'thisMonthsFilesCount'  => $thisMonthsFilesCount,
                'twoYearsAgoFilesCount'  => $twoYearsAgoFilesCount,
                'thisWeeksCreditsCount'  => $thisWeeksCreditsCount,
                'thisYearsCreditsCount'  => $thisYearsCreditsCount,
                'thisYearsFilesCount'  => $thisYearsFilesCount,
                'twoFiles'  => $twoFiles,
                'countYear'  => json_encode($countYear,JSON_NUMERIC_CHECK),
                'datesMonth'  => json_encode($datesMonth,JSON_NUMERIC_CHECK),
                'datesMonthCount'  => json_encode($datesMonthCount,JSON_NUMERIC_CHECK),
                'weekRange'  => json_encode($weekRange,JSON_NUMERIC_CHECK),
                'weekCount'  => json_encode($weekCount,JSON_NUMERIC_CHECK),
            ]);
        }
  
        return redirect("login")->withSuccess('Opps! You do not have access');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}