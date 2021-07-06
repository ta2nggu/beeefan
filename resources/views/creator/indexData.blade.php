{{--@foreach($tweets as $key=>$value)--}}
{{--    <div class="thumbnail_image">--}}
{{--        <a href="">--}}
{{--            <img class="img-thumbnail" src="{{ asset('storage/images/'.$value->path) }}"/>--}}
{{--        </a>--}}
{{--        --}}{{--                                {{ $key }} $key는 foreach index --}}
{{--        --}}{{--                                    @if(strstr($value->mime_type,'/', true) === 'image')--}}
{{--        @if($value->include_video === 0)--}}
{{--            @if($value->file_cnt > 1)--}}
{{--                <div class="file_cnt">image {{ $value->file_cnt }}</div>--}}
{{--            @endif--}}
{{--        @else--}}
{{--            <div class="file_cnt">video</div>--}}
{{--        @endif--}}
{{--    </div>--}}
{{--@endforeach--}}

{{--21.04.26 kondo--}}
@foreach($tweets as $key=>$value)
    @if($value->include_video === 0)
        @if($value->file_cnt > 1)
            <li class="postMulti">
        @else
            <li class="postSingle">
        @endif
    @else
        <li class="postVideo">
            @endif
            <a href="/{{ $user[0]->account_id }}/p/{{ $value->id }}">
                @if($value->main_img_mime_type === 'video')
                    <img src="{{ asset('storage/images/'.$value->thumb_path) }}" alt="">
                @else
                    <img src="{{ asset('storage/images/'.$value->path) }}" alt="">
                @endif
            </a>
        </li>
@endforeach
