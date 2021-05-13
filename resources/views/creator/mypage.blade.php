@extends('layouts.base')

@section('title','プロフィール編集')
@section('pageCss')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_creator.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/creator.js') }}" defer></script>
@endsection
@section('body','profileEdit')

@section('content')
    @component ('components.header')
        @slot('header_title')
            {{ __('プロフィール編集') }}
        @endslot
    @endcomponent

    <!--contentWrap-->
    <div id="contentWrap">

        {{--자기소개 hyper link blade incldue--}}
        @include('creator.partials.link')

        <form method="POST" enctype="multipart/form-data" class="formBox normalFormBox" id="upload-image" action="{{ __('/creator/mypage') }}" >
            @csrf

            <div id="profileEditImg" class="image-upload">
    {{--            background_img--}}
                <div class="background_img">
                    <label for="input_background_img" >
                        @if (isset($user[0]->background_img))
                            <img id="preview_background_img" src="{{ asset('storage/images/'.$user[0]->user_id.'/'.$user[0]->background_img) }}" alt="">
                        @else
                            <img id="preview_background_img" src="{{ asset('storage/icon/no_images_c_bk.png') }}" alt=""></img>
                        @endif
                    </label>
                    <input id="input_background_img" name="background_img" type="file"/>
                    @error('background_img')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
    {{--            profile_img--}}
                <div class="profile_img">
                    <label for="input_profile_img">
                        @if (isset($user[0]->profile_img))
                            <img id="preview_profile_img" src="{{ asset('storage/images/'.$user[0]->user_id.'/'.$user[0]->profile_img) }}" alt="">
                        @else
                            <img id="preview_profile_img" src="{{ asset('storage/icon/no_images_c.png') }}" alt="">
                        @endif
                    </label>
                    <input id="input_profile_img" name="profile_img" type="file"/>
                    @error('profile_img')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="profileEditText" class="wrap_inner">
                <dl>
                    <dt>クリエイター名</dt>
                    <dd><input name="nickname" type="text" value="{{ $user[0]->nickname }}"></dd>
                </dl>
                <dl>
                    <dt>名前</dt>
                    <dd class="nameBox">
                        <input name="last_name" type="text" value="{{ $user[0]->last_name }}" placeholder="姓">
                        <input name="first_name" type="text" value="{{ $user[0]->first_name }}" placeholder="名">
                    </dd>
                </dl>
                <dl class="readonlyBox">
                    <dt>メールアドレス</dt>
                    <dd>
                        <input class="readonly" name="email" type="text" value="{{ $user[0]->email }}" readonly>
                        <a href="{{ url('/email/change') }}">メールアドレスを変更する</a>
                    </dd>
                </dl>
                <dl class="readonlyBox">
                    <dt>パスワード</dt>
                    <dd>
                        <p class="inputCss">*********</p>
                        <a href="{{ url('/password/change') }}">パスワードを変更する</a>
                    </dd>
                </dl>
                <dl>
                    <dt>説明文</dt>
                    <dd>
                        <div id="instruction">
                            {!! $user[0]->instruction !!}
                            <input id="c_mypage_instruction" name="instruction" type="hidden" value="{{$user[0]->instruction}}" readonly>
                        </div>
                        <div class="instruction_link">
                            <a class="nav-link"
                               data-toggle="modal"
                               data-target="#add_link">{{ __('リンクを貼る') }}</a>
                        </div>
                    </dd>
                </dl>

                <ul class="btnBox">
                    <li><button type="submit" class="btn btnPi" id="c_mypage_submit">{{ __('変更する') }}</button></li>
                    <li><a class="btn btnBor btnBorLp" href="{{ url('/creator/index') }}">{{ __('変更せずに戻る') }}</a></li>
                </ul>
            </div>

        </form>

    </div><!--/contentWrap-->
@endsection

