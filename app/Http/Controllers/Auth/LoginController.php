<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;//21.02.21 김태영, 로그인 사용자 별 분기 위해 추가
use App\Models\User;
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
    //protected $redirectTo = RouteServiceProvider::HOME;
    //21.02.21 김태영
    protected function authenticated(Request $request, $user)
    {
        if($user->hasRole('administrator')){
            return redirect('/admin/index');
        }
        if($user->hasRole('creator')){
            //return redirect('/creator/'.$user->nickname);
            return redirect('/creator/index');
        }
//        21.04.08 김태영, 로그인 후 이전 페이지로 이동하기 위해 주석처리
//        if($user->hasRole('user')){
//            return redirect('/mypage');
//        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
//21.04.08 김태영, 로그인 후 이전 페이지로 이동하기 위해 추가
        $this->redirectTo = url()->previous();
    }

//21.04.08 김태영, 로그인 후 이전 페이지로 이동하기 위해 showLoginForm 추가
    public function showLoginForm(Request $request)
    {
//        21.05.02 kondo, toppageからloginする時はmypageへ
        $date = [
            'param'=>$request->root
        ];
        if($date['param']){
            session(['url.intended' => '/mypage']);
        } else {
            //21.04.19 김태영, 로그인 이전 페이지로 이동
            session(['url.intended' => url()->previous()]);

            if (!session()->has('url.intended')) {
                session(['url.intended' => url()->previous()]);
            }
        }
        return view('auth.login');

    }
}
