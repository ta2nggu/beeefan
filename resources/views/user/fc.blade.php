@extends('layouts.base')

@section('title', 'マイページ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_user.css') }}">
@endsection
@section('body','fanclub')

@section('content')
    @component ('components.header')
        @section('page_back')
            <div class="formBox"><button onClick="history.back()" class="back">{{ __('戻る') }}</button></div>
        @endsection
    @endcomponent
    <!--contentWrap-->
    <div id="contentWrap" class="contentBtmMar">
        <dl>
            <dt>詳細</dt>
            <dd>
                <p>{{$creator->account_id}}</p>
                <p>{!! '月額 '. $creator->id .'円(税込)' !!}</p>
            </dd>
        </dl>

        @component ('components.bottomFixed')
        @endcomponent
    </div><!--/contentWrap-->
@endsection
