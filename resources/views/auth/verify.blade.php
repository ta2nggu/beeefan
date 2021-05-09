@extends('layouts.base')

@section('title','仮登録完了')
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
                    <h2>{{ __("メールアドレス認証") }}</h2>
                    @if (session('resent'))
                        <p>{!! ("送信完了しました。<br>メールが届かない場合は下記の宛先まで<br>お問い合わせください。<br>beeefun@example.com") !!}</p>
                    @else
                        <p>{!! ("ご登録いただいたメールアドレスに<br>受信確認用のメールを送信しました。<br>メールに記載されたURLから<br>認証を完了してください。") !!}</p>
                    @endif
                </div>
            </div>

            <form class="formBox" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <ul class="btnBox wrap_inner">
                    <li><button type="submit" class="btn btnS btnCircle btnBorGy">{{ __('認証メールを再度送信する') }}</button></li>
                </ul>
            </form>
        </div>

    </div><!--/contentWrap-->
@endsection
