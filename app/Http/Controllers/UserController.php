<?php

namespace App\Http\Controllers;

use App\Models\Following;
use App\Models\tweet;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(){
//        21.04.06 김태영, 생성자에 role check 제거, 비 로그인 user 에게도 보여주기 위함
//        $this->middleware('role:user|administrator|creator');
    }

    public function index(Request $request){
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $creators = Following::join('creators', 'creators.user_id', '=', 'followings.creator_id')
//                                21.05.02 kondo,account_id取得の為にjoin追加
                                ->join('users', 'users.id', '=', 'creators.user_id')
                                ->where('followings.user_id', '=', $this->user->id)
                                ->orderby('creators.nickname', 'asc')
                                ->paginate(5);

        if ($request->ajax()) {
            $view = view('user.indexData', compact( 'creators'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('user.index', [
            'user' => $this->user,
            'creators' => $creators
        ]);
    }

    public function creator_info_withAccId($account_id) {
        $creator = DB::table("creators")
            ->join('users', 'users.id', '=', 'creators.user_id')
            ->where('users.account_id', '=', $account_id)
            ->get();

        return $creator;
    }

    public function join_chk($user_id, $creator_id) {
        $join = Following::select(DB::raw(1))
            ->where('user_id', '=', $user_id)
            ->where('creator_id', '=', $creator_id)
            ->where('payment_status', '=', 1)
            ->get();

        return $join;
    }

//    21.03.28 김태영, parameter Request $request 추가
    public function creatorIndex(Request $request, $account_id) {
        $this->middleware('auth');
        $this->user =  \Auth::user();


//        $creator = DB::table("creators")
//            ->join('users', 'users.id', '=', 'creators.user_id')
//            ->where('users.account_id', '=', $account_id)
//            ->get();
        $creator = $this->creator_info_withAccId($account_id);


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

            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, creators.nickname, tweets.id, tweets.include_video, tweets.file_cnt, users.account_id"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
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


//        입회 여부
        $follow = $this->join_chk(auth()->user() === null ? null : auth()->user()->id, $creator[0]->user_id);
        $follow = !empty($follow[0]) ? 1 : 0;

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
        return view('main', compact('creator', 'tweets', 'follow'));
    }

    public function timeline(Request $request, $account_id, $startTweet) {
        //21.04.20 김태영, 입회 여부 조회 추가
        //account_id 로 creaotr 정보 가져오기
        $creator = $this->creator_info_withAccId($account_id);
        //login user 의 id와 creator 의 user_id 로 입회 여부 조회
        $follow = $this->join_chk(auth()->user() === null ? null : auth()->user()->id, $creator[0]->user_id);
        //1 입회, 0 미입회
        $follow = !empty($follow[0]) ? 1 : 0;

        //입회 여부에 따라 tweet 하위 이미지 가져오는 쿼리 다름
        if ($follow === 1) {
            //입회한 사용자의 경우
            $query = "tweet_images.tweet_id, tweet_images.idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path";
        }
        else {
            //입회하지 사용자의 않은 경우
            $query = "tweet_images.tweet_id, tweet_images.idx, 'noimg.png' AS path";
        }

        //main tweet
        //nowTweet -> 사용자가 click한 tweet, timeline에서 최상단에 위치
        $nowTweet = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.last_name, users.first_name, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
            ->where('users.account_id', $account_id)
            ->where('tweets.id', $startTweet)
            ->where('tweets.visible', 1)
            ->get();
        //otherTweets -> 사용자가 click한 tweet을 제외한 나머지를 등록 역순으로 조회
        $otherTweets = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.last_name, users.first_name, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
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
                //->select(DB::raw("tweet_images.tweet_id, tweet_images.idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path"))
                    //21.04.20 김태영, 입회 여부에 따라 query 가 달라지기 때문에 $query 변수로 변경
                ->select(DB::raw($query))
                ->join('users', 'users.id', '=', 'tweets.user_id')
                ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
                ->where('users.account_id', $account_id)
                ->where('tweets.id', $tweet->id)
                ->where('tweet_images.idx','<>', $tweet->main_img_idx)//무료공개 = main image는 이미 tweet 정보 가져올 때 가져옴, main image 제외하고 조회
                ->where('tweets.visible', 1)
                ->orderBy('tweet_images.idx', 'asc')
                ->get();

            $tweet_images = $tweet_images->merge($loop);
        }

        if ($request->ajax()) {
            $view = view('timelineData', compact('tweets', 'tweet_images', 'follow', 'creator'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('timeline', compact('tweets', 'tweet_images', 'follow', 'creator'));//compact 할 때 var_name이 위에 선언한 $tweets 과 이름이 같아야 된다
//        return view('timeline', [
//            'tweets' => $tweet
//        ]);
    }

    public function change_password() {
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $user = DB::table("users")
            ->where('id', '=', $this->user->id)
            ->get();

        return view('auth.passwords.change', [
            'user' => $user
        ]);
    }

    public function change_password_store(Request $request) {
        $attributes = [
            'current_password' => '現在のパスワード',
            'new_password' => '新しいパスワード',
            'new_confirm_password' => '新しいパスワード(確認)'
        ];

        $rules = [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password']
        ];

        $this->validate($request, $rules, [], $attributes);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

//        21.04.12 김태영, creator가 비밀번호 변경 후 mypage로 이동
        if (auth()->user()->hasRole('creator')){
            return redirect('/creator/mypage');
        }

        return redirect()->back();
    }

    public function change_email() {
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $user = DB::table("users")
            ->where('id', '=', $this->user->id)
            ->get();

        return view('auth.email.change', [
            'user' => $user
        ]);
    }

    public function change_email_store(Request $request) {
        $attributes = [
            'email' => '新しいメールアドレス',
            'confirm_email' => '新しいメールアドレス(確認)'
        ];

        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'confirm_email' => ['same:email']
        ];

        $this->validate($request, $rules, [], $attributes);

        //User::find(auth()->user()->id)->update(['email'=> $request->email, 'email_verified_ata'=>null,]);
        User::find(auth()->user()->id)->update(['email' => $request->email, 'email_verified_at' => null]);

//        21.04.12 김태영, creator가 email 변경 후 mypage로 이동
        if (auth()->user()->hasRole('creator')){
            return redirect('/creator/mypage');
        }

        return redirect()->back();
    }

    //입회화면 이동
    public function join($account_id) {
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $creator = $this->creator_info_withAccId($account_id);

        //이미 입회 했다면
        $already = $this->join_chk(auth()->user()->id, $creator[0]->user_id);

        if (!empty($already[0])) {
            return redirect('/'.$account_id);
        }

        return view('join', compact('creator'));
    }

    //입회하기
    public function joinStore(Request $request) {
//        21.04.19 김태영, 개발을 위해 일단 무조건 승인
        Following::create([
            'user_id' => $request->input('user_id'),
            'creator_id' => $request->input('creator_id'),
            'next_payment_date'=> date('Y-m-d', strtotime("+1 months")),
            'payment_status' => 1
        ]);

        return redirect($request->input('account_id').'/joinOk');
    }

    public function joinOk($account_id) {
        $creator = $this->creator_info_withAccId($account_id);

        return view('joinOk', compact('creator'));
    }

//    21.05.03 kondo, ファンクラブ詳細（途中）
    public function joinCreator(Request $request){
        $account_id = $request->id;
        $user = DB::table("users")
            ->where('account_id', $account_id)
            ->first();
        return view('user.fanclub',['user' => $user]);
    }
}

