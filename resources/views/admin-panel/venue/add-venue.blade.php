@extends('admin-panel.layouts.app')

@section('css-link')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

    <style>
        .custom-time-error{
            color: #b94a48 !important;
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
                @if(isset($venue->id) && $venue->id != '')
                    <li>Home / Edit Venue</li>
                @else
                    <li>Home / Add Venue</li>
                @endif
            </ol>
        </div>
        <!-- END RIBBON -->
        <!-- MAIN CONTENT -->
        <div id="content">
            <!-- widget grid -->
            <section id="widget-grid" class="">
                <!-- row -->
                <div class="row">
                    <form action="{{url('/admin/venue/save')}}" method="post" id="add_venue_form" enctype="multipart/form-data">
                        @csrf
                        <input id="venue_id" name="id" value="{{isset($venue) ? $venue->id : ''}}" type="hidden">
                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            @if(isset($venue->id) && $venue->id != '')
                                                <legend>Edit Venue</legend>
                                            @else
                                                <legend>Add New Venue</legend>
                                            @endif
                                            {{--<div class="form-group">--}}
                                            {{--<label class="col-md-2 control-label">Title</label>--}}
                                            {{--<div class="col-md-10">--}}
                                            {{--<input class="form-control" name="title" value="{{isset($venue)? $venue->title : ''}}" placeholder="Title" type="text" readonly>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Cover Image</label>
                                                <div class="col-md-10">
                                                    <input id="image_cover" type="file" name="cover_image" class="file form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Description</label>
                                                <div class="col-md-10">
                                                <textarea id="ckeditor" name="description">
                                                    {{isset($venue) ? $venue->description : ''}}
                                                </textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Image Gallery</label>
                                                <div class="col-md-10">
                                                    <input id="image_gallery" type="file" name="images[]" multiple class="file form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Location</label>
                                                <div class="col-md-10">
                                                    <input id="searchmap" class="form-control search_address" name="location" value="{{isset($venue)? $venue->location : 'Shaheen Complex, Egerton Rd, Garhi Shahu, Lahore, Punjab 54000'}}" placeholder="Location" type="text" required>
                                                    {{--<input id="searchmap" type="hidden" name="location" class="search_address" value="">--}}
                                                </div>
                                                <label class="col-md-2 control-label"></label>
                                                <div class="col-md-10">
                                                    <div id="map" class="google_maps" data-gmap-lat="23.895883" data-gmap-lng="-80.650635" data-gmap-zoom="5" data-gmap-src="xml/gmap/pins.xml"></div>
                                                    <input type="hidden" name="latitude" class="search_latitude" value="{{isset($venue)? $venue->latitude : '31.5629793'}}">
                                                    <input type="hidden" name="longitude" class="search_longitude" value="{{isset($venue)? $venue->longitude : '74.3308058'}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Cancellation Policy</label>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" name="cancellation_policy" placeholder="Cancellation Policy" rows="4" required>{{isset($venue) ? $venue->cancellation_policy : ''}}</textarea>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>
                                    <!-- this is what the user will see -->
                                </div>
                                <!-- end widget content -->
                            </div>
                            <!-- end widget -->
                        </article>
                        <!-- WIDGET END -->

                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget div-->
                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            <legend>Company </legend>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="select-1">Company</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="company" id="select-1" required>
                                                        @foreach($companies as $key=>$company)
                                                            @if(isset($venue) && $company->id == $venue->company_id)
                                                                @php $selected = 'selected'; @endphp
                                                            @else
                                                                @php $selected = ''; @endphp
                                                            @endif
                                                            <option {{$selected}} value="{{$company->id}}">{{$company->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="select-1">Country</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="country" id="select-1" onchange="get_cities(this.value)" required>
                                                        <option disabled>-Select a Country-</option>
                                                        @foreach($countries as $key=>$country)
                                                            @if(isset($venue) && $country == $venue->country)
                                                                @php $selected = 'selected'; @endphp
                                                            @else
                                                                @php $selected = ''; @endphp
                                                            @endif
                                                            <option {{$selected}} value="{{$country}}">{{$country}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label class="col-md-2 control-label" for="cities">City</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="city" id="cities" required>
                                                        <option disabled selected>-Select a City-</option>
                                                        @if(isset($venue))
                                                            <option selected value="{{$venue->city}}">{{$venue->city}}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                            {{--<div class="form-group">--}}
                                            {{--<label class="col-md-2 control-label" for="select-1"></label>--}}
                                            {{--<div class="col-md-10">--}}
                                            {{--<a href="">--}}
                                            {{--<i class="fa fa-plus"> </i>  Add New Company--}}
                                            {{--</a>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}

                                        </fieldset>
                                    </div>
                                </div>
                                <!-- end widget content -->


                                <!-- end widget div -->

                            </div>
                            <!-- end widget -->

                        </article>
                        <!-- WIDGET END -->

                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <div class="form-horizontal">
                                    <!-- widget content -->
                                    <div class="widget-body">
                                        <fieldset class="demo-switcher-1">
                                            <legend>Duration & time</legend>
                                            <div id="Duration_text_boxs">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Duration</label>

                                                    @php
                                                        $morning_time_in = '';
                                                        $morning_time_out = '';
                                                        $afternoon_time_in = '';
                                                        $afternoon_time_out = '';
                                                        $evening_time_in = '';
                                                        $evening_time_out = '';
                                                        $night_time_in = '';
                                                        $night_time_out = '';
                                                        $fullday_time_in = '';
                                                        $fullday_time_out = '';

                                                        if(isset($venue_durations))
                                                        {
                                                            foreach ($venue_durations as $durations)
                                                            {
                                                                if($durations['food_duration'] == 'Morning')
                                                                {
                                                                    $morning_time_in = $durations['start_time'];
                                                                    $morning_time_out = $durations['end_time'];
                                                                } elseif($durations['food_duration'] == 'Afternoon'){
                                                                    $afternoon_time_in = $durations['start_time'];
                                                                    $afternoon_time_out = $durations['end_time'];
                                                                } elseif($durations['food_duration'] == 'Evening'){
                                                                    $evening_time_in = $durations['start_time'];
                                                                    $evening_time_out = $durations['end_time'];
                                                                } elseif($durations['food_duration'] == 'Night'){
                                                                    $night_time_in = $durations['start_time'];
                                                                    $night_time_out = $durations['end_time'];
                                                                } elseif($durations['food_duration'] == 'Full Day'){
                                                                    $fullday_time_in = $durations['start_time'];
                                                                    $fullday_time_out = $durations['end_time'];
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    <div class="col-md-4">
                                                        <input class="form-control" name="duration_1" value="Morning" placeholder="Morning" type="text" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="start_time_1" name="start_time_1" value="{{$morning_time_in}}" onchange="check_time('start_time_1','end_time_1')" placeholder="Start Time" required>
                                                        <label id="start_time_1_error" class="custom-time-error" for="start_time_1" style="display: none ">Timing will not overlap any other time</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="end_time_1" name="end_time_1" value="{{$morning_time_out}}" onchange="check_time('start_time_1','end_time_1'); check_time_2('start_time_2','end_time_1')" placeholder="End Time" required>
                                                        <label id="end_time_1_error" class="custom-time-error" for="end_time_1" style="display: none ">Time must be greater</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Duration</label>
                                                    <div class="col-md-4">
                                                        <input class="form-control" name="duration_2" value="Afternoon" placeholder="Afternoon" type="text" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="start_time_2" name="start_time_2" value="{{$afternoon_time_in}}" onchange="check_time('start_time_2','end_time_2') ; check_time_2('start_time_2','end_time_1')" placeholder="Start Time" required>
                                                        <label id="start_time_2_error" class="custom-time-error" for="start_time_2" style="display: none ">Timing will not overlap Morning time</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="end_time_2" name="end_time_2" value="{{$afternoon_time_out}}" onchange="check_time('start_time_2','end_time_2') ; check_time_2('start_time_3','end_time_2')" placeholder="End Time" required>
                                                        <label id="end_time_2_error" class="custom-time-error" for="end_time_2" style="display: none ">Time must be greater</label>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Duration</label>
                                                    <div class="col-md-4">
                                                        <input class="form-control" name="duration_3" value="Evening" placeholder="Evening" type="text" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="start_time_3" name="start_time_3" value="{{$evening_time_in}}" onchange="check_time('start_time_3','end_time_3') ; check_time_2('start_time_3','end_time_2')" placeholder="Start Time" required>
                                                        <label id="start_time_3_error" class="custom-time-error" for="start_time_3" style="display: none ">Timing will not overlap Afternoon time</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="end_time_3" name="end_time_3" value="{{$evening_time_out}}" onchange="get_night_time(); check_time('start_time_3','end_time_3')" placeholder="End Time" required>
                                                        <label id="end_time_3_error" class="custom-time-error" for="end_time_3" style="display: none ">Time must be greater</label>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="display: none">
                                                    <label class="col-md-2 control-label">Duration</label>
                                                    <div class="col-md-4">
                                                        <input class="form-control" name="duration_4" value="Night" placeholder="Night" type="text" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="start_time_4" name="start_time_4" value="{{$night_time_in}}" placeholder="Start Time">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="end_time_4" name="end_time_4" value="{{$night_time_out}}" placeholder="End Time">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Duration</label>
                                                    <div class="col-md-4">
                                                        <input class="form-control" name="duration_5" value="Full Day" placeholder="Full Day" type="text" readonly>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="start_time_5" name="start_time_5" value="{{$fullday_time_in}}" onchange="check_time('start_time_5','end_time_5')" placeholder="Start Time" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input class="form-control timepicker" id="end_time_5" name="end_time_5" value="{{$fullday_time_out}}" onchange="get_night_time(); check_time('start_time_5','end_time_5')" placeholder="End Time" required>
                                                        <label id="end_time_5_error" class="custom-time-error" for="end_time_5" style="display: none ">Time must be greater</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                    </div>
                                    <!-- end widget content -->
                                </div>
                            </div>
                            <!-- end widget -->

                        </article>
                        <!-- WIDGET END -->

                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <div class="form-horizontal">
                                    <!-- widget content -->
                                    <div class="widget-body">
                                        <fieldset class="demo-switcher-1">
                                            <legend>Food</legend>
                                            <div id="food_category_text_boxs">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Category</label>

                                                    <div class="col-md-5">
                                                        <select class="form-control food_input" id="food_duration" name="food_duration">
                                                            <option value="Morning">Breakfast</option>
                                                            <option value="Afternoon">Lunch</option>
                                                            <option value="Evening">Tea/Coffee</option>
                                                            <option value="Night">Dinner</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">

                                                        <select name="food_category" class="form-control custom-scroll" id="food_category" name="food_category">
                                                            @if(isset($food_types))
                                                                @foreach($food_types as $key=>$food_type)

                                                                    <option value="{{$food_type->title}}">{{$food_type->title}}</option>
                                                                @endforeach
                                                            @endif

                                                        </select>

                                                        {{--<input class="form-control food_input" id="food_category" name="food_category" value="" placeholder="Food Category" type="text">--}}
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-2 control-label"></label>
                                                    <div class="col-md-5">
                                                        <select class="form-control food_input" id="food_currency" name="food_currency">
                                                            <option value="AED">AED</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input class="form-control food_input" id="food_price" name="food_price" value="" placeholder="Price" type="number" min="1">
                                                    </div>
                                                </div>

                                                <div id="food_items">
                                                    <div class="form-group" >
                                                        <label class="col-md-2 control-label"></label>
                                                        <div class="col-md-8">
                                                            <input class="form-control food_input food_item" id="food_item1" name="food_item1" value="" placeholder="Food" type="text">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-primary" type="button" onclick="add_more_item()">+</button>
                                                        </div>
                                                    </div>
                                                    <div id="new_food_items">

                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" id="total_account" name="total_account" value="0">

                                            <div>
                                                <button class="btn btn-primary" type="button" onclick="add_food_category()">
                                                    Add Food
                                                </button>
                                            </div>

                                            <label id="food_field_error" class="error" style="position: unset; display: none">Please fill all fields</label>
                                            <legend></legend>

                                            <div class="" id="added_food_items">

                                            </div>

                                            @php
                                                $food_array = '[]';
                                                if(isset($venue) && $venue->food_array)
                                                {
                                                    $food_array = $venue->food_array;
                                                }
                                            @endphp

                                            <input type="hidden" id="food_array" name="food_array" value="{{$food_array}}">
                                            <input type="hidden" id="food_array_check" name="food_array_check" value="0">

                                        </fieldset>

                                    </div>
                                    <!-- end widget content -->
                                </div>
                            </div>
                            <!-- end widget -->

                        </article>
                        <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <div class="form-horizontal">
                                    <!-- widget content -->
                                    <div class="widget-body">
                                        <fieldset class="demo-switcher-1">
                                            <legend>Amenities</legend>
                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    @php
                                                        if(isset($venue)) {
                                                        $amenities_spaces = array();
                                                        foreach($v_amenities as $as){
                                                         array_push($amenities_spaces , $as->id);
                                                         }
                                                        }
                                                    @endphp
                                                    <select multiple="" name="amenities_id[]" class="form-control custom-scroll" id="amenities_id" required>
                                                        @foreach($amenities as $key=>$amenitie)
                                                            @if(isset($venue) &&  in_array($amenitie->id  , $amenities_spaces))
                                                                @php $selected = 'selected'; @endphp
                                                            @else
                                                                @php $selected = ''; @endphp
                                                            @endif

                                                            <option {{$selected}} value="{{$amenitie->id}}">{{$amenitie->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <!-- end widget content -->
                                </div>
                            </div>
                            <!-- end widget -->

                        </article>
                        <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <div class="form-horizontal">
                                    <!-- widget content -->
                                    <div id="all_add_ons_inputs" class="widget-body">
                                        <fieldset class="demo-switcher-1">
                                            <legend>Add Ons</legend>

                                            @php
                                                if(isset($venue))
                                                {
                                                    $addons_arr_db = $venue->venueAddOns;
                                                } else {
                                                    $addons_arr_db = [];
                                                }
                                            @endphp

                                            @if(isset($venue) && count($addons_arr_db) > 0)
                                                @foreach($addons_arr_db as $addon_key=>$addon)
                                                    @php $total_addons_db = $addon_key+1; @endphp
                                                    <div class="form-group" id="new_add_ons_item{{$addon_key+1}}">
                                                        <div class="col-md-5">
                                                            <input type="hidden" name="addons_id{{$addon_key+1}}" value="{{$addon->id}}">
                                                            <select name="addons{{$addon_key+1}}" class="form-control custom-scroll addon-select-box" onchange="checkTheDropdowns()" id="addons{{$addon_key+1}}" required>
                                                                @foreach($amenities as $key=>$amenitie)
                                                                    @if($addon->amenity_id == $amenitie->id)
                                                                        @php $selected = 'selected'; @endphp
                                                                    @else
                                                                        @php $selected = ''; @endphp
                                                                    @endif
                                                                    <option {{$selected}} value="{{$amenitie->id}}">{{$amenitie->name}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="col-md-5">
                                                            <input class="form-control check_addons_input" id="addone_price{{$addon_key+1}}" name="addone_price{{$addon_key+1}}" value="{{$addon->price}}" placeholder="Price" type="number" min="1" required>
                                                        </div>

                                                        @if($addon_key+1 == 1)
                                                            <div class="col-md-2">
                                                                <button class="btn btn-primary" type="button" onclick="add_more_add_ons()">+</button>
                                                            </div>
                                                        @else
                                                            <div class="col-md-2" id="add_ons_delete{{$addon_key+1}}">
                                                                <button class="btn btn-danger" type="button" onclick="delete_add_ons({{$addon_key+1}})">  -  </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @else
                                                @php $total_addons = 1; @endphp
                                                <div class="form-group">
                                                    <div class="col-md-5">
                                                        <select name="addons1" class="form-control custom-scroll addon-select-box" onchange="checkTheDropdowns()" id="addons1" required>
                                                            <option disabled selected>-Please select an option-</option>
                                                            @foreach($amenities as $key=>$amenitie)
                                                                <option value="{{$amenitie->id}}">{{$amenitie->name}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-5">
                                                        <input class="form-control check_addons_input" id="addone_pric1" name="addone_price1" value="" placeholder="Price" type="number" min="1" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-primary" type="button" onclick="add_more_add_ons()">+</button>
                                                    </div>
                                                </div>
                                            @endif

                                            <input id="amenities_count" value="{{count($amenities)}}" type="hidden" required>

                                            <div id="new_add_ons_items">

                                            </div>
                                            <label id="add_ons_field_error" style="display: none;font-size: 13px;color: #cc0000 !important;">All Add Ons Added</label>

                                            @php
                                                if(isset($venue) && count($addons_arr_db) > 0)
                                                {
                                                    $total_add_ons = $total_addons_db;
                                                } else {
                                                    $total_add_ons = $total_addons;
                                                }
                                            @endphp
                                            <input type="hidden" id="total_add_ons" name="total_account_add_ons" value="{{$total_add_ons}}">

                                        </fieldset>
                                    </div>
                                    <!-- end widget content -->
                                </div>
                            </div>
                            <!-- end widget -->

                        </article>
                        <article class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget div-->
                                <!-- widget content -->
                                <div class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Publish</legend>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-10">
                                                    <label class="radio radio-inline no-margin">
                                                        <input type="radio" name="status"  {{isset($venue) && $venue->status == 1 ? 'checked' : ''}} value="1" class="radiobox style-2" data-bv-field="status">
                                                        <span>Publish</span>
                                                    </label>

                                                    <label class="radio radio-inline">
                                                        <input type="radio" name="status" {{isset($venue) && $venue->status == 0 ? 'checked' : ''}} value="0" class="radiobox style-2" data-bv-field="status">
                                                        <span>Draft</span>
                                                    </label>

                                                    <div class="col-sm-12 col-md-10 ">
                                                        <div class="venue_status_area"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>


                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('all.venue') }}" class="btn btn-default"> Cancel </a>
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i>
                                                    {{isset($venue) ? 'Update' : 'Submit'}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- this is what the user will see -->
                                </div>
                                <!-- end widget content -->


                                <!-- end widget div -->

                            </div>
                            <!-- end widget -->

                        </article>
                        <!-- WIDGET END -->
                    </form>
                </div>

                <!-- end row -->

                <!-- row -->

                <div class="row">
                    <!-- a blank row to get started -->
                    <div class="col-sm-12">
                        <!-- your contents here -->
                    </div>
                </div>
                <!-- end row -->
            </section>
            <!-- end widget grid -->

        </div>
        <!-- END MAIN CONTENT -->

    </div>
    <!-- END MAIN PANEL -->
    <!-- hidden field for multi images-->
    @php
        $images_array = '[]';
        if(isset($venue) && $venue->images)
        {
            $images_array = $venue->images;
        }
    @endphp

    <input type="hidden" id="images_name" value="{{$images_array}}">
    <!-- hidden field -->


@endsection

@section('footer')
    @include('admin-panel.layouts.footer')
@endsection

@section('shortcut')
    @include('admin-panel.layouts.shortcut')
@endsection

@section('scripts')
    @include('admin-panel.layouts.scripts')

    <!-- PAGE RELATED PLUGIN(S) -->
    <script src="{{url('js/admin-panel/plugin/ckeditor/ckeditor.js')}}"></script>
    <script src="{{url('js/admin-panel/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
    {{--<script src="{{url('js/admin-panel/plugin/clockpicker/clockpicker.min.js')}}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>



    <script type="text/javascript">

        // food duration JS
        $('.timepicker').timepicker({
            minuteStep: 15,
            defaultTime: false,
        });

        function check_time(start_id, end_id)
        {
            var start_time = $('#'+start_id).val();
            var end_time = $('#'+end_id).val();
            var label_id = '#'+end_id+'_error';

            var startTime = autotimeConvertor(start_time);
            var endTime = autotimeConvertor(end_time);
            var regExp = /(\d{1,2})\:(\d{1,2})\:(\d{1,2})/;
            if(parseInt(endTime .replace(regExp, "$1$2$3")) <= parseInt(startTime .replace(regExp, "$1$2$3"))){
                // alert('jj');
                $('#'+end_id).val('');
                $('#'+end_id).css('border-color', '#cc0000');
                $(label_id).css('display', 'block');
                // alert("Start time is greater");
            } else {
                $('#'+end_id).css('border-color', '#468847');
                $(label_id).css('display', 'none');
            }
        }

        function check_time_2(start_id, end_id)
        {
            var start_time = $('#'+start_id).val();
            var end_time = $('#'+end_id).val();
            var label_id = '#'+start_id+'_error';

            var startTime = autotimeConvertor(start_time);
            var endTime = autotimeConvertor(end_time);

            var regExp = /(\d{1,2})\:(\d{1,2})\:(\d{1,2})/;
            if(parseInt(endTime .replace(regExp, "$1$2$3")) > parseInt(startTime .replace(regExp, "$1$2$3"))){
                $('#'+start_id).val('');
                $('#'+start_id).css('border-color', '#cc0000');
                $(label_id).css('display', 'block');
                // alert("Start time is greater");
            } else {
                $('#'+start_id).css('border-color', '#dedede');
                $(label_id).css('display', 'none');
            }
        }

        function autotimeConvertor(time) {
            var PM = time.match('PM') ? true : false;
            var AM = time.match('AM') ? true : false;

            time = time.split(':');
            var min = time[1];

            if (PM) {
                if(parseInt(time[0],10) == 12){
                    var hour = parseInt(time[0],10);
                } else {
                    var hour = 12 + parseInt(time[0],10);
                }

                var min = time[1].replace(' PM', '');
            }
            if(AM) {
                var hour = time[0];
                var min = time[1].replace(' AM', '');
            }

            return hour + ':' + min;
        }



        function get_night_time() {
            $('#start_time_4').val($('#end_time_3').val());
            $('#end_time_4').val($('#end_time_5').val());
        }


        // add-on JS
        function checkTheDropdowns(){
            var arr  = $(".addon-select-box").find(':selected');
            $(".addon-select-box").find('option').show();
            $.each($(".addon-select-box"), function(){
                var self = this;
                var selectVal = $(this).val();
                $.each(arr, function(){
                    if (selectVal !== $(this).val()){
                        $(self).find('option[value="'+$(this).val()+'"]').hide()
                    } else {
                        $(self).find('option[value="'+$(this).val()+'"]').show()
                    }
                });
                console.log(selectVal);
            });
        }
        checkTheDropdowns();

        $(".addon-select-box").on('change', checkTheDropdowns);

        // $(".addon-select-box").each(function(i,s){
        //     $(".addon-select-box").not(s).find("option[value="+$(s).val()+"]").remove();
        // });

        function add_more_add_ons()
        {
            var empty = $('#all_add_ons_inputs').find('.check_addons_input');
            var count_add_ons = $('#amenities_count').val();

            if(empty.length >= count_add_ons)
            {
                $('#add_ons_field_error').css({'display':'block'});
            } else {
                $('#add_ons_field_error').css({'display': 'none'});

                var t_account = $("#total_add_ons").val();
                var next = parseInt(t_account) + 1;
                $("#total_add_ons").val(next);

                // next = next + 1;
                var newIn = '<div class="form-group" id="new_add_ons_item'+next+'">' +
                    '<div class="col-md-5">' +
                    '<select name="addons'+next+'" class="form-control custom-scroll addon-select-box" id="addons'+next+'" required>' +
                    '<option disabled selected value="">-Please select an option-</option>'+
                    '@foreach($amenities as $amenitie)<option value="{{$amenitie->id}}">{{$amenitie->name}}</option> @endforeach'+
                    '</select>' +
                    '</div>' +
                    '<div class="col-md-5">' +
                    '<input class="form-control check_addons_input" id="addone_price'+next+'" name="addone_price'+next+'" value="" placeholder="Price" type="number" min="1" required>' +
                    '</div>' +
                    '<div class="col-md-2" id="add_ons_delete'+next+'">' +
                    '<button class="btn btn-danger" type="button" onclick="delete_add_ons('+next+')">  -  </button>' +
                    '</div>' +
                    '</div>';

                $('#new_add_ons_items').append(newIn);

                // $(".addon-select-box").each(function(i,s){
                //     $(".addon-select-box").not(s).find("option[value="+$(s).val()+"]").remove();
                // });
                checkTheDropdowns();

            }
        }

        function delete_add_ons(i)
        {
            checkTheDropdowns();

            var t_account = $("#total_add_ons").val();
            var next = parseInt(t_account) - 1;
            $("#total_add_ons").val(next);
            var fieldID = "#new_add_ons_item" + i;
            $(fieldID).remove();
        }
        // end add-on JS

        // Food JS
        window.onload = onload_check_food;
        function onload_check_food()
        {
            var old_food_array = JSON.parse($('#food_array').val());
            $('#food_array_check').val(old_food_array.length);

            for (var j in old_food_array)
            {
                console.log(old_food_array[j].food_items);

                if(old_food_array[j].food_items)
                {
                    var food_items =  old_food_array[j].food_items;
                    var food_id =  old_food_array[j].id;
                    var food_category =  old_food_array[j].category;
                    var food_duration =  old_food_array[j].food_duration;
                    var food_currency =  old_food_array[j].food_currency;
                    var food_price =  old_food_array[j].food_price;
                    var i;
                    var items_str = '';
                    for (i = 0; i < food_items.length; i++) {
                        items_str += '<li> '+food_items[i]+' </li>';
                    }


                    var newIn = '<div class="cuisine-box" id="cuisine_box'+food_id+'">' +
                        '<h3>'+food_category+'<span> '+food_currency+' '+food_price+' </span></h3>' +
                        '<div class="edit-del">' +
                        '<a onclick="edit_food_category('+food_id+')"><i class="fa fa-edit fa-lg"></i></a>' +
                        '<a onclick="delete_food_category('+food_id+')"><i class="fa fa-trash fa-lg"></i></a>' +
                        '</div>' +
                        '<ul>'+items_str+'</ul>' +
                        '</div>';

                    $('#added_food_items').append(newIn);
                }
            }
        }

        function add_more_item()
        {
            var t_account = $("#total_account").val();
            var next = parseInt(t_account) + 1;
            $("#total_account").val(next);

            next = next + 1;
            var newIn = '<div class="form-group" id="new_food_item'+next+'">' +
                '<label class="col-md-2 control-label"></label>' +
                '<div class="col-md-8">' +
                '<input class="form-control food_input food_item" name="food_item'+next+'" value="" placeholder="Food" type="text">' +
                '</div>' +
                '<div class="col-md-2" id="food_item_delete'+next+'">' +
                '<button class="btn btn-danger" type="button" onclick="delete_food_item('+next+')">  -  </button>' +
                '</div>' +
                '</div>';

            $('#new_food_items').append(newIn);
        }

        function delete_food_item(i)
        {
            var t_account = $("#total_account").val();
            var next = parseInt(t_account) - 1;
            $("#total_account").val(next);
            var fieldID = "#new_food_item" + i;
            $(fieldID).remove();
        }

        function add_food_category()
        {
            var empty = $('#food_category_text_boxs').find("input").filter(function() {
                return this.value === "";
            });

            if(empty.length) {
                $('#food_field_error').css({'display':'block'});
            } else {
                $('#food_field_error').css({'display':'none'});
                var old_food_array = JSON.parse($('#food_array').val());

                var food_category =  $('#food_category').val();
                var food_duration =  $('#food_duration').val();
                var food_currency =  $('#food_currency').val();
                var food_price =  $('#food_price').val();

                var food_items = [];
                i = 0;
                $('.food_item').each(function() {
                    food_items[i++] = $(this).val();
                });

                var food_array = {};
                var food_id = old_food_array.length + 1;
                food_array['id'] = food_id;
                food_array['category'] = food_category;
                food_array['food_duration'] = food_duration;
                food_array['food_price'] = food_price;
                food_array['food_currency'] = food_currency;
                food_array['food_items'] = food_items;

                old_food_array.push(food_array);

                $('#food_array').val(JSON.stringify(old_food_array));
                $('#food_array_check').val(old_food_array.length);

                // console.log(old_food_array);



                var i;
                var items_str = '';
                for (i = 0; i < food_items.length; i++) {
                    items_str += '<li> '+food_items[i]+' </li>';
                }


                var newIn = '<div class="cuisine-box" id="cuisine_box'+food_id+'">' +
                    '<h3>'+food_category+'<span> '+food_currency+' '+food_price+' </span></h3>' +
                    '<div class="edit-del">' +
                    '<a onclick="edit_food_category('+food_id+')"><i class="fa fa-edit fa-lg"></i></a>' +
                    '<a onclick="delete_food_category('+food_id+')"><i class="fa fa-trash fa-lg"></i></a>' +
                    '</div>' +
                    '<ul>'+items_str+'</ul>' +
                    '</div>';

                $('#added_food_items').append(newIn);


                $("#food_category").val($("#food_category option:first").val());
                $("#food_duration").val($("#food_duration option:first").val());
                $("#food_currency").val($("#food_currency option:first").val());
                $('#food_price').val('');
                $('#food_item1').val('');
                $('#new_food_items').html('');
            }
        }

        function edit_food_category(id)
        {
            $("#cuisine_box"+id).remove();
            var old_food_array = JSON.parse($('#food_array').val());

            for (var i in old_food_array) {
                if (old_food_array[i].id == id) {
                    var old_food_category =  old_food_array[i];
                    var old_food =  old_food_category.food_items;

                    $('#food_category').val(old_food_category.category);
                    $('#food_duration').val(old_food_category.food_duration);
                    $('#food_currency').val(old_food_category.food_currency);
                    $('#food_price').val(old_food_category.food_price);
                    $('#new_food_items').html('');

                    $("#total_account").val(old_food.length);
                    for (var j=0; j < old_food.length; j++) {
                        if (j == 0)
                        {
                            $('#food_item1').val(old_food[j]);
                        } else {
                            // var t_account = $("#total_account").val();
                            var next = j;
                            var newIn = '<div class="form-group" id="new_food_item'+next+'">' +
                                '<label class="col-md-2 control-label"></label>' +
                                '<div class="col-md-8">' +
                                '<input class="form-control food_input food_item" name="food_item'+next+'" value="'+old_food[j]+'" placeholder="Food" type="text">' +
                                '</div>' +
                                '<div class="col-md-2" id="food_item_delete'+next+'">' +
                                '<button class="btn btn-danger" type="button" onclick="delete_food_item('+next+')">  -  </button>' +
                                '</div>' +
                                '</div>';

                            $('#new_food_items').append(newIn);
                        }
                    }

                    old_food_array.splice(i, 1);
                    $('#food_array').val(JSON.stringify(old_food_array));
                    $('#food_array_check').val(old_food_array.length);
                    break; //Stop this loop, we found it!
                }
            }
        }

        function delete_food_category(id)
        {
            $("#cuisine_box"+id).remove();
            var old_food_array = JSON.parse($('#food_array').val());

            for (var i in old_food_array) {
                if (old_food_array[i].id == id) {
                    old_food_array.splice(i, 1);
                    $('#food_array').val(JSON.stringify(old_food_array));
                    $('#food_array_check').val(old_food_array.length);
                    break; //Stop this loop, we found it!
                }
            }
        }
        // end Food JS

        //cover image  plugin
        $("#image_cover").fileinput({
            uploadUrl:  "{{ isset($venue) ? url('storage/images/venues/'.$venue->id.'/cover/') : '' }}",
            dropZoneEnabled: false,
            showUpload: false, // The "Upload" button
            initialPreviewShowDelete: false,
            initialPreview: "{{ isset($venue) ? url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image) : '' }}",
            initialPreviewConfig: [
                {
                    fileType: 'image',
                    previewAsData: true,
                }
            ],
            required: true,
            removeFromPreviewOnError: true,
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            allowedPreviewTypes: ['image'],
            defaultPreviewContent: '<h5>No Image Selected</h5><h6> Click Browse...</h6>',
            overwriteInitial: true, // Whether to replace the image loaded originally if it exists
            maxFileSize: 5000, // 5 MB
            maxFileCount: 1,
            // msgErrorClass: 'alert alert-block alert-danger',
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });

        var venue = '@php echo isset($venue->images); @endphp';
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        if (venue)
        {
            var venue_id = $.parseJSON($('#venue_id').val());
            var images = $.parseJSON($('#images_name').val());
            var data = [];
            for (var i = 0; i < images.length; i++)
            {
                var url = base_url + '/storage/images/venues/'+venue_id+'/'+images[i];
                data.push(url);
            }
        } else {
            var data = [];
        }

        var delete_data = get_venue_images_delete($('#venue_id').val(), $('#images_name').val());

        function get_venue_images_delete(id, images)
        {
            var delete_data = [];
            var images_name = $.parseJSON(images);

            if (id)
            {
                var delete_data = [];
                for (var i = 0; i < images_name.length; i++)
                {
                    var extra = {};
                    extra['_token'] = csrf_token;
                    extra['id'] = $("#venue_id").val();

                    var arr = {};
                    arr['caption'] = images_name[i];
                    arr['url'] = base_url+ '/admin/venue/images/delete';
                    arr['key'] = images_name[i];
                    arr['extra'] = extra;
                    delete_data.push(arr);
                }
            }
            return delete_data;
        }

        //image gallery plugin
        $("#image_gallery").fileinput({
            theme: "fas",
            // uploadExtraData:{'csrfmiddlewaretoken': csrf_token },
            // uploadAsync: true,
            // uploadUrl:  "{% url 'publication:publish' %}",
            uploadUrl:  "{{ isset($venue) ? url('admin/post/image/save'.$venue->id) : '' }}",
            dropZoneEnabled: false,
            showUpload: false, // The "Upload" button
            showRemove: false, // The "Remove" button
            initialPreview: data,
            initialPreviewConfig: delete_data,
            initialPreviewAsData: true,
            removeFromPreviewOnError: true,
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            allowedPreviewTypes: ['image'],
            // defaultPreviewContent: '<h5>No Image Selected</h5><h6> Click Browse...</h6>',
            overwriteInitial: false, // Whether to replace the image loaded originally if it exists
            maxFileSize: 5000, // 5 MB
            maxFileCount: 10,
            msgErrorClass: 'alert alert-block alert-danger',
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });

        $(document).ready(function() {
            CKEDITOR.replace( 'ckeditor', { height: '180px', startupFocus : true, allowedContent:true} );

            // $('#add_venue_form').bootstrapValidator({
            //     container : '#messages',
            //     feedbackIcons : {
            //         valid : 'glyphicon glyphicon-ok',
            //         invalid : 'glyphicon glyphicon-remove',
            //         validating : 'glyphicon glyphicon-refresh'
            //     },
            //     fields : {
            //         status : {
            //             // The group will be set as default (.form-group)
            //             validators : {
            //                 notEmpty : {
            //                     message : ''
            //                 }
            //             }
            //         }
            //     }
            // });
        });

        var error_message = "Please enter the required field";
        $("#add_venue_form").validate(
            {
                ignore: [],
                debug: false,
                rules: {
                    description:
                        {
                            required: function () {
                                CKEDITOR.instances.ckeditor.updateElement();
                            },
                            minlength: 10
                        },
                    location: {
                        required: true
                    },
                    cancellation_policy: {
                        required: true
                    },
                    company: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    category: {
                        required: true
                    },
                    start_time_1: {
                        required: true
                    },
                    end_time_1: {
                        required: true
                    },
                    start_time_2: {
                        required: true
                    },
                    end_time_2: {
                        required: true
                    },
                    start_time_3: {
                        required: true
                    },
                    end_time_3: {
                        required: true
                    },
                    start_time_5: {
                        required: true
                    },
                    end_time_5: {
                        required: true
                    },
                    // food_duration: {
                    //     required: true
                    // },
                    // food_category: {
                    //     required: true
                    // },
                    // food_currency: {
                    //     required: true
                    // },
                    // food_price: {
                    //     required: true
                    // },
                    // food_item1: {
                    //     required: true
                    // },
                    food_array_check: {
                        min: 1
                    },
                    "amenities_id[]": {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages:
                    {

                        description: {
                            required: error_message,
                            minlength: "Please enter 10 characters"
                        },
                        location: {
                            required: error_message
                        },
                        cancellation_policy: {
                            required: error_message
                        },
                        company: {
                            required: error_message
                        },
                        country: {
                            required: error_message
                        },
                        city: {
                            required: error_message
                        },
                        category: {
                            required: error_message
                        },
                        start_time_1: {
                            required: error_message
                        },
                        end_time_1: {
                            required: error_message
                        },
                        start_time_2: {
                            required: error_message
                        },
                        end_time_2: {
                            required: error_message
                        },
                        start_time_3: {
                            required: error_message
                        },
                        end_time_3: {
                            required: error_message
                        },
                        start_time_5: {
                            required: error_message
                        },
                        end_time_5: {
                            required: error_message
                        },
                        // food_duration: {
                        //     required: error_message
                        // },
                        // food_category: {
                        //     required: error_message
                        // },
                        // food_currency: {
                        //     required: error_message
                        // },
                        // food_price: {
                        //     required: error_message
                        // },
                        // food_item1: {
                        //     required: error_message
                        // },
                        food_array_check: {
                            min: "Place add food first"
                        },
                        "amenities_id[]": {
                            required: error_message
                        },
                        status: {
                            required: error_message
                        }
                    },
                errorPlacement: function (error, element) {
                    if (element.prop("type") === "radio") {
                        error.insertAfter(".venue_status_area");
                    } else {
                        error.insertAfter(element);
                    }
                }
            }
        );


        function initialize() {
            var initialLat = $('.search_latitude').val();
            var initialLong = $('.search_longitude').val();
            initialLat = initialLat?initialLat:31.5629793;
            initialLong = initialLong?initialLong:74.3308058;

            var latlng = new google.maps.LatLng(initialLat, initialLong);
            var options = {
                zoom: 16,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map"), options);

            geocoder = new google.maps.Geocoder();

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: latlng
            });


            google.maps.event.addListener(marker, "dragend", function () {
                var point = marker.getPosition();
                map.panTo(point);
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        $('.search_address').val(results[0].formatted_address);
                        $('.search_latitude').val(marker.getPosition().lat());
                        $('.search_longitude').val(marker.getPosition().lng());
                    }
                });
            });

        }
        $(document).ready(function () {
            $('#amenities_id').select2({
                tags: true,
                allowClear: true

            });

            //load google map
            initialize();

            /*
             * autocomplete location search
             */
            var PostCodeid = '#searchmap';
            $(function () {
                $(PostCodeid).autocomplete({
                    source: function (request, response) {
                        geocoder.geocode({
                            'address': request.term
                        }, function (results, status) {
                            response($.map(results, function (item) {
                                return {
                                    label: item.formatted_address,
                                    value: item.formatted_address,
                                    lat: item.geometry.location.lat(),
                                    lon: item.geometry.location.lng()
                                };
                            }));
                        });
                    },
                    select: function (event, ui) {
                        $('.search_address').val(ui.item.value);
                        $('.search_latitude').val(ui.item.lat);
                        $('.search_longitude').val(ui.item.lon);
                        var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
                        marker.setPosition(latlng);
                        initialize();
                    }
                });
            });

            /*
             * Point location on google map
             */
            $('.get_map').click(function (e) {
                var address = $(PostCodeid).val();
                geocoder.geocode({'address': address}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        $('.search_address').val(results[0].formatted_address);
                        $('.search_latitude').val(marker.getPosition().lat());
                        $('.search_longitude').val(marker.getPosition().lng());
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
                e.preventDefault();
            });

            //Add listener to marker for reverse geocoding
            google.maps.event.addListener(marker, 'drag', function () {
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('.search_address').val(results[0].formatted_address);
                            $('.search_latitude').val(marker.getPosition().lat());
                            $('.search_longitude').val(marker.getPosition().lng());
                        }
                    }
                });
            });
        });

    </script>
    <script>
        function get_cities(country)
        {
            $.ajax({
                type: 'GET',
                url: '{{url('/get-cities')}}',
                datatype: 'json',
                data: {
                    country: country,
                },
                success: function (response) {

                    console.log(response);
                    $('#cities').html('');
                    $('#cities').html(response.data);
                    // $('#cardpopup').modal('toggle');
                    // $('#credit_cards').html(response.data);

                    // $("#credit_cards").load(" #credit_cards");


                    // if (response.error.length > 0) {
                    //     var error_html = '';
                    //     for (var count = 0; count < data.error.length; count++) {
                    //         error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                    //     }
                    //     $('#flash_massage').html(error_html);
                    // } else {
                    //     $('#flash_massage').html(response.success);
                    //
                    // }

                    // $('.flash_message').empty();
                    // if(data.flag == 1){
                    //     $('.flash_message').append('<p class="text-success">Sucessfully Password Changed!</p>');
                    // }else if(data.flag == 0){
                    //     $('.flash_message').append('<p class="text-danger">Your Old Password Not Found</p>');
                    // }
                    // $("form")[0].reset();
                }
            });

        }







    </script>


@endsection

