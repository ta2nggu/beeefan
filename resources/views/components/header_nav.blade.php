@auth
    <div id="menuDrawerContent">
        <ul>
            @role('creator')
            <li><a href="{{ url('/creator/index') }}" class="icon_mypage">マイページ</a></li>
            <li><a href="{{ url('/creator/write') }}" class="icon_post">投稿する</a></li>
            <li><a href="{{ url('/creator/mypage') }}" class="icon_setting">プロフィール編集</a></li>
            <li><a href="" class="icon_draft">下書き投稿一覧</a></li>
            <li><a href="" class="icon_help">ヘルプ</a></li>
            <li><a href="" class="icon_rule">利用規約</a></li>
            <li><a href="" class="icon_policy">プライバシーポリシー</a></li>
            <li><a href="" class="icon_law">特定商取引法</a></li>
            @endrole
            @role('user')
            <li><a href="{{ url('/user/index') }}" class="icon_mypage">マイページ</a></li>
            <li><a href="" class="icon_post">メールアドレス変更</a></li>
            <li><a href="" class="icon_setting">パスワード変更</a></li>
            <li><a href="" class="icon_draft">決済方法変更</a></li>
            <li><a href="" class="icon_help">ヘルプ</a></li>
            <li><a href="" class="icon_rule">利用規約</a></li>
            <li><a href="" class="icon_policy">プライバシーポリシー</a></li>
            <li><a href="" class="icon_law">特定商取引法</a></li>
            @endrole
            @role('administrator')
            <li><a href="{{ url('/admin/index') }}" class="icon_mypage">マイページ</a></li>
            <li><a href="" class="icon_post">お知らせ投稿</a></li>
            <li><a href="{{ url('/admin/creatorReg') }}" class="icon_setting">クリエイター新規登録</a></li>
            <li><a href="" class="icon_draft">クリエイター情報管理</a></li>
            <li><a href="" class="icon_help">運営者新規登録</a></li>
            <li><a href="" class="icon_rule">運営者情報管理</a></li>
            <li><a href="" class="icon_policy">設定方法</a></li>
            @endrole
            <li><a class="icon_logout" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">ログアウト</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
@endauth
