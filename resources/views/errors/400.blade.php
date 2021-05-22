@extends('layouts.base')

@section('title','エラー')
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
                <div class="normalTitleBox wrap_inner">
                    <p>{!! '不正な要求です。<br>再度やり直してください。' !!}</p>
                    <a href="{{route('top')}}" class="btn btnS btnCircle">{{__('トップページへ')}}</a>
                </div>
            @endif
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
