@extends('layouts.base')

@section('title', '退会手続き')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','')

@section('content')
    @component ('components.header')
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap" class="contentTopMar">
        @auth
            <!--ユーザーアカウント-->
            @role('user')
                <div class="helpBox">

                    <h1>{{__('当サイトの退会')}}</h1>
                    <p>{{__('こちらのページから当サイトを退会することができます。退会する前に、必ず以下の注意事項をお読みになり、ご同意の上、ページ下部の退会ボタンから退会処理を行なってください。')}}</p>
                    <h2>{{__('退会についてのご注意')}}</h2>
                    <p>{{__('退会される場合、現在保存されている会員情報は全て削除されます。退会されると同時にサービスがご利用できなくなります。それでも退会をご希望される場合は、下記より退会手続きを行ってください。')}}</p>

                    <div class="centerCheckbox">
                        <input type="checkbox" id="join_chk" class="colorPi">
                        <label for="join_chk">{{ __('上記の内容に同意する')}}</label>
                    </div>
                    <ul class="btnBox">
                        <li><div onclick="history.go(-1)" class="btn btnBl">{{ __('退会をキャンセル') }}</div></li>
                        <li><button type="button" class="btn btnBor btnBorBl disabledBor" id="join_submit" disabled
                                    data-toggle="modal"
                                    data-target="#removeDr">{{ __('退会する') }}</button></li>
                    </ul>
                    <!--退会確認ポップアップ-->
                    <div id="removeDr" class="modal fade warningBox" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="titleText">退会する</p>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-warning">
                                    <p>退会したら取り消せません。退会してもよろしいですか？</p>
                                </div>
                                <form action="{{ __('') }}" method="POST" class="formBox normalFormBox">
                                    @csrf
                                    {{--                                <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">--}}
                                    <ul class="btnBox modal-footer">
                                        <li><button type="submit" class="btn btnSS btnCircle btnBk">{{ __('はい') }}</button></li>
                                        <li><button type="button" class="btn btnSS btnCircle" data-dismiss="modal">{{ __('いいえ') }}</button></li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!--クリエイター/運営者アカウント-->
                <div class="normalTitleBox">
                    <h2>{{ __("当サイトの退会") }}</h2>
                    <p>{!! 'このアカウントはサイト上から<br>退会することができません。<br>担当者までお問い合わせください。' !!}</p>
                    <a class="btn btnS btnBl" href="{{ url('/') }}">{{ __('トップページ') }}</a></div>
                </div>
            @endrole
        @else
            <!--未ログイン-->
            <div class="normalTitleBox">
                <h2>{{ __("当サイトの退会") }}</h2>
                <p>{!! '当サイトを退会するには、ログインしてください。' !!}</p>
                <a class="btn btnS btnBl" href="{{ url('/login') }}">{{ __('ログイン') }}</a></div>
            </div>
        @endauth
    </div><!--/contentWrap-->
@endsection
