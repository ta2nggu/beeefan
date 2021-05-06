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
            <li><a class="icon menu"
               data-toggle="modal"
               data-target="#menuDr">{{ __('メニュー') }}</a></li>
        @endguest
    </ul>
</header>
@component ('components.headerNav')
@endcomponent
