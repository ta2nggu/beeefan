@extends('layouts.base')

@section('title','ヘルプ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentTopMar contentBtmMar">
        <div class="helpBox">
            <h1>ヘルプ</h1>
            <h2>お問い合わせ</h2>
            <p>「よくある質問」をご覧になっても問題が解決しない場合は、以下の各連絡先までお問い合わせください。<br>
                連絡先：</p>
            <h2>よくある質問</h2>
            <dl>
                <dt>どういうサービスですか？</dt>
                <dd>テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。<br>
                    テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。</dd>
                <dt>ファンとはなんですか？</dt>
                <dd>テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。<br>
                    テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。</dd>
                <dt>クリエイターとはなんですかクリエイターとはなんですか？</dt>
                <dd>テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。<br>
                    テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。</dd>
                <dt>どういうサービスですか？</dt>
                <dd>テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。<br>
                    テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。</dd>
                <dt>ファンとはなんですか？</dt>
                <dd>テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。<br>
                    テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。テキストが入ります。</dd>
                <dt>当サイトの退会について</dt>
                <dd><a href="{{ route('removeAccount.show') }}">こちら</a>から退会処理を行なってください。</dd>
            </dl>
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
