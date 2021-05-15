@extends('layouts.base')

@section('title',$creator[0]->nickname.'ファンクラブ入会')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1')

@section('content')
    <!--contentWrap-->
    <div id="contentWrap" class="wrap_inner">
        <div>
            <ul class="btnBox">
                <li><a href="{{route('login')}}" class="btn btnBl">ログインして入会する</a></li>
                <li><a href="{{route('register').'?fc_id='.$creator[0]->id}}" class="btn btnBor btnBorBl">新規会員登録して入会する</a></li>
            </ul>
        </div>
    </div><!--/contentWrap-->
@endsection
