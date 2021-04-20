@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $creator[0]->last_name }}/{{ $creator[0]->first_name }}/{{ $creator[0]->nickname }}</div>
                    <div class="background_img" style="width: 150px; height: 150px;">background_img
                        <img id="preview_background_img" src="@if (isset($creator[0]->background_img)) {{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->background_img) }} @else https://www.riobeauty.co.uk/images/product_image_not_found.gif @endif" style="height: 100%; width: 100%;"/>
                    </div>
                    <div class="profile_img" style="width: 150px; height: 150px;">profile_img
                        <img id="preview_profile_img" src="@if (isset($creator[0]->profile_img)) {{ asset('storage/images/'.$creator[0]->user_id.'/'.$creator[0]->profile_img) }} @else https://www.riobeauty.co.uk/images/product_image_not_found.gif @endif" style="height: 100%; width: 100%;"/>
                    </div>

                    <div class="card-body">
                        <div class="instruction">{!! $creator[0]->instruction  !!}</div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($follow === 0)
                            <div><a href="{{ $creator[0]->account_id }}{{ __('/join') }}">入会する 입회하다</a></div>
                        @endif
                        <div><a href="">マイページにログイン 마이페이지 로그인</a></div>

                        <div class="tweets">
                            <div class="flex_images post-data">
                                @include('mainData')
                            </div>
                        </div>

                        <div class="ajax-load text-center">
                            <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

