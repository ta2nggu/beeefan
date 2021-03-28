@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $creator[0]->name }}/{{ $creator[0]->nickname }}</div>

                    <div class="card-body">
                        <div class="instruction">{{ $creator[0]->instruction }}</div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="tweets">
                            <div class="flex_images post-data">
{{--                            21.03.28 김태영, mainData.balde.php 로 이동--}}
                                @include('mainData')
{{--                                @foreach($tweets as $key=>$value)--}}
{{--                                    <div class="thumbnail_image">--}}
{{--                                        <a href="{{ $value->nickname }}/timeline/{{ $value->id }}">--}}
{{--                                            <img class="img-thumbnail" src="{{ asset('storage/images/'.$value->path) }}"/>--}}
{{--                                        </a>--}}
{{--                                        --}}{{--                                {{ $key }} $key는 foreach index --}}
{{--                                        @if(strstr($value->mime_type,'/', true) === 'image')--}}
{{--                                        @if($value->include_video === 0)--}}
{{--                                            @if($value->file_cnt > 1)--}}
{{--                                                <div class="file_cnt">image {{ $value->file_cnt }}</div>--}}
{{--                                            @endif--}}
{{--                                        @else--}}
{{--                                            <div class="file_cnt">video</div>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
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

