@extends('layouts.base')

@section('title','Beee Fan!')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1 topPage')

@section('content')
    <!--contentWrap-->
    <div id="contentWrap">
        <div>
            <div class="title">
                <h1 class="logo"><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"></h1>
                <p>○○なファンコミュニティ</p>
            </div>
            <ul class="btnBox">
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/home') }}" class="btn">マイページ</a></li>
                        <li><a href="{{ route('logout') }}" class="btn">ログアウト</a></li>
                    @else
                        <li><a href="{{ url('/home') }}" class="btn">ログイン</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="btn">新規会員登録</a></li>
                        @endif
                        <li><a href="{{ url('/creator/login') }}" class="btn">クリエイターの方はこちら</a></li>
                    @endauth
                @endif
            </ul>
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
