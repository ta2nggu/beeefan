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
            <div class="normalTitleBox wrap_inner">
                @if (session('flash_message'))
                        <p>{!! nl2br(session('flash_message')) !!}</p>
                @endif
                <a href="{{route('top')}}" class="btn btnS btnCircle">{{__('トップページへ')}}</a>
            </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
