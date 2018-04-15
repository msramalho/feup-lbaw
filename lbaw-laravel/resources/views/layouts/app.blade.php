<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vecto') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- JavaScript -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}" defer></script>
</head>

<body class="bg-light">
    @include('partials.navbar')
    @yield('content')
    @include('partials.footer')
</body>

</html>