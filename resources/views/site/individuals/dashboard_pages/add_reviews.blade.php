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
            <div class="tab-content dashboard-wrap">

                <div class="tab-pane active reviews-pane" id="#reviews">
                    <div class="back-to full-col fade-right-ani hidden visible animated fadeInRight full-visible">
                        <a href={{url('user/dashboard/reviews')}}><img src="images/back.png" alt="">Back to listing page</a>
                    </div>

                    <div class="add-review-wrap full-col">
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
                        <div class="flow-summry-head col-sm-12">
                            <div class="fs-l-head col-sm-8">
                                <h4>{{$booking_space_venue->title}}</h4>
                                <h2>{{$booking_space->title}}</h2>
                                <h5>{{$booking_space_venue->city}}  </h5>
                                <img src="images/bar.png" alt="">
                            </div>
                            <div class="fs-r-head col-sm-4">
                                <p><span>Booking Date</span>{{date('d-M-Y' , strtotime($booking_space->created_at))}}</p>
                            </div>
                        </div>


                        <div class="review-box full-col">
                            <h3>Add your review</h3>
                            <form role="form" action="<?php echo e(url('/user/review/save')); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="review_id" value="{{$review ? $review->id : ''}}" >
                                <input type="hidden" name="booking_id" value="{{$bookinginfo->id}}" >
                                <input type="hidden" name="space_id" value="{{$booking_space->id}}" >
                                <textarea  {{$form_status}}  name="feedback" id="feedback">{{$review ? $review->feedback : ''}}</textarea>
                                <lable style="color: red; display: none" id="errors"></lable>
                                <input type="hidden" value="{{$review ? $review->customer_service_rate : ''}}"  name="customer_service_rate" id="csr" >
                                <input type="hidden" value="{{$review ? $review->amenities_rate : ''}}" name="amenities_rate" id="ar" >
                                <input type="hidden" value="{{$review ? $review->meeting_facility_rate : ''}}" name="meeting_facility_rate" id="mfr" >
                                <input type="hidden" value="{{$review ? $review->food_rate : ''}}" name="food_rate" id="fr" >
                                <ul class="full-col reviw-ser">

                                    <li>
                                        <span>Customer Service</span>
                                        <div class="rating-cata ">
                                            <div class="rating-stars text-center">
                                                <ul id="stars1" class="stars">
                                                    <li class="star s1_1" title="Poor" data-value="1"><i>★</i></li>
                                                    <li class="star s1_2" title="Fair" data-value="2"><i>★</i></li>
                                                    <li class="star s1_3" title="Good" data-value="3"><i>★</i></li>
                                                    <li class="star s1_4" title="Excellent" data-value="4"><i>★</i></li>
                                                    <li class="star s1_5" title="WOW!!!" data-value="5"><i>★</i></li>
                                                </ul>
                                            </div>
                                        </div><!-- rating-cata -->
                                    </li>
                                    <li>
                                        <span>Amenities</span>
                                        <div class="rating-stars text-center">
                                            <ul id="stars2" class="stars">
                                                <li class="star s2_1" title="Poor" data-value="1"><i>★</i></li>
                                                <li class="star s2_2" title="Fair" data-value="2"><i>★</i></li>
                                                <li class="star s2_3" title="Good" data-value="3"><i>★</i></li>
                                                <li class="star s2_4" title="Excellent" data-value="4"><i>★</i></li>
                                                <li class="star s2_5" title="WOW!!!" data-value="5"><i>★</i></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <span>Meeting Facility Rate</span>
                                        <div class="rating-stars text-center">
                                            <ul id="stars3" class="stars">
                                                <li class="star s3_1" title="Poor" data-value="1"><i>★</i></li>
                                                <li class="star s3_2" title="Fair" data-value="2"><i>★</i></li>
                                                <li class="star s3_3" title="Good" data-value="3"><i>★</i></li>
                                                <li class="star s3_4" title="Excellent" data-value="4"><i>★</i></li>
                                                <li class="star s3_5" title="WOW!!!" data-value="5"><i>★</i></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <span>Food</span>
                                        <div class="rating-stars text-center">
                                            <ul id="stars4" class="stars">
                                                <li class="star s4_1" title="Poor" data-value="1"><i>★</i></li>
                                                <li class="star s4_2" title="Fair" data-value="2"><i>★</i></li>
                                                <li class="star s4_3" title="Good" data-value="3"><i>★</i></li>
                                                <li class="star s4_4" title="Excellent" data-value="4"><i>★</i></li>
                                                <li class="star s4_5" title="WOW!!!" data-value="5"><i>★</i></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                                    {{--{{$form_status}}--}}
                                    <button type="submit" {{$form_status}} class="btn ani-btn book-step">Submit</button>
                                    <a href="{{url('user/dashboard/reviews')}}"><button type="button" class="cancle-step">Cancel</button></a>

                            </form>
                        </div>

                    </div>
                </div>
                <div class="tab-pane" id="reviews">
                    <h2>Reviews</h2>
                </div>
                <div class="tab-pane" id="team">
                    <div class="welcome-title full-col">
                        <h2>Team Managment</h2>
                    </div>
                </div>
                <div class="tab-pane" id="savings">
                    <div class="welcome-title full-col">
                        <h2>Savings</h2>
                    </div>

                </div>
            </div>
            <!-- /tabs -->
            <div class="clearfix"></div>
        </div>
    </section>

