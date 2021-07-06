<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\Image;
use App\Models\tweet;
use App\Models\Tweet_image;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CreatorController extends Controller
{
    public function __construct(){
        $this->middleware('role:creator');
    }

    public function getCreatorInfoWithUserId($user_id) {
        $user = DB::table("users")
            ->join('creators', 'creators.user_id', '=', 'users.id')
            ->where('users.id', '=', $user_id)
            ->get();

        return $user;
    }

    public function index(Request $request){
        $this->middleware('auth');
        $this->user =  \Auth::user();

//        $user = DB::table("users")
//            ->join('creators', 'creators.user_id', '=', 'users.id')
//            ->where('users.id', '=', $this->user->id)
//            ->get();
        $user = $this->getCreatorInfoWithUserId($this->user->id);

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
            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, tweets.id, tweets.include_video, tweets.file_cnt, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweets.main_img, '.', 1), '.png') AS thumb_path, SUBSTRING_INDEX(main_img_mime_type, '/', 1) AS main_img_mime_type"))
            ->where('tweets.user_id', $this->user->id)
            ->where('tweets.visible', 1)
            ->orderBy('tweets.id', 'desc')
            ->paginate(15);

        if ($request->ajax()) {
            $view = view('creator.indexData', compact( 'user', 'tweets'))->render();
            return response()->json(['html'=>$view]);
        }

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

