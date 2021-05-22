<?php

namespace App\Http\Controllers;
use Auth;

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
}
