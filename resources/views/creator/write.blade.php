@extends('layouts.creator')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('크리에이터 신규 투고 화면') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <section id="image-form-wrapper">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 col-md-offset-3">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">Upload your images</div>
                                            <div class="panel-body">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @elseif (session('message'))
                                                    <div class="alert alert-info">
                                                        {{ session('message') }}
                                                    </div>
                                                @endif

                                                <router-view :current-user="{{ auth()->id() }}"></router-view>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <a href="">비공개투고</a>
                    </div>
                </div>
            </div>
        </div>


{{--        <section id="images">--}}
{{--            <div class="container">--}}
{{--                <div class="row">--}}
{{--                    @if($images->count() < 1)--}}
{{--                        <div class="alert alert-warning">--}}
{{--                            You have no images--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    @foreach($images as $image)--}}
{{--                        <div class="col-md-4">--}}
{{--                            <div class="thumbnail">--}}
{{--                                <img src="{{ $image->src }}" alt="">--}}
{{--                                <div class="caption">--}}
{{--                                    <h3>{{ $image->title }}</h3>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
    </div>


@endsection
