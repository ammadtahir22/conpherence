@extends('site.layouts.app')

@section('head')

@endsection

@section('content')
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
            <h1>Saving Report</h1>
            <div class="repthead-right">
                <p>Download</p>
                <form action="{{route('user.saving.report.pdf')}}" method="post" id="form_pdf" style="display: none;">
                    @csrf
                    <input type="hidden" name="start_date" value="{{$start_date}}">
                    <input type="hidden" name="end_date" value="{{$end_date}}">
                    <input type="hidden" name="bookings" value="{{json_encode($bookings)}}">
                </form>
                <p><a href="#" onclick="document.getElementById('form_pdf').submit()"><img src="{{url('images/doc.png')}}"></a>
                <a href="#" onclick="document.getElementById('form_cvs').submit()"><img src="{{url('images/doc1.png')}}"></a></p>
                <form action="{{route('user.saving.report.cvs')}}" method="post" id="form_cvs" style="display: none;">
                    @csrf
                    <input type="hidden" name="start_date" value="{{$start_date}}">
                    <input type="hidden" name="end_date" value="{{$end_date}}">
                    <input type="hidden" name="bookings" value="{{json_encode($bookings)}}">
                </form>
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
                        <h3>Report For</h3>
                        <h2>{{$user->name}}</h2>
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
                    <th>Purpose of Meeting</th>
                    <th>Venue Name</th>
                    <th>Space Name</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Saved Amount</th>
                </tr>
                @php $total_amount = 0 @endphp
                @php $total_discount = 0 @endphp
                @forelse($bookings as $key => $booking)
                    @php $discount = $booking->total - $booking->grand_total; @endphp
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$booking->booking_number}}</td>
                        <td>{{$booking->purpose}}</td>
                        <td>{{$booking->space->venue->title}} ({{$booking->space->venue->city}})</td>
                        <td>{{$booking->space->title}}</td>
                        <td>{{date('d M Y', strtotime($booking->start_date))}} to {{date('d M Y', strtotime($booking->end_date))}}</td>
                        <td>AED   {{number_format($booking->grand_total, 2)}}/-</td>
                        <td>AED   {{number_format($discount, 2)}}/-</td>
                        {{--<td>@if($booking->status == 0) Pending @elseif($booking->status == 1) Approved @else Cancelled @endif</td>--}}
                    </tr>
                    @php $total_amount = $total_amount + $booking->grand_total; @endphp
                    @php $total_discount = $total_discount + $discount; @endphp
                @empty
                    <tr>
                        <td colspan="8">No Booking found with discount</td>
                    </tr>
                @endforelse
            </table>
            <div class="full-col">
                <div class="report-total">
                    <p>Total <span>AED   {{number_format($total_amount, 2)}}/-</span></p>
                    <p>Total Discount<span>AED   {{number_format($total_discount, 2)}}/-</span></p>
                </div>
            </div>
            <div class="report-btm full-col">
                <div class="report-l-btm col-xs-6">
                    <a href="#"><img src="{{url('images/logo.png')}}" alt="" /></a>
                </div>

            </div>
        </div><!-- wrap -->
    </div><!--container-->
    <div class="clearfix"></div>

</section>
@endsection
