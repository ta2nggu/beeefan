@extends('layouts.base')

@section('title','Beee Fan!')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_creator.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap">
        <!--profile(parts)-->
        <div id="profileHeader">
            <div class="imgbox" style="background-image: url({{ asset('images/test_creater_profile_header.jpeg') }})">
                <div class="thumbnail"><img src="{{ asset('images/test_creater_profile_thumbnail.jpeg') }}" alt="クリエイターニックネーム"></div>
            </div>
        </div>
        <div id="profileBox">
            <h1 class="name">池内彩夏👗💕aya</h1>
            <p class="price">月額 3,000円<span>（税込）</span></p>
            <div class="score clm2">
                <dl>
                    <dt>投稿数</dt>
                    <dd>235</dd>
                </dl>
                <dl>
                    <dt>会員数</dt>
                    <dd>3,834</dd>
                </dl>
            </div>
            <div class="score">
                <dl>
                    <dt>総売上額（利益）</dt>
                    <dd>5,000,000<span class="gain">（4,000,000）</span><span class="period">（2021/5/21〜2021/9/18）</span></dd>
                </dl>
            </div>
            <div class="score scorePrice">
                <dl>
                    <dt>先月総売上（利益）</dt>
                    <dd>93,388<span class="gain">（74,710）</span></dd>
                </dl>
                <dl>
                    <dt>今月暫定総売上（利益）</dt>
                    <dd>103,388<span class="gain">（82,710）</span></dd>
                </dl>
            </div>
            <div class="btnBox">
                <p><a href="{{ url('test/02-1') }}" class="btn btnBor btnBorLp">公開ページを確認</a></p>
            </div>
        </div>
        <!--postList(parts)-->
        <div id="postList">
            <ul>
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
        </div>
        <div id="bottomCreatorMypage" class="bottomFixed">
            <ul class="inner">
                <li><a href="{{ url('test/03-4') }}" class="pCreate">投稿する</a></li>
                <li><a href="{{ url('test/02-2') }}" class="post">タイムライン</a></li>
                <li><a href="{{ url('test/03-2') }}" class="mypage">マイページ</a></li>
            </ul>
        </div>
    </div><!--/contentWrap-->
@endsection
