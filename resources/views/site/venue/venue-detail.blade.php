@extends('site.layouts.app')
<style>
    .myspan{
        font-size: 11px;
        font-style: italic;
    }
</style>
@section('head')

@endsection

@section('header-class', '')

@section('header')

    @include('site.layouts.header')
@endsection

@section('content')

    <section class="slider-banner" style="background-image: url({{url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image)}});">
        <div class="container">
            <div class="fav">
                @if(check_wish_list($venue->id,'venue'))
                    @php $filled = 'block' @endphp
                    @php $un_filled = 'none' @endphp
                @else
                    @php $filled = 'none' @endphp
                    @php $un_filled = 'block' @endphp
                @endif

                <a href="#" class="btn get-btn"
                   id="filled_venue" style="display: {{$filled}};" onclick="remove_item_wishlist('{{$venue->id}}','venue', this.id, 'un_filled_venue')">
                    <img src="{{url('images/hearthover.png')}}" alt="" class=""/>
                </a>
                <a href="#" class="btn get-btn"
                   id="un_filled_venue" style="display: {{$un_filled}};" onclick="save_item_wishlist('{{$venue->id}}','venue', this.id, 'filled_venue')">
                    <img src="{{url('images/heart.png')}}" alt="" class="f-heart" />
                </a>
            </div>
            <div class="slide-btm">
                <a href="#" class="btn get-btn" data-toggle="modal" data-target="#photo-slider"><span>View all Photos</span><span></span><span></span><span></span><span></span> </a>
                <div class="s-photo"><a href="#">{{count($slider_images)}} photos of this Venue </a></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>

    <section class="venue-del-top">
        <div class="container">
            <div class="wrap">
                {{--<form action="{{url('venues/search')}}" class="fill-form" method="GET" id="venue_search_main">--}}
                <form action="{{url('venue/'.$venue->slug)}}" class="fill-form" method="post" id="venue_search_main">
                    @csrf
                    <input type="hidden" name="venue_id" value="{{$venue->id}}">
                    <div class="col-sm-2 form-group meeting-flied">
                        <span class="input-number-decrement"><img src="{{url('images/up.png')}}" alt="" /></span>
                        <input type="number" name="people" min="1" value="{{isset($people) ? $people : ''}}" placeholder="People" class="form-control input-number">
                        <span class="input-number-increment"><img src="{{url('images/down.png')}}" alt="" /></span>
                    </div>
                    @php
                        $duration_arr = ['Full Day','Morning','Afternoon','Evening']
                    @endphp
                    <div class="col-sm-2 form-group meeting-flied">
                        <select class="selectpicker" name="duration" id="durationpicker">
                            @foreach($duration_arr as $dur)
                                @if(isset($duration) && $duration==$dur)
                                    @php $selected = 'selected'; @endphp
                                @else
                                    @php $selected = ''; @endphp
                                @endif

                                <option value="{{$dur}}" {{$selected}}>{{$dur}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2 form-group meeting-flied date-venu">
                        <div class="start-date-wrap">
                            <input type="text"  name="start_date" value="{{isset($start_date) ? $start_date : ''}}" placeholder="Start Date" class="form-control start-date" id="date">
                        </div>
                    </div>
                    <div class="col-sm-2 form-group meeting-flied date-venu">
                        <div class="end-date-wrap">
                            <input type="text"  name="end_date" value="{{isset($end_date) ? $end_date : ''}}" placeholder="End Date" class="form-control end-date" id="end-date">
                        </div>
                    </div>
                    <div class="col-sm-2 form-group meeting-btn">
                        {{--<a href="#" class="ani-btn">Search</a>--}}
                        <button class="ani-btn" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>
    <section class="venue-del-section">
        <div class="container">
            <div class="wrap">
                <!-- <div class="back-to full-col fade-right-ani">
                    <a href="#"><img src="images/back.png" alt="" />Back to previous page</a>
                </div> -->
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Venue </li>
                    <li>{{$venue->title}}</li>
                </ol>
                <div class="venu-l-side full-col fade-down-ani">
                    <div class="tabbable">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#spaces" data-toggle="tab">Venue Detail</a></li>
                            <li><a href="#cuisine" data-toggle="tab">Cuisine / Food Menu</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="spaces">
                                <div class="space-head full-col">
                                    <div class="space-head-l"><h2>{{$venue->title}}<span>{{$venue->city}}</span></h2></div>
                                    <div class="space-head-r vd-space-head-r">
                                        @if(round($venue->reviews) == '1') <h3>Poor!</h3>
                                        @elseif(round($venue->reviews) == '2') <h3>Fair!</h3>
                                        @elseif(round($venue->reviews) == '3') <h3>Good!</h3>
                                        @elseif(round($venue->reviews) == '4') <h3>Excellent!</h3>
                                        @elseif(round($venue->reviews) == '5') <h3>WoW!</h3>
                                        @endif
                                        <div class="space-head-r-value"> {{$venue->reviews}}</div>@php echo get_stars_view($venue->reviews); @endphp

                                    </div>
                                </div>
                                <p> {!! $venue->description !!} </p>
                                @forelse($spaces as $sp_data)
                                    <div class="rated-box full-rate-box venu-rated-box fade-down-ani">
                                        <figure>
                                            <img src="{{url('storage/images/spaces/'.$sp_data->image)}}" alt="">
                                            @if($sp_data->top_rate == 1)
                                                <div class="top-rate">
                                                    <img src="{{url('images/ribben.png')}}" alt=""/>
                                                </div>
                                            @endif

                                            <div class="favrt">
                                                @if(check_wish_list($sp_data->id,'space'))
                                                    @php $filled = 'block' @endphp
                                                    @php $un_filled = 'none' @endphp
                                                @else
                                                    @php $filled = 'none' @endphp
                                                    @php $un_filled = 'block' @endphp
                                                @endif


                                                <img src="{{url('images/hearthover.png')}}" alt="" id="filled_space{{$sp_data->id}}" style="display: {{$filled}};"
                                                     onclick="remove_item_wishlist('{{$sp_data->id}}','space', this.id, 'un_filled_space{{$sp_data->id}}')" class=""/>

                                                <img src="{{url('images/heart.png')}}" alt="" class="f-heart" id="un_filled_space{{$sp_data->id}}" style="display: {{$un_filled}};"
                                                     onclick="save_item_wishlist('{{$sp_data->id}}','space', this.id, 'filled_space{{$sp_data->id}}')" />

                                                {{--<img src="{{url('images/heart.png')}}" alt=""/>--}}
                                            </div>
                                        </figure>
                                        <div class="rated-box-info">
                                            <div class="ra-detail col-xs-4 text-center">
                                                <p>{{$sp_data->reviews_total}}</p>
                                                @php echo get_stars_view($sp_data->reviews_total); @endphp
                                                {{--<span>5</span>★★★★★★--}}
                                                <em>{{get_space_reviews_count($sp_data->id)}} reviews</em>

                                                <div class="aed"><span>aed</span>{{$sp_data->price}}</div>
                                            </div>
                                            <div class="ra-info col-xs-8">
                                                @if($sp_data->verified == 1)
                                                    <div class="Veri-box">Verified by Conpherence</div>
                                                @endif
                                                <h4>{{$venue->title}}</h4>
                                                <h2>{{$sp_data->title}}</h2>
                                                @if($sp_data['cancel_cost'] <= 0)
                                                    <p>Free Cancellation</p>
                                                @endif

                                            </div>
                                            <div class="full-col ra-feature">
                                                <div class="ra-l-half col-xs-12">
                                                    <h5 class="head">Capacity</h5>
                                                    @php
                                                        $counter = 0;
                                                    @endphp
                                                    @foreach($sp_data->spaceCapacityPlan as $key=>$cap)

                                                        @php
                                                            $image = get_sitting_plan_imagename($cap->sitting_plan_id);
                                                            $sitting_plan_name = get_sitting_plan_name($cap->sitting_plan_id);
                                                             $counter += $key + 1;
                                                        @endphp
                                                        <p><img src=" {{url('storage/images/sitting-plan/'.$image)}}" alt="" data-toggle="tooltip" data-placement="auto" title="{{$sitting_plan_name}}"><span>{{$cap->capacity}}</span></p>
                                                    @endforeach
                                                    @if($counter == 0)
                                                        <p><span class="myspan">Capacity not available</span></p>
                                                    @endif
                                                </div>
                                                <div class="ra-r-half col-xs-12">
                                                    <h5 class="head">Free with this space</h5>
                                                    @if(!empty($sp_data->free_amenities))
                                                        @foreach(json_decode($sp_data->free_amenities) as $amenity)
                                                            @php
                                                                $aimage = get_amenity_image($amenity);
                                                                $amenity_name = get_amenity_name($amenity);
                                                            @endphp
                                                            <p><img src=" {{url('storage/images/amenities/'.$aimage)}}" alt="" data-toggle="tooltip" data-placement="auto" title="{{$amenity_name}}"></p>
                                                        @endforeach
                                                    @else
                                                        <p><span class="myspan">Amenities not available</span></p>
                                                    @endif
                                                    <a href="{{url('venue/space/'.$sp_data->slug)}}" class="btn get-btn"><span>Space Details</span><span></span><span></span><span></span><span></span> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- rated-box -->
                                @empty
                                    <div class="pay-inner-card">
                                        <div class="dash-pay-gray">
                                            No Space added yet
                                        </div>
                                    </div>
                                @endforelse

                                <div class="cancellations venu-cancellations full-col fade-down-ani">
                                    <h3>Cancellations</h3>
                                    <p>{{$venue->cancellation_policy}}</p>
                                </div>

                                {{$spaces->links()}}

                                <div id="map" class="mapwrap venu-map"></div>
                            </div>
                            <div class="tab-pane" id="cuisine">
                                <div class="cuisine space-cusine full-col">
                                    <h3>Cuisine / Food Menu</h3>
                                    @if(isset($venue->foodCategory) && count($venue->foodCategory) > 0)
                                        @foreach($venue->foodCategory as $v_food_category)
                                            <div class="cusine-type">
                                                <h4>{{$v_food_category->title}} <span>{{$v_food_category->currency}} {{$v_food_category->price}}</span></h4>
                                                <ul>
                                                    @if(isset($v_food_category->foods) && count($v_food_category->foods) > 0)
                                                        @foreach($v_food_category->foods as $food)
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
                        </div>
                        <!-- /tabs -->
                    </div><!-- /tabs end -->
                </div><!--left side-->

            </div><!-- comment  -->
        </div><!--wrapper-->
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

                                @php
                                    $slider_address = url('storage/images/venues/'.$venue->id.'/'.$slider_image);
                                @endphp

                                <div class="item {{$key==0 ? 'active' : ''}}">
                                    <img src="{{$slider_address}}" style="" class="img-responsive">
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
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

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $("#venue_search_main").validate({
            rules: {
                location: {
                    required: true
                },
                people: {
                    required: true
                },
            },
            messages: {
                location: {
                    required: "Please select a Location",
                },
                people: {
                    required: "Attendees is Required",
                }
            }
        });


        // function submitForm(id) {
        //     $("#"+id).submit();
        // }

    </script>
@endsection

