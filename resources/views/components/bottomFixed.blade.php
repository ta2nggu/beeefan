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
                <li><a href="{{ url('/admin/creatorReg') }}" class="addCreator">{{__('クリエイター新規登録')}}</a></li>
                <li><a href="{{ url('/admin/notice') }}" class="notice">{{__('お知らせ投稿')}}</a></li>
            </ul>
        </div>
    @endrole
    @role('superadministrator')
        <div id="bottomAdminMypage" class="bottomFixed">
            <ul class="inner">
                <li><a href="{{ url('/admin/index') }}" class="mypage">{{__('マイページ')}}</a></li>
                <li><a href="{{ url('/admin/creatorReg') }}" class="addCreator">{{__('クリエイター新規登録')}}</a></li>
                <li><a href="{{ url('/admin/admins/list') }}" class="admins">{{__('運営者一覧')}}</a></li>
            </ul>
        </div>
    @endrole
@endauth
