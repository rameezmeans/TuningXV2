<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use ECUApp\SharedCode\Controllers\AuthMainController;
use ECUApp\SharedCode\Models\Credit;
use ECUApp\SharedCode\Models\DTCLookup;
use ECUApp\SharedCode\Models\BoschNumber;
use ECUApp\SharedCode\Models\File;
use ECUApp\SharedCode\Models\User;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller {

    private $frontendID;
    private $authMainObj;
    
    public function __construct(){
        $this->middleware('auth');
        $this->frontendID = 2;
        $this->authMainObj = new AuthMainController;
    }

    public function getBosch(HttpRequest $request) {

        $manufacturerNumber = $request->manufacturer_number;
        $record = BoschNumber::where('manufacturer_number', $manufacturerNumber)->first();

        if($record == NULL){
            $record = "No Record Found";

        }

        return view('bosch', 
            ['record' => $record]
        );
    }

    public function getDTCDesc(HttpRequest $request) {

        $dtcCode = $request->dtc_lookup_code;
        $record = DTCLookup::where('code', $dtcCode)->first();

        if($record == NULL){
            $record = "No Record Found";

        }

        return view('dtc_lookup', [
            'record' => $record]);
    }

    public function bosch() {

        $user = Auth::user();
        $boschRecords = BoschNumber::all();
        
        return view('bosch', [
            'boschRecords' => $boschRecords, 'user' => $user]);
    }

    public function dtcLookup() {

        $user = Auth::user();
        $dtcLookupRecords = DTCLookup::all();
        return view('dtc_lookup', [
            'dtcLookupRecords' => $dtcLookupRecords, 'user' => $user]);
    }

    public function loginAs($id) {
        Auth::loginUsingId($id, true);
        return redirect()->route('home', ['success' => 'Login successful!']);
    }

    public function index() {

        $user = Auth::user();
        $users = User::whereNull('subdealer_group_id')->where('role_id', 4)->where('front_end_id', $this->frontendID)->get();
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

    public function clearFeed(Request $request) {
        Session::forget('feed');
    }

}