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
            <p>Beee Fan!</p>
            <h2>運営事業者の名称</h2>
            <p>大阪市西区北堀江1-14-19-311<br>
                株式会社IKOI</p>
            <h2>お問い合わせ先</h2>
            <p>電話番号：06-6534-8707<br>
                メールアドレス：（未定）</p>
            <h2>運営責任者</h2>
            <p>長島 達也</p>
            <h2>役務の対価</h2>
            <p>都度、購入手続の際に表示されます。</p>
            <h2>役務の対価以外でお客様に発生する金銭</h2>
            <p>本サービス利用及びデジタルコンテンツのダウンロードの際に発生するパケット通信料<br>
                ※発生するパケット通信料の料金は、お客様の契約形態により異なります。</p>
            <h2>代金の支払とその時期について</h2>
            <p>お客様ご利用の決済代行会社から請求いたします。お支払時期等は各社のご契約内容に基づきます。</p>
            <h2>役務の提供時期</h2>
            <p>本サービスの利用規約を内容とする契約を締結している期間中随時<br>
                なお、デジタルコンテンツはダウンロード時から利用できます。</p>
            <h2>返品について</h2>
            <p>本サービス及びデジタルコンテンツの性格上、返品には応じられません。</p>
            <h2>推奨環境・対応機種について</h2>
            <p>iOS Apple iOS 9.0以上で搭載されているSafari9.0以上<br>
                Android Android OS 6.0以上　GoogleChrome 最新版</p>
            <h2>解約について</h2>
            <p>本サービスは、特定商取引法に規定されるクーリング・オフが適用されるサービスではありません。</p>
            <h2>定期課金方式の注意事項</h2>
            <p>契約期間途中の解約となった場合も契約満了日までの料金が発生し、日割精算等による返金を含めた一切の返金は行われません。その場合、サービスも契約満了日まで提供されます。</p>
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
