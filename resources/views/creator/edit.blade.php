@extends('layouts.base')

@section('title',"新規投稿")
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','')

@section('content')
    @component ('components.header')
@section('page_back')
    <div class="formBox"><button onClick="history.back()" class="back">{{ __('戻る') }}</button></div>
@endsection
@slot('header_title')
    新規投稿
@endslot
@endcomponent



<!--contentWrap-->
<div id="contentWrap">
    <div id="app" class="wrap_s">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif
        @php
            foreach($images as $image)
                $image['path'] = asset('storage/images/'.$image['path']);
        @endphp
        <router-view :current-user="{{ auth()->id() }}" :tweet_images="{{ $images }}"></router-view>
    </div>
</div><!--/contentWrap-->

@endsection