@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}
@section('scripts')
    @include('site.layouts.scripts')
    <script>
        $(document).ready(function(){
            var status = '<?php echo $review ?  $review->r_status : 0 ?>';
            if(parseInt(status)) {
                var first = '<?php echo $review ? $review->customer_service_rate : 0 ?>';
                for (var i = 1; i <= first; i++) {
                    $("#stars1 .s1_" + i).addClass('selected')
                }

                var second = '<?php echo $review ? $review->amenities_rate : '' ?>';
                for (var i = 1; i <= second; i++) {
                    $("#stars2 .s2_" + i).addClass('selected')
                }

                var third = '<?php echo $review ? $review->meeting_facility_rate : ''?>';
                for (var i = 1; i <= third; i++) {
                    $("#stars3 .s3_" + i).addClass('selected')
                }

                var four = '<?php echo $review ? $review->food_rate : '' ?>';
                for (var i = 1; i <= four; i++) {
                    $("#stars4 .s4_" + i).addClass('selected')
                }
            }else{

                var first = '<?php echo $review ? $review->customer_service_rate : 0 ?>';
                for (var i = 1; i <= first; i++) {
                    $("#stars1 .s1_" + i).addClass('selected')
                }

                var second = '<?php echo $review ? $review->amenities_rate : '' ?>';
                for (var i = 1; i <= second; i++) {
                    $("#stars2 .s2_" + i).addClass('selected')
                }

                var third = '<?php echo $review ? $review->meeting_facility_rate : ''?>';
                for (var i = 1; i <= third; i++) {
                    $("#stars3 .s3_" + i).addClass('selected')
                }

                var four = '<?php echo $review ? $review->food_rate : '' ?>';
                for (var i = 1; i <= four; i++) {
                    $("#stars4 .s4_" + i).addClass('selected')
                }



                /* 1. Visualizing things on Hover - See next part for action on click */
                $('#stars1 li').on('mouseover', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                    // Now highlight all the stars that's not after the current hovered star
                    $(this).parent().children('li.star').each(function(e){
                        if (e < onStar) {
                            $(this).addClass('hover');
                        }
                        else {
                            $(this).removeClass('hover');
                        }
                    });

                }).on('mouseout', function(){
                    $(this).parent().children('li.star').each(function(e){
                        $(this).removeClass('hover');
                    });
                });
                /* 2. Action to perform on click */
                $('#stars1 li').on('click', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                    var stars = $(this).parent().children('li.star');
                    console.log(stars)

                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                    }

                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');
                    }

                    // JUST RESPONSE (Not needed)
                    var ratingValue = parseInt($('#stars1 li.selected').last().data('value'), 10);
                    var msg = "";
                    if (ratingValue > 1) {
                        msg = ratingValue;
                    }
                    else {
                        msg = ratingValue ;
                    }

                    $('#csr').val(msg);

                });


                /* 1. Visualizing things on Hover - See next part for action on click */
                $('#stars2 li').on('mouseover', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                    // Now highlight all the stars that's not after the current hovered star
                    $(this).parent().children('li.star').each(function(e){
                        if (e < onStar) {
                            $(this).addClass('hover');
                        }
                        else {
                            $(this).removeClass('hover');
                        }
                    });

                }).on('mouseout', function(){
                    $(this).parent().children('li.star').each(function(e){
                        $(this).removeClass('hover');
                    });
                });
                /* 2. Action to perform on click */
                $('#stars2 li').on('click', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                    var stars = $(this).parent().children('li.star');

                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                    }

                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');
                    }

                    // JUST RESPONSE (Not needed)
                    var ratingValue = parseInt($('#stars2 li.selected').last().data('value'), 10);
                    var msg = "";
                    if (ratingValue > 1) {
                        msg = ratingValue;
                    }
                    else {
                        msg = ratingValue ;
                    }
                    $('#ar').val(msg)

                });


                /* 1. Visualizing things on Hover - See next part for action on click */
                $('#stars3 li').on('mouseover', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                    // Now highlight all the stars that's not after the current hovered star
                    $(this).parent().children('li.star').each(function(e){
                        if (e < onStar) {
                            $(this).addClass('hover');
                        }
                        else {
                            $(this).removeClass('hover');
                        }
                    });

                }).on('mouseout', function(){
                    $(this).parent().children('li.star').each(function(e){
                        $(this).removeClass('hover');
                    });
                });
                /* 2. Action to perform on click */
                $('#stars3 li').on('click', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                    var stars = $(this).parent().children('li.star');

                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                    }

                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');
                    }

                    // JUST RESPONSE (Not needed)
                    var ratingValue = parseInt($('#stars3 li.selected').last().data('value'), 10);
                    var msg = "";
                    if (ratingValue > 1) {
                        msg = ratingValue;
                    }
                    else {
                        msg = ratingValue ;
                    }
                    $('#mfr').val(msg)

                });


                /* 1. Visualizing things on Hover - See next part for action on click */
                $('#stars4 li').on('mouseover', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                    // Now highlight all the stars that's not after the current hovered star
                    $(this).parent().children('li.star').each(function(e){
                        if (e < onStar) {
                            $(this).addClass('hover');
                        }
                        else {
                            $(this).removeClass('hover');
                        }
                    });

                }).on('mouseout', function(){
                    $(this).parent().children('li.star').each(function(e){
                        $(this).removeClass('hover');
                    });
                });
                /* 2. Action to perform on click */
                $('#stars4 li').on('click', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                    var stars = $(this).parent().children('li.star');

                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                    }

                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');
                    }

                    // JUST RESPONSE (Not needed)
                    var ratingValue = parseInt($('#stars4 li.selected').last().data('value'), 10);
                    var msg = "";
                    if (ratingValue > 1) {
                        msg = ratingValue;
                    }
                    else {
                        msg = ratingValue ;
                    }

                    $('#fr').val(msg)
                });
            }





        });
        // Below Function Executes On Form Submit
        function validateForm() {

// Storing Field Values In Variables
            var feedback = document.getElementById("feedback").value;
            var csr = document.getElementById("csr").value;
            var ar = document.getElementById("ar").value;
            var mfr = document.getElementById("mfr").value;
            var fr = document.getElementById("fr").value;

            if (csr != '' && ar != '' && mfr != '' && fr != '') {

                $('#errors').css("display","none");
                return true;
            } else {
                $('#errors').css("display","block").text("All Rating fields are required..!");
                return false;
            }
        }
    </script>
@endsection

