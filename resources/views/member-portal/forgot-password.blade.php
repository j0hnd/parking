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
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="padding-20">Forgot Password</h3>
			</div>
		</div>

		@if ($errors->any())
			<div class="error-container">
				<div class="alert alert-danger">
					<strong>Whoops!</strong> Something went wrong...<br>
					<ul class="error-wrapper" style="padding-left: 17px;">
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			</div>
		@endif

		<div class="row">
			<form action="{{ url('/forgot-password') }}" method="post" style="width: 100%; padding-bottom: 30px;">
				<div class="col-md-6">
					<p>Enter your registered email address and we will send you a temporary password.</p>
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="email">
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 text-right">
						<button type="submit" class="btn btn-info">Send</button>
					</div>
				</div>

				{{ csrf_field() }}
			</form>
		</div>
	</div>


@stop

@section('js')
@stop