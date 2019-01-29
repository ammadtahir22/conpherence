@extends('site.layouts.app')
@section('head')
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
                    @include('site.companies.dashboard_nev',['active_booking' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane" id="dashboard">
                </div>
                <div class="tab-pane" id="profile">

                </div>
                <div class="tab-pane" id="venue">
                </div>
                <div class="tab-pane" id="payment">
                    <div class="welcome-title full-col">
                        <h2>Payment</h2>
                    </div>
                </div>
                <div class="tab-pane active booking-flow-summry manual-booking" id="bookings">
                    <div class="back-to full-col">
                        <a href="{{url('company/dashboard/bookings')}}"><img src="{{url('images/back.png')}}" alt="">Back
                            to listing page</a>
                    </div>
                    <div class="flow-summry">
                        <h3>Add New Booking</h3>
                        <div class="flash_message alert alert-danger text-center" style="margin-top: 30px; display: none;"></div>
                        <form action="{{url('/company/dashboard/save-manual-booking')}}" id="manual_booking_form" method="post">
                            @csrf
                            <input type="hidden" name="hotel_owner_id" value="{{Auth::user()->id}}">
                            <div class="full-col">
                                <h4>Space Info</h4>
                                <div class="form-group group col-xs-4">
                                    <select name="venue_id" id="venue_id" class="no-b-r b-l-radius">
                                        <option value="">Add Location</option>
                                        @if(isset($venues) && count($venues) > 0)
                                            @foreach($venues as $venue)
                                                <option value="{{$venue->id}}">{{$venue->city}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="venue_id">Location</label>
                                </div>
                                <div class="form-group group col-xs-8">
                                    <select name="space_id" id="space_id" class="b-r-radius">
                                        <option value="">Select Venue first</option>
                                    </select>
                                    <label for="spacce">Space Name</label>
                                </div>
                            </div>
                            <div class="full-col">
                                <h4>Booking Info</h4>
                                <div class="full-col">
                                    <div class="form-group group col-xs-6">
                                        <input type="text" name="customer_name"  placeholder="Name of individual"
                                               class="form-control b-l-radius" id="customer_name">
                                        <label for="cutomer">Customer Name</label>
                                    </div>
                                    <div class="form-group group col-xs-3">
                                        <input type="email" name="customer_email" placeholder="Enter Email"
                                               class="form-control no-b-r no-b-l" id="customer_email">
                                        <label for="email">Email Id</label>
                                    </div>
                                    <div class="form-group group col-xs-3">
                                        <input type="text" name="customer_contact" placeholder="Enter Phone Number"
                                               class="form-control b-r-radius" id="customer_contact">
                                        <label for="cutomer">Contact Number</label>
                                    </div>
                                </div>
                                <div class="full-col">
                                    <div class="form-group group col-xs-8">
                                        <input type="text" name="purpose" placeholder="Business Startup Meeting"
                                               class="form-control b-l-radius" id="purpose">
                                        <label for="meeting">Purpose of Meeting</label>
                                    </div>
                                    <div class="form-group group col-xs-2 ">
                                        <input type="text" name="startdate" class="form-control no-b-r no-b-l"
                                               id="booking_date" placeholder="Start Date">
                                        <label for="date">Start Date</label>
                                    </div>
                                    <div class="form-group group col-xs-2">
                                        <input type="text" name="enddate" placeholder="End Date"
                                               class="form-control end-date b-r-radius" id="booking_end_date">
                                        <label for="end-date">End Date</label>
                                    </div>
                                </div>
                            </div>
                            <div id="booking_days_detail"></div>
                            <div id="customer_hidden"></div>
                            <div class="full-col b-sum-btn-wrap">
                                <ul class="list-inline col-sm-6">
                                    <li>
                                        <button type="button" onclick="CheckAndBook()" class="btn ani-btn book-step">Save</button>
                                    </li>
                                    <li>
                                        <button type="button" class="cancle-step">Cancel</button>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div><!-- flow-summry" -->
                </div>
                <div class="tab-pane" id="reviews">
                    <div class="welcome-title full-col">
                        <h2>Reviews</h2>
                    </div>
                </div>
                <div class="tab-pane" id="savings">
                    <div class="welcome-title full-col">
                        <h2>Savings</h2>
                    </div>
                </div>
            </div>
        </div>
    {{--</div>--}}
    <!-- /tabs -->
        <div class="clearfix"></div>
    </section>
@endsection
@section('footer')
    @include('site.layouts.footer')
@endsection
@section('scripts')
    @include('site.layouts.scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#venue_id').change(function () {
                var venue_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('company.manualbooking.venueallspaces') }}",
                    data: {'venue_id': venue_id},
                    success: function (data) {
                        $('#space_id').html(data.option);
                    }
                });
            });

            $("#manual_booking_form").validate({
                ignore:[],
                rules: {
                    venue_id: {
                        required: true
                    },
                    space_id: {
                        required: true
                    },
                    customer_name: {
                        required: true
                    },
                    customer_email: {
                        required: true
                    },
                    customer_contact: {
                        required: true
                    },
                    purpose: {
                        required: true
                    },
                    startdate: {
                        required: true
                    },
                    enddate: {
                        required: true
                    }
                },
                messages: {
                }
                // ,
                // errorPlacement: function(error, element) {
                //     error.insertAfter(element.parent('.form-group'));
                // }
            });

            $('#booking_date').on("change", function () {
                add_booking_days();
            });
            $('#booking_end_date').on("change", function () {
                add_booking_days();
            });

            $("#customer_name").focusout(function(){
                $('#customer_hidden').html('');
                var customer_name = $('#customer_name').val();
                if(customer_name !== '') {
                    var cus_name_array = $('#customer_name').val().split(' ');
                    var firstname = cus_name_array[0];
                    var lastname = '';
                    for (var j = 0; j < cus_name_array.length; j++) {
                        if (j !== 0) {
                            lastname += cus_name_array[j] + ' ';
                        }
                    }
                    $('#customer_hidden').append('<input type="hidden" name="firstname" value="'+firstname+'"><input type="hidden" name="lastname" value="'+lastname+'">');
                }
            });
            $.validator.addClassRules('book_day_timing', {
                required: true,
            });
        });

        function parseDate(start_date, end_date) {
            var f_d_array = start_date.split('-');
            var s_d_array = end_date.split('-');
            var oneDay = 24*60*60*1000;
            var firstDate = new Date(f_d_array[0],f_d_array[1],f_d_array[2]);
            var secondDate = new Date(s_d_array[0],s_d_array[1],s_d_array[2]);
            return Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay))) + 1;
        }
        function date_increment(newdate, more_days){
            var result = new Date(new Date(newdate).setDate(new Date(newdate).getDate() + more_days));
            return result.toISOString().substr(0, 10);
        }

        function add_booking_days(){
            var start_date = $('#booking_date').val();
            var end_date = $('#booking_end_date').val();
            var num_of_days = '';
            var booking_days = '';
            var words = new Array();
            words[1] = 'One'
            words[2] = 'Two';
            words[3] = 'Three';
            words[4] = 'Four';
            words[5] = 'Five';
            words[6] = 'Six';
            words[7] = 'Seven';

            if(start_date !== '' && end_date !== ''){
                $('#booking_days_detail').html('');
                var num_of_days = parseDate(start_date, end_date);
                if(num_of_days <= 7) {
                    for (var i = 1; i <= num_of_days; i++) {
                        if (i % 2 == 0) {
                            var manual_booking_class = 'manual-booking-right';
                        } else {
                            var manual_booking_class = 'manual-booking-left';
                        }
                        if (i === 1) {
                            var increment_date = start_date;
                        } else {
                            var day_increment = i - 1;
                            var increment_date = date_increment(start_date, day_increment);
                        }
                        booking_days += '<div class="' + manual_booking_class + ' col-xs-6">' +
                            '<h4>Booking Detail Day ' + words[i] + '</h4>' +
                            '<div class="form-group group col-xs-4">' +
                            '<input type="text" name="day' + words[i] + '_date" placeholder="Enter date" class="form-control b-l-radius disable_date" id="day' + words[i] + '_date" value="' + increment_date + '">' +
                            '<label for="day-two">Date</label></div>' +
                            '<div class="form-group group col-xs-4">' +
                            '<select name="stime' + i + '" class="form-control valid book_day_timing" id="stime' + i + '" onchange="get_end_time(this, '+i+')">' +
                            '    <option value="">- Select Time -</option>' +
                            '    <option value="7">7:00 AM</option>' +
                            '    <option value="8">8:00 AM</option>' +
                            '    <option value="9">9:00 AM</option>' +
                            '    <option value="10">10:00 AM</option>' +
                            '    <option value="11">11:00 AM</option>' +
                            '    <option value="12">12:00 PM</option>' +
                            '    <option value="13">1:00 PM</option>' +
                            '    <option value="14">2:00 PM</option>' +
                            '    <option value="15">3:00 PM</option>' +
                            '    <option value="16">4:00 PM</option>' +
                            '    <option value="17">5:00 PM</option>' +
                            '    <option value="18">6:00 PM</option>' +
                            '    <option value="19">7:00 PM</option>' +
                            '    <option value="20">8:00 PM</option>' +
                            '    <option value="21">9:00 PM</option>' +
                            '    <option value="22">10:00 PM</option>' +
                            '    <option value="23">11:00 PM</option>' +
                            '</select>' +
                            '<label for="date">Start Time</label></div>' +
                            '<div class="form-group group col-xs-4">' +
                            '<select name="etime' + i + '" class="form-control valid book_day_timing" id="etime' + i + '">' +
                            '    <option value="">- Select Time -</option>' +
                            '</select>' +
                        '<label for="end-date">End Time</label></div></div>';
                    }
                    booking_days += '<input type="hidden" name="user_id" value="0">'+
                        '<input type="hidden" name="total_days" value="'+num_of_days+'"><input type="hidden" name="address" value="Manual Booking">';
                }else{
                    alert('Start and end date should be between 7 days');
                }
                $('#booking_days_detail').append(booking_days);
                $(".disable_date").attr("disabled", true);
            }
        }

        function get_end_time(selected_value, current_value){
            var new_times = '';
            var new_append_id = '#etime' + current_value;
            if(selected_value.value !== '') {
                var start_value = parseInt(selected_value.value) + 1;

                var time_values = new Array();
                time_values[7] = '<option value="7">7:00 AM</option>';
                time_values[8] = '<option value="8">8:00 AM</option>';
                time_values[9] = '<option value="9">9:00 AM</option>';
                time_values[10] = '<option value="10">10:00 AM</option>';
                time_values[11] = '<option value="11">11:00 AM</option>';
                time_values[12] = '<option value="12">12:00 PM</option>';
                time_values[13] = '<option value="13">1:00 PM</option>';
                time_values[14] = '<option value="14">2:00 PM</option>';
                time_values[15] = '<option value="15">3:00 PM</option>';
                time_values[16] = '<option value="16">4:00 PM</option>';
                time_values[17] = '<option value="17">5:00 PM</option>';
                time_values[18] = '<option value="18">6:00 PM</option>';
                time_values[19] = '<option value="19">7:00 PM</option>';
                time_values[20] = '<option value="20">8:00 PM</option>';
                time_values[21] = '<option value="21">9:00 PM</option>';
                time_values[22] = '<option value="22">10:00 PM</option>';
                time_values[23] = '<option value="23">11:00 PM</option>';

                new_times += '<option value="">- Select Time -</option>';
                for (var i = start_value; i <= 23; i++) {
                    new_times += time_values[i];
                }
                $(new_append_id).html(new_times);
            }else{
                $(new_append_id).html('<option value="">- Select Time -</option>');
            }
        }

        function CheckAndBook(){
            $('.flash_message').html('').hide();
            $.ajax({
                url: "{{url('/booking/check_space_status')}}",
                type: "POST",
                data: $('#manual_booking_form').serialize(),
                dataType: 'json',
                success: function(data){
                    if(data.flag == 0){
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $('.flash_message').html(data.message).show();
                    }else{
                        $('#manual_booking_form').submit();
                    }
                }
            });
        }
    </script>
@endsection

