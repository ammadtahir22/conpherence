@extends('admin-panel.layouts.app')

@section('css-link')
    <style>
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
        .smart-form{
            float:left;
        }
        .smart-form .toggle i{
            width:60px;
        }
        .smart-form .toggle i:before{
            right:2px;
        }
        .smart-form .toggle input:checked+i:before {
            right: 46px;
        }

    </style>
@endsection

{{--@section('header')--}}
{{----}}
{{--@endsection--}}

@section('left-panel')
    @include('admin-panel.layouts.left-panel')
@endsection
@section('main-panel')
    <!-- MAIN PANEL -->
    <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">

            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home</li><li>Bookings</li><li>Invoice</li>
            </ol>
            <!-- end breadcrumb -->

            <!-- You can also add more buttons to the
            ribbon for further usability

            Example below:

            <span class="ribbon-button-alignment pull-right">
            <span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
            <span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
            <span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
            </span> -->

        </div>
        <!-- END RIBBON -->

        <!-- MAIN CONTENT -->
        <div id="content">

            <!-- widget grid -->
            <section id="widget-grid" class="">

                <!-- row -->
                <div class="row">

                    <!-- NEW WIDGET START -->
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget well jarviswidget-color-darken" id="wid-id-0" data-widget-sortable="false" data-widget-deletebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false">

                            <header>
                                <span class="widget-icon"> <i class="fa fa-barcode"></i> </span>
                                <h2>Item #44761 </h2>

                            </header>

                            <!-- widget div-->
                            <div>

                                <!-- widget edit box -->
                                <div class="jarviswidget-editbox">
                                    <!-- This area used as dropdown edit box -->

                                </div>
                                <!-- end widget edit box -->

                                <!-- widget content -->
                                <div class="widget-body no-padding">
                                    <div class="widget-body-toolbar">



                                    </div>


                                    <div class="padding-10">
                                        <br>
                                        <h1 class="" style="font-weight: 700;font-size: 20px; color:#b11f5f;font-family: 'Montserrat', sans-serif;">invoice</h1>
                                        <div class="pull-left">
                                            <img src="{{url('images/logo.png')}}" width="150" height="32" alt="invoice icon">
                                            <input type="hidden" name="id" value="{{$booking->id}}">
                                            <input type="hidden" name="venue_id" value="{{$booking->venue_id}}">
                                            <input type="hidden" name="space_id" value="{{$booking->space_id}}">
                                            <input type="hidden" name="hotel_owner_id" value="{{$booking->hotel_owner_id}}">
                                            <address style="color:#a6a6a6;">
                                                <br>
                                                <strong style="color:#302f2f;">@if(isset($spaces) && count($spaces) > 0)
                                                        @foreach($spaces as $space)
                                                            @if($space->id == $booking->space_id) {{$space->title}} @endif
                                                        @endforeach
                                                    @endif</strong>
                                                <br>
                                                @if(isset($venues) && count($venues) > 0)
                                                    @foreach($venues as $venue)
                                                        @if($booking->venue_id == $venue->id) {{$venue->city}} @endif
                                                    @endforeach
                                                @endif
                                                <br>
                                                @if(isset($venues) && count($venues) > 0)
                                                    @foreach($venues as $venue)
                                                        @if($booking->venue_id == $venue->id) {{$venue->location}} @endif
                                                    @endforeach
                                                @endif

                                            </address>
                                        </div>
                                        <div class="pull-right">

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <h4 class="" style="color:#302f2f;font-size:16px;font-weight: 700;">{{$booking->booking_firstname.' '.$booking->booking_lastname}}</h4>
                                                <address style="color:#a6a6a6;font-size:13px;">
                                                    <abbr title="Phone">P:</abbr> {{$booking->booking_phone}}
                                                </address>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="" >
                                                    <strong style="color:#302f2f;font-size:14px;font-family: 'Lato', sans-serif;">Invoice Date :</strong>
                                                    <span class="pull-right" style="color: #a6a6a6;font-size:14px;font-family: 'Lato', sans-serif;"> <i class="fa fa-calendar"></i> {{date('d M Y', strtotime($booking->created_at))}}</span>
                                                </div>
                                                <br>

                                            </div>
                                        </div>
                                        <div id="booking_days_detail">
                                            @if(isset($booking_times) && count($booking_times) > 0)
                                                <input type="hidden" name="total_days" value="{{count($booking_times)}}" />
                                                @php $b_start_date = date('Y-m-d', strtotime($booking->start_date));
                                        $numberToWord = array();
                                        $numberToWord[1] = 'One';
                                        $numberToWord[2] = 'Two';
                                        $numberToWord[3] = 'Three';
                                        $numberToWord[4] = 'Four';
                                        $numberToWord[5] = 'Five';
                                        $numberToWord[6] = 'Six';
                                        $numberToWord[7] = 'Seven';
                                                @endphp
                                                @foreach($booking_times as $key => $time)
                                                    @if($key != 0)
                                                        @php $b_start_date = date('Y-m-d', strtotime($booking->start_date. '+'.$key.'day')); @endphp
                                                    @endif
                                                    <div class="manual_booking_class  col-xs-6">
                                                        <h4>Booking Detail Day {{$numberToWord[$key+1]}}</h4>
                                                        <div class="form-group group col-xs-4">
                                                            <input type="text" name="day_date" placeholder="Enter date"
                                                                   class="form-control b-l-radius disable_date" id="day{{$key}}_date"
                                                                   value="{{$b_start_date}}">
                                                            <label for="day-two">Date</label></div>
                                                        <div class="form-group group col-xs-4">
                                                            <select name="stime{{$key + 1}}" class="form-control valid book_day_timing" id="stime{{$key + 1}}" onchange="get_end_time(this, {{$key+1}})">
                                                                <option value="">- Select Time -</option>
                                                                <option @if($time['start_time'] == 7) {{'selected'}}@endif value="7">7:00 AM</option>
                                                                <option @if($time['start_time'] == 8) {{'selected'}}@endif value="8">8:00 AM</option>
                                                                <option @if($time['start_time'] == 9) {{'selected'}}@endif value="9">9:00 AM</option>
                                                                <option @if($time['start_time'] == 10) {{'selected'}}@endif value="10">10:00 AM</option>
                                                                <option @if($time['start_time'] == 11) {{'selected'}}@endif value="11">11:00 AM</option>
                                                                <option @if($time['start_time'] == 12) {{'selected'}}@endif value="12">12:00 PM</option>
                                                                <option @if($time['start_time'] == 13) {{'selected'}}@endif value="13">1:00 PM</option>
                                                                <option @if($time['start_time'] == 14) {{'selected'}}@endif value="14">2:00 PM</option>
                                                                <option @if($time['start_time'] == 15) {{'selected'}}@endif value="15">3:00 PM</option>
                                                                <option @if($time['start_time'] == 16) {{'selected'}}@endif value="16">4:00 PM</option>
                                                                <option @if($time['start_time'] == 17) {{'selected'}}@endif value="17">5:00 PM</option>
                                                                <option @if($time['start_time'] == 18) {{'selected'}}@endif value="18">6:00 PM</option>
                                                                <option @if($time['start_time'] == 19) {{'selected'}}@endif value="19">7:00 PM</option>
                                                                <option @if($time['start_time'] == 20) {{'selected'}}@endif value="20">8:00 PM</option>
                                                                <option @if($time['start_time'] == 21) {{'selected'}}@endif value="21">9:00 PM</option>
                                                                <option @if($time['start_time'] == 22) {{'selected'}}@endif value="22">10:00 PM</option>
                                                                <option @if($time['start_time'] == 23) {{'selected'}}@endif value="23">11:00 PM</option>
                                                            </select>
                                                            <label for="date">Start Time</label></div>
                                                        <div class="form-group group col-xs-4">
                                                            <select name="etime{{$key + 1}}" class="form-control valid book_day_timing" id="etime{{$key + 1}}">
                                                                <option value="">- Select Time -</option>
                                                                <option @if($time['end_time'] == 7) {{'selected'}}@endif value="7">7:00 AM</option>
                                                                <option @if($time['end_time'] == 8) {{'selected'}}@endif value="8">8:00 AM</option>
                                                                <option @if($time['end_time'] == 9) {{'selected'}}@endif value="9">9:00 AM</option>
                                                                <option @if($time['end_time'] == 10) {{'selected'}}@endif value="10">10:00 AM</option>
                                                                <option @if($time['end_time'] == 11) {{'selected'}}@endif value="11">11:00 AM</option>
                                                                <option @if($time['end_time'] == 12) {{'selected'}}@endif value="12">12:00 PM</option>
                                                                <option @if($time['end_time'] == 13) {{'selected'}}@endif value="13">1:00 PM</option>
                                                                <option @if($time['end_time'] == 14) {{'selected'}}@endif value="14">2:00 PM</option>
                                                                <option @if($time['end_time'] == 15) {{'selected'}}@endif value="15">3:00 PM</option>
                                                                <option @if($time['end_time'] == 16) {{'selected'}}@endif value="16">4:00 PM</option>
                                                                <option @if($time['end_time'] == 17) {{'selected'}}@endif value="17">5:00 PM</option>
                                                                <option @if($time['end_time'] == 18) {{'selected'}}@endif value="18">6:00 PM</option>
                                                                <option @if($time['end_time'] == 19) {{'selected'}}@endif value="19">7:00 PM</option>
                                                                <option @if($time['end_time'] == 20) {{'selected'}}@endif value="20">8:00 PM</option>
                                                                <option @if($time['end_time'] == 21) {{'selected'}}@endif value="21">9:00 PM</option>
                                                                <option @if($time['end_time'] == 22) {{'selected'}}@endif value="22">10:00 PM</option>
                                                                <option @if($time['end_time'] == 23) {{'selected'}}@endif value="23">11:00 PM</option>
                                                            </select>
                                                            <label for="end-date">End Time</label></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>


                                    </div>

                                </div>
                                <!-- end widget content -->

                            </div>
                            <!-- end widget div -->

                        </div>
                        <!-- end widget -->

                    </article>
                    <!-- WIDGET END -->

                </div>

                <!-- end row -->

            </section>
            <!-- end widget grid -->

        </div>
        <!-- END MAIN CONTENT -->

    </div>

@endsection
@section('footer')
    @include('admin-panel.layouts.footer')
@endsection

@section('shortcut')
    @include('admin-panel.layouts.shortcut')
@endsection

@section('scripts')
    <script type="text/javascript">
        //delete credit card
        function changeStatus(id) {
            // alert(id);
            $('input[name="status"]').val(id);
            if(id == 1){
                $('#approve-status').html('Are You Sure You Want To Approve this Booking');
            }else {
                $('#approve-status').html('Are You Sure You Want To Cancel this Booking');
            }
            // document.getElementById("demo").innerHTML = "Hello World";
        }

    </script>
    <script type="text/javascript">
        function form_submit() {
            document.getElementById("changeStatus").submit();
        }
    </script>
    @include('admin-panel.layouts.scripts')


@endsection



