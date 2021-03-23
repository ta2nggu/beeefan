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
    <div class="tweet">
        <div class="tweet_top">
            <div class="tweet_name">
                {{ $tweet->name }} / {{ $tweet->nickname }}
            </div>
            <div class="tweet_time">
                @php
                    echo time_ago($tweet->past_time);
                @endphp
            </div>
        </div>
        <div class="tweet_img">
            <img class="img-thumbnail" src="{{ asset('storage/images/'.$tweet->path) }}"/>
        </div>
        <div class="tweet_bottom">
            {{ $tweet->msg }}
        </div>
    </div>
@endforeach
