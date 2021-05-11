@extends('layouts.base')

@section('title', $creator[0]->nickname.'登録情報')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_user.css') }}">
@endsection
@section('body','fanclub')

@section('content')
    @component ('components.header')
        @section('page_back')
            <div class="formBox"><button onClick="history.back()" class="back userBack">{{ __('戻る') }}</button></div>
        @endsection
        @slot('header_title')
            <span class="name">{{ $creator[0]->nickname }}</span>{{ __('登録情報') }}
        @endslot
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap">
        <dl>
            <dt>{{ __('詳細') }}</dt>
            <dd>
                <p>{{$creator[0]->nickname}}</p>
                <p>{!! '月額 '. number_format($creator[0]->month_price) .'円(税込)' !!}</p>
            </dd>
            <dt>{{ __('お支払い') }}</dt>
            <dd>
                <p class="methods">{!! 'お支払い方法: ' .'<span>お支払い方法を変更したい場合は...texttexttext</span>' !!}</p>
                <p class="dayFirst">{!! '初回入会日: ' !!}</p>
                <p class="dayNext">{!! '次回請求日: ' !!}</p>
            </dd>
            <div class="wrap_s">
                <p class="removeLink"><a href="{{url('/mypage/fc/'.$creator[0]->account_id.'/remove')}}">{{ __('退会のお手続き') }}</a></p>
                <p><button onClick="history.back()" class="btn btnBor btnBorBl">{{ __('マイページへ戻る') }}</button></p>
            </div>
        </dl>
    </div><!--/contentWrap-->
@endsection
