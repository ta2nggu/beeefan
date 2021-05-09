<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    //21.04.14 김태영, email 인증 후 redirect
//    protected $redirectTo = RouteServiceProvider::HOME; 21.04.14 김태영, 주석처리
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        //이미 인증된 이메일이 있으면
        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

//        return redirect($this->redirectPath())->with('verified', true);
        if($user->hasRole('superadministrator')){
            return redirect('/admin/index')->with('verified', true);
        }
        if($user->hasRole('administrator')){
            return redirect('/admin/index')->with('verified', true);
        }
        if($user->hasRole('creator')){
            //return redirect('/creator/'.$user->nickname);
            return redirect('/creator/index')->with('verified', true);
        }
        if($user->hasRole('user')){
//            return redirect('/user')->with('verified', true);
            return redirect('/mypage')->with('verified', true);
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
