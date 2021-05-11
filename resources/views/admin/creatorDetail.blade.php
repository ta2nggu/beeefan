@extends('layouts.base')

@section('title','運営者新規登録')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','')

@section('content')

<?php
function dateFormat($timestamp) {
    $year = date('Y', strtotime($timestamp));
    $month = strval(intval(date('m', strtotime($timestamp))));
    $day = strval(intval(date('d', strtotime($timestamp))));
    $date = $year.'/'.$month.'/'.$day;

    return $date;
}
?>
@if (isset($creator[0]->profile_img))
    <div class="thumbnail"><img src="{{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }}" alt="{{ $creator[0]->nickname }}"></div>
@else
    <div class="thumbnail"><img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $creator[0]->nickname }}"></div>
@endif

<h2>{{__('投稿数')}}</h2>
<h4>{{$tweet_cnt}}</h4>
<h2>{{__('会員数')}}</h2>
<h4>{{$creator[0]->follower_cnt}}</h4>
<h2>{{__('総売上額')}}</h2>
<h4>
    {{-- 総売上額(利益) 밑에 날짜 있어서 creator account 생성일 부터 오늘까지 일단 표기 해둠 --}}
    @php
        echo '('.dateFormat($creator[0]->created_at).' ~ '.dateFormat(date("Y-m-d H:i:s")).')';
    @endphp
</h4>
<h2>{{__('先月総売上')}}</h2>
<h2>{{__('今月暫定総売上')}}</h2>

@role('superadministrator')
<div style="border: 3px dotted blue;">
    <h2>月額変更</h2>
    <pre>
    月額は運営管理者しか変更できません。変更する場合
    は、金額を記入し「月額を変更する」ボタンを押して
    ください。
    </pre>

    <input id="inMonthlyPrice" type="number" class="form-control @error('month_price') is-invalid @enderror"  name="month_price" value="{{$creator[0]->month_price}}" required autocomplete="month_price" autofocus>
    @error('month_price')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
    <input id="inPriceUpdateCreatorId" type="hidden" name="creator_id" value="{{ $creator[0]->user_id }}">
    <button id="btnUpdateCreatorPrice" type="submit">{{ __('月額を変更する') }}</button>
    <div id="updatedMonthlyPrice" style="color: red; display: none;"></div>
</div>
@endrole

    <h2>{{__('アカウントID')}}</h2>
    <h3>{{$creator[0]->account_id}}</h3>
    <h2>{{__('メールアドレス')}}</h2>
    <h3>{{$creator[0]->email}}</h3>
    <h2>{{__('パスワード')}}</h2>
    <h3>{{__('*********')}}</h3>
    <p class="txtLink NoMrg right"><a href="{{ url('/password/creator/'.$creator[0]->user_id) }}">{{__('パスワードを変更する')}}</a></p>

<form method="POST" action="{{ __('/creator/visible') }}" class="formBox normalFormBox">
    @csrf

    <input type="hidden" name="creator_id" value="{{ $creator[0]->user_id }}">

    @if ($creator[0]->visible === 1)
        <input type="hidden" name="visible" value="0">
        <button type="submit">{{__('creator 비공개')}}</button>
    @else
        <input type="hidden" name="visible" value="1">
        <button type="submit">{{__('creator 공개')}}</button>
    @endif
</form>

<form method="POST" action="{{ __('/creator/del') }}" class="formBox normalFormBox">
    @csrf

    <input type="hidden" name="creator_id" value="{{ $creator[0]->user_id }}">
    <button type="submit">{{__('クリエイターを削除する creator 삭제')}}</button>
</form>


@endsection
