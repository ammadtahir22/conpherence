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
                    @include('site.individuals.dashboard_nev',['active_review' => "active"])
                </ul>
            </aside>
        </div>
        <div class="tab-content dashboard-wrap">
            <div class="welcome-title full-col">
                <h2>Reviews</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php if(session('msg-success')): ?>
                    <p class="alert alert-success" role="alert">
                        <?php echo e(session('msg-success')); ?>

                    </p>
                    <?php endif; ?>

                    <?php if(session('msg-error')): ?>
                    <p class="alert alert-success" role="alert">
                        <?php echo e(session('msg-error')); ?>

                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="booking-wrap">
                <div class="tabs">
                    <div class="tab-button-outer">
                        <ul id="tab-button" class="booking-tab">
                            <li class="active reviewed_data_tab"><a href="#approved"  aria-controls="all-booked" role="tab" data-toggle="tab">Reviewed</a></li>
                            <li class="pending_data_tab"><a href="#pending" aria-controls="todays-booked" role="tab" data-toggle="tab">Pending</a></li>
                        </ul>
                    </div><!-- tab-button-outer -->
                    <div class="tab-content">
                        <div id="approved" class="tab-pane active" role="tabpanel">
                            <div class="full-col book-result a_lable">
                                <div class="col-sm-6 book-result-info">
                                    <p>Showing <label id="a_label">{{ count($reviewed_booking) }}</label> results</p>
                                </div>
                                <div class="col-sm-6 book-result-form">
                                    {{--<form action="#" method="post" id="r_fapproved">--}}
                                        <div class="col-xs-4 form-group">
                                            <select id="reviewed_orderby" class="selectpicker" name="reviewed_order" onchange="get_review_search()">
                                                <option>Sort by</option>
                                                <option value="asc">Accending Order</option>
                                                <option value="desc">Deccending Order</option>
                                            </select>
                                        </div>
                                    {{--</form>--}}
                                    <div class="col-xs-8 form-group">
                                        {{--<form id="searching" method="get">--}}
                                            @csrf
                                            <input id="reviewed_search" type="text" name="reviewed_search" placeholder="Search" class="form-control search_review_data" onkeyup="get_review_search()">
                                        {{--</form>--}}
                                    </div>

                                </div>
                            </div>
                            <div class="search-result" id="review_data">
                                @php
                                    $total_p_booking = 0;
                                    $total_a_booking = 0;
                                @endphp
                                @if(count($reviewed_booking) > 0)
                                    @foreach($reviewed_booking as $book)
                                        @php
                                            $booking_id = $book->id;
                                            $booking_space = $book->space;
                                            $booking_space_venue = $booking_space->venue;
                                        @endphp
                                        @if($book->review_status == '1')
                                            @php $total_a_booking++; @endphp
                                            <div class="book-list review-list">
                                                <div class="b-list-info col-sm-5">
                                                    <h4>{{$booking_space_venue->title}}</h4>
                                                    <h3>{{$booking_space->title}}</h3>
                                                    <h5><a href="#">{{$booking_space_venue->city}}</a><span>Reviewed on {{$book->review ? date('Y-M-d' , strtotime($book->review->created_at)) : ''}}</span></h5>
                                                </div>
                                                <div class="b-list-date col-sm-3">
                                                    <p>{{date('d-M' , strtotime($book->created_at))}}<span>{{$book->purpose}}</span></p>
                                                </div>
                                                <div class="b-list-rate col-sm-3">
                                                    @php
                                                        $review = $book->review->total_stars;
                                                        $review = number_format((float)$review / 4 , 1, '.', '');
                                                       $json = json_decode($booking_space->reviews_count);
                                                    @endphp
                                                    {{$review}}
                                                    {{--                                            @php echo get_stars_view($json[4]); @endphp--}}
                                                    @php echo get_stars_view($review); @endphp
                                                </div>
                                                <div class="b-list-btn col-sm-1">
                                                    <a href="{{url('user/add_review/'.$booking_id)}}" class="btn get-btn">
                                                        <span>View Review </span><span></span><span></span><span></span><span></span>
                                                    </a>
                                                </div>
                                            </div><!--booking list-->
                                        @endif
                                    @endforeach
                                @else
                                    <div id="r_approved" style="display:none;" class="pay-inner-card"><div class="dash-pay-gray"> Record Not Found.</div></div>
                                @endif
                            </div>
                        </div>
                        <div id="pending" class="tab-pane pending" role="tabpanel">
                            <div class="full-col book-result  p_lable">
                                <div class="col-sm-6 book-result-info">
                                    <p>Showing <label id="p_label">{{ count($pending_booking) }}</label> results</p>
                                </div>
                                <div class="col-sm-6 book-result-form" id="r_fpending">
                                    {{--<form action="#" method="post">--}}
                                        <div class="col-xs-4 form-group">
                                            <select id="pending_orderby" class="selectpicker" name="pending_order" onchange="get_review_search()">
                                                <option>Sort by</option>
                                                <option value="asc">Accending Order</option>
                                                <option value="desc">Deccending Order</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8 form-group">
                                            {{--<form id="searching" method="get">--}}
                                                @csrf
                                                <input id="pending_search" type="text"  name="pending_search" placeholder="Search" class="form-control search_review_data" onkeyup="get_review_search()">
                                            {{--</form>--}}
                                        </div>
                                    {{--</form>--}}
                                </div>
                            </div>
                            <div id="pending_data">
                                @if(count($pending_booking) > 0)
                                    @foreach($pending_booking as $book)
                                        @php
                                            $booking_id = $book->id;
                                            $booking_space = $book->space;
                                            $booking_space_venue = $booking_space->venue;
                                        @endphp
                                        @if($book->review_status != '1')
                                            @php $total_p_booking++; @endphp
                                            <div class="book-list review-list search-result std_pnd_search_res">
                                                <div class="b-list-info col-sm-5">
                                                    <h4>{{$booking_space_venue->title}}</h4>
                                                    <h3>{{$booking_space->title}}</h3>
                                                    <h5><a href="#">{{$booking_space_venue->city}}</a> @if($book->review) <span>Reviewed on </span> @endif {{$book->review ? '' . date('Y-M-d' , strtotime($book->review->created_at)) : ''}}</h5>
                                                </div>
                                                <div class="b-list-date col-sm-3">
                                                    <p>{{date('d-M' , strtotime($book->created_at))}}<span>{{$book->purpose}}</span></p>
                                                </div>
                                                <div class="b-list-rate col-sm-3">
                                                    @if($book->review)
                                                        @if($book->review->r_status == "0") <p class="b-list-status">Pending for approval<a href="#" data-toggle="tooltip" data-placement="top" title="Status" class="stus-info"><img src="images/info.png" alt=""></a></p>
                                                        @else
                                                            @php
                                                                $json = json_decode($booking_space->reviews_count);
                                                                $total_average_percentage = ($json[4]/5) * 100;
                                                            @endphp
                                                            {{$json[4]}}
                                                            @php echo get_stars_view($json[4]); @endphp
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="b-list-btn col-sm-1">
                                                    <a href="{{url('user/add_review/'.$booking_id)}}" class="btn get-btn">
                                                        @if($book->review)
                                                            @if($book->review->r_status == "0") <span>Edit Review </span>
                                                            @endif
                                                        @else <span>Add Review </span>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div id="r_pending" style="display:none;" class="pay-inner-card"><div class="dash-pay-gray"> Record Not Found.</div></div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="total_p_booking" value="{{$total_p_booking}}">
                    <input type="hidden" id="total_a_booking" value="{{$total_a_booking}}">
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

    </section>


