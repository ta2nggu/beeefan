<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    //21.08.01 kondo, superadministrator新規作成
    public function saReg() {
        return view('admin.saReg');
    }
    public function saReg_store(Request $request) {
        $validated = $request->validate([
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'account_id' => ['required', 'string', 'min:2', 'max:20','unique:users', 'regex:/^[\w-]*$/','not_in:index,verify,creator,admin,page,remove,exit,error,register,registered,home,mypage,join,image,stripe,aDetail,password,email'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $new = User::create([
            'account_id' => $request->input('account_id'),
            'last_name' => $request->input('last_name'),
            'first_name' => $request->input('first_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'status' => '5',
        ]);
        $new->attachRole('superadministrator');
        return redirect(route('top'));
    }
}
