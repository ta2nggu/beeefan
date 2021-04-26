@extends('layouts.base')

@section('title','Beee Fan!')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection
@section('body','')

@section('content')
    @component ('components.header')
    @endcomponent
{{--    <header id="header">--}}
{{--        <button onClick="history.back()" class="back">戻る</button>--}}
{{--        <h1 class="txtTitle"><span class="name">{{ $creator[0]->nickname }}</span>投稿</h1>--}}
{{--    </header>--}}

    <!--contentWrap-->
    <div id="contentWrap">
        <div id="app">

            <div id="profileHeader">
                <div class="imgbox" style="background-image: url({{ asset('storage/test/test_creater_profile_header.jpeg') }})">
                    <div class="thumbnail"><img src="{{ asset('storage/test/test_creater_profile_thumbnail.jpeg') }}" alt="クリエイターニックネーム"></div>
                </div>
            </div>
            <div class="instruction">{{ $creator[0]->instruction }}</div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div id="profileBox">
                <h1 class="name">{{ $creator[0]->nickname }}</h1>
                <p class="text moreArea">テキストが入ります<br>
                    <br>
                    <a href="" target="_blank">Instagram📷</a><br>
                    <a href="" target="_blank">イチナナライブ👗💕</a><span class="moreBtn ">..続きを読む</span></p>
                <div class="btnBox">
                    @guest
                        <p><a href="" class="btn btnPi">入会する</a></p>
                        <p><a href="{{ url('/home') }}" class="btn btnLp">マイページにログイン</a></p>
                    @else
                        @role('user')
                            <p><a href="" class="btn btnPi">入会する</a></p>
                        @else
                            <p><span class="btn line2">このアカウントでは<br>入会できません</span></p>
                        @endrole
                        @if( Auth::id() === $creator[0]->id)
                            <p><a href="{{ url('/creator/index') }}" class="btn btnLp">マイページへ</a></p>
                        @endif
                    @endguest
                </div>
            </div>

            <img id="preview_background_img" src="@if (isset($creator[0]->background_img)) {{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->background_img) }} @else https://www.riobeauty.co.uk/images/product_image_not_found.gif @endif" style="height: 100%; width: 100%;"/>
            <img id="preview_profile_img" src="@if (isset($creator[0]->profile_img)) {{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }} @else https://www.riobeauty.co.uk/images/product_image_not_found.gif @endif" style="height: 100%; width: 100%;"/>

            @if($follow === 0)
                <div><a href="{{ $creator[0]->account_id }}{{ __('/join') }}">入会する 입회하다</a></div>
            @endif

            <!--postList(parts)-->
            <div id="postList">
                <ul>
                    {{--                            21.03.28 김태영, mainData.balde.php 로 이동--}}
                    @include('mainData')

                    <div class="ajax-load text-center">
                        <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
                    </div>
                </ul>
            </div>
            <div id="bottomPost" class="bottomFixed">
                <div class="inner">
                    <div class="nameBox">
                        <p class="name">{{ $creator[0]->nickname }}</p>
                        <p class="price">月額 0円</p>
                    </div>
                    @guest
                        <a href="" class="btnCircle btnPi">入会する</a>
                    @else
                        @role('user')
                            <a href="" class="btnCircle btnPi">入会する</a>
                        @else
                            <span class="btnCircle line2">このアカウントでは<br>入会できません</span>
                        @endrole
                    @endguest
                </div>
            </div>
        </div>
    </div><!--/contentWrap-->
@endsection
