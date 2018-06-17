<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ config('app.name') }} - Member Portal</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{ asset('/img/images/icons/favicon.ico') }}"/>
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/animate/animate.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/css-hamburgers/hamburgers.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/animsition/css/animsition.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/select2/select2.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/daterangepicker/daterangepicker.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/member-nav.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,800" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
		  integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
		  crossorigin="anonymous">

	<link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/member-portal/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/member-portal/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/member-portal/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('/member-portal/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/member-portal/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/member-portal/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/member-portal/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/member-portal/vendor/slick/slick.css" rel="stylesheet') }}" media="all">
    <link href="{{ asset('/member-portal/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/member-portal/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('/css/theme.css') }}" rel="stylesheet" media="all">
    @yield('css')
</head>
<body style="background-color: #666666;">
	@yield('main-content')

	<script src="{{ asset('/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('/vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('/vendor/countdowntime/countdowntime.js') }}"></script>
	<script src="{{ asset('/js/login.js') }}"></script>

	<script src="{{ asset('/js/member-nav.js') }}"></script>


    <!-- Vendor JS       -->
    <script src="{{ asset('/member-portal/vendor/slick/slick.min.js') }}">
    </script>
    <script src="{{ asset('/member-portal/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('/member-portal/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('/member-portal/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}">
    </script>
    <script src="{{ ('member-portal/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="member-portal/vendor/counter-up/jquery.counterup.min.js') }}">
    </script>
    <script src="{{ asset('/member-portal/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('/member-portal/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/member-portal/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('/member-portal/vendor/select2/select2.min.js') }}">
    </script>

    <!-- Main JS-->
    <script src="{{ asset('/js/main.js') }}"></script>

	@yield('js')

</body>
</html>