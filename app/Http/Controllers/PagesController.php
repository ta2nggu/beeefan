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
}
class homeController extends Controller
{
    public function ブレード名(){
        $auths = Auth::user();
        return view('home', [ 'auths' => $auths ]);
    }
}
