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
                <div class="col-sm-4 sign-right forgot-box midtext clearfix">
                    <div class="sign-wrap">
                        <h4>Reset Password</h4>
                        <img src="{{url('images/bar.png')}}" alt="" />

                        @if (session('status'))
                            <p class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </p>
                        @endif

                        <p>Enter the new Password</p>
                        <form method="POST" action="{{ route('password.request') }}" class="fill-form input" id="reset_password_form">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">
                            <input id="email" type="hidden" name="email" placeholder="Email"  value="{{ $email ?? old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif


                            <div class="form-group">
                                <input id="password" type="password" name="password" placeholder="Password">
                            </div>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif

                            <div class="form-group">
                                <input id="password-confirm" type="password" name="password_confirmation" placeholder="Password confirmation">
                            </div>

                            <div class="form-group">
                                <button class="form-btn ani-btn" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div><!-- signup-wrap -->
                </div>
            </div>
        </div><!--CONTAINER-->
        <div class="clearfix"></div>
    </section>

@endsection



{{--@section('footer')--}}
{{--@include('layouts.footer')--}}
{{--@endsection--}}

@section('scripts')
    @include('layouts.scripts')
    <script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}"></script>

    <script>
        $("#reset_password_form").validate({
            rules:{
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation : {
                    required: true,
                    minlength : 6,
                    equalTo : "#password"
                }
            },
            messages: {
                password: {
                    required: "Password is required",
                    minlength: "Minimum length is 6"
                },
                password_confirmation : {
                    required: "Confirm Password is required",
                    minlength : "Minimum length is 6",
                    equalTo : "Password must same"
                }
            }
        });
    </script>
@endsection

