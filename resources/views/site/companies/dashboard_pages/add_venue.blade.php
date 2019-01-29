@extends('site.layouts.app')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <style>
        .space-feature-full .sp-f-btn {
            max-width: 110px;!important;

        }
        .custom-time-error{
            /*display: none !important;*/
            position: absolute;
            color: rgb(204, 0, 0) !important;
        }
    </style>
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
                    @include('site.companies.dashboard_nev',['active_venue' => "active"])
                </ul>
            </aside>

            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active" id="add-venue">
                    <div class="welcome-title full-col">
                        <div class="back-to"><a href="{{url('/company/dashboard/venue/index')}}"><img src="{{url('images/back.png')}}" alt="" />Back to venue listing</a></div>
                    </div>
                    <form action="{{url('/company/dashboard/venue/save')}}" method="post" enctype="multipart/form-data" id="add_venue_form">
                        {{--@csrf--}}
                        <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">
                        <div class="hotal-add-vanu">
                            <div class="dash-box col-xs-4 dash-featured-photo">
                                <h3 class="dashboard-title">Featured Image</h3>
                                <div class="dash-box-inner profile-photo-box">
                                    <div class="file-upload">
                                        @php
                                            $venue_cover_url = url('images/edit-profile-iconh.png');
                                            $venue_cover_required = 'required';

                                            if(isset($venue) && $venue['cover_image'] != ' ')
                                            {
                                                $venue_cover_url = url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image);
                                                $venue_cover_required = '';
                                            }
                                        @endphp
                                        <div class="" id="image_upload_wrap_venue_add">
                                            <input class="file-upload-input" id="hotel_cover_image" type='file' name="cover_image" onchange="readURL_add_venue(this);" accept="image/*" {{$venue_cover_required}} />
                                        </div>
                                        <div class="" id="file_upload_content_venue_add">
                                            <div class="profile-img hotal-profile-img"><img class="" id="hotel_cover_upload_image" src="{{$venue_cover_url}}" alt="your image" /></div>
                                            <p> Be sure to use a photo that clearly shows your face and doesn’t include any personal or sensitive info .</p>
                                            <button class="btn get-btn" id="upload_cover_add_venue" type="button" onclick="$('#hotel_cover_image').trigger( 'click' )"><span>Upload Photo</span><span></span><span></span><span></span><span></span></button>
                                            {{--<button class="btn get-btn" id="save_cover_add_venue" style="display: none"><span>Save Photo</span><span></span><span></span><span></span><span></span></button>--}}
                                            <button class="btn get-btn" id="remove_cover_add_venue" type="button" style="display: none" onclick="removeUpload_add_venue()"><span>Remove Photo</span><span></span><span></span><span></span><span></span></button>

                                        </div>
                                    </div><!-- file-upload -->
                                </div>
                            </div>

                            <div class="dash-box dash-personal col-xs-8 dash-add-venue">
                                <h3 class="dashboard-title">Venue Info
                                    <div class=" filter-r-info meeting-toggle vanu-toggle">
                                        <span>Active/ Deactive</span>
                                        <label class="switch">
                                            <input type="checkbox" id="add_venue_switch" onchange="set_status_venue()"  {{isset($venue) && $venue->status == 1 ? 'checked' : ''}}>
                                            <span class="switch-toggle round"></span>
                                        </label>
                                        <input type="hidden" name="status" id="add_venue_status" value="{{isset($venue) && $venue->status == 1 ? '1' : '0'}}">
                                        <script>
                                            function set_status_venue(){
                                                var status =  $('#add_venue_status').val();

                                                if(status == 1)
                                                {
                                                    $('#add_venue_status').val(0);
                                                } else {
                                                    $('#add_venue_status').val(1);
                                                }
                                            }
                                        </script>
                                    </div>
                                </h3>
                                <div class="dash-box-inner dash-personal-box">
                                    <input id="add_venue_id" name="id" value="{{isset($venue) ? $venue->id : ''}}" type="hidden">
                                    <input id="add_venue_company_id" name="company" value="{{isset($company) ? $company->id : ''}}" type="hidden">
                                    <div class="col-sm-12 form-group per-form-group">
                                        <input id="add_venue_title" type="text"  name="title" placeholder="Name" class="form-control" value="{{isset($venue) ? $venue->title : $company->name}}" disabled/>
                                    </div>
                                    <div class="col-sm-12 form-group per-form-group">
                                        <textarea id="add_venue_descriprion" name="description" placeholder="Description">{{ isset($venue) ? $venue->description : '' }}</textarea>
                                    </div>

                                    <h4 class="sub-title">Add Images
                                        <input id="image_gallery_venue" type="file" name="images[]" multiple class="file form-control">
                                    </h4>

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

                                    <h4 class="sub-title">Duration & time</h4>
                                    <div class="space-calagory-box space-feature-box">
                                        <div class="full-col space-feature">
                                            <div class="form-group loc-field col-sm-4 ">
                                                <input class="form-control" name="duration_1" value="Morning" placeholder="Morning" type="text" readonly>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="padding-left: 20px;">
                                                <input class="form-control timepicker" id="start_time_1" name="start_time_1" value="{{$morning_time_in}}" onfocusout="check_time('start_time_1','end_time_1')" placeholder="Start Time" required>
                                                <label id="start_time_1_error" class="custom-time-error" for="start_time_1" style="display: none ">Timing overlap</label>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="padding-left: 20px;">
                                                <input class="form-control timepicker" id="end_time_1" name="end_time_1" value="{{$morning_time_out}}" onfocusout="check_time('start_time_1','end_time_1'); check_time_2('start_time_2','end_time_1')" placeholder="End Time" required>
                                                <label id="end_time_1_error" class="custom-time-error" for="end_time_1" style="display: none ">Time must be greater</label>
                                            </div>

                                            <div class="form-group loc-field col-sm-4">
                                                <input class="form-control" name="duration_2" value="Afternoon" placeholder="Afternoon" type="text" readonly>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="padding-left: 20px;">
                                                <input class="form-control timepicker" id="start_time_2" name="start_time_2" value="{{$afternoon_time_in}}" onfocusout="check_time('start_time_2','end_time_2'); check_time_2('start_time_2','end_time_1')" placeholder="Start Time" required>
                                                <label id="start_time_2_error" class="custom-time-error" for="start_time_2" style="display: none ">Timing overlap</label>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="padding-left: 20px;">
                                                <input class="form-control timepicker" id="end_time_2" name="end_time_2" value="{{$afternoon_time_out}}" onfocusout="check_time('start_time_2','end_time_2'); check_time_2('start_time_3','end_time_2')"  placeholder="End Time" required>
                                                <label id="end_time_2_error" class="custom-time-error" for="end_time_2" style="display: none ">Time must be greater</label>
                                            </div>

                                            <div class="form-group loc-field col-sm-4">
                                                <input class="form-control" name="duration_3" value="Evening" placeholder="Evening" type="text" readonly>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="padding-left: 20px;">
                                                <input class="form-control timepicker" id="start_time_3" name="start_time_3" value="{{$evening_time_in}}" onfocusout="check_time('start_time_3','end_time_3'); check_time_2('start_time_3','end_time_2')" placeholder="Start Time" required>
                                                <label id="start_time_3_error" class="custom-time-error" for="start_time_3" style="display: none ">Timing overlap</label>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="padding-left: 20px;">
                                                <input class="form-control timepicker" id="end_time_3" name="end_time_3" value="{{$evening_time_out}}" onfocusout="get_night_time(); check_time('start_time_3','end_time_3')" placeholder="End Time" required>
                                                <label id="end_time_3_error" class="custom-time-error" for="end_time_3" style="display: none ">Time must be greater</label>
                                            </div>

                                            <div class="form-group loc-field col-sm-4" style="display: none">
                                                <input class="form-control" name="duration_4" value="Night" placeholder="Night" type="text" readonly >
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="display: none">
                                                <input class="form-control timepicker" id="start_time_4" name="start_time_4" value="{{$night_time_in}}" placeholder="Start Time" required>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="display: none">
                                                <input class="form-control timepicker" id="end_time_4" name="end_time_4" value="{{$night_time_out}}" placeholder="End Time" required>
                                            </div>

                                            <div class="form-group loc-field col-sm-4">
                                                <input class="form-control" name="duration_5" value="Full Day" placeholder="Full Day" type="text" readonly>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="padding-left: 20px;">
                                                <input class="form-control timepicker" id="start_time_5" name="start_time_5" value="{{$fullday_time_in}}" onfocusout="check_time('start_time_5','end_time_5')" placeholder="Start Time" required>
                                            </div>

                                            <div class="form-group loc-field col-sm-4 timepicker-wrap" style="padding-left: 20px;">
                                                <input class="form-control timepicker" id="end_time_5" name="end_time_5" value="{{$fullday_time_out}}" onfocusout="get_night_time(); check_time('start_time_5','end_time_5')" placeholder="End Time" required>
                                                <label id="end_time_5_error" class="custom-time-error" for="end_time_5" style="display: none ">Time must be greater</label>
                                            </div>
                                        </div><!-- full-col space-feature -->
                                    </div><!-- Duration-calagory-box -->

                                    <h4 class="sub-title">Cuisine / Food Menu</h4>
                                    <div class="space-calagory-box space-feature-box" id="food_category_text_boxs">
                                        <div class="full-col space-feature">


                                            <div class="form-group loc-field col-sm-4" >
                                                <select class="food_input food_input" id="food_duration" name="food_duration" aria-invalid="false" style="color: #b11f5f;">
                                                    <option value="Morning">Breakfast</option>
                                                    <option value="Afternoon">Lunch</option>
                                                    <option value="Evening">Tea/Coffee</option>
                                                    <option value="Night">Dinner</option>
                                                </select>
                                            </div>
                                            <div class="form-group loc-field col-sm-4" style="padding-left: 20px;">
                                                <select name="food_category" class="form-control custom-scroll" id="food_category" >
                                                    @if(isset($food_types))
                                                        @foreach($food_types as $key=>$food_type)

                                                            <option value="{{$food_type->title}}">{{$food_type->title}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                                {{--<input type="text" id="food_category" name="food_category" placeholder="Food Category" class="form-control Search-location food_input">--}}
                                            </div>

                                            <div class="form-group loc-field currency-wrap col-sm-4">
                                                <div class="currency-field">
                                                    <select class="food_input" id="food_currency" name="food_currency">
                                                        <option value="AED" selected>AED</option>
                                                    </select>
                                                    <input id="food_price" name="food_price" placeholder="Price" type="number" min="1" class="form-control Search-location food_input">
                                                </div><!-- currency-field -->
                                            </div><!-- currency-wrap -->
                                        </div><!-- full-col space-feature -->
                                        <div class="space-feature-full">
                                            <div id="food_field">
                                                <div class="space-feature-flied">
                                                    <div class="form-group">
                                                        <input id="food_item1" name="food_item1" type="text" placeholder="Food Name" class="form-control food_input food_item">
                                                    </div>
                                                </div><!-- space-feature-flied -->
                                                <button class="ani-btn sp-f-btn" type="button" onclick="add_more_item()">Add Item</button>
                                                <div id="new_food_items">

                                                </div>

                                                <input type="hidden" id="add_venue_food_count" name="total_account" value="0">
                                            </div><!--field-->
                                            <div class="catagory-btn"><a class="ani-btn" onclick="add_food_category()">Add Category</a></div>
                                        </div><!-- space-feature -->
                                        <label id="food_field_error" style="display: none;font-size: 13px;color: #cc0000 !important;  float: left; width: 100%; ">Please fill all fields</label>
                                    </div><!-- food-calagory-box -->

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

                                    <h4 class="sub-title">Add Ons</h4>

                                    <div id="all_add_ons_inputs" class="space-calagory-box space-feature-box">
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

                                                <div class="form-group addon-flied" id="new_add_ons_item{{$addon_key+1}}">
                                                    <div class="addon-flied-inner">
                                                        <div class="col-md-5">
                                                            <input type="hidden" name="addons_id{{$addon_key+1}}" value="{{$addon->id}}" onchange="makeAddoneRequired('{{$addon_key+1}}'); checkTheDropdowns()">
                                                            <select name="addons{{$addon_key+1}}" class="form-control custom-scroll addon-select-box" id="addons{{$addon_key+1}}" >
                                                                @foreach($amenities as $amenitie)
                                                                    @if($addon->amenity_id == $amenitie->id)
                                                                        @php $selected = 'selected'; @endphp
                                                                    @else
                                                                        @php $selected = ''; @endphp
                                                                    @endif
                                                                    <option value="{{$amenitie->id}}" {{$selected}}>{{$amenitie->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input class="form-control check_addons_input" id="addone_price{{$addon_key+1}}" name="addone_price{{$addon_key+1}}" value="{{$addon->price}}" placeholder="Price" type="number" min="1" required>
                                                        </div>
                                                    </div>

                                                    @if($addon_key+1 == 1)
                                                        <div class="col-md-2 addon-btn">
                                                            <button class="ani-btn" type="button" onclick="add_more_add_ons()">Add Item</button>
                                                        </div>
                                                    @else
                                                        <div class="col-md-2 addon-btn" id="add_ons_delete{{$addon_key+1}}">
                                                            <button class="addon-del-btn" type="button" onclick="delete_add_ons({{$addon_key+1}})">  <img src="{{url('images/delete.png')}}" alt="del">  </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            @php $total_addons = 1; @endphp
                                            <div class="form-group addon-flied">
                                                <div class="addon-flied-inner">
                                                    <div class="col-md-5">
                                                        <select name="addons1" class="form-control custom-scroll addon-select-box" id="addons1" onchange="checkTheDropdowns()" required>
                                                            <option disabled selected>-Please select an option-</option>
                                                            @foreach($amenities as $key=>$amenitie)
                                                                <option value="{{$amenitie->id}}">{{$amenitie->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input class="form-control check_addons_input" id="addone_price1" name="addone_price1" value="" placeholder="Price" type="number" min="1" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 addon-btn">
                                                    <button class="ani-btn" type="button" onclick="add_more_add_ons()">Add Item</button>
                                                </div>
                                            </div>
                                        @endif
                                        <input id="amenities_count" value="{{count($amenities)}}" type="hidden" required>
                                        <div class="form-group" id="new_add_ons_items">

                                        </div>

                                        <label id="add_ons_field_error" style="display: none;font-size: 13px;color: #cc0000 !important;">All Add Ons are added</label>


                                        @php
                                            if(isset($venue) && count($addons_arr_db) > 0)
                                            {
                                                $total_add_ons = $total_addons_db;
                                            } else {
                                                $total_add_ons = $total_addons;
                                            }
                                        @endphp
                                        <input type="hidden" id="total_add_ons" name="total_account_add_ons" value="{{$total_add_ons}}">

                                    </div>

                                    <h4 class="sub-title">Add Amenities</h4>
                                    <div class="space-calagory-box space-calagory-box1 space-feature-box">
                                        <div class="form-group">
                                            @php
                                                if(isset($venue)) {
                                                $amenities_spaces = array();
                                                foreach($v_amenities as $as){
                                                 array_push($amenities_spaces , $as->id);
                                                 }
                                                }
                                            @endphp
                                            <select multiple="" name="amenities_id[]" class="js-select2-multi form-control custom-scroll" id="amenities_id" >
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


                                    <div class="col-sm-12 form-group per-form-group">
                                        <textarea id="add_venue_cancellation_policy" name="cancellation_policy" placeholder="Cancellation policy" required>{{isset($venue) ? $venue->cancellation_policy : ''}}</textarea>
                                    </div>
                                    <h4 class="sub-title">Location</h4>
                                    <div class="col-sm-6 form-group per-form-group sp-select">
                                        <select class="select2" name="country" onchange="get_cities(this.value)" required>
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

                                    <div class="col-sm-6 form-group per-form-group sp-select">
                                        <select class="select2" name="city" id="cities" required>
                                            <option disabled selected>-Select a City-</option>
                                            @if(isset($venue))
                                                <option selected value="{{$venue->city}}">{{$venue->city}}</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-sm-12 form-group per-form-group">
                                        {{--<input type="text" name="location" placeholder="Add Your Location" class="form-control"/>--}}
                                        <input id="searchmap_venue" class="form-control search_address_venue" name="location" type="text"  value="{{isset($venue)? $venue->location : 'Shaheen Complex, Egerton Rd, Garhi Shahu, Lahore, Punjab 54000'}}" required>
                                    </div>
                                    <div id="map_venue" class="mapwrap hotal-map" data-gmap-lat="23.895883" data-gmap-lng="-80.650635" data-gmap-zoom="5" data-gmap-src="xml/gmap/pins.xml"></div>
                                    <input id="add_venue_latitude" type="hidden" name="latitude" class="search_latitude search_latitude_venue" value="{{isset($venue)? $venue->latitude : '31.5629793'}}">
                                    <input id="add_venue_longitude" type="hidden" name="longitude" class="search_longitude search_longitude_venue" value="{{isset($venue)? $venue->longitude : '74.3308058'}}">

                                    <div class="col-sm-2 form-group per-form-group">
                                        <button class="btn get-btn" type="submit"><span>Save Venue</span><span></span><span></span><span></span><span></span></button>
                                    </div>

                                </div>
                            </div>
                        </div><!--check-->
                    </form>
                </div>
            </div>
        </div>
        <!-- /tabs -->
        <div class="clearfix"></div>
    </section>

    @php
        $images_array = '[]';
        if(isset($venue) && $venue->images)
        {
            $images_array = $venue->images;
        }
    @endphp

    <!-- hidden field for multi images-->
    <input type="hidden" id="images_name" value="{{$images_array}}">
    <!-- hidden field -->
@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
@section('scripts')
    @include('site.layouts.scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    {{--<script src="{{url('js/admin-panel/plugin/clockpicker/clockpicker.min.js')}}"></script>--}}

    <script>

        $(document).ready(function(){

        });

        function get_night_time() {
            $('#start_time_4').val($('#end_time_3').val());
            $('#end_time_4').val($('#end_time_5').val());
        }

        function check_time(start_id, end_id)
        {
            var start_time = $('#'+start_id).val();
            var end_time = $('#'+end_id).val();
            var label_id = '#'+end_id+'_error';

            var startTime = autotimeConvertor(start_time);
            var endTime = autotimeConvertor(end_time);

            var regExp = /(\d{1,2})\:(\d{1,2})\:(\d{1,2})/;
            if(parseInt(endTime .replace(regExp, "$1$2$3")) < parseInt(startTime .replace(regExp, "$1$2$3"))){
                $('#'+end_id).val('');
                $('#'+end_id).css('border-color', '#cc0000');
                $(label_id).css('display', 'block');
                // alert("Start time is greater");
            } else {
                $('#'+end_id).css('border-color', '#dedede');
                $(label_id).css('display', 'none');
            }

            // alert('#'+end_id+'_error');

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

            // alert('#'+end_id+'_error');

        }


        function autotimeConvertor(time) {
            var PM = time.match('pm') ? true : false;
            var AM = time.match('am') ? true : false;

            time = time.split(':');
            var min = time[1];

            // console.log(time[0]);

            if (PM) {
                if(parseInt(time[0],10) == 12){
                    var hour = parseInt(time[0],10);
                } else {
                    var hour = 12 + parseInt(time[0],10);
                }

                var min = time[1].replace('pm', ':00');
            }
            if(AM) {
                var hour = time[0];
                var min = time[1].replace('am', ':00');
            }

            return hour + ':' + min;
        }

        // alert(autotimeConvertor('07:03PM')); // "19:03:15"
        //
        // alert(autotimeConvertor('1:53AM')); // "1:53:55"



        //select
        $(".select2").select2();

        function get_venue_images_url(id, images)
        {
            var data = [];

            var images_name = $.parseJSON(images);
            // var size = Object.keys(images_name).length;

            if (id)
            {
                var data = [];
                for (var i = 0; i < images_name.length; i++)
                {
                    var url = base_url + '/storage/images/venues/'+id+'/'+images_name[i];
                    data.push(url);
                }
            }

            return data;
        }

        var data = get_venue_images_url($('#add_venue_id').val(), $('#images_name').val());
        var delete_data = get_venue_images_delete($('#add_venue_id').val(), $('#images_name').val());

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
                    extra['_token'] = $("#csrf_token").val();
                    extra['id'] = $("#add_venue_id").val();


                    var arr = {};

                    arr['caption'] = images_name[i];
                    // arr['url'] = base_url+ '/company/dashboard/venue/images/delete/'+id+'/'+images_name[i];
                    arr['url'] = base_url+ '/company/dashboard/venue/images/delete';
                    arr['key'] = images_name[i];
                    arr['extra'] = extra;
                    delete_data.push(arr);
                }
            }

            return delete_data;
        }




        //image gallery plugin
        var $el1 =  $("#image_gallery_venue");
        $el1.fileinput({
            uploadUrl:  base_url,
            dropZoneEnabled: false,
            showUpload: false, // The "Upload" button
            showRemove: false, // The "Remove" button
            showCancel: false,
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
        //     .on("filebatchselected", function(event, files) {
        //     console.log(files);
        //     // $el1.fileinput("upload");
        // });




        $("#add_venue_form").validate({
            ignore:[],
            rules: {
                title: {
                    required: true
                },
                description: {
                    required: true
                },
                cancellation_policy: {
                    required: true
                },
                food_array_check: {
                    min: 1
                }
            },
            messages: {
                title: {
                    required: "Venue Title is Required",
                },
                description: {
                    required: "Description is Required",
                },
                cancellation_policy: {
                    required: "Please provide your Cancellation policy",
                },
                cover_image: {
                    required: "Please Select a Cover Image",
                },
                food_array_check: {
                    min: "Place add food first"
                }
            }});


        // add-on JS
        function makeAddoneRequired(key) {
            var addons_name = $("#addons"+key).val();
            var addons_price = $("#addone_price"+key).val();
        }

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
        //     // console.log(s);
        //     // console.log(i);
        //     $(".addon-select-box").not(s).find("option[value="+$(s).val()+"]").remove();
        // });


        function add_more_add_ons()
        {
            // var empty = $('#all_add_ons_inputs').find('.check_addons_input').filter(function() {
            //     return this.value === "";
            // });

            var empty = $('#all_add_ons_inputs').find('.check_addons_input');

            var count_add_ons = $('#amenities_count').val();

            // console.log(empty.length, 'empty');
            // console.log(count_add_ons, 'count_add_ons');

            if(empty.length >= count_add_ons)
            {
                $('#add_ons_field_error').css({'display':'block'});
            } else {
                $('#add_ons_field_error').css({'display':'none'});
                var t_account = $("#total_add_ons").val();
                var next = parseInt(t_account) + 1;
                $("#total_add_ons").val(next);

                // next = next + 1;
                var newIn = '<div class="form-group addon-flied" id="new_add_ons_item'+next+'">' +
                    '<div class="addon-flied-inner">' +
                    '<div class="col-md-5">' +
                    '<select name="addons'+next+'" class="form-control custom-scroll addon-select-box" id="addons'+next+'" onchange="makeAddoneRequired('+next+'); checkTheDropdowns()" required>' +
                    '<option disabled selected value="">-Please select an option-</option>'+
                    '@foreach($amenities as $amenitie)<option value="{{$amenitie->id}}">{{$amenitie->name}}</option> @endforeach'+
                    '</select>' +
                    '</div>' +
                    '<div class="col-md-5">' +
                    '<input class="form-control check_addons_input" id="addone_price'+next+'" name="addone_price'+next+'" value="" placeholder="Price" type="number" min="1" required>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-md-2 addon-btn" id="add_ons_delete'+next+'">' +
                    '<button class="addon-del-btn" type="button" onclick="delete_add_ons('+next+')">  <img src="'+base_url+'/images/delete.png" alt="del">  </button>' +
                    '</div>' +
                    '</div>';

                $('#new_add_ons_items').append(newIn);


                checkTheDropdowns();
            }



            // $(".addon-select-box").each(function(i,s){
            //     // console.log(s);
            //     // console.log(i);
            //     $(".addon-select-box").not(s).find("option[value="+$(s).val()+"]").remove();
            // });

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
                // console.log(old_food_array[j].food_items);

                if(old_food_array[j].food_items)
                {
                    var food_items =  old_food_array[j].food_items;
                    var food_id =  old_food_array[j].id;
                    var food_category =  old_food_array[j].category;
                    var food_currency =  old_food_array[j].food_currency;
                    var food_price =  old_food_array[j].food_price;
                    var i;
                    var items_str = '';
                    for (i = 0; i < food_items.length; i++) {
                        items_str += '<li> '+food_items[i]+' </li>';
                    }


                    var newIn = '<div class="cuisine-box" id="cuisine_box'+food_id+'">' +
                        '<h3>'+food_category+' <span>'+food_currency+' '+food_price+' </span></h3>' +
                        '<div class="edit-del">' +
                        '<a onclick="edit_food_category('+food_id+')"><img src="'+base_url+'/images/edit.png" alt="del"></a>' +
                        '<a onclick="delete_food_category('+food_id+')"><img src="'+base_url+'/images/delete.png" alt="del"></a>' +
                        '</div>' +
                        '<ul>'+items_str+'</ul>' +
                        '</div>';

                    $('#added_food_items').append(newIn);
                }
            }
        }

        function add_more_item()
        {
            var t_account = $("#add_venue_food_count").val();
            var next = parseInt(t_account) + 1;
            $("#add_venue_food_count").val(next);

            next = next + 1;

            var newIn = '<div id="new_food_item'+next+'">' +
                '<div class="space-feature-flied">' +
                '<div class="form-group">' +
                '<input class="form-control food_input food_item" name="food_item'+next+'" value="" placeholder="Food Name" type="text">' +
                '</div>' +
                '</div>' +
                '<div id="food_item_delete'+next+'">' +
                '<button class="cross sp-f-btn" onclick="delete_food_item('+next+')"><img src="'+base_url+'/images/delete.png" alt=""/> </button>'+
                '</div>'+
                '</div>';

            $('#new_food_items').append(newIn);
        }

        function delete_food_item(i)
        {
            var t_account = $("#add_venue_food_count").val();
            var next = parseInt(t_account) - 1;
            $("#add_venue_food_count").val(next);
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

                var i;
                var items_str = '';
                for (i = 0; i < food_items.length; i++) {
                    items_str += '<li> '+food_items[i]+' </li>';
                }


                var newIn = '<div class="cuisine-box" id="cuisine_box'+food_id+'">' +
                    '<h3>'+food_category+' <span>'+food_currency+' '+food_price+' </span></h3>' +
                    '<div class="edit-del">' +
                    '<a onclick="edit_food_category('+food_id+')"><img src="'+base_url+'/images/edit.png" alt="del"></a>' +
                    '<a onclick="delete_food_category('+food_id+')"><img src="'+base_url+'/images/delete.png" alt="del"></a>' +
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

                            var newIn = '<div id="new_food_item'+next+'">' +
                                '<div class="space-feature-flied">' +
                                '<div class="form-group">' +
                                '<input class="form-control food_input food_item" name="food_item'+next+'" value="'+old_food[j]+'" placeholder="Food Name" type="text">' +
                                '</div>' +
                                '</div>' +
                                '<div id="food_item_delete'+next+'">' +
                                '<button class="cross sp-f-btn" onclick="delete_food_item('+next+')"><img src="'+base_url+'/images/delete.png" alt=""/> </button>'+
                                '</div>'+
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


        //upload hotel cover photo
        function readURL_add_venue(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_upload_wrap_venue_add').hide();

                    $('#hotel_cover_upload_image').attr('src', e.target.result);
                    $('#file_upload_content_venue_add').show();

                    // $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        $('#image_upload_wrap_venue_add').bind('dragover', function () {
            $('#image_upload_wrap_venue_add').addClass('image-dropping');
        });
        $('#image_upload_wrap_venue_add').bind('dragleave', function () {
            $('#image_upload_wrap_venue_add').removeClass('image-dropping');
        });



        $("#hotel_cover_image").change(function (){
            var fileName = $(this).val();

            if(fileName)
            {
                $('#remove_cover_add_venue').css("display", "block");
                $('#save_cover_add_venue').css("display", "block");
                $('#upload_cover_add_venue').css("display", "none");
            } else {
                $('#remove_cover_add_venue').css("display", "none");
                $('#save_cover_add_venue').css("display", "none");
                $('#upload_cover_add_venue').css("display", "block");
            }
        });

        function removeUpload_add_venue() {
            var baseUrl = '@php echo url('images/edit-profile-iconh.png'); @endphp';
            $('#hotel_cover_image').val('');
            $('#hotel_cover_upload_image').attr("src",baseUrl);


            $('#image_upload_wrap_venue_add').css("display", "block");

            $('#remove_cover_add_venue').css("display", "none");
            $('#save_cover_add_venue').css("display", "none");

            $('#upload_cover_add_venue').css("display", "block");
        }
        //end upload cover photo

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
    <script type="text/javascript">
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
    </script>

    <script type="text/javascript">
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 15,

                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng(25.099448, 55.161948), // New York

                // How you would like to style the map.
                // This is where you would paste any style found on Snazzy Maps.

            };

            // Get the HTML DOM element that will contain your map
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('map_venue');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Let's also add a marker while we're at it

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(25.099448, 55.161948),
                map: map,
                title: 'Snazzy!',
                icon: base_url+'/images/locator1.png'
            });

        }
    </script>

@endsection


