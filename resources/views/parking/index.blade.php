@extends('parking-app')

@section('tags')
	<meta name="description" content="My Travel Compared is the UK’s fastest growing car park comparison site. We work closely with our partners so we can offer a professional, low cost, stress free, reliable way to book your parking. Whether your a frequent business flyer, taking the trip of a life time or simply getting away for the weekend we have a parking solution to meet your needs." />
	<meta name="keywords" content="airport, travel, parking, " />
	<meta name="author" content="Unistop LTD" />

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content="My Travel Compared"/>
	<meta property="og:image" content="{{ asset ('img/round.png') }}"/>
	<meta property="og:url" content="http://mytravelcompared.com/"/>
	<meta property="og:site_name" content="My Travel Compared"/>
	<meta property="og:description" content="My Travel Compared is the UK’s fastest growing car park comparison site. We work closely with our partners so we can offer a professional, low cost, stress free, reliable way to book your parking. Whether your a frequent business flyer, taking the trip of a life time or simply getting away for the weekend we have a parking solution to meet your needs."/>
	<meta property="fb:admins" content="100001809531980">
	<meta property="fb:app_id" content="174457103083743">
	<meta name="twitter:title" content="My Travel Compared" />
	<meta name="twitter:image" content="{{ asset ('img/round.png') }}" />
	<meta name="twitter:url" content="http://mytravelcompared.com/" />
	<meta name="twitter:card" content="summary" />
    <meta name="twitter:description" content="My Travel Compared is the UK’s fastest growing car park comparison site. We work closely with our partners so we can offer a professional, low cost, stress free, reliable way to book your parking. Whether your a frequent business flyer, taking the trip of a life time or simply getting away for the weekend we have a parking solution to meet your needs.">



    <script>
    var dataLayer = [{
        'sectionName': 'Parking',
        'locationType': 'Airport',
        'page': 'Landing/Index',
        'culture': 'en-GB',
        'lang': 'en'
    }];
    </script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-552WTR9');</script>
<!-- End Google Tag Manager -->

@stop
@section('css')
	<link href="{{ asset('/css/parking-app.css') }}" rel="stylesheet">
	{{-- Add the slick-theme.css if you want default styling --}}
	<link href="{{ asset('/css/slick.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('/css/slick-theme.css') }}" rel="stylesheet" type="text/css"/>
	{{-- Bootstrap datepicker --}}
	<link href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@stop

@section('main-content')
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-552WTR9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

	<div id="mobileNav" class="overlay">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<div class="overlay-content">
			<a href="{{ url('/member/login') }}">Member Login</a>
			<a href="/contact">Contact Us</a>
			{{--<a href="#">Chat</a>--}}
			<a href="#">Airport</a>
		</div>
	</div>

	<nav class="navbar navbar-expand-sm navbar-dark bg-dark" data-toggle="affix">
		@include('parking.templates.nav')
		<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
	</nav>

	{{-- header --}}
	<header id="header">
		@include('parking.templates.header')
	</header>

	{{-- sections --}}
	@include('parking.templates.sections')
@stop

@section('js')
	<script src="{{ asset('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

	<script src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>
	<script src='{{ asset('/js/slick.min.js') }}' type="text/javascript"></script>
	<script src="{{ asset('/js/parking-app.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
        $(function () {
            $('#airport').select2();
        });
	</script>
@stop