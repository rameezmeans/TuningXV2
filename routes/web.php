<?php

use App\Http\Controllers\Auth\AuthController;
use ECUApp\SharedCode\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/test', function () {

    // abort(404);

    \Mail::to('xrkalix@gmail.com')->send(new \App\Mail\AllMails(['html' => "testing email", 'subject' => 'test email']));
    dd('email sent');

    // try {
    //     $accountSid = env("TWILIO_SID");
    //     $authToken = env("TWILIO_AUTH_TOKEN");
    //     $twilioNumber = env("TWILIO_NUMBER"); 

    //     // dd($authToken);

    //     $client = new Client($accountSid, $authToken);

    //     // dd($client);

    //     $message = $client->messages
    //         ->create("+923218612198", 
    //             ["body" => 'test message', "from" => "Tuning-X"]
    //     );

    //     dd($message);

    //     \Log::info('message sent to:'.'+923218612198');

    // } catch (\Exception $e) {
    //     dd($e->getMessage());
    // }

});

Auth::routes();

// Route::get('login', [AuthController::class, 'index'])->name('login');
// Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
// Route::get('register', [AuthController::class, 'registration'])->name('register');
// Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login_as/{id}', [App\Http\Controllers\HomeController::class, 'loginAs'])->name('loginAs');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/clear_feed', [App\Http\Controllers\HomeController::class, 'clearFeed'])->name('clear-feed');
Route::post('/pusher/auth', [MessagesController::class, 'pusherAuth'])->name('pusher.auth');

Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account');
Route::post('/edit_account', [App\Http\Controllers\AccountController::class, 'editAccount'])->name('edit-account');
Route::post('/change-password', [App\Http\Controllers\AccountController::class, 'changePassword'])->name('change-password');
Route::post('/update_tools', [App\Http\Controllers\AccountController::class, 'updateTools'])->name('update-tools');
Route::post('get_tool_icons', [App\Http\Controllers\AccountController::class, 'getToolsIcons'])->name('get-tool-icons');

Route::post('delete_account_email', [App\Http\Controllers\AccountController::class, 'deleleAccountEmail'])->name('delete-account-email');
Route::get('delete_account/{id}', [App\Http\Controllers\AccountController::class, 'deleleAccount'])->name('delete-account');

Route::get('pdfview',array('as'=>'pdfview','uses'=>'App\Http\Controllers\InvoicesController@makePDF'));

Route::get('/upload', [App\Http\Controllers\FileController::class, 'step1'])->name('upload');
Route::get('/history', [App\Http\Controllers\FileController::class, 'fileHistory'])->name('history');
Route::post('/step2', [App\Http\Controllers\FileController::class, 'step2'])->name('step2');
Route::get('/terms_and_conditions', [App\Http\Controllers\FileController::class, 'termsAndConditions'])->name('terms-and-conditions');
Route::get('/norefund_policy', [App\Http\Controllers\FileController::class, 'norefundPolicy'])->name('norefund-policy');
Route::post('/create-temp-file', [App\Http\Controllers\FileController::class, 'createTempFile'])->name('create-temp-file');
Route::post('/get_models', [App\Http\Controllers\FileController::class, 'getModels'])->name('get-models');
Route::post('/get_versions', [App\Http\Controllers\FileController::class, 'getVersions'])->name('get-versions');
Route::post('/get_engines', [App\Http\Controllers\FileController::class, 'getEngines'])->name('get-engines');
Route::post('/get_ecus', [App\Http\Controllers\FileController::class, 'getECUs'])->name('get-ecus');
Route::post('/get_type', [App\Http\Controllers\FileController::class, 'getType'])->name('get-type');
Route::get('/stages', [App\Http\Controllers\FileController::class, 'step3'])->name('step3');
Route::post('/post_stages', [App\Http\Controllers\FileController::class, 'postStages'])->name('post-stages');
Route::post('get_upload_comments', [App\Http\Controllers\FileController::class, 'getUploadComments'])->name('get-upload-comments');
Route::post('/get_options_for_stage', [App\Http\Controllers\FileController::class, 'getOptionsForStage'])->name('get-options-for-stage');
Route::post('/add_credits_to_file', [App\Http\Controllers\FileController::class, 'saveFile'])->name('add-credits-to-file');
Route::get('/file/{id}', [App\Http\Controllers\FileController::class, 'showFile'])->name('file');
Route::get('auto_download', [App\Http\Controllers\FileController::class, 'autoDownload'])->name('auto-download');
Route::post('/file_checkout', [App\Http\Controllers\PaymentsController::class, 'fileCart'])->name('checkout-file');
Route::post('/checkout_file', [App\Http\Controllers\PaymentsController::class, 'checkoutFile'])->name('checkout.file');
Route::post('get_comments', [App\Http\Controllers\FileController::class, 'getComments'])->name('get-comments');

