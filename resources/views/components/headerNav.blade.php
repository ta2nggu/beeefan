@auth
    <div class="modal fade" id="menuDr" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom" role="document">
            <div class="modal-content">
                <ul class="modal-body">
                    @role('creator')
                    <li><a href="{{ url('/creator/index') }}" class="icon_mypage">{{__('マイページ')}}</a></li>
                    <li><a href="{{ url('/creator/write') }}" class="icon_post">{{__('投稿する')}}</a></li>
                    <li><a href="{{ url('/creator/mypage') }}" class="icon_setting">{{__('プロフィール編集')}}</a></li>
                    <li><a href="{{ url('/creator/invisible') }}" class="icon_draft">{{__('下書き投稿一覧')}}</a></li>
                    <li><a href="{{ url('/page/help') }}" class="icon_help">{{__('ヘルプ')}}</a></li>
                    <li><a href="{{ url('/page/rule') }}" class="icon_rule">{{__('利用規約')}}</a></li>
                    <li><a href="{{ url('/page/policy') }}" class="icon_policy">{{__('プライバシーポリシー')}}</a></li>
                    <li><a href="{{ url('/page/law') }}" class="icon_law">{{__('特定商取引法に基づく表記')}}</a></li>
                    @endrole
                    @role('user')
                    <li><a href="{{ url('/mypage') }}" class="icon_mypage">{{__('マイページ')}}</a></li>
                    <li><a href="{{ url('/email/change') }}" class="icon_card">{{__('メールアドレス変更')}}</a></li>
                    <li><a href="{{ url('/password/change') }}" class="icon_setting">{{__('パスワード変更')}}</a></li>
                    <li><a href="" class="icon_payment">{{__('決済方法変更')}}</a></li>
                    <li><a href="{{ url('/page/help') }}" class="icon_help">{{__('ヘルプ')}}</a></li>
                    <li><a href="{{ url('/page/rule') }}" class="icon_rule">{{__('利用規約')}}</a></li>
                    <li><a href="{{ url('/page/policy') }}" class="icon_policy">{{__('プライバシーポリシー')}}</a></li>
                    <li><a href="{{ url('/page/law') }}" class="icon_law">{{__('特定商取引法に基づく表記')}}</a></li>
                    @endrole
                    @role('administrator')
                    <li><a href="{{ url('/admin/index') }}" class="icon_mypage">{{__('マイページ')}}</a></li>
                    <li><a href="{{ url('/admin/notice') }}" class="icon_notice">{{__('お知らせ投稿')}}</a></li>
                    <li><a href="{{ url('/admin/creatorReg') }}" class="icon_addCreator">{{__('クリエイター新規登録')}}</a></li>
                    <li><a href="{{ url('/email/change') }}" class="icon_law">{{__('メールアドレス変更')}}</a></li>
                    <li><a href="{{ url('/password/change') }}" class="icon_setting">{{__('パスワード変更')}}</a></li>
                    @endrole
                    @role('superadministrator')
                    <li><a href="{{ url('/admin/index') }}" class="icon_mypage">{{__('マイページ')}}</a></li>
                    <li><a href="{{ url('/admin/notice') }}" class="icon_notice">{{__('お知らせ投稿')}}</a></li>
                    <li><a href="{{ url('/admin/creatorReg') }}" class="icon_addCreator">{{__('クリエイター新規登録')}}</a></li>
                    <li><a href="{{ url('/admin/admins/list') }}" class="icon_admins">{{__('運営者一覧')}}</a></li>
                    <li><a href="{{ url('/admin/adminReg') }}" class="icon_addAdmin">{{__('運営者新規登録')}}</a></li>
                    <li><a href="{{ url('/email/change') }}" class="icon_law">{{__('メールアドレス変更')}}</a></li>
                    <li><a href="{{ url('/password/change') }}" class="icon_setting">{{__('パスワード変更')}}</a></li>
                    @endrole
                    <li><a class="icon_logout" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">ログアウト</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
                <div class="modal-footer">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">{{__('閉じる')}}</button>
                </div>
            </div>
        </div>
    </div>
@endauth
