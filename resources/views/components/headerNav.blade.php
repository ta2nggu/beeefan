@auth
    <div class="modal fade" id="menuDr" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom" role="document">
            <div class="modal-content">
                <ul class="modal-body">
                    <li><a href="{{ route('home') }}" class="icon icon_mypage">{{__('マイページ')}}</a></li>
                    @role('creator')
                    <li><a href="{{ url('/creator/write') }}" class="icon icon_post">{{__('投稿する')}}</a></li>
                    <li><a href="{{ url('/creator/mypage') }}" class="icon icon_setting">{{__('プロフィール編集')}}</a></li>
                    <li><a href="{{ url('/creator/invisible') }}" class="icon icon_draft">{{__('下書き投稿一覧')}}</a></li>
                    <li><a href="{{ url('/page/help') }}" class="icon icon_help">{{__('ヘルプ')}}</a></li>
                    <li><a href="{{ url('/page/rule') }}" class="icon icon_rule">{{__('利用規約')}}</a></li>
                    <li><a href="{{ url('/page/policy') }}" class="icon icon_policy">{{__('プライバシーポリシー')}}</a></li>
                    <li><a href="{{ url('/page/law') }}" class="icon icon_law">{{__('特定商取引法に基づく表記')}}</a></li>
                    @endrole
                    @role('user')
                    <li><a href="{{ url('/email/change') }}" class="icon icon_card">{{__('メールアドレス変更')}}</a></li>
                    <li><a href="{{ url('/password/change') }}" class="icon icon_setting">{{__('パスワード変更')}}</a></li>
                    <li><a href="" class="icon icon_payment">{{__('決済方法変更')}}</a></li>
                    <li><a href="{{ url('/page/help') }}" class="icon icon_help">{{__('ヘルプ')}}</a></li>
                    <li><a href="{{ url('/page/rule') }}" class="icon icon_rule">{{__('利用規約')}}</a></li>
                    <li><a href="{{ url('/page/policy') }}" class="icon icon_policy">{{__('プライバシーポリシー')}}</a></li>
                    <li><a href="{{ url('/page/law') }}" class="icon icon_law">{{__('特定商取引法に基づく表記')}}</a></li>
                    @endrole
                    @role('administrator')
                    <li><a href="{{ url('/admin/notice') }}" class="icon icon_notice">{{__('お知らせ投稿')}}</a></li>
                    <li><a href="{{ url('/admin/creatorReg') }}" class="icon icon_addCreator">{{__('クリエイター新規登録')}}</a></li>
                    <li><a href="{{ url('/email/change') }}" class="icon icon_law">{{__('メールアドレス変更')}}</a></li>
                    <li><a href="{{ url('/password/change') }}" class="icon icon_setting">{{__('パスワード変更')}}</a></li>
                    @endrole
                    @role('superadministrator')
                    <li><a href="{{ url('/admin/notice') }}" class="icon icon_notice">{{__('お知らせ投稿')}}</a></li>
                    <li><a href="{{ url('/admin/creatorReg') }}" class="icon icon_addCreator">{{__('クリエイター新規登録')}}</a></li>
                    <li><a href="{{ url('/admin/admins/list') }}" class="icon icon_admins">{{__('運営者一覧')}}</a></li>
                    <li><a href="{{ url('/admin/adminReg') }}" class="icon icon_addAdmin">{{__('運営者新規登録')}}</a></li>
                    <li><a href="{{ url('/email/change') }}" class="icon icon_law">{{__('メールアドレス変更')}}</a></li>
                    <li><a href="{{ url('/password/change') }}" class="icon icon_setting">{{__('パスワード変更')}}</a></li>
                    @endrole
                    <li><p class="icon icon_logout" id="warningLogoutBtn">{{ __('ログアウト') }}</p></li>
                </ul>
                <div class="modal-footer">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">{{__('閉じる')}}</button>
                </div>
            </div>
        </div>
    </div>

    <!--ログアウトポップアップ-->
    <div class="modal fade warningBox" id="warningLogout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="titleText">ログアウト</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-warning">
                    <p class="center">ログアウトしてもよろしいですか？</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="formBox normalFormBox">
                    @csrf
                    <ul class="btnBox modal-footer">
                        <li><button type="submit" class="btn btnSS btnCircle btnBk">{{ __('はい') }}</button></li>
                        <li><button type="button" class="btn btnSS btnCircle" data-dismiss="modal">{{ __('いいえ') }}</button></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
@endauth
