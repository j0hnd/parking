@extends('member-portal')

@section('css')
<link href="{{ asset('/css/member-portal.css') }}" rel="stylesheet">
	<style type="text/css">
		.main-content {
		    padding-top: 20px;
		    min-height: 55vh;
		}
		.card {
		    margin-bottom: 30px;
		    width: 50%;
		    position: relative;
		    margin-left: 25%;
		}
		.col-md-6 {
		    -ms-flex: 0 0 50%;
		    flex: 0 0 50%;
		    max-width: 100%;
		}
		.offset-md-3 {
    		margin-left: 0%;
		}
		.btn{
			position: relative;
			right: 15px;
		}
		@media only screen and (min-width:100px ) and (max-width:699px){
		.card {
		        margin-bottom: 30px;
		        width: 100%;
		        position: relative;
		        margin-left: 0%;
		    }
		.col-md-6 {
		        -ms-flex: 0 0 50%;
		        flex: 0 0 50%;
		        max-width: 100%;
		    }
		.offset-md-3 {
		        margin-left: 0%;
		    }
		}
	</style>
	
@stop

@section('main-content')
	@include('parking.templates.nav-mobile')
	<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
		<a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
		@include('parking.templates.nav')
		<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
	</nav>

	<br/>
	<div class="page-content--bgf7">
	<section class="statistic statistic2">
	<div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
	 <div class="card">
         <div class="card-header">
            <strong class="card-title mb-3">Forgot Password</strong>
         </div>
    <div class="card-body">
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
</div>
</div>
</div>
</div>
</section>
</div>
	

@include('parking.templates.footer')
@stop

@section('js')
<script src="{{ asset('/js/navigation.js') }}" type="text/javascript"></script>
@stop