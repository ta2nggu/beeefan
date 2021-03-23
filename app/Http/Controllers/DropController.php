<?php

namespace App\Http\Controllers;

use App\Models\Tweet_image;
use Illuminate\Http\Request;
use App\Models\Tweet;

class DropController extends Controller
{
    public function store(Request $request) {
//        return dd($request);

        $images = $request->file('file');
        $imgPrivate = $request->private;
        $imgPrivate = explode(",", $imgPrivate);

        if (!is_array($images)) {
            $images = [$images];
        }

        $mTweet = new Tweet();
        $mTweet->user_id = $request->id;
        $mTweet->msg = $request->msg;
        $mTweet->visible = $request->visible;
        $mTweet->file_cnt = $request->file_cnt;
        $mTweet->include_video = $request->include_video;
        $mTweet->main_img = $request->main_img;
        $mTweet->save();

        for ($i = 0; $i < count($images); $i++) {
            $image = $images[$i];
            $imageName = $image->getClientOriginalName();
//            $image->move(storage_path('images/'.$request->id.'/'.$mTweet->id), $imageName);
            $image->move(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id), $imageName);

            $mImage = new Tweet_image();
            $mImage->tweet_id = $mTweet->id;
            $mImage->idx = $i;
            $mImage->name = $imageName;
            $mImage->mime_type = $image->getClientMimeType();
            $mImage->private = $imgPrivate[$i];//$i === 0 ? 1 : 0;
            $mImage->save();
        }
    }
}
