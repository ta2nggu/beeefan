@extends('layouts.base')

@section('title','管理者新規登録')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @slot('header_title')
            {{ __("管理者新規登録") }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentTopMar">

        <form method="POST" action="{{ __('/admin/saReg') }}" class="formBox normalFormBox">
            @csrf

            <dl>
                <dt><label>{{ __('名前') }}</label><span class="required">{{ __('必須') }}</span></dt>
                <dd>
                    <div class="nameBox">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="性">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="名">
                    </div>
                    @error('last_name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                    @error('first_name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </dd>
            </dl>
            <dl>
                <dt><label for="email">{{ __('メールアドレス') }}</label><span class="required">{{ __('必須') }}</span></dt>
                <dd>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
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
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--Password-->
            <dl>
                <dt><label for="password">{{ __('パスワード') }}</label><span class="required">{{ __('必須') }}</span><span class="att">{{ __('※8文字以上でご記入ください') }}</span></dt>
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

            <ul class="btnBox">
                <li><button type="submit" class="btn btnAd submitBtn">{{ __('管理者を登録する') }}</button></li>
                <li><a href="{{route('top')}}" class="btn btnBor btnBorGy">{{ __('登録せずに戻る') }}</a></li>
            </ul>

        </form>
    </div><!--/contentWrap-->
@endsection
