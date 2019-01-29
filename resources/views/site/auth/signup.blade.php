@extends('site.layouts.app')

@section('head')
	<link rel='stylesheet' href='{{url('css/intlTelInput.css')}}'>
@endsection

@section('header-class', 'home-header')

@section('header')
	<nav class="navbar navbar-default navbar-fixed-top nav_inner header @yield('header-class')">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
				<a class="navbar-brand" href="{{url('/')}}"><img src="{{url('images/logo.png')}}" alt="logo"></a></div>
			<a href="#" id="toggle"><span class="top"></span>
				<span class="middle"></span>
				<span class="bottom"></span>
			</a>
			<div id="overlay"></div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="menu">
				<ul class="nav navbar-nav sigup-nav"  >
					<li class=""><a href="{{url('/login')}}" ><span>Already have an account</span> Sign In</a></li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->
	</nav><!--header-->
@endsection

@section('content')

	@php
			$name = '';
			$email = '';
            $provider_id = '';
            $provider = '';

            if (isset($user))
            {
                $name = $user['name'];
                $email = $user['email'];
                $provider_id = $user['id'];
                $provider = $user['provider'];
            }
	@endphp

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

				<div class="col-sm-4 sign-right signup-box clearfix">
					<div class="sign-wrap">
						<h4>Sign up to your account</h4>
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

						<form method="POST" action="{{ route('register') }}" class="fill-form input" id="signup-form">
							@csrf
							<input type="hidden" name="provider_id" value="{{ $provider_id }}">
							<input type="hidden" name="provider" value="{{ $provider }}">
							<div class="form-group">
								<input type="text" name="name" class="input-feild" placeholder="Name" value="{{ $name }}" required>
							</div>
							<div class="form-group">
								<input type="email" name="email" class="input-feild" placeholder="Email" value="{{ $email }}" required>
							</div>

							@if ($errors->any())
								<p class="alert alert-danger" role="alert">
									{{ $errors->first() }}
								</p>
							@endif

							<div class="form-group">
								<select name="type" id="type" class="input-feild" required onchange="checkType(this.value)">
									<option disabled selected>Account type</option>
									<option value="individual">Individual/Company </option>
									<option value="company">Hotel Owner</option>
								</select>
							</div>
							<div class="form-group">
								<input type="text" id="company_name" class="input-feild" name="company_name" placeholder="Hotel name"
									   value="{{ old('company_name') }}" style="display: none">
							</div>
							<div class="form-group">
								<input type="tel" name="phone_number" class="input-feild telephone" id="telephone" placeholder="Phone number" value="{{ old('phone_number') }}" required>
							</div>
							<div class="form-group">
								<input type="password" name="password" class="input-feild"  placeholder="Password" minlength="6" required>
							</div>

							<div class="form-group form-check sign-check">
                                <label for="check_agree">
                                    <input type="checkbox" id="check_agree" name="agree" class="input-feild"  value="agree" title="Please agree to our policy!" required>
                                    I have read and accept the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                                    <span class="checkmark"></span>
                                </label>
								{{--<input type="checkbox" id="check_agree" name="agree" class="input-feild"  value="agree" title="Please agree to our policy!" required>--}}
								{{--<label for="check_agree">I have read and accept the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a></label>--}}
							</div>
							<div class="form-group">
								<button class="form-btn ani-btn" type="submit">Sign Up</button>
								<div class="or">Or</div>
								<div class="btn-l-half">
									<a href="{{ url('/auth/facebook') }}" class="form-btn ani-btn fb-btn"><i class="flaticon-facebook-logo"></i>Facebook</a>
								</div>
								<div class="btn-r-half">
									<a href="{{ url('/auth/google') }}" class="form-btn ani-btn g-btn"><i class="flaticon-google-plus-symbol google"></i>Gmail</a>
								</div>
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
	@include('site.layouts.scripts')
	<script src='{{url('js/intlTelInput.min.js')}}'></script>

	<script>

        $('document').ready(function(){
            var input = document.querySelector("#telephone");
            window.intlTelInput(input, {
                nationalMode: false,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
            });
            // $(".telephone").intlTelInput({
            //     nationalMode: false,
            //     utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
            // });
        });

        // $(".telephone").intlTelInput({
        //     nationalMode: false,
        //     utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
        // });

		function checkType(value) {
			if(value === 'company')
			{
                $('#company_name').show();
                $('#company_name').prop('required',true);
			} else {
                $('#company_name').hide();
                $('#company_name').prop('required',false);
			}
        }

        $("#signup-form").validate({
            messages: {
                name: {
                    required: "Please enter your name first",
                    minlength: "Name Length should be more then 2"
                },
                email: {
                    required: "Email address is required",
                    email: "Should be a valid email address"
                },
                type: {
                    required: "Please select a account type",
                },
                phone_number: {
                    required: "Phone number is required",
                },
                password: {
                    required: "Password is required",
					minlength: "Minimum length is 6"
                },
                agree: {
                    required: "Please accept Terms and Conditions and Privacy Policy"
                },
			}
		});
	</script>
@endsection
