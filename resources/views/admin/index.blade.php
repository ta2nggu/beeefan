@extends('layouts.base')

@section('title','マイページ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
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

        <div id="creatorRegBtn" class="btnBox">
            <p><a href="{{ url('/admin/creatorReg') }}" class="btn btnAd">クリエイター新規登録</a></p>
        </div>

        <!--creatorList(parts)-->
        <div id="creatorList">
            <p>전 크리에이터 정보</p>
        </div>

        <div id="bottomAdminMypage" class="bottomFixed">
            <ul class="inner">
                <li><a href="{{ url('/admin/index') }}" class="mypage">マイページ</a></li>
                <li><a href="{{ url('/admin/creators') }}" class="setting">設定変更</a></li>
            </ul>
        </div>
    </div><!--/contentWrap-->
@endsection
