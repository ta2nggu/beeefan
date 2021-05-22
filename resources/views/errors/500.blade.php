@extends('layouts.base')

@section('title','システムエラー')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1 errorPage')

@section('content')
    <!--contentWrap-->
    <div id="contentWrap">
        <div>
            <div class="title">
                <h1 class="logo"><img src="{{ asset('storage/common/logo.png') }}" alt="{{ config('app.name') }}"></h1>
            </div>
            @if(env('APP_DEBUG') == 1)
                <p>{{ $exception->getMessage() }}</p>
            @else
                <div class="normalTitleBox">
                    <p>{!! 'サーバー内部でエラーが発生しました。<br>大変恐れ入りますが、<br>時間をおいてもう一度アクセスしてください。' !!}</p>
                    <a href="{{route('top')}}" class="btn btnS btnCircle">{{__('トップページへ')}}</a>
                </div>
            @endif
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
