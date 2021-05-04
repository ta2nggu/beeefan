<h2>{{__('お知らせ一覧')}}</h2>
@foreach($notices as $notice)
    <div style="border-bottom: 3px solid black;">
        <p style="border-bottom: 1px solid black;">{{ $notice->title }}</p>
        <p>{{ $notice->body }}</p>
        <form method="POST" action="{{ __('/admin/delNotice') }}" >
            @csrf

            <input type="hidden" name="notice_id" value="{{ $notice->id }}">
            <button type="submit">{{ __('공지 삭제') }}</button>
        </form>
    </div>
@endforeach
<h2>{{__('お知らせ投稿')}}</h2>
<div>{{__('※一度投稿すると変更できません')}}</div>
<form method="POST" action="{{ __('/admin/notice') }}" >
    @csrf

    <h4>タイトル</h4>
    <div><input type="text" name="title" style="width: 300px;"></div>
    <h4>本文</h4>
    <div><textarea type="text" name="body" style="width: 300px; height: 150px;"></textarea></div>
    <button type="submit">{{ __('投稿する') }}</button>
    <a href="{{__('/admin/index')}}">메인으로</a>
</form>
