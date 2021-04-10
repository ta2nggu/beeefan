@extends('layouts.base')

@section('title','Beee Fan!')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_creator.css') }}">
@endsection
@section('body','')

@section('content')
    <header id="header">
        <a href="{{ url('/test/02-1') }}" class="back">戻る</a>
        <h1 class="txtTitle">新規投稿</h1>
    </header>
    <!--contentWrap-->
    <div id="contentWrap">
        <!--postList(parts)-->
        <div id="postCreate">
            <ul class="post">
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
                <li><a href="{{ url('test/02-2') }}"><img src="{{ asset('images/test_creater_post1.jpg') }}" alt=""></a></li>
            </ul>
            <ul class="btnBox">
                <li><a href="" class="btn">入会する</a></li>
                <li><a href="{{ url('/home') }}" class="btn">ログイン</a></li>
            </ul>
        </div>
    </div><!--/contentWrap-->
@endsection
