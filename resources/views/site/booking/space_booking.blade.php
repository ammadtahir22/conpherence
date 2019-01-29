@extends('site.layouts.app')

@section('head')
    <style>

    </style>
@endsection

@section('header-class', '')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="bok-flow-section">
        <div class="container">
            <div class="wrap">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">Venue</a></li>
                    <li><a href="#">Space</a></li>
                    <li>Booking</li>
                </ol>
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">

                            <li role="info" class="active continue">
                                <a href="#info" data-toggle="tab" aria-controls="step1" role="tab" title="Info">
                                    <div class="round-tab"></div>
                                    <span>Info</span>
                                </a>
                            </li>

                            <li role="timing" class="disabled">
                                <a href="#timing" data-toggle="tab" aria-controls="step2" role="tab" title="Timing">
                                    <div class="round-tab"></div>
                                    <span>Timing</span>
                                </a>
                            </li>
                            <li role="cuisine" class="disabled">
                                <a href="#cuisine" data-toggle="tab" aria-controls="step3" role="tab" title="Cuisine">
                                    <div class="round-tab"></div>
                                    <span>Cuisine</span>
                                </a>
                            </li>

                            <li role="addons" class="disabled">
                                <a href="#addons" data-toggle="tab" aria-controls="complete" role="tab" title="Add Ons">
                                    <div class="round-tab"></div>
                                    <span>Add Ons</span>
                                </a>
                            </li>
                            <li role="payment" class="disabled">
                                <a href="#payment" data-toggle="tab" aria-controls="complete" role="tab" title="Payment">
                                    <div class="round-tab"></div>
                                    <span>Payment</span>
                                </a>
                            </li>
                            <li role="review" class="disabled">
                                <a href="#review" data-toggle="tab" aria-controls="complete" role="tab" title="Review & Book">
                                    <div class="round-tab"></div>
                                    <span>Review & Book</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form role="form" action="{{url('/booking/save')}}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <input type="hidden" name="venue_id" value="{{isset($space_record)? $space_record->venue_id : ''}}" />
                        <input type="hidden" name="user_id" value="{{isset($user_profile)? $user_profile->user_id : ''}}" />
                        <input type="hidden" name="space_id" value="{{isset($space_record)? $space_record->id : ''}}" />
                        <input type="hidden" id="space_price" name="space_price" value="{{isset($space_record)? $space_record->price : '0'}}" />
                        <input type="hidden" name="hotel_owner_id" value="{{isset($hotel_owner)? $hotel_owner->id : ''}}" />
                        <input type="hidden" name="status" value="1" />
                        <div class="tab-content">
                            <div class="tab-pane active" role="tabpanel" id="info">
                                <div class="tab-full-pane">
                                    <h3>Meeting Details</h3>
                                    <div class="form-group group bok-ful-fleid">
                                        <input type="text"  name="purpose"  class="form-control start-date purpose_m" id="purpose" placeholder="Business Startup Meeting">
                                        <label for="purpose">Purpose of Meeting</label>
                                        <lable class="error" id="error_m"></lable>
                                    </div>
                                    <div class="form-group group form-group-left">
                                        <input type="text"  name="startdate"  placeholder="Start Date" onchange="reset_form()" class="form-control start-date date_s" id="date">
                                        <label for="date">Start Date</label>
                                        <lable class="error" id="error_sd"></lable>
                                    </div>
                                    <div class="form-group group form-group-right">
                                        <input type="text"  name="enddate" placeholder="End Date"  onchange="reset_form()" class="form-control end-date end-date_e" id="end-date">
                                        <label for="end-date">End Date</label>
                                        <lable class="error" id="error_ed"></lable>
                                    </div>

                                    <ul class="list-inline pull-right">
                                        <li><button type="button" id="first" class="btn ani-btn next-step">Next</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="timing">
                                <div class="tab-left-pane" id="adjustli">
                                    <h3>Meeting Timing</h3>
                                    <input type="hidden" value="" name="total_days" id="total_days">
                                    <input type="hidden" value="" name="firstscreentotal" id="firstscreentotal">
                                    <input type="hidden" value="" name="secondscreentotal" id="secondscreentotal">
                                    <input type="hidden" value="" name="thirdscreentotal" id="thirdscreentotal">
                                {{--@php  dump($sitting_plan);--}}
                                {{--dump($space_food_duration);--}}
                                {{--@endphp--}}

                                <!-- Nav tabs -->
                                    <div class="card">
                                        <ul class="nav nav-tabs" role="tablist" id="timeheader">
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content" id="timecontent">
                                        </div>
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn prev-step">Previous</button></li>
                                        <li><button type="button" id="second" class="btn ani-btn next-step">Next</button></li>
                                    </ul>
                                </div>
                                <div class="tab-right-pane">
                                    <h3><span>Booking</span>Summary</h3>
                                    <div class="panel-group timesummery" id="accordion" >

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="cuisine">
                                <div class="tab-left-pane">
                                    <h3>Choose Cuisine</h3>
                                    <!-- Nav tabs -->
                                    <div class="card">
                                        <ul class="nav nav-tabs" role="tablist" id="cuisineheader">

                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content" id="cuisinecontent">

                                        </div>
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn prev-step">Previous</button></li>
                                        <li><button type="button" id="third" class="btn ani-btn next-step">Next</button></li>
                                    </ul>
                                </div>
                                <div class="tab-right-pane">
                                    <h3><span>Booking</span>Summary</h3>

                                    <div class="panel-group timesummery2" id="accordion">

                                    </div>
                                </div>



                            </div>
                            <div class="tab-pane" role="tabpanel" id="addons">
                                <div class="tab-left-pane">
                                    <h3>Add Ons</h3>

                                    <!-- Nav tabs -->
                                    <div class="card">
                                        <ul class="nav nav-tabs" role="tablist" id="addonesheader">
                                            {{--<li class="active"><a href="#addonday1" aria-controls="home" role="tab" data-toggle="tab">Day One</a></li>--}}
                                            {{--<li><a href="#addonday2" aria-controls="profile" role="tab" data-toggle="tab">Day Two</a></li>--}}
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content" id="addonescontent">



                                        </div>

                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn prev-step">Previous</button></li>
                                        <li><button type="button" id="four" class="btn ani-btn next-step">Next</button></li>
                                    </ul>

                                </div>
                                <div class="tab-right-pane">
                                    <h3><span>Booking</span>Summary</h3>
                                    <div class="panel-group timesummery3" id="accordion">

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" role="tabpanel" id="payment">
                                <div class="tab-left-pane">
                                    <h3>Billing Information</h3>

                                    <?php // dump($user_profile);
                                    $parts = explode(" ", $user->name);
                                    $last = array_pop($parts);
                                    $first = implode(" ", $parts);


                                    ?>
                                    <div class="form-group group form-group-left">
                                        <input type="text" value="{{isset($first)? $first : ''}}"  name="firstname"  placeholder="First Name" class="form-control start-date" id="name">
                                        <label for="name">First Name</label>
                                    </div>
                                    <div class="form-group group form-group-right">
                                        <input type="text" value="{{isset($last)? $last : ''}}"  name="lastname" placeholder="Last Name" class="form-control end-date" id="lname">
                                        <label for="lname">Last Name</label>
                                    </div>
                                    <div class="form-group group bok-ful-fleid">
                                        <input type="text"  name="address" value="{{isset($user_profile)? $user_profile->address : ''}}"  class="form-control start-date" id="purpose" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry.">
                                        <label for="purpose">Billing Address</label>
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn prev-step">Previous</button></li>
                                        <li><button type="button" id="five"  class="btn ani-btn next-step">Next</button></li>
                                    </ul>
                                </div>
                                <div class="tab-right-pane">
                                    <h3><span>Booking</span>Summary</h3>
                                    <div class="panel-group timesummery4" id="accordion">

                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" role="tabpanel" id="review">
                                <div class="flow-summry">
                                    <h3>Booking Summary</h3>
                                    <div class="bsummary-box col-sm-7 no-b-r">
                                        <h5>Name of individual / company</h5>
                                        <p>{{isset($user)? $user->name : ''}}</p>
                                    </div>
                                    <div class="bsummary-box col-sm-3 no-b-r">
                                        <h5>Email Id</h5>
                                        <p>{{isset($user)? $user->email : ''}}</p>
                                    </div>
                                    <div class="bsummary-box col-sm-2">
                                        <h5>Contact Number</h5>
                                        <p>+71 0256 2589</p>
                                    </div>
                                    <div class="bsummary-box col-sm-8 no-b-r">
                                        <h5>Purpose of Meeting</h5>
                                        <p id="last_purpose"></p>
                                    </div>
                                    <div class="bsummary-box col-sm-2 no-b-r">
                                        <h5>Start Date</h5>
                                        <p id="last_date"></p>
                                    </div>
                                    <div class="bsummary-box col-sm-2">
                                        <h5>End Date</h5>
                                        <p id="last_end-date"></p>
                                    </div>
                                    {{-------------Days Sections -----------------}}
                                    <div class="days_section" id="days_section">

                                    </div>


                                    {{--<h6>Payment Method</h6>--}}
                                    {{--<div class="bsummary-box col-sm-6 no-b-r">--}}
                                    {{--<h5>Card Holder Name</h5>--}}
                                    {{--<p>Nadeem Majeed</p>--}}
                                    {{--</div>--}}
                                    {{--<div class="bsummary-box col-sm-6">--}}
                                    {{--<h5>Card Number</h5>--}}
                                    {{--<p>xxxxxxxxxxx</p>--}}
                                    {{--</div>--}}
                                    <div class="bsummary-result col-sm-6">
                                        {{--<p>Sub Total<span>AED 45,000</span></p>--}}
                                        {{--<p>Tax (15%)<span>AED 5,000</span></p>--}}
                                        {{--<hr>--}}
                                        {{--<p>Tax (15%)<span>AED 5,000</span></p>--}}
                                        {{--<div class="partial">--}}
                                        {{--<i>Partial Payment </i>--}}
                                        {{--<select>--}}
                                        {{--<option>20%</option>--}}
                                        {{--<option>30%</option>--}}
                                        {{--</select>--}}
                                        {{--<span>- AED 5,000</span>--}}
                                        {{--</div>--}}
                                        {{--<p class="stotle">Total Due<span id="last_grand_total"></span></p>--}}
                                        <p class="stotle">Grand Total<span id="last_grand_total_lable"></span></p>
                                        <input type="hidden" name="grand_total" id="last_grand_total" ></p>
                                        <div class="form-group form-check ">
                                            <input type="checkbox" id="agree">
                                            <label for="agree">By Click on Book Now you are agree to our <a href="#">Terms & Conditions</a></label>
                                        </div>
                                        <hr/>
                                    </div>
                                    <ul class="list-inline col-sm-12">
                                        <li><button type="button" class="btn prev-step">Previous</button></li>
                                        <li ><button type="submit" class="btn ani-btn book-step">Book Now</button></li>
                                        <li><button type="button" class="cancle-step">Cancel</button></li>
                                    </ul>
                                </div><!-- flow-summry" -->
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                    <div id="tem_html"></div>
                </div><!--wized-->
            </div><!--wrap-->
        </div><!--container-->
        <div class="clearfix"></div>
    </section><!-- booking-flow-section -->


