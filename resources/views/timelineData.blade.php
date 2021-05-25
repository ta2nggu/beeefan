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
                    <a href="{{url($creator[0]->account_id)}}">
                        @if (isset($creator[0]->profile_img))
                            <img src="{{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }}" alt="{{ $creator[0]->nickname }}">
                        @else
                            <img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $creator[0]->nickname }}">
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
{{--                    <video class="video-js" controls poster="#" playsinline autoplay loop preload="auto" width="640px" height="267px" src="{{ asset('storage/images/'.$tweet->path) }}"></video>--}}
                    <video id="my_video_1" class="video-js" width="640px" height="267px"
                           controls preload="none"
{{--                           poster='http://video-js.zencoder.com/oceans-clip.jpg'--}}
                           poster=""
{{--                           data-setup='{ "fluid": true, "aspectRatio":"640:267", "playbackRates": [1, 1.5, 2] }'>--}}
                           data-setup='{ "fluid": true, "aspectRatio":"640:267" }'>
                        <source src="{{ asset('storage/images/'.$tweet->path) }}" type='{{$tweet->mime_type}}' />
{{--                        <source src="https://vjs.zencdn.net/v/oceans.webm" type='video/webm' />--}}
                    </video>
                @endif
{{--                @if ($tweet->file_cnt > 1)<div class="counter" style="position: absolute; top: 0px; left: 250px; color: white; background-color: rgba(16,16,16,0.5);">{{ __('1 / ') }}{{ $tweet->file_cnt }}</div>@endif--}}
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
                        <img src="{{ asset('storage/images/'.$tweet_image->path) }}" alt="">
                    @endif
                    @if ($tweet->file_cnt > 1)
                        <div class="counter"></div>
                    @endif
                    {{-- 21.04.20 김태영, $follow === 0 미입회 user 일 때 img tag 위에 가입 안내 div 표시 --}}
                    @if($follow === 0)
                        <div class="secretBox">
                            <div class="inner">
                                <p>このコンテンツを観るには<br>ファンクラブへの入会が必要です。</p>
                                <ul class="btnBox">
                                    <li><a href="../../{{ $creator[0]->account_id }}{{ __('/join') }}" class="btn">入会する</a></li>
                                    <li><a href="{{ url('/home') }}" class="btn">ログイン</a></li>
                                </ul>
                                <p><a href="" target="_blank">支払い方法について</a></p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>

{{--        21.05.06 kondo,投稿したcreatorのみ編集可能--}}
    @if( Auth::id() === $creator[0]->id)
        <a class="editBtn"
           data-toggle="modal"
           data-target="#edit{{$tweet->id}}"><img src="{{ asset('storage/icon/icon_leader.png') }}" alt="{{__('編集')}}"></a>
        <div class="modal fade postEditBox" id="edit{{$tweet->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-bottom" role="document">
                <div class="modal-content">
                    <div class="modal-body postEditLink">
                        <ul>
                            <li><p class="postEditDelete">{{ __('削除') }}</p></li>
                            <li><a href="/creator/edit/{{$tweet->id}}">{{__('編集')}}</a></li>
                            <li><p class="postEditInvisible">{{ __('下書きに戻す') }}</p></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">{{__('キャンセル')}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!--削除ポップアップ-->
        <div class="modal fade warningBox warningDre" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="titleText">コンテンツを削除</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-warning">
                        <p>コンテンツは投稿から削除されます。コンテンツは一度削除したら取り消せません。削除してもよろしいですか？</p>
                    </div>
                    <form action="{{ __('/creator/delTweetPost') }}" method="POST" class="formBox normalFormBox">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $creator[0]->user_id }}">
                        <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                        <ul class="btnBox modal-footer">
                            <li><button type="submit" class="btn btnSS btnCircle btnBk">{{ __('はい') }}</button></li>
                            <li><button type="button" class="btn btnSS btnCircle" data-dismiss="modal">{{ __('いいえ') }}</button></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>

        <!--下書きポップアップ-->
        <div class="modal fade warningBox warningInvi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="titleText">下書きに戻す</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-warning">
                        <p>コンテンツを下書きに戻しますか?下書き一覧から再度公開することも可能です。戻してもよろしいですか？</p>
                    </div>
                    <form action="{{ __('/creator/ChangeTweetInvisible') }}" method="POST" class="formBox normalFormBox">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $creator[0]->user_id }}">
                        <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                        <ul class="btnBox modal-footer">
                            <li><button type="submit" class="btn btnSS btnCircle btnBk">{{ __('はい') }}</button></li>
                            <li><button type="button" class="btn btnSS btnCircle" data-dismiss="modal">{{ __('いいえ') }}</button></li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="textBox">
        <div class="text moreArea">{{ $tweet->msg }}</div>
    </div>

</li>
@endforeach
