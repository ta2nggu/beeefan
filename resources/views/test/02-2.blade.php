@extends('layouts.base')

@section('title','Beee Fan!')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','p')

@section('content')
    <header id="header">
        <a href="{{ url('/test/02-1') }}" class="back">戻る</a>
        <h1 class="txtTitle"><span class="name">池内彩夏👗💕aya</span>投稿</h1>
    </header>

    <!--contentWrap-->
    <div id="contentWrap">
        <ul id="postBox">
            <li class="post">
                <div class="postTitle">
                    <div class="thumbnail"><img src="{{ asset('images/test_creater_profile_thumbnail.jpeg') }}" alt="クリエイターニックネーム"></div>
                    <div class="nameBox">
                        <p class="name">池内彩夏👗💕aya</p>
                        <p class="time">2時間前</p>
                    </div>
                </div>
                <ul class="postContent">
                    <li><img src="{{ asset('images/test_creater_profile_thumbnail.jpeg') }}" alt=""></li>
                </ul>
                <div class="textBox">
                    <p class="text moreArea">ライブ配信やInstagramでは公開していないコンテンツをミーグラムで発信していこうと思います👧🏼💕<br>
                        男の子も女の子もみーんな集合💖たくさん交流しましょ💖<br>
                        ライブ配信やInstagramでは公開していないコンテンツをミーグラムで発信していこうと思います👧🏼💕<br>
                        男の子も女の子もみーんな集合💖たくさん交流しましょ💖<span class="moreBtn">..続きを読む</span></p>
                </div>
            </li>
            <li class="post">
                <div class="postTitle">
                    <div class="thumbnail"><img src="{{ asset('images/test_creater_profile_thumbnail.jpeg') }}" alt="クリエイターニックネーム"></div>
                    <div class="nameBox">
                        <p class="name">池内彩夏👗💕aya</p>
                        <p class="time">2時間前</p>
                    </div>
                </div>
                <ul class="postContent">
                    <li class="secretBox">
                        <div class="inner">
                            <p>このコンテンツを観るには<br>ファンクラブへの入会が必要です。</p>
                            <ul class="btnBox">
                                <li><a href="" class="btn">入会する</a></li>
                                <li><a href="{{ url('/home') }}" class="btn">ログイン</a></li>
                            </ul>
                            <p><a href="" target="_blank">支払い方法について</a></p>
                        </div>
                    </li>
                </ul>
                <div class="textBox">
                    <p class="text moreArea">ライブ配信やInstagramでは公開していないコンテンツをミーグラムで発信していこうと思います👧🏼💕<br>
                        男の子も女の子もみーんな集合💖たくさん交流しましょ💖<br>
                        ライブ配信やInstagramでは公開していないコンテンツをミーグラムで発信していこうと思います👧🏼💕<br>
                        男の子も女の子もみーんな集合💖たくさん交流しましょ💖<span class="moreBtn">..続きを読む</span></p>
                </div>
            </li>
        </ul>
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
