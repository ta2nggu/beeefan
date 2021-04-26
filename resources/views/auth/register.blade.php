@extends('layouts.base')

@section('title','新規会員登録')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
@endsection
@section('body','')

@section('content')
    <header id="header" class="border">
        <h1 class="txtTitle">新規会員登録</h1>
    </header>

    <!--contentWrap-->
    <div id="contentWrap">
        <ol id="stepBox">
            <li class="active"><p>情報入力</p></li>
            <li><p>仮登録完了</p></li>
            <li><p>お支払い方法選択</p></li>
            <li><p>会員登録完了</p></li>
        </ol>

        <form method="POST" action="{{ __('/register') }}" class="formBox normalFormBox">
        @csrf
        <!--account_id-->
            <dl>
                <dt><label for="account_id">アカウントID</label><span class="required">必須</span><span class="att">※半角英数字でご記入ください</span></dt>
                <dd>

                    <input id="account_id" type="text" class="form-control @error('account_id') is-invalid @enderror" name="account_id" value="{{ old('account_id') }}" required autocomplete="account_id" autofocus>
                    @error('account_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>アカウントIDは「英数字 _ -」のみ使用することができます</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--birth_date-->
            <dl id="app">
                <dt><label for="birth_date">誕生日</label><span class="required">必須</span></dt>
                <dd>
                    {{--                                <input id="birth_date" type="text" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>--}}
                    <datetime id="birth_date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus type="date" format="yyyy-MM-dd" ref="DatetimePicker"></datetime>
                    @error('birth_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--sex-->
            <dl>
                <dt>性別<span class="required">必須</span></dt>
                <dd>
                    <div class="clm2 sexBox">
                        <div>
                            <input type="radio" id="male" value=1 name="sex">
                            <label for="male">男性</label>
                        </div>
                        <div>
                            <input type="radio" id="female" value=0 name="sex">
                            <label for="female">女性</label>
                        </div>
                    </div>
                    @error('sex')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--prefecture_id-->
            <dl>
                <dt><label for="prefecture_id">居住地</label><span class="required">必須</span></dt>
                <dd>
                    <select name="prefecture_id" id="prefecture_id" class="prefecture_id @error('prefecture_id') is-invalid @enderror">
                        <option value="" selected disabled hidden>ご選択ください</option>
                        @foreach($Prefectures as $Prefecture)
                            <option value="{{ $Prefecture->id }}">{{ $Prefecture->name }}</option>
                        @endforeach
                    </select>
                    @error('prefecture_id')
                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ __('居住地を選択してください') }}</strong>
                                </span>
                    @enderror
                </dd>
            </dl>
            <!--email-->
            <dl>
                <dt><label for="email">メールアドレス</label><span class="required">必須</span></dt>
                <dd>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--Password-->
            <dl>
                <dt><label for="password">パスワード</label><span class="required">必須</span></dt>
                <dd>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--Password-->
            <dl>
                <dt><label for="password-confirm">パスワード（確認）</label><span class="required">必須</span></dt>
                <dd>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </dd>
            </dl>

            <!--送信-->
            <input id="role" name="role" type="hidden" value="{{ __('user') }}">
            <p class="txtLink"><a href="" target="_blank">利用規約</a>と<a href="" target="_blank">プライバシーポリシー</a>をご確認ください</p>
            <ul class="btnBox">
                <li><button type="submit" class="btn btnBl submitBtn">同意して登録</button></li>
                <li><button onClick="history.back()" class="btn btnBor btnBorGy">登録せずに戻る</button></li>
            </ul>

            {{--                        <datetime type="datetime" use12-hour></datetime>--}}
        </form>
    </div><!--/contentWrap-->
@endsection
