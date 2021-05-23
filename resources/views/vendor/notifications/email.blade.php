<br>
{{$actionText->account_id.' 様'}}<br>
<br>
{{ config('app.name') }}をご利用いただき誠にありがとうございます。<br>
<br>
下記の【メールアドレス認証URL】をクリックして<br>
メールアドレスの登録を完了してください。<br>
<br>
■メールアドレス認証URL<br>
<a href="{{url($actionUrl)}}">{{url($actionUrl)}}</a><br>
<br>
<br>
【お問い合わせ】<br>
こちらのメールアドレスは送信専用です。<br>
直接返信されても返答できませんのであらかじめご了承ください。<br>
ご利用に際してご不明の点がございましたら、下記URLよりご確認ください。<br>
ヘルプ：<a href="{{route('pageHelp')}}">{{route('pageHelp')}}</a><br>
<br>
※本メールにお心当たりが無い場合は、お手数ですが、破棄していただけますようお願いします。<br>
<br>
<br>
――――――――――――――――――――<br>
Beee Fan!<br>
<a href="{{route('top')}}">{{route('top')}}</a><br>
<br>



