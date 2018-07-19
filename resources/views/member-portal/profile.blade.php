@extends('member-portal')

@section('css')
	<link href="{{ asset('/css/member-portal.css') }}" rel="stylesheet">
@stop

@section('main-content')
	@include('member-portal.partials.nav-mobile')

	@include('member-portal.partials.nav-header')

	<br/>
	<div class="page-content--bgf7">
		@include('member-portal.partials.breadcrumbs', ['page_title' => 'Profile'])

		<section class="statistic statistic2">
			<div class="main-content">
				<div class="section__content section__content--p30">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<strong class="card-title mb-3">Profile</strong>
									</div>
									<div class="card-body">
										<div class="mx-auto d-block">
											<img class="rounded-circle mx-auto d-block" src="{{ asset('img/profile.png') }}" alt="Card image cap">

											<h5 class="text-sm-center mt-2 mb-1">{{ $user->members->first_name }} {{ $user->members->last_name }}</h5>
											{{--<div class="location text-sm-center">--}}
												{{--<i class="fa fa-map-marker"></i> London, United Kingdom--}}
											{{--</div>--}}
										</div>
										<br/>
										<br/>
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
													<div class="row">
														<div class="col-6">
															<h3>Personal Information</h3>
															<br>
															<div class="form-group">
																<label>Firstname</label>
																<input type="text" class="form-control" name="first_name" value="{{ $user->members->first_name }}">
															</div>

															<div class="form-group">
																<label>Lastname</label>
																<input type="text" class="form-control" name="last_name" value="{{ $user->members->last_name }}">
															</div>
														</div>
														<div class="col-6">
															<h3>Login Credentials</h3>
															<br>
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
													</div>

													<div class="row">
														<div class="col-6">
															<h3>Company Informnation</h3>
															<br>
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
																	<label>Phone No.</label>
																	<input type="text" class="form-control" name="company[phone_no]" value="{{ $phone_no }}">
																</div>

																<div class="form-group">
																	<label>Mobile No.</label>
																	<input type="text" class="form-control" name="company[mobile_no]" value="{{ $mobile_no }}">
																</div>

																<div class="form-group">
																	<label>Email</label>
																	<input type="text" class="form-control" name="company[email]" value="{{ $email_add }}">
																</div>

																<input type="hidden" name="cid" value="{{ $company_id }}">
															@endif
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
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	</div>
	@include('parking.templates.footer')

@stop

@section('js')
@stop