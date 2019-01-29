@extends('site.layouts.app')

@section('head')

@endsection

@section('header-class', '')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="slider-banner" style="background-image: url({{url('storage/images/spaces/'.$spaces->image)}});">
        <div class="container">
            <div class="fav">
                @if(check_wish_list($spaces->id,'space'))
                    @php $filled = 'block' @endphp
                    @php $un_filled = 'none' @endphp
                @else
                    @php $filled = 'none' @endphp
                    @php $un_filled = 'block' @endphp
                @endif

                <a href="#" class="btn get-btn"
                   id="filled_space" style="display: {{$filled}};" onclick="remove_item_wishlist('{{$spaces->id}}','space', this.id, 'un_filled_space')">
                    <img src="{{url('images/hearthover.png')}}" alt="" class=""/>
                </a>
                <a href="#" class="btn get-btn"
                   id="un_filled_space" style="display: {{$un_filled}};" onclick="save_item_wishlist('{{$spaces->id}}','space', this.id, 'filled_space')">
                    <img src="{{url('images/heart.png')}}" alt="" class="f-heart" />
                </a>
            </div>
            <div class="slide-btm">
                <a href="#" class="btn get-btn" data-toggle="modal" data-target="#photo-slider"><span>View all Photos</span><span></span><span></span><span></span><span></span> </a>
                <div class="s-photo"><a href="#">{{count($slider_images)}} photos of this space</a></div>
            </div>
        </div>

        <div class="clearfix"></div>
    </section>
    <section class="venue-del-section space-section">
        <div class="container">
            <div class="wrap">
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li><a href="{{url('/venue/'.$venue->slug)}}">Venue </a></li>
                    <li>Space</li>
                </ol>
                <div class="venu-l-side col-sm-7 fade-down-ani">
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#spaces" data-toggle="tab">Spaces Detail</a></li>
                            <li><a href="#cuisine" data-toggle="tab">Cuisine / Food Menu</a></li>
                            <li><a href="#review" data-toggle="tab">Review</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="spaces">
                                <div class="space-head full-col">
                                    <div class="space-head-l"><h2>{{$spaces->title}}<span>{{$spaces->venue->city}}</span></h2></div>
                                    <div class="space-head-r space-head-r1">
                                        @if(round($spaces->reviews_total) == '1') <h3>Poor!</h3>
                                        @elseif(round($spaces->reviews_total) == '2') <h3>Fair!</h3>
                                        @elseif(round($spaces->reviews_total) == '3') <h3>Good!</h3>
                                        @elseif(round($spaces->reviews_total) == '4') <h3>Excellent!</h3>
                                        @elseif(round($spaces->reviews_total) == '5') <h3>WoW!</h3>
                                        @endif
                                        <div class="rating-cata">
                                            <div class="success-box">{{$spaces->reviews_total}}</div></div>
                                        <div class="rating-stars text-center">
                                        @php echo get_stars_view($spaces->reviews_total); @endphp
                                        </div>

                                        {{--// no change--}}

                                    </div><!-- rating-cata -->
                                </div>
                                <p> {!! $spaces->description !!} </p>
                                <div class="full-col ra-feature b-feature">

                                    <div class="ra-l-half col-xs-6">
                                        <h3>Capacity</h3>
                                        @if(isset($spaces))
                                            @foreach($s_sittingplans as $key1=>$plans)
                                                <p><img src="{{url('storage/images/sitting-plan/'.get_sitting_plan_imagename($plans->sitting_plan_id))}}" alt="" data-toggle="tooltip" data-placement="auto" title="{{get_sitting_plan_name($plans->sitting_plan_id)}}"><span>{{$plans->capacity}}</span></p>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="ra-r-half col-xs-6">
                                        <h3>Free with this space</h3>
                                        @if(isset($spaces))
                                            @foreach($amenities as $key=>$amenitie)
                                                @if(in_array($amenitie->id , json_decode($spaces->free_amenities)))
                                                    <p><img src="{{url('storage/images/amenities/'.$amenitie->image)}}" alt="" data-toggle="tooltip" data-placement="auto" title="{{$amenitie->name}}"></p>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="amenities full-col ">
                                    <h3>Amenities</h3>
                                    <ul class="col-sm-4 fade-left-ani">
                                        @if(isset($spaces))
                                            @foreach($amenities as $key=>$amenitie)
                                                @if(in_array($amenitie->id , json_decode($spaces->amenities)))
                                                    <li><img src="{{url('storage/images/amenities/'.$amenitie->image)}}" alt="">{{$amenitie->name}}</li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="cancellations full-col fade-down-ani">
                                    <h3>Cancellations</h3>
                                    <p>Moderate policy – Free cancellation within {{$spaces->hours}} hours</p>
                                    <p>Chargies – {{$spaces->cancel_cost}}%</p>
                                    <p>{{$spaces->cancellation_policy}}</p>
                                </div>
                                <div class="cuisine access full-col fade-down-ani">
                                    <h3>Accessibility</h3>
                                    <ul>
                                        @php
                                            if(isset($spaces)) {
                                            $access = array();
                                            foreach($s_accessibilities as $as){
                                             array_push($access , $as->id);
                                             }
                                            }
                                        @endphp

                                        @foreach($accessibilities as $key=>$accessibilitie)
                                            @if(isset($spaces) &&  in_array($accessibilitie->id  , $access))
                                                <li><a href="#"><img src="{{url('storage/images/accessibilities/'.$accessibilitie->image)}}" alt="" />{{$accessibilitie->name}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                                <div id="map" class="mapwrap"></div>
                            </div>
                            <div class="tab-pane" id="cuisine">
                                <div class="cuisine space-cusine full-col">
                                    <h3>Cuisine / Food Menu</h3>
                                    @if(isset($spaces->venue->foodCategory) && count($spaces->venue->foodCategory) > 0)
                                        @foreach($spaces->venue->foodCategory as $s_food_category)
                                            <div class="cusine-type">
                                                <h4>{{$s_food_category->title}} <span>{{$s_food_category->currency}} {{$s_food_category->price}}</span></h4>
                                                <ul>
                                                    @if(isset($s_food_category->foods) && count($s_food_category->foods) > 0)
                                                        @foreach($s_food_category->foods as $food)
                                                            <li><a href="#">{{$food->title}}</a></li>
                                                        @endforeach
                                                    @else
                                                        <li><a href="#">No Food Found</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="cusine-type">
                                            <h3>No Food Category</h3>
                                        </div>
                                    @endif


                                </div>
                            </div>
                            <div class="tab-pane" id="review">
                                <div class="review-sum full-col">
                                    @php
                                        $total_star = json_decode($spaces->reviews_count);
                                    @endphp
                                    <div class="review-excellent-cata col-sm-7">
                                        <h3>Review Summery</h3>
                                        <ul>
                                            <li>
                                                <span>Customer Service</span>

                                                <div class="rating-cata star-rating-cata">
                                                    @php echo get_stars_view($total_star['0']); @endphp
                                                </div><!-- rating-cata -->
                                            </li>
                                            <li>
                                                <span>Amenities</span>
                                                <div class="rating-cata star-rating-cata">
                                                    <!-- <div class='success-box'>0</div> -->
                                                    @php echo get_stars_view($total_star['1']); @endphp
                                                </div><!-- rating-cata -->
                                            </li>
                                            <li>
                                                <span>Meeting Facility Rate</span>
                                                <div class="rating-cata star-rating-cata">
                                                    <!-- <div class='success-box'>0</div> -->
                                                    @php echo get_stars_view($total_star['2']); @endphp
                                                </div><!-- rating-cata -->
                                            </li>
                                            <li>
                                                <span>Food</span>
                                                <div class="rating-cata star-rating-cata">
                                                    @php echo get_stars_view($total_star['3']); @endphp
                                                </div><!-- rating-cata -->
                                            </li>
                                        </ul>
                                    </div>
                                    @php
                                        $reviews = $spaces->reviews->where('r_status' , '1')->toArray();;
                                        $total = count($reviews);
                                    @endphp
                                    <div class="review-sum-info col-sm-5">
                                        <div class="rating-cata ">
                                            <div class='success-box'>{{$total_star['4']}}</div>
                                            <div class='rating-stars text-center'>
                                                @php echo get_stars_view($total_star['4']); @endphp
                                            </div>
                                        </div><!-- rating-cata -->
                                        <a href="#">{{$total}} Reviews</a>
                                    </div>
                                </div>
                                <div class="comment full-col">
                                    @foreach($reviews as $review)
                                        @if($review['feedback'])
                                            <div class="comment-box full-col main-commemt-box">
                                                <div class="comment-img"><img src="{{get_user_image($review['user_id'])}}" alt="" /></div>
                                                <div class="comment-info">
                                                    <h4>{{get_user_name($review['user_id'])}}  <span class="date">{{date('d-M-Y' , strtotime($review['created_at']))}}</span></h4>
                                                    <p>{{$review['feedback']}}</p>
                                                </div>
                                            </div><!-- comment-box -->
                                        @endif
                                    @endforeach
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

                                </div>
                            </div>
                        </div>
                        <!-- /tabs -->
                    </div><!-- /tabs end -->
                </div><!--left side-->
                <div class="venu-r-side col-sm-5 space-r-side fade-right-ani">
                    <div class="venu-aed">
                        {{--<h5>Order Summary</h5>--}}
                        <h3>AED {{$spaces->price}} Per Person</h3>
                        <img src="{{url('images/bar.png')}}" alt="" />
                        <form action="#" method="post" class="fill-form">
                            <div class="form-group ">
                                <span class="input-number-decrement"><img src="{{url('images/up.png')}}" alt="" /></span>
                                <input type="number" name="People" placeholder="People" min="1"  class="form-control numeric_value_only input-number" id="people" onkeyup="calculate()">
                                <span class="input-number-increment"><img src="{{url('images/down.png')}}" alt="" /></span>
                            </div>
                            <div class="form-group">
                                <input type="text" value=""  name="date" placeholder="Start Date" class="form-control" id="date" onchange="calculate()">
                            </div>
                            <div class="form-group">
                                <input type="text" value="" name="date" placeholder="End Date" class="form-control" id="end-date" onchange="calculate()">
                            </div>
                            {{--<div class="form-group">--}}
                            {{--<select class="selectpicker">--}}
                            {{--<option>Morning</option>--}}
                            {{--<option>Afternoon</option>--}}
                            {{--<option>Evening</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            <div class="form-group sub-total">
                                <label>Subtotal <span class="total-price">AED 0.00</span></label>
                            </div>
                            <div class="form-group total">
                                <label>Total <span class="total-price">AED 0.00</span></label>
                            </div>
                            <div class="form-group">
                                <a  class="ani-btn" onclick="check_agree()" id="book_now">Book Now</a>
                            </div>
                            <div class="form-group form-check ">
                                <input type="checkbox" id="agree" onchange="show_agree_error()">
                                <label for="agree">I have read & accepted the Client Terms of Service</label>
                                <span id="booking_agree_error" class="error" style="display: none;">Please accept the Client Terms of Service</span>
                            </div>
                        </form>
                    </div>
                </div><!--right side-->

            </div><!-- comment  -->
        </div><!--wrapper-->
        </div>
        <div class="clearfix"></div>
    </section>
    <section class="rated-section rated-detail-section catagory-section gray-catagory">
        <div class="container">
            <div class="cata-info midtext">
                <h2>Other Spaces</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
            </div>
            <div class="catagory-wrap row">
                @if(isset($spacesall))
                    @foreach($spacesall as $spacesal)
                        <div class="rated-box col-xs-3 fade-down-ani active">
                            <figure>
                                <img src="{{url('storage/images/spaces/'.$spacesal->image)}}" onclick="location.href='{{url('venue/space/'.$spacesal->slug)}}';"  alt="" />
                                @if($spacesal->top_rate == 1)
                                    <div class="top-rate">
                                        <img src="{{url('images/ribben.png')}}" alt=""/>
                                    </div>
                                @endif

                                <div class="favrt">
                                    @if(check_wish_list($spacesal->id,'space'))
                                        @php
                                            $filled2 = 'block' ;
                                            $un_filled2 = 'none'
                                        @endphp
                                    @else
                                        @php
                                            $filled2 = 'none' ;
                                            $un_filled2 = 'block'
                                        @endphp
                                    @endif

                                        <img src="{{url('images/hearthover.png')}}" alt="" id="filled2_space{{$spacesal->id}}" style="display: {{$filled2}};"
                                             onclick="remove_item_wishlist('{{$spacesal->id}}','space', this.id, 'un_filled2_space{{$spacesal->id}}')" class=""/>

                                        <img src="{{url('images/heart.png')}}" alt="" class="f-heart" id="un_filled2_space{{$spacesal->id}}" style="display: {{$un_filled2}};"
                                             onclick="save_item_wishlist('{{$spacesal->id}}','space', this.id, 'filled2_space{{$spacesal->id}}')" />

                                    {{--<img src="{{url('images/heart.png')}}" alt="">--}}
                                </div>
                            </figure>
                            <div class="rated-box-info" onclick="location.href='{{url('venue/space/'.$spacesal->slug)}}';" >
                                @if($spacesal->verified == 1)
                                    <h3>Verified by Conpherence</h3>
                                @endif

                                <h2>{{$spacesal->title}}</h2>
                                <h4>{{$spacesal->venue->title}}</h4>
                                <ul>
                                    @if($spacesal['cancel_cost'] <= 0)
                                        <li>Free Cancellation</li>
                                    @endif
                                </ul>
                                @php
                                    $averge = ($spacesal->reviews_total/5)*100;
                                   // echo $averge;
                                @endphp
                                <div class="star-bar">
                                    <h3>
                                        <div class="star-ratings-css">
                                            <div class="star-ratings-css-top" style="width: {{$averge}}%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                            <div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
                                        </div>
                                    </h3>
                                </div>

                            </div>
                        </div><!-- rated-box -->
                    @endforeach
                @endif

                <div class="col-xs-12 rated-btn">
                    <a href="{{url('/categories')}}" class="get-btn">
                        <span>Load More</span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div><!--catagpry-wrapper-->
        </div>
        <div class="clearfix"></div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="photo-slider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <!-- <h3>Continental</h3> -->
                    <!-- Carousel
            ================================================== -->
                    <div id="myCarousel" class="carousel slide">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            @foreach($slider_images as $key=>$slider_image)
                                <li data-target="#myCarousel" data-slide-to="{{$key}}" class="{{$key==0 ? 'active' : ''}}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach($slider_images as $key=>$slider_image)
                                <div class="item {{$key==0 ? 'active' : ''}}">
                                    <img src="{{url('storage/images/spaces/'.$spaces->id.'/'.$slider_image)}}" style="" class="img-responsive">
                                </div>
                            @endforeach
                        </div>
                        <!-- Controls -->
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                            <span class="icon-prev"></span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                            <span class="icon-next"></span>
                        </a>
                    </div>
                    <!-- /.carousel -->
                </div>
            </div>
        </div>
    </div>
    <!-- wishlist popup -->
    <div class="modal fade list-popup" id="wishlistpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3 id="wishlistmsg"></h3>
                    {{--<div class="form-group">--}}
                    {{--<input type="text" name="" placeholder="Name of list" class="form-control Search-location">--}}
                    {{--</div><!--checkbox-->--}}
                    {{--<div class="form-group form-btn">--}}
                    {{--<button type="button" class="btn get-btn">--}}
                    {{--<span>Creates</span><span></span><span></span><span></span><span></span>--}}
                    {{--</button>--}}
                    {{--</div>--}}
                    {{--<h4>Your Lists</h4>--}}
                    {{--<ul>--}}
                    {{--<li class="active">--}}
                    {{--<span>Top Rated in Dubai</span>--}}
                    {{--<a href="#">Save</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<span>Best Venue</span>--}}
                    {{--<a href="#">Save</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                </div>
            </div>
        </div>
    </div>


@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            //Allow only numeric values
            $(".numeric_value_only").keypress(function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });
            /* 1. Visualizing things on Hover - See next part for action on click */
            $('#stars li').on('mouseover', function(){
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
            $('#stars li').on('click', function(){
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                // JUST RESPONSE (Not needed)
                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                var msg = "";
                if (ratingValue > 1) {
                    msg = ratingValue;
                }
                else {
                    msg = ratingValue ;
                }
                responseMessage(msg);

            });


        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        
        function check_agree() {
            if($("#agree").prop('checked') == true){
               window.location = '{{url('/venue/'.$spaces->slug.'/booking/')}}';
                $("#booking_agree_error").css('display', 'none');
            } else {
                $("#booking_agree_error").css('display', 'block');
            }
        }

        function show_agree_error() {
            if($("#agree").prop('checked') == true){
                $("#booking_agree_error").css('display', 'none');
            } else {
                $("#booking_agree_error").css('display', 'block');
            }
        }


        function responseMessage(msg) {
            $('.success-box').fadeIn(200);
            $('.success-box').html("<span>" + msg + "</span>");
        }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <script type="text/javascript">
        // $('.datepicker').datepicker({
        //     startDate: new Date()
        // });



        function calculate()
        {
            var people = $('#people').val();
            var price = '@php echo $spaces['price'] @endphp';

            var startDate = new Date($('#date').val());
            var endDate = new Date($('#end-date').val());
            var dates = getDataCount(startDate, endDate);

            var value = 'AED ' + price * people * dates.length;

            $('.total-price').text(value)
        }

        function getDataCount(startDate, endDate)
        {
            var dates = [],
                currentDate = startDate,
                addDays = function(days) {
                    var date = new Date(this.valueOf());
                    date.setDate(date.getDate() + days);
                    return date;
                };
            while (currentDate <= endDate) {
                dates.push(currentDate);
                currentDate = addDays.call(currentDate, 1);
            }
            return dates;
        }



        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 15,

                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng(25.099448, 55.161948), // New York

                // How you would like to style the map.
                // This is where you would paste any style found on Snazzy Maps.

            };

            // Get the HTML DOM element that will contain your map
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('map');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Let's also add a marker while we're at it

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(25.099448, 55.161948),
                map: map,
                title: 'Snazzy!',
                icon: '{{url('images/locator.png')}}'
            });

        }

    </script>
@endsection

