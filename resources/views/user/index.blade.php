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

        @if (session('flash_message'))
            <div class="flashMsg">
                <p>{!! nl2br(session('flash_message')) !!}</p>
            </div>
        @endif

        @if(count($notices)>=1)
            <div id="infoBox">
                <ul>
                    {{-- 21.05.10 김태영, 공지사항 추가 --}}
                    @foreach($notices as $notice)
                        <li>
                            <p class="ttl">{{$notice->title}}</p>
                            <pre class="txt">{{$notice->body}}</pre>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

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
            <h2>{{ __('入会中ファンクラブ一覧') }}</h2>
            @if(count($creators)>=1)
                <ul class="post-data">
                    @include('user/indexData')
                </ul>
                <div class="ajax-load">
                    <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
                </div>
            @else
                <div class="noDateBox noDateBoxBorder"><p class="noDateText">{{ __('入会中のファンクラブがありません') }}</p></div>
            @endif
        </div>

        @component ('components.bottomFixed')
        @endcomponent
    </div><!--/contentWrap-->
@endsection
