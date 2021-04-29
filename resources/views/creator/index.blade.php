@extends('layouts.base')

@section('title', 'マイページ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_creator.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
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
            @if (isset($user[0]->background_img))
                <div class="imgbox" style="background-image: url({{ asset('storage/images/'.$user[0]->user_id.'/'.$user[0]->background_img) }})">
            @else
                <div class="imgbox">
            @endif
                @if (isset($user[0]->profile_img))
                    <div class="thumbnail"><img src="{{ asset('storage/images/'.$user[0]->user_id.'/'.$user[0]->profile_img) }}" alt="{{ $user[0]->nickname }}"></div>
                @else
                    <div class="thumbnail"><img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $user[0]->nickname }}"></div>
                @endif
            </div>
        </div>
        <div id="profileBox">
            <h1 class="name">{{ $user[0]->nickname }}</h1>
            <p class="price">{{__('月額' . number_format($user[0]->month_price) . '円')}}<span>{{__('（税込）')}}</span></p>
            <div class="score clm2">
                <dl>
                    <dt>{{__('投稿数')}}</dt>
                    <dd>{{ number_format($tweets->count()) }}</dd>
                </dl>
                <dl>
                    <dt>{{__('会員数')}}</dt>
                    <dd>0</dd>
                </dl>
            </div>
            <div class="score">
                <dl>
                    <dt>{{__('総売上額')}}</dt>
                    @php
                        $day = new DateTime($user[0]->created_at);
                    @endphp
                    <dd>0
{{--                        21.04.29 kondo, 登録日から昨日までの日付（当日までいけるか確認）--}}
                        <span class="period">{{__('('.$day->format('Y/m/d').'〜'.date('Y/m/d',strtotime('-1 day')) .')') }}</span>
                    </dd>
                </dl>
            </div>
            <div class="score scorePrice">
                <dl>
                    <dt>{{__('先月総売上')}}</dt>
                    <dd>0</dd>
                </dl>
                <dl>
                    <dt>{{__('今月暫定総売上')}}</dt>
                    <dd>0</dd>
                </dl>
            </div>
            <div class="btnBox">
                <p><a href="/{{ $user[0]->account_id }}" class="btn btnBor btnBorLp">{{__('公開ページを確認')}}</a></p>
            </div>

{{--            21.04.29 김태영, 下書き投稿一覧 page 개발을 위해 anchor 여기에 추가 나중에 지우세요 --}}
{{--            21.04.29 kondo, 비공개 화면 link headerNavへ移動--}}

        </div>
        <!--postList(parts)-->
        <div id="postList">
            <ul class="post-data">
                @include('creator/indexData')
            </ul>
            <div class="ajax-load">
                <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
            </div>
        </div>

        @component ('components.bottomFixed')
            @slot('bottomFixed_id')
                {{ $user[0]->account_id }}
            @endslot
        @endcomponent
    </div><!--/contentWrap-->
@endsection
