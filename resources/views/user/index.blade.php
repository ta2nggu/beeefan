@extends('layouts.base')

@section('title', 'マイページ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_user.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','')

@section('content')
    @component ('components.header')
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap">

        <div class="flashMsg">
            <p>パスワードの変更が完了しました</p>
        </div>

        <div id="infoBox">
            <ul>
                <li>
                    <p class="ttl">title</p>
                    <p class="txt">text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,</p>
                </li>
                <li>
                    <p class="ttl">title</p>
                    <p class="txt">text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,text,</p>
                </li>
            </ul>
        </div>

        <div id="memberCard">
            <div class="inner">
                <h2>{{ __("MEMBER'S CARD") }}</h2>
                <div class="box">
                    <p class="id">{{ $user->account_id }}</p>
                    <p>{{ __("アカウントID") }}</p>
                </div>
            </div>
        </div>

        <div id="fanclubList">
            <h2>{{ __('入会済みファンクラブ') }}</h2>
            <ul class="post-data">
                @include('user/indexData')
            </ul>
            <div class="ajax-load">
                <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
            </div>
        </div>

        @component ('components.bottomFixed')
        @endcomponent
    </div><!--/contentWrap-->
@endsection
