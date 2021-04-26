@foreach($creators as $key=>$value)
    <div class="creator_info">
        <h3>{{ $value->nickname }}</h3>
        <div class="creator_info_img" style="border: 1px solid #1b1e21;width: 100px;height: 100px">
            <img id="preview_profile_img" src="@if (isset($value->profile_img)) {{ asset('storage/images/'.$value->user_id.'/'.$value->profile_img) }} @else https://www.riobeauty.co.uk/images/product_image_not_found.gif @endif" style="width: 100%;height: 100%;"/>
        </div>
        <p>登錄日 : {{ $value->created_at }}</p>
        <p>月額 : {{ $value->month_price }}</p>
    </div>
@endforeach
