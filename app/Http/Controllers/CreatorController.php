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

//    테스트 이미지 업로드 주석
//    public function write(){
//        $images = Image::latest()->get();
//        return view('creator.upload', compact('images'));
//    }
    public function write(){
        return view('creator.write');
    }

//    21.02.28 김태영, 업로드 전 파일 미리보기
    public function preview(Request $request){

        if($request->hasFile('file')) {

            // Upload path
            $destinationPath = 'files/';

            // Create directory if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Get file extension
            $extension = $request->file('file')->getClientOriginalExtension();

            // Valid extensions
            $validextensions = array("jpeg","jpg","png");

            // Check extension
            if(in_array(strtolower($extension), $validextensions)){

                // Rename file
                $fileName = $request->file('file')->getClientOriginalName().time() .'.' . $extension;
                // Uploading file to given path
                $request->file('file')->move($destinationPath, $fileName);

            }

        }
    }
}

