<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use App\Models\Image;
use App\Models\Tweet;
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

        $tweets_cnt = DB::table('tweets', 'tweets')
            ->where('tweets.user_id', $this->user->id)
            ->where('tweets.visible', 1)
            ->count('id');

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
            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, tweets.id, tweets.include_video, tweets.file_cnt, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweets.main_img, '.', 1), '.jpeg') AS thumb_path, SUBSTRING_INDEX(main_img_mime_type, '/', 1) AS main_img_mime_type"))
            ->where('tweets.user_id', $this->user->id)
            ->where('tweets.visible', 1)
            ->orderBy('tweets.id', 'desc')
            ->paginate(15);

        if ($request->ajax()) {
            $view = view('creator.indexData', compact( 'user', 'tweets', 'tweets_cnt'))->render();
            return response()->json(['html'=>$view]);
        }
        $creator_id = $this->user->id;
        return view('creator.index', [
            'user' => $user,
            'tweets' => $tweets,
            'tweets_cnt' => $tweets_cnt
        ]);
    }

//    ????????? ????????? ????????? ??????
//    public function write(){
//        $images = Image::latest()->get();
//        return view('creator.upload', compact('images'));
//    }
    public function write(){
        return view('creator.write');
    }

//    21.04.08 ?????????, ??????????????? mypage ??????
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

                //?????? https://mactavish10101.medium.com/how-to-upload-images-in-laravel-7-7a7f9982ebba
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
//                21.04.17 ?????????, background_img field table ?????? Users -> Creators
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
//            21.04.17 ?????????, background_img field table ?????? Users -> Creators
            Creator::where('user_id', $this->user->id)
                ->update(['profile_img'=>trim($profile_imgName) === "" ? NULL : $profile_imgName]);
        }

//        User::where('id', $this->user->id)
//            21.04.17 ?????????, background_img field table ?????? Users -> Creators
        User::where('id', $this->user->id)
            ->update(['last_name'=>$request->input('last_name'),
                'first_name'=>$request->input('first_name')]);
        Creator::where('user_id', $this->user->id)
            ->update(['nickname'=>$request->input('nickname'),
                    'instruction'=>$request->input('instruction')]);

////        ?????? ?????? ??? index ???????????? ??????
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
//        21.04.17 ?????????, redirect ?????? url ????????? ??????
        return redirect(route('creator'))->with('verified', true)->with('flash_message','????????????????????????????????????????????????');
    }

