@auth
    @role('creator')
        <div id="bottomCreatorMypage" class="bottomFixed">
            <ul class="inner">
                <li><a href="{{ url('/creator/write') }}" class="pCreate">投稿する</a></li>
                <li><a href="/{{ $bottomFixed_id }}/timeline/0" class="post">タイムライン</a></li>
                <li><a href="{{ url('/creator/index') }}" class="mypage">マイページ</a></li>
            </ul>
        </div>
    @endrole
    @role('user')

    @endrole
    @role('administrator')
        <div id="bottomAdminMypage" class="bottomFixed">
            <ul class="inner">
                <li><a href="{{ url('/admin/index') }}" class="mypage">マイページ</a></li>
                <li><a href="{{ url('/admin/creators') }}" class="setting">設定変更</a></li>
            </ul>
        </div>
    @endrole
@endauth
