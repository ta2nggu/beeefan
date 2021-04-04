@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="account_id" class="col-md-4 col-form-label text-md-right">{{ __('Account ID') }}</label>

                            <div class="col-md-6">
                                <input id="account_id" type="text" class="form-control @error('account_id') is-invalid @enderror" name="account_id" value="{{ old('account_id') }}" required autocomplete="account_id" autofocus>

                                @error('account_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __('Account ID는 영문, 숫자, -_ 만 사용할 수 있습니다.') }}</strong>
{{--                                        <strong>{{ $message }}</strong>--}}
                                </span>
                                @enderror
                            </div>
{{--                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>--}}

{{--                                @error('name')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                        </div>

                        <div class="form-group row">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-right">{{ __('Birth day 誕生日') }}</label>

                            <div class="col-md-6">
                                {{--                                <input id="birth_date" type="text" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>--}}
                                <datetime id="birth_date" class="form-control datetime @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus type="date" format="yyyy-MM-dd" ref="DatetimePicker"></datetime>
                                @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sex" class="col-md-4 col-form-label text-md-right">{{ __('성별') }}</label>

                            <div class="col-md-6">
                                <div class="sex">
                                    <input type="radio" id="male" value=1 name="sex" checked>
                                    <label for="male">남자</label>
                                    <input type="radio" id="female" value=0 name="sex">
                                    <label for="female">여자</label>
                                </div>
                                @error('sex')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prefecture_id" class="col-md-4 col-form-label text-md-right">{{ __('거주지') }}</label>

                            <div class="col-md-6">
                                <select name="prefecture_id" id="prefecture_id" class="prefecture_id @error('prefecture_id') is-invalid @enderror">
                                    <option value="" selected disabled hidden>선택해주세요.</option>
                                    @foreach($Prefectures as $Prefecture)
                                        <option value="{{ $Prefecture->id }}">{{ $Prefecture->name }}</option>
                                    @endforeach
                                </select>
                                @error('prefecture_id')
                                <span class="invalid-feedback" role="alert">
{{--                                        <strong>{{ $message }}</strong>--}}
                                    <strong>{{ __('거주지를 선택하세요') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

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
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

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
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

{{--                        21.04.04 김태영, nickname 사용 안함--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ __('Nick Name 別名') }}</label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror"  name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>--}}

{{--                                @error('nickname')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                        21.04.04 김태영, laratrust 사용자 권한 적용--}}
                        <input id="role" name="role" type="hidden" value="{{ __('user') }}">

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
