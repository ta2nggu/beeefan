@extends('layouts.creator')

{{--자기소개 hyper link blade incldue--}}
@include('creator.partials.link')

@section('content')
    <form method="POST" enctype="multipart/form-data" id="upload-image" action="{{ url('upload-image') }}" >

        <div class="image-upload">
{{--            background_img--}}
            <div class="background_img">background_img
                <label for="input_background_img">
                    <img id="preview_background_img" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"/>
                </label>

                <input id="input_background_img" name="background_img" type="file"/>

                @error('background_img')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>

{{--            profile_img--}}
            <div class="profile_img">profile_img
                <label for="input_profile_img">
                    <img id="preview_profile_img" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"/>
                </label>

                <input id="input_profile_img" name="profile_img" type="file"/>

                @error('profile_img')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="creator_name">クリエイター名</div>
        <input name="creator_name" type="text" value="{{ $user[0]->name }}">

        <div class="nickname">Nickname</div>
        <input name="nickname" type="text" value="{{ $user[0]->nickname }}">

        <div class="email">メールアドレス</div>
        <input name="email" type="text" value="{{ $user[0]->email }}" readonly>

        <div class="password">パスワード</div>
        <input name="password" type="password" value="{{ $user[0]->password }}" readonly>

        <div class="instruction">説明文</div>
{{--        <textarea name="instruction" placeholder="テキストを入力してください (2000文字以内)">{{ $user[0]->instruction }}--}}
{{--            <a href="https://www.google.com/">hi</a>--}}
{{--        </textarea>--}}
        <div id="instruction">
            <h4>My Links</h4>
            <p><a href="https://www.google.com/" title="Mouseover Description">Link Text Description</a></p>
        </div>

        <div class="instruction_link">
            <a class="nav-link"
               style="cursor: pointer"
               data-toggle="modal"
               data-target="#add_link">{{ __('リンクを張る') }}</a>

        </div>



        <div class="submit">
            <button type="submit" class="btn btn-primary" id="submit">Submit</button>
        </div>
    </form>



@endsection
