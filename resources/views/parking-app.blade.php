<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/parking-app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,800" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
    <!-- Add the slick-theme.css if you want default styling -->
    <link href="{{ asset('/css/slick.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link href="{{ asset('/css/slick-theme.css') }}" rel="stylesheet" type="text/css"/>
</head>

<body>
    {{-- main --}}
    <main>
      	<nav class="navbar navbar-expand-sm navbar-dark bg-dark" data-toggle="affix">
            @include('parking.templates.nav')
        </nav>

        {{-- header --}}
        <header id="header">
            @include('parking.templates.header')
        </header>

        {{-- sections --}}
        @include('parking.templates.sections')

        {{-- footer --}}
        @include('parking.templates.footer')

        {{-- scripts --}}
        @include('parking.templates.scripts')
    </main>
</body>
</html>
