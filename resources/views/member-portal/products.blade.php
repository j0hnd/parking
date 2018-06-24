@extends('member-portal')

@section('main-content')
	<div id="mobileNav" class="overlay-nav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<div class="overlay-content">
			<a href="{{ url('/members/dashboard') }}">Dashboard</a>
			@if($user->roles[0]->slug == 'vendor')
			<a href="{{ url('/members/products') }}">My Products</a>
			@endif
			<a href="{{ url('/members/profile') }}">Profile</a>
			<a href="{{ url('/members/inbox') }}">Inbox</a>
			<a href="{{ url('/logout') }}">Logout</a>
		</div>
	</div>
	<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
		<a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
		@include('parking.templates.member-nav')
		<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
	</nav>

	<br>

	<div class="page-content--bgf7">
		<section class="au-breadcrumb2">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="au-breadcrumb-content">
							<div class="au-breadcrumb-left">
								<span class="au-breadcrumb-span">You are here:</span>
								<ul class="list-unstyled list-inline au-breadcrumb__list">
									<li class="list-inline-item">Dashboard</li>
									<li class="list-inline-item seprate">
										<span>/</span>
									</li>
									<li class="list-inline-item">My Products</li>
								</ul>
							</div>
							<form class="au-form-icon--sm" action="" method="post">
								<input class="au-input--w300 au-input--style2" type="text" placeholder="Search for transactions...">
								<button class="au-btn--submit2" type="submit">
									<i class="zmdi zmdi-search"></i>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>

		<div class="main-content" style="padding-top: 20px">
			<div class="section__content section__content--p30">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<strong class="card-title mb-3">My Products</strong>
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

										<div class="row">
											<div class="co-md-12">
												<table class="table">
													<thead class="thead-dark">
														<tr>
															<th scope="col">Product</th>
															<th scope="col">Type</th>
															<th scope="col">Carpark</th>
															<th scope="col">Airport</th>
															<th scope="col">Price</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('parking.templates.footer')
@stop