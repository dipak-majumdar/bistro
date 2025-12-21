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

</head>

<body id="register_bg">
	
	<video class="video-bg" autoplay muted loop>
		<source src="{{ asset('assets/web/video/login-bg.mp4') }}" type="video/mp4">
	</video>
	<div id="register">
		<aside>
			<figure>
				<a href="{{ route('home') }}"><img src="{{ asset('assets/site/logo.png') }}" width="140" height="auto" alt=""></a>
			</figure>
			<div class="access_social">
					<a href="#0" class="social_bt facebook">Register with Facebook</a>
					<a href="#0" class="social_bt google">Register with Google</a>
				</div>
            <div class="divider"><span>Or</span></div>
			<form autocomplete="off" method="POST" action="{{ route('register') }}">
				@csrf

				<div class="form-group mb-0">
					<input class="form-control" type="text" placeholder="Name" :value="old('name')" name="name">
					<i class="icon_pencil-edit"></i>
				</div>
				@if ($errors->get('name'))
					@foreach ((array) $errors->get('name') as $message)
						<p class="small text-danger mb-2">{{ $message }}</p>
					@endforeach
				@endif
				
				{{-- <div class="form-group">
					<input class="form-control" type="text" placeholder="Last Name" :value="old('name')" name="name">
					<i class="icon_pencil-edit"></i>
				</div>
				@if ($errors->get('email'))
					@foreach ((array) $errors->get('email') as $message)
						<p class="small text-danger mb-2">{{ $message }}</p>
					@endforeach
				@endif --}}
				
				<div class="form-group mb-0 mt-3">
					<input class="form-control" type="email" placeholder="Email" :value="old('email')" name="email">
					<i class="icon_mail_alt"></i>
				</div>
				@if ($errors->get('email'))
					@foreach ((array) $errors->get('email') as $message)
						<p class="small text-danger mb-2">{{ $message }}</p>
					@endforeach
				@endif

				<div class="form-group mb-0 mt-3">
					<input class="form-control" type="password" id="password1" placeholder="Password" name="password">
					<i class="icon_lock_alt"></i>
				</div>
				@if ($errors->get('Password'))
					@foreach ((array) $errors->get('Password') as $message)
						<p class="small text-danger mb-2">{{ $message }}</p>
					@endforeach
				@endif

				<div class="form-group mb-0 mt-3">
					<input class="form-control" type="password" id="password2" placeholder="Confirm Password" name="password_confirmation">
					<i class="icon_lock_alt"></i>
				</div>
				@if ($errors->get('password_confirmation'))
					@foreach ((array) $errors->get('password_confirmation') as $message)
						<p class="small text-danger mb-2">{{ $message }}</p>
					@endforeach
				@endif

				<div id="pass-info" class="clearfix"></div>
				<button type="submit" class="btn_1 gradient full-width">Register Now!</button>
				{{-- <a href="#0" class="btn_1 gradient full-width">Register Now!</a> --}}
				<div class="text-center mt-2"><small>Already have an acccount? <strong><a href="{{ route('login') }}">Sign In</a></strong></small></div>
			</form>
			<div class="copy">© 2020 FooYes</div>
		</aside>
	</div>
	<!-- /login -->
	
	<!-- COMMON SCRIPTS -->
	
    <script src="{{ asset('assets/web/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/common_func.js') }}"></script>
    <script src="{{ asset('assets/web/js/validate.js') }}"></script> --}}
    <script src="assets/validate.js"></script>
	
	<!-- SPECIFIC SCRIPTS -->
	<script src="{{ asset('assets/web/js/pw_strenght.js') }}"></script>	
  
</body>
</html>