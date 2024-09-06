<?php

namespace App\Http\Controllers;

use ECUApp\SharedCode\Controllers\AuthMainController;
use ECUApp\SharedCode\Controllers\ElorusMainController;
use ECUApp\SharedCode\Controllers\FilesMainController;
use ECUApp\SharedCode\Controllers\PaymentsMainController;
use ECUApp\SharedCode\Controllers\ZohoMainController;
use ECUApp\SharedCode\Models\Group;
use ECUApp\SharedCode\Models\Package;
use ECUApp\SharedCode\Models\Product;
use ECUApp\SharedCode\Models\User;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Deyjandi\VivaWallet\VivaWallet;
use Deyjandi\VivaWallet\Payment;
use ECUApp\SharedCode\Models\TemporaryFile;
use Srmklive\PayPal\Facades\PayPal;

class PaymentsController extends Controller
{
    private $paymenttMainObj;
    private $authMainObj;
    private $filesMainObj;
    private $zohoMainObj;
    private $elorusMainObj;
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
        $this->paymenttMainObj = new PaymentsMainController();
        $this->authMainObj = new AuthMainController();
        $this->filesMainObj = new FilesMainController();
        $this->zohoMainObj = new ZohoMainController();
        $this->elorusMainObj = new ElorusMainController();
    }

    public function vivaCreds(){

        $vivaAccount = Auth::user()->viva_payment_account();
        
        config(['viva-wallet.env' => $vivaAccount->env]);
        config(['viva-wallet.api_key' => $vivaAccount->key]);
        config(['viva-wallet.client_id' => $vivaAccount->viva_client_id]);
        config(['viva-wallet.client_secret' => $vivaAccount->secret]);
        config(['viva-wallet.merchant_id' => $vivaAccount->viva_merchant_id]);
        config(['viva-wallet.payment.source_code' => $vivaAccount->source_code]);
    }

    public function redirectVivaFile(Request $request) {

        $user = Auth::user();

        $file = TemporaryFile::findOrFail($request->file_id);

        $serviceCredits = $this->filesMainObj->getCredits($file);

        $creditsToBuy = $serviceCredits - Auth::user()->credits->sum('credits');
        $creditsForFile = $serviceCredits;

        $fileID = $request->file_id;

        $unitPrice =  $this->paymenttMainObj->getPrice()->value;

        $taxPer = 0;

        if($user->group->tax > 0){
            $taxPer = (float) $user->group->tax;
        }

        $tax = ($taxPer * $unitPrice)/100;

        $unitPrice = $unitPrice + $tax;

        $money = $unitPrice * $creditsToBuy;

        $this->vivaCreds();

        $jsonMessage = json_encode([
            'file_id' => $fileID,
            'credits_for_file' => $creditsForFile,
            'credits_to_buy' => $creditsToBuy,
        ]);

        $payment = new Payment();
        $payment->setAmount($money*100)
        ->setMerchantTrns($jsonMessage)
        ->setBrandColor('273759');

        $checkoutUrl = VivaWallet::createPaymentOrder($payment);

        return redirect()->away($checkoutUrl);
    }

    public function redirectVivaPackages(Request $request) {

        $money = (float)$request->price * 100;

        $this->vivaCreds();

        $jsonMessage = json_encode(['package_id' => $request->package_id]);

        $payment = new Payment();
        $payment->setAmount($money)
        ->setMerchantTrns($jsonMessage)
        ->setBrandColor('273759');

        $checkoutUrl = VivaWallet::createPaymentOrder($payment);

        return redirect()->away($checkoutUrl);

    }

    public function offerCheckoutViva(Request $request) {

        $user = Auth::user();
        
        $file = TemporaryFile::findOrFail($request->file_id);

        $serviceCredits = $this->filesMainObj->getCredits($file);
        $creditsToBuy = $serviceCredits - Auth::user()->credits->sum('credits');
        $creditsForFile = $serviceCredits;

        $fileID = $request->file_id;

        $unitPrice =  $this->paymenttMainObj->getPrice()->value;

        $taxPer = 0;

        if($user->group->tax > 0){
            $taxPer = (float) $user->group->tax;
        }

        $tax = ($taxPer * $unitPrice)/100;

        $unitPrice = $unitPrice + $tax;

        $money = $unitPrice * $creditsToBuy;

        $this->vivaCreds();

        $jsonMessage = json_encode([
            'type' => 'offer',
            'file_id' => $fileID,
            'credits_for_file' => $creditsForFile,
            'credits_to_buy' => $creditsToBuy,
        ]);

        $payment = new Payment();
        $payment->setAmount($money*100)
        ->setMerchantTrns($jsonMessage)
        ->setBrandColor('273759');

        $checkoutUrl = VivaWallet::createPaymentOrder($payment);

        return redirect()->away($checkoutUrl);
    }

    public function redirectViva(Request $request) {

        $amount = (int)$request->amount;

        if($amount <= 0){
            return redirect()->back()->with('success', 'Please pick 1 or more credits!');

        }

        $money = (float)$request->amount * 100;

        $this->vivaCreds();

        $jsonMessage = json_encode(['credits' => $request->credits]);

        $payment = new Payment();
        $payment->setAmount($money)
        ->setMerchantTrns($jsonMessage)
        ->setBrandColor('273759');

        $checkoutUrl = VivaWallet::createPaymentOrder($payment);

        return redirect()->away($checkoutUrl);
    }

    public function offerCheckout(Request $request) {

        $file = TemporaryFile::findOrFail($request->file_id);

        $serviceCredits = $this->filesMainObj->getCredits($file);

        $creditsToBuy = $serviceCredits - Auth::user()->credits->sum('credits');
        $creditsForCheckout = $serviceCredits;

        $fileID = $request->file_id;

        $user = Auth::user();

        $price = $this->paymenttMainObj->getPrice();

        $packages =  $this->paymenttMainObj->getPackages($this->frontendID);

        if($user->exclude_vat_check) {

            if(!$user->group_id){
                $vat0Group = Group::where('slug', 'VAT0')->first();
                $user->group_id = $vat0Group->id;
            }
        }

        else{

            $this->authMainObj->VATCheckPolicy($user);
           
        }
        
        $factor = 0;
        $tax = 0;

        if($user->group->tax > 0){
            $tax = (float) $user->group->tax;
        }

        if($user->group->raise > 0){
            $factor = (float)  ($user->group->raise / 100) * $price->value;
        }

        if($user->group->discount > 0){
            $factor =  -1* (float) ($user->group->discount / 100) * $price->value;
        }

        return view('files.cart_offer', [

            'file_id' => $fileID,
            'credits_to_buy' => $creditsToBuy,
            'credits_for_checkout' => $creditsForCheckout, 
            'packages' => $packages, 
            'price' => $price, 
            'tax' => $tax, 
            'factor' => $factor, 
            'group' => $user->group, 
            'user' => $user
        ]);

    }

    public function buyOffer(Request $request){

        $file = TemporaryFile::findOrFail($request->file_id);

        $serviceCredits = $this->filesMainObj->getCredits($file);
        $creditsToBuy = $serviceCredits - Auth::user()->credits->sum('credits');
        $creditsForFile = $serviceCredits;

        $fileID = $request->file_id;

        $type = $request->type;
        $user = Auth::user();
        $unitPrice =  $this->paymenttMainObj->getPrice()->value;
        
        if($type == 'stripe'){
            return $this->paymenttMainObj->redirectStripeOffer($user, $unitPrice, $creditsToBuy, $creditsForFile, $fileID);
        }
        else{
            return $this->paymenttMainObj->redirectPaypalOffer($user, $unitPrice, $creditsToBuy, $creditsForFile, $fileID);
        }
    }


    public function fileCart(Request $request){

        $file = TemporaryFile::findOrFail($request->file_id);

        $serviceCredits = $this->filesMainObj->getCredits($file);
        $creditsToBuy = $serviceCredits - Auth::user()->credits->sum('credits');
        $creditsForFile = $serviceCredits;

        $fileID = $request->file_id;

        $user = Auth::user();

        $price = $this->paymenttMainObj->getPrice();
        $packages = $this->paymenttMainObj->getPackages($this->frontendID);

        if($user->exclude_vat_check) {

            if(!$user->group_id){
                $vat0Group = Group::where('slug', 'VAT0')->first();
                $user->group_id = $vat0Group->id;
                $user->save();
            }
        }

        else{

            $this->authMainObj->VATCheckPolicy($user);
            
        }
        
        $factor = 0;
        $tax = 0;

        if($user->group->tax > 0){
            $tax = (float) $user->group->tax;
        }

        if($user->group->raise > 0){
            $factor = (float)  ($user->group->raise / 100) * $price->value;
        }

        if($user->group->discount > 0){
            $factor =  -1* (float) ($user->group->discount / 100) * $price->value;
        }

        return view('files.file_cart', ['user' => $user, 'file_id' => $fileID,'creditsToBuy' => $creditsToBuy, 'creditsForFile' => $creditsForFile, 'packages' => $packages, 'price' => $price, 'tax' => $tax, 'factor' => $factor, 'group' => $user->group] );

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function shopProduct(){

        $user = Auth::user();
        
        $price = $this->paymenttMainObj->getPrice();
        $packages = $this->paymenttMainObj->getPackages($this->frontendID);

        return view('shop_product', ['packages' => $packages, 'price' => $price, 'group' => $user->group, 'user' => $user]);
    }

    public function cart(){
        
        $user = Auth::user();
        $price = $this->paymenttMainObj->getPrice();
        $packages = $this->paymenttMainObj->getPackages($this->frontendID);

        if($user->exclude_vat_check) {

            if(!$user->group_id){
                $vat0Group = Group::where('slug', 'VAT0')->first();
                $user->group_id = $vat0Group->id;
                $user->save();
            }
        }

        else{

            $this->authMainObj->VATCheckPolicy($user);
            
        }
        
        $factor = 0;
        $tax = 0;

        if($user->group->tax > 0){
            $tax = (float) $user->group->tax;
        }

        if($user->group->raise > 0){
            $factor = (float)  ($user->group->raise / 100) * $price->value;
        }

        if($user->group->discount > 0){
            $factor =  -1* (float) ($user->group->discount / 100) * $price->value;
        }

        
        return view('cart', ['packages' => $packages, 'price' => $price, 'tax' => $tax, 'factor' => $factor, 'group' => $user->group, 'user' => $user] );

    }

    public function createTestElorusCustomer($userID){

        $user = User::findOrFail($userID);
        $this->elorusMainObj->createTestElorusCustomer($user);

    }

    public function success(Request $request){

        $this->vivaCreds();

        $package = false;
        $offer = false;
        $fileFlag = false;
        $viva = false;
        $packageID = 0;

        if(isset($request->purpose) && $request->purpose == 'offer'){
            $offer = true;
            $fileID = $request->file_id;
        }

        if(isset($request->eventId)){
            $viva = true;
        }

        if(!$offer) {
            
            if(isset($request->file_id)){
                $fileFlag = true;
                $fileID = $request->file_id;
            }

        }

        $user = Auth::user();
        $type = $request->type;

        if($type == 'stripe'){
            $sessionID = $request->get('session_id');
        }
        else if($type == 'paypal'){

            $arr = [];

            $arr['PayerID'] = $request->input('PayerID');
            $arr['paymentId'] = $request->input('paymentId');
            
            $sessionID = $arr;

            // $this->gateway->setClientId($user->paypal_payment_account()->key);
            // $this->gateway->setSecret($user->paypal_payment_account()->secret);
            // // $this->gateway->setTestMode(false);
            // $this->gateway->setTestMode(true);

            // if ($request->input('paymentId') && $request->input('PayerID')) {
            //     $transaction = $this->gateway->completePurchase(array(
            //         'payer_id' => $request->input('PayerID'),
            //         'transactionReference' => $request->input('paymentId')
            //     ));
    
            //     $response = $transaction->send();

            //     if ($response->isSuccessful()) {
    
            //         $arr = $response->getData();

            //         Log::info(json_encode($arr));

            //         $sessionID = $arr['id'];

            //     }

            // }

            // $configArr = config('paypal');

            // $configArr['live']['client_id'] = $user->paypal_payment_account()->key;
            // $configArr['live']['client_secret'] = $user->paypal_payment_account()->secret;

            // // $sessionID = $request->get('PayerID');
            // PayPal::setProvider();
            // $paypalProvider = PayPal::getProvider();
            // $paypalProvider->setApiCredentials($configArr);
            // $paypalProvider->setAccessToken($paypalProvider->getAccessToken());   
            // $token = $request->get('token');

            // $orderInfo = $paypalProvider->showOrderDetails($token);
            // $response = $paypalProvider->capturePaymentOrder($token);

            // Log::info(json_encode($orderInfo));
            // Log::info(json_encode($response));

            // dd($response);
            
        }

        if($offer){ 
            $file = TemporaryFile::findOrFail($request->file_id);

            $serviceCredits = $this->filesMainObj->getCredits($file);
            $credits = $serviceCredits - Auth::user()->credits->sum('credits');
            $creditsForFile = $serviceCredits;

            $invoice = $this->paymenttMainObj->addCredits($user, $sessionID, $credits, $type);
            $file = $this->filesMainObj->acceptOfferFinalise($user, $fileID, $creditsForFile, $this->frontendID);
        }

        if($fileFlag){

            $file = TemporaryFile::findOrFail($request->file_id);

            $serviceCredits = $this->filesMainObj->getCredits($file);
            $credits = $serviceCredits - Auth::user()->credits->sum('credits');
            $creditsForFile = $serviceCredits;

            $invoice = $this->paymenttMainObj->addCredits($user, $sessionID, $credits, $type);
            $file = $this->filesMainObj->saveFile($user, $fileID, $creditsForFile, $type);
            $this->filesMainObj->notifications($file);

        }

        else{

            if($viva){

                $type = 'viva';
                $sessionID = $request->get('t');
                $transaction = VivaWallet::retrieveTransaction($request->get('t'));

                Log::info(json_encode($transaction));
                Log::info(json_encode($sessionID));

                $merchantTrns = json_decode($transaction['merchantTrns']);

                if(isset($merchantTrns->package_id)) {

                    $package = true;
                    $packageObj = Package::findOrFail($merchantTrns->package_id);
                    $packageID = $packageObj->id;
                    $credits = $packageObj->credits;
                    $invoice = $this->paymenttMainObj->addCreditsPackage($user, $sessionID, $packageObj, $type);

                }
                else if(isset($merchantTrns->file_id)){

                    if(isset($merchantTrns->type) && $merchantTrns->type == 'offer'){

                        $offer = true;
                        $creditsForFile = $merchantTrns->credits_for_file;
                        $credits = $merchantTrns->credits_to_buy;
                        $fileID = $merchantTrns->file_id;
                        $invoice = $this->paymenttMainObj->addCredits($user, $sessionID, $credits, $type);
                        $file = $this->filesMainObj->acceptOfferFinalise($user, $fileID, $creditsForFile, $this->frontendID);

                    }
                    else{
                    
                        $fileFlag = true;
                        $fileID = $merchantTrns->file_id;
                        $creditsForFile = $merchantTrns->credits_for_file;
                        $credits = $merchantTrns->credits_to_buy;

                        $invoice = $this->paymenttMainObj->addCredits($user, $sessionID, $credits, $type);
                        $file = $this->filesMainObj->saveFile($user, $fileID, $creditsForFile, $type);
                        $this->filesMainObj->notifications($file);
                    }

                }
                else{
                    $amount = $transaction['amount'];
                    $price = $this->paymenttMainObj->getPrice()->value;
                    $tax = (float) $user->group->tax;
                    $amountWithoutTax =  $amount;
                    $taxAmount = 0;

                    if($tax>0){
                        $taxAmount = $amount * $tax/100;
                        $amountWithoutTax = $amount - $taxAmount;
                    }

                    $credits = (float) $amountWithoutTax / $price;
                    $invoice = $this->paymenttMainObj->addCredits($user, $sessionID, $credits, $type);
                }
                
            }
            else{

                if($offer == false){ 

                    if($request->packageID == 0){

                        $credits = $request->credits;
                        $invoice = $this->paymenttMainObj->addCredits($user, $sessionID, $credits, $type);
                    }
                    else{

                        $package = true;
                        $packageID = $request->packageID;
                        $package = Package::findOrFail($packageID);
                        $credits = $package->credits;
                        $invoice = $this->paymenttMainObj->addCreditsPackage($user, $sessionID, $package, $type);
                        
                    }
                }
            }
        }

        if($user->zohobooks_id == NULL){
            $this->zohoMainObj->createZohoAccount($user);
        }

        if($user->zohobooks_id){
            if($invoice == NULL){
                return redirect()->route('cart')->with('success', 'Credits not added.');
            }
            $this->zohoMainObj->createZohobooksInvoice($user, $invoice, $package, $type, $packageID);
        }

        if($user->zohobooks_id == NULL){

            $this->zohoMainObj->createZohoAccount($user);
        }

        if($type == 'stripe'){
            $account = $user->stripe_payment_account();
            
        }
        else if($type == 'viva'){
            $account = $user->viva_payment_account();
            
        }
        else{
            $account = $user->paypal_payment_account();
        }

        if($account->elorus){

            $clientID = null;

            if($user->elorus_id == null){
                
                $clientID = $this->elorusMainObj->createElorusCustomer($user);
            }
            else{
                $clientID = $user->elorus_id;
            }
            
            if(country_to_continent($user->country) == 'Europe'){

                $this->elorusMainObj->createElorusInvoice($invoice, $clientID, $user, $package);

            }
        }

        \Cart::remove(101);

        if($offer){
            return redirect()->route('file', $file->id)->with('success', 'Offer is accepted!');
        }

        if($fileFlag){
            return redirect()->route('auto-download',['id' => $file->id]);
        }

        return redirect()->route('shop-product')->with('success', 'Credits are added!');
        
    }

    public function buyPackage(Request $request){

        $user = Auth::user();

        $price = $request->price;
        $package = $request->package;
        $credits = $request->credits;

        $packages = $this->paymenttMainObj->getPackages($this->frontendID);

        if($user->exclude_vat_check) {

            if(!$user->group_id){
                $vat0Group = Group::where('slug', 'VAT0')->first();
                $user->group_id = $vat0Group->id;
                $user->save();
            }
        }

        else{

            $this->authMainObj->VATCheckPolicy($user);

        }
        
        $factor = 0;
        $tax = 0;

        if($user->group->tax > 0){
            $tax = (float) $user->group->tax;
        }

        if($user->group->raise > 0){
            $factor = (float)  ($user->group->raise / 100) * $price;
        }

        if($user->group->discount > 0){
            $factor =  -1* (float) ($user->group->discount / 100) * $price;
        }

        
        return view('cart_package', ['package' => $package,'credits' => $credits,'packages' => $packages, 'price' => $price, 'tax' => $tax, 'factor' => $factor, 'group' => $user->group, 'user' => $user] );

    }

    public function checkoutPackagesPaypal(Request $request){

        $user = Auth::user();
        $package =  Package::findOrFail($request->package);

        return $this->paymenttMainObj->redirectPaypal($user, $package->discounted_price, $package->credits, $package->id);        
    }

    public function checkoutPackagesStripe(Request $request){

        $user = Auth::user();
        $package =  Package::findOrFail($request->package);

        return $this->paymenttMainObj->redirectStripe($user, $package->discounted_price, $package->credits, $package->id);

    }

    public function paypalCheckout(Request $request){

        $user = Auth::user();
        $unitPrice =  $this->paymenttMainObj->getPrice()->value;
        $credits = $request->credits_for_checkout;
        return $this->paymenttMainObj->redirectPaypal($user, $unitPrice, $credits);

    }
    
    public function checkoutFile(Request $request){

        $file = TemporaryFile::findOrFail($request->file_id);

        $serviceCredits = $this->filesMainObj->getCredits($file);
        $creditsToBuy = $serviceCredits - Auth::user()->credits->sum('credits');
        $creditsForFile = $serviceCredits;
        
        $fileID = $request->file_id;

        $type = $request->type;
        $user = Auth::user();
        $unitPrice =  $this->paymenttMainObj->getPrice()->value;
        
        if($type == 'stripe'){
            return $this->paymenttMainObj->redirectStripeFile($user, $unitPrice, $creditsToBuy, $creditsForFile, $fileID);
        }
        else{
            return $this->paymenttMainObj->redirectPaypalFile($user, $unitPrice, $creditsToBuy, $creditsForFile, $fileID);
        }

    }

    public function stripeCheckout(Request $request){
       
        $user = Auth::user();
        $unitPrice =  $this->paymenttMainObj->getPrice()->value;
        $credits = $request->credits_for_checkout;
        return $this->paymenttMainObj->redirectStripe($user, $unitPrice, $credits);
        
    }

    public function cancel(){
        return redirect()->route('shop-product')->with('danger', 'Credits Not Added!');
    }

    public function getCartQuantity(){
        $item = \Cart::get(101);
        if($item){
            return $item['quantity'];
        }
        else{
            return 0;
        }
    }

    public function clearCart(){
        \Cart::remove(101);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addToCart(Request $request)
    {

        $empty = \Cart::isEmpty();

        if($empty){

            $product = Product::findOrFail(1);
            $request->cart;

            \Cart::add(array(
                'id' => 101,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => array(),
                'associatedModel' => $product
            ));
        }

        else{

            \Cart::update(101, array(
                'quantity' => $request->cart, 
              ));
        }

        
        return response()->json(['success'=>'Item Added to cart']);
    }
}
