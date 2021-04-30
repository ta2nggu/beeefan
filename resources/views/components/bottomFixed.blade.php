@auth
    @role('creator')
        <div id="bottomCreatorMypage" class="bottomFixed">
            <ul class="inner">
                <li><a href="{{ url('/creator/write') }}" class="pCreate">{{__('投稿する')}}</a></li>
                <li><a href="/{{ $bottomFixed_id }}/timeline/0" class="post">{{__('タイムライン')}}</a></li>
                <li><a href="{{ url('/creator/index') }}" class="mypage">{{__('マイページ')}}</a></li>
            </ul>
        </div>
    @endrole
    @role('user')
    <div id="bottomUserMypage" class="bottomFixed">
        <ul class="inner">
            <li><a href="{{ url('/mypage') }}" class="post">{{__('タイムライン')}}</a></li>
            <li><a href="{{ url('/mypage') }}" class="mypage">{{__('マイページ')}}</a></li>
        </ul>
    </div>
    @endrole
    @role('administrator')
        <div id="bottomAdminMypage" class="bottomFixed">
            <ul class="inner">
                <li><a href="{{ url('/admin/index') }}" class="mypage">{{__('マイページ')}}</a></li>
                <li><a href="{{ url('/admin/creators') }}" class="setting">{{__('設定変更')}}</a></li>
            </ul>
        </div>
    @endrole
@endauth
