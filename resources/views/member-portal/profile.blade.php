@extends('parking-app')

@section('css')
	<link href="{{ asset('/css/parking-search.css') }}" rel="stylesheet">
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
				<h3 class="padding-20">Profile</h3>
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
			<form action="{{ url('/members/update/profile') }}" method="post" style="width: 100%; padding-bottom: 30px;">
				<div class="col-sm">
					<div class="form-group">
						<label>Firstname</label>
						<input type="text" class="form-control" name="first_name" value="{{ $user->members->first_name }}">
					</div>

					<div class="form-group">
						<label>Lastname</label>
						<input type="text" class="form-control" name="last_name" value="{{ $user->members->last_name }}">
					</div>
				</div>

				<div class="col-sm">
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" value="{{ $user->email }}" disabled>
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="new_password">
					</div>

					<div class="form-group">
						<label>Confirm Password</label>
						<input type="password" class="form-control" name="confirm_password">
					</div>
				</div>

				<button type="submit" class="btn btn-info">Update</button>
				<input type="hidden" name="id" value="{{ $user->id }}">
				{{ csrf_field() }}
			</form>
		</div>
	</div>


@stop

@section('js')
@stop