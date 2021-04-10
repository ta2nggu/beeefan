<?php

namespace App\Http\Controllers;

use App\Models\tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(){
//        21.04.06 김태영, 생성자에 role check 제거, 비 로그인 user 에게도 보여주기 위함
//        $this->middleware('role:user|administrator|creator');
    }

    public function index(){
        return view('user.index');
    }

//    21.03.28 김태영, parameter Request $request 추가
    public function creatorIndex(Request $request, $account_id) {
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $creator = DB::table("users")
            ->select(DB::raw('users.name, users.nickname, users.instruction'))
//            ->where('nickname', '=', $creator_nick)
//                21.04.06 김태영, $creator_nick -> account_id
            ->where('account_id', '=', $account_id)
            ->get();

        $tweets = DB::table('tweets', 'tweets')
//            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path, tweets.id, tweet_images.mime_type, A.images_cnt"))
//            ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
//            ->join('users', 'users.id', '=', 'tweets.user_id')
//            ->joinSub('(select tweet_images.tweet_id, count(1) as images_cnt from tweet_images join tweets on tweets.id = tweet_images.tweet_id join users on users.id = tweets.user_id where users.nickname = "'.$creator_nick.'" group by tweet_images.tweet_id)', 'A', 'A.tweet_id', '=', 'tweets.id')
////            ->where('tweets.user_id', $this->user->id)
//            ->where('users.nickname', $creator_nick)
//            ->where('tweets.visible', 1)
////            ->where('tweet_images.idx', 0)
//            ->where('tweet_images.private', 0)
//            ->orderBy('tweets.id', 'desc')
//            ->orderBy('tweet_images.idx')

            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, users.nickname, tweets.id, tweets.include_video, tweets.file_cnt, users.account_id"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
//            ->where('users.nickname', $creator_nick)
            ->where('users.account_id', $account_id)
            ->where('tweets.visible', 1)
            ->orderBy('tweets.id', 'desc')
//            ->get();
//          21.03.28 김태영, paginate로 변경 ajax inifite scrolling 을 위해
            ->paginate(15);


//        잘못된 url은 404 에러 페이지
        if(!$creator->count()) {
            return abort(404);
        }

//        return view('user.creatorIndex', [
//        21.03.28 김태영, creatorIndex view page directory, main.blade.php로 이름 변경
//        return view('main', [
//            'creator' => $creator,
//            'tweets' => $tweets
//        ]);
        if ($request->ajax()) {
            $view = view('mainData', compact('creator', 'tweets'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('main', compact('creator', 'tweets'));
    }

    public function timeline(Request $request, $account_id, $startTweet) {
        //main tweet
        //nowTweet -> 사용자가 click한 tweet, timeline에서 최상단에 위치
        $nowTweet = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.name, users.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->where('users.account_id', $account_id)
            ->where('tweets.id', $startTweet)
            ->where('tweets.visible', 1)
            ->get();
        //otherTweets -> 사용자가 click한 tweet을 제외한 나머지를 등록 역순으로 조회
        $otherTweets = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.name, users.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->where('users.account_id', $account_id)
            ->where('tweets.id','<>', $startTweet)
            ->where('tweets.visible', 1)
            ->orderBy('tweets.id', 'desc')
//            ->limit(4)
            ->get();
        //nowTweet + otherTweets 합침
        //forPage는 페이징 처리, 5개
        $tweets = $nowTweet->merge($otherTweets)->forPage($request->page,5);

        $tweet_images = new \Illuminate\Support\Collection;
        foreach ($tweets as $tweet) {
            $loop = DB::table('tweets', 'tweets')
                ->select(DB::raw("tweet_images.tweet_id, tweet_images.idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path"))
                ->join('users', 'users.id', '=', 'tweets.user_id')
                ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
                ->where('users.account_id', $account_id)
                ->where('tweets.id', $tweet->id)
                ->where('tweet_images.idx','<>', $tweet->main_img_idx)//무료공개 = main image는 이미 tweet 정보 가져올 때 가져옴, main image 제외하고 조회
                ->where('tweets.visible', 1)
                ->orderBy('tweet_images.idx', 'asc')
                ->get();
//
            $tweet_images = $tweet_images->merge($loop);
        }
//        var_dump($tweet_images);

//        $tweets = tweet::paginate(2);
        if ($request->ajax()) {
            $view = view('timelineData', compact('tweets', 'tweet_images'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('timeline', compact('tweets', 'tweet_images'));//compact 할 때 var_name이 위에 선언한 $tweets 과 이름이 같아야 된다
//        return view('timeline', [
//            'tweets' => $tweet
//        ]);
    }
}
