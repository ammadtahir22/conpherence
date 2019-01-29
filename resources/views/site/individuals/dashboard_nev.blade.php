@php if(!isset($active_dashboard)) { $active_dashboard = ''; } @endphp
@php if(!isset($active_profile)) { $active_profile = ''; } @endphp
@php if(!isset($active_payment)) { $active_payment = ''; } @endphp
@php if(!isset($active_booking)) { $active_booking = ''; } @endphp
@php if(!isset($active_review)) { $active_review = ''; } @endphp
@php if(!isset($active_wishlist)) { $active_wishlist = ''; } @endphp
@php if(!isset($active_saving)) { $active_saving = ''; } @endphp
<li class="{{$active_dashboard}}"><a href="{{url('user/dashboard')}}"><img src="{{url('images/dash-iconh.png')}}" alt="" /><span>Dashboard</span></a></li>
<li class="{{$active_profile}}"><a href="{{url('user/dashboard/profile')}}"><img src="{{url('images/dash-iconh7.png')}}" alt="" /><span>Profile</span></a></li>
{{--<li class="{{$active_payment}}"><a href="{{url('user/dashboard/payment')}}"><img src="{{url('images/dash-iconh2.png')}}" alt="" /><span>Payment</span></a></li>--}}
<li class="{{$active_booking}}"><a href="{{url('user/dashboard/bookings')}}"><img src="{{url('images/dash-iconh3.png')}}" alt="" /><span>Bookings</span></a></li>
<li class="{{$active_review}}"><a href="{{url('user/dashboard/reviews')}}"><img src="{{url('images/dash-iconh4.png')}}" alt="" /><span>Reviews</span></a></li>
<li class="{{$active_wishlist}}"><a href="{{url('user/dashboard/wishlists')}}"><img src="{{url('images/wish.png')}}" alt="" /><span>WishList</span></a></li>
<li class="{{$active_saving}}"><a href="{{url('user/dashboard/saving')}}"><img src="{{url('images/dash-iconh6.png')}}" alt="" /><span>Savings</span></a></li>