//    21.04.08 김태영, 크리에이터 mypage 추가
    public function creatorSetting(){
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $user = DB::table("users")
            ->join('creators', 'creators.user_id', '=', 'users.id')
            ->where('account_id', '=', $this->user->account_id)
            ->get();

        return view('creator.setting', [
            'user' => $user
        ]);
    }

    public function creatorSetting_store(Request $request) {

        $this->middleware('auth');
        $this->user =  \Auth::user();

        $background_imgName = '';
        $profile_imgName = '';

        if ($request->hasFile('background_img')) {
            //  Let's do everything here
            if ($request->file('background_img')->isValid()) {
//                $validated = $request->validate([
//                    'name' => 'string|max:40',
//                    'image' => 'mimes:jpeg,png|max:1014',
//                ]);
                $image = $request->file('background_img');
                $background_imgName = $image->getClientOriginalName();
                $image->move(storage_path('app/public/images/'.$this->user->id), $background_imgName);

                //참고 https://mactavish10101.medium.com/how-to-upload-images-in-laravel-7-7a7f9982ebba
//                $extension = $request->image->extension();
//                $request->image->storeAs('/public', $validated['name'].".".$extension);
//                $url = Storage::url($validated['name'].".".$extension);
//                $file = File::create([
//                    'name' => $validated['name'],
//                    'url' => $url,
//                ]);
//                Session::flash('success', "Success!");
//                return \Redirect::back();

//                User::where('id', $this->user->id)
//                21.04.17 김태영, background_img field table 이동 Users -> Creators
                Creator::where('user_id', $this->user->id)
                    ->update(['background_img' => trim($background_imgName) === "" ? NULL : $background_imgName]);
            }
        }
//        abort(500, 'Could not upload image :(');

        if ($request->hasFile('profile_img')) {
            //  Let's do everything here
            if ($request->file('profile_img')->isValid()) {
                $image = $request->file('profile_img');
                $profile_imgName = $image->getClientOriginalName();
                $image->move(storage_path('app/public/images/'.$this->user->id), $profile_imgName);
            }

//            User::where('id', $this->user->id)
//            21.04.17 김태영, background_img field table 이동 Users -> Creators
            Creator::where('user_id', $this->user->id)
                ->update(['profile_img'=>trim($profile_imgName) === "" ? NULL : $profile_imgName]);
        }

//        User::where('id', $this->user->id)
//            21.04.17 김태영, background_img field table 이동 Users -> Creators
        User::where('id', $this->user->id)
            ->update(['last_name'=>$request->input('last_name'),
                'first_name'=>$request->input('first_name')]);
        Creator::where('user_id', $this->user->id)
            ->update(['nickname'=>$request->input('nickname'),
                    'instruction'=>$request->input('instruction')]);

////        정보 수정 후 index 화면으로 이동
//        $user = DB::table("users")
//            ->where('account_id', '=', $this->user->account_id)
//            ->get();
//
//        $tweets = DB::table('tweets', 'tweets')
//            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, tweets.id, tweets.include_video, tweets.file_cnt"))
//            ->where('tweets.user_id', $this->user->id)
//            ->where('tweets.visible', 1)
//            ->orderBy('tweets.id', 'desc')
//            ->get();
//
//        return view('creator.index', [
//            'user' => $user,
//            'tweets' => $tweets
//        ]);
//        21.04.17 김태영, redirect 직접 url 호출로 변경
        return redirect(route('creator'))->with('verified', true)->with('flash_message','プロフィールの変更が完了しました');
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

    //21.04.29 김태영, 비공개 투고 list 화면으로
    public function invisibleTweets(Request $request) {
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $user = $this->getCreatorInfoWithUserId($this->user->id);

        $tweets = DB::table('tweets', 'tweets')
            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, tweets.id, tweets.include_video, tweets.file_cnt"))
            ->where('tweets.user_id', $this->user->id)
            ->where('tweets.visible', 0)//0 비공개
            ->orderBy('tweets.id', 'desc')
            ->paginate(15);

        if ($request->ajax()) {
            $view = view('creator.invisibleTweetsData', compact( 'tweets','user'))->render();
            return response()->json(['html'=>$view]);
        }

        return view('creator.invisibleTweets', [
            'user' => $user,
            'tweets' => $tweets
        ]);
    }

    public function invisibleTweetsTime(Request $request, $startTweet) {
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $creator = DB::table("creators")
            ->join('users', 'users.id', '=', 'creators.user_id')
            ->where('users.id', '=', $this->user->id)
            ->get();

        //main tweet
        //nowTweet -> 사용자가 click한 tweet, timeline에서 최상단에 위치
        $nowTweet = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.last_name, users.first_name, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
            ->where('users.id', $this->user->id)
            ->where('tweets.id', $startTweet)
            ->where('tweets.visible', 0)//0 비공개
            ->get();
        //otherTweets -> 사용자가 click한 tweet을 제외한 나머지를 등록 역순으로 조회
        $otherTweets = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.last_name, users.first_name, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
            ->where('users.id', $this->user->id)
            ->where('tweets.id','<>', $startTweet)
            ->where('tweets.visible', 0)
            ->orderBy('tweets.id', 'desc')
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
                ->where('users.id', $this->user->id)
                ->where('tweets.id', $tweet->id)
                ->where('tweet_images.idx','<>', $tweet->main_img_idx)//무료공개 = main image는 이미 tweet 정보 가져올 때 가져옴, main image 제외하고 조회
//                ->where('tweets.visible', 1) -> 어차피 비공개 0 으로 가져옴
                ->orderBy('tweet_images.idx', 'asc')
                ->get();

            $tweet_images = $tweet_images->merge($loop);
        }

        if ($request->ajax()) {
            $view = view('creator.invisibleTimeData', compact('tweets', 'tweet_images', 'creator'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('creator.invisibleTime', compact('tweets', 'tweet_images', 'creator'));//compact 할 때 var_name이 위에 선언한 $tweets 과 이름이 같아야 된다
    }

    //21.04.30 김태영, 비공개 투고 삭제
    public function delTweet(Request $request) {
        $result = tweet::where('id', $request->tweet_id)->delete();
        if ($result === 1) {
            File::deleteDirectory(storage_path('app/public/images/'.$request->user_id.'/'.$request->tweet_id));
        }
        return redirect('/creator/invisible');
    }
    //21.05.06 kondo, 공개투고 삭제
    public function delTweetPost(Request $request) {
        $this->middleware('auth');
        $this->user =  \Auth::user();
        $result = tweet::where('id', $request->tweet_id)->delete();
        if ($result === 1) {
            File::deleteDirectory(storage_path('app/public/images/'.$request->user_id.'/'.$request->tweet_id));
        }
        $url = '/'.$this->user->account_id.'/p/0';
        return redirect($url)->with('flash_message', '投稿を削除しました');
    }
    //21.05.06 kondo, 공개투고→비공개
    public function ChangeTweetInvisible(Request $request) {
        $result = tweet::where('id', $request->tweet_id)->first();
        $result->visible = 0;
        $result->save();
        return redirect('/creator/invisible')->with('flash_message', '下書きに変更しました');
    }
    //21.05.06 kondo, 비공개투고→공개
    public function ChangeTweetPost(Request $request) {
        $this->middleware('auth');
        $this->user =  \Auth::user();
        $result = tweet::where('id', $request->tweet_id)->first();
        $result->visible = 1;
        $result->save();
        $url = '/'.$this->user->account_id.'/p/'.$request->tweet_id;
        return redirect($url)->with('flash_message', '投稿しました');
    }

    public function edit(Request $request) {
        //$images = Tweet_image::select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time"))
        $images = tweet::select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) as path, tweet_images.name, tweet_images.idx, tweet_images.private, tweet_images.mime_type, tweets.id as tweet_id, tweet_images.id as tweet_image_id, tweets.msg"))
            ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
            ->where('tweets.id', $request->tweet_id)
            ->orderby('idx', 'asc')
            ->get();

//        foreach ($images as $image) {
//            $image['path'] = storage_path($image['path']);
//        }

        return view('creator.edit', compact('images'));
    }
}

