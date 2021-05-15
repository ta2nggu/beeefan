@extends('layouts.base')

@section('title','会員登録完了')
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
                    <h2>{{ __("会員登録完了") }}</h2>
                    <p>{!! ("会員登録が完了いたしました。<br>BeeeFan!のコンテンツをお楽しみください。") !!}</p>
                </div>
                <ol>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li class="active"><p>{{ __("登録完了") }}</p></li>
                </ol>
            </div>
            <ul class="btnBox wrap_inner">
                @if(isset($creator))
                    <li><a class="btn btnBl" href="{{ url('/'.$user->account_id.'/join') }}">{{ __($creator->nickname." 入会") }}</a></li>
                @endif
                <li><a class="btn btnBor btnBorBl" href="{{route('home')}}">{{ __("マイページへ") }}</a></li>
            </ul>
        </div>

    </div><!--/contentWrap-->
@endsection
