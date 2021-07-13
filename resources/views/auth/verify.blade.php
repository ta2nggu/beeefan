@extends('layouts.base')

@section('title','メールアドレス認証')
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
                    @if (session('flash_message'))
                        <p>{!! ("メールアドレスの変更を完了するには<br>下記の「送信ボタン」をクリックし<br>メールに記載されたURLから<br>認証を行ってください。<br><br>新しいメールアドレス<br>").$user->email !!}</p>
                    @else
                        @if (session('resent'))
                            <p>{!! ("送信完了しました。<br>メールが届かない場合は下記の宛先まで<br>お問い合わせください。<br>info@beeefan.com") !!}</p>
                        @else
                            <p>{!! ("メールアドレスの認証をしてください。<br>下記の「送信ボタン」をクリックし<br>メールに記載されたURLから<br>認証を完了してください。<br><br>登録中のメールアドレス<br>").$user->email !!}</p>
                        @endif
                    @endif
                </div>
            </div>
            <form class="formBox" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <ul class="btnBox wrap_inner">
                    <li><button type="submit" class="btn btnS btnCircle btnBl">{{ __('認証メールを送信する') }}</button></li>
                    <li><a href="{{route('top')}}" class="btn btnS btnCircle btnBor btnBorBl">{{ __('トップページに戻る') }}</a></li>
                </ul>
            </form>

        </div>

    </div><!--/contentWrap-->
@endsection
