<?php

namespace App\Http\Controllers;

use App\Models\Tweet_image;
use Illuminate\Http\Request;
use App\Models\Tweet;
use Illuminate\Support\Facades\File;

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

                //ios safari에서 투고하면 video file 이름이 "trim"
                //file 이름 앞에 unix time을 붙임
                if (explode(".", $image->getClientOriginalName())[0] === "trim") {
                    $timestamp = time();
                    $videoFileName = $timestamp."_".explode(".", $image->getClientOriginalName())[0].'.mp4';
                }
                else {
                    $videoFileName = explode(".", $image->getClientOriginalName())[0].'.mp4';
                }

                //DB tweets table 저장
                if ($i == 0) {
                    $mTweet = new Tweet();
                    $mTweet->user_id = $request->id;
                    $mTweet->msg = $request->msg;
                    $mTweet->visible = $request->visible;
                    $mTweet->file_cnt = $request->file_cnt;
                    $mTweet->include_video = $request->include_video;
                    $mTweet->main_img = explode("/", $image->getClientMimeType())[0] === "video" ? $videoFileName : $request->main_img;
                    $mTweet->main_img_mime_type = explode("/", $image->getClientMimeType())[0] === "video" ? explode("/", $image->getClientMimeType())[0].'/mp4' : $request->main_img_mime_type;
                    $mTweet->main_img_idx = $request->main_img_idx;
                    $mTweet->save();
                }

                if (explode("/", $image->getClientMimeType())[0] === "video"){
                    //video thumbnail 저장
                    $thumbnail = 'thumb_'.$videoFileName.'.jpeg';//'.png';
                    $video = $this->ffmpeg->open($image);
                    $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(0));
                    $frame->addFilter(new \FFMpeg\Filters\Frame\CustomFrameFilter('scale=640x640'));
                    if (!is_dir(storage_path('app/public/images/'.$request->id.'/'))) {
                        mkdir(storage_path('app/public/images/'.$request->id.'/'));
                    }
                    if (!is_dir(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/'))) {
                        mkdir(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/'));
                    }
                    $frame->save(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/').$thumbnail);

                    //video 저장
                    $clip = $video->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds(0), \FFMpeg\Coordinate\TimeCode::fromSeconds(10));
                    $clip->save(new \FFMpeg\Format\Video\X264(),storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/').$videoFileName);
                }
                else {
                    $image->move(storage_path('app/public/images/'.$request->id.'/'.$mTweet->id.'/'), $imageName);
                }

                //DB tweet_images table 저장
                $mImage = new Tweet_image();
                $mImage->tweet_id = $mTweet->id;
                $mImage->idx = $i;
                $mImage->name = explode("/", $image->getClientMimeType())[0] === "video" ? $videoFileName : $imageName;
                $mImage->mime_type = explode("/", $image->getClientMimeType())[0] === "video" ? explode("/", $image->getClientMimeType())[0].'/mp4' : $image->getClientMimeType();
                $mImage->private = $imgPrivate[$i];//$i === 0 ? 1 : 0;
                $mImage->save();
            }
            //temp(임시) 테이블 삭제
            File::deleteDirectory(storage_path('app/public/images/'.$request->id.'/temp/'));
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

    public function makeThumbnail(Request $request) {
        if ($request->ajax()) {
            //directory 존재 여부 체크
            if (!is_dir(storage_path('app/public/images/'.$request->creator_id.'/'))) {
                mkdir(storage_path('app/public/images/'.$request->creator_id.'/'));
            }
            if (!is_dir(storage_path('app/public/images/'.$request->creator_id.'/temp/'))) {
                mkdir(storage_path('app/public/images/'.$request->creator_id.'/temp/'));
            }

            $file = $request->file('file');
            $timestamp = time();
            $thumbnail = 'thumb_'.$timestamp.'.jpeg';

            $video = $this->ffmpeg->open($file);
            $frame = $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(0));
            $frame->addFilter(new \FFMpeg\Filters\Frame\CustomFrameFilter('scale=640x640'));
            $frame->save(storage_path('app/public/images/'.$request->creator_id.'/temp/').$thumbnail);

            $tempFilePath = $video->getPathfile();
            $duration = exec("ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $tempFilePath");
            $thumbPath = asset('storage/images/'.$request->creator_id.'/temp/'.$thumbnail);
            return compact('duration', 'thumbPath');
        }
        else{
            return dd('wrong approach');
        }
    }
}
