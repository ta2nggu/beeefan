@extends('layouts.base')

@section('title','クリエイター新規登録')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
@endsection
@section('body','')

@section('content')
    <header id="header" class="border">
        <h1 class="txtTitle">クリエイター新規登録</h1>
    </header>

    <!--contentWrap-->
    <div id="contentWrap">

        <form method="POST" action="{{ __('/admin/creatorReg') }}" class="formBox normalFormBox">
            @csrf
            <!--name-->
            <dl>
                <dt><label for="name">名前</label><span class="required">必須</span></dt>
                <dd>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </dd>
            </dl>
            <!--nickname-->
            <dl>
                <dt><label for="nickname">クリエイター名</label><span class="required">必須</span><span class="att">※後からクリエイターの設定変更画面にて変更可能です。</span></dt>
                <dd>
                    <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror"  name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>
                    @error('nickname')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
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
            <!--monthly_price-->
            <dl>
                <dt><label for="monthly_price">月額</label><span class="required">必須</span><span class="att">※月額設定後、変更できるのは運営管理者のみです。</span></dt>
                <dd>
                    <div class="monthly_priceBox"><input id="monthly_price" type="text" class="form-control @error('monthly_price') is-invalid @enderror"  name="monthly_price" value="{{ old('monthly_price') }}" required autocomplete="monthly_price" autofocus placeholder="0"></div>
                    @error('monthly_price')
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
            <!--birth_date-->
            <dl>
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

            <!--送信-->
            <input id="role" name="role" type="hidden" value="{{ __('creator') }}">
            <ul class="btnBox">
                <li><button type="submit" class="btn btnAd submitBtn">クリエイターを登録する</button></li>
                <li><button onClick="history.back()" class="btn btnBor btnBorGy">登録せずに戻る</button></li>
            </ul>

            {{--                        <datetime type="datetime" use12-hour></datetime>--}}
        </form>
    </div><!--/contentWrap-->
@endsection
