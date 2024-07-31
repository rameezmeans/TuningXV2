<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use ECUApp\SharedCode\Models\NewsFeed;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        $feeds = NewsFeed::where('active', 1)
        ->whereNull('subdealer_group_id')
        ->where('front_end_id', 2)
        ->get();

        foreach($feeds as $feed){
            Session::put('feed', $feed);
        }
        
        $this->validateLogin($request);
        
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        try{

            if ($this->attemptLogin($request)) {
                //check user is admin or not  
                
                if (Auth::user()->front_end_id == 2 && Auth::user()->subdealer_group_id == NULL && Auth::user()->is_admin() == false && Auth::user()->is_engineer() == false) {
                    return $this->sendLoginResponse($request);
                }
                else if (Auth::user()->is_admin() == true) {
                    return $this->sendLoginResponse($request);
                }
                else {
                    $this->guard()->logout();
                    // return $this->notAdmin($request);
                }
            }

        }
        catch(Exception $e){

        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function notAdmin(Request $request){
        throw ValidationException::withMessages([
          $this->username() => ['You can not login here.'],
        ]);
    }
}
