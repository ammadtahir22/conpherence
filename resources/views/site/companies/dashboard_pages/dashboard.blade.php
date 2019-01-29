@extends('site.layouts.app')

@section('head')
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />--}}
    {{--<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>--}}
    <style>
        .canvasjs-chart-credit{
            display: none;
        }
    </style>
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
                    @include('site.companies.dashboard_nev',['active_dashboard' => "active"])
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
                        <div id="chartContainer" style="height: 290px; width: 100%;"></div>
                        {{--<div id="map" class="mapwrap"></div>--}}
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
                    <!-- <div class="dash-review-box">
                            <div class="dash-review-box-img">
                                <img src="images/booking-img.png" alt="" />
                            </div>
                            <div class="dash-review-box-info">
                                <div class="dash-review-left col-sm-7">
                                    <h4>Khalidiya Palace Rayhaan</h4>
                                    <h3>Westbourne Suite<span>Abu Dhabi</span></h3>
                                </div>
                                <div class="dash-review-right col-sm-5">
                                    <h4>Lorem Ipsum is simply</h4>
                                    <p>2 July 2018</p>
                                </div>
                                <div class="dash-review-inner col-sm-12">
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s Lorem Ipsum is simply dummy text of the printing and typesetting industry. the industry's standard dummy text ever since the 1500s </p>
                                    <ul>
                                        <li>
                                            <span>Customer Service</span><i class="star"><span class="active-start">★</span><span>★</span><span>★</span><span>★</span><span>★</span></i>
                                        </li>
                                        <li>
                                            <span>Equipment</span><i class="star"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></i>
                                        </li>
                                        <li>
                                            <span>Meeting Facilities</span><i class="star"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></i>
                                        </li>
                                        <li>
                                            <span>Food</span><i class="star"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></i>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="dashboard-reward col-sm-4">
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

    <!--Delete popup-->
    <div class="modal fade card-popup" id="delpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <!-- <h3>Delete Payment Method</h3> -->
                    <p style="text-align: center;"> Are you sure you want delete it</p>
                    <form id="delete_space_form">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" id="delete_venue_id">
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
<script src="{{url('js/canvasjs.min.js')}}"></script>

@section('scripts')
    @include('site.layouts.scripts')
    <script>
        var dataPoints = [];
        // array to define name of monthes
        monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
        var currentDate       = new Date();
        var thisMonth = monthNames[currentDate.getMonth()];
         // $(function () {
             CanvasJS.addColorSet("pickShades",
                 [//colorSet Array
                     "#b11f5f"
                 ]);
             //Better to construct options first and then pass it as a parameter
             var chart = new CanvasJS.Chart("chartContainer", {
                 animationEnabled: true,
                 theme: "light2",

                 title: {
                     text: thisMonth+ " Bookings"
                 },
                 colorSet: "pickShades",
                 exportEnabled: true,
                 axisX: {
                     title: "Date"
                 },
                 axisY: {
                     title: "Booking - Count",
                     titleFontColor: "#b11f5f",
                     lineColor: "#b11f5f",
                     labelFontColor: "#b11f5f",
                     tickColor: "#b11f5f"
                 },
                 data: [
                     {
                         type: "column", //change it to line, area, column, pie, etc
                         yValueFormatString: "#,### Bookings",
                         dataPoints: dataPoints
                     }
                 ]
             });

         $.getJSON("{{url('company/dashboard/chart/data')}}", addData);
         function addData(data) {
             for (var i = 0; i < data.length; i++) {
                 dataPoints.push({
                     x: new Date(data[i].date),
                     y: data[i].count
                 });
             }
             console.log(dataPoints);
             chart.render();
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
                                '<a href="{{route('company.dashboard.bookings')}}" class="ani-btn btn">View all</a>'+
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