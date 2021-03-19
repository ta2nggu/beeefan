@extends('layouts.creator')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

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

    {{--                                                    21.03.16 김태영, 테스트용--}}
    {{--                                                <input type="file" name="file" id="file" class="inputfile" multiple>--}}
    {{--                                                <label for="file" style="background-image: url({{ asset('storage/images/18/48/cat1.png') }})"></label>--}}
    {{--                                                <label for="file">+</label>--}}
    {{--                                                <label for="file">+</label>--}}
@endsection
