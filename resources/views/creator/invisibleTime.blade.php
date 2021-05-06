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
    <div class="formBox"><a href="{{url('creator/invisible')}}" class="back">{{ __('戻る') }}</a></div>
@endsection
@slot('header_title')
    {{ __('下書き投稿') }}
@endslot
@endcomponent

<!--contentWrap-->
<div id="contentWrap">

    {{--    <div id="post-data" class="timeline_image">--}}
    {{--    21.03.28 김태영, main.blade.php에서도 ajax infinite scrolling 같이 사용하기 위해 클래스(.post-data) 로 변경--}}
    @if(count($tweets)>=1)
        <ul id="postBox" class="timeline_image post-data">
            @include('creator/invisibleTimeData')
        </ul>
        <div class="ajax-load">
            <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
        </div>
    @else
        <div class="noDateBox"><p class="noDateText">{{ __('下書きがありません') }}</p></div>
    @endif

    @component ('components.bottomFixed')
        @slot('bottomFixed_id')
            {{ $creator[0]->account_id }}
        @endslot
    @endcomponent
</div><!--/contentWrap-->
@endsection
