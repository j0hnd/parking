<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="user-scalable=yes, initial-scale=1, maximum-scale=1, width=device-width">
        <title>@yield('title') {{ config('app.name') }}</title>
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
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        {{-- <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}"> --}}
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
        <script src="http://mytravelcompared.com/userTrack/tracker.min.js"></script>
        @yield('tags')
        @yield('css')
        <style media="screen">
            .cookie-consent {
                text-align: center;
                padding: 10px;
                background-color: #ffe5cc;
            }
        </style>
    </head>

    <body>
        @yield('tag-manager')
        {{-- main --}}
        <main>
            @yield('main-content')

            {{-- footer --}}
            @include('parking.templates.footer')
        </main>

        @include('cookieConsent::index')
    </body>

    {{-- scripts --}}
    @include('parking.templates.scripts')
    @yield('js')
    @php
        $mydate = date('Y-m-d H:i', strtotime('+2 days'));
        $start_date = date('d/m/Y H:i', strtotime($mydate));
        $end_date = date('d/m/Y H:i', strtotime($mydate . ' +7 days'));

        if (isset($drop_date)) {
            $start_date = $drop_date;
        }

        if (isset($return_date)) {
            $end_date = $return_date;
        }
    @endphp
    <script type="text/javascript">
        $(function () {
			$('.datepicker').daterangepicker({
		        "minYear": {{ date('Y') }},
		        "maxYear": {{ date('Y', strtotime('+30 years')) }},
		        "showWeekNumbers": true,
		        "timePicker": true,
		        "timePicker24Hour": true,
		        "timePickerIncrement": 5,
		        "alwaysShowCalendars": true,
		        "startDate": "{{ $start_date }}",
		        "endDate": "{{ $end_date }}",
                "applyButtonClasses": "btn-info",
				"locale": {
					format: "DD/MM/YYYY H:mm"
				}
		    }, function(start, end, label) {
		        // console.log('New date range selected: ' + start.format('HH:mm') + ' to ' + end.format('HH:mm') + ' (predefined range: ' + label + ')');
				$('#return-at-date').val(end.format('DD/MM/YYYY'));
				$('#drop-off-time option[value="'+ start.format('HH:mm') +'"]').attr('selected', 'selected');
				$('#return-at-time option[value="'+ end.format('HH:mm') +'"]').attr('selected', 'selected');
		    });

            $('.datepicker').data('daterangepicker').setStartDate('{{ $start_date }}');
            $('.datepicker').data('daterangepicker').setEndDate('{{ $end_date }}');
            $('#airport').select2().select2('val', $('#airport option:eq(5)').val());
            $('#return-at-date').val('{{ date('d/m/Y', strtotime($mydate . ' +7 days')) }}');
        });
	</script>
</html>
