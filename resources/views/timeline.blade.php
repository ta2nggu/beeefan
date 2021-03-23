@extends('layouts.app')

@section('content')
    <div id="post-data" class="timeline_image">
        @include('timelineData')
    </div>

    <div class="ajax-load text-center">
        <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
    </div>
@endsection
