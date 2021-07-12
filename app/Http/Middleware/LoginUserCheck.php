<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

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

        return $next($request);
    }
}