@endsection

@section('footer')
    @include('site.layouts.footer')

    <script type="text/javascript">

        perperson = parseInt($('#space_price').val());

        function space_addone_options(){
            var time = {!! json_encode($space_add_ons) !!};
            var space_option = '';
            $.each(time , function (key , value) {
                space_option += '<option value="'+value['id']+'" data-src="'+value['image_address']+'">'+value['name']+'<span>AED '+value['price']+'</span></option>'
            });
            return space_option;
        }

        function timeoptionswithselected(selected_number , starttime , endtime) {
            var timeoptions = "";
            var format = '';
            var j = 0;
            var selectedclass = '';
            if(endtime > 24 || endtime == '') endtime = 24;
            if(starttime < 1 || starttime == '') starttime = 1;
            var halftime = Math.round(endtime / 2);
            for(var i = starttime; i<= endtime; i++){
                if(i == selected_number) selectedclass = 'selected'; else selectedclass = '';
                if(i < 12) {
                    format = ':00 AM';
                    timeoptions += '<option '+selectedclass+' value="'+i+'">'+i + format+'</option>';
                } else {
                    format = ':00 PM'; j = i - halftime;
                    if(j == 0)  timeoptions += '<option '+selectedclass+' value="'+i+'">'+12 + format+'</option>';
                    else timeoptions += '<option '+selectedclass+' value="'+i+'">'+j + format+'</option>';
                }

            }
            if(endtime == 24) timeoptions += '<option value="24">12:00 AM</option>';
            return timeoptions
        }
        // var time = '18:00';
        // console.log(tConvert (time.trim ()))
        function tConvert (time) {
            // Check correct time format and split into components
            time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

            if (time.length > 1) { // If time format correct
                time = time.slice (1);  // Remove full string match value
                time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
                time[0] = +time[0] % 12 || 12; // Adjust hours
            }
            return time.join (''); // return adjusted time or original string
        }


        $("#btnConvert").on("click", function () {
            ConvertTimeformat("24", $("#txttime").val());
        });

        $(document).ready(function () {

            // var s_day = 9;
            // var e_day = 14;
            // console.log(time_categorys(s_day , e_day));
            // console.log(get_per_day_cosine(s_day , e_day));

            {{--var morning_options = '';--}}
            {{--var morning_plan = {!! json_encode($morning_food_categories) !!}--}}

            {{--for(var i = 0; i < morning_plan.length; i++) {--}}
            {{--var  plan_id =  morning_plan[i]['id'];--}}
            {{--var  plan_title =  morning_plan[i]['title']+ ':' + morning_plan[i]['currency'] + ' ' + morning_plan[i]['price'];--}}
            {{--morning_options  += '<option value="' +  plan_id + '">'+  plan_title + '</option>';--}}
            {{--}--}}
            {{--console.log(morning_options);--}}


            //Initialize tooltips
            $('.nav-tabs > li a[title]').tooltip();
            //Wizard
            $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

                var $target = $(e.target);

                if ($target.parent().hasClass('disabled')) {
                    return false;
                }
            });

            $(".next-step").click(function (e) {


                if(this.id  == 'first'){

                    if(cal_days()){
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled')
                            .addClass('continue')
                            .prevAll().addClass( "complete" )
                            .removeClass('continue');
                        nextTab($active);
                        var dObj = $(".date_s").val();
                        var edObj = $(".end-date_e").val();

                        if($('.timesummery #capacity1').length == 0) {
                            generate_html_views(dObj , edObj);
                            genrate_html_cusine();
                            //it doesn't exist
                        }


                        // var is_already_genrated = $('#timeheader').html();
                        // console.log(is_already_genrated);
                        // if(!trim(is_already_genrated)) generate_html_views(dObj , edObj);

                    }

                }else if(this.id  == 'second') {
                    console.log('second');
                    if (second_form_validate()) {
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled')
                            .addClass('continue')
                            .prevAll().addClass("complete")
                            .removeClass('continue');
                        nextTab($active);



                        // if($('.timesummery2 #capacity1').length == 0) {
                        //
                        //     //it doesn't exist
                        // }
                        var bill = $('.timesummery').html();
                        var bill = bill.replace(/summary/g, "summary2");
                        $('.timesummery2').html(bill);
                        genrate_html_cusine();
                        // // next screen total set 0
                        $('#secondscreentotal').val('0');
                        $('#thirdscreentotal').val('0');
                        update_grand_total();


                        //
                        // var bill = $('.timesummery').html();
                        // var bill = bill.replace(/summary/g, "summary2");
                        // $('.timesummery2').html(bill);

                        // genrate_html_cusine();
                        // var start_times = get_booking_selected_start_times();
                        // var end_times = get_booking_selected_end_times();
                        //
                        // // console.log(start_times);
                        // var total_days = start_times.length;
                        // for (var i = 0; i <= total_days; i++) {
                        //     // console.log("#cuisineday" + i);
                        //     // console.log(get_per_day_cosine(start_times[i], end_times[i]));
                        //     var j = i + 1;
                        //     $("#cuisineday" + j).append(get_per_day_cosine(start_times[i], end_times[i]));
                        // }

                        $("#cuisineheader>li").removeClass("complete continue active");
                        $('#cuisineheader>li:first-child').addClass('active');
                        $("#cuisinecontent [id^='cuisineday']").removeClass('active');
                        $('#cuisinecontent #cuisineday1').addClass('active');



                    }


                }else if(this.id  == 'third'){
                    console.log('third');
                    if(second_form_validate()){
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled')
                            .addClass('continue')
                            .prevAll().addClass( "complete" )
                            .removeClass('continue');
                        nextTab($active);

                        var bill = $('.timesummery2').html();
                        var bill = bill.replace(/summary2/g, "summary3");
                        $('.timesummery3').html(bill);

                        $('.gaddones').val('').trigger("change");


                        $("#addonesheader>li").removeClass("complete continue active");
                        $('#addonesheader>li:first-child').addClass('active');
                        $("#addonescontent [id^='addonday']").removeClass('active');
                        $('#addonescontent #addonday1').addClass('active');
                    }


                }else if(this.id == 'five'){
                    genrate_review_html();
                    var $active = $('.wizard .nav-tabs li.active');
                    $active.next().removeClass('disabled')
                        .addClass('continue')
                        .prevAll().addClass( "complete" )
                        .removeClass('continue');
                    nextTab($active);

                }else{
                    var $active = $('.wizard .nav-tabs li.active');
                    $active.next().removeClass('disabled')
                        .addClass('continue')
                        .prevAll().addClass( "complete" )
                        .removeClass('continue');
                    var bill = $('.timesummery3').html();
                    $('.timesummery4').html(bill);
                    nextTab($active);
                }
            });

            $(".prev-step").click(function (e) {

                var $active = $('.wizard .nav-tabs li.active');
                prevTab($active);

            });
        });
        function time_categorys(start_time , end_time){
            var total_c = [];
            var category = {!! json_encode($space_food_duration) !!}
            var s_day = parseInt(start_time);
            var e_day = parseInt(end_time);
            var firstentry = '';
            var secondentry = '';
            var thirdentry = '';
            for(var i = 0; i < category.length; i++){
                var db_stime = parseInt(category[i]['start_time'].substr(0, 2));
                var db_etime = parseInt(category[i]['end_time'].substr(0, 2));
                // console.log(s_day + '-' + e_day);
                // console.log(db_stime + '-' + db_etime);
                if(s_day < db_etime && firstentry !== 'ok'){
                    // console.log('enteri' + i);
                    total_c.push(category[i]['food_duration']);
                    firstentry = 'ok';
                    // console.log(total_c)
                    i = i+1;
                    for(var j = i ; j < category.length; j++){
                        // console.log('enterj' + j);
                        // console.log(e_day + 'compare' + db_etime);
                        var db_stime = parseInt(category[j]['start_time'].substr(0, 2));
                        var db_etime = parseInt(category[j]['end_time'].substr(0, 2));
                        // console.log(s_day + 'compare' + db_stime);
                        // console.log(e_day + 'compare' + db_etime);
                        if((e_day < db_etime || e_day >= db_stime) && e_day >= db_stime && secondentry !== 'ok') {
                            // console.log('checkj' + j);
                            total_c.push(category[j]['food_duration'])
                            secondentry = 'ok';
                            // console.log(total_c)
                            j = j+1;
                            for(var k = j ; k < category.length; k++){
                                var db_stime = parseInt(category[k]['start_time'].substr(0, 2));
                                var db_etime = parseInt(category[k]['end_time'].substr(0, 2));
                                // console.log('enterk' + k);
                                // console.log(s_day + 'compare' + db_stime);
                                // console.log(e_day + 'compare' + db_etime);
                                if(e_day <= db_etime && e_day >= db_stime && s_day < db_stime) {
                                    // console.log('checkk' + k);
                                    total_c.push(category[k]['food_duration']);
                                    thirdentry = 'ok';
                                }
                                // console.log(total_c);
                            }

                        }
                        // console.log(total_c);
                    }
                    // if(e_day < db_etime) total_c.push(category[i]['food_duration'])
                }

                // console.log(total_c);
            }
            return total_c;
        }
        function nextTab(elem) {

            $(elem).next().find('a[data-toggle="tab"]').click();
        }
        function prevTab(elem) {
            $(elem).prev().find('a[data-toggle="tab"]').click();
        }
        (function() {

            $(".panel").on("show.bs.collapse hide.bs.collapse", function(e) {
                if (e.type=='show'){
                    $(this).addClass('active');
                }else{
                    $(this).removeClass('active');
                }
            });

        }).call(this);

        function cal_total_price(){
            var elems = $( ".timesummery [id^='dayprice']");
            //Retrieve html
            // console.log(elems);
            var total_price = 0;
            elems.each( function() {
                var html = localStorage.getItem( this.id );
                var html1 = localStorage.setItem( this.id, this.innerHTML );
                // console.log(localStorage);
                // console.log(html);
                // console.log(html1);
                if(html) {
                    // console.log(html);
                    total_price += parseInt(html);
                    $('#firstscreentotal').val(total_price);

                }
            });
            update_grand_total();

        }
        function get_booking_selected_start_times(){
            var stimes = $( "[id^='stime']");
            var total_s_time = [];
            $.each( stimes , function( key, value ) {
                key = parseInt(key) + 1;
                total_s_time.push($('#stime' + key).val());
            });
            return total_s_time;
        }
        function get_booking_selected_end_times(){
            var etimes = $( "[id^='etime']");
            var total_e_time = [];
            $.each( etimes , function( key, value ) {
                key = parseInt(key) + 1;
                total_e_time.push($('#etime' + key).val());
            });
            return total_e_time;
        }
        function get_per_day_cosine(start_time , end_time , tab){

            // var time_categorys = time_categorys(starttime , endtime);
            var total_c = [];
            var category = {!! json_encode($space_food_duration) !!}
            var s_day = parseInt(start_time);
            var e_day = parseInt(end_time);
            var firstentry = '';
            var secondentry = '';
            var thirdentry = '';


            // -----------------------------------------------------------------------------

            var morning_plan = {!! json_encode($morning_food_categories) !!}
            var  morning_options  = '<option value="">- Select Food Category -</option>';
            for(var i = 0; i < morning_plan.length; i++) {
                var  plan_id =  morning_plan[i]['id'];
                var  plan_title =  morning_plan[i]['title']+ ':' + morning_plan[i]['currency'] + ' ' + morning_plan[i]['price'];
                morning_options  += '<option value="' +  plan_id + '">'+  plan_title + '</option>';
            }

            var afternoon_plan = {!! json_encode($afternoon_food_categories) !!}
            var  afternoon_options  = '<option value="">- Select Food Category -</option>';
            for(var i = 0; i < afternoon_plan.length; i++) {
                var  plan_id =  afternoon_plan[i]['id'];
                var  plan_title =  afternoon_plan[i]['title']+ ':' + afternoon_plan[i]['currency'] + ' ' + afternoon_plan[i]['price'];
                afternoon_options  += '<option value="' +  plan_id + '">'+  plan_title + '</option>';
            }

            var evening_plan = {!! json_encode($evening_food_categories) !!}
            var  evening_options  = '<option value="">- Select Food Category -</option>';
            for(var i = 0; i < evening_plan.length; i++) {
                var  plan_id =  evening_plan[i]['id'];
                var  plan_title =  evening_plan[i]['title']+ ':' + evening_plan[i]['currency'] + ' ' + evening_plan[i]['price'];
                evening_options  += '<option value="' +  plan_id + '">'+  plan_title + '</option>';
            }
            // -----------------------------------------------------------------------------

            // $morning_food_categories
            // $afternoon_food_categories
            // $evening_food_categories



            for(var i = 0; i < category.length; i++){
                var db_stime = parseInt(category[i]['start_time'].substr(0, 2));
                var db_etime = parseInt(category[i]['end_time'].substr(0, 2));
                // console.log(s_day + '-' + e_day);
                // console.log(db_stime + '-' + db_etime);
                if(s_day < db_etime && firstentry !== 'ok'){
                    // console.log('enteri' + i);
                    total_c.push(category[i]['food_duration']);
                    firstentry = 'ok';
                    // console.log(total_c)
                    i = i+1;
                    for(var j = i ; j < category.length; j++){
                        // console.log('enterj' + j);
                        // console.log(e_day + 'compare' + db_etime);
                        var db_stime = parseInt(category[j]['start_time'].substr(0, 2));
                        var db_etime = parseInt(category[j]['end_time'].substr(0, 2));
                        // console.log(s_day + 'compare' + db_stime);
                        // console.log(e_day + 'compare' + db_etime);
                        if((e_day < db_etime || e_day >= db_stime) && e_day >= db_stime && secondentry !== 'ok') {
                            // console.log('checkj' + j);
                            total_c.push(category[j]['food_duration'])
                            secondentry = 'ok';
                            // console.log(total_c)
                            j = j+1;
                            for(var k = j ; k < category.length; k++){
                                var db_stime = parseInt(category[k]['start_time'].substr(0, 2));
                                var db_etime = parseInt(category[k]['end_time'].substr(0, 2));
                                // console.log('enterk' + k);
                                // console.log(s_day + 'compare' + db_stime);
                                // console.log(e_day + 'compare' + db_etime);
                                if(e_day <= db_etime && e_day >= db_stime && s_day < db_stime) {
                                    // console.log('checkk' + k);
                                    total_c.push(category[k]['food_duration']);
                                    thirdentry = 'ok';
                                }
                                // console.log(total_c);
                            }

                        }
                        // console.log(total_c);
                    }
                    // if(e_day < db_etime) total_c.push(category[i]['food_duration'])
                }

                // console.log(total_c);
            }

            // -------------------------
            var total_selection = '';
            var total_counter = 0;
            $.each(total_c , function (key ,value) {
                if(value == 'Morning') {
                    total_selection += '<div class="form-group group bok-ful-fleid cuisine-filed">' +
                        '                   <select id="cuisine_'+tab+'_'+key+'_'+value+'" onchange="update_cuisine_summary(this.value , this.id)">' +
                        '"'+ morning_options +'"' +
                        '                   </select>' +
                        '                   <label for="cuisine">Select Breakfast</label>' +
                        '               </div>';
                    total_counter += 1;
                }
                if(value == 'Afternoon') {
                    total_selection += '<div class="form-group group bok-ful-fleid cuisine-filed">' +
                        '                   <select id="cuisine_'+tab+'_'+key+'_'+value+'" onchange="update_cuisine_summary(this.value , this.id)">' +
                        '"'+ afternoon_options +'"' +
                        '                   </select>' +
                        '                   <label for="cuisine">Select Lunch</label>' +
                        '               </div>';
                    total_counter += 1;
                }
                if(value == 'Evening') {
                    total_selection += '<div class="form-group group bok-ful-fleid cuisine-filed">' +
                        '                   <select id="cuisine_'+tab+'_'+key+'_'+value+'" onchange="update_cuisine_summary(this.value , this.id)">' +
                        '"'+ evening_options +'"' +
                        '                   </select>' +
                        '                   <label for="cuisine">Select Dinner</label>' +
                        '               </div>';
                    total_counter += 1;
                }
            })
            // console.log(total_counter);
            // console.log(tab);
            var makeid = parseInt(tab)+1;
            // console.log(makeid)
            $('.timesummery2 #total_cosine'+makeid).val(total_counter);  // usman butt

            return total_selection;
        }
        function set_values_lables(value , d_id){

            var id_name = d_id.replace(/[0-9]/g, '');
            var id_number = parseInt(d_id.match(/\d+/),10);
            if(id_name == '#people'){
                var perdaytotal = parseInt(perperson) * parseInt(value);
                if(value) {
                    $("#dayprice"+id_number).html(perdaytotal);
                    $(d_id).html(value);
                }
                else {
                    $("#dayprice"+id_number).html(perperson);
                    $(d_id).html(1);
                }
                cal_total_price();
            }else if(id_name == '#st' || id_name == '#et'){
                if(value > 9) value = value+':00';
                else value = '0'+value+':00';
                $(d_id).html(tConvert(value));
            }else{
                // console.log(id_name);
                // console.log(id_number);
                $(d_id).html(value);
                cal_total_price()
            }
            cal_total_price()


        }
        function convertNumberToWords(amount) {
            var words = new Array();
            words[0] = '';
            words[1] = 'One';
            words[2] = 'Two';
            words[3] = 'Three';
            words[4] = 'Four';
            words[5] = 'Five';
            words[6] = 'Six';
            words[7] = 'Seven';
            words[8] = 'Eight';
            words[9] = 'Nine';
            words[10] = 'Ten';
            words[11] = 'Eleven';
            words[12] = 'Twelve';
            words[13] = 'Thirteen';
            words[14] = 'Fourteen';
            words[15] = 'Fifteen';
            words[16] = 'Sixteen';
            words[17] = 'Seventeen';
            words[18] = 'Eighteen';
            words[19] = 'Nineteen';
            words[20] = 'Twenty';
            words[30] = 'Thirty';
            words[40] = 'Forty';
            words[50] = 'Fifty';
            words[60] = 'Sixty';
            words[70] = 'Seventy';
            words[80] = 'Eighty';
            words[90] = 'Ninety';
            amount = amount.toString();
            var atemp = amount.split(".");
            var number = atemp[0].split(",").join("");
            var n_length = number.length;
            var words_string = "";
            if (n_length <= 9) {
                var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
                var received_n_array = new Array();
                for (var i = 0; i < n_length; i++) {
                    received_n_array[i] = number.substr(i, 1);
                }
                for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                    n_array[i] = received_n_array[j];
                }
                for (var i = 0, j = 1; i < 9; i++, j++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        if (n_array[i] == 1) {
                            n_array[j] = 10 + parseInt(n_array[j]);
                            n_array[i] = 0;
                        }
                    }
                }
                value = "";
                for (var i = 0; i < 9; i++) {
                    if (i == 0 || i == 2 || i == 4 || i == 7) {
                        value = n_array[i] * 10;
                    } else {
                        value = n_array[i];
                    }
                    if (value != 0) {
                        words_string += words[value] + " ";
                    }
                    if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Crores ";
                    }
                    if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Lakhs ";
                    }
                    if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                        words_string += "Thousand ";
                    }
                    if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                        words_string += "Hundred and ";
                    } else if (i == 6 && value != 0) {
                        words_string += "Hundred ";
                    }
                }
                words_string = words_string.split("  ").join(" ");
            }
            return words_string;
        }
        // Returns an array of dates between the two dates
        var getDates = function(startDate, endDate) {
            var dates = [],
                currentDate = startDate,
                addDays = function(days) {
                    var date = new Date(this.valueOf());
                    date.setDate(date.getDate() + days);
                    return date;
                };
            while (currentDate <= endDate) {
                dates.push(currentDate);
                currentDate = addDays.call(currentDate, 1);
            }
            return dates;
        };

        var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        function generate_html_views(startday , endday){
            var totalhead_timing = '';
            var totalcontent_timing = '';

            var totalhead_cuisine = '';
            var totalcontent_cuisine = '';

            var totalhead_addons = '';
            var totalcontent_addons = '';

            var totalsummery = '';
            var classactive = '';

            var preview = '';


            var colin = '';
            // -------------------Data Section (Options)-----------------------------------
            var total_options = '';
            var sitting_plan = {!! json_encode($sitting_plan) !!}
            var base_url = '{{url('storage/images/sitting-plan/')}}';
            for(var i = 0; i < sitting_plan.length; i++) {
                var sittingplan_id = sitting_plan[i]['id'];
                var sittingplan_title = sitting_plan[i]['title'];
                var sittingplan_image = base_url +'/'+ sitting_plan[i]['image'];
                total_options  += '<option value="' + sittingplan_id + '" data-src="'+sittingplan_image+'">'+ sittingplan_title + '</option>';
            }


            var day_start = new Date(startday);
            var day_end = new Date(endday);
            var dates = getDates(day_start, day_end);
            var total_days = dates.length;
            total_days = parseInt(total_days);
            var i = 1;
            $('#total_days').val(total_days );
            var signaldayprice = perperson * total_days;
            dates.forEach(function(date) {
                if(i == 1) { classactive = "active"; colin = "in";}
                else { classactive = ""; colin = ""; }
                var functionpram1 = "#people"+i;
                var stime = "#st"+i;
                var etime = "#et"+i;

                var signaldayprice = perperson;
                totalhead_timing += '<li class="'+ classactive +'"><a href="#day'+i+'" aria-controls="home" role="tab" data-toggle="tab">Day ' +convertNumberToWords(i)+'</a></li>'
                totalcontent_timing += '<div role="tabpanel" class="tab-pane '+ classactive +'" id="day'+i+'">' +
                    '<div class="form-group group form-group-left">' +
                    '<input type="number" min="1" name="capacity'+i+'" data-soler = "abc" value="1" onkeyup = "set_values_lables(this.value , \'' + functionpram1 + '\')" class="form-control" id="capacity'+i+'">' +
                    '<label for="people">Number of People</label></div>' +
                    '<div class="form-group group form-group-right">'+
                    '<select class="select-img" name = "layout'+i+'" id="layout'+i+'">' +
                    '"'+ total_options +'"' +
                    '</select>'+
                    '<label for="">Layout</label></div>'+
                    '<div class="form-group group form-group-left">'+
                    // '<input type="text"  name="stime'+i+'"  placeholder="Start Time" onkeyup = "set_values_lables(this.value , \'' + stime + '\')" class="form-control start-date timepicker" id="stime'+i+'">'+
                    '<select name="stime'+i+'"  onchange = "set_values_lables(this.value , \'' + stime + '\'); genrate_html_cusine();"  class="form-control start-date" id="stime'+i+'">' +
                    '"'+ timeoptionswithselected(9 , 8 , 23) +'"' +
                    '</select>'+
                    '<label for="date">Start Time</label></div>'+
                    '<div class="form-group group form-group-right">'+
                    // '<input type="text"  name="etime'+i+'" placeholder="End Date" onkeyup = "set_values_lables(this.value , \'' + etime + '\')" class="form-control end-date timepicker" id="etime'+i+'">'+
                    '<select name="etime'+i+'"  onchange = "set_values_lables(this.value , \'' + etime + '\'); genrate_html_cusine();" class="form-control end-date" id="etime'+i+'">' +
                    '"'+ timeoptionswithselected(23 , 8 , 23) +'"' +
                    '</select>'+
                    '<label for="end-date">End Time</label></div>'+
                    '<div class="form-group group bok-ful-fleid">'+
                    '<input type="text"  name="sinstructionname'+i+'"  id="sinstruction'+i+'" class="form-control start-date"  placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry.">'+
                    '<label for="purpose">Special Instructions</label></div></div>';
                totalsummery += '<div class="panel panel-default '+ classactive +'">' +
                    '<input type="hidden" value="" name="total_cosine'+i+'"  id="total_cosine'+i+'" >' +
                    '<input type="hidden" name="total_addone'+i+'" value="" id="total_addone'+i+'">' +
                    '<div class="panel-heading">' +
                    '<h4 class="panel-title">' +
                    '<a data-toggle="collapse" data-parent="#accordion" href="#summary'+convertNumberToWords(i).trimEnd()+'">Day ' +convertNumberToWords(i)+'<span>AED<span id="dayprice'+i+'"> '+signaldayprice+'</span></span></a>' +
                    '</h4></div>' +
                    '<div id="summary'+convertNumberToWords(i).trimEnd()+'" class="panel-collapse collapse '+ colin +'">' +
                    '<div class="panel-body"><p>People <span id = "people'+i+'">1</span></p><p>Date<span>'+ date.getDate() +' '+ months[date.getMonth()] +'</span></p>' +
                    '<p id="sdurations'+i+'" style="display: none">Duration<span class="sdurations'+i+'"></span></p>' +
                    '<p>Timing<span><span id = "st'+i+'">9:00 AM </span> <i> to </i>   <span id = "et'+i+'">11:00 PM</span></span></p>' +
                    '<div id="cuisine'+i+'"></div>' +
                    '<div id="addonssum'+i+'"></div>' +
                    '</div></div></div>';
                // ------------------------------------------------------------------------------------------------------------
                totalhead_cuisine += '<li class="'+ classactive +'"><a href="#cuisineday'+i+'" aria-controls="home" role="tab" data-toggle="tab">Day ' +convertNumberToWords(i)+'</a></li>';
                totalcontent_cuisine += ' <div role="tabpane'+i+'" class="tab-pane '+ classactive +'" id="cuisineday'+i+'">' +
                    '<input type="hidden" name="total_cuisine_price'+i+'" value="" id="total_cuisine_price'+i+'">' +

                    '</div>';
                // ------------------------------------------------------------------------------------------------------------
                totalhead_addons += '<li class="'+ classactive +'"><a href="#addonday'+i+'" aria-controls="home" role="tab" data-toggle="tab">Day ' +convertNumberToWords(i)+'</a></li>';
                totalcontent_addons += '<div role="tabpane'+i+'" class="tab-pane '+ classactive +'" id="addonday'+i+'">' +
                    ' <div class="form-group group bok-ful-fleid addons-filed">' +
                    '                                        <label for="addon">Select Add Ons</label>' +
                    '                                        <select id="addone'+i+'" class="js-select2-multi gaddones"  multiple="multiple" name="addons[]" onchange="update_addons_summary(this.id , '+i+')" >' +
                    ''+ space_addone_options() +'' +
                    // '                                            <option data-src="http://didododo.com/conpherence/images/am-icon.png">Air Conditioning <span>AED 20</span></option>' +
                    // '                                            <option data-src="http://didododo.com/conpherence/images/am-icon2.png">Cable TV  <span>AED 20</span></option>' +
                    // '                                            <option data-src="http://didododo.com/conpherence/images/am-icon5.png">Laundry Service <span>AED 20</span></option>' +
                    // '                                            <option data-src="http://didododo.com/conpherence/images/am-icon9.png">Parking <span>AED 20</span></option>' +
                    '                                        </select>' +
                    '                                  </div></div>';


                {{--<div role="tabpanel" class="tab-pane active" id="addonday1">--}}
                        {{--<div class="form-group group bok-ful-fleid">--}}
                        {{--<select id="addon">--}}
                        {{--<option>Search</option>--}}
                        {{--</select>--}}
                        {{--<label for="addon">Select Add Ons</label>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<div role="tabpanel" class="tab-pane active" id="addonday2">--}}
                        {{--<div class="form-group group bok-ful-fleid">--}}
                        {{--<select id="addon">--}}
                        {{--<option>Search</option>--}}
                        {{--</select>--}}
                        {{--<label for="addon">Select Add Ons</label>--}}
                        {{--</div>--}}
                        {{--</div>--}}

                    i++;

            });
            totalsummery += '<div class="booking-result"> <p>Total<span>AED <span id="total_price">'+signaldayprice+'</span></span></p> </div>';
            // console.log(totalhead);
            $('#timeheader').append(totalhead_timing);
            $('#timecontent').append(totalcontent_timing);
            $('#cuisineheader').append(totalhead_cuisine);
            $('#cuisinecontent').append(totalcontent_cuisine);
            $('#addonesheader').append(totalhead_addons);
            $('#addonescontent').append(totalcontent_addons);
            $('.timesummery').append(totalsummery);
            $('#firstscreentotal').val(signaldayprice);
            $('.select-img').select2({
                minimumResultsForSearch: Infinity,
                templateResult: formatState,
                templateSelection: formatState
            });
            $(".js-select2-multi").select2({
                templateResult: formatState,
                templateSelection: formatState,
                placeholder: "Select a Item",
                allowClear: true
            });

        }
        function genrate_html_cusine(){

            var start_times = get_booking_selected_start_times();
            var end_times = get_booking_selected_end_times();
            var total_days = start_times.length;
            var totaltabs = $('#total_days').val();
            if(parseInt(total_days) == parseInt(totaltabs)) {
                for (var i = 0; i <= total_days; i++) {
                    var j = i + 1;
                    $("#cuisineday" + j).html('');
                    $("#cuisineday" + j).append(get_per_day_cosine(start_times[i], end_times[i] , i));
                }
            }
            // // next screen total set 0
            // $('#secondscreentotal').val('0');
            // $('#thirdscreentotal').val('0');
        }

        function update_cuisine_summary(value , id){

            var id_section = id.split("_");
            var id_name = id_section[0];
            var id_tabno = id_section[1]; id_tabno = parseInt(id_tabno) + 1;
            var id_select_no = id_section[2];
            var id_duration = id_section[3];

            var value_text = $("#"+id+" option:selected").text();
            var value_val = $("#"+id+" option:selected").val();

            // working
            if(value_val) {
                var selections = value_text.split(":");
                // console.log(id_tabno);
                if($(".timesummery2 #cuisine"+id_tabno).has("p").length) {
                    // console.log('2nd time')
                    $("[id^='p_"+id+"']").remove();
                    $('.timesummery2  #cuisine' + id_tabno).append('<p id="p_' + id + '">' + selections[0] + '<span><span>'+selections[1].replace(/[0-9]/g, '')+'</span><span id="cusineprice_' + id + '">' + parseInt(selections[1].match(/\d+/),10) + '</span></span></p>');
                    // add value in per day cusine total
                    var last_cusine_val =  $('.timesummery2 #total_cosine' + id_tabno).val(); // get last current day total
                    var last_cval_t = parseInt(last_cusine_val) + parseInt(selections[1].match(/\d+/),10);
                    // now update day total
                    $('.timesummery2 #total_cosine'+id_tabno).val(last_cval_t);
                    // add value in per day total
                    var last_perday_val = $('.timesummery #dayprice'+id_tabno).html(); // get last step total
                    var last_cusine_per_day_total = parseInt(last_perday_val) + last_cval_t; // add last step per day total plus total cusine per day
                    $('.timesummery2 #dayprice'+id_tabno).html(last_cusine_per_day_total);

                    // console.log(parseInt(last_cusine_val) +'+'+ parseInt(selections[1].match(/\d+/),10) + '=' + last_cval_t);
                    // console.log('cuisin total = ' + last_cval_t);
                    // console.log('per day total =' + parseInt(last_cval_t) +'+'+ parseInt(last_perday_val) + '=' + last_cusine_per_day_total);

                }else{
                    // console.log('1st time')
                    $('.timesummery2  #cuisine' + id_tabno).append('<p id="p_' + id + '">' + selections[0] + '<span><span>' + selections[1].replace(/[0-9]/g, '') + '</span><span id="cusineprice_' + id + '">' + parseInt(selections[1].match(/\d+/),10) + '</span></span></p>');
                    // add value in per day total
                    var last_val = $('.timesummery #dayprice'+id_tabno).html(); // get last step total
                    var last_cusine_per_day_total = parseInt(last_val) + parseInt(selections[1].match(/\d+/),10);

                    // console.log('cuisin total = ' + parseInt(selections[1].match(/\d+/),10));
                    // console.log('per day total =' + parseInt(last_val) +'+'+ parseInt(selections[1].match(/\d+/),10) + '=' + last_cusine_per_day_total);

                    $('.timesummery2 #total_cosine'+id_tabno).val(parseInt(selections[1].match(/\d+/),10));
                    $('.timesummery2 #dayprice'+id_tabno).html(last_cusine_per_day_total);
                }
                // add value in per day total
//                 var last_val = $('.timesummery #dayprice').html(); // get last step total
//                 last_val = parseInt(id) + parseInt(selections[1].match(/\d+/),10);
//                 $('#total_cuisine_price' + id_tabno).val(last_val);
//                 $('.timesummery2 #dayprice'+id_tabno).html(last_val);
//                 update_total_cprice();
            }else{
                if($("#p_"+id).length == 0) {

                }else{

                    // cut last value in per day total
                    // console.log('empty value script')
                    var updateval = $(".timesummery2 #p_"+id +" #cusineprice_"+id).html();
                    var lasttotal = $('.timesummery2 #total_cosine' + id_tabno).val();

                    var last_val = parseInt(lasttotal) - parseInt(updateval);
                    // console.log(lasttotal + '-' + updateval + '=' + last_val);
                    $('.timesummery2 #total_cosine'+id_tabno).val(last_val);  // update total cusine value

                    var last_day_val = $('.timesummery #dayprice'+id_tabno).html(); // get last step total
                    $('.timesummery2 #dayprice'+id_tabno).html(parseInt(last_day_val) + last_val);
                    $("[id^='p_"+id+"']").remove();
                    if(!$(".timesummery2 #cuisine"+id_tabno).has("p").length)  $('.timesummery2 #total_cosine' + id_tabno).val(0);

                }

            }

            update_total_cprice();


        }

        function update_total_cprice(){
            var totaldays = $('#total_days').val();
            var totalcusin = 0;
            for(var i = 1; i<= parseInt(totaldays); i++){
                var c_val = $('.timesummery2 #total_cosine'+i).val();
                if(c_val) totalcusin += parseInt($('.timesummery2 #total_cosine'+i).val());
                else totalcusin += parseInt(0);
            }
            // console.log('grand cusine total = ' + totalcusin);
            $("#secondscreentotal").val(totalcusin);

            update_grand_total();
            // -----------------update addones summeary -----
            var bill = $('.timesummery2').html();
            var bill = bill.replace(/summary2/g, "summary3"); //update summary2 to summary 3 everywhere
            $('.timesummery3').html(bill);

        }

        function update_addons_summary(select_id , day){
            var space_array = {!! json_encode($space_add_ons) !!};
            var total_days = $('#total_days').val();


            $('.timesummery3 #addonssum'+ day).html('');
            var values = $("#"+select_id).val();
            var total_price = 0;
            if(values) {
                $.each(space_array, function (key, value) {

                    for (var i = 0; i < values.length; i++) {
                        // console.log('value campare =' + value['id'] + '==' + values[i]);
                        if (value['id'] == values[i]) {
                            // console.log('selected value = ' + value['price']);
                            $('.timesummery3 #addonssum' + day).append('<p>' + value['name'] + '<span>AED ' + value['price'] + '</span></p>');  // append section

                            total_price += parseInt(value['price']);
                            $('.timesummery3 #total_addone' + day).val(total_price);  //pending

                            // var total_price_add =  0;
                            // for(var i=1; i<=parseInt(total_days); i++){
                            //     if(parseInt($('#total_addone'+i).val()))
                            //         total_price_add += parseInt($('#total_addone'+i).val());
                            // }
                            // $('#thirdscreentotal').val(total_price_add);


                        }
                    }

                });
            }else{
                $('.timesummery3 #total_addone' + day).val('0');
            }

            var per_day_cusine = $('.timesummery3 #total_addone'+day).val();
            // console.log("#total_addone"+day);
            // console.log("total addons price = " + per_day_cusine);

            var signalday = $('.timesummery2 #dayprice'+day).html();  // get last day total
            // console.log("last day cusion = " + signalday);
            var totaldayprice = parseInt(signalday) + parseInt(per_day_cusine);
            // console.log(parseInt(signalday) +'+'+ parseInt(per_day_cusine) + " = " + totaldayprice);
            $('.timesummery3 #dayprice'+day).html(totaldayprice);

            //
            var total_price_add = 0;
            for(var i=1; i<=parseInt(total_days); i++){
                if(parseInt($('.timesummery3 #total_addone'+i).val()))
                    total_price_add += parseInt($('.timesummery3 #total_addone'+i).val());
            }
            $('#thirdscreentotal').val(total_price_add);

            update_grand_total();

        }
        function  update_grand_total(){
            var first = $( "#firstscreentotal").val();
            var second = $( "#secondscreentotal").val();
            var third = $( "#thirdscreentotal").val();
            var total = parseInt(first);
            if(second) total += parseInt(second);
            if(third) total +=  parseInt(third);
            $( "[id^='total_price']").text(total);
        }
        function reset_form(){
            $('#timeheader').html('');
            $('#timecontent').html('');
            $('#cuisineheader').html('');
            $('#cuisinecontent').html('');
            $('#addonesheader').html('');
            $('#addonescontent').html('');
            $('.timesummery').html('');
        }
        function cal_days(){

            var pObj = $(".purpose_m").val();
            var dObj = $(".date_s").val();
            var edObj = $(".end-date_e").val();
            var counter = 0;
            if (!pObj) {
                document.getElementById("error_m").innerHTML = "Please fill out this field.";
                counter += 1;
            } else {
                document.getElementById("error_m").innerHTML = "";

            }

            if (!dObj) {
                document.getElementById("error_sd").innerHTML = "Please fill out this field.";
                counter += 1;
            } else {
                document.getElementById("error_sd").innerHTML = "";

            }

            if (!edObj) {
                document.getElementById("error_ed").innerHTML = "Please fill out this field.";
                counter += 1;
            } else {
                document.getElementById("error_ed").innerHTML = "";

            }

            if (counter == 0) {
                return  true;
            } else {
                return  false;

            }
        }
        function second_form_validate(){

            var pObj = $(".purpose_m").val();
            var dObj = $(".date_s").val();
            var edObj = $(".end-date_e").val();
            var counter = 0;
            if (!pObj) {
                document.getElementById("error_m").innerHTML = "Please fill out this field.";
                counter += 1;
            } else {
                document.getElementById("error_m").innerHTML = "";

            }

            if (!dObj) {
                document.getElementById("error_sd").innerHTML = "Please fill out this field.";
                counter += 1;
            } else {
                document.getElementById("error_sd").innerHTML = "";

            }

            if (!edObj) {
                document.getElementById("error_ed").innerHTML = "Please fill out this field.";
                counter += 1;
            } else {
                document.getElementById("error_ed").innerHTML = "";

            }

            if (counter == 0) {
                return  true;

            } else {
                return  false;

            }



        }

        function genrate_review_html(){
            // firststep_data
            var purpose = $('#purpose').val();
            $('#last_purpose').html(purpose);
            var start_d = $('#date').val();
            $('#last_date').html(start_d);
            var end_d = $('#end-date').val();
            $('#last_end-date').html(end_d);
            var total = $('.timesummery3 #total_price').html();
            $('#last_grand_total_lable').html(total);
            $('#last_grand_total').val(total);



            var total_days = $('#total_days').val();
            var day_start = new Date(start_d);
            var day_end = new Date(end_d);
            var dates = getDates(day_start, day_end);
            // console.log(dates);

            var review = '';
            for(var i=1; i<=total_days; i++){

                var capacity = $('#capacity'+i).val();
                var layout = $('#layout'+i+ ' option:selected').text();
                var stime = $('#stime'+i +' option:selected').text();
                var etime = $('#etime'+i +' option:selected').text();
                var sinstruction = $('#sinstruction'+i).val();
                var addones = '';
                $( "#addone"+i+ " option:selected" ).each(function() {
                    addones += '<li><img src="images/am-icon.png" alt="" /><span>'+$( this ).text()+'</span></li>';

                });
                // console.log(addones);

                var cusine = $('.timesummery2 #cuisine'+i).html();
                // console.log(cusine);

                var dayprice = $('.timesummery3 #dayprice'+i).html();

                review += '     <h4>Booking Detail Day '+convertNumberToWords(i)+'<span id="last_perdaytotal">AED '+dayprice+'</span>' +
                    '</h4><div class="bsummary-box col-sm-2 no-b-r">' +
                    '                                        <h5>Number of People</h5>' +
                    '                                        <p>'+capacity+'</p>' +
                    '                                    </div>' +
                    '                                    <div class="bsummary-box col-sm-4 no-b-r">' +
                    '                                        <h5>Layout</h5>' +
                    '                                        <p><img src="images/sum-icon.png" alt="" />'+layout+'</p>' +
                    '                                    </div>' +
                    '                                    <div class="bsummary-box col-sm-2 no-b-r">' +
                    '                                        <h5>Date</h5>' +
                    '                                        <p>'+dates[i-1].getDate()+'</p>' +
                    '                                    </div>' +
                    '                                    <div class="bsummary-box col-sm-2 no-b-r">' +
                    '                                        <h5>Start Time</h5>' +
                    '                                        <p>'+stime+' </p>' +
                    '                                    </div>' +
                    '                                    <div class="bsummary-box col-sm-2">' +
                    '                                        <h5>End Time</h5>' +
                    '                                        <p>'+etime+'</p>' +
                    '                                    </div>' +
                    '                                    <div class="bsummary-box col-sm-12"><h5>Cuisine</h5>' + cusine +'</div>' +
                    '                                    <div class="bsummary-box col-sm-12">' +
                    '                                        <h5>Special Instructions</h5>' +
                    '                                        <p>'+sinstruction+'</p>' +
                    '                                    </div>' +
                    '                                    <div class="bsummary-box col-sm-12">' +
                    '                                        <h5>Add Ons</h5>' +
                    '                                         <ul>' + addones +
                    '                                        </ul>' +
                    '                                    </div>';
            }

            $('#days_section').html('').append(review);

        }



    </script>
@endsection

@section('scripts')
    @include('site.layouts.scripts')
    <script type="application/javascript">

        //select
        $(".js-select2-multi").select2({
            templateResult: formatState,
            templateSelection: formatState,
            placeholder: "Select a Item",
            allowClear: true
        });

        function formatState (opt) {
            if (!opt.id) {
                return opt.text.toUpperCase();
            }

            var optimage = $(opt.element).attr('data-image');
            // console.log(optimage)
            if(!optimage){
                return opt.text.toUpperCase();
            } else {
                var $opt = $(
                    '<span><img src="' + optimage + '" width="60px" /> ' + opt.text.toUpperCase() + '</span>'
                );
                return $opt;
            }
        };
        $('.js-select2-multi').on('select2:open', function(){

            $('.select2-dropdown--above .select2-search--dropdown').insertAfter('.select2-results');
        });
        function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="' + $(state.element).attr('data-src') + '" class="img-flag" /> ' + state.text + '</span>'
            );
            return $state;
        };
        $('.select-img').select2({
            minimumResultsForSearch: Infinity,
            templateResult: formatState,
            templateSelection: formatState
        });
    </script>
@endsection

