@extends('layouts.base')

@section('title', 'マイページ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_user.css') }}">
@endsection
@section('body','fanclub')

@section('content')
    @component ('components.header')
        @section('page_back')
            <div class="formBox"><button onClick="history.back()" class="back">{{ __('戻る') }}</button></div>
        @endsection
        @slot('header_title')
            <span class="name">{{$user->account_id}}</span>{{ __('入会情報') }}
        @endslot
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap" class="contentBtmMar">
        <dl>
            <dt>詳細</dt>
            <dd>
                <p>{{$user->id}}</p>
                <p>{!! '月額 '. $user->id .'円(税込)' !!}</p>
            </dd>
            <dt>お支払い</dt>
            <dd>
                <p class="methods">{!! 'お支払い方法: '. $user->id .'<span>お支払い方法を変更したい場合は...texttexttext</span>' !!}</p>
                <p class="dayFirst">{!! '初回入会日: '. $user->id !!}</p>
                <p class="dayNext">{!! '次回請求日: '. $user->id !!}</p>
            </dd>
            <div class="wrap_s">
                <p class="removeLink"><a href="">退会のお手続き</a></p>
                <p><button onClick="history.back()" class="btn btnBor btnBorBl">{{ __('マイページへ戻る') }}</button></p>
            </div>
        </dl>

        @component ('components.bottomFixed')
        @endcomponent
    </div><!--/contentWrap-->
@endsection
