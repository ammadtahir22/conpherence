@extends('site.layouts.app')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
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
                <div class="tab-pane active" id="space">
                    <div class="welcome-title full-col">
                        <div class="back-to"><a href="{{url('/company/dashboard/space/index/'.$venue->id)}}"><img src="{{url('images/back.png')}}" alt="" />Back to Space listing</a></div>
                    </div>
                    <form action="{{url('/space/save')}}" method="post" enctype="multipart/form-data" id="add_space_form">
                        @csrf
                        <div class="hotal-add-vanu">
                            <div class="dash-box col-xs-4 dash-featured-photo">
                                <h3 class="dashboard-title">Featured Image</h3>
                                <div class="dash-box-inner profile-photo-box">
                                    <div class="file-upload">
                                        @php
                                            $space_cover_url = url('images/edit-profile-iconh.png');
                                            $space_cover_required = 'required';

                                            if(isset($spaces) && $spaces['image'] != ' ')
                                            {
                                                $space_cover_url = url('storage/images/spaces/'.$spaces->image);
                                                $space_cover_required = '';
                                            }
                                        @endphp

                                        <div class="" id="image_upload_wrap_venue_add">
                                            <input class="file-upload-input" id="hotel_cover_image" type='file' name="image" onchange="readURL_add_venue(this);" accept="image/*" {{$space_cover_required}} />
                                        </div>
                                        <div class="" id="file_upload_content_venue_add">
                                            <div class="profile-img hotal-profile-img"><img class="" id="hotel_cover_upload_image" src="{{$space_cover_url}}" alt="your image" /></div>
                                            <p> Be sure to use a photo that clearly shows your face and doesn’t include any personal or sensitive info .</p>
                                            <button class="btn get-btn" id="upload_cover_add_venue" type="button" onclick="$('#hotel_cover_image').trigger( 'click' )"><span>Upload Photo</span><span></span><span></span><span></span><span></span></button>
                                            {{--<button class="btn get-btn" id="save_cover_add_venue" style="display: none"><span>Save Photo</span><span></span><span></span><span></span><span></span></button>--}}
                                            <button class="btn get-btn" id="remove_cover_add_venue" type="button" style="display: none" onclick="removeUpload_add_venue()"><span>Remove Photo</span><span></span><span></span><span></span><span></span></button>

                                        </div>

                                    </div>
                                </div><!-- file-upload -->
                            </div>
                        </div>

                        <div class="dash-box dash-personal col-xs-8 dash-add-venue">
                            <h3 class="dashboard-title">Space Info
                                <div class=" filter-r-info meeting-toggle vanu-toggle">
                                    <span>Active/ Deactive</span>
                                    <label class="switch">
                                        <input type="checkbox" onchange="set_status_space()" {{isset($spaces) && $spaces->status == 1 ? 'checked' : ''}}>
                                        <span class="switch-toggle round"></span>
                                    </label>
                                    <input type="hidden" name="status" id="add_space_status" value="{{isset($spaces) && $spaces->status == 1 ? '1' : '0'}}">

                                </div></h3>
                            <div class="dash-box-inner dash-personal-box">


                                <input id="space_id" name="id" value="{{isset($spaces) ? $spaces->id : ''}}" type="hidden">

                                <input id="add_venue_space_id" name="venue_id" value="{{isset($venue) ? $venue->id : ''}}" type="hidden">
                                <input name="company" value="{{isset($company) ? $company->id : ''}}" type="hidden">


                                <div class="col-sm-12 form-group per-form-group">
                                    <input id="add_space_title" type="text"  placeholder="Title" value="{{isset($spaces) ? $spaces->title : ''}}" name="title" class="form-control" required/>

                                </div>
                                <div class="col-sm-6 form-group per-form-group">

                                    @php if(isset($spaces) && isset($s_spacetypes)) {  $s_type = 0; foreach($s_spacetypes as $type) { $s_type = $type->id; } }@endphp
                                    <select name="space-type" class="form-control custom-scroll" id="add_space_type" required>
                                        @foreach($spacetypes as $key=>$spacetype)
                                            @if(isset($spaces) && $spacetype->id == $s_type)
                                                @php $selected = 'selected'; @endphp
                                            @else
                                                @php $selected = ''; @endphp
                                            @endif
                                            <option {{$selected}} value="{{$spacetype->id}}">{{$spacetype->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group per-form-group ">
                                    <div class="currency-field currency-group">
                                        <select>
                                            <option>AED</option>
                                            <option>AED</option>
                                        </select>
                                        <input type="number" name="price" value="{{isset($spaces)? $spaces->price : ''}}" placeholder="Add Price In Per Person" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group per-form-group">
                                    <textarea id="add_space_description" name="ckeditor" placeholder="Description" required>{{isset($spaces) ? $spaces->description : ''}}</textarea>
                                </div>
                                <div class="col-sm-12 form-group per-form-group">
                                    <label>Cancellation Policy</label>
                                    <textarea id="add_space_description" name="cancellation_policy" placeholder="Description" required>{{isset($spaces) ? $spaces->cancellation_policy : ''}}</textarea>
                                </div>
                                <div class="col-sm-6 form-group per-form-group add-sp-sphere">

                                        <input type="number" name="hours" value="{{isset($spaces)? $spaces->hours : ''}}" placeholder="Free Cancellation upto (hrs)" class="form-control ">

                                </div>
                                <div class="col-sm-6 form-group per-form-group add-sp-sphere">
                                    <input type="number" name="cancel_cost" value="{{isset($spaces)? $spaces->cancel_cost : ''}}" placeholder="Cancellation penality (percentage)" class="form-control ">
                                </div>
                                <h4 class="sub-title">Add images <input id="image_gallery_space" type="file" name="gallery[]" multiple class="file form-control">
                                    <!-- hidden field for multi images-->
                                    @php
                                        $gallery = '[]';
                                        if(isset($spaces) && $spaces->gallery)
                                        {
                                        $gallery = $spaces->gallery;
                                        }

                                    @endphp
                                    <input type="hidden" id="images_name" value="{{$gallery}}">
                                    <!-- hidden field -->
                                </h4>

                                <h4 class="sub-title">Amenities</h4>
                                <div class="space-calagory-box space-calagory-box1">

                                    <select id="add_space_amenities" name="amenities_id[]" class="js-select2-multi select2-dropdown--above" multiple="multiple" required>

                                        @if(isset($spaces))

                                        @foreach($s_addons as $s_addon)
                                            @if(!empty($spaces->amenities))
                                                @if(in_array($s_addon->amenity_id , json_decode($spaces->amenities)))
                                                    @php $selected = 'selected'; @endphp
                                                @else
                                                    @php $selected = ''; @endphp
                                                @endif
                                            @else
                                                @php $selected = ''; @endphp
                                            @endif

                                            <option {{$selected}} value="{{$s_addon->amenity_id}}">{{get_amenity_name($s_addon->amenity_id)}}</option>
                                        @endforeach
                                        @else
                                            @foreach ($s_addons as $s_addon)
                                                <option value="{{$s_addon->amenity_id}}">{{get_amenity_name($s_addon->amenity_id)}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div><!-- space-calagory-box -->
                                <h4 class="sub-title">Free with this Space</h4>
                                <div class="space-calagory-box space-calagory-box1">
                                    <select name="free_amenity[]"  id="add_free_amenity" class="js-select2-multi select2-dropdown--above" multiple="multiple" required>
                                        @if(isset($spaces))
                                        @foreach($v_amenities as $key=>$amenitie)
                                            @if($spaces->amenities != "null")
                                                @if(isset($spaces) &&  in_array($amenitie->id  , json_decode($spaces->free_amenities)))
                                                    @php $selected = 'selected'; @endphp
                                                @else
                                                    @php $selected = ''; @endphp
                                                @endif
                                            @else
                                                @php $selected = ''; @endphp
                                            @endif

                                            <option {{$selected}} value="{{$amenitie->id}}">{{$amenitie->name}}</option>
                                        @endforeach

                                        @else

                                            @foreach($v_amenities as $key=>$amenitie)
                                                <option {{$selected}} value="{{$amenitie->id}}">{{$amenitie->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                        {{--<select id="add_space_amenitiess" name="amenities_id[]" class="js-select2-multi select2-dropdown--above" multiple="multiple" required>--}}
                                            {{--@php--}}
                                                {{--if(isset($spaces)) {--}}
                                                    {{--$amenities_spaces = array();--}}
                                                    {{--if(count($s_amenities) > 0)--}}
                                                    {{--{--}}
                                                        {{--foreach($s_amenities as $as)--}}
                                                        {{--{--}}
                                                            {{--array_push($amenities_spaces , $as);--}}
                                                        {{--}--}}
                                                    {{--}--}}
                                                {{--}--}}
                                            {{--@endphp--}}
                                            {{--@foreach($amenities as $key=>$amenitie)--}}
                                                {{--@if(isset($spaces) &&  in_array($amenitie->id  , $amenities_spaces))--}}
                                                    {{--@php $selected = 'selected'; @endphp--}}

                                                {{--@else--}}
                                                    {{--@php $selected = ''; @endphp--}}
                                                {{--@endif--}}
                                                {{--<option {{$selected}} value="{{$amenitie->id}}">{{$amenitie->name}}</option>--}}

                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                </div><!-- space-calagory-box -->
                                <h4 class="sub-title">Accessibility</h4>
                                <div class="space-calagory-box space-calagory-box1">

                                    @php
                                        if(isset($spaces))
                                        {
                                            $access = array();
                                            if(count($s_accessibilities) > 0)
                                            {
                                                foreach($s_accessibilities as $as)
                                                    {
                                                        array_push($access , $as->id);
                                                    }
                                            }
                                        }
                                    @endphp
                                    <select id="add_space_accessibility" name="accessibility_id[]" class="js-select2-multi select2-dropdown--above" multiple="multiple" required>
                                        @foreach($accessibilities as $key=>$accessibilitie)
                                            @if(isset($spaces) &&  in_array($accessibilitie->id  , $access))
                                                @php $selected = 'selected'; @endphp
                                            @else
                                                @php $selected = ''; @endphp
                                            @endif
                                            <option {{$selected}} value="{{$accessibilitie->id}}">{{$accessibilitie->name}}</option>
                                        @endforeach
                                    </select>

                                </div><!-- space-calagory-box -->
                                <h4 class="sub-title">Capacity</h4>
                                <div class="space-calagory-box space-feature-box">
                                    <div class="full-col space-feature">
                                        <div class="space-feature-addd">
                                            <div id="all_sitting_plan_inputs" class="space-calagory-box space-feature-box space-cap-box">
                                                <!----------------------------------------------->
                                                <div id="field" class="space-feature-flied">
                                                    @if(isset($spaces))
                                                        @php $counter = count($s_sittingplans); $counter--; @endphp
                                                        <input type="hidden" value="{{$counter}}" name="count" id="count" />
                                                        @foreach($s_sittingplans as $key1=>$plans)
                                                            <div id="field{{$key1}}">
                                                                <div class="form-group">
                                                                    <label class="col-md-10 control-label" for="action_name">Sitting Plan</label>
                                                                    <div class="col-md-10 cap-field">
                                                                        <select onchange="checkTheDropdowns()"  name="sitting-plans-{{$key1}}" class="form-control custom-scroll sitting-select-box" id="sitting-plan" required>
                                                                            <option  value="">- Select Plan -</option>
                                                                            @foreach($sittingplans as $key=>$sittingplan)
                                                                                @if($sittingplan->id == $plans->sitting_plan_id)
                                                                                    @php $selected = 'selected'; @endphp
                                                                                @else
                                                                                    @php $selected = '';  @endphp
                                                                                @endif
                                                                                <option {{$selected}} value="{{$sittingplan->id}}">{{$sittingplan->title}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <!-- Text input-->
                                                                    <div class="form-group">
                                                                        <label class="col-md-10 control-label" for="action_name">Capacity</label>
                                                                        <div class="col-md-10 cap-field">
                                                                            <input id="capacity" name="capacity-{{$key1}}" type="number" placeholder="" value="{{$plans->capacity}}" class="form-control input-md" required>

                                                                        </div>
                                                                    </div>
                                                                    @if($key1 < $counter)
                                                                        <div class="form-group">
                                                                            <div class="col-md-10 cap-del-btn" style="text-align: right;">
                                                                                {{--<input type="button" value="remove" id="remove{{$key1}}" onclick="remove_entry(this.id)" class="btn btn-danger remove-me">--}}
                                                                                <button id="remove{{$key1}}" onclick="remove_entry(this.id)" class="btn btn-danger remove-me">  <img src="{{url('images/delete.png')}}" alt="del">  </button>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    @else
                                                        @php $counter = 0 @endphp
                                                        <div id="field0">
                                                            <div class="form-group cap-form-group">
                                                                <label class="col-md-10 control-label" for="action_name">Sitting Plan</label>
                                                                <div class="col-md-10 cap-field">
                                                                    <select onchange="checkTheDropdowns()"  name="sitting-plans-0" class="form-control custom-scroll sitting-select-box" id="sitting-plan" required>
                                                                        <option  value="">- Select Plan -</option>
                                                                        @foreach($sittingplans as $key=>$sittingplan)
                                                                            <option {{$selected}} value="{{$sittingplan->id}}">{{$sittingplan->title}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <!-- Text input-->
                                                                <div class="form-group ">
                                                                    <label class="col-md-10 control-label" for="action_name">Capacity</label>
                                                                    <div class="col-md-10 cap-field">
                                                                        <input id="capacity" name="capacity-0" type="number" placeholder="People" value="" class="form-control input-md" required>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endif

                                                </div>
                                                <!-- Button -->
                                                <div class="form-group cap-btn">
                                                    <div class="col-md-10 ">
                                                        <button id="add-more" name="add-more" class="btn btn-primary">Add Plan</button>
                                                    </div>
                                                </div>

                                                <!----------------------------------------------->
                                                <p id="sitting_field_error" class="error" style="display: none;">All Sitting plans added.</p>

                                            </div><!-- space-feature-box -->
                                        </div><!-- space-feature-full -->
                                    </div><!-- space-feature -->
                                </div><!-- space-calagory-box -->


                                <div class="col-sm-2 form-group per-form-group">
                                    <button class="btn get-btn" type="submit"><span>Save Space</span><span></span><span></span><span></span><span></span></button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div><!--check-->

            </div>
        </div>
        <!-- /tabs -->
        <div class="clearfix"></div>
    </section>

@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection


@section('scripts')
    @include('site.layouts.scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    <script type="application/javascript">
        function checkTheDropdowns(){
            var arr  = $(".sitting-select-box").find(':selected');
            $(".sitting-select-box").find('option').show();
            $.each($(".sitting-select-box"), function(){
                var self = this;
                var selectVal = $(this).val();
                $.each(arr, function(){
                    if (selectVal !== $(this).val()){
                        $(self).find('option[value="'+$(this).val()+'"]').hide()
                    } else {
                        $(self).find('option[value="'+$(this).val()+'"]').show()
                    }
                });
            });
        }
        checkTheDropdowns();
        $(".sitting-select-box").on('change', checkTheDropdowns);


        var usedlist = [];
        function optionchange(select) {

            var sitting = $(select).val();
            usedlist.push(parseInt(sitting));

            console.log(usedlist);
        }
        function options() {
            var sittingplan = {!! json_encode($sittingplans) !!}
            // console.dir(sittingplan);
            var options = '<option  value="">- Select Plan -</option>';
            for(var i = 0; i < sittingplan.length; i++) {

                var sittingplan_id = sittingplan[i]['id'];
                var sittingplan_title = sittingplan[i]['title'];
                if(usedlist.indexOf(sittingplan_id) < 0) {
                    //  console.log('<option value="'+sittingplan[i]['id']+'">'+sittingplan[i]['title']+'</option>');
                    options = options.concat('<option value="' + sittingplan[i]['id'] + '">' + sittingplan[i]['title'] + '</option>');
                }
            }
            return options;
            // console.log(options);
        }



        //@naresh action dynamic childs
        var next = parseInt('{{$counter}}');

        $("#add-more").click(function(e){
            var sittingplan = {!! json_encode($sittingplans) !!};
            //  console.dir(sittingplan)
            var options = '<option disabled selected>- Select Plan -</option>';
            for(var i = 0; i < sittingplan.length; i++) {

                var sittingplan_id = sittingplan[i]['id'];
                var sittingplan_title = sittingplan[i]['title'];
                options = options.concat('<option value="' + sittingplan[i]['id'] + '">' + sittingplan[i]['title'] + '</option>');
            }

            var empty = $('#all_sitting_plan_inputs').find('.sitting-select-box');

            if(empty.length >= sittingplan.length)
            {
                e.preventDefault();
                $('#sitting_field_error').css({'display':'block'});
            } else {
                $('#sitting_field_error').css({'display': 'none'});


                e.preventDefault();
                var addto = "#field" + next;
                var addRemove = "#field" + (next);
                next = next + 1;
                var newIn = ' <div id="field'+ next +'" name="field'+ next +'" class="space-added-field"><!-- Text input--><div class="form-group"> <label class="col-md-10 control-label" for="action_id">Sitting Plan</label> <div class="col-md-10 cap-field"> <select name="sitting-plans-'+ next +'" onchange="checkTheDropdowns" class="form-control custom-scroll sitting-select-box" required>'+options+'</select> </div></div> <!-- Text input--><div class="form-group"> <label class="col-md-10 control-label" for="action_name">Capacity</label> <div class="col-md-10 cap-field"> <input name="capacity-'+ next +'" type="number" placeholder="" class="form-control input-md" required><input name="count" type="hidden" value="'+next+'" /> </div></div></div></div>';
                var newInput = $(newIn);
                var removeBtn = '<div class="form-group" id="remove_section' + (next - 1) + '"><div class="col-md-10 cap-del-btn" style="text-align: right;"> ' +
                    // '<input type="button" value="remove" onclick="remove_entry(this.id)" id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >' +
                    '<button onclick="remove_entry(this.id)" id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >  <img src="' + base_url + '/images/delete.png" alt="del">  </button>' +
                    '</div></div></div></div><div id="field">';
                var removeButton = $(removeBtn);
                $(addto).after(newInput);
                $(addRemove).after(removeButton);
                $("#field" + next).attr('data-source', $(addto).attr('data-source'));
                $("#count").val(next);

                checkTheDropdowns();
            }
        });
        function remove_entry(id){
            var fieldNum = id.charAt(id.length-1);
            var fieldID = "#field" + fieldNum;
            var removeID = "#remove_section" + fieldNum;
            $(removeID).remove();
            $(fieldID).remove();
            checkTheDropdowns();
        };

        var csrf_token = $('meta[name="csrf-token"]').attr('content');
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
                    var url = base_url + '/storage/images/spaces/'+id+'/'+images_name[i];
                    data.push(url);
                }
            }

            return data;


        }


        function get_space_images_delete(id, images)
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
                    extra['id'] = $("#space_id").val();

                    var arr = {};
                    arr['caption'] = images_name[i];
                    arr['url'] = base_url+ '/company/dashboard/space/images/delete';
                    arr['key'] = images_name[i];
                    arr['extra'] = extra;
                    delete_data.push(arr);
                }
            }
            return delete_data;
        }
        var delete_data = get_space_images_delete($('#space_id').val(), $('#images_name').val());
        var data = get_venue_images_url($('#space_id').val(), $('#images_name').val());
        //image gallery plugin
        $("#image_gallery_space").fileinput({

            {{--uploadUrl:  "{{ url('storage/images/spaces/'.$spaces->id.'/') }}",--}}
            // uploadUrl:  base_url + '/storage/images/spaces/'+$('#space_id').val()+'/',
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

    </script>
    <script>

        $("#add_space_form").validate({
            rules: {
                title: {
                    required: true,
                },
                ckeditor: {
                    required: true
                },
                hours: {
                    required: true
                },
                cancel_cost: {
                    required: true
                },
                cancellation_policy: {
                    required: true,
                },
            },
            messages: {
                title: {
                    required: "Space Title is Required",
                },
                ckeditor: {
                    required: "Description is Required",
                },
                cancellation_policy: {
                    required: "Please provide your Cancellation policy",
                },
                image: {
                    required: "Please Select a Cover Image",
                }
            }
        });

        function set_status_space(){
            var status =  $('#add_space_status').val();

            if(status == 1)
            {
                $('#add_space_status').val(0);
            } else {
                $('#add_space_status').val(1);
            }
        }
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
            console.log(optimage)
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

@endsection


