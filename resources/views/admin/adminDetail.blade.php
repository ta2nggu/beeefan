<h1>{{$admin->last_name}} {{$admin->first_name}}</h1>
<h2>アカウントID</h2>
<h3>{{$admin->account_id}}</h3>
<h2>メールアドレス</h2>
<h3>{{$admin->email}}</h3>
<a href="{{ url('/email/'.$admin->id) }}">メールアドレスを変更する</a>
<h2>パスワード</h2>
<h3>{{__('*********')}}</h3>
<a href="{{ url('/password/'.$admin->id) }}">パスワードを変更する</a>
<form method="POST" action="{{ __('/admin/del') }}">
    @csrf

    <input type="hidden" name="admin_id" value="{{$admin->id}}">
    <button type="submit" class="btn btnAd">{{ __('削除する') }}</button>
</form>
