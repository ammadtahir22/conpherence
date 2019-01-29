<!DOCTYPE html>
<html lang="en-us" id="extr-page">
<head>
    <meta charset="utf-8">
    <title> Conpherence </title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- #CSS Links -->
    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/font-awesome.min.css')}}">

    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/smartadmin-production-plugins.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/smartadmin-production.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/smartadmin-skins.min.css')}}">

    <!-- SmartAdmin RTL Support -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/smartadmin-rtl.min.css')}}">

    <!-- We recommend you use "your_style.css" to override SmartAdmin
         specific styles this will also ensure you retrain your customization with each SmartAdmin update.
    <link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

    <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
    {{--<link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/demo.min.css')}}">--}}

    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="{{url('images/admin-panel/favicon/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{url('images/admin-panel/favicon/favicon.ico')}}" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- #APP SCREEN / ICONS -->
    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="{{url('images/admin-panel/splash/sptouch-icon-iphone.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('images/admin-panel/splash/touch-icon-ipad.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('images/admin-panel/splash/touch-icon-iphone-retina.png')}}">
    <link rel="apple-touch-icon" sizes="152x152"  href="{{url('images/admin-panel/splash/touch-icon-ipad-retina.png')}}">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="{{url('images/admin-panel/splash/ipad-landscape.png')}}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="{{url('images/admin-panel/splash/ipad-portrait.png')}}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="{{url('images/admin-panel/splash/iphone.png')}}" media="screen and (max-device-width: 320px)">

    <style>
        .admin-pane{
            float:inherit;
            margin:auto;
        }
        #extr-page #main {
            margin-top: 0!important;
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 90px);
        }
    </style>



</head>

<body class="animated fadeInDown">

<header id="header">
    <div id="logo-group">
        <a href="{{url('admin/')}}"><span id="logo"> <img src="{{url('images/logo.png')}}" alt="Conpherence">  </span>  </a>
    </div>
</header>

<div id="main" role="main">

    <!-- MAIN CONTENT -->
    <div id="content" class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 admin-pane">
                <div class="well no-padding">
                    <form method="POST" action="{{ route('admin.login.submit') }}" id="login-form" class="smart-form client-form">
                        @csrf
                        <header>
                            Admin Sign In
                        </header>

                        <fieldset>

                            <section>
                                <label class="label">E-mail</label>
                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                    <input type="email" name="email">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b></label>
                            </section>

                            <section>
                                <label class="label">Password</label>
                                <label class="input"> <i class="icon-append fa fa-lock"></i>
                                    <input type="password" name="password">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
                                {{--<div class="note">--}}
                                    {{--<a href="forgotpassword.html">Forgot password?</a>--}}
                                {{--</div>--}}
                            </section>

                            {{--<section>--}}
                            {{--<label class="checkbox">--}}
                            {{--<input type="checkbox" name="remember" checked="">--}}
                            {{--<i></i>Stay signed in</label>--}}
                            {{--</section>--}}
                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary">
                                Sign in
                            </button>
                        </footer>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

<!--================================================== -->

@include('admin-panel.layouts.scripts')

<script type="text/javascript">
    runAllForms();

    $(function() {
        // Validation
        $("#login-form").validate({
            // Rules for form validation
            rules : {
                email : {
                    required : true,
                    email : true
                },
                password : {
                    required : true,
                    minlength : 6,
                    maxlength : 20
                }
            },

            // Messages for form validation
            messages : {
                email : {
                    required : 'Please enter your email address',
                    email : 'Please enter a VALID email address'
                },
                password : {
                    required : 'Please enter your password'
                }
            },

            // Do not change code below
            errorPlacement : function(error, element) {
                error.insertAfter(element.parent());
            }
        });
    });
</script>

</body>
</html>