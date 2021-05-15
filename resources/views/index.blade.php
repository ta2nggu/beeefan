@extends('layouts.base')

@section('title','○○なファンコミュニティ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1 topPage')

@section('content')
    <!--contentWrap-->
    <div id="contentWrap">
        <div>
            <div class="title">
                <h1 class="logo"><img src="{{ asset('storage/common/logo.png') }}" alt="{{ config('app.name') }}"></h1>
                <p>{{ __('○○なファンコミュニティ')}}</p>
            </div>
            @if (session('flash_message'))
                <div class="flashMsgTop">
                    <p>{!! nl2br(session('flash_message')) !!}</p>
                </div>
            @else
                <ul class="btnBox">
                    @if (Route::has('login'))
                        @auth
                            <li><a href="{{ route('home') }}" class="btn">{{ __('マイページ') }}</a></li>
                            <li><a class="btn" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">ログアウト</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li><a href="{{ url('/login?root=top') }}" class="btn">ログイン</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="btn">新規会員登録</a></li>
                            @endif
                            <li><a href="{{ url('/creator/login') }}" class="btn">クリエイターの方はこちら</a></li>
                        @endauth
                    @endif
                </ul>
            @endif
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
