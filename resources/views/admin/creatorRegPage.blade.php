@extends('layouts.base')

@section('title','クリエイター新規登録')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @slot('header_title')
            {{ __("クリエイター新規登録") }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentTopMar">

        <form method="POST" action="{{ __('/admin/creatorReg') }}" class="formBox normalFormBox">
            @csrf
            <!--name-->
            <dl>
                <dt><label for="name">{{ __('名前') }}</label><span class="required">{{ __('必須') }}</span></dt>
                <dd>
                    <div class="nameBox">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="性">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="名">
                    </div>
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    @error('first_name')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </dd>
            </dl>
            <!--nickname-->
            <dl>
                <dt><label for="nickname">{{ __('クリエイター名') }}</label><span class="required">{{ __('必須') }}</span><span class="att">{{ __('※後からクリエイターの設定変更画面にて変更可能です。') }}</span></dt>
                <dd>
                    <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror"  name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>
                    @error('nickname')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </dd>
            </dl>
            <!--email-->
            <dl>
                <dt><label for="email">{{ __('メールアドレス') }}</label><span class="required">{{ __('必須') }}</span></dt>
                <dd>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </dd>
            </dl>
            <!--account_id-->
            <dl>
                <dt><label for="account_id">{{ __('アカウントID') }}</label><span class="required">{{ __('必須') }}</span><span class="att">{{ __('※「半角英数字 _ -」でご記入ください') }}</span></dt>
                <dd>

                    <input id="account_id" type="text" class="form-control @error('account_id') is-invalid @enderror" name="account_id" value="{{ old('account_id') }}" required autocomplete="account_id" autofocus>
                    @error('account_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ __('アカウントIDは「半角英数字 _ -」のみ使用することができます') }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--Password-->
            <dl>
                <dt><label for="password">{{ __('パスワード') }}</label><span class="required">{{ __('必須') }}</span></dt>
                <dd>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--Password-->
            <dl>
                <dt><label for="password-confirm">{{ __('パスワード（確認）') }}</label><span class="required">{{ __('必須') }}</span></dt>
                <dd>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </dd>
            </dl>
            <!--monthly_price-->
            <dl>
                <dt><label for="month_price">{{ __('月額') }}</label><span class="required">{{ __('必須') }}</span><span class="att">{{ __('※月額設定後、変更できるのは運営管理者のみです。') }}</span></dt>
                <dd>
                    <div class="monthly_priceBox"><input type="number" class="form-control @error('month_price') is-invalid @enderror"  name="month_price" value="{{ old('month_price', 0) }}" required autocomplete="month_price" autofocus></div>
                    @error('month_price')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </dd>
            </dl>

            <!--送信-->
            <input id="role" name="role" type="hidden" value="{{ __('creator') }}">
            <ul class="btnBox">
                <li><button type="submit" class="btn btnAd submitBtn">{{ __('クリエイターを登録する') }}</button></li>
                <li><a href="{{route('admin')}}" class="btn btnBor btnBorGy">{{ __('登録せずに戻る') }}</a></li>
            </ul>
        </form>
    </div><!--/contentWrap-->
@endsection
