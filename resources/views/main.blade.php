@extends('layouts.base')

@section('title',$creator[0]->nickname)
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @slot('header_title')
            {{ $creator[0]->nickname }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap">
        <div id="profileHeader">
            @if (isset($creator[0]->background_img))
                <div class="imgbox" style="background-image: url({{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->background_img) }})">
            @else
                <div class="imgbox">
            @endif
                @if (isset($creator[0]->profile_img))
                    <div class="thumbnail"><img src="{{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }}" alt="{{ $creator[0]->nickname }}"></div>
                @else
                    <div class="thumbnail"><img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $creator[0]->nickname }}"></div>
                @endif
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div id="profileBox">
            <h1 class="name">{{ $creator[0]->nickname }}</h1>
            <div class="text moreArea">{!! $creator[0]->instruction !!}</div>
            <div class="btnBox">
                @guest
                    <p><a href="{!! '/'. $creator[0]->account_id .'/join' !!}" class="btn btnPi">{{ __('入会する') }}</a></p>
                    <p><a href="{{ url('/home') }}" class="btn btnLp">{{ __('マイページにログイン') }}</a></p>
                @else
                    @role('user')
                        @if($follow === 0)
                            <p><a href="{!! '/'. $creator[0]->account_id .'/join' !!}" class="btn btnPi">{{ __('入会する') }}</a></p>
                        @endif
                    @else
                        <p><span class="btn line2">{!! 'このアカウントでは<br>入会できません' !!}</span></p>
                    @endrole
                    @if( Auth::id() === $creator[0]->id)
                        <p><a href="{{ url('/creator/index') }}" class="btn btnLp">{{ __('マイページへ') }}</a></p>
                    @endif
                @endguest
            </div>
        </div>

        <!--postList(parts)-->
        <div id="postList">
            @if(count($tweets)>=1)
                <ul class="post-data">
                    {{--                            21.03.28 김태영, mainData.balde.php 로 이동--}}
                    @include('mainData')
                </ul>
                <div class="ajax-load">
                    <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
                </div>
            @else
                <div class="noDateBox noDateBoxBorder"><p class="noDateText">{{ __('投稿がありません') }}</p></div>
            @endif
        </div>

        @if($follow === 0)
            <div id="bottomPost" class="bottomFixed">
                <div class="inner">
                    <div class="nameBox">
                        <p class="name">{{ $creator[0]->nickname }}</p>
                        <p class="price">{{ __('月額') . $creator[0]->month_price .('円') }}</p>
                    </div>
                    @guest
                        <a href="{!! '/'. $creator[0]->account_id .'/join' !!}" class="btnCircle btnPi">{{ __('入会する') }}</a>
                    @else
                        @role('user')
                            <a href="{!! '/'. $creator[0]->account_id .'/join' !!}" class="btnCircle btnPi">{{ __('入会する') }}</a>
                        @else
                            <span class="btnCircle line2">{!! 'このアカウントでは<br>入会できません' !!}</span>
                        @endrole
                    @endguest
                </div>
            </div>
        @else
            @component ('components.bottomFixed')
            @endcomponent
        @endif
    </div><!--/contentWrap-->
@endsection
