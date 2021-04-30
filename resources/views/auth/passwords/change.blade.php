@extends('layouts.base')

@section('title','パスワード変更')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @slot('header_title')
            {{ __('パスワード変更') }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentTopMar">
        <div>

            <form method="POST" action="{{ __('/password/change') }}" class="formBox normalFormBox">
                @csrf

                <dl>
                    <dt><label for="password">{{__('現在のパスワード')}}</label><span class="required">{{ __("必須") }}</span></dt>
                    <dd><input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password"></dd>
                </dl>
                <dl>
                    <dt><label for="password">{{__('新しいパスワード')}}</label><span class="required">{{ __("必須") }}</span></dt>
                    <dd><input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password"></dd>
                </dl>
                <dl>
                    <dt><label for="password" class="col-md-4 col-form-label text-md-right">{{__('新しいパスワード(確認)')}}</label></dt>
                    <dd><input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password"></dd>
                </dl>

                @foreach ($errors->all() as $error)
                    <span class="invalid-feedback" role="alert"><strong>{{ $error }}</strong></span>
                @endforeach

                <ul class="btnBox">
                    @role('creator')
                    <li><button type="submit" class="btn btnPi">{{ __('変更する') }}</button></li>
                    <li><button onclick="history.back();" class="btn btnBor btnBorLp">{{ __('変更せずに戻る') }}</button></li>
                    @endrole
                    @role('user')
                    <li><button type="submit" class="btn btnBl">{{ __('変更する') }}</button></li>
                    <li><button onclick="history.back();" class="btn btnBor btnBorGy">{{ __('変更せずに戻る') }}</button></li>
                    @endrole
                    @role('administrator')
                    <li><button type="submit" class="btn btnAd">{{ __('変更する') }}</button></li>
                    <li><button onclick="history.back();" class="btn btnBor btnBorGy">{{ __('変更せずに戻る') }}</button></li>
                    @endrole
                </ul>
            </form>

        </div><!--/contentWrap-->
    </div><!--/contentWrap-->
@endsection

