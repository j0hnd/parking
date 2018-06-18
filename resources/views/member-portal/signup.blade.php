@extends('parking-app')

@section('css')
	<link href="{{ asset('/css/parking-search.css') }}" rel="stylesheet">
@stop

@section('main-content')
@include('parking.templates.nav-mobile')
	<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
		<a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
		@include('parking.templates.nav')
		<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
	</nav>

	<br/><br/><br/><br/><br/>

	<nav class="navbar-expand-lg navbar-light bg-light navbar-2"></nav>

	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3 class="padding-20">Signup</h3>
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

				<form action="" method="post" style="width: 100%; padding-bottom: 30px;">
					<div class="col-sm">
						<div class="form-group">
							<label>Firstname</label>
							<input type="text" class="form-control" name="first_name" placeholder="Firstname">
						</div>

						<div class="form-group">
							<label>Lastname</label>
							<input type="text" class="form-control" name="last_name" placeholder="Lastname">
						</div>

						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="email" placeholder="Email Address">
						</div>

						<div class="form-group">
							<label>Member Type</label>
							<select name="member_type" class="form-control member-type">
								<option value="member">Member</option>
								<option value="vendor">Vendor</option>
								<option value="travel_agent">Travel Agent</option>
							</select>
						</div>

						<div id="company-wrapper" class="form-group d-none">
							<label>Company Name</label>
							<input type="text" class="form-control" name="company_name" placeholder="Company Name">
						</div>
					</div>

					<div class="col-sm text-right">
						<button type="submit" class="btn btn-info">Sign Up</button>
					</div>

					{{ csrf_field() }}
				</form>
			</div>
		</div>
	</div>


@stop

@section('js')
<script type="text/javascript">
	$(function () {
		$(document).on('change', '.member-type', function (e) {
		    if ($(this).val() == 'member') {
                $('#company-wrapper').addClass('d-none');
			} else {
		        $('#company-wrapper').removeClass('d-none');
			}
        });
    });
</script>
<script src="{{ asset('/js/navigation.js') }}" type="text/javascript"></script>
@stop