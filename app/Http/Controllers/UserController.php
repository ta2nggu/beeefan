<?php

namespace App\Http\Controllers;

use App\Models\tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('role:user|administrator|creator');
    }

    public function index(){
        return view('user.index');
    }

    public function creatorIndex($creator_nick) {
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $creator = DB::table("users")
            ->select(DB::raw('users.name, users.nickname, users.instruction'))
            ->where('nickname', '=', $creator_nick)
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

            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, users.nickname, tweets.id, tweets.include_video, tweets.file_cnt"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->where('users.nickname', $creator_nick)
            ->where('tweets.visible', 1)
            ->orderBy('tweets.id', 'desc')
            ->get();


//        잘못된 url은 404 에러 페이지
        if(!$creator->count()) {
            return abort(404);
        }

        return view('user.creatorIndex', [
            'creator' => $creator,
            'tweets' => $tweets
        ]);
    }

    public function timeline(Request $request, $creator_nick, $startTweet) {
        $nowTweet = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.name, users.nickname, tweets.id, tweets.msg, tweets.file_cnt, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->where('users.nickname', $creator_nick)
            ->where('tweets.id', $startTweet)
            ->where('tweets.visible', 1)
            ->get();

        $otherTweets = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.name, users.nickname, tweets.id, tweets.msg, tweets.file_cnt, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->where('users.nickname', $creator_nick)
            ->where('tweets.id','<>', $startTweet)
            ->where('tweets.visible', 1)
            ->orderBy('tweets.id', 'desc')
//            ->limit(4)
            ->get();

        $tweets = $nowTweet->merge($otherTweets)->forPage($request->page,5);

//        $tweets = tweet::paginate(2);
        if ($request->ajax()) {
            $view = view('timelineData', compact('tweets'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('timeline', compact('tweets'));//compact 할 때 var_name이 위에 선언한 $tweets 과 이름이 같아야 된다
//        return view('timeline', [
//            'tweets' => $tweet
//        ]);
    }
}
