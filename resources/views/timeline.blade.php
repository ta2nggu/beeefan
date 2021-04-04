@extends('layouts.app')

@section('content')
{{--    <div id="post-data" class="timeline_image">--}}
{{--    21.03.28 김태영, main.blade.php에서도 ajax infinite scrolling 같이 사용하기 위해 클래스(.post-data) 로 변경--}}
    <div class="timeline_image post-data">
        @include('timelineData')
    </div>

    <div class="영">
        <p><img src="{{ asset('storage/images/loading.gif') }}"/>データを持ってきています。</p>
    </div>
@endsection
