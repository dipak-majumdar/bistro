{{-- @extends('web.web-layout')

@section('header')
@endsection

@section('main')
@endsection

@section('elements')
@endsection --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="FooYes - Quality delivery or takeaway food">
    <meta name="author" content="Ansonika">
    <title>FooYes - Quality delivery or takeaway food</title>
    
	<x-web.header-link />
	    <!-- SPECIFIC CSS -->
		<link href="{{ asset('assets/web/css/order-sign_up.css') }}" rel="stylesheet">

		<style>
			#register_bg {
			position: relative;
			min-height: 100vh;
			width: 100%;
			overflow: hidden;
			display: flex;
			justify-content: center;
			align-items: center;
			}
			
			#register_bg::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(0, 0, 0, 0.4);
			z-index: 1;
			}
			
			.video-bg {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			min-width: 100%;
			min-height: 100%;
			width: auto;
			height: auto;
			z-index: 0;
			}
			
			#register {
			z-index: 2;
			}
		</style>
</head>

<body id="register_bg">
	
	<video class="video-bg" autoplay muted loop>
		<source src="{{ asset('assets/web/video/login-bg.mp4') }}" type="video/mp4">
	</video>
	
	<div id="register">
		<aside>
			<figure>
				<a href="{{ route('register') }}"><img src="{{ asset('assets/web/img/logo_sticky.svg') }}" width="140" height="35" alt=""></a>
			</figure>
			<div class="access_social">
					<a href="#0" class="social_bt facebook">Login with Facebook</a>
					<a href="#0" class="social_bt google">Login with Google</a>
				</div>
            <div class="divider"><span>Or</span></div>
			<form method="POST" action="{{ route('login') }}" autocomplete="off">
				@csrf
				<div class="form-group">
					<input class="form-control" type="email" placeholder="Email" name="email" id="email" value="{{ old('email') }}">
					<i class="icon_mail_alt"></i>
					<p>{{ $errors->first('email') }}</p>
				</div>
				<div class="form-group">
					<input class="form-control" type="password" id="password" placeholder="Password" name="password" value="{{ old('password') }}">
					<i class="icon_lock_alt"></i>
					<p>{{ $errors->first('password') }}</p>
				</div>
				<div class="clearfix add_bottom_15">
					<div class="checkboxes float-start">
						<label class="container_check">Remember me
						  <input type="checkbox">
						  <span class="checkmark"></span>
						</label>
					</div>
					<div class="float-end"><a id="forgot" href="#0">Forgot Password?</a></div>
				</div>
				<div>
					{{ session('status') }}
				</div>
				<button type="submit" class="btn_1 gradient full-width">Login Now!</button>
				<div class="text-center mt-2">
					<small>Don't have an acccount? <strong><a href="{{ route('register') }}">Sign Up</a></strong></small>
				</div>
			</form>
			<div class="copy">© 2020 FooYes</div>
		</aside>
	</div>
	<!-- /login -->
	
	<!-- COMMON SCRIPTS -->
    <script src="{{ asset('assets/web/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/common_func.js') }}"></script>
    <script src="{{ asset('assets/web/js/validate.js') }}"></script>

	<!-- SPECIFIC SCRIPTS -->
	<script src="{{ asset('assets/web/js/pw_strenght.js') }}"></script>	
  
</body>
</html>