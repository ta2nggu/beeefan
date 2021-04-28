<header id="header" class="@yield('headerClass')">
    @yield('page_back')
    @if(isset( $header_title ))
        <h1 class="txtTitle">{{$header_title}}</h1>
    @else
        <p class="logo"><a href="{{ url('/') }}"><img src="{{ asset('storage/common/logo.png') }}" alt="{{ config('app.name') }}"></a></p>
    @endif

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
