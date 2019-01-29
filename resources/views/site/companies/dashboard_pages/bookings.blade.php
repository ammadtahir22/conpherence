@extends('site.layouts.app')

@section('head')
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>--}}
    {{--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>--}}
    {{--<script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}"></script>--}}
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
                    @include('site.companies.dashboard_nev',['active_booking' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active bookings-pane" id="bookings">
                    <div class="welcome-title full-col">
                        <h2>Bookings</h2>
                        <a href="{{url('company/dashboard/manual-booking')}}" class="get-btn"><span>Add Booking</span></a>
                    </div>
                    @include('site.layouts.session_messages')
                    <div class="booking-wrap">
                        <div class="tabs">
                            <div class="tab-button-outer">
                                <ul id="tab-button" class="booking-tab">
                                    <li><a href="#all-booked" aria-controls="all-booked" role="tab" data-toggle="tab">All Bookings</a></li>
                                    <li><a href="#today-booking" aria-controls="todays-booked" role="tab" data-toggle="tab">Today’s Bookings</a></li>
                                    <li><a href="#upcoming" aria-controls="upcoming -booked" role="tab" data-toggle="tab">Upcoming Bookings</a>
                                    <li><a href="#canbooked" aria-controls="canceled-booked" role="tab" data-toggle="tab">Cancelled Bookings</a></li>
                                </ul>
                                <div class="report-btn">
                                    <a href="#" data-toggle="modal" data-target="#reportpopup">Generate Report</a>
                                </div>
                            </div><!-- tab-button-outer -->
                            <div class="tab-content">
                                <div id="all-booked" class="search-result allbooked tab-pane active" role="tabpanel">
                                    <div class="full-col book-result">
                                        <div class="col-sm-6 book-result-info">
                                            {{--<p>Showing 15 results</p>--}}
                                        </div>
                                        <div class="col-sm-6 book-result-form">
                                            {{--<form action="#" method="post">--}}
                                            <div class="col-xs-4 form-group">
                                                <select id="all_orderby" class="selectpicker" onchange="get_search_data()">
                                                    <option>Sort by</option>
                                                    <option value="asc">Accending Order</option>
                                                    <option value="desc">Deccending Order</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-8 form-group">
                                                {{--<form id="searching" method="get">--}}
                                                @csrf
                                                <input id="all_search" type="text"  name="date" placeholder="Search" class="form-control" onkeyup="get_search_data()">
                                                {{--</form>--}}
                                            </div>
                                            {{--</form>--}}
                                        </div>
                                    </div>
                                    <div id="all-booking">
                                        @if(count($booking_infos) > 0)
                                            @foreach ($booking_infos as $current_booking)
                                                <div class="book-list hotal-book-list">
                                                    <div class="b-list-info col-sm-3">
                                                        <h4>{{$current_booking->space->venue->title}}</h4>
                                                        <h3>{{$current_booking->space->title}}</h3>
                                                        <h5><a href="#">{{$current_booking->space->venue->city}}</a></h5>
                                                    </div>
                                                    <div class="b-list-status col-sm-1">

                                                        <p><?php if($current_booking->user_id != 0){ ?> @if($current_booking->status == 0) Pending @elseif($current_booking->status == 1) Approved @else Cancelled @endif <?php } elseif($current_booking->user_id == 0 && $current_booking->status == 2){ echo "Cancelled"; } elseif($current_booking->user_id == 0){ echo "Manual Booking"; }  ?> <a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="{{url('images/info.png')}}" alt=""></a></p>
                                                    </div>
                                                    <div class="b-list-com b-list-date col-sm-3">
                                                        <p>@if($current_booking->user_id == 0)
                                                                {{$current_booking->booking_firstname .' '.$current_booking->booking_lastname}}
                                                            @else
                                                                {{$current_booking->user->name}}
                                                                <span>{{$current_booking->user->phone_number}}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="b-list-date col-sm-3">
                                                        <p>{{date('d M', strtotime($current_booking->start_date))}} to {{date('d M', strtotime($current_booking->end_date))}}<span>{{$current_booking->purpose}}</span></p>
                                                    </div>
                                                    <div class="b-list-price col-sm-1">
                                                        AED {{$current_booking->grand_total}}
                                                    </div>
                                                    <div class="b-list-btn col-sm-1">
                                                        @php if($current_booking->user_id == 0){
                                                        $url = url('/company/dashboard/manual-booking-detail/'.$current_booking->id);
                                                    }else{
                                                        $url = url('/company/dashboard/bookings-detail/'.$current_booking->id);
                                                    }
                                                        @endphp
                                                        <a href="{{$url}}" class="btn get-btn">
                                                            <span>View Detail </span><span></span><span></span><span></span><span></span>
                                                        </a>
                                                    </div>
                                                </div><!--booking list-->
                                            @endforeach
                                        @else
                                            <div class="pay-inner-card"><div class="dash-pay-gray"> No record found. </div></div>
                                        @endif
                                    </div>
                                    <div class="bookinginfos-pagination"> {{ $booking_infos->links() }} </div>
                                </div>
                                <div id="today-booking" class="search-result tab-pane prebooked" role="tabpanel">
                                    <div class="full-col book-result">
                                        <div class="col-sm-6 book-result-info">
                                            {{--<p>Showing 15 results</p>--}}
                                        </div>
                                        <div class="col-sm-6 book-result-form">
                                            {{--<form action="#" method="post">--}}
                                            <div class="col-xs-4 form-group">
                                                <select id="today_orderby" class="selectpicker" onchange="get_search_data()">
                                                    <option>Sort by</option>
                                                    <option value="asc">Accending Order</option>
                                                    <option value="desc">Deccending Order</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-8 form-group">
                                                {{--<form id="searching" method="get">--}}
                                                @csrf
                                                <input id="today_search" type="text"  name="date" placeholder="Search" class="form-control" onkeyup="get_search_data()">
                                                {{--</form>--}}
                                            </div>
                                            {{--</form>--}}
                                        </div>
                                    </div>
                                    <div id="today-booked">
                                        @if(count($todays_booking) > 0)
                                            @foreach ($todays_booking as $today_booking)
                                                <div class="book-list hotal-book-list">
                                                    <div class="b-list-info col-sm-3">
                                                        <h4>{{$today_booking->space->venue->title}}</h4>
                                                        <h3>{{$today_booking->space->title}}</h3>
                                                        <h5><a href="#">{{$today_booking->space->venue->city}}</a></h5>
                                                    </div>
                                                    <div class="b-list-status col-sm-1">

                                                        <p><?php if($today_booking->user_id != 0){ ?> @if($today_booking->status == 0) Pending @elseif($today_booking->status == 1) Approved @else Cancelled @endif <?php } else{ echo "Manual Booking"; } ?> <a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="{{url('images/info.png')}}" alt=""></a></p>
                                                    </div>
                                                    <div class="b-list-com b-list-date col-sm-3">
                                                        <p>@if($today_booking->user_id == 0)
                                                                {{$today_booking->booking_firstname .' '.$today_booking->booking_lastname}}
                                                            @else
                                                                {{$today_booking->user->name}}
                                                                <span>{{$today_booking->user->phone_number}}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="b-list-date col-sm-3">
                                                        <p>{{date('d M', strtotime($today_booking->start_date))}}  to {{date('d M', strtotime($today_booking->end_date))}} <span>{{$today_booking->purpose}}</span></p>
                                                    </div>
                                                    <div class="b-list-price col-sm-1">
                                                        AED {{$today_booking->grand_total}}
                                                    </div>
                                                    <div class="b-list-btn col-sm-1">
                                                        @php if($today_booking->user_id == 0){
                                                        $url = url('/company/dashboard/manual-booking-detail/'.$today_booking->id);
                                                    }else{
                                                        $url = url('/company/dashboard/bookings-detail/'.$today_booking->id);
                                                    }
                                                        @endphp
                                                        <a href="{{$url}}" class="btn get-btn">
                                                            <span>View Detail </span><span></span><span></span><span></span><span></span>
                                                        </a>
                                                    </div>
                                                </div><!--booking list-->
                                            @endforeach
                                        @else
                                            <div class="pay-inner-card"><div class="dash-pay-gray"> No record found. </div></div>
                                        @endif
                                    </div>
                                    <div class="todays-pagination"> {{ $todays_booking->links() }}</div>
                                </div>
                                <div id="upcoming" class="search-result tab-pane prebooked" role="tabpanel">
                                    <div class="full-col book-result">
                                        <div class="col-sm-6 book-result-info">
                                            {{--<p>Showing 15 results</p>--}}
                                        </div>
                                        <div class="col-sm-6 book-result-form">
                                            {{--<form action="#" method="post">--}}
                                            <div class="col-xs-4 form-group">
                                                <select id="upcomming_orderby" class="selectpicker" onchange="get_search_data()">
                                                    <option>Sort by</option>
                                                    <option value="asc">Accending Order</option>
                                                    <option value="desc">Deccending Order</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-8 form-group">
                                                {{--<form id="searching" method="get">--}}
                                                @csrf
                                                <input id="upcomming_search" type="text"  name="date" placeholder="Search" class="form-control" onkeyup="get_search_data()">
                                                {{--</form>--}}
                                            </div>
                                            {{--</form>--}}
                                        </div>
                                    </div>
                                    <div id="upcomming-booking">
                                        @if(count($upcomings_booking) > 0)
                                            @foreach ($upcomings_booking as $upcoming_booking)
                                                <div class="book-list hotal-book-list">
                                                    <div class="b-list-info col-sm-3">
                                                        <h4>{{$upcoming_booking->space->venue->title}}</h4>
                                                        <h3>{{$upcoming_booking->space->title}}</h3>
                                                        <h5><a href="#">{{$upcoming_booking->space->venue->city}}</a></h5>
                                                    </div>
                                                    <div class="b-list-status col-sm-1">
                                                        <p><?php if($upcoming_booking->user_id != 0){ ?> @if($upcoming_booking->status == 0) Pending @elseif($upcoming_booking->status == 1) Approved @else Cancelled @endif <?php } else{ echo "Manual Booking"; } ?> <a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="{{url('images/info.png')}}" alt=""></a></p>
                                                    </div>
                                                    <div class="b-list-com b-list-date col-sm-3">
                                                        <p>@if($upcoming_booking->user_id == 0)
                                                                {{$upcoming_booking->booking_firstname .' '.$upcoming_booking->booking_lastname}}
                                                            @else
                                                                {{$upcoming_booking->user->name}}
                                                                <span>{{$upcoming_booking->user->phone_number}}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="b-list-date col-sm-3">
                                                        <p>{{date('d M', strtotime($upcoming_booking->start_date))}} to {{date('d M', strtotime($upcoming_booking->end_date))}}<span>{{$upcoming_booking->purpose}}</span></p>
                                                    </div>
                                                    <div class="b-list-price col-sm-1">
                                                        AED {{$upcoming_booking->grand_total}}
                                                    </div>
                                                    <div class="b-list-btn col-sm-1">
                                                        @php if($upcoming_booking->user_id == 0){
                                                        $url = url('/company/dashboard/manual-booking-detail/'.$upcoming_booking->id);
                                                    }else{
                                                        $url = url('/company/dashboard/bookings-detail/'.$upcoming_booking->id);
                                                    }
                                                        @endphp
                                                        <a href="{{$url}}" class="btn get-btn">
                                                            <span>View Detail </span><span></span><span></span><span></span><span></span>
                                                        </a>
                                                    </div>
                                                </div><!--booking list-->
                                            @endforeach
                                        @else
                                            <div class="pay-inner-card"><div class="dash-pay-gray"> No record found. </div></div>
                                        @endif
                                    </div>
                                    <div class="upcomings-pagination"> {{ $upcomings_booking->links() }}</div>
                                </div>
                                <div id="canbooked" class="search-result tab-pane canbooked" role="tabpanel">
                                    <div class="full-col book-result">
                                        <div class="col-sm-6 book-result-info">
                                            {{--<p>Showing 15 results</p>--}}
                                        </div>
                                        <div class="col-sm-6 book-result-form">
                                            {{--<form action="#" method="post">--}}
                                            <div class="col-xs-4 form-group">
                                                <select id="cancel_orderby" class="selectpicker" onchange="get_search_data()">
                                                    <option>Sort by</option>
                                                    <option value="asc">Accending Order</option>
                                                    <option value="desc">Deccending Order</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-8 form-group">
                                                {{--<form id="searching" method="get">--}}
                                                @csrf
                                                <input id="cancel_search" type="text"  name="date" placeholder="Search" class="form-control" onkeyup="get_search_data()">
                                                {{--</form>--}}
                                            </div>
                                            {{--</form>--}}
                                        </div>
                                    </div>
                                    <div id="cancel-booking">
                                        @if(count($cancel_bookings) > 0)
                                            @foreach ($cancel_bookings as $cancel_booking)
                                                <div class="book-list hotal-book-list">
                                                    <div class="b-list-info col-sm-3">
                                                        <h4>{{$cancel_booking->space->venue->title}}</h4>
                                                        <h3>{{$cancel_booking->space->title}}</h3>
                                                        <h5><a href="#">{{$cancel_booking->space->venue->city}}</a></h5>
                                                    </div>
                                                    <div class="b-list-status col-sm-1">

                                                        <p><?php if($cancel_booking->user_id != 0){ ?> @if($cancel_booking->status == 0) Pending @elseif($cancel_booking->status == 1) Approved @else Cancelled @endif <?php } elseif($cancel_booking->user_id == 0 && $cancel_booking->status == 2){ echo "Cancelled"; } elseif($cancel_booking->user_id == 0){ echo "Manual Booking"; }  ?><a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="{{url('images/info.png')}}" alt=""></a></p>
                                                    </div>
                                                    <div class="b-list-com b-list-date col-sm-3">
                                                        <p>@if($cancel_booking->user_id == 0)
                                                                {{$cancel_booking->booking_firstname .' '.$cancel_booking->booking_lastname}}
                                                            @else
                                                                {{$cancel_booking->user->name}}
                                                                <span>{{$cancel_booking->user->phone_number}}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="b-list-date col-sm-3">
                                                        <p>{{date('d M', strtotime($cancel_booking->start_date))}} to {{date('d M', strtotime($cancel_booking->end_date))}}<span>{{$cancel_booking->purpose}}</span></p>
                                                    </div>
                                                    <div class="b-list-price col-sm-1">
                                                        AED {{$cancel_booking->grand_total}}
                                                    </div>
                                                    <div class="b-list-btn col-sm-1">
                                                        @php if($cancel_booking->user_id == 0){
                                                        $url = url('/company/dashboard/manual-booking-detail/'.$cancel_booking->id);
                                                    }else{
                                                        $url = url('/company/dashboard/bookings-detail/'.$cancel_booking->id);
                                                    }
                                                        @endphp
                                                        <a href="{{$url}}" class="btn get-btn">
                                                            <span>View Detail </span><span></span><span></span><span></span><span></span>
                                                        </a>
                                                    </div>
                                                </div><!--booking list-->
                                            @endforeach
                                        @else
                                            <div class="pay-inner-card"><div class="dash-pay-gray"> No Record found. </div></div>
                                        @endif
                                    </div>
                                    <div class="cancel-pagination"> {{ $cancel_bookings->links() }}</div>

                                </div>
                            </div><!--wrapper-->
                        </div>
                    </div>
                </div>
                <!-- /tabs -->
                <div class="clearfix"></div>
            </div>
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
                    <form method="post" action="{{url('/company/dashboard/report')}}" target="_blank" id="report">
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
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}
@section('scripts')
    @include('site.layouts.scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>--}}


    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        // $('.datepicker').datepicker({
        //    // format: 'mm/dd/yyyy',
        //     format: 'yyyy/mm/dd',
        //     orientation: 'left bottom',
        //     autoclose: true,
        //     startDate: 'date',
        //     todayHighlight: true
        // });
        new Pikaday({
            field: document.getElementById('report_start_date'),
        });
        new Pikaday({
            field: document.getElementById('report_end_date'),
        });
    </script>
    <script type="text/javascript">
        function get_search_data(){
            if($('#all-booked').hasClass( "active" )){
                $Activetab = 1;
                var search_order = $('#all_orderby').val();
                var search = $('#all_search').val();

            }else if($('#today-booking').hasClass( "active" )){
                $Activetab = 2;
                var search_order = $('#today_orderby').val();
                var search = $('#today_search').val();
            }
            else if($('#upcoming').hasClass( "active" )){
                $Activetab = 3;
                var search_order = $('#upcomming_orderby').val();
                var search = $('#upcomming_search').val();
            }
            else if($('#canbooked').hasClass( "active" )){
                $Activetab = 4;
                var search_order = $('#cancel_orderby').val();
                var search = $('#cancel_search').val();
            }
            $.ajax({
                type : "GET",
                url : "{{ route('company.dashboard.booking-search') }}",
                data:{'search':search,'activetab':$Activetab,'search_order': search_order},
                success:function(data){
                    if($('#all-booked').hasClass( "active" )){
                        $('#all-booking').html("");
                        $('#all-booking').html(data.output);
                        $('.bookinginfos-pagination').html("");
                        $('.bookinginfos-pagination').html(data.page);
                    }else if($('#today-booking').hasClass( "active" )){
                        $('#today-booked').html("");
                        $('#today-booked').html(data.output);
                        $('.today-pagination').html("");
                        $('.today-pagination').html(data.page);
                    }
                    else if($('#upcoming').hasClass( "active" )){
                        $('#upcomming-booking').html("");
                        $('#upcomming-booking').html(data.output);
                        $('.upcomming-pagination').html("");
                        $('.upcomming-pagination').html(data.page);
                    }
                    else if($('#canbooked').hasClass( "active" )){
                        $('#cancel-booking').html("");
                        $('#cancel-booking').html(data.output);
                        $('.cancel-pagination').html("");
                        $('.cancel-pagination').html(data.page);
                    }
                }
            });
        }
    </script>
    {{--<script type="text/javascript">--}}

    {{--$('#orderby').change('keyup',function(){--}}
    {{--$value=$(this).val();--}}
    {{--$Activetab = $('.search-result.active').attr('id');--}}
    {{--//alert($Activetab);--}}
    {{--//exit();--}}
    {{--$.ajax({--}}
    {{--type : "GET",--}}
    {{--url : "{{ route('company.dashboard.booking-sort') }}",--}}
    {{--data:{'sort':$value,'activetab':$Activetab},--}}
    {{--success:function(data){--}}
    {{--console.log(data);--}}
    {{--// exit();--}}
    {{--$('.search-result').html(data);--}}
    {{--}--}}
    {{--});--}}
    {{--})--}}
    {{--</script>--}}

@endsection