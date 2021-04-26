@extends('layouts.app')
{{--뒤로가기 방지 php 코드--}}
<?php header("Progma:no-cache"); header("Cache-Control: no-store, no-cache ,must-revalidate"); ?>

@section('content')
<div class="profile_img" style="width: 150px; height: 150px;">
    <img id="preview_profile_img" src="@if (isset($creator[0]->profile_img)) {{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }} @else https://www.riobeauty.co.uk/images/product_image_not_found.gif @endif" style="height: 100%; width: 100%;"/>
</div>
<div style="margin-top: 30px;">
    <h2>{{ $creator[0]->last_name }}{{ $creator[0]->first_name }} / {{ $creator[0]->nickname }}</h2>
    <h3>月 額 {{ number_format($creator[0]->month_price) }}円(税込)</h3>
    <h4>ファンクラブ特典</h4>
    <p>{{ $creator[0]->last_name }}{{ $creator[0]->first_name }} / {{ $creator[0]->nickname }}の写真・動画・文章が見放題! ※ファンクラブ内容は変更となる場合がございます</p>
    <h4>お支払いについて</h4>
    <p>クレジットカード(全種)、デビットカード、プリペイ ドカード、バンドルカード、Kyashでのお支払が可能 です。引き落としは毎月1日です。 クレジットカードを持ってない方はバンドルカード作 成で、お支払いが簡単です。コンビニ払い、ATM払 い、ドコモ払いも対応しています(ソフトバンク、au のキャリア決済は未対応)。</p>

    <form method="POST" action="{{ __('/join') }}" >
        @csrf

        <input name="account_id" type="hidden" value="{{ $creator[0]->account_id }}">
        <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
        <input name="creator_id" type="hidden" value="{{ $creator[0]->user_id }}">
        <input type="checkbox" id="join_chk">利用規約に同意する 이용약관에 동의합니다
        <div class="submit">
            <button type="submit" class="btn btn-primary" id="join_submit" disabled>入会する</button>
        </div>
    </form>
    <div class="btn btn-secondary" onclick="history.go(-1)">戻る</div>

    <p>※Beee Fan!では毎月1日に当月分の決済を行います。その際にクレ ジットカードの限度額オーバーや有効期限切れ、デビットカードの 残高不足などで正常な決済が行えない場合、該当プランから退会と なりますので、ご注意ください。</p>
</div>
@endsection
