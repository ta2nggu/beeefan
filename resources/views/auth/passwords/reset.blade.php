@extends('layouts.base')

@section('title','パスワード変更')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1')

@section('content')

    <!--contentWrap-->
    <div id="contentWrap">
        <div>

            <div class="normalTitleBox">
                <h2>{{ __("パスワード再設定") }}</h2>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="formBox normalFormBox">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <dl>
                    <dt><label for="email">{{ __('メールアドレス') }}</label></dt>
                    <dd class="readonlyBox">
                        <input id="email" type="email" class="readonly form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </dd>
                </dl>
                <dl>
                    <dt><label for="password">{{ __('新しいパスワード') }}</label><span class="required">{{ __("必須") }}</span></dt>
                    <dd>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </dd>
                </dl>
                <dl>
                    <dt><label for="password-confirm">{{ __('新しいパスワード(確認)') }}</label><span class="required">{{ __("必須") }}</span></dt>
                    <dd>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </dd>
                </dl>
                <div class="btnBox"><button type="submit" class="btn btnS btnBl">{{ __('設定する') }}</button></div>
            </form>

        </div>
    </div><!--/contentWrap-->
@endsection
