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
            <a href="{{__('/creator/invisibleTime/')}}{{ $value->id }}">
                @if($value->main_img_mime_type === 'video')
                    <img src="{{ asset('storage/images/'.$value->thumb_path) }}" alt="">
                @else
                    <img src="{{ asset('storage/images/'.$value->path) }}" alt="">
                @endif
            </a>
        </li>
@endforeach
