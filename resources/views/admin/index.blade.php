@extends('layouts.app')

@section('content')
{{-- 運営者管理画面 운영자관리화면 --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('運営者管理画面 관리자 main page') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            クリエイター数 : {{ $creators_cnt }}<br>
                            会員数 : {{ $users_cnt }}<br>
                            ..


                            {{--        <a href="/admin/creators">クリエイター情報管理</a><br>--}}
                            {{--        21.04.15 김태영, index 화면에서 등록 화면으로 바로 접근--}}
                            {{--        index 화면에 creator list 보여주기--}}
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
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div><a href="">運営者情報管理운영자정보관리</a></div>

@endsection
