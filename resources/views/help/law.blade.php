@extends('layouts.base')

@section('title','特定商取引法に基づく表示')
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
            <h1>特定商取引法に基づく表示</h1>
            <h2>サービス名</h2>
            <p>Beee fan!</p>
            <h2>運営事業者の名称・住所・お問い合わせ先</h2>
            <p>テキストが入ります。テキストが入ります。</p>
            <h2>運営責任者</h2>
            <p>山田 太郎</p>
            <h2>販売価格(役務の対価)</h2>
            <p>都度、購入手続きの際に表示されます。</p>
            <h2>販売価格以外でお客様に発生する金銭</h2>
            <p>本サービス利用及びデジタルコンテンツのダウンロードの際に発生するパケット通信料（発生するパケット通信料の料金は、お客様の契約形態により異なります。）</p>
            <h2>代金の支払いとその時期について</h2>
            <p>お客様がご利用の決済代行会社から請求いたします。お支払い時期等は各社のご契約内容に基づきます。</p>
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
