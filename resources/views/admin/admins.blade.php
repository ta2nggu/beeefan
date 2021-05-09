@if($new != '')
{{__('運営者')}}{{ $new->last_name }} {{ $new->first_name }}{{__('さんの登録が完了しました')}}
@else

@endif
<div><a href="{{ url('/admin/adminReg/') }}">{{__('運営者新規登録')}}</a></div>
@foreach($admins as $admin)
    <div style="border: 1px solid black;">
        {{ $admin->last_name }} {{ $admin->first_name }}
        <a href="{{url('/aDetail/'.$admin->user_id)}}">상세</a>
    </div>
@endforeach
