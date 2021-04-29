@extends('layouts.base')

@section('title', '下書き一覧')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_creator.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @slot('header_title')
            {{ __('下書き一覧') }}
        @endslot
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap">

        <div id="postList">
            <ul class="post-data">
                @include('creator/invisibleTweetsData')
            </ul>
            <div class="ajax-load">
                <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
            </div>
        </div>

    @component ('components.bottomFixed')
    @slot('bottomFixed_id')
    {{ $user[0]->account_id }}
    @endslot
    @endcomponent
    </div><!--/contentWrap-->
@endsection
