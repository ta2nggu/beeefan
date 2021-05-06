@extends('layouts.base')

@section('title','お知らせ')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/style_admin.css') }}">
@endsection
@section('body','')

@section('content')

    @component ('components.header')
        @slot('header_title')
            {{ __('お知らせ') }}
        @endslot
    @endcomponent
    <!--contentWrap-->
    <li id="contentWrap" class="contentTopMar contentBtmMar">
        <div id="adminNotice">

            <div class="ttlBox">
                <h2>{{__('お知らせ一覧')}}</h2>
            </div>

            <div id="adminNoticeList">
                @if(count($notices)>=1)
                    <ul>
                        @foreach($notices as $notice)
                            <li>
                                <div class="inner">
                                    <h3>{{ $notice->title }}</h3>
                                    <p>{{ $notice->body }}</p>
                                    <form method="POST" action="{{ __('/admin/delNotice') }}" class="formBox">
                                        @csrf
                                        <input type="hidden" name="notice_id" value="{{ $notice->id }}">
                                        <button type="submit">{{ __('削除する') }}</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="noDateText">{{ __('投稿がありません') }}</p>
                @endif
            </div>

            <div class="ttlBox">
                <h2>{{__('お知らせ投稿')}}</h2>
                <p>{{__('※一度投稿すると編集できません')}}</p>
            </div>
            <form method="POST" action="{{ __('/admin/notice') }}" class="formBox normalFormBox">
                @csrf
                <dl>
                    <dt>{{__('タイトル')}}<span class="required">{{ __('必須') }}</span></dt>
                    <dd><input type="text" name="title" value="{{ old('title') }}"></dd>
                </dl>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <dl>
                    <dt>{{__('本文')}}<span class="required">{{ __('必須') }}</span></dt>
                    <dd><textarea type="text" name="body" rows="5">{{{ old('body') }}}</textarea></dd>
                </dl>
                @error('body')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <ul class="btnBox">
                    <li><button type="submit" class="btn btnAd submitBtn">{{ __('投稿する') }}</button></li>
                    <li><button onClick="history.back()" class="btn btnBor btnBorGy">{{ __('投稿せずに戻る') }}</button></li>
                </ul>
            </form>
        </div>

        @component ('components.bottomFixed')
        @endcomponent

    </div><!--/contentWrap-->
@endsection
