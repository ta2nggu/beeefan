@extends('layouts.base')

@section('title','メールアドレス変更')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @slot('header_title')
            {{ __('メールアドレス変更') }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentTopMar">
        <div>
            <form method="POST" action="{{ __('/email/change') }}" class="formBox normalFormBox">
                @csrf

                <dl class="readonlyBox">
                    <dt>{{ __('現在のメールアドレス') }}</dt>
                    <dd><p class="readonly inputCss">{{ $user[0]->email }}</p></dd>
                </dl>
                <dl>
                    <dt><label for="new_email">{{__('新しいメールアドレス')}}</label><span class="required">{{ __("必須") }}</span></dt>
                    <dd>
                        <input id="new_email" type="text" class="form-control" name="email" autocomplete="off">
                    </dd>
                </dl>
                <dl>
                    <dt><label for="confirm_email">{{__('新しいメールアドレス(確認)')}}</label><span class="required">{{ __("必須") }}</span></dt>
                    <dd><input id="confirm_email" type="text" class="form-control" name="confirm_email" autocomplete="off"></dd>
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
                    @role('administrator|superadministrator')
                        {{-- 21.05.09 김태영, super admin이 admin의 email 변경 --}}
                        <input type="hidden" name="admin_id" value="{{$user[0]->id}}">
                        <li><button type="submit" class="btn btnAd">{{ __('変更する') }}</button></li>
                        <li><button onclick="history.back();" class="btn btnBor btnBorGy">{{ __('変更せずに戻る') }}</button></li>
                    @endrole
                </ul>
            </form>

        </div><!--/contentWrap-->
    </div><!--/contentWrap-->
@endsection
