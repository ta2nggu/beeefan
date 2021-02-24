<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class CreatorController extends Controller
{
    public function __construct(){
        $this->middleware('role:creator');
    }

    //public function index($user_nick){
    public function index(){
        $this->middleware('auth');
        $this->user =  \Auth::user();
//        dd($this->user->nickname);

        $user = DB::table("users")
//                       ->select(DB::raw("COUNT(1) as cnt"))
            ->where('nickname', '=', $this->user->nickname)
            ->get();
        return view('creator.index', [
            'user' => $user
        ]);
    }

    public function write(){
        $images = Image::latest()->get();
        return view('creator.upload', compact('images'));
    }
}
