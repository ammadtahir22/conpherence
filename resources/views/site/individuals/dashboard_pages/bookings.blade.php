@extends('site.layouts.app')

@section('head')
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />--}}
    {{--<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>--}}
@endsection

@section('header-class', 'dashboard-header')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="dashboard">
        <div class="tabbable tabs-left">
            <aside class="dashboard-sidebar">
                <ul class="nav nav-tabs ">
                    @include('site.individuals.dashboard_nev',['active_booking' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active bookings-pane" id="bookings">
                    <div class="welcome-title full-col">
                        <h2>Bookings</h2>
                    </div>
                    <div class="booking-wrap">
                        <div class="tabs">
                            <div class="tab-button-outer">
                                <ul id="tab-button" class="booking-tab">
                                    <li class="mybooking"><a href="#booked">My Bookings</a></li>
                                    <li class="previous_booking"><a href="#prebooked">Previous Bookings</a></li>
                                    <li class="calcelled_booking"><a href="#canbooked">Cancelled Bookings</a></li>
                                    {{--<li class="report-btn"><a href="#">Generate Report</a></li>--}}
                                </ul>
                                <div class="report-btn">
                                    <a href="#" data-toggle="modal" data-target="#reportpopup">Generate Report</a>
                                </div>
                            </div>
                            @php // dump($booked_spaces->bookingInfo()); @endphp
                            <div id="booked" class="search-result tab-contents">
                                <div class="full-col book-result">
                                    <div class="col-sm-6 book-result-info">
                                    </div>
                                    <div class="col-sm-6 book-result-form">
                                        {{--<form action="#" method="post">--}}
                                        <div class="col-xs-4 form-group">
                                            <select id="booked_orderby" class="selectpicker" onchange="BookingSearchFilter()">
                                                <option>Sort by</option>
                                                <option value="asc">Accending Order</option>
                                                <option value="desc">Deccending Order</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8 form-group">
                                            {{--<form id="searching" method="get">--}}
                                            @csrf
                                            <input id="booked_search" type="text"  name="booked_search" placeholder="Search" class="form-control" onkeyup="BookingSearchFilter()">
                                            {{--</form>--}}
                                        </div>
                                        {{--</form>--}}
                                    </div>
                                </div>
                                <div class="col-sm-6 book-result-info all_booking_count">
                                    Showing <label id="all_booking_count">{{$booking_infos->count()}}</label> Results
                                </div>
                                <div id="all_booking_area">
                                    @if(count($booking_infos) > 0)
                                        @foreach ($booking_infos as $current_booking)
                                            <div class="book-list">
                                                <div class="b-list-img col-sm-2">
                                                    <img src="{{url('storage/images/spaces/'.$current_booking->space->image)}}" alt="" />
                                                </div>
                                                <div class="b-list-info col-sm-3">
                                                    <h4>{{$current_booking->space->venue->title}}</h4>
                                                    <h3>{{$current_booking->space->title}}</h3>
                                                    <h5><a href="#">{{$current_booking->space->venue->city}}</a></h5>
                                                </div>
                                                <div class="b-list-status col-sm-1">
                                                    <p>@if($current_booking->status == 0) Pending @elseif($current_booking->status == 1) Approved @else Cancelled @endif<a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="{{url('images/info.png')}}" alt=""></a></p>
                                                </div>
                                                <div class="b-list-date col-sm-2">
                                                    <p>{{date('d-M', strtotime($current_booking->start_date))}}  to  {{date('d-M', strtotime($current_booking->end_date))}}</p>
                                                </div>
                                                <div class="b-list-rate col-sm-1">
                                                    @php
                                                        $json = json_decode($current_booking->space->reviews_count);
                                                        $total_average_percentage = ($json[4]/5) * 100;
                                                    @endphp
                                                    {{$json[4]}}
                                                    @php echo get_stars_view($json[4]); @endphp
                                                </div>
                                                <div class="b-list-price col-sm-1">
                                                    AED {{$current_booking->grand_total}}
                                                </div>
                                                <div class="b-list-btn col-sm-2">
                                                    <a href="{{url('/user/dashboard/bookings-detail/'.$current_booking->id)}}" class="btn get-btn">
                                                        <span>View Detail </span><span></span><span></span><span></span><span></span>
                                                    </a>
                                                </div>
                                            </div><!--booking list-->
                                        @endforeach

                                    @else
                                        <div class="pay-inner-card"><div class="dash-pay-gray">No record found.</div></div>
                                    @endif

                                </div>
                            </div>
                            <div id="prebooked" class="search-result tab-contents prebooked">
                                <div class="full-col book-result">
                                    <div class="col-sm-6 book-result-info">

                                    </div>
                                    <div class="col-sm-6 book-result-form">
                                        {{--<form action="#" method="post">--}}
                                        <div class="col-xs-4 form-group">
                                            <select id="previous_orderby" name="previous_orderby" class="selectpicker" onchange="BookingSearchFilter()">
                                                <option>Sort by</option>
                                                <option value="asc">Accending Order</option>
                                                <option value="desc">Deccending Order</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8 form-group">
                                            {{--<form id="searching" method="get">--}}
                                            @csrf
                                            <input id="previous_search" type="text"  name="previous_search" placeholder="Search" class="form-control" onkeyup="BookingSearchFilter()">
                                            {{--</form>--}}
                                        </div>
                                        {{--</form>--}}
                                    </div>
                                </div>
                                <div class="col-sm-6 book-result-info">
                                    Showing <label id="previous_booking_counter">{{$previous_booking->count()}}</label> results
                                </div>
                                <div id="previous_booking_area">
                                    @if(count($previous_booking) > 0)
                                        @foreach ($previous_booking as $previous_bookings)
                                            <div class="book-list">
                                                <div class="b-list-img col-sm-2">
                                                    <img src="{{url('storage/images/spaces/'.$previous_bookings->space->image)}}" alt="" />
                                                </div>
                                                <div class="b-list-info col-sm-3">
                                                    <h4>{{$previous_bookings->space->venue->title}}</h4>
                                                    <h3>{{$previous_bookings->space->title}}</h3>
                                                    <h5><a href="#">{{$previous_bookings->space->venue->city}}</a></h5>
                                                </div>
                                                <div class="b-list-status col-sm-1">
                                                    <p>@if($previous_bookings->status == 0) Pending @elseif($previous_bookings->status == 1) Approved @else Cancelled @endif<a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="{{url('images/info.png')}}" alt=""></a></p>
                                                </div>
                                                <div class="b-list-date col-sm-2">
                                                    <p>{{date('d-M', strtotime($previous_bookings->start_date))}}  to  {{date('d-M', strtotime($previous_bookings->end_date))}}</p>
                                                </div>
                                                <div class="b-list-rate col-sm-1">
                                                    @php
                                                        $json = json_decode($previous_bookings->space->reviews_count);
                                                        $total_average_percentage = ($json[4]/5) * 100;
                                                    @endphp
                                                    {{$json[4]}}
                                                    @php echo get_stars_view($json[4]); @endphp
                                                </div>
                                                <div class="b-list-price col-sm-1">
                                                    AED {{$previous_bookings->grand_total}}
                                                </div>
                                                <div class="b-list-btn col-sm-2">
                                                    <a href="{{url('/user/dashboard/bookings-detail/'.$current_booking->id)}}" class="btn get-btn">
                                                        <span>View Detail </span><span></span><span></span><span></span><span></span>
                                                    </a>
                                                </div>
                                            </div><!--booking list-->
                                        @endforeach
                                    @else
                                        <div class="pay-inner-card"><div class="dash-pay-gray">No record found.</div></div>
                                    @endif

                                </div>
                            </div><!--prebooked-->
                            <div id="canbooked" class="search-result tab-contents canbooked">
                                <div class="full-col book-result">
                                    <div class="col-sm-6 book-result-info">
                                    </div>
                                    <div class="col-sm-6 book-result-form">
                                        {{--<form action="#" method="post">--}}
                                        <div class="col-xs-4 form-group">
                                            <select id="cancelled_orderby" class="selectpicker" onchange="BookingSearchFilter()">
                                                <option>Sort by</option>
                                                <option value="asc">Accending Order</option>
                                                <option value="desc">Deccending Order</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8 form-group">
                                            {{--<form id="searching" method="get">--}}
                                            @csrf
                                            <input id="cancelled_search" type="text"  name="cancelled_search" placeholder="Search" class="form-control" onkeyup="BookingSearchFilter()">
                                            {{--</form>--}}
                                        </div>
                                        {{--</form>--}}
                                    </div>
                                </div>
                                <div class="col-sm-6 book-result-info">
                                    Showing <label id="cancelled_booking_count">{{$cancel_bookings->count()}}</label> Results
                                </div>
                                <div id="cancelled_booking_area">
                                    @if(count($cancel_bookings) > 0)
                                        @foreach ($cancel_bookings as $cancel_booking)
                                            <div class="book-list">
                                                <div class="b-list-img col-sm-2">
                                                    <img src="{{url('storage/images/spaces/'.$cancel_booking->space->image)}}" alt="" />
                                                </div>
                                                <div class="b-list-info col-sm-3">
                                                    <h4>{{$cancel_booking->space->venue->title}}</h4>
                                                    <h3>{{$cancel_booking->space->title}}</h3>
                                                    <h5><a href="#">{{$cancel_booking->space->venue->city}}</a></h5>
                                                </div>
                                                <div class="b-list-status col-sm-1">
                                                    <p>@if($cancel_booking->status == 0) Pending @elseif($cancel_booking->status == 1) Approved @else Cancelled @endif<a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="{{url('images/info.png')}}" alt=""></a></p>
                                                </div>
                                                <div class="b-list-date col-sm-2">
                                                    <p>{{date('d-M', strtotime($cancel_booking->start_date))}}  to  {{date('d-M', strtotime($cancel_booking->end_date))}}</p>
                                                </div>
                                                <div class="b-list-rate col-sm-1">
                                                    @php
                                                        $json = json_decode($cancel_booking->space->reviews_count);
                                                        $total_average_percentage = ($json[4]/5) * 100;
                                                    @endphp
                                                    {{$json[4]}}
                                                    @php echo get_stars_view($json[4]); @endphp
                                                </div>
                                                <div class="b-list-price col-sm-1">
                                                    AED {{$cancel_booking->grand_total}}
                                                </div>
                                                <div class="b-list-btn col-sm-2">
                                                    <a href="{{url('/user/dashboard/bookings-detail/'.$cancel_booking->id)}}" class="btn get-btn">
                                                        <span>View Detail </span><span></span><span></span><span></span><span></span>
                                                    </a>
                                                </div>
                                            </div><!--booking list-->
                                        @endforeach

                                    @else
                                        <div class="pay-inner-card"><div class="dash-pay-gray">No record found.</div></div>
                                    @endif

                                </div>
                            </div>
                            {{--<ul class="pagination pagination-large ">--}}
                            {{--<li class="active"><span>1</span></li>--}}
                            {{--<li><a href="#">2</a></li>--}}
                            {{--<li><a href="#">3</a></li>--}}
                            {{--<li><a href="#">4</a></li>--}}
                            {{--<li><a href="#">6</a></li>--}}
                            {{--<li><a href="#">7</a></li>--}}
                            {{--<li><a href="#">8</a></li>--}}
                            {{--<li><a href="#">9</a></li>--}}
                            {{--</ul>--}}
                        </div><!--wrapper-->
                    </div>
                </div>
                <!-- /tabs -->
                <div class="clearfix"></div>
            </div>
    </section>

    <!-- generate repost popup -->
    <div class="modal fade card-popup" id="reportpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3>Generate Report</h3>
                    <form method="post" action="{{url('/user/dashboard/report')}}" target="_blank" id="report">
                        @csrf
                        <div class="form-group full-field">
                            <select name="status">
                                <option value="">All</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                                <option value="2">Cancelled</option>
                            </select>
                        </div><!--form-group-->
                        <div class="form-group full-field">
                            <select name="location">
                                <option value="">All</option>
                                @foreach ($venue_location as $venue_locations)
                                    <option value="{{$venue_locations->city}}">{{$venue_locations->city}}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->
                        <div class="form-group half-l-field">
                            <legend>Start Date*</legend>
                            <input type="text" name="start_date" class="form-control" id="report_start_date" placeholder="Start Date" required>
                        </div><!--form-group-->
                        <div class="form-group half-r-field">
                            <legend for="date">End Date*</legend>
                            <input type="text" name="end_date" class="form-control" id="report_end_date" placeholder="End Date" required>
                        </div><!--form-group-->
                        <div class="form-group form-btn half-l-field">
                            <button type="submit" class="btn ani-btn">Generate Report</button>
                        </div>
                        <div class="form-group form-btn half-r-field">
                            <button type="button" class="btn ani-btn cancle-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
@section('scripts')
    @include('site.layouts.scripts')
    <script type="text/javascript">

        new Pikaday({
            field: document.getElementById('report_start_date'),
        });
        new Pikaday({
            field: document.getElementById('report_end_date'),
        });
    </script>
    <script type="text/javascript">
        function BookingSearchFilter(){
            if($('.mybooking').hasClass( "is-active" )){
                var activetab = 0;
                var search_order = $('#booked_orderby').val();
                var search = $('#booked_search').val();
            }else if($('.previous_booking').hasClass("is-active")){
                var activetab = 1;
                var search_order = $('#previous_orderby').val();
                var search = $('#previous_search').val();
            }else{
                var activetab = 2;
                var search_order = $('#cancelled_orderby').val();
                var search = $('#cancelled_search').val();
            }
            $.ajax({
                type : "GET",
                url : "{{ route('user.dashboard.booking-search') }}",
                data:{'search':search, 'search_order':search_order, 'activetab':activetab},
                success:function(data){
                    if($('.mybooking').hasClass( "is-active" )){
                        $('#all_booking_count').html(data.counter);
                        $('#all_booking_area').html("");
                        $('#all_booking_area').html(data.html);
                    }else if($('.previous_booking').hasClass("is-active")){
                        console.log('Previous Tab '+ data.counter);
                        $('#previous_booking_counter').html(data.counter);
                        $('#previous_booking_area').html("");
                        $('#previous_booking_area').html(data.html);
                    }else{
                        $('#cancelled_booking_count').html(data.counter);
                        $('#cancelled_booking_area').html("");
                        $('#cancelled_booking_area').html(data.html);
                    }
                }
            });
        }
        $('#search').on('keyup',function(){
            $value=$(this).val();
            //alert($value);
            $.ajax({
                type : "GET",
                url : "{{ route('user.dashboard.booking-search') }}",
                data:{'search':$value},
                success:function(data){
                    console.log(data);
                    // exit();
                    $('.search-result').html(data);
                }
            });
        });
    </script>
    <script type="text/javascript">

        $('#orderby').change('keyup',function(){
            $value=$(this).val();
            $Activetab = $('.search-result').attr('id');
            //alert($Activetab);
            //exit();
            $.ajax({
                type : "GET",
                url : "{{ route('user.dashboard.booking-sort') }}",
                data:{'sort':$value,'activetab':$Activetab},
                success:function(data){
                    console.log(data);
                    // exit();
                    $('.search-result').html(data);
                }
            });
        })
    </script>
@endsection
