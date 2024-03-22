<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use ECUApp\SharedCode\Controllers\FilesMainController;
use ECUApp\SharedCode\Controllers\PaymentsMainController;
use ECUApp\SharedCode\Models\Comment;
use ECUApp\SharedCode\Models\Credit;
use ECUApp\SharedCode\Models\EmailReminder;
use ECUApp\SharedCode\Models\EngineerFileNote;
use ECUApp\SharedCode\Models\File;
use ECUApp\SharedCode\Models\FileFeedback;
use ECUApp\SharedCode\Models\FileService;
use ECUApp\SharedCode\Models\FileUrl;
use ECUApp\SharedCode\Models\Log;
use ECUApp\SharedCode\Models\Price;
use ECUApp\SharedCode\Models\Service;
use ECUApp\SharedCode\Models\StagesOptionsCredit;
use ECUApp\SharedCode\Models\TemporaryFile;
use ECUApp\SharedCode\Models\Tool;
use ECUApp\SharedCode\Models\User;
use ECUApp\SharedCode\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $filesMainObj;
    private $paymentMainObj;

    public function __construct(){

        $this->middleware('auth', [ 'except' => [ 'feedbackLink' ] ]);
        $this->filesMainObj = new FilesMainController();
        $this->paymentMainObj = new PaymentsMainController();

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function fileURL(Request $request)
    {

        $validated = $request->validate([
            'file_url' => 'required'
        ]);

        $file = File::findOrFail($request->file_id);
        $message = new FileUrl();
        $message->file_url = $request->file_url;
       
        if($request->file('file_url_attachment')){
            $attachment = $request->file('file_url_attachment');
            $fileName = $attachment->getClientOriginalName();
            $attachment->move(public_path($file->file_path),$fileName);
            $message->file_url_attachment = $fileName;
        }

        $message->file_id = $request->file_id;
        $message->save();
        return redirect()->back()->with('success', 'Personal Note successfully Added!');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addCustomerNote(Request $request)
    {
        $file = File::findOrFail($request->id);
        $file->name = $request->name;
        $file->phone = $request->phone;
        $file->email = $request->email;
        $file->customer_internal_notes = $request->customer_internal_notes;
        $file->save();
        return redirect()->back()->with('success', 'File successfully Edited!');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fileEngineersNotes(Request $request)
    {

        $validated = $request->validate([
            'egnineers_internal_notes' => 'required|max:1024'
        ]);

        $file = File::findOrFail($request->file_id);

        $noteItSelf = $request->egnineers_internal_notes;

        $reply = new EngineerFileNote();
        $reply->egnineers_internal_notes = $request->egnineers_internal_notes;

        if($request->file('engineers_attachement')){
            $attachment = $request->file('engineers_attachement');
            $fileName = $attachment->getClientOriginalName();
            $attachment->move(public_path($file->file_path),$fileName);
            $reply->engineers_attachement = $fileName;
        }

        $reply->file_id = $request->file_id;
        $reply->request_file_id = $request->request_file_id;
        $reply->sent_by = 'engineer';
        $reply->save();

        $file->support_status = "open";
        $file->save();

        return redirect()->back()->with('success', 'Engineer note successfully Added!');
    }

    public function rejectOffer(Request $request) {

        $fileID = $request->file_id;
        $file = File::findOrFail($fileID);
        $user = Auth::user();

        $this->filesMainObj->rejectOffer($file, $user);

        // Alert: reject email will go here. 
    }   

    public function payCreditsOffer($id) {

        $file = File::findOrfail($id);
 
        $proposedCredits = $this->filesMainObj->getOfferedCredits($file);
        $differece = $proposedCredits - $file->credits;
        
        $price = Price::where('label', 'credit_price')->first();
 
        $user = User::findOrFail(Auth::user()->id);
 
        $factor = 0;
        $tax = 0;
 
        if($user->group){
            if($user->group->tax > 0){
                $tax = (float) $user->group->tax;
            }

            if($user->group->raise > 0){
                $factor = (float)  ($user->group->raise / 100) * $price->value;
            }

            if($user->group->discount > 0){
                $factor =  -1* (float) ($user->group->discount / 100) * $price->value;
            }
         }
 
        return view( 'files.pay_credits_offer', [ 
         'file_id' => $file->id, 
         'file' => $file, 
         'credits' => $differece, 
         'price' => $price,
         'factor' => $factor,
         'tax' => $tax,
         'group' =>  $user->group,
         'user' =>  $user
         ] );
 
     }
 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fileFeedback(Request $request)
    {
        FileFeedback::where('request_file_id','=', $request->request_file_id)->delete();

        $reminder = EmailReminder::where('file_id', $request->file_id)->where('request_file_id', $request->request_file_id)->where('user_id', Auth::user()->id)->first();
       
        if($reminder){
            $reminder->delete();
        }

        $requestFile = new FileFeedback();
        $requestFile->file_id = $request->file_id;
        $requestFile->request_file_id = $request->request_file_id;
        $requestFile->type = $request->type;
        $requestFile->save();

        return response()->json($requestFile);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createNewrequest(Request $request)
    {
        $rules = $this->filesMainObj->getNewReqValidationRules();
        $request->validate($rules);
        $data = $request->all();
        $file = $request->file('request_file');

        return $this->filesMainObj->createNewRequest($data, $file);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function EditMilage(Request $request)
    {
        
        $file = File::findOrFail($request->id);
        $file->vin_number = $request->vin_number;
        $file->license_plate = $request->license_plate;
        $file->first_registration = $request->first_registration;
        $file->kilometrage = $request->kilometrage;
        $file->vehicle_internal_notes = $request->vehicle_internal_notes;
        $file->save();
        return redirect()->back()->with('success', 'File successfully Edited!');

    }

    public function download($id,$fileName) {

        $file = File::findOrFail($id); 
        $filePath = public_path($file->file_path).$fileName;
        return response()->download($filePath);

    // if($engFileID){
    //     $engFile = RequestFile::findOrFail($engFileID);
    // }
        
    //     $file = File::findOrFail($id); 

    //     $kess3Label = Tool::where('label', 'Kess_V3')->where('type', 'slave')->first();
        
    //     if($file->tool_type == 'slave' && $file->tool_id == $kess3Label->id){

    //         if($file->original_file_id == NULL){

    //         $engFile = RequestFile::where('request_file', $fileName)->where('file_id', $file->id)->first();

    //         if($engFile && $engFile->uploaded_successfully){

    //         $notProcessedAlientechFile = AlientechFile::where('file_id', $file->id)
    //         ->where('purpose', 'decoded')
    //         ->where('type', 'download')
    //         ->where('processed', 0)
    //         ->first();

    //         if($notProcessedAlientechFile){
               
    //             $fileNameEncoded = $this->alientechObj->downloadEncodedFile($id, $notProcessedAlientechFile, $fileName);
    //             $notProcessedAlientechFile->processed = 1;
    //             $notProcessedAlientechFile->save();
                
    //             $file_path = public_path($file->file_path).$fileNameEncoded;
    //             return response()->download($file_path);
    //         }
    //         else{
    //             $encodedFileNameToBe = $fileName.'_encoded_api';
    //             $processedFile = ProcessedFile::where('name', $encodedFileNameToBe)->first();

    //             if($processedFile){

    //             // if($processedFile->extension != ''){
    //             //     $finalFileName = $processedFile->name.'.'.$processedFile->extension;
    //             // }
    //             // else{
    //                 $finalFileName = $processedFile->name;
    //             // }

    //         }else{
    //             $finalFileName = $fileName;
    //         }

    //             $file_path = public_path($file->file_path).$finalFileName;
    //             return response()->download($file_path);

    //         }
    //     }
    //     else{
    //         $file_path = public_path($file->file_path).$fileName;
    //         return response()->download($file_path);
    //     }
    // }

    // else{
    //     $file_path = public_path($file->file_path).$fileName;
    //     return response()->download($file_path);
    // }

    //     }
    //     else{
    //         $file_path = public_path($file->file_path).$fileName;
    //         return response()->download($file_path);
    //     }

    }

    public function autoDownload(Request $request){

        $file = File::findOrFail($request->id);
        $user = User::findOrFail(Auth::user()->id);

        return view('files.auto_download', [ 'user' => $user, 'file' => $file ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showFile($id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $kess3Label = Tool::where('label', 'Kess_V3')->where('type', 'slave')->first();

        $file = $this->filesMainObj->getFile($id, $user);
        $vehicle = $this->filesMainObj->getVehicle($file);
        
        $slaveTools =  $user->tools_slave;
        $masterTools =  $user->tools_master;

        $comments = $this->filesMainObj->getCommentsOnFileShowing($file);

        $selectedOptions = $this->filesMainObj->getSelectedOptions($file);

        $showComments = $this->filesMainObj->getShowComments($selectedOptions, $comments);
        
        return view('files.show_file', ['user' => $user, 'showComments' => $showComments, 'comments' => $comments,'kess3Label' => $kess3Label,  'file' => $file, 'masterTools' => $masterTools,  'slaveTools' => $slaveTools, 'vehicle' => $vehicle ]);
    }

    public function addOfferToFile(Request $request) {
        
            $fileID = $request->file_id;
            $creditsToBuy = $request->credits;
    
            $user = User::findOrFail(Auth::user()->id);
    
            $file = $this->filesMainObj->acceptOfferFinalise($user, $fileID, $creditsToBuy);

            if($file->original_file_id){
                return redirect(route('file', $file->original_file_id))->with(['success' => 'Engineer offer accepted!']);
            }
    
            else{
                return redirect(route('file', $fileID))->with(['success' => 'Engineer offer accepted!']);
            }
    
            // Alert: email will be added here. 
    }

    public function saveFile(Request $request) {

        $fileID = $request->file_id;
        $credits = $request->credits;
        
        $user = User::findOrFail(Auth::user()->id);

        $file = $this->filesMainObj->saveFile($user, $fileID, $credits);

        return redirect()->route('auto-download',['id' => $file->id]);
        
    }

    public function postStages(Request $request) {

        $stage = Service::FindOrFail($request->stage);
        $stageName = $stage->name;

        $rules = $this->filesMainObj->getStep3ValidationStage($stageName);

        $request->validate($rules);
        
        $fileID = $request->file_id;
        $DTCComments = $request->dtc_off_comments;
        $vmaxComments = $request->vmax_off_comments;

        $file = $this->filesMainObj->saveStagesInfo($fileID, $DTCComments, $vmaxComments);
        
        FileService::where('service_id', $stage->id)->where('temporary_file_id', $file->id)->delete();
        
        $servieCredits = 0;

        $servieCredits += $this->filesMainObj->saveFileStages($file, $stage);

        $options = $request->options;

        $servieCredits += $this->filesMainObj->saveFileOptions($file, $stage, $options);

        $price = $this->paymentMainObj->getPrice();

        $user = User::findOrFail(Auth::user()->id);

        return view( 'files.pay_credits', [ 
        'file' => $file, 
        'credits' => $servieCredits, 
        'price' => $price,
        'factor' => 0,
        'tax' => 0,
        'group' =>  $user->group,
        'user' =>  $user
        ] );

    }

    public function termsAndConditions() {

        $user = User::findOrFail(Auth::user()->id);

        return view('files.terms_and_conditions', ['user' => $user]);

    }

    public function norefundPolicy() {

        $user = User::findOrFail(Auth::user()->id);

        return view('files.norefund_policy', ['user' => $user]);

    }

    public function getOptionsForStage(Request $request) {

        $stageID = $request->stage_id;
        $optionsArray = $this->filesMainObj->getStagesAndOptions($stageID);

        return json_encode($optionsArray);

    }

    public function getUploadComments(Request $request){
        
        $tempFileID = $request->file_id;
        $serviceID = $request->service_id;

        $comment = $this->filesMainObj->getStagePageComments($tempFileID, $serviceID);

        return response()->json(['comment'=> $comment]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function step1(){

        $user = User::findOrFail(Auth::user()->id);

        $masterTools = $this->filesMainObj->getMasterTools($user);
        $slaveTools = $this->filesMainObj->getSlaveTools($user);

        $brands = $this->filesMainObj->getBrands();

        return view('files.step1', ['user' => $user, 'brands' => $brands,'masterTools' => $masterTools, 'slaveTools' => $slaveTools]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getModels(Request $request)
    {
        $brand = $request->brand;

        $models = $this->filesMainObj->getModels($brand);
        
        return response()->json( [ 'models' => $models ] );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getVersions(Request $request)
    {

        $model = $request->model;
        $brand = $request->brand;

        $versions = $this->filesMainObj->getVersians($brand, $model);

        return response()->json( [ 'versions' => $versions ] );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEngines(Request $request)
    {
        $model = $request->model;
        $brand = $request->brand;
        $version = $request->version;

        $engines = $this->filesMainObj->getEngines($brand, $model, $version);

        return response()->json( [ 'engines' => $engines ] );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getECUs(Request $request)
    {
        $model = $request->model;
        $brand = $request->brand;
        $version = $request->version;
        $engine = $request->engine;
       
        $ecusArray = $this->filesMainObj->getECUs($brand, $model, $version, $engine);
        return response()->json( [ 'ecus' => $ecusArray ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function step3(Request $request) {

        $user = User::findOrFail(Auth::user()->id);

        $frontendID = 2;

        $file = TemporaryFile::findOrFail($request->file_id);
        $vehicle = $file->vehicle();
        $vehicleType = $vehicle->type;

        $stages = $this->filesMainObj->getStagesForStep3($frontendID, $vehicleType);
        $options = $this->filesMainObj->getOptionsForStep3($frontendID, $vehicleType);

        $firstStage = $stages[0];
        
        return view( 'files.set_stages', ['user' => $user, 'firstStage' => $firstStage, 'vehicleType' => $vehicleType,'file' => $file, 'stages' => $stages, 'options' => $options] );

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function step2(Request $request) {

        $rules = $this->filesMainObj->getStep1ValidationTempfile();
        $file = $request->validate($rules);

        $data = $request->all();
        
        return $this->filesMainObj->addStep1InforIntoTempFile($data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createTempFile(Request $request) {

        $user = User::findOrFail(Auth::user()->id);
        $frontendID = 2;
        $file = $request->file('file');

        $toolType = $request->tool_type_for_dropzone;
        $toolID = $request->tool_for_dropzone;

        $tempFile = $this->filesMainObj->createTemporaryFile($user, $file, $toolType, $toolID, $frontendID);

        return response()->json(['tempFileID' => $tempFile->id]);


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fileHistory()
    {
        $frontendID = 2;
        $user = User::findOrFail(Auth::user()->id);
        $files = $this->filesMainObj->getFiles($user, $frontendID);

        return view('files.file_history', [ 'files' => $files, 'user' => $user ]);
    }
}