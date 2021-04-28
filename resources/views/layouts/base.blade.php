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

    <link rel="icon" href="../../img/common/favicon.ico">
    @yield('pageCss')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{ asset('js/common.js') }}" defer></script>
</head>

<body class="@yield('body')">

    <!--wrapper-->
    <div id="wrapper">
        @yield('content')
    </div><!--/wrapper-->

</body>
</html>
