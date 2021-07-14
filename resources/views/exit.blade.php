@extends('layouts.base')

@section('title','退会完了')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1')

@section('content')
    <!--contentWrap-->
    <div id="contentWrap">
        <div>
            <div class="title">
                <h1 class="logo"><img src="{{ asset('storage/common/logo.png') }}" alt="{{ config('app.name') }}"></h1>
            </div>
            <div class="flashMsgTop">
                <p>{!! '退会が完了しました。<br>ご利用いただき誠にありがとうございました。<br>またのご利用を心よりお待ちしております。' !!}</p>
            </div>
            <div class="formBox normalFormBox">
                <ul class="btnBox">
                    <li><a href="{{ route('top') }}" class="btn btnS">{{ __('トップページへ') }}</a></li>
                </ul>
            </div>
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
