@extends('site.layouts.app')

@section('head')
    {{--<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>--}}
    <style>
        .meeting-section .fill-form input, .meeting-section .fill-form select {
            height: 40px;
            border: 1px solid #d5d5d5;
            padding: 10px 10px;
        }
    </style>
@endsection

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')
    <!--Top Rated Section-->
    <section class="meeting-section">
        <form method="post" class="fill-form" id="filer_venue_form" >
            <input type="hidden" id="orderby_input" name="orderby" value="desc">
            <div class="full-col main-met-venu extened-venu" id="search_banner">
                <div class="container">
                    <div class="col-sm-4 loc-venu form-group">
                        <input type="text" name="location" value="{{isset($location) ? $location : ''}}" onchange="submitForm()" placeholder="Meeting city e.g. London" class="form-control Search-location" list="Search-location">
                        <datalist id="Search-location">
                            @php $cities = get_all_cities(); @endphp
                            @foreach($cities as $city)
                                <option value="{{$city}}">{{$city}}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-sm-2 form-group meeting-flied">
                        <input type="number" name="people" value="{{isset($people) ? $people : ''}}" onkeyup="submitForm()" placeholder="People" class="form-control">
                    </div>
                    @php
                        $duration_arr = ['Full Day','Morning','Afternoon','Evening']
                    @endphp

                    <div class="col-sm-2 form-group meeting-flied">
                        <select class="selectpicker" name="duration" id="durationpicker" onchange="submitForm()">
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
                            <input type="text"  name="start_date" value="{{isset($start_date) ? $start_date : ''}}" onkeyup="submitForm()" placeholder="Start Date" class="form-control start-date" id="date">
                        </div>
                        <div class="end-date-wrap">
                            <input type="text"  name="end_date" value="{{isset($end_date) ? $end_date : ''}}" onkeyup="submitForm()" placeholder="End Date" class="form-control end-date" id="end-date">
                        </div>
                    </div>
                    <div class="col-sm-2 form-group meeting-btn">
                        <div class="ani-btn"><a href="#"><i class="filter"></i>Advance Filters</a></div>
                    </div>
                </div>
            </div>
            <div class="filter-section">
                <div class="full-col filter-top">
                    <div class="container">
                        <div class="filter-l-info">
                            <ul id="filter-list">

                            </ul>
                            <h3>Price Range   AED <span id="minimum_price_span"></span> - AED <span id="maximum_price_span"></span> <a href="#" class="filter"  id="clear-filters">Clear Filters</a></h3>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="full-col filter-main">
                        <div class="full-col">
                            @if(count($food_types) > 0)
                                <div class="col-sm-4 check-cata">
                                    <h3>Cuisine/Food Menu</h3>
                                    @foreach($food_types as $food_type)
                                        <div class="form-group form-check col-xs-6">
                                            <input type="checkbox" class="filter-checkboxes food_checkboxes" value="{{$food_type->title}}" id="food{{$food_type->id}}" onchange="get_food_checks()">
                                            <label for="food{{$food_type->id}}">{{$food_type->title}}</label>
                                        </div>
                                    @endforeach

                                    <input type="hidden" name="food_checkboxes_arr" value="" id="food_checkboxes_arr">
                                </div><!-- check-cata fade-left-anigory -->
                            @endif
                            <div class="col-sm-4 check-cata">
                                <h3>Space Type</h3>
                                @foreach($space_types as $space_type)
                                    <div class="form-group form-check col-xs-6">
                                        <input type="checkbox" class="filter-checkboxes spacetype_checkboxes" value="{{$space_type->title}}" id="space_type{{$space_type->id}}" onchange="get_spacetype_checks()">
                                        <label for="space_type{{$space_type->id}}">{{$space_type->title}}</label>
                                    </div>
                                @endforeach

                                <input type="hidden" name="spacetype_checkboxes_arr" value="" id="spacetype_checkboxes_arr">
                            </div><!-- check-cata fade-left-anigory -->
                            <div class="col-sm-4 check-cata">
                                <h3>Amenities</h3>
                                @foreach($amenities as $amenity)
                                    <div class="form-group form-check col-xs-6">
                                        <input type="checkbox" class="filter-checkboxes amenities_checkboxes" value="{{$amenity->name}}" id="amenities{{$amenity->id}}" onchange="get_amenities_checks()">
                                        <label for="amenities{{$amenity->id}}">{{$amenity->name}}</label>
                                    </div>
                                @endforeach

                                <input type="hidden" name="amenities_checkboxes_arr" value="" id="amenities_checkboxes_arr">

                            </div><!-- check-cata fade-left-anigory -->
                        </div>
                        <div class="full-col">
                            <div class="col-sm-2 check-cata">
                                <h3>Accessibility</h3>
                                @foreach($accessibilities as $accessibility)
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="filter-checkboxes accessibility_checkboxes" value="{{$accessibility->name}}" id="accessibility{{$accessibility->id}}" onchange="get_accessibility_checks()">
                                        <label for="accessibility{{$accessibility->id}}">{{$accessibility->name}}</label>
                                    </div>
                                @endforeach

                                <input type="hidden" name="accessibility_checkboxes_arr" value="" id="accessibility_checkboxes_arr">
                            </div><!-- check-cata fade-left-anigory -->
                            <div class="col-sm-2 check-cata">
                                <h3>Rating</h3>
                                {{--<div class="form-group form-check">--}}
                                {{--<input type="checkbox" class="filter-checkboxes star_checkboxes" value="3" id="3_star" onchange="get_start_checks()">--}}
                                {{--<label for="3_star">Star 3</label>--}}
                                {{--</div>--}}

                                {{--<div class="form-group form-check">--}}
                                {{--<input type="checkbox" class="filter-checkboxes star_checkboxes" value="4" id="4_star" onchange="get_start_checks()">--}}
                                {{--<label for="4_star">Star 4</label>--}}
                                {{--</div>--}}

                                {{--<div class="form-group form-check">--}}
                                {{--<input type="checkbox" class="filter-checkboxes star_checkboxes" value="5" id="5_star" onchange="get_start_checks()">--}}
                                {{--<label for="5_star">Star 5</label>--}}
                                {{--</div>--}}

                                <div class="form-group form-rating ">
                                    <select id="stardropdown1">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <span>to</span>
                                    <select id="stardropdown2">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>


                                <input type="hidden" name="star_checkboxes_arr" value="" id="star_checkboxes_arr">
                            </div><!-- check-cata fade-left-anigory -->
                            <div class="col-sm-4 check-cata">
                                <h3>Seating Arrangement</h3>
                                @foreach($seating_plans as $seating_plan)
                                    <div class="form-group form-check col-sm-6">
                                        <input type="checkbox" class="filter-checkboxes seating_arrangement_checkboxes" data-imgsrc="{{url('storage/images/sitting-plan/'.$seating_plan->image)}}" id="seating_plan{{$seating_plan->id}}" value="{{$seating_plan->title}}" onchange="get_seating_arrangement_checks()">
                                        <label for="seating_plan{{$seating_plan->id}}"><img src="{{url('storage/images/sitting-plan/'.$seating_plan->image)}}"></label>
                                    </div>
                                @endforeach

                                <input type="hidden" name="seating_arrangement_checkboxes_arr" value="" id="seating_arrangement_checkboxes_arr">
                            </div><!-- check-cata fade-left-anigory -->
                            <div class="col-sm-4 check-cata">
                                <h3>Price Range</h3>
                                <div class="price-range-slider">
                                    <p class="range-value">
                                        <input type="text" name="price_range" id="amount" readonly>
                                        <input type="hidden" name="minimum_price" value="130" id="minimum_price">
                                        <input type="hidden" name="maximum_price" value="500" id="maximum_price">
                                    </p>
                                    <div id="slider-range" class="range-bar"></div>
                                </div>
                            </div><!-- check-cata fade-left-anigory -->
                            <div class="fliter-close"><a class="fliter-close-btn" id="close_filter">Close</a></div>
                        </div>
                    </div>
                </div><!--container-->
                <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
        </form>
    </section>



    <!--Top Rated Section-->
    <section class="rated-section rated-detail-section venue-listing">
        <div class="container">
            <div class="show-wraper">
                <p class="show-result">Showing <span id="venue_count">{{count($venues)}}</span> results</p>
                <select id="orderby" class="sort" onchange="changeOrderBy()">
                    <option disabled selected>Sort by</option>
                    <option value="asc">Accending Order</option>
                    <option value="desc">Deccending Order</option>
                </select>
                <div class=" filter-r-info meeting-toggle">
                    <h4>Show Map</h4>
                    <button type="button" class="btn btn-toggle" id="btn-toggle" data-toggle="button" aria-pressed="false" autocomplete="off">
                        <div class="handle"></div>
                    </button>
                </div>
            </div>
            <div class="row main-row gride">
                <div class="meeting-map col-sm-3 col-menu">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d13602.226435225284!2d74.3441274197754!3d31.536335749999992!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1532931843350" width="100%" height="700" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <div class="meeting-leftside col-cards col-sm-9">
                    <div class="venuelist-wrap row-cards" id="searched_venues">
                        @if(count($venues) > 0)
                            @foreach($venues as $venue)
                                <form action="{{url('venue/'.$venue->slug)}}" method="post" id="filter_space_form_{{$venue->id}}">
                                    @csrf
                                    <input type="hidden" name="venue_id" value="{{$venue->id}}">
                                    <input type="hidden" name="people" value="{{isset($people) ? $people : ''}}">
                                    <input type="hidden" name="duration" value="{{isset($duration) ? $duration : ''}}">
                                    <input type="hidden" name="start_date" value="{{isset($start_date) ? $start_date : ''}}">
                                    <input type="hidden" name="end_date" value="{{isset($end_date) ? $end_date : ''}}">
                                    <div class="rated-box col-xs-3 col-card col-4 active" id="filter_space_form_{{$venue->id}}" onclick="submitSpaceForm(this.id)" >
                                {{--<div class="rated-box col-xs-3 col-card col-4 active" onclick="location.href='{{url('venue/'.$venue->slug)}}';" >--}}

                                <figure>
                                            <img src="{{url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image)}}" alt="" />
                                            @if($venue->top_rate == 1)
                                                <div class="top-rate">
                                                    <img src="{{url('images/ribben.png')}}" alt=""/>
                                                </div>
                                            @endif
                                        </figure>
                                        <div class="rated-box-info">
                                            @if($venue->verified == 1)
                                                <h3>Verified by Conpherence</h3>
                                            @endif
                                            <h2>{{$venue->title}}</h2>
                                            <h4>{{$venue->city}}</h4>
                                            {{--<ul>--}}
                                            {{--<li>Free Cancellation</li>--}}
                                            {{--</ul>--}}
                                            @php
                                                $averge = ($venue->reviews/5)*100;
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
                                </form>
                            @endforeach
                        @else
                            <div class="dash-box-inner dash-pay-inner" id="credit_cards">
                                <div class="pay-inner-card">
                                    <div class="dash-pay-gray">
                                        No Venue added yet.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div><!--main-row-->
        </div>
        <div class="clearfix"></div>
    </section>

    <section class="pagination-section">
        <div class="container">
            {{ $venues->links() }}
        </div>
        <div class="clearfix"></div>
    </section>
