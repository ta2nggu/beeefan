@extends('layouts.base')

@section('title','運営者新規登録')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
@endsection
@section('body','')

@section('content')
    @component ('components.header')
        @slot('header_title')
            <span class="name">{{$admin->last_name}} {{$admin->first_name}}</span>{{ __('運営者情報') }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentTopMar contentBtmMar">

        <form method="POST" action="{{ __('/admin/del') }}" class="formBox normalFormBox">
            @csrf

            <dl class="readonlyBox">
                <dt>{{__('名前')}}</dt>
                <dd>
                    <p class="inputCss">{{$admin->last_name}} {{$admin->first_name}}</p>
                </dd>
            </dl>
            <dl class="readonlyBox">
                <dt>{{__('アカウントID')}}</dt>
                <dd>
                    <p class="inputCss">{{$admin->account_id}}</p>
                </dd>
            </dl>
            <dl class="readonlyBox">
                <dt>{{__('メールアドレス')}}</dt>
                <dd>
                    <p class="inputCss">{{$admin->email}}</p>
                    <p class="txtLink NoMrg right"><a href="{{ url('/email/'.$admin->id) }}">{{__('メールアドレスを変更する')}}</a></p>
                </dd>
            </dl>
{{--            <dl class="readonlyBox">--}}
{{--                <dt>{{__('パスワード')}}</dt>--}}
{{--                <dd>--}}
{{--                    <p class="inputCss">{{__('*********')}}</p>--}}
{{--                    <p class="txtLink NoMrg right"><a href="{{ url('/password/'.$admin->id) }}">{{__('パスワードを変更する')}}</a></p>--}}
{{--                </dd>--}}
{{--            </dl>--}}

            <ul class="btnBox">
                <li><a class="btn btnBor btnBorGy"
                       data-toggle="modal"
                       data-target="#warningDre">{{ __('削除する') }}</a></li>
                <li><a href="{{url('/admin/admins/list')}}" class="btn btnAd">{{ __('一覧にもどる') }}</a></li>
            </ul>
            <!--削除ポップアップ-->
            <div class="modal fade warningBox" id="warningDre" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="titleText">アカウントを削除</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-warning">
                            <p>{{$admin->last_name}} {{$admin->first_name}}は運営者から削除されます。一度削除すると取り消すことができません。削除してもよろしいですか？</p>
                        </div>
                        <input type="hidden" name="admin_id" value="{{$admin->id}}">
                        <ul class="btnBox modal-footer">
                            <li><button type="submit" class="btn btnSS btnCircle btnBk">{{ __('はい') }}</button></li>
                            <li><button type="button" class="btn btnSS btnCircle" data-dismiss="modal">{{ __('いいえ') }}</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>

        @component ('components.bottomFixed')
        @endcomponent

    </div><!--/contentWrap-->
@endsection


