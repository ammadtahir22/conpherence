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
                <div class="tab-pane active bookings-pane booking-flow-summry" id="bookings">
                    <div class="welcome-title back-to full-col fade-right-ani hidden visible animated fadeInRight full-visible">
                        <a href="{{url('company/dashboard/bookings')}}"><img src="images/back.png" alt="">Back to listing page</a>
                    </div>
                    <div class="flow-summry">
                        <div class="flow-summry-head col-sm-12">
                            <div class="fs-l-head col-sm-8">
                                <h4>{{$booking_infos->space->venue->location}}</h4>
                                <h2>{{$booking_infos->space->venue->title}}</h2>
                                <h5>{{$booking_infos->space->venue->city}}  </h5>
                                <img src="images/bar.png" alt="">
                            </div>
                            <div class="fs-r-head col-sm-4">
                                <p><span>Order Date</span>{{date('d M Y', strtotime($booking_infos->created_at))}}</p>
                            </div>
                        </div>
                        <h4>info</h4>
                        <div class="bsummary-box col-sm-7 no-b-r">
                            <h5>Name of individual / company</h5>
                            <p>{{$booking_infos->booking_firstname}} {{$booking_infos->booking_lastname}}</p>
                        </div>
                        <div class="bsummary-box col-sm-3 no-b-r">
                            <h5>Email Id</h5>
                            <p>{{isset($user)? $user->email : " "}}</p>
                        </div>
                        <div class="bsummary-box col-sm-2">
                            <h5>Contact Number</h5>
                            <p>{{isset($user)? $user->phone_number : " "}}</p>
                        </div>
                        <div class="bsummary-box col-sm-6 no-b-r">
                            <h5>Purpose of Meeting</h5>
                            <p>{{$booking_infos->purpose}}</p>
                        </div>
                        <div class="bsummary-box col-sm-2">
                            <h5>Cost per head</h5>
                            <p class="pink">AED {{$booking_infos->space->price}}</p>
                        </div>
                        <div class="bsummary-box col-sm-2 no-b-r">
                            <h5>Start Date</h5>
                            <p>{{date('d M Y', strtotime($booking_infos->start_date))}}</p>
                        </div>
                        <div class="bsummary-box col-sm-2">
                            <h5>End Date</h5>
                            <p>{{date('d M Y', strtotime($booking_infos->end_date))}}</p>
                        </div>
                        @foreach($sitting_plan as $key=>$sitting_plans)

                            @foreach($payment_per_day as $inner_key => $payment_per_days)
                                @if($key == $inner_key)
                                    <h4>Booking Detail Day {{ numberTowords($payment_per_days->day) }}<span>AED {{$payment_per_days->total_day_payment}}</span></h4>
                                @endif
                            @endforeach

                            <div class="bsummary-box col-sm-2 no-b-r">
                                <h5>Number of People</h5>
                                <p>{{$sitting_plans->capacity}}</p>
                            </div>
                            <div class="bsummary-box col-sm-4 no-b-r">
                                <h5>Layout</h5>
                                @php $image = get_sitting_plan_imagename($sitting_plans->sitting_plan_id) @endphp
                                <p><img src="{{url('storage/images/sitting-plan/'.$image)}}" alt="" /> @php echo get_sitting_plan_name($sitting_plans->sitting_plan_id) @endphp</p>
                            </div>
                            <div class="bsummary-box col-sm-2 no-b-r">
                                <h5>Date</h5>
                                @if(isset($booking_days_arr[$key]))
                                    <p>{{date('d M Y', strtotime($booking_days_arr[$key]))}}</p>
                                @else
                                    <p> </p>
                                @endif
                            </div>
                            <div class="bsummary-box col-sm-2 no-b-r">
                                <h5>Start Time</h5>
                                <p>{{date('h:i a', strtotime($sitting_plans->start_time))}} </p>
                            </div>
                            <div class="bsummary-box col-sm-2">
                                <h5>End Time</h5>
                                <p>{{date('h:i a', strtotime($sitting_plans->end_time))}}</p>
                            </div>

                            @foreach($foods as $inner_food_key => $food)
                                @if($sitting_plans->day == $food->day)
                                    <div class="bsummary-box col-sm-12">

                                        @foreach($booking_infos->space->venue->foodCategory as $s_food_category)
                                            @if($food->food_categories_id == $s_food_category->id)
                                                @if($s_food_category->foodDuration->food_duration == 'Morning')
                                                    <h5>{{'Breakfast'}}</h5>
                                                @elseif($s_food_category->foodDuration->food_duration == 'Afternoon')
                                                    <h5>{{'Lunch'}}</h5>
                                                @elseif($s_food_category->foodDuration->food_duration == 'Evening')
                                                    <h5>{{'Tea/Coffee'}}</h5>
                                                @elseif($s_food_category->foodDuration->food_duration == 'Night')
                                                    <h5>{{'Dinner'}}</h5>
                                                @endif

                                                <p>{{$s_food_category->title}}<span>AED {{$s_food_category->price}}</span></p>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                            <div class="bsummary-box col-sm-12">
                                <h5>Add Ons</h5>

                                <ul>
                                    @foreach($booking_infos->space->venue->venueAddOns as $addons)
                                        @if(in_array($addons->id  , json_decode($sitting_plans->addons)))
                                            @php $image = get_amenity_image($addons->amenity_id) @endphp
                                            <li><img src="{{url('storage/images/amenities/'.$image)}}" alt="" /><span>@php echo get_amenity_name($addons->amenity_id) @endphp<i>AED {{$addons->price}}</i></span></li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>
                            @if($sitting_plans->special_instruction != null)
                                <div class="bsummary-box col-sm-12">
                                    <h5>Special Instructions</h5>
                                    <p>{{$sitting_plans->special_instruction}}</p>
                                </div>
                            @endif
                        @endforeach
                        {{--<h6>Payment Method</h6>--}}
                        {{--<div class="bsummary-box col-sm-6 no-b-r">--}}
                        {{--<h5>Card Holder Name</h5>--}}
                        {{--<p></p>--}}
                        {{--</div>--}}
                        {{--<div class="bsummary-box col-sm-6">--}}
                        {{--<h5>Card Number</h5>--}}
                        {{--<p>xxxxxxxxxxx</p>--}}
                        {{--</div>--}}
                        <div class="bsummary-result col-sm-6">
                            <p class="stotle">Total<span>AED {{$booking_infos->total}}</span></p>
                            <p class="stotle">Discount<span>{{$booking_infos->discount}} %</span></p>
                            <p class="stotle">Grand Total<span>AED {{$booking_infos->grand_total}}</span></p>
                            <hr/>
                        </div>
                        <div class="full-col b-sum-btn-wrap">
                            <ul class="list-inline col-sm-6">
                                @php
                                    $end_date = Carbon\Carbon::parse($booking_infos->end_date)->format('Y-m-d');
                                    $today_date = Carbon\Carbon::now();
                                @endphp

                                @if($end_date > $today_date)
                                    @if($booking_infos->status == 1 || $booking_infos->status == 2)
                                        <li ><button  data-toggle="modal" onclick="changeStatus(1)" data-target="#delpopup" type="button" class="btn ani-btn book-step" disabled>Approve</button></li>
                                    @else
                                        <li ><button  data-toggle="modal" onclick="changeStatus(1)" data-target="#delpopup" type="button" class="btn ani-btn book-step">Approve</button></li>
                                    @endif
                                    <li><button  data-toggle="modal" onclick="changeStatus(2)" data-target="#delpopup" type="button" class="cancle-step">Cancel</button></li>
                                @endif

                            </ul>
                        </div>
                    </div><!-- flow-summry" -->

                </div>
            </div>
        </div>
        <!-- /tabs -->
        <div class="clearfix"></div>

    </section>

    <!--Delete popup-->
    <div class="modal fade card-popup" id="delpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <!-- <h3>Delete Payment Method</h3> -->
                    <p id="approve-status" style="text-align: center;"> Are you sure you want delete it</p>
                    <form method="post" action="{{url('/company/dashboard/booking-approve')}}" id="changeStatus">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{$booking_infos->id}}" id="booking_id">
                        <input type="hidden" name="status" value="" id="status">
                        <div class="form-group form-btn half-l-field">
                            <button type="submit" class="btn ani-btn" id="delete_card_button">Yes</button>
                        </div>
                        <div class="form-group form-btn half-r-field">
                            <button type="button" class="btn ani-btn cancel-btn" data-dismiss="modal" aria-label="Close">No</button>
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
        //delete credit card
        function changeStatus(id) {
            //  alert(id);
            $('input[name="status"]').val(id);
            if(id == 1){
                $('#approve-status').html('Are You Sure You Want To Approve this Booking');
            }else {
                $('#approve-status').html('Are You Sure You Want To Cancel this Booking');
            }
            // document.getElementById("demo").innerHTML = "Hello World";
        }

    </script>


@endsection
