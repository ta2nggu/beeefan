@extends('layouts.base')

@section('title','マイページ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','admin')

@section('content')

    @component ('components.header')
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap">

        @if (session('flash_message'))
            <div class="flashMsg">
                <p>{{ session('flash_message') }}</p>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div id="profileBox">
            <div class="score clm3">
                <dl>
                    <dt>クリエイター数</dt>
                    <dd>{{ number_format($creators_cnt) }}</dd>
                </dl>
                <dl>
                    <dt>総会員数</dt>
                    <dd>{{ number_format($users_cnt) }}</dd>
                </dl>
                <dl>
                    <dt>入会総件数</dt>
                    <dd>{{ number_format($followings_cnt) }}</dd>
                </dl>
            </div>
            <div class="score">
                <dl>
                    <dt>総売上額</dt>
                    <dd>0</dd>
                </dl>
            </div>
            <div class="score">
                <dl>
                    <dt>総利益額（総売上から20％引いた額）</dt>
                    <dd>0</dd>
                </dl>
            </div>
        </div>

        <div id="creatorRegBtn" class="btnBox">
            <p><a href="{{ url('/admin/creatorReg') }}" class="btn btnAd">{{__('クリエイター新規登録')}}</a></p>
        </div>

        <div class="formBox normalFormBox">
            <div class="searchBox">
                <input id="search_creator_input" type="text" placeholder="{{__('クリエイター名で検索する')}}">
                <input type="image" src="{{ asset('storage/icon/icon_search.png') }}">
            </div>
            <div class="selectBox">
                <select id="search_creator_select" name="sortCreators">
                    <option value="{{ __("creators.created_at,desc") }}">{{ __('登錄日が新しい順に表示') }}</option>
                    <option value="{{ __("creators.created_at,asc") }}">{{ __('登錄日が古い順に表示') }}</option>
                </select>
            </div>
        </div>

        <div id="fanclubList">
            @if(count($creators)>=1)
                <ul class="post-data">
                    @include('admin/indexData')
                </ul>
                <div class="ajax-load">
                    <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
                </div>
            @else
                <div class="noDateBox noDateBoxBorder"><p class="noDateText">{{ __('クリエイターが未登録です') }}</p></div>
            @endif
        </div>

        @component ('components.bottomFixed')
        @endcomponent

    </div><!--/contentWrap-->
@endsection
