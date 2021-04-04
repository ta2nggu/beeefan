<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
