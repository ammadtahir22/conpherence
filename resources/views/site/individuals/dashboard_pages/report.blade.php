@extends('site.layouts.app')

<body style="background: #fff;">
<section class="generated-report">
    <div class="container">
        <div class="wrap">
            @php
                if(!empty($booking_status))
                {
                    $status = $booking_status;
                }else
                {
                    $status = "All";
                }

                if(!empty($location))
                {
                    $locations = $location;
                }else
                {
                    $locations = "All";
                }
            @endphp
            <h1>{{$user->name}}</h1>
            <div class="repthead-right">
                <p>Download</p>
                <p><a href="{{url('/user/dashboard/report/pdf/'. $status.'/'.$locations.'/'.$start_date.'/'.$end_date)}}"><img src="{{url('images/doc.png')}}"></a>
                    <a href="{{url('/user/dashboard/report/csv/'. $status.'/'.$locations.'/'.$start_date.'/'.$end_date)}}"><img src="{{url('images/doc1.png')}}"></a></p>
            </div>
            {{--<a href="{{url('/user/dashboard/report/pdf/'. $status.'/'.$locations.'/'.$start_date.'/'.$end_date)}}">pdf</a>--}}
            {{--<a href="{{url('/user/dashboard/report/csv/'. $status.'/'.$locations.'/'.$start_date.'/'.$end_date)}}">csv</a>--}}
            <div class="full-col report-info-outer">
                <div class="full-col report-info dep-report-info">
                    <div class="report-l-info col-sm-5">
                        <h3>Date of generate report</h3>
                        <h2>{{date('d M Y', strtotime(today()))}}</h2>
                    </div>
                    <div class="report-m-info col-sm-2">
                        <h3>Location</h3>
                        <h2>@if($location) {{$location}} @else All @endif</h2>
                    </div>
                    <div class="report-r-info col-sm-5">
                        <h3>Report Duration</h3>
                        <h2>From {{date('d M Y', strtotime($start_date))}}<span>To {{date('d M Y', strtotime($end_date))}}</span></h2>
                    </div>
                </div><!-- report-info -->
            </div><!-- report-info-outer -->
            <table class="meeting-report">
                <tr class="meeting-head">
                    <th>Sr#</th>
                    <th>Booking Number</th>
                    <th>Name of Meeting</th>
                    <th>Venue Name</th>
                    <th>Space Name</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
                @php $total_amount = 0 @endphp
                @foreach($bookingreports as $key => $bookingreport)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$bookingreport->booking_number}}</td>
                        <td>{{$bookingreport->purpose}}</td>
                        <td>{{$bookingreport->space->venue->title}}</td>
                        <td>{{$bookingreport->space->title}}</td>
                        <td>{{date('d M Y', strtotime($bookingreport->start_date))}} to {{date('d M Y', strtotime($bookingreport->end_date))}}</td>
                        <td>AED   {{$bookingreport->grand_total}}/-</td>
                        <td>@if($bookingreport->status == 0) Pending @elseif($bookingreport->status == 1) Approved @else Cancelled @endif</td>
                    </tr>
                    @php $total_amount = $total_amount + $bookingreport->grand_total; @endphp
                @endforeach
            </table>
            <div class="full-col">
                <div class="report-total">
                    <p>Total <span>AED   {{$total_amount}}/-</span></p>
                </div>
            </div>
            <div class="report-btm full-col">
                <div class="report-l-btm col-xs-6">
                    <a href="#"><img src="images/logo.png" alt="" /></a>
                </div>

            </div>
        </div><!-- wrap -->
    </div><!--container-->
    <div class="clearfix"></div>
</section>
</body>
</html>