@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}
@section('scripts')
    @include('site.layouts.scripts')
    <script type="text/javascript">
        function get_review_search(){
            if($('.reviewed_data_tab').hasClass( "active" )){
                $activetab = 1;
                var search_order = $('#reviewed_orderby').val();
                var search = $('#reviewed_search').val();
            }else{
                $activetab = 0;
                var search_order = $('#pending_orderby').val();
                var search = $('#pending_search').val();
            }
            console.log(search_order);
            console.log(search);
            $.ajax({
                type : "GET",
                url : "{{ route('user.dashboard.review-search') }}",
                data:{'search':search,'activetab':$activetab, 'search_order': search_order},
                success:function(data){
                    if($('.reviewed_data_tab').hasClass( "active" )){
                        $('#review_data').html("");
                        $('#review_data').html(data.html);
                        $('#a_label').html(data.counter);
                    }else{
                        $('#p_label').html(data.counter);
                        $('#pending_data').html("");
                        $('#pending_data').html(data.html);
                    }
                }
            });
        }

        {{--$('.search_review_data').on('keyup',function(){--}}
        {{--$value = $(this).val();--}}
        {{--if($('.reviewed_data_tab').hasClass( "active" )){--}}
        {{--$activetab = 1;--}}
        {{--}else{--}}
        {{--$activetab = 0;--}}
        {{--}--}}
        {{--$.ajax({--}}
        {{--type : "GET",--}}
        {{--url : "{{ route('user.dashboard.review-search') }}",--}}
        {{--data:{'search':$value,'activetab':$activetab},--}}
        {{--success:function(data){--}}
        {{--if($('.reviewed_data_tab').hasClass( "active" )){--}}
        {{--$('#review_data').html("");--}}
        {{--$('#review_data').html(data.html);--}}
        {{--$('#a_label').html(data.counter);--}}
        {{--}else{--}}
        {{--$('#p_label').html(data.counter);--}}
        {{--$('#pending_data').html("");--}}
        {{--$('#pending_data').html(data.html);--}}
        {{--}--}}
        {{--}--}}
        {{--});--}}
        {{--})--}}
    </script>
    <script type="text/javascript">
        {{--$('#orderby').change('keyup',function(){--}}
        {{--$value=$(this).val();--}}
        {{--$Activetab = $('.search-result').attr('id');--}}
        {{--//alert($Activetab);--}}
        {{--//exit();--}}
        {{--$.ajax({--}}
        {{--type : "GET",--}}
        {{--url : "{{ route('user.dashboard.review-sort') }}",--}}
        {{--data:{'sort':$value,'activetab':$Activetab},--}}
        {{--success:function(data){--}}
        {{--$('.search-result').html(data);--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}
    </script>
    <script>
        $(document).ready(function(){
            var a_booking =  $('#total_a_booking').val();
            var p_booking =  $('#total_p_booking').val();
            if(a_booking == '0') {
                $('#r_approved').css("display" , "block");
                $("#r_fapproved :input").prop("disabled", true);
                $('.a_lable').css("display" , "none");
            }
            if(p_booking == '0') {
                $('#r_pending').css("display" , "block");
                $("#r_fpending :input").prop("disabled", true);
                $('.p_lable').css("display" , "none");
            }
            $('#a_lable').text(a_booking);
            $('#p_lable').text(p_booking);


        });
    </script>

@endsection