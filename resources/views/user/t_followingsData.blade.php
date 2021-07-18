<?php
function time_ago($sec) {
    $minutes = round($sec / 60);
    $hours = round($sec / 3600);//3600 is 60 minutes
    $days = round($sec / 86400);//86400 = 24 * 60 * 60
    $weeks = round($sec / 604800);//7 * 24 * 60 * 60
    $months = round($sec / 2629440);//((365 + 365 + 365 + 365 + 366) / 5 / 12) * 24 * 60 * 60
    $years = round($sec / 31553280);//(365 + 365 + 365 + 365 + 366) / 5 * 24 * 60 * 60

    if ($sec <= 60) {
        return "今";
    }
    else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1分前";
        }
        else {
            return "$minutes 分前";
        }
    }
    else if ($hours <= 24) {
        if ($hours == 1) {
            return "1時間前";
        }
        else {
            return "$hours 時間前";
        }
    }
    else if ($days <= 7) {
        if ($days == 1) {
            return "昨日";
        }
        else {
            return "$days 日前";
        }
    }
    else if ($weeks <= 4.3) {//4.3 == 52 / 12
        if ($weeks == 1) {
            return "1週間前";
        }
        else {
            return "$weeks 週間前";
        }
    }
    else if ($months <= 12) {
        if ($months == 1) {
            return "1か月前";
        }
        else {
            return "$months か月前";
        }
    }
    else if ($years == 1) {
        if ($years == 1) {
            return "1年前";
        }
        else {
            return "$years 年前";
        }
    }
}
?>
@foreach($tweets as $tweet)
    <li class="post">
        <div class="tweet_top">
            <div class="postTitle">
                <div class="thumbnail">
                    <a href="{{url($tweet->account_id)}}">
                        @if (isset($tweet->profile_img))
                            <img src="{{ asset('storage/images/'.$tweet->creator_id.'/'.$tweet->profile_img) }}" alt="{{ $tweet->nickname }}">
                        @else
                            <img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $tweet->nickname }}">
                        @endif
                    </a>
                </div>
                <div class="nameBox">
                    <p class="name">{{ $tweet->nickname }}</p>
                    <p class="time">
                        @php
                            echo time_ago($tweet->past_time);
                        @endphp
                    </p>
                </div>
            </div>
        </div>
        <div class="owl-carousel owl-theme">
            <div class="postImgBox">
                @if (explode('/', $tweet->mime_type)[0] === 'image')
                    <img src="{{ asset('storage/images/'.$tweet->path) }}" alt="">
                @else
                    <video class="video-js vjs-default-skin vjs-big-play-centered" width="640px" height="640px"
                           controls preload='none'
                           poster="{{ asset('storage/images/'.$tweet->thumb_path) }}"
                           data-setup='{ "fluid": true, "aspectRatio":"640:640" }'>
                        <source src="{{ URL::asset('storage/images/'.$tweet->path) }}" type='{{$tweet->mime_type}}' />
                    </video>
                @endif
                @if ($tweet->file_cnt > 1)
                    <div class="counter"></div>
                @endif
            </div>
            @foreach($tweet_images as $tweet_image)
                @if($tweet->id == $tweet_image->tweet_id)
                    <div class="postImgBox">
                        @if (explode('/', $tweet_image->mime_type)[0] === 'image')
                            <img src="{{ asset('storage/images/'.$tweet_image->path) }}" alt="">
                        @else
                            <video class="video-js vjs-default-skin vjs-big-play-centered" width="640px" height="640px"
                                   controls preload='none'
                                   poster="{{ asset('storage/images/'.$tweet_image->thumb_path) }}"
                                   data-setup='{ "fluid": true, "aspectRatio":"640:640" }'>
                                <source src="{{ URL::asset('storage/images/'.$tweet_image->path) }}" type='{{$tweet_image->mime_type}}' />
                            </video>
                        @endif
                        @if ($tweet->file_cnt > 1)
                            <div class="counter"></div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <div class="textBox">
            @isset($tweet->msg)
                <div class="text moreArea">{!! $tweet->msg !!}<p class="moreBtn">続きを見る</p></div>
            @endisset
        </div>

    </li>
@endforeach
