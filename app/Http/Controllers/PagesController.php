<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    // クリエイターログイン
    public function creatorLogin(){
        return view('auth/login', ['userFlag' => 'クリエイター']);
    }
    public function adminLogin(){
        return view('auth/login', ['userFlag' => '運営者']);
    }

    // 固定ページ
    public function pageRule(){
        return view('help/rule');
    }
    public function pagePolicy(){
        return view('help/policy');
    }
    public function pageLaw(){
        return view('help/law');
    }
    public function pageHelp(){
        return view('help/help');
    }

    // エラー
    public function errorShow(){
        return view('errors/error');
    }

    // エラー（アカウント無効化画面）
    public function accountInvalid(){
        return view('errors/accountInvalid');
    }
    // エラー（アカウント無効化画面）アカウント削除
    public function accountInvalidPost(Request $request){
        $user = User::find($request->user_id);
        $user->delete();
        return redirect(url('/register'));
    }
}
