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

    // testpage
    public function test1(){ return view('test/02-1');}
    public function test2(){ return view('test/02-2');}
    public function test3(){ return view('test/03-2');}
    public function test5(){ return view('test/03-4');}
}
