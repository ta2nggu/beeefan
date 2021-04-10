@extends('layouts.creator')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
{{--                    <div class="card-header">{{ __('Creator Dashboard') }}</div>--}}
                    <div class="card-header">{{ $user[0]->name }}/{{ $user[0]->nickname }}</div>

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
{{--                                @foreach($tweets as $tweet)--}}
                            @foreach($tweets as $key=>$value)
                                <div class="thumbnail_image">
                                    <a href="">
                                        <img class="img-thumbnail" src="{{ asset('storage/images/'.$value->path) }}"/>
                                    </a>
    {{--                                {{ $key }} $key는 foreach index --}}
{{--                                    @if(strstr($value->mime_type,'/', true) === 'image')--}}
                                    @if($value->include_video === 0)
                                        @if($value->file_cnt > 1)
                                            <div class="file_cnt">image {{ $value->file_cnt }}</div>
                                        @endif
                                    @else
                                        <div class="file_cnt">video</div>
                                    @endif
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
