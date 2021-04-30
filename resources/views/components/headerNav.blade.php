@auth
    <div id="menuDrawerContent">
        <ul>
            @role('creator')
            <li><a href="{{ url('/creator/write') }}" class="icon_post">{{__('投稿する')}}</a></li>
            <li><a href="{{ url('/creator/mypage') }}" class="icon_setting">{{__('プロフィール編集')}}</a></li>
            <li><a href="{{ url('/creator/invisible') }}" class="icon_draft">{{__('下書き投稿一覧')}}</a></li>
            <li><a href="{{ url('/page/help') }}" class="icon_help">{{__('ヘルプ')}}</a></li>
            <li><a href="{{ url('/page/rule') }}" class="icon_rule">{{__('利用規約')}}</a></li>
            <li><a href="{{ url('/page/policy') }}" class="icon_policy">{{__('プライバシーポリシー')}}</a></li>
            <li><a href="{{ url('/page/law') }}" class="icon_law">{{__('特定商取引法に基づく表記')}}</a></li>
            @endrole
            @role('user')
            <li><a href="" class="icon_card">{{__('メールアドレス変更')}}</a></li>
            <li><a href="" class="icon_setting">{{__('パスワード変更')}}</a></li>
            <li><a href="" class="icon_payment">{{__('決済方法変更')}}</a></li>
            <li><a href="{{ url('/page/help') }}" class="icon_help">{{__('ヘルプ')}}</a></li>
            <li><a href="{{ url('/page/rule') }}" class="icon_rule">{{__('利用規約')}}</a></li>
            <li><a href="{{ url('/page/policy') }}" class="icon_policy">{{__('プライバシーポリシー')}}</a></li>
            <li><a href="{{ url('/page/law') }}" class="icon_law">{{__('特定商取引法に基づく表記')}}</a></li>
            @endrole
            @role('administrator')
            <li><a href="" class="icon_post">{{__('マイページ')}}お知らせ投稿</a></li>
            <li><a href="{{ url('/admin/creatorReg') }}" class="icon_setting">{{__('クリエイター新規登録')}}</a></li>
            <li><a href="" class="icon_help">{{__('運営者一覧')}}</a></li>
            <li><a href="" class="icon_rule">{{__('運営者新規登録')}}</a></li>
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
