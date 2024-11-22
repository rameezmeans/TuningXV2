<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use ECUApp\SharedCode\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $userActual = User::where('email', $user->email)->where('front_end_id', 2)->first();

        $userActual->setRememberToken(Str::random(60));

        $userActual->save();

        event(new PasswordReset($userActual));

        $this->guard()->login($userActual);
    }
}
