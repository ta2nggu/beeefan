@extends('layouts.base')

@section('title',' 登録中タイムライン')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_user.css') }}">
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
            <div class="formBox"><button onClick="history.back()" class="back userBack">{{ __('戻る') }}</button></div>
        @endsection
        @slot('header_title')
            {{ __('タイムライン') }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap">

        @if(count($tweets)>=1)
            <ul id="postBox" class="timeline_image post-data">
                @include('user.t_followingsData')
            </ul>
            <div class="ajax-load">
                <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
            </div>
        @else
            <div class="noDateBox noDateBoxBorder"><p class="noDateText">{{ __('投稿がありません') }}</p></div>
        @endif

        @component ('components.bottomFixed')
        @endcomponent
    </div><!--/contentWrap-->
@endsection
