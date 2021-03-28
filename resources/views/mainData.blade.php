@foreach($tweets as $key=>$value)
    <div class="thumbnail_image">
        <a href="{{ $value->nickname }}/timeline/{{ $value->id }}">
            <img class="img-thumbnail" src="{{ asset('storage/images/'.$value->path) }}"/>
        </a>
        {{--                                {{ $key }} $key는 foreach index --}}
        {{--                                        @if(strstr($value->mime_type,'/', true) === 'image')--}}
        @if($value->include_video === 0)
            @if($value->file_cnt > 1)
                <div class="file_cnt">image {{ $value->file_cnt }}</div>
            @endif
        @else
            <div class="file_cnt">video</div>
        @endif
    </div>
@endforeach
