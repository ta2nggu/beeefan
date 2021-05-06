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
        @slot('header_title')
            新規投稿
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap">
        <div class="wrap_s">
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
            <router-view :current-user="{{ auth()->id() }}"></router-view>
        </div>
    </div><!--/contentWrap-->

    {{--                                                    21.03.16 김태영, 테스트용--}}
    {{--                                                <input type="file" name="file" id="file" class="inputfile" multiple>--}}
    {{--                                                <label for="file" style="background-image: url({{ asset('storage/images/18/48/cat1.png') }})"></label>--}}
    {{--                                                <label for="file">+</label>--}}
    {{--                                                <label for="file">+</label>--}}
@endsection
