@extends('layouts.base')

@section('title','エラー')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection
@section('body','view1 errorPage')

@section('content')
    <!--contentWrap-->
    <div id="contentWrap">
        <div>
            <div class="title">
                <h1 class="logo"><img src="{{ asset('storage/common/logo.png') }}" alt="{{ config('app.name') }}"></h1>
            </div>
            <div class="normalTitleBox wrap_inner">
                <p>{!! '仮登録から1時間を超えた為、<br>アカウントが無効になりました。<br>再度、新規登録からやり直してください。' !!}</p>

            </div>
            <form action="{{ route('accountInvalid.post') }}" method="POST" class="formBox normalFormBox">
                @csrf
                <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                <ul class="btnBox modal-footer">
                    <li><button type="submit" class="btn btnCircle btnBk">{{__('アカウントを削除して新規登録する')}}</button></li>
                </ul>
            </form>
        </div>
    </div><!--/contentWrap-->
    @component ('components.footer')
    @endcomponent
@endsection
