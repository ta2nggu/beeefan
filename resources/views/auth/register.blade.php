@extends('layouts.base')

@section('title','新規会員登録')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @slot('header_title')
            {{ __("新規会員登録") }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap">
        <div id="stepBox">
            <div class="normalTitleBox">
                <h2>{{ __("会員情報入力") }}</h2>
                <p>{{ __("会員情報をご入力ください") }}</p>
            </div>
            <ol>
                <li class="active"><p>{{ __("情報入力") }}</p></li>
                <li></li>
                <li></li>
                <li></li>
            </ol>
        </div>

        <form method="POST" action="{{ __('/register') }}" class="formBox normalFormBox">
        @csrf
        <!--account_id-->
            <dl>
                <dt><label for="account_id">{{ __("アカウントID") }}</label><span class="required">{{ __("必須") }}</span><span class="att">{{ __("※半角英数字と「_ -」が使用できます") }}</span></dt>
                <dd>
                    <input id="account_id" type="text" class="@error('account_id') is-invalid @enderror" name="account_id" value="{{ old('account_id') }}" required autocomplete="account_id" autofocus>
                    @error('account_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--birth_date-->
            <dl>
                <dt><label for="birth_date">{{ __("誕生日") }}</label><span class="required">{{ __("必須") }}</span></dt>
                <dd>
                    {{--                                <input id="birth_date" type="text" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>--}}
                    <datetime id="birth_date" class="@error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus type="date" format="yyyy-MM-dd" ref="DatetimePicker"></datetime>
                    @error('birth_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--sex-->
            <dl>
                <dt>{{ __("性別") }}<span class="required">{{ __("必須") }}</span></dt>
                <dd>
                    <div class="clm2 sexBox">
                        <div>
                            <input type="radio" id="male" value=1 name="sex" class="@error('sex') is-invalid @enderror">
                            <label for="male">{{ __("男性") }}</label>
                        </div>
                        <div>
                            <input type="radio" id="female" value=0 name="sex">
                            <label for="female">{{ __("女性") }}</label>
                        </div>
                    </div>
                    @error('sex')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ __('性別を選択してください') }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--prefecture_id-->
            <dl>
                <dt><label for="prefecture_id">{{ __("居住地") }}</label><span class="required">{{ __("必須") }}</span></dt>
                <dd>
                    <select name="prefecture_id" id="prefecture_id" class="prefecture_id @error('prefecture_id') is-invalid @enderror">
                        <option value="" selected disabled hidden>{{ __("ご選択ください") }}</option>
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
                <dt><label for="email">{{ __("メールアドレス") }}</label><span class="required">{{ __("必須") }}</span></dt>
                <dd>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--Password-->
            <dl>
                <dt><label for="password">{{ __("パスワード") }}</label><span class="required">{{ __("必須") }}</span></dt>
                <dd>
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </dd>
            </dl>
            <!--Password-->
            <dl>
                <dt><label for="password-confirm">{{ __("パスワード（確認）") }}</label><span class="required">{{ __("必須") }}</span></dt>
                <dd>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                </dd>
            </dl>

            <!--送信-->
            <input id="role" name="role" type="hidden" value="{{ __('user') }}">
            <p class="txtLink"><a href="{{ url('/rule') }}" target="_blank">{{ __("利用規約") }}</a>{{ __("と") }}<a href="{{ url('/policy') }}" target="_blank">{{ __("プライバシーポリシー") }}</a>{{ __("をご確認ください") }}</p>
            <ul class="btnBox">
                <li><button type="submit" class="btn btnBl submitBtn">{{ __("同意して登録") }}</button></li>
                <li><button onClick="history.back()" class="btn btnCansell">{{ __("登録せずに戻る") }}</button></li>
            </ul>

            {{--                        <datetime type="datetime" use12-hour></datetime>--}}
        </form>
    </div><!--/contentWrap-->
@endsection
