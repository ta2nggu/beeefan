<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class LoginUserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //ログインユーザーIDを取得
        $user = Auth::id();
        $user = User::find($user);

        //本登録が済んでいない場合
        if ($user->status != '1') {
            return redirect(route('preRegistered.show'));
        }

        return $next($request);
    }
}
