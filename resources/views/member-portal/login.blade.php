@extends('member-portal')
@section('css')

@stop
@section('main-content')
	<div class="limiter">

		<div class="container-login100">
			<div class="wrap-login100">

				<form class="login100-form validate-form" action="{{ url('/member/authenticate') }}" method="post">
					{{-- THIS WILL GO BACK TO THE PREVIOUS PAGE --}}
					<a href="{{ url('/') }}" class="back">
						<i class="fas fa-arrow-left"></i>
					</a>
					<span class="login100-form-title p-b-43">Login to continue</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" autofocus="true">
						<span class="focus-input100"></span>
						<span class="label-input100" id="email">Email</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">Remember me</label>
						</div>

						<div>
							<a href="{{ url('/forgot-password') }}" class="txt1">Forgot Password?</a>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">Login</button>
					</div>
					<br/>
					<div class="container-signup100-form-btn">
						<button type="button" class="signup100-form-btn">Sign Up</button>
					</div>

					{{--<div class="text-center p-t-46 p-b-20">--}}
						{{--<span class="txt2">or sign up using</span>--}}
					{{--</div>--}}

					{{--<div class="login100-form-social flex-c-m">--}}
						{{--<a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">--}}
							{{--<i class="fab fa-facebook-f" aria-hidden="true"></i>--}}
						{{--</a>--}}

						{{--<a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">--}}
							{{--<i class="fab fa-twitter" aria-hidden="true"></i>--}}
						{{--</a>--}}
					{{--</div>--}}

					{{ csrf_field() }}
				</form>

				<div class="login100-more" style="background-image: url('{{ asset('/img/images/bg-01.jpg') }}');"></div>
			</div>
		</div>
	</div>
@stop

@section('js')
<script type="text/javascript">
	$(function () {
		$(document).on('click', '.signup100-form-btn', function (e) {
		    window.location = "{{ url('/signup') }}";
		});
	});
</script>
@stop
