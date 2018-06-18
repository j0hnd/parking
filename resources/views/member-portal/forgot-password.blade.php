@extends('member-portal')

@section('css')
	<link href="{{ asset('/css/member-portal.css') }}" rel="stylesheet">
@stop

@section('main-content')
	<div id="mobileNav" class="overlay-nav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content">
        <a href="#">Dashboard</a>
        <a href="#">Profile</a>
        <a href="#">Logout</a>
      </div>
    </div>
	<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
		<a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
		@include('parking.templates.member-nav')
		<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
	</nav>

	<br/><br/><br/><br/><br/>

	

	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="padding-20">Forgot Password</h3>
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

				<form action="{{ url('/process/forgot-password') }}" method="post" style="width: 100%; padding-bottom: 30px;">
					<div class="col-md-12">
						<p>Enter your registered email address and we will send you a temporary password.</p>
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="email" placeholder="Email Address">
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 text-right">
							<button type="submit" class="btn btn-info">Send</button>
						</div>
					</div>

					{{ csrf_field() }}
				</form>
			</div>
		</div>
	</div>

	@include('parking.templates.footer')
@stop

@section('js')
@stop