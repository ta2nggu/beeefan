<br>
{{$user->account_id.' 様'}}<br>
<br>
Beee Fan!をご利用いただき誠にありがとうございます。<br>
<br>
パスワードリセットのリクエストがありました。<br>
下記の【パスワードリセットのURL】をクリックして<br>
パスワードの変更を完了してください。<br>
<br>
■パスワードリセットのURL<br>
<a href="{{url($reset_url)}}">{{url($reset_url)}}</a><br>
<br>
なお、本メール受信後60分を過ぎますとリクエストが無効となります。<br>
その場合は、最初からやり直してください。<br>
<a href="{{route('password.request')}}">{{route('password.request')}}</a><br>
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
