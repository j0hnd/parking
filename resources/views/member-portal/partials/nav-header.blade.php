<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
	<a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
	@include('parking.templates.member-nav')
	<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
</nav>