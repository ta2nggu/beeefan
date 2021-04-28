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
                <img src="{{ asset('storage/images/'.$value->path) }}" alt="">
            </a>
        </li>
@endforeach
