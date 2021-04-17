@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('クリエイター新規登録') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ __('/admin/creatorReg') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('氏名') }}</label>

                                <div class="col-md-6">
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
                                </div>
                            </div>

{{--                            クリエイター名 = nickname--}}
                            <div class="form-group row">
                                <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ __('クリエイター名') }}</label>

                                <div class="col-md-6">
                                    <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror"  name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>

                                    @error('nickname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="account_id" class="col-md-4 col-form-label text-md-right">{{ __('アカウントID') }}</label>

                                <div class="col-md-6">
                                    <input id="account_id" type="text" class="form-control @error('account_id') is-invalid @enderror" name="account_id" value="{{ old('account_id') }}" required autocomplete="account_id" autofocus>

                                    @error('account_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ __('Account ID는 영문, 숫자, -_ 만 사용할 수 있습니다.') }}</strong>
{{--                                        <strong>{{ $message }}</strong>--}}
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('パスワード(確認)') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="month_price" class="col-md-4 col-form-label text-md-right">{{ __('月額') }}</label>

                                <div class="col-md-6">
                                    <input type="number" class="form-control @error('month_price') is-invalid @enderror"  name="month_price" value="{{ old('month_price', 0) }}" required autocomplete="month_price" autofocus>

                                    @error('month_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

{{--21.04.15 김태영, 성별, 생일 제거--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="sex" class="col-md-4 col-form-label text-md-right">{{ __('성별') }}</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <div class="sex">--}}
{{--                                        <input type="radio" id="male" value=1 name="sex" checked>--}}
{{--                                        <label for="male">남자</label>--}}
{{--                                        <input type="radio" id="female" value=0 name="sex">--}}
{{--                                        <label for="female">여자</label>--}}
{{--                                    </div>--}}
{{--                                    @error('sex')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="form-group row">--}}
{{--                                <label for="birth_date" class="col-md-4 col-form-label text-md-right">{{ __('Birth day 誕生日') }}</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    --}}{{--                                <input id="birth_date" type="text" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>--}}
{{--                                    <datetime id="birth_date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus type="date" format="yyyy-MM-dd" ref="DatetimePicker"></datetime>--}}
{{--                                    @error('birth_date')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <input id="role" name="role" type="hidden" value="{{ __('creator') }}">

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>


                            {{--                        <datetime type="datetime" use12-hour></datetime>--}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
