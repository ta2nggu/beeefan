@extends('layouts.base')

@section('title',$creator[0]->nickname .' 投稿一覧')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- 21.03.25 김태영, 추가 owl carousel(timeline image slider) 작성 -->
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <!-- 21.03.23 김태영, 추가 timeline ajax 작성 -->
    <script src="{{ asset('js/main.js') }}" defer></script>
    <!-- 21.03.25 김태영, 추가 owl carousel(timeline image slider) 작성 -->
    <script src="{{ asset('js/owl.carousel.js') }}" defer></script>
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @section('page_back')
            <div class="formBox"><button onClick="history.back()" class="back">{{ __('戻る') }}</button></div>
        @endsection
        @slot('header_title')
            <span class="name">{{ $creator[0]->nickname }}</span>{{ __('投稿') }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap">

            @if (session('flash_message'))
                <div class="flashMsg">
                    <p>{{ session('flash_message') }}</p>
                </div>
            @endif

        {{--    <div id="post-data" class="timeline_image">--}}
        {{--    21.03.28 김태영, main.blade.php에서도 ajax infinite scrolling 같이 사용하기 위해 클래스(.post-data) 로 변경--}}
            @if(count($tweets)>=1)
                <ul id="postBox" class="timeline_image post-data">
                    @include('timelineData')
                </ul>
                <div class="ajax-load">
                    <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
                </div>
            @else
                <div class="noDateBox noDateBoxBorder"><p class="noDateText">{{ __('投稿がありません') }}</p></div>
            @endif

{{--        21.04.27 kondo footer fixed(ユーザー別)--}}
        @if( Auth::id() === $creator[0]->id)
            @component ('components.bottomFixed')
                @slot('bottomFixed_id')
                    {{ $creator[0]->account_id }}
                @endslot
            @endcomponent
        @else
            <div id="bottomPost" class="bottomFixed">
                <div class="inner">
                    <div class="nameBox">
                        <p class="name">{{ $creator[0]->nickname }}</p>
                        <p class="price">{{ __('月額') . number_format($creator[0]->month_price) .('円') }}</p>
                    </div>
                    @guest
                        <a href="{{url('/'.$creator[0]->account_id.'/join')}}" class="btnCircle btnPi">{{ __('入会する') }}</a>
                    @else
                        @role('user')
                            @if($follow === 0)
                                <a href="{{url('/'.$creator[0]->account_id.'/join')}}" class="btnCircle btnPi">{{ __('入会する') }}</a>
                            @else
                                <span class="btnCircle">{{ __('入会中です') }}</span>
                            @endif
                        @else
                        <span class="btnCircle line2">{!! 'このアカウントでは<br>入会できません' !!}</span>
                        @endrole
                    @endguest
                </div>
            </div>
        @endif
    </div><!--/contentWrap-->
@endsection
