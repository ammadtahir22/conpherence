<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{--Globel Varable--}}
    <script type='text/javascript' >
        var base_url = '@php echo url('/'); @endphp';
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <title>{{ config('app.name', 'Conpherence') }}</title>

    @if(!auth()->guest())
        <script>
            window.Laravel.userId = <?php echo auth()->user()->id; ?>;
            window.Laravel.userType = '<?php echo auth()->user()->type; ?>';
        </script>
    @endif

@yield('head')

<!-- Scripts -->
    {{--<link href="{{url('css/app.css')}}" rel="stylesheet">--}}
<!-- Bootstrap -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link href="{{url('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{url('css/animate.css')}}" rel="stylesheet">
    {{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css'>--}}
    {{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css'>--}}
    <link rel='stylesheet' href="{{url('css/select2.min.css')}}">
    <link href="{{url('css/layout.css')}}" rel="stylesheet">
    <link href="{{url('css/calender.css')}}" rel="stylesheet">
    <link href="{{url('css/responsive.css')}}" rel="stylesheet">
    <link href="{{url('css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{url('css/jquery-ui.css')}}" rel="stylesheet">
    {{--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0-RC1/css/bootstrap-datepicker3.standalone.min.css'>--}}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon"type="image/png" href="{{url('images/favicon.png')}}">
    <link rel="apple-touch-startup-image" href="{{url('/launch.png')}}">
    <link rel="apple-touch-icon" href="{{url('images/touch-icon-iphone.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{url('images/apple-touch-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('images/apple-touch-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{url('images/apple-touch-icon-114x114.png')}}">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <!-- Start of  Zendesk Widget script -->
    <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=1da688be-9811-4834-ba20-3621b86a7bf3"> </script>
    <!-- End of  Zendesk Widget script -->

</head>

{{--@include('layouts.head')--}}

<body>

@yield('header')

@yield('content')

@yield('footer')

@yield('scripts')


</body>
</html>

