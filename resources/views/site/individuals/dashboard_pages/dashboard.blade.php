@extends('site.layouts.app')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
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
                    @include('site.individuals.dashboard_nev',['active_dashboard' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active" id="dashboard">
                    <div class="welcome-title full-col">
                        <h2>Dashboard</h2>
                        <h3>Welcome {{auth()->user()->name}}</h3>
                    </div>
                    <div class="dashboard-calender col-sm-5">
                        <h3 class="dashboard-title">Upcoming Meetings</h3>
                        <div class="calender">
                            <ul class="month">
                                <li>
                                    <h1>January</h1>
                                    <h2>2016</h2>
                                </li>
                                <span class="prev">&#10094;</span>
                                <span class="next">&#10095;</span>
                            </ul>
                            <ul class="weeks">
                                <li>Sa</li>
                                <li>Su</li>
                                <li>Mo</li>
                                <li>Tu</li>
                                <li>We</li>
                                <li>Th</li>
                                <li>Fr</li>
                            </ul>
                            <ul class="days">

                            </ul>
                        </div>

                    </div><!-- Calender -->
                    <div class="dashboard-map col-sm-7">
                        <h3 class="dashboard-title">Your Bookings</h3>
                        <div id="map" class="mapwrap"></div>
                        {{--<div class="dash-label">--}}
                        {{--<div class="dash-label-left">--}}
                        {{--<h3>Khalidiya Palace Rayhaan</h3>--}}
                        {{--<h4>Westbourne Suite<span>Abu Dhabi</span></h4>--}}
                        {{--</div>--}}
                        {{--<div class="dash-label-right">--}}
                        {{--<h3>5<i class="star">★★★★★</i></h3>--}}
                        {{--<h4>15 Reviews<img src="{{url('images/bar.png')}}" alt=""/></h4>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    </div><!-- map -->
                    <div class="dashboard-review col-sm-8">
                        <h3 class="dashboard-title">Your Recent Reviews</h3>
                        @if(count($reviews) > 0)
                            <div id="slider" class="review-rightslider">
                                @foreach($reviews as $key=>$review)
                                    @php
                                        $bookinginfo = $review->bookinginfo;
                                        $space = $review->space;
                                        $venue = $space->venue;
                                    @endphp
                                    <div data-card="{{$key}}" class="review-card">
                                        <div class="dash-review-box">
                                            <div class="dash-review-box-img">
                                                <img src="{{url('images/booking-img.png')}}" alt="" />
                                            </div>
                                            <div class="dash-review-box-info">
                                                <div class="dash-review-left col-sm-7">
                                                    <h4>{{$venue->title}}</h4>
                                                    <h3>{{$space->title}}<span>{{$venue->city}}</span></h3>
                                                </div>
                                                <div class="dash-review-right col-sm-5">
                                                    <h4>{{$bookinginfo->purpose}}</h4>
                                                    <p>{{date('d-M-Y' , strtotime($bookinginfo->created_at))}}</p>
                                                </div>
                                                <div class="dash-review-inner col-sm-12">
                                                    <p>{{$review->feedback}}</p>
                                                    <ul>
                                                        <li>
                                                            <span>Customer Service</span>
                                                            <i class="star">
                                                                @if($review->customer_service_rate == '1') <span class="active-start">★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                                                @elseif($review->customer_service_rate == '2') <span class="active-start">★</span><span class="active-start">★</span><span>★</span><span>★</span><span>★</span>
                                                                @elseif($review->customer_service_rate == '3') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span ><span>★</span><span>★</span>
                                                                @elseif($review->customer_service_rate == '4') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span>★</span>
                                                                @elseif($review->customer_service_rate == '5') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span>
                                                                @endif
                                                            </i>
                                                        </li>
                                                        <li>
                                                            <span>Equipment</span>
                                                            <i class="star1">
                                                                @if($review->amenities_rate == '1') <span class="active-start">★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                                                @elseif($review->amenities_rate == '2') <span class="active-start">★</span><span class="active-start">★</span><span>★</span><span>★</span><span>★</span>
                                                                @elseif($review->amenities_rate == '3') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span ><span>★</span><span>★</span>
                                                                @elseif($review->amenities_rate == '4') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span>★</span>
                                                                @elseif($review->amenities_rate == '5') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span>
                                                                @endif
                                                            </i>                                                </li>
                                                        <li>
                                                            <span>Meeting Facilities</span>
                                                            <i class="star">
                                                                @if($review->meeting_facility_rate == '1') <span class="active-start">★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                                                @elseif($review->meeting_facility_rate == '2') <span class="active-start">★</span><span class="active-start">★</span><span>★</span><span>★</span><span>★</span>
                                                                @elseif($review->meeting_facility_rate == '3') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span ><span>★</span><span>★</span>
                                                                @elseif($review->meeting_facility_rate == '4') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span>★</span>
                                                                @elseif($review->meeting_facility_rate == '5') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span>
                                                                @endif
                                                            </i>                                                </li>
                                                        <li>
                                                            <span>Food</span>
                                                            <i class="star">
                                                                @if($review->food_rate == '1') <span class="active-start">★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                                                                @elseif($review->food_rate == '2') <span class="active-start">★</span><span class="active-start">★</span><span>★</span><span>★</span><span>★</span>
                                                                @elseif($review->food_rate == '3') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span ><span>★</span><span>★</span>
                                                                @elseif($review->food_rate == '4') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span>★</span>
                                                                @elseif($review->food_rate == '5') <span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span><span class="active-start">★</span>
                                                                @endif
                                                            </i>                                                </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div><!--slider-->
                        @else
                            <h5 style="padding-left: 10%;" class="dashboard-title">No Reviews added yet.</h5>
                        @endif
                    </div>
                    <div class="dashboard-reward col-sm-4">
                        <h3 class="dashboard-title">You’ve The {{$badge}} Badge</h3>
                        <div class="dash-box-inner dash-earncard-box">
                            @if($badge == 'Platinum')
                                <img src="{{url('images/platinum.png')}}" alt="" />
                                <h4>Platinum Badge</h4>
                            @elseif($badge == 'Gold')
                                <img src="{{url('images/gold.png')}}" alt="" />
                                <h4>Gold Badge</h4>
                            @elseif($badge == 'Sliver')
                                <img src="{{url('images/silver.png')}}" alt="" />
                                <h4>Silver Badge</h4>
                            @elseif($badge == 'Classic')
                                <img src="{{url('images/clasic.png')}}" alt="" />
                                <h4>Classic Badge</h4>
                            @endif

                            <div class="progress">
                                <div class="progress-bar dash-bar-clasic" role="progressbar" style="width:25%">
                                    <span>Classic</span>
                                </div>
                                @php
                                    $sliver_bar = '';
                                        if($badge == 'Sliver' || $badge == 'Gold'  || $badge == 'Platinum')
                                        {
                                            $sliver_bar = 'dash-bar-silver';
                                        }
                                @endphp

                                <div class="progress-bar {{$sliver_bar}}" role="progressbar" style="width:50%">
                                    <span>Silver</span>
                                </div>

                                @php
                                    $gold_bar = '';
                                        if($badge == 'Gold' || $badge == 'Platinum')
                                        {
                                            $gold_bar = 'dash-bar-gold';
                                        }
                                @endphp
                                <div class="progress-bar {{$gold_bar}}" role="progressbar" style="width:51%">
                                    <span>Gold</span>
                                </div>

                                @php
                                    $platinum_bar = '';
                                        if($badge == 'Platinum')
                                        {
                                            $platinum_bar = 'dash-bar-platinum';
                                        }
                                @endphp
                                <div class="progress-bar {{$platinum_bar}}" role="progressbar" style="width:76%">
                                    <span>Platinum</span>
                                </div>
                            </div>
                        </div>
                        {{--<h3 class="dashboard-title">You’ve Earned Points</h3>--}}
                        {{--<div class="reward-box">--}}
                            {{--<img src="{{url('images/cheer.png')}}" alt="" />--}}
                            {{--<h4>Congratulations Nadeem</h4>--}}
                            {{--<p>You’ve got 208 points in this month.book more new places and earn more points and get discount.</p>--}}
                        {{--</div>--}}

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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
@section('scripts')
    @include('site.layouts.scripts')
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
                icon: base_url+'/images/locator1.png'
            });

        }
    </script>

    <script type="text/javascript">
        (function() {
            var rotate, timeline;

            rotate = function() {
                return $('.review-card:first-child').fadeOut(400, 'swing', function() {
                    return $('.review-card:first-child').appendTo('.review-rightslider').hide();
                }).fadeIn(400, 'swing');
            };

            timeline = setInterval(rotate, 10000);

            $('.dashboard-review').hover(function() {
                return clearInterval(timeline);
            });

            $('.review-card').click(function() {
                return rotate();
            });

        }).call(this);
    </script>



    <script type="text/javascript">
        var booking_dates = [];
        var booking_dates = <?php echo json_encode($date); ?>;
        var bookings = <?php echo json_encode($bookings); ?>;
        var bookingsLength = bookings.length;

        // console.log(bookings);

        /*global console*/
        //calender
        //month
        //prev
        //next
        //weeks
        //days

        //punblic variables
        var calender = document.querySelector(".calender"),//container of calender
            topDiv = document.querySelector('.month'),
            monthDiv = calender.querySelector("h1"),//h1 of monthes
            yearDiv = calender.querySelector('h2'),//h2 for years
            weekDiv = calender.querySelector(".weeks"),//week container
            dayNames = weekDiv.querySelectorAll("li"),//dayes name
            dayItems = calender.querySelector(".days"),//date of day container
            prev = calender.querySelector(".prev"),
            next = calender.querySelector(".next"),

            // date variables
            years = new Date().getFullYear(),
            monthes = new Date(new Date().setFullYear(years)).getMonth(),
            lastDayOfMonth = new Date(new Date(new Date().setMonth(monthes + 1)).setDate(0)).getDate(),
            dayOfFirstDateOfMonth = new Date(new Date(new Date().setMonth(monthes)).setDate(1)).getDay(),

            // array to define name of monthes
            monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"],
            //colors = ['#FFA549', '#ABABAB', '#1DABB8', '#953163', '#E7DF86', '#E01931', '#92F22A', '#FEC606', '#563D28', '#9E58DC', '#48AD01', '#0EBB9F'],
            i,//counter for day before month first day in week
            x,//counter for prev , next
            counter;//counter for day of month  days;


        //display dayes of month in items
        function days(x) {
            'use strict';
            dayItems.innerHTML = "";
            monthes = monthes + x;

            /////////////////////////////////////////////////
            //test for last month useful while prev ,max prevent go over array
            if (monthes > 11) {
                years = years + 1;
                monthes = new Date(new Date(new Date().setFullYear(years)).setMonth(0)).getMonth();//
            }
            if (monthes < 0) {
                years = years - 1;
                monthes = new Date(new Date(new Date().setFullYear(years)).setMonth(11)).getMonth();//
            }
            //next,prev
            lastDayOfMonth = new Date(new Date(new Date(new Date().setFullYear(years)).setMonth(monthes + 1)).setDate(0)).getDate();//اخر يوم فى الشهر
            dayOfFirstDateOfMonth = new Date(new Date(new Date(new Date().setFullYear(years)).setMonth(monthes)).setDate(1)).getDay();//بداية الشهر فى اى يوم من ايام الاسبوع؟
            /////////////////////////////////////////////////
            yearDiv.innerHTML = years;
            monthDiv.innerHTML = monthNames[monthes];
            for (i = 0; i <= dayOfFirstDateOfMonth; i = i + 1) {
                if (dayOfFirstDateOfMonth === 6) { break; }
                dayItems.innerHTML += "<li>  </li>";
            }
            for (counter = 1; counter <= lastDayOfMonth; counter = counter + 1) {
                // dayItems.innerHTML += "<li>" + "<span>" + (counter) + "</span>" + "</li>";
                var month = monthes+1;
                const counter_date = years+'-'+month+'-'+counter;

                if(booking_dates.includes(counter_date))
                {
                    var popup = '';
                    var count_inn = 0;
                    popup += '<div class="dash-label">';
                    for (let k = 0; k < bookingsLength; k++)
                    {
                        if(bookings[k]['start_date'] === counter_date)
                        {
                            count_inn = count_inn+1;
                            var total_average_percentage = (parseInt(bookings[k]['space_reviews_avg'])/5) * 100;

                             popup += '<div class="full-col">' +
                                '<div class="dash-label-left">' +
                                '<h3>'+bookings[k]['venue_title']+'</h3>' +
                                '<h4>'+bookings[k]['space_title']+'<span>'+bookings[k]['venue_city']+'</span></h4>' +
                                '</div>'+
                                '<div class="dash-label-right">' +
                                // '<h3>'+bookings[k]['space_reviews_avg']+'<i class="star">★★★★★</i></h3>' +
                                '<h3><i style="display: block;font-style:normal;">'+bookings[k]['space_reviews_avg']+'</i>' +
                                '<div class="star-ratings-css">' +
                                '<div class="star-ratings-css-top" style="width:'+total_average_percentage+'%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>' +
                                '<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>' +
                                '</div>' +
                                '</h3>' +
                                '<h4 style="color: #302f2f">'+bookings[k]['space_reviews_count']+' Reviews<img src="'+base_url+'/images/bar.png" alt=""/></h4>' +
                                '</div>' +
                                '</div>';

                            if(count_inn === 4)
                             {
                                count_inn = 0;
                                 popup += '<div class="full-col dash-label-btn">'+
                                     '<a href="{{route('user.dashboard.bookings')}}" class="ani-btn btn">View all</a>'+
                                       ' </div>';
                                     break;
                             }
                        }
                    }

                    popup +=  '</div>';

                    dayItems.innerHTML += "<li>" + "<div class='active-event'>" + (counter) + popup +"</div>" + "</li>";

                } else {
                    dayItems.innerHTML += "<li>" + "<span>" + (counter) + "</span>" + "</li>";
                }

            }
            // topDiv.style.background = colors[monthes];
            // dayItems.style.background = colors[monthes];
            //
            // if (monthes === new Date().getMonth() && years === new Date().getFullYear()) {
            //     dayItems.children[new Date().getDate() + dayOfFirstDateOfMonth].style.background = "#2ecc71";
            // }
        }
        prev.onclick = function () {
            'use strict';
            days(-1);//decrement monthes
        };
        next.onclick = function () {
            'use strict';
            days(1);//increment monthes
        };
        days(0);

        //end
    </script>
@endsection
