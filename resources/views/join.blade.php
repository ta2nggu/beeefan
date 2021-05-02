@extends('layouts.base')
{{--뒤로가기 방지 php 코드--}}
<?php header("Progma:no-cache"); header("Cache-Control: no-store, no-cache ,must-revalidate"); ?>

@section('title',$creator[0]->nickname.'ファンクラブ入会')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','join')

@section('content')
    @component ('components.header')
        @slot('header_title')
            <span class="name">{{ $creator[0]->nickname}}</span>{{__('ファンクラブ入会')}}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentBtmMar">
        <div id="profileHeader" class="profileHeaderNoBk">
            <div class="imgbox">
                @if (isset($creator[0]->profile_img))
                    <div class="thumbnail"><img src="{{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }}" alt="{{ $creator[0]->nickname }}"></div>
                @else
                    <div class="thumbnail"><img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $creator[0]->nickname }}"></div>
                @endif
            </div>
        </div>
        <div id="profileBox">
            <h1 class="name">{{ $creator[0]->nickname }}</h1>
            <p class="price">{{__('月額' . number_format($creator[0]->month_price) . '円')}}<span>{{__('（税込）')}}</span></p>
        </div>
        <div class="helpBox">
            <h2>{{ __('ファンクラブ特典')}}</h2>
            <p>{{ $creator[0]->nickname }}{{__('の写真・動画・文章が見放題! ※ファンクラブ内容は変更となる場合がございます。')}}</p>
            <h2>{{ __('お支払いについて')}}</h2>
            <p>{{ __('クレジットカード(全種)、デビットカード、プリペイドカード、バンドルカード、Kyashでのお支払が可能です。クレジットカードを持ってない方はバンドルカード作成で、お支払いが簡単です。コンビニ払い、ATM払い、ドコモ払いも対応しています(ソフトバンク、au のキャリア決済は未対応)。')}}</p>
        </div>
        <form method="POST" action="{{ __('/join') }}" class="formBox normalFormBox">
            @csrf
            <input name="account_id" type="hidden" value="{{ $creator[0]->account_id }}">
            <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
            <input name="creator_id" type="hidden" value="{{ $creator[0]->user_id }}">

            <div class="centerCheckbox">
                <input type="checkbox" id="join_chk" class="colorPi">
                <label for="join_chk"><a href="{{ url('/page/rule') }}" target="_blank">{{ __('利用規約')}}</a>{{ __('に同意する')}}</label>
            </div>
            <ul class="btnBox">
                <li><button type="submit" class="btn btnPi" id="join_submit" disabled>{{ __('入会する') }}</button></li>
                <li><div onclick="history.go(-1)" class="btn btnBor btnBorGy">{{ __('戻る') }}</div></li>
            </ul>
            <p class="txtLink">{{ __('※Beee Fan!ではフォンクラブ登録日によって決済日が異なります。その際にクレジットカードの限度額オーバーや有効期限切れ、デビットカードの残高不足などで正常な決済が行えない場合、該当プランから退会となりますので、ご注意ください。') }}</p>
        </form>

    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
