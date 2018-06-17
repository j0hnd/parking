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
			<div class="col-md-12 text-center">
				<h3 class="padding-20">Profile</h3>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 offset-md-3">
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

				@if (session('success'))
					<div class="alert alert-success">
						{{ session('success') }}
					</div>
				@endif

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

						@if(in_array($user->roles[0]->slug, ['vendor', 'travel_agent']))
							@php
								$company_id   = is_null($user->members->company) ? "" : $user->members->company->id;
								$company_name = is_null($user->members->company) ? "" : $user->members->company->company_name;
								$phone_no     = is_null($user->members->company) ? "" : $user->members->company->phone_no;
								$mobile_no    = is_null($user->members->company) ? "" : $user->members->company->mobile_no;
								$email_add    = is_null($user->members->company) ? "" : $user->members->company->email;
							@endphp

						<div class="form-group">
							<label>Company Name</label>
							<input type="text" class="form-control" name="company[company_name]" value="{{ $company_name }}">
						</div>

						<div class="form-group">
							<label>Company Phone No.</label>
							<input type="text" class="form-control" name="company[phone_no]" value="{{ $phone_no }}">
						</div>

						<div class="form-group">
							<label>Company Mobile No.</label>
							<input type="text" class="form-control" name="company[mobile_no]" value="{{ $mobile_no }}">
						</div>

						<div class="form-group">
							<label>Company Email</label>
							<input type="text" class="form-control" name="company[email]" value="{{ $email_add }}">
						</div>

						<input type="hidden" name="cid" value="{{ $company_id }}">
						@endif
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

					<div class="col-sm text-right">
						<button type="submit" class="btn btn-info">Update</button>
					</div>

					<input type="hidden" name="id" value="{{ $user->id }}">
					{{ csrf_field() }}
				</form>
			</div>
		</div>
	</div>


@stop

@section('js')
@stop