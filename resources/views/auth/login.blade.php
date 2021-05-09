@extends('layouts.base')

@section('title','ログイン')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1 login')

@section('content')
    <!--contentWrap-->
    @if(isset( $userFlag ))
        @if($userFlag == "クリエイター")
            <div id="contentWrap" class="creator">
        @else
            <div id="contentWrap" class="admin">
        @endif
    @else
        <div id="contentWrap" class="fan">
    @endif
        <div>
            <div class="title">
                <p class="logo"><a href="{{ url('/') }}"><img src="{{ asset('storage/common/logo.png') }}" alt="{{ config('app.name') }}"></a></p>
                @if(isset( $userFlag ))
                    <h1>{{$userFlag}}{{_("ログイン")}}</h1>
                @else
                    <h1>{{_("会員ログイン")}}</h1>
                @endif
            </div>
            <form method="POST" action="{{ route('login') }}" class="formBox">
                @csrf
                <div>
                    <input id="account_id" type="text" placeholder="{{_("メールアドレスまたはアカウントID")}}" class="form-control @error('account_id') is-invalid @enderror" name="account_id" value="{{ old('account_id') }}" required autofocus>
                    @error('account_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div>
                    <input id="password" type="password" placeholder="{{_("パスワード")}}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="saveCheck">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{_("ログイン状態を保存する")}}</label>
                </div>
                <div>
                    <button type="submit" class="btn btnBl submitBtn">{{_("ログイン")}}</button>
                </div>
                <div class="linkBox">
                    @if(isset( $userFlag ))
                        @if($userFlag == "クリエイター")
                            <p class="noLink">{{ __("アカウントID・パスワードを忘れてしまった場合は、担当者までお問い合わせください。")}}</p>
                            <p><a href="{{ url('/login?root=top') }}">{{__("ファンの方はこちら")}}</a></p>
                        @else
                            <p class="noLink">{{_("アカウントID・パスワードを忘れてしまった場合は、管理者までお問い合わせください。")}}</p>
                        @endif
                    @else
                        @if (Route::has('password.request'))
                            <p>{{_("パスワードを忘れてしまった場合は")}}<a class="linkLine" href="{{ route('password.request') }}">{{_("こちら")}}</a></p>
                        @endif
                        <p><a href="{{ route('register') }}">{{_("初めての方はこちら")}}</a></p>
                        <p><a href="{{ url('/creator/login') }}">{{_("クリエイターの方はこちら")}}</a></p>
                    @endif
                </div>
            </form>
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
