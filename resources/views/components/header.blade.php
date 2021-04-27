<header id="header" class="@yield('headerClass')">
    <p class="logo"><a href="{{ url('/') }}"><img src="{{ asset('storage/common/logo.png') }}" alt="{{ config('app.name') }}"></a></p>
    <ul class="nav">
        @guest
            @if (Route::has('login'))
                <li><a href="{{ route('login') }}" class="icon login">ログイン</a></li>
            @endif
        @else
            <li><span id="menuDrawer" class="icon menu">メニュー</span></li>
        @endguest
    </ul>
    @component ('components.header_nav')
    @endcomponent
</header>
