<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use ECUApp\SharedCode\Controllers\AlientechMainController;
use ECUApp\SharedCode\Controllers\FilesMainController;
use ECUApp\SharedCode\Controllers\NotificationsMainController;
use ECUApp\SharedCode\Controllers\PaymentsMainController;
use ECUApp\SharedCode\Controllers\MagicsportsMainController;
use ECUApp\SharedCode\Models\AlientechFile;
use ECUApp\SharedCode\Models\Comment;
use ECUApp\SharedCode\Models\Credit;
use ECUApp\SharedCode\Models\EmailReminder;
use ECUApp\SharedCode\Models\EngineerFileNote;
use ECUApp\SharedCode\Models\File;
use ECUApp\SharedCode\Models\FileFeedback;
use ECUApp\SharedCode\Models\FileInternalEvent;
use ECUApp\SharedCode\Models\FileService;
use ECUApp\SharedCode\Models\FileUrl;
use ECUApp\SharedCode\Models\Log;
use ECUApp\SharedCode\Models\Price;
use ECUApp\SharedCode\Models\ProcessedFile;
use ECUApp\SharedCode\Models\RequestFile;
use ECUApp\SharedCode\Models\Service;
use ECUApp\SharedCode\Models\StagesOptionsCredit;
use ECUApp\SharedCode\Models\TemporaryFile;
use ECUApp\SharedCode\Models\Tool;
use ECUApp\SharedCode\Models\User;
use ECUApp\SharedCode\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ECUApp\SharedCode\Models\MagicEncryptedFile;

