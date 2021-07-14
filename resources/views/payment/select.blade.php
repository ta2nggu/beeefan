@extends('layouts.base')

@section('title','決済方法選択')
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
                    <h2>{{ __("お支払い方法選択") }}</h2>
                    <p>{!! ("お支払い方法を選択してください。") !!}</p>
                </div>
                <ol>
                    <li></li>
                    <li></li>
                    <li class="active"><p>{{ __("決済登録") }}</p></li>
                    <li></li>
                </ol>
            </div>
            <form method="POST" action="{{ route('registerPaymentSelect') }}" class="formBox normalFormBox">
                @csrf
                <ul id="paymentSlectBox">
                    <li>
                        <input type="radio" id="credit_card" value="{{ __("credit_card") }}" name="payment_select" class="">
                        <label for="credit_card">
                            <span class="ttl">{{ __("クレジットカード") }}</span>
                        </label>
                    </li>
{{--                    <li>--}}
{{--                        <input type="radio" id="softbank" value="{{ __("softbank決済") }}" name="payment_select" class="">--}}
{{--                        <label for="softbank">--}}
{{--                            <span class="ttl">{{ __("softbank決済") }}</span>--}}
{{--                            <span class="txt">{{ __("テキストが入りますテキストが入ります") }}</span>--}}
{{--                        </label>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <input type="radio" id="docomo" value="{{ __("docomo決済") }}" name="payment_select" class="">--}}
{{--                        <label for="docomo">--}}
{{--                            <span class="ttl">{{ __("docomo決済") }}</span>--}}
{{--                            <span class="txt">{{ __("テキストが入りますテキストが入ります") }}</span>--}}
{{--                        </label>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <input type="radio" id="au" value="{{ __("au決済") }}" name="payment_select" class="">--}}
{{--                        <label for="au">--}}
{{--                            <span class="ttl">{{ __("au決済") }}</span>--}}
{{--                            <span class="txt">{{ __("テキストが入りますテキストが入ります") }}</span>--}}
{{--                        </label>--}}
{{--                    </li>--}}
                </ul>
                <input name="user_id" type="hidden" value="{{ $user->id }}">
                @isset($fc_id)
                    <input name="fc_id" type="hidden" value="{{ $fc_id }}">
                @else
                    <input name="fc_id" type="hidden" value="0">
                @endisset
                <div class="btnBox" style="margin-bottom: 10px">
                    <div><button type="submit" class="btn btnBl">{{ __("登録") }}</button></div>
                </div>
            </form>
            @isset($email_token)
                <form method="POST" action="{{ route('registerPaymentNoSelect') }}" class="formBox normalFormBox">
                    @csrf
                    <input name="user_id" type="hidden" value="{{ $user->id }}">
                    @isset($fc_id)
                        <input name="fc_id" type="hidden" value="{{ $fc_id }}">
                    @else
                        <input name="fc_id" type="hidden" value="0">
                    @endisset
                    <div>
                        <div><button type="submit" class="btn btnBor btnBorBl">{{ __("あとで登録する") }}</button></div>
                    </div>
                </form>
            @else
                <div class="formBox normalFormBox">
                    <div><button type="button" class="btn btnBor btnBorBl">{{ __("キャンセル") }}</button></div>
                </div>
            @endisset
        </div>

    </div><!--/contentWrap-->
@endsection
