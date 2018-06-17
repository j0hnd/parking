@extends('parking-app')

@section('css')
	<link href="{{ asset('/css/parking-search.css') }}" rel="stylesheet">
	<style type="text/css">
		footer {
			bottom: 0;
			position: absolute;
			width: 100%;
			height: 250px;
		}
	</style>
@stop

@section('main-content')
	<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
		<a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
		@include('parking.templates.member-nav')
		<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
	</nav>

	<br/><br/><br/><br/><br/>

	<nav class="navbar-expand-lg navbar-light bg-light navbar-2">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<h4 style="color:white;">Welcome {{ $user->members->first_name }}!</h4>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="padding-20">Dashboard</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				@if($user->roles[0]->slug == 'member')
					@include('member-portal.partials.member')
				@else
					@include('member-portal.partials.vendor')
				@endif
			</div>
		</div>
	</div>

	<input type="hidden" id="token" value="{{ csrf_token() }}">
@stop

@section('js')
@stop