use Pusher\Pusher;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    private $filesMainObj;
    private $paymentMainObj;
    private $notificationsMainObj;
    private $frontendID;
    private $alientechMainObj;
    private $magicMainObj;

    public function __construct(){

        $this->frontendID = 2;

        $this->middleware('auth', [ 'except' => [ 'feedbackLink' ] ]);
        $this->filesMainObj = new FilesMainController();
        $this->paymentMainObj = new PaymentsMainController();
        $this->notificationsMainObj = new NotificationsMainController();
        $this->alientechMainObj = new AlientechMainController();
        $this->magicMainObj = new MagicsportsMainController();
    }

    public function authPusher(Request $request){

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),
                'host' => env('PUSHER_HOST') ?: 'api-'.env('PUSHER_APP_CLUSTER', 'mt1').'.pusher.com',
                'port' => env('PUSHER_PORT', 443),
                'scheme' => env('PUSHER_SCHEME', 'https'),
                'encrypted' => true,
                'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
            ],
        );

        $chatUser = User::findOrFail(env('LIVE_CHAT_ID'));

        // Auth data
        $authData = json_encode([
            'user_id' => $chatUser->id,
            'user_info' => [
                'name' => $chatUser->name
            ]
        ]);
        
        return $pusher->socket_auth(
            $request->channel_name,
            $request->socket_id,
            $authData
        );
            
        // if not authorized
        return response()->json(['message'=>'Unauthorized'], 401);
        
    }

    public function getDownloadButton(Request $request){

        $file = File::findOrFail($request->file_id);

        if($file->no_longer_auto == 0){

            $downloadButton = '<a class="btn" style="background: #f02429 !important;" href="'.route("download", [$file->id,$file->engineer_file->request_file]).'">
            <i class="fa fa-download"></i> Download
            </a>';
        }
        else{
            
            $downloadButton = "<p>Your file will be processed by our engineers, you will hear from them very soon.</p>";
        }
        
        // $downloadButton = 
        //         '
        //         <p>Success, your file is ready for download.</p>
        //         <button style="background: #f02429 !important;" class="btn btn-download" 
        //         data-make="'.$file->brand.'" 
        //         data-engine="'.$file->engine.'" 
        //         data-ecu="'.$file->ecu.'" 
        //         data-model="'.$file->model.'" 
        //         data-generation="'.$file->version.'" 
        //         data-file_id="'.$file->id.'" 
        //         data-path="'.route("download", [$file->id, $file->engineer_file->request_file]).'"
        //         >
                    
        //             <i class="fa fa-download"></i>
        //             Download
        //         </button>';

        return  response()->json( ['download_button' => $downloadButton] );
    }

    public function changeCheckingStatus(Request $request){

        $file = File::findOrFail($request->file_id);
        if($file->checking_status == 'unchecked'){
            $file->checking_status = 'fail';
            $file->save();
            return  response()->json( ['msg' => 'status set to fail', 'fail' => 1, 'file_id' => $file->id] );
        }
        if($file->checking_status == 'completed'){
            return response()->json( ['msg' => 'status was completed', 'fail' => 2, 'file_id' => $file->id] );
        }
        return response()->json( ['msg' => 'status not set to fail', 'fail' => 0, 'file_id' => $file->id] );
    }

    public function acmFileUpload(Request $request){

        $file = File::findOrFail($request->file_id);

        $fileUploaded = $request->file('acm_file');
        $fileName = $fileUploaded->getClientOriginalName();
        $fileName = $this->filesMainObj->getFilename($fileName);
        $fileUploaded->move(public_path($file->file_path),$fileName);

       
        $file->acm_file = $fileName;
        $file->save();

        return redirect()->back()->with('success', 'ACM file successfully Added!');

    }

    public function getComments(Request $request){

        $file = File::findOrFail($request->file_id);

        if($request->ecu){

            // $commentObj = Comment::where('engine', $request->engine);

            $commentObj = Comment::where('comment_type', 'download')->whereNull('subdealer_group_id');

            // $commentObj = Comment::where('engine', $request->engine);
            // $commentObj = $commentObj->where('comment_type', 'download');

            if($request->make){
                $commentObj->where('make',$request->make);
            }

            // if($request->model){
            //     $commentObj->where('model', $request->model);
            // }

            if($request->ecu){
                $commentObj->where('ecu',$request->ecu);
            }

            // if($request->generation){
            //     $commentObj->where('generation', $request->generation);
            // }

            $comments = $commentObj->get()->toArray();
        }
        else{

            $comments = [];
        }

        // if($file->show_comments == 0){
        //     $comments = [];
        // }
        
        $optionsArray = [];

        foreach($file->options_services as $option){
            $optionsArray []= Service::findOrFail($option->service_id)->id;
        }

        $optionComment = "";

        if(sizeof($comments) != 0){

            $optionComment .= '<ul class="bullets">';

            foreach($comments as $comment){
                if(in_array($comment['service_id'],$optionsArray)){
                    $optionComment  .= '<li class="comments">'.__($comment['comments']).'</li>';
                }
            }

            $optionComment .= '</ul>';
        }

        return response()->json(['comments'=> $optionComment]);

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

    public function fileEventsNotes(Request $request)
    {

        $file = File::findOrFail($request->file_id);

        $validated = $request->validate([
            'events_internal_notes' => 'required|max:1024'
        ]);

        $reply = new FileInternalEvent();
        $reply->events_internal_notes = $request->events_internal_notes;
       
        if($request->file('events_attachement')){
            $attachment = $request->file('events_attachement');
            $fileName = $attachment->getClientOriginalName();
            $attachment->move( public_path($file->file_path) ,$fileName);
            $reply->events_attachement = $fileName;
        }

        $reply->file_id = $request->file_id;
        $reply->request_file_id = $request->request_file_id;
        $reply->save();
        return redirect()->back()->with('success', 'Events note successfully Added!');
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

        if($file->original_file_id != NULL){
            $ofile = File::findOrFail($file->original_file_id);
            $ofile->support_status = "open";
            $ofile->save();
        }

        $engPermissions = array(
            0 => 'msg_cus_eng_email',
            1 => 'msg_cus_eng_sms',
            2 => 'msg_cus_eng_whatsapp'
        );

        $uploader = User::findOrFail($file->user_id);
        $engineer = User::FindOrFail($file->assigned_to);
        $subject = "TuningX: Client support message!";
        $this->notificationsMainObj->sendNotification($engineer, $file, $uploader, $this->frontendID, $subject, 'mess-to-eng', 'message_to_engineer', $engPermissions);

        $adminPermissions = array(
            0 => 'msg_cus_admin_email',
            1 => 'msg_cus_admin_sms',
            2 => 'msg_cus_admin_whatsapp'
        );

        $uploader = User::findOrFail($file->user_id);
        $admin = get_admin();
        $subject = "TuningX: Client support message!";
        $this->notificationsMainObj->sendNotification($admin, $file, $uploader, $this->frontendID, $subject, 'mess-to-eng', 'message_to_engineer', $adminPermissions);

        return redirect()->back()->with('success', 'Engineer note successfully Added!');
    }

    public function acceptOffer(Request $request) {

        $fileID = $request->file_id;
        $file = File::findOrFail($fileID);
        $user = Auth::user();

        $this->filesMainObj->acceptOfferWithoutPayingCredits($file, $user);

        $customerPermission = array(
            0 => 'status_change_cus_email',
            1 => 'status_change_cus_sms',
            2 => 'status_change_cus_whatsapp'
        );

        $customer = Auth::user();
        $subject = "ECUTech: File Status Changed!";
        $this->notificationsMainObj->sendNotification($customer, $file, $customer, $this->frontendID, $subject, 'sta-cha', 'status_change', $customerPermission);

        $adminPermission = array(
            0 => 'status_change_admin_email',
            1 => 'status_change_cus_sms',
            2 => 'status_change_cus_whatsapp'
        );

        $admin = get_admin();
        $customer = Auth::user();
        $subject = "ECUTech: File Status Changed!";
        $this->notificationsMainObj->sendNotification($admin, $file, $customer, $this->frontendID, $subject, 'sta-cha', 'status_change', $adminPermission);

    }

    public function rejectOffer(Request $request) {

        $fileID = $request->file_id;
        $file = File::findOrFail($fileID);
        $user = Auth::user();

        $this->filesMainObj->rejectOffer($file, $user);

        $customerPermission = array(
            0 => 'status_change_cus_email',
            1 => 'status_change_cus_sms',
            2 => 'status_change_cus_whatsapp'
        );

        $customer = Auth::user();
        $subject = "TuningX: File Status Changed!";
        $this->notificationsMainObj->sendNotification($customer, $file, $customer, $this->frontendID, $subject, 'sta-cha', 'status_change', $customerPermission);

        $adminPermission = array(
            0 => 'status_change_admin_email',
            1 => 'status_change_cus_sms',
            2 => 'status_change_cus_whatsapp'
        );

        $admin = get_admin();
        $customer = Auth::user();
        $subject = "TuningX: File Status Changed!";
        $this->notificationsMainObj->sendNotification($admin, $file, $customer, $this->frontendID, $subject, 'sta-cha', 'status_change', $adminPermission);

    }   

    public function payCreditsOffer($id) {

        $file = File::findOrfail($id);
 
        $proposedCredits = $this->filesMainObj->getOfferedCredits($file);
        $differece = $proposedCredits - $file->credits;
        
        $price = Price::where('label', 'credit_price')->first();
 
        $user = Auth::user();
 
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

    // public function download($id,$fileName) {

    //     $file = File::findOrFail($id); 
    //     $filePath = public_path($file->file_path).$fileName;
    //     return response()->download($filePath);

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

    // }

    public function download($id,$fileName) {

        // if($engFileID){
        //     $engFile = RequestFile::findOrFail($engFileID);
        // }
        
        $file = File::findOrFail($id); 

        $kess3Label = Tool::where('label', 'Kess_V3')->where('type', 'slave')->first();
        $flexLabel = Tool::where('label', 'Flex')->where('type', 'slave')->first();
        
        if($file->tool_type == 'slave' && $file->tool_id == $kess3Label->id){

            // if($file->original_file_id == NULL){

            $engFile = RequestFile::where('request_file', $fileName)->where('file_id', $file->id)->first();

            if($engFile && $engFile->uploaded_successfully){

            $notProcessedAlientechFile = AlientechFile::where('file_id', $file->id)
            ->where('purpose', 'decoded')
            ->where('type', 'download')
            ->where('processed', 0)
            ->first();

            if($notProcessedAlientechFile){
               
                $fileNameEncoded = $this->alientechMainObj->downloadEncodedFile($id, $notProcessedAlientechFile, $fileName);
                $notProcessedAlientechFile->processed = 1;
                $notProcessedAlientechFile->save();
                
                $file_path = public_path($file->file_path).$fileNameEncoded;
                return response()->download($file_path);
            }
            else{
                $encodedFileNameToBe = $fileName.'_encoded_api';
                $processedFile = ProcessedFile::where('name', $encodedFileNameToBe)->where('type', 'encoded')->first();

                if($processedFile){

                // if($processedFile->extension != ''){
                //     $finalFileName = $processedFile->name.'.'.$processedFile->extension;
                // }
                // else{
                    $finalFileName = $processedFile->name;
                // }

                $file_path = public_path($file->file_path).$finalFileName;
                return response()->download($file_path);

                }
                else{
                    abort(505);
                }

                // }else{
                //     $finalFileName = $fileName;
                // }

                

            }
        }
        else{
            $file_path = public_path($file->file_path).$fileName;
            return response()->download($file_path);
        }
    // }

    // else{
    //     $file_path = public_path($file->file_path).$fileName;
    //     return response()->download($file_path);
    // }

    
    }

    else if($file->tool_type == 'slave' && $file->tool_id == $flexLabel->id){
            
            $magicFile = MagicEncryptedFile::where('file_id', $file->id)
            ->where('name', $fileName.'_magic_encrypted.mmf')
            ->where('downloadable', 1)
            ->first();

            if($magicFile){
    
                $file_path = public_path($file->file_path).$magicFile->name;
                return response()->download($file_path);
            }
            else{
                $file_path = public_path($file->file_path).$fileName; // quick fix. need to work a bit more.
                return response()->download($file_path);
            }
        }

        else{
            $file_path = public_path($file->file_path).$fileName;
            return response()->download($file_path);
        }
    }

    public function autoDownload(Request $request){

        $file = File::findOrFail($request->id);
        $user = Auth::user();

        return view('files.auto_download', [ 'user' => $user, 'file' => $file ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showFile($id)
    {
        $user = Auth::user();
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

        $user = Auth::user();

        $file = $this->filesMainObj->acceptOfferFinalise($user, $fileID, $creditsToBuy, $this->frontendID);

        $customerPermission = array(
            0 => 'status_change_cus_email',
            1 => 'status_change_cus_sms',
            2 => 'status_change_cus_whatsapp',
        );

        $customer = Auth::user();
        $subject = "TuningX: File Status Changed!";
        $this->notificationsMainObj->sendNotification($customer, $file, $customer, $this->frontendID, $subject, 'sta-cha', 'status_change', $customerPermission);

        $adminPermission = array(
            0 => 'status_change_admin_email',
            1 => 'status_change_cus_sms',
            2 => 'status_change_cus_whatsapp',
        );

        $admin = get_admin();
        $customer = Auth::user();
        $subject = "TuningX: File Status Changed!";
        $this->notificationsMainObj->sendNotification($admin, $file, $customer, $this->frontendID, $subject, 'sta-cha', 'status_change', $adminPermission);

        if($file->original_file_id){
            return redirect(route('file', $file->original_file_id))->with(['success' => 'Engineer offer accepted!']);
        }

        else{
            return redirect(route('file', $fileID))->with(['success' => 'Engineer offer accepted!']);
        }
    
    }

    public function saveFile(Request $request) {

        $tempFileID = $request->file_id;
        $credits = $request->credits;
        
        $user = Auth::user();
        $file = $this->filesMainObj->saveFile($user, $tempFileID, $credits);
        
        $this->filesMainObj->notifications($file);
        
        return redirect()->route('auto-download',['id' => $file->id]);
        
    }

    public function postStages(Request $request) {

        // dd($request->all());

        $stage = Service::FindOrFail($request->stage);
        $stageName = $stage->name;

        $rules = $this->filesMainObj->getStep3ValidationStage($stageName);

        $request->validate($rules);
        
        $fileID = $request->file_id;
        // $DTCComments = $request->dtc_off_comments;
        // $vmaxComments = $request->vmax_off_comments;

        $optionComments = $request->option_comments;

        $file = $this->filesMainObj->saveStagesInfo($fileID, $optionComments);
        
        FileService::where('service_id', $stage->id)->where('temporary_file_id', $file->id)->delete();
        
        $servieCredits = 0;

        $servieCredits += $this->filesMainObj->saveFileStages($file, $stage, $this->frontendID);

        $options = $request->options;

        $servieCredits += $this->filesMainObj->saveFileOptions($file, $stage, $options, $this->frontendID);

        $price = $this->paymentMainObj->getPrice();

        $user = Auth::user();

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

        $user = Auth::user();

        return view('files.terms_and_conditions', ['user' => $user]);

    }

    public function norefundPolicy() {

        $user = Auth::user();

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

        $user = Auth::user();

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

        $user = Auth::user();

        $file = TemporaryFile::findOrFail($request->file_id);
        $vehicle = $file->vehicle();
        
        if($vehicle != NULL){
            $vehicleType = $vehicle->type;
        }
        else{
            return redirect()->route('upload')->with('success', 'There is no Vehilce with Specification you entered.');
        }

        $stages = $this->filesMainObj->getStagesForStep3($this->frontendID, $vehicleType);
        $options = $this->filesMainObj->getOptionsForStep3($this->frontendID, $vehicleType);

        $firstStage = $stages[0];
        
        return view( 'files.set_stages', ['user' => $user, 'firstStage' => $firstStage, 'vehicleType' => $vehicleType,'file' => $file, 'stages' => $stages, 'options' => $options] );

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function step2(Request $request) {

        $fileUploaded = $request->file('acm_file');
        $rules = $this->filesMainObj->getStep1ValidationTempfile();
        $file = $request->validate($rules);

        $data = $request->all();
        
        return $this->filesMainObj->addStep1InforIntoTempFile($data, $fileUploaded);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createTempFile(Request $request) {

        $user = Auth::user();
        $file = $request->file('file');

        $toolType = $request->tool_type_for_dropzone;
        $toolID = $request->tool_for_dropzone;

        $tempFile = $this->filesMainObj->createTemporaryFile($user, $file, $toolType, $toolID, $this->frontendID);

        $kess3Label = Tool::where('label', 'Kess_V3')->where('type', 'slave')->first();

        if($toolType == 'slave' && $tempFile->tool_id == $kess3Label->id){

            $path = $this->filesMainObj->getPath($file);
            $this->alientechMainObj->saveGUIDandSlotIDToDownloadLater($path , $tempFile->id);
            
        }

        $flexLabel = Tool::where('label', 'Flex')->where('type', 'slave')->first();

        if($toolType == 'slave' && $tempFile->tool_id == $flexLabel->id){
            
            $path = $this->filesMainObj->getPath($file);
            $this->magicMainObj->magicDecrypt($path , $tempFile->id);
            
        }

        return response()->json(['tempFileID' => $tempFile->id]);


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fileHistory()
    {
        $user = Auth::user();
        $files = $this->filesMainObj->getFiles($user, $this->frontendID);

        return view('files.file_history', [ 'files' => $files, 'user' => $user ]);
    }
}
