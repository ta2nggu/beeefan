@foreach($creators as $key=>$value)
    <li>
        <a href="{{url('/')}}" class="imgbox">
            @if (isset($value->profile_img))
                <img src=" {{ asset('storage/images/'.$value->user_id.'/'.$value->profile_img) }}" alt="{{ $value->nickname }}">
            @else
                <img src="{{ asset('storage/icon/no_images_c.png') }}" alt="{{ $value->nickname }}">
            @endif
        </a>
        <div class="txtBox">
            <h3 class="name">{{ $value->nickname }}</h3>
            <p class="price"> {!! '月額 '. number_format($value->month_price) .'　登録者 '.number_format($value->month_price)!!}</p>
            <a href="">{{__('詳細はこちらへ')}}</a>
        </div>
        <a href="{{url('/')}}" class="iconBox"></a>
    </li>
@endforeach
