<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show(Request $request)
    {
        $user = $request->user();

        //210713 kondo, 本登録が済んでいない場合
        if ($user->status != '1') {
            $now = strtotime(Carbon::now());
            $user_created_time = strtotime($user->created_at);
            $difference =($now - $user_created_time) / 60 / 60;
            if($difference > 1){
                $user->status = config('const.USER_STATUS.INVALID');
                if ($user->save()) {
                    Auth::logout($user);
                    return redirect(route('error.show'))->with('flash_message', "仮登録が無効になりました。\n再度、新規登録からやり直してください。");
                } else {
                    Auth::logout($user);
                    return redirect(route('error.show'))->with('flash_message', "エラーが発生しました。\n再度、新規登録からやり直してください。");
                }
            }
            Auth::logout($user);
            return redirect(route('preRegistered.show'));
        }

        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify',compact('user'));
    }

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

        //210713 kondo, 本登録が済んでいない場合
        if ($user->status != '1') {
            Auth::logout($user);
            return redirect(route('preRegistered.show'));
        }

        //이미 인증된 이메일이 있으면
        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

//        return redirect($this->redirectPath())->with('verified', true);
        if($user->hasRole('superadministrator')){
            return redirect('/admin/index')->with('verified', true)->with('flash_message','メールアドレスの認証が完了しました');
        }
        if($user->hasRole('administrator')){
            return redirect('/admin/index')->with('verified', true)->with('flash_message','メールアドレスの認証が完了しました');
        }
        if($user->hasRole('creator')){
            //return redirect('/creator/'.$user->nickname);
            return redirect('/creator/index')->with('verified', true)->with('flash_message','メールアドレスの認証が完了しました');
        }
        if($user->hasRole('user')){
//            return redirect('/user')->with('verified', true);
            return redirect('/mypage')->with('verified', true)->with('flash_message','メールアドレスの認証が完了しました');
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
