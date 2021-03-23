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

//        21.03.07 김태영, 크리에이터 tweet 가져오기
//        $tweets = DB::table('tweets', 'tweets')
////            ->select('tweets.user_id', 'tweets.id', 'tweet_images.name')
//            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path, tweets.id"))
//            ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
//            ->where('tweets.user_id', $this->user->id)
//            ->where('tweet_images.idx', 0)
//            ->orderBy('tweets.id', 'desc')
//            ->orderBy('tweet_images.idx')
////            ->limit(1)
//            ->get();

        $tweets = DB::table('tweets', 'tweets')
//            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path, tweets.id, tweet_images.mime_type, A.images_cnt"))
//            ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
//            ->joinSub('(select tweet_images.tweet_id, count(1) as images_cnt from tweet_images join tweets on tweet_images.tweet_id = tweets.id where tweets.user_id = '.$this->user->id.' group by tweet_images.tweet_id)', 'A', 'A.tweet_id', '=', 'tweets.id')
//            ->where('tweets.user_id', $this->user->id)
//            ->where('tweets.visible', 1)
////            ->where('tweet_images.idx', 0)
//            ->where('tweet_images.private', 0)
//            ->orderBy('tweets.id', 'desc')
//            ->orderBy('tweet_images.idx')

            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, tweets.id, tweets.include_video, tweets.file_cnt"))
            ->where('tweets.user_id', $this->user->id)
            ->where('tweets.visible', 1)
            ->orderBy('tweets.id', 'desc')
            ->get();


        return view('creator.index', [
            'user' => $user,
            'tweets' => $tweets
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

//    21.03.07 김태영, dropzone js 사용으로 변경, 현재 사용 안함
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

