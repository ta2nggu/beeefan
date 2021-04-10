@extends('layouts.base')

@section('title','Beee Fan!')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
            <p class="text moreArea">ライブ配信やInstagramでは公開していないコンテンツをミーグラムで発信していこうと思います👧🏼💕<br>
                男の子も女の子もみーんな集合💖たくさん交流しましょ💖<br>
                <br>
                <a href="" target="_blank">Instagram📷</a><br>
                <a href="" target="_blank">イチナナライブ👗💕</a><span class="moreBtn ">..続きを読む</span></p>
            <div class="btnBox">
                <p><a href="" class="btn btnPi">入会する</a></p>
                <p><a href="" class="btn btnLp">マイページにログイン</a></p>
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
        <div id="bottomPost" class="bottomFixed">
            <div class="inner">
                <div class="nameBox">
                    <p class="name">池内彩夏👗💕aya</p>
                    <p class="price">月額 3,000円</p>
                </div>
                <a href="" class="btnCircle btnPi">入会する</a>
            </div>
        </div>
    </div><!--/contentWrap-->
@endsection
