@extends('layouts.base')

@section('title','ログイン')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1 login fan')

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
                <p class="logo"><a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"></a></p>
                @if(isset( $userFlag ))
                    <h1>{{$userFlag}}ログイン</h1>
                @else
                    <h1>会員ログイン</h1>
                @endif
            </div>
            <form method="POST" action="{{ route('login') }}" class="formBox">
                @csrf
                <div>
                    <input id="email" type="email" placeholder="メールアドレスまたはアカウントID" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div>
                    <input id="password" type="password" placeholder="パスワード" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="saveCheck">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">ログイン状態を保存する</label>
                </div>
                <div>
                    <button type="submit" class="btn btnBl submitBtn">ログイン</button>
                </div>
                <div class="linkBox">
                    @if(isset( $userFlag ))
                        @if($userFlag == "クリエイター")
                            <p class="noLink">アカウントID・パスワードを忘れてしまった場合は、担当者までお問い合わせください。</p>
                            <p><a href="{{ url('/login') }}">ファンの方はこちら</a></p>
                        @else
                            <p class="noLink">アカウントID・パスワードを忘れてしまった場合は、管理者までお問い合わせください。</p>
                        @endif
                    @else
                        @if (Route::has('password.request'))
                            <p>パスワードを忘れてしまった場合は<a class="linkLine" href="{{ route('password.request') }}">こちら</a></p>
                        @endif
                        <p><a href="{{ url('/creator/login') }}">クリエイターの方はこちら</a></p>
                    @endif
                </div>
            </form>
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
