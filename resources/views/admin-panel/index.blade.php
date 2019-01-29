@extends('admin-panel.layouts.app')

@section('css-link')
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/style.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{url('css/admin-panel/morris.css')}}">
@endsection

{{--@section('header')--}}
{{----}}
{{--@endsection--}}

@section('left-panel')
    @include('admin-panel.layouts.left-panel')
@endsection

@section('main-panel')
    {{--@include('admin-panel.layouts.main-panel')--}}
    <!-- MAIN PANEL -->
    <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home / Dashboard</li>
            </ol>
            <!-- end breadcrumb -->
        </div>
        <!-- END RIBBON -->

        <!-- MAIN CONTENT -->
        <div id="content">
            {{--<!-- widget grid -->--}}
            {{--<section id="widget-grid" class="">--}}

            {{--<!-- row -->--}}
            {{--<div class="row">--}}

            {{--<!-- NEW WIDGET START -->--}}
            {{--<article class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">--}}

            {{--<!-- Widget ID (each widget will need unique ID)-->--}}
            {{--<div class="jarviswidget" data-widget-colorbutton="false" data-widget-editbutton="falses" data-widget-togglebutton="false" data-widget-fullscreenbutton="false" id="wid-id-0">--}}
            {{--<!-- widget options:--}}
            {{--usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">--}}
            {{--data-widget-colorbutton="false"--}}
            {{--data-widget-editbutton="false"--}}
            {{--data-widget-togglebutton="false"--}}
            {{--data-widget-deletebutton="false"--}}
            {{--data-widget-fullscreenbutton="false"--}}
            {{--data-widget-custombutton="false"--}}
            {{--data-widget-collapsed="true"--}}
            {{--data-widget-sortable="false"--}}
            {{---->--}}
            {{--<header>--}}
            {{--<span class="widget-icon"> <i class="fa fa-briefcase"></i> </span>--}}
            {{--<h2> Bookings </h2>--}}
            {{--</header>--}}
            {{--<!-- widget div-->--}}
            {{--<div>--}}
            {{--<!-- widget content -->--}}
            {{--<div class="widget-body">--}}
            {{--<h2 class="center-block">--}}
            {{--<span class="count"> {{$booking_count}} </span>--}}
            {{--<span> <i class="fa fa-briefcase"></i> </span>--}}
            {{--</h2>--}}

            {{--<div class="show-stat-microcharts">--}}
            {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
            {{--<span class="label label-success"> {{$booking_monthly_growth}}% </span>--}}
            {{--<span class="text-muted"> From previous period</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!-- end widget content -->--}}
            {{--</div>--}}
            {{--<!-- end widget div -->--}}
            {{--</div>--}}
            {{--<!-- end widget -->--}}
            {{--</article>--}}
            {{--<!-- WIDGET END -->--}}
            {{--<!-- NEW WIDGET START -->--}}
            {{--<article class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">--}}

            {{--<!-- Widget ID (each widget will need unique ID)-->--}}
            {{--<div class="jarviswidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-fullscreenbutton="false" id="wid-id-1">--}}
            {{--<!-- widget options:--}}
            {{--usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">--}}

            {{--data-widget-colorbutton="false"--}}
            {{--data-widget-editbutton="false"--}}
            {{--data-widget-togglebutton="false"--}}
            {{--data-widget-deletebutton="false"--}}
            {{--data-widget-fullscreenbutton="false"--}}
            {{--data-widget-custombutton="false"--}}
            {{--data-widget-collapsed="true"--}}
            {{--data-widget-sortable="false"--}}

            {{---->--}}
            {{--<header>--}}
            {{--<span class="widget-icon"> <i class="fa fa-money"></i> </span>--}}
            {{--<h2> REVENUE </h2>--}}
            {{--</header>--}}
            {{--<!-- widget div-->--}}
            {{--<div>--}}
            {{--<!-- widget content -->--}}
            {{--<div class="widget-body">--}}
            {{--<h2 class="center-block">--}}
            {{--AED <span class="count">{{$booking_revenue}}</span>--}}
            {{--AED <span data-plugin="counterup">{{number_format($booking_revenue)}}</span>--}}
            {{--1023--}}
            {{--</h2>--}}
            {{--<div class="show-stat-microcharts">--}}
            {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
            {{--<span class="label label-success"> +11% </span>--}}
            {{--<span class="text-muted"> From previous period</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!-- end widget content -->--}}
            {{--</div>--}}
            {{--<!-- end widget div -->--}}
            {{--</div>--}}
            {{--<!-- end widget -->--}}
            {{--</article>--}}
            {{--<!-- WIDGET END -->--}}
            {{--<!-- NEW WIDGET START -->--}}
            {{--<article class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">--}}

            {{--<!-- Widget ID (each widget will need unique ID)-->--}}
            {{--<div class="jarviswidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-fullscreenbutton="false" id="wid-id-2">--}}
            {{--<!-- widget options:--}}
            {{--usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">--}}

            {{--data-widget-colorbutton="false"--}}
            {{--data-widget-editbutton="false"--}}
            {{--data-widget-togglebutton="false"--}}
            {{--data-widget-deletebutton="false"--}}
            {{--data-widget-fullscreenbutton="false"--}}
            {{--data-widget-custombutton="false"--}}
            {{--data-widget-collapsed="true"--}}
            {{--data-widget-sortable="false"--}}

            {{---->--}}
            {{--<header>--}}
            {{--<span class="widget-icon"> <i class="fa fa-comments"></i> </span>--}}
            {{--<h2> Venues </h2>--}}
            {{--<h2> Venues </h2>--}}
            {{--</header>--}}
            {{--<!-- widget edit box -->--}}
            {{--<div class="jarviswidget-editbox">--}}
            {{--<!-- This area used as dropdown edit box -->--}}
            {{--<input class="form-control" type="text">--}}
            {{--</div>--}}
            {{--<!-- end widget edit box -->--}}
            {{--<!-- widget div-->--}}
            {{--<div>--}}
            {{--<!-- widget content -->--}}
            {{--<div class="widget-body">--}}
            {{--<h2 class="center-block">--}}
            {{--<span class="count">{{$venues_count}}</span>--}}
            {{--1023--}}
            {{--</h2>--}}
            {{--<div class="show-stat-microcharts">--}}
            {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
            {{--<span class="label label-success"> +11% </span>--}}
            {{--<span class="text-muted"> From previous period</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!-- end widget content -->--}}
            {{--</div>--}}
            {{--<!-- end widget div -->--}}
            {{--</div>--}}
            {{--<!-- end widget -->--}}
            {{--</article>--}}
            {{--<!-- WIDGET END -->--}}
            {{--<!-- NEW WIDGET START -->--}}
            {{--<article class="col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">--}}

            {{--<!-- Widget ID (each widget will need unique ID)-->--}}
            {{--<div class="jarviswidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-fullscreenbutton="false" id="wid-id-3">--}}
            {{--<!-- widget options:--}}
            {{--usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">--}}

            {{--data-widget-colorbutton="false"--}}
            {{--data-widget-editbutton="false"--}}
            {{--data-widget-togglebutton="false"--}}
            {{--data-widget-deletebutton="false"--}}
            {{--data-widget-fullscreenbutton="false"--}}
            {{--data-widget-custombutton="false"--}}
            {{--data-widget-collapsed="true"--}}
            {{--data-widget-sortable="false"--}}

            {{---->--}}
            {{--<header>--}}
            {{--<span class="widget-icon"> <i class="fa fa-comments"></i> </span>--}}
            {{--<h2> Spaces </h2>--}}
            {{--</header>--}}
            {{--<!-- widget div-->--}}
            {{--<div>--}}
            {{--<!-- widget content -->--}}
            {{--<div class="widget-body">--}}
            {{--<h2 class="center-block">--}}
            {{--<span class="count">{{$spaces_count}}</span>--}}
            {{--1023--}}
            {{--</h2>--}}
            {{--<div class="show-stat-microcharts">--}}
            {{--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">--}}
            {{--<span class="label label-success"> +11% </span>--}}
            {{--<span class="text-muted"> From previous period</span>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!-- end widget content -->--}}
            {{--</div>--}}
            {{--<!-- end widget div -->--}}
            {{--</div>--}}
            {{--<!-- end widget -->--}}
            {{--</article>--}}
            {{--<!-- WIDGET END -->--}}
            {{--</div>--}}

            {{--<!-- end row -->--}}

            {{--<!-- row -->--}}

            {{--<div class="row">--}}

            {{--<!-- a blank row to get started -->--}}
            {{--<div class="col-sm-12">--}}
            {{--<!-- your contents here -->--}}
            {{--</div>--}}

            {{--</div>--}}

            {{--<!-- end row -->--}}

            {{--</section>--}}
            {{--<!-- end widget grid -->--}}

            <div class="wrappers">
                <div class="container">

                    <!-- Page-Title -->
                    {{--<div class="row">--}}
                    {{--<div class="col-sm-12">--}}
                    {{--<h4 class="page-title">Dashboard</h4>--}}
                    {{--</div>--}}
                    {{--</div>--}}


                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fa fa-briefcase pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Bookings</h6>
                                <h2 class="m-b-20" data-plugin="counterup">{{number_format($booking_count)}}</h2>
                                <span class="label label-success"> {{$booking_monthly_growth}}% </span> <span class="text-muted">From previous period</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fa fa-money pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Revenue</h6>
                                <h2 class="m-b-20">AED <span data-plugin="counterup">{{number_format($booking_revenue)}}</span></h2>
                                <span class="label label-danger"> {{$booking_revenue_monthly_growth}}% </span> <span class="text-muted">From previous period</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fa fa-building pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20"> Venues </h6>
                                <h2 class="m-b-20"><span data-plugin="counterup">{{number_format($venues_count)}}</span></h2>
                                <span class="label label-pink"> {{$venue_monthly_growth}}% </span> <span class="text-muted">From previous period</span>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                            <div class="card-box tilebox-one">
                                <i class="fa fa-home pull-xs-right text-muted"></i>
                                <h6 class="text-muted text-uppercase m-b-20">Spaces</h6>
                                <h2 class="m-b-20" data-plugin="counterup">{{number_format($spaces_count)}}</h2>
                                <span class="label label-warning"> {{$spaces_monthly_growth}}% </span> <span class="text-muted">From previous period</span>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                    <div class="row">
                        <div class="col-xs-12 col-lg-12 col-xl-8">
                            <div class="card-box">

                                <h4 class="header-title m-t-0 m-b-20">Statistics</h4>

                                <div class="text-xs-center">
                                    <ul class="list-inline chart-detail-list m-b-0">
                                        <li class="list-inline-item">
                                            <h6 style="color: #1bb99a;"><i class="fa fa-money"></i> Booking</h6>
                                        </li>
                                    </ul>
                                </div>

                                <div id="sales_line_bar" style="height: 320px;"></div>

                            </div>
                        </div><!-- end col-->

                        <div class="col-xs-12 col-lg-12 col-xl-4">
                            <div class="card-box">

                                <h4 class="header-title m-t-0 m-b-30">Bookings</h4>

                                <div class="text-xs-center m-b-20">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button id="PieChartAll" type="button" class="btn btn-sm btn-secondary showSingle" data-value="1">All Time</button>
                                        <button id="PieChartThis" type="button" class="btn btn-sm btn-secondary showSingle" data-value="2">This Week</button>
                                        <button id="PieChartLast" type="button" class="btn btn-sm btn-secondary showSingle" data-value="3">Last Week</button>
                                    </div>
                                </div>

                                <div id="booking_donut_chart1" class="targetDiv" style="height: 263px;"></div>
                                <div id="booking_donut_chart2" class="targetDiv" style="height: 263px;"></div>
                                <div id="booking_donut_chart3" class="targetDiv" style="height: 263px;"></div>

                                <div class="text-xs-center">
                                    <ul class="list-inline chart-detail-list m-b-0">
                                        <li class="list-inline-item">
                                            <h6 style="color: #9261c6;"><i class="fa fa-briefcase m-r-5"></i>Approved</h6>
                                        </li>
                                        <li class="list-inline-item">
                                            <h6 style="color: #f1b53d;"><i class="fa fa-briefcase m-r-5"></i>Pending</h6>
                                        </li>
                                        <li class="list-inline-item">
                                            <h6 style="color: #ff5d48;"><i class="fa fa-briefcase m-r-5"></i>Cancelled</h6>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div><!-- end col-->


                    </div>
                    <!-- end row -->


                    <div class="row">
                        <div class="col-xs-12 col-lg-12 col-xl-7">
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="card-box">
                                        <h4 class="header-title m-t-0 m-b-20">LATEST BOOKINGS</h4>

                                        <div class="inbox-widget nicescroll" style="height: 320px; overflow: hidden; outline: none;">
                                            @forelse($latest_bookings as $l_bookings)
                                                <a href="{{url('admin/booking/all')}}">
                                                    <div class="inbox-item">
                                                        <div class="inbox-item-img"><img src="{{get_space_cover($l_bookings['space_id'])}}" class="img-circle" alt=""></div>
                                                        <p class="inbox-item-author">{{get_space_title($l_bookings['space_id'])}}</p>
                                                        <p class="inbox-item-text">{{substr($l_bookings['purpose'],0, 20)}} ...</p>
                                                        <p class="inbox-item-date" style="text-transform: uppercase;">{{$l_bookings->created_at->format('H:i a')}}</p>
                                                    </div>
                                                </a>
                                            @empty
                                                <a href="#">
                                                    <div class="inbox-item">
                                                        <div class="inbox-item-img"><img src="{{url('images/edit-profile-iconh.png')}}" class="img-circle" alt=""></div>
                                                        <p class="inbox-item-author">No Booking added</p>
                                                        <p class="inbox-item-text"></p>
                                                    </div>
                                                </a>
                                            @endforelse
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-6">
                                    <div class="card-box">
                                        <p class="font-600 m-b-5" style="text-transform: uppercase;">Platinum Users<span class="text-danger pull-right"><b>{{$platinum_p}}%</b></span></p>
                                        <progress class="progress progress-striped progress-xs progress-danger m-b-0" value="{{$platinum_p}}" max="100">{{$platinum_p}}%
                                        </progress>
                                    </div>

                                    <div class="card-box">
                                        <p class="font-600 m-b-5" style="text-transform: uppercase;">Gold Users<span class="text-success pull-right"><b>{{$gold_p}}%</b></span></p>
                                        <progress class="progress progress-striped progress-xs progress-success m-b-0" value="{{$gold_p}}" max="100">{{$gold_p}}%
                                        </progress>
                                    </div>

                                    <div class="card-box">
                                        <p class="font-600 m-b-5" style="text-transform: uppercase;">Silver Users<span class="text-warning pull-right"><b>{{$sliver_p}}%</b></span></p>
                                        <progress class="progress progress-striped progress-xs progress-warning m-b-0" value="{{$sliver_p}}" max="100">{{$sliver_p}}%
                                        </progress>
                                    </div>

                                    <div class="card-box">
                                        <p class="font-600 m-b-5" style="text-transform: uppercase;">Classic Users<span class="text-info pull-right"><b>{{$classic_p}}%</b></span></p>
                                        <progress class="progress progress-striped progress-xs progress-info m-b-0" value="{{$classic_p}}" max="100">{{$classic_p}}%
                                        </progress>
                                    </div>

                                </div>

                            </div>
                        </div><!-- end col-->

                        <div class="col-xs-12 col-lg-12 col-xl-5">
                            <div class="card-box">

                                <h4 class="header-title m-t-0 m-b-30">Latest Venues & Spaces</h4>

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item active" style="width: 49%">
                                        <a class="nav-link" id="venue-tab" data-toggle="tab" href="#venue_tab"
                                           role="tab" aria-controls="venue_tab" aria-expanded="true">Venues</a>
                                    </li>
                                    <li class="nav-item" style="width: 49%">
                                        <a class="nav-link" id="space-tab" data-toggle="tab" href="#space_tab"
                                           role="tab" aria-controls="space_tab">Spaces</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div role="tabpanel" class="tab-pane fade in active" id="venue_tab"
                                         aria-labelledby="venue-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered m-b-0">
                                                <thead>
                                                <tr>
                                                    <th>Company</th>
                                                    <th>City</th>
                                                    <th>Added Date</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($latest_venues as $l_venue)
                                                    <tr>
                                                        <th class="text-muted">{{get_company_name($l_venue['company_id'])}}</th>
                                                        <td>{{$l_venue['city']}}</td>
                                                        <td>{{ date('d/m/Y', strtotime($l_venue['created_at']))}}</td>
                                                        @if($l_venue['status'] == 1)
                                                            <td><span class="label label-success">Approve</span></td>
                                                        @elseif($l_venue['status'] == 0)
                                                            <td><span class="label label-default">Pending</span></td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <th class="text-muted" colspan="4" style="text-align: center">No Venue found</th>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="space_tab" role="tabpanel"
                                         aria-labelledby="space-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered m-b-0">
                                                <thead>
                                                <tr>
                                                    <th>Company</th>
                                                    <th>Space Type</th>
                                                    <th>Added Date</th>
                                                    <th>Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($latest_spaces as $l_space)
                                                    <tr>
                                                        <th class="text-muted">{{get_company_name($l_space->venue->company_id)}}</th>
                                                        <td>{{get_spacetype_by_space($l_space->id)}}</td>
                                                        <td>{{ date('d/m/Y', strtotime($l_space['created_at']))}}</td>
                                                        @if($l_space['status'] == 1)
                                                            <td><span class="label label-success">Approve</span></td>
                                                        @elseif($l_space['status'] == 0)
                                                            <td><span class="label label-default">Pending</span></td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <th class="text-muted" colspan="4" style="text-align: center">No Booking found</th>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>





                            </div>
                        </div><!-- end col-->


                    </div>
                    <!-- end row -->
                </div> <!-- container -->
            </div> <!-- End wrapper -->


        </div>
        <!-- END MAIN CONTENT -->

    </div>
    <!-- END MAIN PANEL -->


@endsection

@section('footer')
    @include('admin-panel.layouts.footer')
@endsection

@section('shortcut')
    @include('admin-panel.layouts.shortcut')
@endsection

@section('scripts')
    @include('admin-panel.layouts.scripts')

    <script src="{{url('js/admin-panel/jquery.nicescroll.js')}}"></script>
    <script src="{{url('js/admin-panel/jquery.waypoints.js')}}"></script>
    <script src="{{url('js/admin-panel/jquery.counterup.min.js')}}"></script>
    <script src="{{url('js/admin-panel/jquery.core.js')}}"></script>

    <!--Morris Chart-->
    <script src="{{url('js/admin-panel/plugin/morris/morris.min.js')}}"></script>
    <script src="{{url('js/admin-panel/plugin/morris/raphael.min.js')}}"></script>
    {{--<script src="{{url('js/admin-panel/jquery.morris.init.js')}}"></script>--}}

    <script>
        !function($) {
            "use strict";

            var MorrisCharts = function() {};
            //creates line chart
            MorrisCharts.prototype.createLineChart = function(element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
                Morris.Line({
                    element: element,
                    data: data,
                    xkey: xkey,
                    ykeys: ykeys,
                    labels: labels,
                    fillOpacity: opacity,
                    pointFillColors: Pfillcolor,
                    pointStrokeColors: Pstockcolor,
                    behaveLikeLine: true,
                    gridLineColor: '#eef0f2',
                    hideHover: 'auto',
                    lineWidth: '3px',
                    pointSize: 0,
                    preUnits: 'AED ',
                    resize: true, //defaulted to true
                    lineColors: lineColors,
                    parseTime:false
                });
            },
                //creates Donut chart
                MorrisCharts.prototype.createDonutChart = function(element, data, colors) {
                    Morris.Donut({
                        element: element,
                        data: data,
                        resize: true, //defaulted to true
                        colors: colors
                    });
                },

                MorrisCharts.prototype.init = function() {
                    var lineData = [];
                    $.getJSON("{{url('admin/dashboard/line/chart/data')}}", addLineData);
                    function addLineData(data) {
                        for (var i = 0; i < data.length; i++) {
                            lineData.push({
                                y: data[i].date,
                                a: data[i].count
                            });

                        }
                        // console.log(lineData);
                        //create line chart
                        MorrisCharts.prototype.createLineChart('sales_line_bar', lineData, 'y', ['a'],['Sales'],['0.1'],['#ffffff'],['#999999'], ['#1bb99a']);
                    }

                    var donutData = [];
                    var donutDataThis = [];
                    var donutDataLast = [];
                    var NoData = [
                        {label: "No Data", value: 0}
                    ];


                    $.getJSON("{{url('admin/dashboard/pie/chart/data')}}", addDonutData);
                    function addDonutData(data) {
                        //donutData = data.all;
                        //donutDataThis = data.this;
                        // donutDataLast = data.last;
                        if(searchGraph(data.all) == 0){
                            var donutData = NoData;
                        }else{
                            var donutData = data.all;
                        }
                        if(searchGraph(data.thisweek) == 0){
                            var donutDataThis = NoData;
                        }else{
                            var donutDataThis = data.thisweek;
                        }
                        if(searchGraph(data.lastweek) == 0){
                            var donutDataLast = NoData;
                        }else{
                            var donutDataLast = data.lastweek;
                        }
                        //console.log(searchGraph(data.thisweek));
                        //console.log(donutDataThis);
                        //console.log(donutDataLast);

                        //creating donut chart
                        MorrisCharts.prototype.createDonutChart('booking_donut_chart1', donutData, ['#f1b53d', '#9261c6', "#ff5d48"]);
                        MorrisCharts.prototype.createDonutChart('booking_donut_chart2', donutDataThis, ['#f1b53d', '#9261c6', "#ff5d48"]);
                        $('#booking_donut_chart2').hide();
                        MorrisCharts.prototype.createDonutChart('booking_donut_chart3', donutDataLast, ['#f1b53d', '#9261c6', "#ff5d48"]);
                        $('#booking_donut_chart3').hide();
                    }

                },
                //init
                $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
        }(window.jQuery),

            //initializing
            function($) {
                "use strict";
                $.MorrisCharts.init();
            }(window.jQuery);


        function searchGraph(chartValues){
            var no_value = 3;
            for (var i=0; i < chartValues.length; i++) {
                if (chartValues[i].value == 0) {
                    no_value--;
                }
            }
            return no_value;
        }

        $('.showSingle').click(function() {
            $('.targetDiv').hide();
            $('#booking_donut_chart' + $(this).attr('data-value')).show();
        });

    </script>



@endsection

