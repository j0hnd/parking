<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name') }}</title>
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,800" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css"
              integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">
        @yield('css')
    </head>

    <body>
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