//    21.03.07 ?????????, dropzone js ???????????? ??????, ?????? ?????? ??????
//    21.02.28 ?????????, ????????? ??? ?????? ????????????
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

    //21.04.29 ?????????, ????????? ?????? list ????????????
    public function invisibleTweets(Request $request) {
        $this->middleware('auth');
        $this->user =  \Auth::user();

        $user = $this->getCreatorInfoWithUserId($this->user->id);

        $tweets = DB::table('tweets', 'tweets')
            ->select(DB::raw("CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, tweets.id, tweets.include_video, tweets.file_cnt, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweets.main_img, '.', 1), '.jpeg') AS thumb_path, SUBSTRING_INDEX(main_img_mime_type, '/', 1) AS main_img_mime_type"))
            ->where('tweets.user_id', $this->user->id)
            ->where('tweets.visible', 0)//0 ?????????
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
        //nowTweet -> ???????????? click??? tweet, timeline?????? ???????????? ??????
        $nowTweet = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.last_name, users.first_name, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time, tweets.main_img_mime_type as mime_type, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweets.main_img, '.', 1), '.jpeg') AS thumb_path"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
            ->where('users.id', $this->user->id)
            ->where('tweets.id', $startTweet)
            ->where('tweets.visible', 0)//0 ?????????
            ->get();
        //otherTweets -> ???????????? click??? tweet??? ????????? ???????????? ?????? ???????????? ??????
        $otherTweets = DB::table('tweets', 'tweets')
            ->select(DB::raw("users.last_name, users.first_name, creators.nickname, tweets.id, tweets.msg, tweets.file_cnt, tweets.main_img_idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweets.main_img) AS path, TIMESTAMPDIFF(SECOND, release_at, now()) as past_time, tweets.main_img_mime_type as mime_type, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweets.main_img, '.', 1), '.jpeg') AS thumb_path"))
            ->join('users', 'users.id', '=', 'tweets.user_id')
            ->join('creators', 'creators.user_id', '=', 'tweets.user_id')
            ->where('users.id', $this->user->id)
            ->where('tweets.id','<>', $startTweet)
            ->where('tweets.visible', 0)
            ->orderBy('tweets.id', 'desc')
            ->get();
        //nowTweet + otherTweets ??????
        //forPage??? ????????? ??????, 5???
        $tweets = $nowTweet->merge($otherTweets)->forPage($request->page,5);

        $tweet_images = new \Illuminate\Support\Collection;
        foreach ($tweets as $tweet) {
            $loop = DB::table('tweets', 'tweets')
                ->select(DB::raw("tweet_images.tweet_id, tweet_images.idx, CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) AS path, tweet_images.mime_type, CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweet_images.name, '.', 1), '.jpeg') AS thumb_path"))
                ->join('users', 'users.id', '=', 'tweets.user_id')
                ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
                ->where('users.id', $this->user->id)
                ->where('tweets.id', $tweet->id)
                ->where('tweet_images.idx','<>', $tweet->main_img_idx)//???????????? = main image??? ?????? tweet ?????? ????????? ??? ?????????, main image ???????????? ??????
//                ->where('tweets.visible', 1) -> ????????? ????????? 0 ?????? ?????????
                ->orderBy('tweet_images.idx', 'asc')
                ->get();

            $tweet_images = $tweet_images->merge($loop);
        }

        if ($request->ajax()) {
            $view = view('creator.invisibleTimeData', compact('tweets', 'tweet_images', 'creator'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('creator.invisibleTime', compact('tweets', 'tweet_images', 'creator'));//compact ??? ??? var_name??? ?????? ????????? $tweets ??? ????????? ????????? ??????
    }

    //21.04.30 ?????????, ????????? ?????? ??????
    public function delTweet(Request $request) {
        $result = tweet::where('id', $request->tweet_id)->delete();
        if ($result === 1) {
            Tweet_image::where('tweet_id', $request->tweet_id)->delete();
            File::deleteDirectory(storage_path('app/public/images/'.$request->user_id.'/'.$request->tweet_id));
        }
        return redirect('/creator/invisible');
    }
    //21.05.06 kondo, ???????????? ??????
    public function delTweetPost(Request $request) {
        $this->middleware('auth');
        $this->user =  \Auth::user();
        $result = tweet::where('id', $request->tweet_id)->delete();
        if ($result === 1) {
            Tweet_image::where('tweet_id', $request->tweet_id)->delete();
            File::deleteDirectory(storage_path('app/public/images/'.$request->user_id.'/'.$request->tweet_id));
        }
        $url = '/'.$this->user->account_id.'/p/0';
        return redirect($url)->with('flash_message', '???????????????????????????');
    }
    //21.05.06 kondo, ????????????????????????
    public function ChangeTweetInvisible(Request $request) {
        $result = tweet::where('id', $request->tweet_id)->first();
        $result->visible = 0;
        $result->save();
        return redirect('/creator/invisible')->with('flash_message', '??????????????????????????????');
    }
    //21.05.06 kondo, ????????????????????????
    public function ChangeTweetPost(Request $request) {
        $this->middleware('auth');
        $this->user =  \Auth::user();
        $result = tweet::where('id', $request->tweet_id)->first();
        $result->visible = 1;
        $result->save();
        $url = '/'.$this->user->account_id.'/p/'.$request->tweet_id;
        return redirect($url)->with('flash_message', '??????????????????');
    }

    public function edit(Request $request) {
        $images = tweet::select(DB::raw("case when SUBSTRING_INDEX(tweet_images.mime_type, '/', 1) = 'video' then CONCAT(tweets.user_id, '/', tweets.id, '/thumb_', SUBSTRING_INDEX(tweet_images.name, '.', 1), '.jpeg') else CONCAT(tweets.user_id, '/', tweets.id, '/', tweet_images.name) end as path, tweet_images.name, tweet_images.idx, tweet_images.private, tweet_images.mime_type, tweets.id as tweet_id, tweet_images.id as tweet_image_id, tweets.msg"))
            ->join('tweet_images', 'tweet_images.tweet_id', '=', 'tweets.id')
            ->where('tweets.id', $request->tweet_id)
            ->orderby('idx', 'asc')
            ->get();

        return view('creator.edit', compact('images'));
    }
}

