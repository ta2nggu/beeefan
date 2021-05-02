@extends('layouts.base')
{{--뒤로가기 방지 php 코드--}}
<?php header("Progma:no-cache"); header("Cache-Control: no-store, no-cache ,must-revalidate"); ?>

@section('title',$creator[0]->nickname.'ファンクラブ入会完了')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1')

@section('content')
    @component ('components.header')
        @slot('header_title')
            <span class="name">{{ $creator[0]->nickname}}</span>{{__('入会完了')}}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentBtmMar">
        <div>
            <div class="normalTitleBox">
                <h2>{{ __("入会完了") }}</h2>
                <p>{!! ("入会が完了いたしました<br>".$creator[0]->nickname."のコンテンツをお楽しみください") !!}</p>
            </div>
            <ul class="btnBox wrap_inner">
                <li><a href="/{{ $creator[0]->account_id }}" class="btn btnBl">{!! ($creator[0]->nickname."の投稿を見る") !!}</a></li>
                <li><a href="{{ url('/mypage') }}" class="btn btnBor btnBorBl">{{__('マイページへ')}}</a></li>
            </ul>
        </div>

    </div><!--/contentWrap-->
@endsection
