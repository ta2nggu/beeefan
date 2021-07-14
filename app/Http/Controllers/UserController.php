<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\Following;
use App\Models\Notice;
use App\Models\Remove_follow;
use App\Models\tweet;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(){
//        21.04.06 김태영, 생성자에 role check 제거, 비 로그인 user 에게도 보여주기 위함
//        $this->middleware('role:user|administrator|creator');
    }

    public function userIndex(Request $request){
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $creators = Following::join('creators', 'creators.user_id', '=', 'followings.creator_id')
//                                21.05.02 kondo,account_id取得の為にjoin追加
                                ->join('users', 'users.id', '=', 'creators.user_id')
                                ->where('followings.user_id', '=', $this->user->id)
                                ->orderby('creators.nickname', 'asc')
                                ->paginate(5);

        //21.05.10 김태영, 공지사항 추가
        $notices = Notice::orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            $view = view('user.indexData', compact( 'creators', 'notices'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('user.index', [
            'user' => $this->user,
            'creators' => $creators,
            'notices' => $notices
        ]);
    }

    public function creator_info_withAccId($account_id) {
        $creator = DB::table("creators")
            ->join('users', 'users.id', '=', 'creators.user_id')
            ->where('users.account_id', '=', $account_id)
            //21.05.12 김태영, 비공개된 creator 제외
            ->where('creators.visible', '=', 1)
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

            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, creators.nickname, tweets.id, tweets.include_video, tweets.file_cnt, users.account_id, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweets.main_img, '.', 1), '.jpeg') AS thumb_path, SUBSTRING_INDEX(main_img_mime_type, '/', 1) AS main_img_mime_type"))
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
        if(!$creator->count()) {
            return abort(404);
        }
        //login user 의 id와 creator 의 user_id 로 입회 여부 조회
        $follow = $this->join_chk(auth()->user() === null ? null : auth()->user()->id, $creator[0]->user_id);
        //1 입회, 0 미입회
        $follow = !empty($follow[0]) ? 1 : 0;
        //입회 여부에 따라 tweet 하위 이미지 가져오는 쿼리 다름
        //21.05.25 kondo, クリエイター自身とadmin/saは「follow = 1」に（ログインしているか判定）
        if (Auth::check()) {
            $user = \Auth::user();
            if($creator[0]->id == $user->id || $user->hasRole('superadministrator|administrator')){
                $follow = 1;
            }
        }
        if ($follow === 1) {
            //입회한 사용자의 경우
            $query = "tweet_images.tweet_id, tweet_images.idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path, tweet_images.mime_type, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweet_images.name, '.', 1), '.jpeg') AS thumb_path";
        }
        else {
            //입회하지 사용자의 않은 경우
            $query = "tweet_images.tweet_id, tweet_images.idx, 'noimg.png' AS path, tweet_images.mime_type, 'noimg.png' AS thumb_path";
        }

        //main tweet
        //nowTweet -> 사용자가 click한 tweet, timeline에서 최상단에 위치
        $nowTweet = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.last_name, users.first_name, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time, tweet_images.mime_type, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweets.main_img, '.', 1), '.jpeg') AS thumb_path"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
            ->join("tweet_images",function($join){
                $join->on("tweet_images.tweet_id", "=", "tweets.id")
                    ->on("tweet_images.idx", "=", "tweets.main_img_idx");
            })
            ->where('users.account_id', $account_id)
            ->where('tweets.id', $startTweet)
            ->where('tweets.visible', 1)
            ->get();
        //otherTweets -> 사용자가 click한 tweet을 제외한 나머지를 등록 역순으로 조회
        $otherTweets = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.last_name, users.first_name, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time, tweet_images.mime_type, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweets.main_img, '.', 1), '.jpeg') AS thumb_path"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
            ->join("tweet_images",function($join){
                $join->on("tweet_images.tweet_id", "=", "tweets.id")
                    ->on("tweet_images.idx", "=", "tweets.main_img_idx");
            })
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

    public function timeline_followings(Request $request) {
        $tweets = DB::table('followings', 'f')
            ->select(DB::raw("users.last_name, users.first_name, users.account_id, creators.user_id as creator_id, creators.profile_img, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('tweets', 'tweets.user_id', '=', 'f.creator_id')
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
            ->where('f.user_id', \Auth::user()->id)
            ->where('tweets.visible', 1)
            ->orderBy('tweets.id', 'desc')
            ->paginate(3);

        $tweet_images = new \Illuminate\Support\Collection;
        foreach ($tweets as $tweet) {
            $loop = DB::table('tweets', 'tweets')
                ->select(DB::raw("tweet_images.tweet_id, tweet_images.idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path"))
                ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
                ->where('tweets.id', $tweet->id)
                ->where('tweet_images.idx','<>', $tweet->main_img_idx)//무료공개 = main image는 이미 tweet 정보 가져올 때 가져옴, main image 제외하고 조회
                ->where('tweets.visible', 1)
                ->orderBy('tweet_images.idx', 'asc')
                ->get();

            $tweet_images = $tweet_images->merge($loop);
        }

        if ($request->ajax()) {
            $view = view('user.t_followingsData', compact('tweets', 'tweet_images'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('user.t_followings', compact('tweets', 'tweet_images'));
    }

    public function change_password($admin_id) {
        $this->middleware('auth');
        $this->user =  \Auth::user();

//        21.05.09 김태영, super admin이 admin의 email 변경할 때 추가
        $selectId = $admin_id === 'change' ? $this->user->id : $admin_id;

        $user = DB::table("users")
            ->where('id', '=', $selectId)
            ->get();

        //21.05.10 김태영, 관리자 삭제 이후 뒤로가기로 돌아와서 다시 누를까봐..
        if(count($user) === 0) {
            if (auth()->user()->hasRole('creator')){
                return redirect('/creator/mypage');
            }
            else if (auth()->user()->hasRole('superadministrator')) {
                return redirect('/admin/admins/list');
            }
        }

        return view('auth.passwords.change', [
            'user' => $user
        ]);
    }

    public function change_creator_password($creator_id) {
        $user = DB::table("users")
            ->where('id', '=', $creator_id)
            ->get();

        //21.05.10 김태영, 관리자 삭제 이후 뒤로가기로 돌아와서 다시 누를까봐..
        if(count($user) === 0) {
            if (auth()->user()->hasRole('superadministrator')) {
                return redirect('/admin/index');
            }
        }

        $redirect_url = '/admin/index';

        return view('auth.passwords.change', [
            'user' => $user,
            'redirect_url' => $redirect_url
        ]);
    }

    public function change_password_store(Request $request) {
        // 21.05.09 김태영, super admin이 admin의 email->password 변경할 때 추가
        $id = $request->has('target_id') ? $request->target_id : auth()->user()->id;
        $user = User::find($id);
        $changerId = \Auth::user()->id;

        $attributes = [
            'current_password' => '現在のパスワード',
            'new_password' => '新しいパスワード',
            'new_confirm_password' => '新しいパスワード(確認)'
        ];

        //target_id 가 존재한다면, admin이 admin이나 creator 의 비밀번호를 바꾸는 경우
        if ($id = $request->has('target_id')) {
            if (Hash::check($request->current_password, $user->password)) {
                $rules = [
                //'current_password' => ['required', new MatchOldPassword],
                    'new_password' => ['required', 'min:8'],
                    'new_confirm_password' => ['same:new_password']
                ];
                $this->validate($request, $rules, [], $attributes);

                if ($user != null) {
                    $user->update(['password'=> Hash::make($request->new_password)]);
                }
                //自分以外
                if ($request->target_id != $changerId) {
                    //21.04.12 김태영, creator가 비밀번호 변경 후 mypage로 이동
                    if ($user->hasRole('creator')) {
                        \Session::flash('flash_message', '「' . $user->last_name . ' ' . $user->first_name . '」さんのパスワードを変更しました。');
                        return redirect(route('admin'));
                    } else if ($user->hasRole('administrator')) {
                        \Session::flash('flash_message', '「' . $user->last_name . ' ' . $user->first_name . '」さんのパスワードを変更しました。');
                        return redirect('/admin/admins/list');
                    }
                }else{
                    if ($user->hasRole('superadministrator|administrator')) {
                        return redirect(route('admin'))->with('flash_message','パスワードを変更しました');
                    }
                }
                return redirect()->back();
            }
            else {
                return Redirect::back()->withErrors('入力したパスワードを確認してください。');
            }
        }
        else {
            //자신의 id의 비밀번호를 바꾸는 경우
            $rules = [
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => ['required', 'min:8'],
                'new_confirm_password' => ['same:new_password']
            ];

            $this->validate($request, $rules, [], $attributes);

            if ($user != null) {
                $user->update(['password'=> Hash::make($request->new_password)]);
            }
            //21.04.12 김태영, creator가 비밀번호 변경 후 mypage로 이동
            if ($user->hasRole('creator')){
                return redirect(route('creator'))->with('flash_message','パスワードを変更しました');
            }elseif ($user->hasRole('superadministrator|administrator')){
                return redirect(route('admin'))->with('flash_message','パスワードを変更しました');
            }elseif ($user->hasRole('user')){
                return redirect(route('userIndex'))->with('flash_message','パスワードを変更しました');
            }
            return redirect()->back();
        }

    }

    public function change_email($admin_id) {
        $this->middleware('auth');
        $this->user =  \Auth::user();

//        21.05.09 김태영, super admin이 admin의 email 변경할 때 추가
        $selectId = $admin_id === 'change' ? $this->user->id : $admin_id;
        $user = DB::table("users")
            ->where('id', '=', $selectId)
            ->get();

        //21.05.10 김태영, 관리자 삭제 이후 뒤로가기로 돌아와서 다시 누를까봐..
        if(count($user) === 0) {
            if (auth()->user()->hasRole('creator')){
                return redirect('/creator/mypage');
            }
            else if (auth()->user()->hasRole('superadministrator')) {
                return redirect('/admin/admins/list');
            }
        }

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

//        21.05.24 kondo, 自分
        $changerId =  \Auth::user()->id;

//        21.05.09 김태영, super admin이 admin의 email 변경할 때 추가
        $id = $request->has('admin_id') ? $request->admin_id : auth()->user()->id;
        $user = User::find($id);

        if ($user != null) {
            $user->update(['email' => $request->email, 'email_verified_at' => null]);
        }
        //21.05.10 김태영, email update 후 인증 메일 전송
//        $user->sendEmailVerificationNotification_change();

//        21.04.12 김태영, creator가 email 변경 후 mypage로 이동
//        if (auth()->user()->hasRole('creator')) {
//            return redirect('/email/verify')->with('flash_message');
//        }
        if (auth()->user()->hasRole('superadministrator')) {
            if($user->hasRole('administrator')){
                \Session::flash('flash_message','「'.$user->last_name.' '.$user->first_name.'」さんのメールアドレスを変更しました。ログイン後にメールアドレスの承認が必要です。');
                return redirect('/admin/admins/list');
            }
        }
        return redirect('/email/verify')->with('flash_message','メッセージ表示');
        return redirect()->back();
    }

    //입회화면 이동
    public function join($account_id) {
        $this->middleware('auth');
        $creator = $this->creator_info_withAccId($account_id);
        if(\Auth::user()){
            $this->user =  \Auth::user();
            if($this->user->hasRole('superadministrator|administrator')) {
                return redirect(route('admin'))->with('flash_message','このアカウントではアクセスできません');
            }elseif($this->user->hasRole('creator')) {
                return redirect(route('creator'))->with('flash_message','このアカウントではアクセスできません');
            }
        }else{
            return view('joinLogin', compact('creator'));
        }
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

        //21.05.11 김태영, creators table에 follower_cnt 회원수 field 추가
        Creator::where('user_id', $request->input('creator_id'))->increment('follower_cnt');

        return redirect($request->input('account_id').'/joinOk');
    }

    public function joinOk($account_id) {
        $creator = $this->creator_info_withAccId($account_id);

        return view('joinOk', compact('creator'));
    }

//    21.05.03 kondo, 登録中のファンクラブ詳細
    public function joinFc($account_id){
//        $creator = User::where('account_id','=',$account_id)->first();
        $this->middleware('auth');
        $this->user =  \Auth::user();
        $creator = DB::table("users")
            ->join("creators","creators.user_id","=","users.id")
            ->where('users.account_id', '=', $account_id)
            ->get();
        //入会してなければクリエイター公開ページにリダイレクト
        $already = $this->join_chk(auth()->user()->id, $creator[0]->user_id);
        if (!empty($already[0])) {
            return view('user.fc',compact('creator'));
        }else{
            return redirect('/'.$creator[0]->account_id);
        }
    }
//    21.05.10 kondo, 登録中のファンクラブ退会
//    view
    public function removeFc($account_id){
        $this->middleware('auth');
        $this->user =  \Auth::user();
        $creator = DB::table("users")
            ->join("creators","creators.user_id","=","users.id")
            ->where('users.account_id', '=', $account_id)
            ->get();
        //入会してなければクリエイター公開ページにリダイレクト
        $already = $this->join_chk(auth()->user()->id, $creator[0]->user_id);
        if (!empty($already[0])) {
            return view('user.fcRemove',compact('creator'));
        }else{
            return redirect('/'.$creator[0]->account_id);
        }
    }
//    post
    public function removeFcForm(Request $request){
        $validated = $request->validate([
            'cause' => 'required',
        ]);
        Remove_follow::create([
            'user_id' => $request->user_id,
            'creator_id' => $request->creator_id,
            'cause' => $request->cause,
            'content' => $request->input('content'),
        ]);
        $creator = Creator::where('user_id','=',$request->creator_id)->first();
        $creator->decrement('follower_cnt');
        $follow = Following::where('user_id', $request->user_id)->where('creator_id', $request->creator_id)->first();
        $follow->delete();
        return redirect(url('/mypage'))->with('flash_message','“'.$creator->nickname.'”の退会が完了しました。 ご利用いただき誠にありがとうございました。');
    }

//    21.05.12 kondo, beeefan退会（ユーザーのみアカウント削除）
//    view
    public function removeAccount(){
        $this->middleware('auth');
        $this->user =  \Auth::user();
        return view('removeAccount',[
            'user' => $this->user,
        ]);
    }
//    post
    public function removeAccountForm(Request $request){
        $follow = Following::where('user_id','=',$request->user_id)->first();
        if($follow){
            return redirect(url('/remove'))->with('flash_message',"入会中のファンクラブがあります。\n当サイトの退会前にマイページから各ファンクラブの退会手続きを行ってください。");
        }
        $user = User::find($request->user_id);
        $user->delete();
        return redirect(route('exit.show'));
    }
//    accountExit view
    public function accountExit(){
        return view('exit');
    }
}

