@extends('layouts.base')

@section('title','パスワード再設定')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1')

@section('content')

    <!--contentWrap-->
    <div id="contentWrap">
        <div>

            @if (session('status'))
                <div class="normalTitleBox">
                    <h2>{{ __("パスワード再設定") }}</h2>
                    <p>{!! ("ご登録のメールアドレス宛に<br>URLをお送りしております。<br>60分以内にパスワードの再設定をしてください。") !!}</p>
                    <a class="btn btnS btnBl" href="{{ url('/login') }}">{{ __('ログイン画面へ') }}</a></div>
                </div>
            @else
                <div class="normalTitleBox">
                    <h2>{{ __("パスワード再設定") }}</h2>
                    <p>{!! ("パスワード再設定用のURLを<br>メールアドレスにお送りします。") !!}</p>
                </div>
                <form method="POST" action="{{ route('password.email') }}" class="formBox normalFormBox">
                    @csrf
                    <dl>
                        <dt><label for="email">{{ __('メールアドレス') }}</label><span class="required">{{ __("必須") }}</span></dt>
                        <dd>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('メールアドレスをご入力ください') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <p class="txtLink center">{!! ("メールアドレスをお忘れの方は<br>下記の宛先までお問い合わせください<br>beeefun@example.com</p>") !!}
                        </dd>
                    </dl>
                    <div class="btnBox"><button type="submit" class="btn btnS btnBl">{{ __('送信') }}</button></div>
                </form>
            @endif

        </div>

    </div><!--/contentWrap-->
@endsection
