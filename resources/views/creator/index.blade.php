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

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div id="profileHeader">
            <div class="imgbox" style="background-image: url({{ asset('storage/test/test_creater_profile_header.jpeg') }})">
                <div class="thumbnail"><img src="{{ asset('storage/test/test_creater_profile_thumbnail.jpeg') }}" alt="クリエイターニックネーム"></div>
            </div>
        </div>
        <div id="profileBox">
            <h1 class="name">{{ $user[0]->nickname }}</h1>
            <p class="price">月額 3,000円<span>（税込）</span></p>
            <div class="score clm2">
                <dl>
                    <dt>投稿数</dt>
                    <dd>{{ number_format($tweets->count()) }}</dd>
                </dl>
                <dl>
                    <dt>会員数</dt>
                    <dd>0</dd>
                </dl>
            </div>
            <div class="score">
                <dl>
                    <dt>総売上額</dt>
                    <dd>0<span class="period">（2021/5/21〜2021/9/18）</span></dd>
                </dl>
            </div>
            <div class="score scorePrice">
                <dl>
                    <dt>先月総売上</dt>
                    <dd>0</dd>
                </dl>
                <dl>
                    <dt>今月暫定総売上</dt>
                    <dd>0</dd>
                </dl>
            </div>
            <div class="btnBox">
                <p><a href="/{{ $user[0]->account_id }}" class="btn btnBor btnBorLp">公開ページを確認</a></p>
            </div>
        </div>
        <!--postList(parts)-->
        <div id="postList">
            <div class="tweets">
                <div class="flex_images">
                    <div class="post-data">
                        @include('creator/indexData')
                    </div>
                    <div class="ajax-load text-center">
                        <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
                    </div>
                </div>
            </div>
            <ul>
                @foreach($tweets as $key=>$value)
                    @if($value->include_video === 0)
                        @if($value->file_cnt > 1)
                            <li class="postMulti">
                        @else
                            <li class="postSingle">
                        @endif
                    @else
                    <li class="postVideo">
                        @endif
                        <a href="/{{ $user[0]->account_id }}/timeline/{{ $value->id }}">
                            <img src="{{ asset('storage/images/'.$value->path) }}" alt="">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="bottomCreatorMypage" class="bottomFixed">
            <ul class="inner">
                <li><a href="{{ url('/creator/write') }}" class="pCreate">投稿する</a></li>
                <li><a href="/{{ $user[0]->account_id }}/timeline/0" class="post">タイムライン</a></li>
                <li><a href="{{ url('/creator/index') }}" class="mypage">マイページ</a></li>
            </ul>
        </div>
    </div><!--/contentWrap-->
@endsection
