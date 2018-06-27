<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="user-scalable=yes, initial-scale=1, maximum-scale=1, width=device-width">
        <title>{{ config('app.name') }}</title>
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/spacing.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,800" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css"
              integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/icons.ico/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/icons.ico/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/icons.ico/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/icons.ico/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/icons.ico/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/icons.ico/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/icons.ico/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/icons.ico/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icons.ico/apple-icon-180x180.png')}}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/icons.ico/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/icons.ico/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/icons.ico/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/icons.ico/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('img/icons.ico/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <meta name="application-name" content="My Travel Compared"/>
                <meta name="msapplication-square70x70logo" content="{{ asset('/img/small.jpg') }}"/>
                <meta name="msapplication-square150x150logo" content="{{ asset('/img/medium.jpg') }}"/>
                <meta name="msapplication-wide310x150logo" content="{{ asset('/img/wide.jpg') }}"/>
                <meta name="msapplication-square310x310logo" content="{{ asset('/img/large.jpg') }}"/>
                <meta name="msapplication-TileColor" content="#ffffff"/>
        <script type="text/javascript">
            cdn_url = 'http://mytravelcompared.com';
        </script>
        @yield('tags')
        @yield('css')
    </head>

    <body>
        @yield('tag-manager')
        {{-- main --}}
        <main>
            @yield('main-content')

            {{-- footer --}}
            @include('parking.templates.footer')
        </main>
    </body>

    {{-- scripts --}}
    @include('parking.templates.scripts')
    @yield('js')
</html>
