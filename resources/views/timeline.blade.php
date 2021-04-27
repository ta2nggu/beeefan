@extends('layouts.base')

@section('title','Beee Fan!')
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
{{--    <div id="post-data" class="timeline_image">--}}
{{--    21.03.28 김태영, main.blade.php에서도 ajax infinite scrolling 같이 사용하기 위해 클래스(.post-data) 로 변경--}}
    <div class="timeline_image post-data">
        @include('timelineData')
    </div>

    <div class="ajax-load text-center">
        <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
    </div>
@endsection
