<body style="background: #fff;">
<style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i|Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
    body {
        background:#f2f1f3;
        font-family: 'Lato', sans-serif;
        font-size:14px;
        -webkit-font-smoothing: antialiased; /* Fix for webkit rendering */
        -webkit-text-size-adjust: 100%;
        cursor:default;
        margin:0;
        color:#353535;
        overflow-x: hidden;
    }
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Montserrat', sans-serif;
    }
    .container {
        max-width: 1170px;
        margin: auto;
    }
    .generated-report{
        float: left;width:100%;position: relative;min-height: 1px;background: #ffffff;padding: 40px 0px;
    }
    .generated-report .wrap{
    }
    .report-info h2 span{
        border-left: 1px solid #302f2f; padding-left: 5px;margin-left: 5px;
    }
    .meeting-report {
        font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif;
    }

    .meeting-report th {
        text-align: left; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;
    }
    .meeting-report td{
        border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;
    }
</style>
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
            <h1 style="color: #b11f5f;font-weight: 700;font-size: 26px; position: relative;">{{$user->name}}</h1>
            <div style="float:left;width:100%; position: relative;margin: 10px 0px 20px 0px;"><img src="images/bar.png" alt="" style="width:173px;" /></div>
            {{--<div class="full-col report-info-outer">--}}
                {{--<div class="full-col report-info dep-report-info">--}}
                    {{--<div class="report-l-info col-sm-5">--}}
                        {{--<h3>Date of generate report</h3>--}}
                        {{--<h2>{{date('d M Y', strtotime(today()))}}</h2>--}}
                    {{--</div>--}}
                    {{--<div class="report-m-info col-sm-2">--}}
                        {{--<h3>Location</h3>--}}
                        {{--<h2>@if($location) {{$location}} @else All @endif</h2>--}}
                    {{--</div>--}}
                    {{--<div class="report-r-info col-sm-5">--}}
                        {{--<h3>Report Duration</h3>--}}
                        {{--<h2>From {{date('d M Y', strtotime($start_date))}}<span>To {{date('d M Y', strtotime($end_date))}}</span></h2>--}}
                    {{--</div>--}}
                {{--</div><!-- report-info -->--}}
            {{--</div><!-- report-info-outer -->--}}
            <table width="100%" style="border: 1px solid #d4d4d4; margin-top:30px;margin-bottom: 10px;">
                <tr>
                    <td style="padding: 15px;">
                        <h3 style="font-size: 12px;margin: 0px;color: #a6a6a6;font-family: 'Lato', sans-serif;">Date of generate report</h3>
                        <h2 style="font-size: 16px;margin: 10px 0px 5px 0px;color: #302f2f;font-weight: 700;">{{date('d M Y', strtotime(today()))}}</h2>
                    </td>
                    <td style="padding: 15px;    border-left: 1px solid #d4d4d4;">
                        <h3 style="font-size: 12px;margin: 0px;color: #a6a6a6;font-family: 'Lato', sans-serif;">Location</h3>
                        <h2 style="font-size: 16px;margin: 10px 0px 5px 0px;color: #302f2f;font-weight: 700;">@if($location) {{$location}} @else All @endif</h2>
                    </td>
                    <td style="padding: 15px;    border-left: 1px solid #d4d4d4;">
                        <h3 style="font-size: 12px;margin: 0px;color: #a6a6a6;font-family: 'Lato', sans-serif;">Report Duration</h3>
                        <h2 style="font-size: 16px;margin: 10px 0px 5px 0px;color: #302f2f;font-weight: 700;">From {{date('d M Y', strtotime($start_date))}}<span>To {{date('d M Y', strtotime($end_date))}}</span></h2>
                    </td>
                </tr>
            </table>
            <table class="meeting-report" style="border-collapse: collapse;border-color:#d4d4d4;width: 100%;">
                <tr class="meeting-head">
                    <th style="text-align: center; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;text-align: center;">Sr#</th>
                    <th style="text-align: center; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;text-align: center;">Booking Number</th>
                    <th style="text-align: left; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;">Name of Meeting</th>
                    <th style="text-align: left; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;">Venue Name</th>
                    <th style="text-align: left; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;">Space Name</th>
                    <th style="text-align: left; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;">Date</th>
                    <th style="text-align: left; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;">Amount</th>
                    <th style="text-align: left; background-color: #b11f5f;color: #fff;font-size:13px;font-weight:700;border: 1px solid #d4d4d4;padding: 10px 20px;">Status</th>
                </tr>
                @php $total_amount = 0 @endphp
                @foreach($bookingreports as $key => $bookingreport)
                    <tr>
                        <td style="border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;text-align: center;">{{$key+1}}</td>
                        <td style="border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;">{{$bookingreport->booking_number}}</td>
                        <td style="border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;">{{$bookingreport->purpose}}</td>
                        <td style="border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;">{{$bookingreport->space->venue->title}}</td>
                        <td style="border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;">{{$bookingreport->space->title}}</td>
                        <td style="border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;">{{date('d M Y', strtotime($bookingreport->start_date))}} to {{date('d M Y', strtotime($bookingreport->end_date))}}</td>
                        <td style="border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;">AED   {{number_format($bookingreport->grand_total, 2)}}/-</td>
                        <td style="border: 1px solid #d4d4d4; padding: 15px 17px; color:#302f2f;font-size:14px;font-weight: 500;">@if($bookingreport->status == 0) Pending @elseif($bookingreport->status == 1) Approved @else Cancelled @endif</td>
                    </tr>
                    @php $total_amount = $total_amount + $bookingreport->grand_total; @endphp
                @endforeach
            </table>
            <table width="100%" style="background:#fff;font-size: 14px;color: #302f2f;padding-top: 15px;margin-top: 50px;margin-bottom: 50px;">
                <tr>
                    <td align="right" class="report-total" style=" color: #b11f5f;padding-right: 40px;font-size: 16px;"><p style="margin-bottom: 10px;">Total <span>AED   {{number_format($total_amount, 2)}}/-</span></p><img src="images/bar.png" alt="" style="width: 200px" /></td>
                </tr>
            </table>
            <table width="100%" style="background:#fff;font-size: 14px;color: #302f2f;border-top: 1px solid #d4d4d4;padding-top: 15px;">
                <tr>
                    <td align="left"><a href="#"><img src="images/logo.png" alt="" style="max-width: 157px;" /></a></td>
                </tr>
            </table>
            {{--<div class="full-col">--}}
                {{--<div class="report-total">--}}
                    {{--<p>Total <span>AED   {{$total_amount}}/-</span></p>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="report-btm full-col">--}}
                {{--<div class="report-l-btm col-xs-6">--}}
                    {{--<a href="#"><img src="images/logo.png" alt="" /></a>--}}
                {{--</div>--}}
                {{--<div class="report-r-btm col-xs-6">--}}
                    {{--<p>Page 1/10</p>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div><!-- wrap -->
    </div><!--container-->
    <div class="clearfix"></div>
</section>
</body>
</html>
