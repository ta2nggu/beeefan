@foreach($creator_list as $key=>$value)
    <div class="creator_info">
{{--        {{ $value->last_name }} {{ $value->first_name }}--}}
        <h3>{{ $value->nickname }}</h3>
        <p>Created at : {{ $value->created_at }}</p>
    </div>
@endforeach
