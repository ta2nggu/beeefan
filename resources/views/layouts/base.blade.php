<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(isset( $title ))
            {{ config('app.name') }}
        @else
            @yield('title') | {{ config('app.name') }}
        @endif
    </title>
    <meta name="description" content="">

    <link rel="icon" href="{{ asset('storage/common/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/common/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/common.js') }}" defer></script>

    @yield('pageCss')

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:description" content="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:image" content="{{ asset('storage/common/sns.gif') }}">
    <meta property="og:image:secure_url" content="{{ asset('storage/common/sns.gif') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name') }}">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="{{ asset('storage/common/sns.gif') }}">
</head>

<body class="@yield('body')">

    <!--wrapper-->
    <div id="app">
        @yield('content')
    </div><!--/wrapper-->

</body>
</html>
