<!--header-->
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
            <ul class="nav navbar-nav" >
                <li class="active"><a href="{{url('/')}}" >Home</a></li>
                <li><a href="{{url('/page/how-it-works')}}">How it Works</a></li>
                <li><a href="{{url('/categories')}}">Venues</a></li>
                {{--<li><a href="#">Saved</a></li>--}}
                {{--<li><a href="#">Become a Host </a></li>--}}
                <li class="asd-nav">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">AED</a>
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li><a href="#">AED 10 - AED 100</a></li>--}}
                        {{--<li><a href="#">AED 101 - AED 200</a></li>--}}
                        {{--<li><a href="#">AED 201 - AED 300</a></li>--}}
                    {{--</ul>--}}
                </li>
                @guest
                    <li><a href="{{url('/login')}}">Login</a></li>
                    <li><a href="{{url('/register')}}" class="btn get-btn"><span>Register Now</span><span></span><span></span><span></span><span></span> </a></li>
                @else
                    <li class="dropdown nitif" id="notification_li" style="">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{url('images/bell.png')}}" alt="">
                            {{--<span class="badge">{{Auth::user()->unreadNotifications->count()}}</span>--}}
                        </a>
                        {{--<ul class="dropdown-menu scroll-bar">--}}
                            {{--@if(Auth::user()->unreadNotifications->count())--}}
                                {{--<li><div class="dropdown-title">Today</div></li>--}}
                                {{--@foreach(Auth::user()->unreadNotifications as $notification)--}}
                                    {{--<li class="active">--}}
                                        {{--<a href="#">--}}
                                            {{--<div class="noti-img">--}}
                                                {{--<img src="{{url('images/booking-img.png')}}" alt="" />--}}
                                            {{--</div>--}}
                                            {{--<div class="noti-info">--}}
                                                {{--<div class="noti-info-left">--}}
                                                    {{--<h3>Your Upcoming Booking</h3>--}}
                                                    {{--<h4>{{$notification->data['booking']['space_id']}}<span>{{ get_city_by_venue($notification->data['booking']['venue_id'])}}</span></h4>--}}
                                                {{--</div>--}}
                                                {{--<div class="noti-info-right">--}}
                                                    {{--<span>4.5<i class="star">★★★★★</i></span>--}}
                                                    {{--<h4>AED 400</h4>--}}
                                                    {{--<div class="date">20 to 22 July</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                {{--@endforeach--}}
                            {{--@else--}}
                                {{--<li>--}}
                                    {{--<a>--}}
                                        {{--No Notification--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--@endif--}}
                        {{--</ul>--}}
                    </li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{get_user_image(Auth::user()->id)}}" alt=""/></a>
                        <ul class="dropdown-menu">
                            @php
                                if(Auth::user()->type == 'company')
                            {
                                $dashboard = 'dashboard-company';
                            } else {
                                $dashboard = 'dashboard-user';
                            }
                            @endphp
                            <li class="active"><a href="{{ route($dashboard) }}"><div class="userimg"><img src="{{url('images/dash-iconh1.png')}}" alt="" /></div>My account</a></li>
                            {{--<li class="active"><a href="#"><div class="userimg"><img src="{{url('images/user-menu.png')}}" alt="" /></div>User Settings</a></li>--}}
                            {{--<li><a href="#"><div class="userimg"><img src="{{url('images/user-menu1.png')}}" alt="" /></div>Account Settings</a></li>--}}
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <div class="userimg"><img src="{{url('images/user-menu2.png')}}" alt="" /></div>
                                    Logout
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav><!--header-->
