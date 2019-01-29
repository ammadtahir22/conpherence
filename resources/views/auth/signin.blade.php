@extends('layouts.app')

@section('head')
	<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
@endsection

@section('header')
	<ul class="nav navbar-nav sigup-nav"  >
		<li class=""><a href="{{url('/register')}}" ><span>Not a member?</span> Register now</a></li>
	</ul>
@endsection

@section('content')
	<section class="sign-section full-col">
		<div class="container">
			<div class="sign-inner clearfix">
				<div class="sign-left col-sm-8 clearfix">
					<div class="sign-info">
						<h2>Register a <span>free account now</span></h2>
						<p>Discover, Book and Enjoy</p>
						<img src="images/bar.png" alt="" class="bar-img" />
					</div>
				</div>

				<div class="col-sm-4 sign-right signin-right clearfix">
					<div class="sign-wrap">
						<h4>Individual Account</h4>
						<img src="images/bar.png" alt="" />

						@if (session('msg-success'))
							<p class="alert alert-success" role="alert">
								{{ session('msg-success') }}
							</p>
						@endif

						@if (session('msg-error'))
							<p class="alert alert-success" role="alert">
								{{ session('msg-error') }}
							</p>
						@endif


						<form method="POST" action="{{ route('login') }}" class="fill-form input" id="login-form">
							@csrf
							<div class="form-group">
								<input class="{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
							</div>

							@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert" style="color:#cc0000;">
                                        <strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif

							{{--@if ($errors->any())--}}
								{{--<p class="alert alert-success" role="alert">--}}
									{{--{{ $errors->first() }}--}}
								{{--</p>--}}
							{{--@endif--}}

							<div class="form-group">
								<input class="{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Password" required>
							</div>

							@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert" style="color:#cc0000;">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
							@endif

							<div class="form-group form-check ">
								<input type="checkbox" id="login">
								<label for="login">Keep me signed in</label>
							</div>
							<a href="{{ route('password.request') }}" class="forgot">Forgot your password?</a>
							<div class="form-group">
								<button class="form-btn ani-btn">Sign In</button>
								<div class="or">Or</div>
								<a href="{{ url('/auth/facebook') }}" class="form-btn ani-btn fb-btn"><i class="flaticon-facebook-logo"></i>Continue with Facebook</a>
								<a href="{{ url('/auth/google') }}" class="form-btn ani-btn g-btn"><i class="flaticon-google-plus-symbol google"></i>Continue with Gmail</a>
							</div>
						</form>
					</div><!-- signup-wrap -->
				</div>
			</div>
		</div><!--CONTAINER-->
		<div class="clearfix"></div>
	</section>
@endsection

@section('scripts')
	@include('layouts.scripts')

    <script>
        $("#login-form").validate({
            messages: {
                email: {
                    required: "Email address is required",
                    email: "Should be a valid email address"
                },
                password: {
                    required: "Password is required",
                },
            }
        });
    </script>

@endsection
