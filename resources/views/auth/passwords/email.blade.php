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
                        <h4>Forgot Password</h4>
                        <img src="{{url('images/bar.png')}}" alt="" />

                        @if (session('status'))
                            <p class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </p>
                        @endif

                        <p>Enter the email address you used when you joined and we’ll send you instructions to reset your password.</p>
                        <p>For security reasons, we do NOT store your password. So rest assured that we will never send your password via email.</p>
                        <form method="POST" action="{{ route('password.email') }}" class="fill-form input" id="forget_password_form">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email" name="email" placeholder="Email" required autofocus>
                            </div>
                            <div class="form-group">
                                <button class="form-btn ani-btn">Send Reset Instructions</button>
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
        $("#forget_password_form").validate({
            messages: {
                email: {
                    required: "Email address is required",
                    email: "Should be a valid email address"
                }
            }
        });
    </script>
@endsection