Route::post('get_change_status', [App\Http\Controllers\FileController::class, 'changeCheckingStatus'])->name('get-change-status');
Route::post('get_auto_download_button', [App\Http\Controllers\FileController::class, 'getDownloadButton'])->name('get-download-button');
Route::post('auth_pusher', [App\Http\Controllers\FileController::class, 'authPusher'])->name('pusher.auth');

// Route::post('/checkout_offer_redirect', [App\Http\Controllers\FileController::class, 'checkoutOfferRedirect'])->name('checkout.stripe.offer');
// Route::post('/checkout_offer_paypal_redirect', [App\Http\Controllers\FileController::class, 'checkoutOfferPaypalRedirect'])->name('checkout.paypal.offer');
// Route::post('/checkout_file_paypal', [App\Http\Controllers\PaymentsController::class, 'checkoutFile'])->name('checkout.paypal.file');
Route::post('/new_request', [App\Http\Controllers\FileController::class, 'createNewrequest'])->name('request-file');
Route::post('/file-url', [App\Http\Controllers\FileController::class, 'fileURL'])->name('file-url');
Route::get('/download/{id}/{file}', [App\Http\Controllers\FileController::class,'download'])->name('download');
Route::post('/edit-milage', [App\Http\Controllers\FileController::class, 'EditMilage'])->name('edit-milage');
Route::post('/add-customer-note', [App\Http\Controllers\FileController::class, 'addCustomerNote'])->name('add-customer-note');
Route::post('/file-engineers-notes', [App\Http\Controllers\FileController::class, 'fileEngineersNotes'])->name('file-engineers-notes');
Route::post('/file-events-notes', [App\Http\Controllers\FileController::class, 'fileEventsNotes'])->name('file-events-notes');
Route::post('/file_feedback', [App\Http\Controllers\FileController::class, 'fileFeedback'])->name('file-feedback');
Route::post('accept_offer', [App\Http\Controllers\FileController::class, 'acceptOffer'])->name('accept-offer');
Route::post('reject_offer', [App\Http\Controllers\FileController::class, 'rejectOffer'])->name('reject-offer');
Route::get('pay_offer_credits/{id}', [App\Http\Controllers\FileController::class, 'payCreditsOffer'])->name('pay-credits-offer');
Route::post('add_offer_file', [App\Http\Controllers\FileController::class, 'addOfferToFile'])->name('add-offer-to-file');
Route::post('offer_checkout', [App\Http\Controllers\PaymentsController::class, 'offerCheckout'])->name('offer-checkout');
Route::post('buy_offer', [App\Http\Controllers\PaymentsController::class, 'buyOffer'])->name('buy.offer');
Route::post('acm_file_upload', [App\Http\Controllers\FileController::class, 'acmFileUpload'])->name('acm-file-upload');

Route::post('/viva_payment', [App\Http\Controllers\PaymentsController::class, 'redirectViva'])->name('checkout.viva');
Route::post('/viva_payment_packages', [App\Http\Controllers\PaymentsController::class, 'redirectVivaPackages'])->name('checkout.packages.viva');
Route::post('/viva_payment_file', [App\Http\Controllers\PaymentsController::class, 'redirectVivaFile'])->name('checkout.file.viva');
Route::post('offer_checkout_viva', [App\Http\Controllers\PaymentsController::class, 'offerCheckoutViva'])->name('buy.offer.viva');
Route::post('/viva_payment', [App\Http\Controllers\PaymentsController::class, 'redirectViva'])->name('checkout.viva');

