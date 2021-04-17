@extends('layouts.creator')

{{--자기소개 hyper link blade incldue--}}
@include('creator.partials.link')

@section('content')
    <form method="POST" enctype="multipart/form-data" id="upload-image" action="{{ __('/creator/mypage') }}" >
        @csrf

        <div class="image-upload">
{{--            background_img--}}
            <div class="background_img">background_img
                <label for="input_background_img">
                    <img id="preview_background_img" src="@if (isset($user[0]->background_img)) {{ asset('storage/images/'.$user[0]->user_id.'/'.$user[0]->background_img) }} @else https://www.riobeauty.co.uk/images/product_image_not_found.gif @endif"/>
                </label>

                <input id="input_background_img" name="background_img" type="file"/>

                @error('background_img')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>

{{--            profile_img--}}
            <div class="profile_img">profile_img
                <label for="input_profile_img">
                    <img id="preview_profile_img" src="@if (isset($user[0]->profile_img)) {{ asset('storage/images/'.$user[0]->user_id.'/'.$user[0]->profile_img) }} @else https://www.riobeauty.co.uk/images/product_image_not_found.gif @endif"/>
                </label>

                <input id="input_profile_img" name="profile_img" type="file"/>

                @error('profile_img')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="creator_name">クリエイター名</div>
        <input name="last_name" type="text" value="{{ $user[0]->last_name }}" placeholder="last name">
        <input name="first_name" type="text" value="{{ $user[0]->first_name }}" placeholder="first name">

        <div class="nickname">Nickname</div>
        <input name="nickname" type="text" value="{{ $user[0]->nickname }}">

        <div class="email">メールアドレス</div>
        <input name="email" type="text" value="{{ $user[0]->email }}" readonly>
        <a href="{{ __('/email/change') }}">メールアドレスを変更します。</a>

        <div class="password">パスワード</div>
        <input name="password" type="password" value="{{ $user[0]->password }}" readonly>
        <a href="{{ __('/password/change') }}">パスワードを変更します。</a>

        <div class="instruction">説明文
            <div id="instruction">
                {!! $user[0]->instruction !!}
            </div>
            <input id="c_mypage_instruction" name="instruction" type="hidden" value="" readonly>
        </div>

        <div class="instruction_link">
            <a class="nav-link"
               style="cursor: pointer"
               data-toggle="modal"
               data-target="#add_link">{{ __('リンクを張る') }}</a>

        </div>

        <div class="submit">
            <button type="submit" class="btn btn-primary" id="c_mypage_submit">変更する</button>
        </div>
        <div>
            <a href="{{ __('/creator/index') }}" class="btn btn-secondary">変更せずに戻る</a>
        </div>

    </form>



@endsection
