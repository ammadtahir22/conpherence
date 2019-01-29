@php if(!isset($active_dashboard)) { $active_dashboard = ''; } @endphp
@php if(!isset($active_venue)) { $active_venue = ''; } @endphp
@php if(!isset($active_profile)) { $active_profile = ''; } @endphp
@php if(!isset($active_payment)) { $active_payment = ''; } @endphp
@php if(!isset($active_booking)) { $active_booking = ''; } @endphp
@php if(!isset($active_review)) { $active_review = ''; } @endphp
@php if(!isset($active_saveing)) { $active_saveing = ''; } @endphp
<li class="{{$active_dashboard}}"><a href="{{url('company/dashboard')}}"><img src="{{url('images/dash-iconh.png')}}" alt="" /><span>Dashboard</span></a></li>
<li class="{{$active_profile}}"><a href="{{url('company/dashboard/profile')}}"><img src="{{url('images/dash-iconh7.png')}}" alt="" /><span>Profile</span></a></li>
<li class="{{$active_venue}}"><a href="{{url('company/dashboard/venue/index')}}"><img src="{{url('images/dash-iconh8.png')}}" alt="" /><span>Venue</span></a></li>
{{--<li class="{{$active_payment}}"><a href="{{url('company/dashboard/payment')}}"><img src="{{url('images/dash-iconh2.png')}}" alt="" /><span>Payment</span></a></li>--}}
<li class="{{$active_booking}}"><a href="{{url('company/dashboard/bookings')}}"><img src="{{url('images/dash-iconh3.png')}}" alt="" /><span>Bookings</span></a></li>
{{--<li class="{{$active_review}}"><a href="#"><img src="{{url('images/dash-iconh4.png')}}" alt="" /><span>Reviews</span></a></li>--}}
{{--<li class="{{$active_saveing}}"><a href="#"><img src="{{url('images/dash-iconh.png')}}" alt="" /><span>Savings</span></a></li>--}}