Route::get('/bosch_ecu', [App\Http\Controllers\HomeController::class, 'bosch'])->name('bosch-ecu');
Route::post('/bosch_ecu', [App\Http\Controllers\HomeController::class, 'getBosch'])->name('get-bosch-ecu');

// Route::get('/bosch-ecu', [App\Http\Controllers\AccountController::class, 'boschECU'])->name('bosch-ecu');
Route::get('/evc_credit_shop', [App\Http\Controllers\EVCPackagesController::class, 'packages'])->name('evc-credits-shop');
Route::post('buy_evc_package', [App\Http\Controllers\EVCPackagesController::class, 'buyEVCPackage'])->name('buy.evc.package');
Route::get('/evc_history', [App\Http\Controllers\EVCPackagesController::class, 'history'])->name('evc-history');
Route::post('checkout_evc_packages', [App\Http\Controllers\EVCPackagesController::class, 'checkoutEVCPackages'])->name('checkout.evc.packages');
Route::post('checkout_evc_packages_paypal', [App\Http\Controllers\EVCPackagesController::class, 'checkoutEVCPackages'])->name('checkout.evc.packages.paypal');
Route::get('cancel_evc_packages', [App\Http\Controllers\EVCPackagesController::class, 'cancelEVCPackages'])->name('checkout.evc.cancel');
Route::get('success_evc_packages', [App\Http\Controllers\EVCPackagesController::class, 'successEVC'])->name('checkout.evc.success');
// Route::get('success_evc_packages_paypal', [App\Http\Controllers\EVCPackagesController::class, 'successEVC'])->name('checkout.evc.success');

Route::get('/invoices', [App\Http\Controllers\InvoicesController::class, 'index'])->name('invoices');

Route::get('/shop-product', [App\Http\Controllers\PaymentsController::class, 'shopProduct'])->name('shop-product');
Route::get('/cart', [App\Http\Controllers\PaymentsController::class, 'cart'])->name('cart');
Route::post('/add_to_cart', [App\Http\Controllers\PaymentsController::class, 'addToCart'])->name('add-to-cart');
Route::post('buy_package', [App\Http\Controllers\PaymentsController::class, 'buyPackage'])->name('buy.package');
Route::post('/cart_quantity', [App\Http\Controllers\PaymentsController::class, 'getCartQuantity'])->name('get-cart');
Route::get('/cart', [App\Http\Controllers\PaymentsController::class, 'cart'])->name('cart');
Route::post('checkout_packages', [App\Http\Controllers\PaymentsController::class, 'checkoutPackagesStripe'])->name('checkout.packages.stripe');
Route::post('checkout_packages_paypal', [App\Http\Controllers\PaymentsController::class, 'checkoutPackagesPaypal'])->name('checkout.packages.paypal');

Route::post('/checkout_stripe', [App\Http\Controllers\PaymentsController::class, 'stripeCheckout'])->name('checkout.stripe');
Route::post('/checkout_paypal', [App\Http\Controllers\PaymentsController::class, 'paypalCheckout'])->name('checkout.paypal');
Route::get('/success', [App\Http\Controllers\PaymentsController::class, 'success'])->name('checkout.success');
Route::get('/success_package', [App\Http\Controllers\PaymentsController::class, 'successPackage'])->name('checkout.success.package');
Route::get('/cancel', [App\Http\Controllers\PaymentsController::class, 'cancel'])->name('checkout.cancel');

Route::post('get_tool_icons', [App\Http\Controllers\AccountController::class, 'getToolsIcons'])->name('get-tool-icons');

Route::get('/price-list', [App\Http\Controllers\PricelistController::class, 'index'])->name('price-list');

Route::get('/dtc_lookup', [App\Http\Controllers\HomeController::class, 'dtcLookup'])->name('dtc-lookup');
Route::post('/dtc_lookup', [App\Http\Controllers\HomeController::class, 'getDTCDesc'])->name('get-dtc-desc');

Route::get('/create_test_customer/{id}', [App\Http\Controllers\PaymentsController::class, 'createTestElorusCustomer'])->name('create-customer-elorus');



