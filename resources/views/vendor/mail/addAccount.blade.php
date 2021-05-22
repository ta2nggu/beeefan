<br>
{{$user->account_id.' 様'}}<br>
<br>
Beee Fan!をご利用いただき誠にありがとうございます。<br>
<br>
サイトへの仮登録が完了いたしました。<br>
引き続き、下記の【本登録完了専用のURL】をクリックして<br>
本登録のお手続きをお願いいたします。<br>
<br>
■本登録完了専用のURL<br>
@isset($fc_id)
    <a href="{{url('/register/'.$user->email_verify_token.'?email='.$user->email.'&fc_id='.$fc_id)}}">{{url('/register/'.$user->email_verify_token.'?email='.$user->email.'&fc_id='.$fc_id)}}</a><br>
@else
    <a href="{{url('/register/'.$user->email_verify_token.'?email='.$user->email)}}">{{url('/register/'.$user->email_verify_token.'?email='.$user->email)}}</a><br>
@endisset
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
