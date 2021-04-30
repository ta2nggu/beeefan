<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    //21.04.02 kondo, 静的ページ用

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
}
//class homeController extends Controller
//{
//    public function ブレード名(){
//        $auths = Auth::user();
//        return view('home', [ 'auths' => $auths ]);
//    }
//}
