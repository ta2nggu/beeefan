<?php

namespace App\Http\Controllers;

use App\Models\Tweet_image;
use Illuminate\Http\Request;
use App\Models\Tweet;

require '../vendor/autoload.php';

class DropController extends Controller
{
    protected $ffmpeg;
    public function __construct() {
        $this->ffmpeg =\FFMpeg\FFMpeg::create([
            'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe'
        ]);
    }

    public function store(Request $request) {
        //21.05.02 김태영, 분기
        //신규투고
        if ($request->editMode === "0") {
            $images = $request->file('file');
            $imgPrivate = $request->private;
            $imgPrivate = explode(",", $imgPrivate);

            if (!is_array($images)) {
                $images = [$images];
            }

            for ($i = 0; $i < count($images); $i++) {
                $image = $images[$i];
                $imageName = $image->getClientOriginalName();

                if ($i == 0) {
                    $mTweet = new Tweet();
                    $mTweet->user_id = $request->id;
                    $mTweet->msg = $request->msg;
                    $mTweet->visible = $request->visible;
                    $mTweet->file_cnt = $request->file_cnt;
                    $mTweet->include_video = $request->include_video;
                    $mTweet->main_img = explode("/", $image->getClientMimeType())[0] === "video" ? explode(".", $image->getClientOriginalName())[0].'.mp4' : $request->main_img;
                    $mTweet->main_img_mime_type = $request->main_img_mime_type;
                    $mTweet->main_img_idx = $request->main_img_idx;
                    $mTweet->save();
                }

                //21.07.04 김태영, video thumbnail
                if (explode("/", $image->getClientMimeType())[0] === "video"){
                    $thumbnail = 'thumb_'.explode(".", $image->getClientOriginalName())[0].'.jpeg';//'.png';
                    $video = $this->ffmpeg->open($image);
                    $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(0));
                    $frame->addFilter(new \FFMpeg\Filters\Frame\CustomFrameFilter('scale=640x640'));
                    if (!is_dir(storage_path('app/public/images/'.$request->id.'/'))) {
                        mkdir(storage_path('app/public/images/'.$request->id.'/'));
                    }
                    if (!is_dir(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/'))) {
                        //mkdir($path, 0777, true);
                        mkdir(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/'));
                    }
                    $frame->save(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/').$thumbnail);

//                    $video->save(new \FFMpeg\Format\Video\X264(), storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/').explode(".", $image->getClientOriginalName())[0].'.mp4');
                    $clip = $video->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds(0), \FFMpeg\Coordinate\TimeCode::fromSeconds(10));
//                    $clip->filters()->resize(new \FFMpeg\Coordinate\Dimension(320, 240), \FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_INSET, true);
                    $clip->save(new \FFMpeg\Format\Video\X264(),storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/').explode(".", $image->getClientOriginalName())[0].'.mp4');

                }
                else {
                    $image->move(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/'), $imageName);
                }

                $mImage = new Tweet_image();
                $mImage->tweet_id = $mTweet->id;
                $mImage->idx = $i;
                $mImage->name = $imageName;
                $mImage->mime_type = $image->getClientMimeType();
                $mImage->private = $imgPrivate[$i];//$i === 0 ? 1 : 0;
                $mImage->save();
            }
        }
        //투고 편집
        else {
            $images = $request->file('file');
            $imgPrivate = $request->private;
            $imgPrivate = explode(",", $imgPrivate);

            $tweet_image_id = $request->tweet_image_id;
            $tweet_image_id = explode(",", $tweet_image_id);

            if (!is_array($images)) {
                $images = [$images];
            }

            $param = [
                'visible' => $request->visible,
                'msg' => $request->msg,
                'main_img' => $request->main_img,
                'main_img_mime_type' => $request->main_img_mime_type,
                'main_img_idx' => $request->main_img_idx,
            ];

            tweet::find($request->tweet_id)->update($param);

            for ($i = 0; $i < count($images); $i++) {
                $mparam = [
                    'private' => $imgPrivate[$i],
                ];

                $tweet_images=new Tweet_image();
                $tweet_images->find($tweet_image_id[$i])->update($mparam);
            }
        }

    }
}
