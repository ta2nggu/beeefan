@extends('layouts.base')

@section('title','仮登録完了')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1')

@section('content')

    <!--contentWrap-->
    <div id="contentWrap">
        <div>
            <div id="stepBox">
                <div class="normalTitleBox">
                    <h2>{{ __("仮登録完了") }}</h2>
                    <p>{!! ("ご登録いただいたメールアドレスに<br>本登録用のメールを送信しました。<br>メールに記載されたURLから<br>Beee Fan!への本登録を完了してください。") !!}</p>
                </div>
                <ol>
                    <li></li>
                    <li class="active"><p>{{ __("仮登録完了") }}</p></li>
                    <li></li>
                    <li></li>
                </ol>
            </div>
            <ul class="btnBox wrap_inner">
                <li><a class="btn btnS btnBor btnBorBl" href="{{route('top')}}">{{ __("トップページへ") }}</a></li>
            </ul>
        </div>

    </div><!--/contentWrap-->
@endsection
