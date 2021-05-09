@extends('layouts.base')

@section('title','運営者一覧')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
@section('body','admin admins')

@section('content')

    @component ('components.header')
        @slot('header_title')
            {{ __("運営者一覧") }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap" class="contentBtmMar">

        @if (session('flash_message'))
            <div class="flashMsg">
                <p>{{ session('flash_message') }}</p>
            </div>
        @endif

        @if($new != '')
            <div class="flashMsg">
                <p>{!! $new->last_name.' '.$new->first_name.'さんの登録が完了しました'!!}</p>
            </div>
        @endif

        <div id="adminRegBtn" class="btnBox">
            <p><a href="{{ url('/admin/adminReg') }}" class="btn btnAd">{{__('運営者新規登録')}}</a></p>
        </div>

        <ul id="adminList">
            @if(count($admins)>=1)
                @foreach($admins as $admin)
                    <li>
                        <a href="{{url('/aDetail/'.$admin->user_id)}}">
                            <p class="name">{{ $admin->last_name }} {{ $admin->first_name }}</p>
                            <p class="txtLink">詳細はこちら</p>
                        </a>
                    </li>
                @endforeach
            @else
                <div class="noDateBox noDateBoxBorder"><p class="noDateText">{{ __('運営者が未登録です') }}</p></div>
            @endif
        </ul>

    @component ('components.bottomFixed')
    @endcomponent

    </div><!--/contentWrap-->
@endsection

