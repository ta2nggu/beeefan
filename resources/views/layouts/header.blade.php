@section('header')
    <header id="header">
        <p class="logo"><a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}"></a></p>
        <ul class="nav">
            @guest
                @if (Route::has('login'))
                    <li><a href="{{ route('login') }}" class="icon login">ログイン</a></li>
                @endif
            @else
                <li><span id="menuDrawer" class="icon menu">メニュー</span></li>
                <div id="menuDrawerContent">

                </div>
            @endguest
        </ul>
    </header>
@endsection
