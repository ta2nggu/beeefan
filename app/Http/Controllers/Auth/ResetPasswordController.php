<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * パスワード再設定が完了した場合の処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

    protected function sendResetResponse(Request $request, $response)
    {
        // リダイレクト先でフラッシュメッセージを表示する
        $user = \Auth::user();
        $user = DB::table("role_user")
            ->where('user_id', '=', $user->id)
            ->first();
        $role = $user->role_id;
        if ($role === 1 || $role === 2 ) {
            return redirect(route('admin'))->with('flash_message', trans($response));
        } elseif ($role === 3) {
            return redirect(route('creator'))->with('flash_message', trans($response));
        } elseif ($role === 4) {
            return redirect(route('userIndex'))->with('flash_message', trans($response));
        }
        return redirect(route('home'))->with('flash_message', trans($response));
    }
}
