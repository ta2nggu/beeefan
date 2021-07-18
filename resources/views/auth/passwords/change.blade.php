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
                    <dt><label for="password">{{__('新しいパスワード(確認)')}}</label><span class="required">{{ __("必須") }}</span></dt>
                    <dd><input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password"></dd>
                </dl>

                @foreach ($errors->all() as $error)
                    <span class="invalid-feedback" role="alert"><strong>{{ $error }}</strong></span>
                @endforeach

                <ul class="btnBox">
                    @role('creator')
                    <li><button type="submit" class="btn btnPi">{{ __('変更する') }}</button></li>
                    <li><a class="btn btnBor btnBorLp" href="{{ url('/creator/setting') }}">{{ __('変更せずに戻る') }}</a></li>
                    @endrole
                    @role('user')
                    <li><button type="submit" class="btn btnBl">{{ __('変更する') }}</button></li>
                    <li><a class="btn btnBor btnBorGy" href="{{ url('/mypage') }}">{{ __('変更せずに戻る') }}</a></li>
                    @endrole
                    @role('superadministrator')
                    {{-- 21.05.09 김태영, super admin이 admin의 email 변경 --}}
                    @if(isset($redirect_url))
                        <input type="hidden" name="target_id" value="{{$user[0]->id}}">
                        <input type="hidden" name="redirect_url" value="{{ $redirect_url }}">
                    @else
                        <input type="hidden" name="target_id" value="{{$user[0]->id}}">
                        <input type="hidden" name="redirect_url" value="{{ __('/admin/admins/list') }}">
                    @endif
                    @endrole
                    @role('administrator|superadministrator')
                    <li><button type="submit" class="btn btnAd">{{ __('変更する') }}</button></li>
                    <li><a class="btn btnBor btnBorGy" href="{{ url('/admin/index') }}">{{ __('変更せずに戻る') }}</a></li>
                    @endrole
                </ul>
            </form>

        </div><!--/contentWrap-->
    </div><!--/contentWrap-->
@endsection

