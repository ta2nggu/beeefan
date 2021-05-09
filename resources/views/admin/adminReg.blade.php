<h1>{{__('運営者新規登録')}}</h1>
<form method="POST" action="{{ __('/admin/adminReg') }}">
    @csrf

    <h2>{{ __('名前') }}</h2>
    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="性">
    <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="名">

    @error('last_name')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror
    @error('first_name')
    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
    @enderror

    <h2>{{ __('メールアドレス') }}</h2>
    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror

    <h2>{{ __('アカウントID') }}</h2>
    <input id="account_id" type="text" class="form-control @error('account_id') is-invalid @enderror" name="account_id" value="{{ old('account_id') }}" required autocomplete="account_id" autofocus>
    @error('account_id')
    <span class="invalid-feedback" role="alert">
        <strong>{{ __('アカウントIDは「英数字 _ -」のみ使用することができます') }}</strong>
    </span>
    @enderror

    <h2>{{ __('パスワード') }}</h2>
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
    @error('password')
    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
    @enderror

    <h2>{{ __('パスワード（確認）') }}</h2>
    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

    <button type="submit" class="btn btnAd submitBtn">{{ __('クリエイターを登録する') }}</button>
    <button onClick="history.back()" class="btn btnBor btnBorGy">{{ __('登録せずに戻る') }}</button>
</form>