@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')
    {{--<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js'></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-viewport-checker/1.8.8/jquery.viewportchecker.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>--}}
    {{--<script async src="//jsfiddle.net/nanoquantumtech/Ddnuh/embed/"></script>--}}
    <script>
        // $(document).ready(function () {
        //     // durationpicker
        //     // $('#durationpicker').val();
        //
        //     console.log($('#durationpicker').val());
        //     checkDays($('#durationpicker').val());
        // });

        function submitSpaceForm(id) {
            $("#"+id).submit();
        }

        function checkDays(value) {
            if(value === 'More than one day')
            {
                $('#search_banner').addClass('extened-venu');
            } else {
                $('#search_banner').removeClass('extened-venu');
                $('#end-date').val(null);
            }
            $("#filer_venue_form").submit();
        }

        function changeOrderBy()
        {
            $("#orderby_input").val($("#orderby").val());
            submitForm();
        }

        function submitForm()
        {
            $("#filer_venue_form").submit();
        }

        //filters
        $(document).ready(function () {
            //Filters-handling fro checkboxes
            $(".filter-checkboxes").on('change',function(){
                var checkboxId = $(this).attr('id');
                var wrapper = "#li-"+checkboxId;
                var checkboxText =  $(this).next('label').text();
                var sit_plans = '';
                if($(this).attr('data-imgsrc') !== undefined){
                    sit_plans = $(this).attr('data-imgsrc');
                }
                if($(this).is(":checked")) {
                    if (sit_plans !== '') {
                        $("#filter-list").append('<li id="li-'+checkboxId+'"><a href="#"><img src="'+sit_plans+'"><span class="remove-self-filter" data-checkbox="'+checkboxId+'">x</span></a></li>');
                    }else{
                        $("#filter-list").append('<li id="li-'+checkboxId+'"><a href="#">'+checkboxText+'<span class="remove-self-filter" data-checkbox="'+checkboxId+'">x</span></a></li>');
                    }
                }
                else
                    $(wrapper).remove();
            });

            $("#clear-filters").on('click',function(){

                $("#filter-list").html('');
                $(".filter-checkboxes").prop('checked', false);

                $("#stardropdown1").html('<option value="1">1</option>' +
                    '                                        <option value="2">2</option>' +
                    '                                        <option value="3">3</option>' +
                    '                                        <option value="4">4</option>' +
                    '                                        <option value="5">5</option>');
                $("#stardropdown2").html('<option value="1">1</option>' +
                    '                                        <option value="2">2</option>' +
                    '                                        <option value="3">3</option>' +
                    '                                        <option value="4">4</option>' +
                    '                                        <option value="5">5</option>');

            });

            jQuery("#close_filter").click(function() {
                jQuery(".ani-btn a").removeClass("active") ;
                jQuery('.filter-main').removeClass("open");
            });
        });


        function get_food_checks() {
            $('#food_checkboxes_arr').val($('.food_checkboxes:checked').map(function() {
                return this.value;
            }).get().join(','));

            $("#filer_venue_form").submit();
        }

        function get_spacetype_checks() {
            $('#spacetype_checkboxes_arr').val($('.spacetype_checkboxes:checked').map(function() {
                return this.value;
            }).get().join(','));

            $("#filer_venue_form").submit();
        }

        function get_amenities_checks() {
            $('#amenities_checkboxes_arr').val($('.amenities_checkboxes:checked').map(function() {
                return this.value;
            }).get().join(','));

            $("#filer_venue_form").submit();
        }

        function get_accessibility_checks() {
            $('#accessibility_checkboxes_arr').val($('.accessibility_checkboxes:checked').map(function() {
                return this.value;
            }).get().join(','));

            $("#filer_venue_form").submit();
        }

        // function get_start_checks() {
        //     $('#star_checkboxes_arr').val($('.star_checkboxes:checked').map(function() {
        //         return this.value;
        //     }).get().join(','));
        //
        //     $("#filer_venue_form").submit();
        // }

        $("#stardropdown1").change(function() {
            var value = $("option:selected", this).val();

            $('#stardropdown2').html('');

            for (var count = parseInt(value); count < 6; count++) {
                $('#stardropdown2').append($('<option>',
                    {
                        value: count,
                        text: count
                    }));

            }
            get_stars();
        });

        $("#stardropdown2").change(function() {
            get_stars();
        });

        function get_stars() {
            var value1 = $('#stardropdown1').find(":selected").text();
            var value2 = $('#stardropdown2').find(":selected").text();
            var text = '';

            for (var count = value1; count <= value2; count++) {

                if (count == parseInt(value2))
                {
                    text += count;
                } else {
                    text += count + ',';
                }

            }

            $('#star_checkboxes_arr').val(text);
            $("#filer_venue_form").submit();
        }

        function get_seating_arrangement_checks() {
            $('#seating_arrangement_checkboxes_arr').val($('.seating_arrangement_checkboxes:checked').map(function() {
                return this.value;
            }).get().join(','));

            $("#filer_venue_form").submit();
        }

        // function submitForm() {
        //
        //     $("#filer_venue_form").submit();
        // var food_checkboxes_arr = $('#food_checkboxes_arr').val();
        // var spacetype_checkboxes_arr = $('#spacetype_checkboxes_arr').val();
        // var amenities_checkboxes_arr = $('#amenities_checkboxes_arr').val();
        // var accessibility_checkboxes_arr = $('#accessibility_checkboxes_arr').val();
        // var star_checkboxes_arr = $('#star_checkboxes_arr').val();

        // console.log(selected);
        // $("#"+id).submit();
        // }

        $("#filer_venue_form").validate({
            rules: {
                location: {
                    required: true,
                },
                people: {
                    required: true,
                }
            },
            messages: {
                location: {
                    required: "Please select a Location first",
                },
                people: {
                    required: "Attendees is Required",
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'GET',
                    data: $('#filer_venue_form').serialize(),
                    url: '{{url('/venues/search/filter')}}',
                    success: function (response) {

                        console.log(response);
                        $('#searched_venues').html(response.data);
                        $('#venue_count').html(response.count);
                    }
                });
            }
        });


    </script>
@endsection




