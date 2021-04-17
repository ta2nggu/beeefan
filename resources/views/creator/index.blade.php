@extends('layouts.creator')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
{{--                    <div class="card-header">{{ __('Creator Dashboard') }}</div>--}}
                    <div class="card-header">{{ $user[0]->last_name }}/{{ $user[0]->first_name }}/{{ $user[0]->nickname }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        こんにちは。{{ $user[0]->nickname }} 様。

                        <br><br>
                        투고 수 : <br>
                        회원 수 : <br>
                        수익 : <br>
                        <br>
{{--                        <a href="/creator_write/{{ $user[0]->nickname }}">신규투고</a><br>--}}
{{--                        <a href="/creator_write">테스트 업로드 페이지로 이동</a><br>--}}
                        <div>
                            <a href="/creator/write">投稿する 투고하기</a>
                        </div>
                        <div>
                            <a href="/creator/mypage">マイページ 설정변경</a>
                        </div>

                        <div class="tweets">
                            <div class="flex_images">
                                <div class="post-data">
                                    @include('creator/indexData')
                                </div>
                                <div class="ajax-load text-center">
                                    <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
