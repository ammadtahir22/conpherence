@extends('site.layouts.app')

@section('css-link')
<link href="{{url('css/layout.css')}}" rel="stylesheet">
@endsection
<body style="background: #fff;">
<section class="generated-report">
    <div class="container">
        <div class="wrap">
            
            <h1>Booking Report</h1>
            <div class="repthead-right">
                <p>Download</p>
                <form action="{{route('admin.downloadpdf_report')}}" method="post" id="form_pdf" style="display: none;">
                    @csrf
                    <input type="hidden" name="report_data" value="{{json_encode($booking_infos)}}">
                    <input type="hidden" name="start_date" autocomplete="off" value="{{$start_date}}">
                    <input type="hidden" name="end_date" autocomplete="off" value="{{$end_date}}">
                </form>
                <form action="{{route('admin.downloadexcel_report')}}" method="post" id="form_csv" style="display: none;">
                    @csrf
                    <input type="hidden" name="report_data" value="{{json_encode($booking_infos)}}">
                    <input type="hidden" name="start_date" autocomplete="off" value="{{$start_date}}">
                    <input type="hidden" name="end_date" autocomplete="off" value="{{$end_date}}">
                </form>
                <p><a href="#" onclick="document.getElementById('form_pdf').submit()"><img src="{{url('images/doc.png')}}"></a>
                    <a href="#" onclick="document.getElementById('form_csv').submit()"><img src="{{url('images/doc1.png')}}"></a></p>
            </div>

            <div class="full-col report-info-outer">
                <div class="full-col report-info dep-report-info">
                    <div class="report-l-info col-sm-6">
                        <h3>Date of generate report</h3>
                        <h2>{{date('d M Y', strtotime(today()))}}</h2>
                    </div>
                    <div class="report-r-info col-sm-6">
                        <h3>Report Duration</h3>
                        <h2>From {{date('d M Y', strtotime($start_date))}}<span> To {{date('d M Y', strtotime($end_date))}}</span></h2>
                    </div>
                </div><!-- report-info -->
            </div><!-- report-info-outer -->
            <table class="meeting-report">
                <tr class="meeting-head">
                    <th>Sr#</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Name of Meeting</th>
                    <th>Venue Name</th>
                    <th>Space Name</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
                @php $total_amount = 0 @endphp
                @foreach($booking_infos as $key => $bookingreport)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$bookingreport->booking_firstname." ".$bookingreport->booking_lastname}}</td>
                        <td>{{$bookingreport->user->email}}</td>
                        <td>{{$bookingreport->purpose}}</td>
                        <td>{{get_venue_title($bookingreport->venue_id)}} ({{get_city_by_venue($bookingreport->venue_id)}})</td>
                        <td>{{get_space_title($bookingreport->space_id)}}</td>
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
