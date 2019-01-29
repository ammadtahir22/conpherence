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

                                        <div class="row">

                                            <div class="col-sm-4">

                                            </div>

                                            <div class="col-sm-8 text-align-right">

                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" onclick="changeStatus(2)" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i> Cancel </a>
                                                </div>

                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" onclick="changeStatus(1)" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success"> <i class="fa fa-plus"></i> Approve </a>
                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="padding-10">
                                        <br>
                                        <h1 class="" style="font-weight: 700;font-style: 20px; color:#b11f5f;font-family: 'Montserrat', sans-serif;">invoice</h1>
                                        <div class="pull-left">
                                            <img src="{{url('images/logo.png')}}" width="150" height="32" alt="invoice icon">

                                            <address style="color:#a6a6a6;">
                                                <br>
                                                <strong style="color:#302f2f;">{{$booking_infos->space->title}}</strong>
                                                <br>
                                                {{$booking_infos->space->venue->title}} - {{$booking_infos->space->venue->city}}
                                                <br>
                                                {{$booking_infos->space->venue->location}}
                                                <br>
                                                <abbr title="Phone">P:</abbr> (123) 456-7890
                                            </address>
                                        </div>
                                        <div class="pull-right">

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <h4 class="" style="color:#302f2f;font-size:16px;font-weight: 700;">{{$booking_infos->booking_firstname}} {{$booking_infos->booking_lastname}}</h4>
                                                <address style="color:#a6a6a6;font-size:13px;">
                                                    <abbr title="Phone">P:</abbr> @if($booking_infos->user_id == 0) {{$booking_infos->booking_phone}} @else {{$user->phone_number}} @endif
                                                </address>
                                            </div>
                                            <div class="col-sm-4">
                                                <div>
                                                    <strong style="color:#302f2f;font-size:14px;font-family: 'Lato', sans-serif;">Invoice No :</strong>
                                                    <span class="pull-right" style="color: #a6a6a6;font-size:14px;font-family: 'Lato', sans-serif;"> #{{$booking_infos->id}} </span>

                                                </div>
                                                 <div class="" >
                                                        <strong style="color:#302f2f;font-size:14px;font-family: 'Lato', sans-serif;">Invoice Date :</strong>
                                                        <span class="pull-right" style="color: #a6a6a6;font-size:14px;font-family: 'Lato', sans-serif;"> <i class="fa fa-calendar"></i> {{date('d M Y', strtotime($booking_infos->created_at))}} </span>
                                                </div>
                                                <br>
                                                <div class="well well-sm  txt-color-white no-border" style="background-color: #b11f5f!important;">
                                                    <div class="fa-lg">
                                                        Total Due :
                                                        <span class="pull-right"> AED {{$booking_infos->grand_total}} </span>
                                                    </div>

                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                        @foreach($sitting_plan as $key=>$sitting_plans)
                                            @foreach($payment_per_day as $inner_key => $payment_per_days)
                                                @if($key == $inner_key)
                                                    <h4>Booking Detail Day {{ numberTowords($payment_per_days->day) }}</h4>
                                                @endif
                                            @endforeach
                                        <table class="table table-hover" style="border-collapse: collapse;">

                                            <tbody>
                                            <tr  style="border:1px solid #dedede;background:#fff;">
                                                <td style="padding: 10px 10px;border-right:1px solid #dedede;" >
                                                    <span style="color:#a6a6a6;font-size:12px;width:100%;display:block;">Number of People:</span>
                                                    {{$sitting_plans->capacity}}
                                                </td>
                                                @php $image = get_sitting_plan_imagename($sitting_plans->sitting_plan_id) @endphp
                                                <td style="padding: 10px 10px;border-right:1px solid #dedede;"><span style="color:#a6a6a6;font-size:12px;width:100%;display:block;">Layout :</span>
                                                <img src="{{url('storage/images/sitting-plan/'.$image)}}" alt="" />@php echo get_sitting_plan_name($sitting_plans->sitting_plan_id) @endphp</td>
                                                <td style="padding: 10px 10px;border-right:1px solid #dedede;">
                                                    <span style="color:#a6a6a6;font-size:12px;width:100%;display:block;">Start Time</span>
                                                    {{date('h:i a', strtotime($sitting_plans->start_time))}}
                                                </td>
                                                <td style="padding: 10px 10px;border-right:1px solid #dedede;">
                                                    <span style="color:#a6a6a6;font-size:12px;width:100%;display:block;">End Time</span>
                                                    {{date('h:i a', strtotime($sitting_plans->end_time))}}</td>
                                            </tr>
                                            <tr style="border:1px solid #dedede;background:#fff;">
                                                @foreach($foods as $inner_food_key => $food)
                                                    @if($sitting_plans->day == $food->day)
                                                        @foreach($booking_infos->space->venue->foodCategory as $s_food_category)
                                                            @if($food->food_categories_id == $s_food_category->id)
                                                                <td style="border-right:1px solid #dedede;">
                                                                @if($s_food_category->foodDuration->food_duration == 'Morning')
                                                                    <strong style="font-weight: 400;color:#a6a6a6;display:block;">{{'Breakfast'}}</strong>
                                                                @elseif($s_food_category->foodDuration->food_duration == 'Afternoon')
                                                                    <strong style="font-weight: 400;color:#a6a6a6;display:block;">{{'Lunch'}}</strong>
                                                                @elseif($s_food_category->foodDuration->food_duration == 'Evening')
                                                                <strong style="font-weight: 400;color:#a6a6a6;display:block;">{{'Tea/Coffee'}}</strong>
                                                                @elseif($s_food_category->foodDuration->food_duration == 'Night')
                                                               <strong style="font-weight: 400;color:#a6a6a6;display:block;">{{'Dinner'}}</strong>
                                                                @endif

                                                                {{$s_food_category->title}}<span> AED {{$s_food_category->price}}</span></td>
                                                            @endif
                                                        @endforeach

                                                    @endif
                                                @endforeach
                                            </tr>
                                            <tr style="border:1px solid #dedede;background:#fff;">
                                                <td style="padding: 10px 10px;border-right:1px solid #dedede; width:100%" colspan="10"><span style="color:#a6a6a6;font-size:12px;width:100%;display:block;">Addon's</span>
                                                @foreach($booking_infos->space->venue->venueAddOns as $addons)
                                                    @if(in_array($addons->id  , json_decode($sitting_plans->addons)))
                                                        @php $image = get_amenity_image($addons->amenity_id) @endphp
                                                            <span style="display:inline-block;padding-right:10px;"><img src="{{url('storage/images/amenities/'.$image)}}" alt="" /><span><span style="display: block;">@php echo get_amenity_name($addons->amenity_id) @endphp</span><i style="color:#b11f5f;float:right;font-style: normal;font-weight:700;display: block;"> AED {{$addons->price}}</i></span></span>
                                                    @endif
                                                @endforeach
                                                </td>
                                            </tr>

                                            <tr style="border:1px solid #dedede;background:#fff;">
                                                <td style="padding: 10px 10px;width: 100%;border-right: 1px solid #dedede;" colspan="10">Total
                                                    <strong style="float: right;    color: #b11f5f;">
                                                        @foreach($payment_per_day as $inner_key => $payment_per_days)
                                                            @if($key == $inner_key)
                                                               AED {{$payment_per_days->total_day_payment}}
                                                            @endif
                                                        @endforeach
                                                    </strong>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                        @endforeach

                                        <div class="invoice-footer">

                                            <div class="row">

                                                <div class="col-sm-7">

                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="invoice-sum-total pull-right">
                                                        <h3><strong>Total: <span class="text-success" style="color:#b11f5f !important;">AED {{$booking_infos->grand_total}}</span></strong></h3>
                                                    </div>
                                                </div>

                                            </div>



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
    <!-- END MAIN PANEL -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <p id="approve-status" style="text-align: center;"> Are you sure you want to delete it</p>
                        </div>
                    </div>

                </div>
                <form action="{{url('/admin/booking/booking-approve')}}" id="changeStatus" method="post" >
                    @csrf
                <div class="modal-footer">

                        <input type="hidden" name="booking_id" value="{{$booking_infos->id}}" id="booking_id">
                        <input type="hidden" name="status" value="" id="status">
                    <button onclick="form_submit()" class="btn btn-default" data-dismiss="modal">Yes</button>
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-primary"> No </button>

                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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

