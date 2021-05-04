@extends('layouts.base')

@section('title','マイページ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','admin')

@section('content')

    @component ('components.header')
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap">

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div id="profileBox">
            <div class="score clm3">
                <dl>
                    <dt>クリエイター数</dt>
                    <dd>{{ $creators_cnt }}</dd>
                </dl>
                <dl>
                    <dt>総会員数</dt>
                    <dd>{{ $users_cnt }}</dd>
                </dl>
                <dl>
                    <dt>入会総件数</dt>
                    <dd>0</dd>
                </dl>
            </div>
            <div class="score">
                <dl>
                    <dt>総売上額</dt>
                    <dd>0</dd>
                </dl>
            </div>
            <div class="score">
                <dl>
                    <dt>総利益額（総売上から20％引いた額）</dt>
                    <dd>0</dd>
                </dl>
            </div>
        </div>
<<<<<<< HEAD
{{--        21.05.03 김태영, 공지사항    --}}
        <div><a href="/admin/">{{__('공지사항')}}</a></div>
        <div><a href="/admin/creatorReg">{{__('クリエイター新規登録크리에이터신규등록')}}</a></div>
        <div>{{ __('クリエイター名で検索する 크리에이터 이름 검색') }}</div>
        <input id="search_creator_input" type="text" placeholder="nicknameを入力してください。">
        <div>{{ __('sorting 정렬') }}</div>
        <select id="search_creator_select" name="sortCreators">
            {{--                                <option value="" selected disabled hidden>お選びください.</option>--}}
            <option value="{{ __("created_at,desc") }}">{{ __('登錄日降順 등록일 내림차순') }}</option>
            <option value="{{ __("created_at,asc") }}">{{ __('登錄日昇順 등록일 오름차순') }}</option>
        </select>

        <div class="post-data">
            @include('admin/indexData')
        </div>
        <div class="ajax-load text-center">
            <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
        </div>
=======
>>>>>>> main

{{--            21.05.04 김태영, 이 부분이 충돌되면서 중복 생성되었어--}}
{{--            git에서 자동으로 생성해준 부분--}}
{{--            미카가 확인해보고 필요없으면 지우세요!--}}
{{--<<<<<<< HEAD--}}
{{--=======--}}
{{--        21.05.03 김태영, 공지사항    --}}
{{--        <div><a href="{{__('/admin/notice')}}">{{__('공지사항')}}</a></div>--}}
{{--        <div><a href="/admin/creatorReg">{{__('クリエイター新規登録크리에이터신규등록')}}</a></div>--}}
{{--        <div>{{ __('クリエイター名で検索する 크리에이터 이름 검색') }}</div>--}}
{{--        <input id="search_creator_input" type="text" placeholder="nicknameを入力してください。">--}}
{{--        <div>{{ __('sorting 정렬') }}</div>--}}
{{--        <select id="search_creator_select" name="sortCreators">--}}
{{--            --}}{{--                                <option value="" selected disabled hidden>お選びください.</option>--}}
{{--            <option value="{{ __("created_at,desc") }}">{{ __('登錄日降順 등록일 내림차순') }}</option>--}}
{{--            <option value="{{ __("created_at,asc") }}">{{ __('登錄日昇順 등록일 오름차순') }}</option>--}}
{{--        </select>--}}

{{--        <div class="post-data">--}}
{{--            @include('admin/indexData')--}}
{{--        </div>--}}
{{--        <div class="ajax-load text-center">--}}
{{--            <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>--}}
{{--        </div>--}}
{{-->>>>>>> 084b449... 공지사항 개발 시작--}}

        <div id="creatorRegBtn" class="btnBox">
            <p><a href="{{ url('/admin/creatorReg') }}" class="btn btnAd">クリエイター新規登録</a></p>
        </div>

        <div class="formBox normalFormBox">
            <div class="searchBox">
                <input id="search_creator_input" type="text" placeholder="クリエイター名で検索する。">
                <input type="image" src="{{ asset('storage/icon/icon_search.png') }}">
            </div>
            <div class="selectBox">
                <select id="search_creator_select" name="sortCreators">
                    {{--                                <option value="" selected disabled hidden>お選びください.</option>--}}
                    <option value="{{ __("created_at,desc") }}">{{ __('登錄日が新しい順に表示') }}</option>
                    <option value="{{ __("created_at,asc") }}">{{ __('登錄日が古い順に表示') }}</option>
                </select>
            </div>
        </div>

        <div id="fanclubList">
            <ul class="post-data">
                @include('admin/indexData')
            </ul>
            <div class="ajax-load">
                <div class="loadingIcon"><img src="{{ asset('storage/icon/loading.gif') }}" alt="{{ __('データを持ってきています。') }}"></div>
            </div>
        </div>

        @component ('components.bottomFixed')
        @endcomponent

    </div><!--/contentWrap-->
@endsection
