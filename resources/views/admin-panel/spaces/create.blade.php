@extends('admin-panel.layouts.app')
@section('css-link')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
@endsection

@section('styles')
    <style>
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






@section('footer')
    @include('admin-panel.layouts.footer')
@endsection

@section('shortcut')
    @include('admin-panel.layouts.shortcut')
@endsection


@section('main-panel')
    {{--@include('admin-panel.layouts.main-panel')--}}
    <!-- MAIN PANEL -->
    <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home / @php if(isset($spaces)){ echo "Edit Space"; }else{ echo 'Add Space'; } @endphp</li>
            </ol>

        </div>
        <!-- END RIBBON -->


        <!-- MAIN CONTENT -->
        <div id="content">


            <!-- widget grid -->
            <section id="widget-grid" class="">
                <!-- row -->
                <div class="row">
                    <form action="{{url('/admin/spaces/save')}}" method="post" id="add_space_form" enctype="multipart/form-data">
                        @csrf
                        <input id="space_id" name="id" value="{{isset($spaces) ? $spaces->id : ''}}" type="hidden">

                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            <legend>@php if(isset($spaces)){ echo "Edit Space"; }else{ echo 'Add New Space'; } @endphp</legend>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Title</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" value="{{isset($spaces) ? $spaces->title : ''}}" name="title" placeholder="Title" type="text" required>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Image</label>
                                                <div class="col-md-10">
                                                    <input id="image" type="file" name="image" class="file form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Description</label>
                                                <div class="col-md-10">
                                                    <!-- widget content -->
                                                    <div class="widget-body">
                                                            <textarea name="ckeditor" required>
                                                                 {{isset($spaces) ? $spaces->description : ''}}
                                                            </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Image Gallery</label>
                                                <div class="col-md-10">
                                                    <input id="image_gallery" type="file" name="gallery[]" multiple class="file form-control">
                                                    <!-- hidden field for multi images-->

                                                    <input type="hidden" id="images_name" value="{{isset($spaces) ? $spaces->gallery : ''}}">
                                                    <!-- hidden field -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Cancellation Policy</label>
                                                <div class="col-md-10">
                                                    <!-- widget content -->
                                                    <div class="widget-body">
                                                        <textarea class="form-control" name="cancellation_policy" rows="4" required>{{isset($spaces) ? $spaces->cancellation_policy : ''}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <!-- widget content -->
                                                        <div class="widget-body">
                                                            <input type="number" name="hours" placeholder="Cancellation Hours" value="{{isset($spaces)? $spaces->hours : ''}}" class="form-control" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <!-- widget content -->
                                                        <div class="widget-body">
                                                            <input type="number" name="cancel_cost" placeholder="Cancellation Price In Percentage" value="{{isset($spaces)? $spaces->cancel_cost : ''}}" class="form-control" required />
                                                        </div>
                                                    </div>
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
                        <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget div-->
                                <!-- widget content -->
                                <div class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Publish</legend>
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" {{isset($spaces) && $spaces->status == 1 ? 'checked' : ''}} class="radiobox style-0" name="status" value="1">
                                                        <span>Publish</span>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" {{isset($spaces) && $spaces->status == 0 ? 'checked' : ''}} class="radiobox style-0"  name="status" value="0">
                                                        <span>Draft</span>
                                                    </label>
                                                </div>

                                                <div class="col-sm-12 col-md-10 ">
                                                    <div class="venue_status_area"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <button class="btn btn-primary" id="add-new-space" type="submit">
                                                    <i class="fa fa-save"></i>
                                                    Publish
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- this is what the user will see -->
                                </div>
                                <!-- end widget content -->

                                <!-- widget content -->
                                <div class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Per Person Price</legend>

                                        <div class="form-group">

                                            <div class="col-md-10">

                                                <input type="text" name="price" placeholder="Please Add Per Person Price" value="{{isset($spaces)? $spaces->price : ''}}" class="form-control" required />

                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                                <!-- end widget content -->

                                <!-- widget content -->
                                <div class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Venue</legend>

                                        <div class="form-group">

                                            <div class="col-md-10">

                                                <select class="form-control" name="venue_id" id="venue_id" required>
                                                    @foreach($venues as $key=>$venue)
                                                        @if(isset($spaces) && $venue->id == $spaces->venue_id)
                                                            @php $selected = 'selected'; @endphp
                                                        @else
                                                            @php $selected = ''; @endphp
                                                        @endif
                                                        <option {{$selected}} value="{{$venue->id}}">{{$venue->title}} - {{$venue->city}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                    </fieldset>
                                </div>
                                <!-- end widget content -->


                                <!-- widget content -->
                                <div class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Space Type</legend>

                                        <div class="form-group">

                                            <div class="col-md-10">
                                                @php if(isset($spaces) && isset($s_spacetypes)) {  $s_type = 0; foreach($s_spacetypes as $type) { $s_type = $type->id; } }@endphp
                                                <select  name="space-type" class="form-control custom-scroll" id="space-type">
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
                                        </div>

                                    </fieldset>
                                </div>
                                <!-- end widget content -->

                                <!-- widget content -->
                                <div id="all_sitting_plan_inputs" class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Sitting Plan</legend>

                                    <?php /*    <div class="form-group">

                                            <div class="col-md-10">

                                               <select multiple="" name="sitting-plans[]" class="form-control custom-scroll" id="sitting-plan" >
                                                    @foreach($sittingplans as $key=>$sittingplan)
                                                        @if(isset($spaces) && $sittingplan->id == $spaces->space_id)
                                                            @php $selected = 'selected'; @endphp
                                                        @else
                                                            @php $selected = ''; @endphp
                                                        @endif
                                                        <option {{$selected}} value="{{$sittingplan->id}}">{{$sittingplan->title}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div> */ ?>
                                    <!----------------------------------------------->
                                        <div id="field">

                                            <!-- Text input-->
                                            @if(isset($spaces))
                                                @php $counter = count($s_sittingplans); $counter--; @endphp
                                                <input type="hidden" value="{{$counter}}" name="count" id="count" />

                                                @foreach($s_sittingplans as $key1=>$plans)
                                                    <div id="field{{$key1}}">
                                                        <div class="form-group">
                                                            <label class="col-md-10 control-label" for="action_name">Sitting Plan</label>
                                                            <div class="col-md-10">
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
                                                                <div class="col-md-10">
                                                                    <input id="capacity" name="capacity-{{$key1}}" type="number" placeholder="" value="{{$plans->capacity}}" class="form-control input-md" required>

                                                                </div>
                                                            </div>
                                                            @if($key1 < $counter)
                                                                <div class="form-group">
                                                                    <div class="col-md-10" style="text-align: right;">
                                                                        <input type="button" value="remove" id="remove{{$key1}}" onclick="remove_entry(this.id)" class="btn btn-danger remove-me">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach

                                            @else
                                                @php $counter = 0 @endphp
                                                <div id="field0">
                                                    <div class="form-group">
                                                        <label class="col-md-10 control-label" for="action_name">Sitting Plan</label>
                                                        <div class="col-md-10">
                                                            <select onchange="checkTheDropdowns()"  name="sitting-plans-0" class="form-control custom-scroll sitting-select-box" id="sitting-plan" required>
                                                                <option  value="">- Select Plan -</option>
                                                                @foreach($sittingplans as $key=>$sittingplan)
                                                                    <option value="{{$sittingplan->id}}">{{$sittingplan->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- Text input-->
                                                        <div class="form-group">
                                                            <label class="col-md-10 control-label" for="action_name">Capacity</label>
                                                            <div class="col-md-10">
                                                                <input id="capacity" name="capacity-0" type="number" placeholder="" value="" class="form-control input-md" required>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endif

                                        </div>
                                        <!----------------------------------------------->
                                    </fieldset>
                                    <!-- Button -->
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <button id="add-more" name="add-more" class="btn btn-primary">Add Sitting Plan</button>
                                        </div>
                                        <div class="col-md-12">
                                            <em id="sitting_field_error" class="error" style="display: none;">All Sitting plans added.</em>
                                        </div>
                                    </div>
                                </div>
                                <!-- end widget content -->

                                <!-- widget content -->
                                <div class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Amenities</legend>
                                        <div class="form-group">
                                            <div class="col-md-10">

                                                <select multiple="" name="amenities_id[]" class="form-control custom-scroll" id="amenities_id" required>
                                                    @if(isset($spaces))
                                                        @foreach($amenities as $key=>$amenitie)
                                                            @if($spaces->amenities != "null")
                                                                @if(isset($spaces) &&  in_array($amenitie->id  , json_decode($spaces->amenities)))
                                                                    @php $selected = 'selected'; @endphp
                                                                @else
                                                                    @php $selected = ''; @endphp
                                                                @endif
                                                            @else
                                                                @php $selected = ''; @endphp
                                                            @endif

                                                            <option {{$selected}} value="{{$amenitie->id}}">{{$amenitie->name}}</option>
                                                        @endforeach
                                                    @endif

                                                </select>


                                            </div>

                                        </div>



                                    </fieldset>
                                </div>
                                <!-- end widget content -->


                                <!-- widget content -->
                                <div class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Accessibility</legend>
                                        <div class="form-group">
                                            <div class="col-md-10">

                                                @php
                                                    if(isset($spaces)) {
                                                    $access = array();
                                                    foreach($s_accessibilities as $as){
                                                     array_push($access , $as->id);
                                                     }
                                                    }
                                              //  dump($access);
                                                @endphp
                                                <select multiple="" name="accessibility_id[]" class="form-control custom-scroll" id="accessibility_id" required>
                                                    @foreach($accessibilities as $key=>$accessibilitie)
                                                        @if(isset($spaces) &&  in_array($accessibilitie->id  , $access))
                                                            @php $selected = 'selected'; @endphp
                                                        @else
                                                            @php $selected = ''; @endphp
                                                        @endif
                                                        <option {{$selected}} value="{{$accessibilitie->id}}">{{$accessibilitie->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>



                                    </fieldset>
                                </div>
                                <!-- end widget content -->

                                <!-- widget content -->
                                <div class="widget-body">
                                    <fieldset class="demo-switcher-1">
                                        <legend>Free with this Space</legend>
                                        <div class="form-group">
                                            <div class="col-md-10">
                                                <select multiple="" name="free_amenity[]" class="form-control custom-scroll" id="free_amenity" required>
                                                    @if(isset($spaces))
                                                        @foreach($amenities as $key=>$amenitie)
                                                            @if($spaces->free_amenities != "null")
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
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </fieldset>
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


            </section>
            <!-- end widget grid -->

        </div>
        <!-- END MAIN CONTENT -->

    </div>
    <!-- END MAIN PANEL -->


@endsection



@section('scripts')
    @include('admin-panel.layouts.scripts')
    <!-- PAGE RELATED PLUGIN(S) -->
    <script src="{{url('js/admin-panel/plugin/ckeditor/ckeditor.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>

    <script type="text/javascript">

        $('#venue_id').change(function() {
            event.preventDefault();
            var venue_id = $(this).val();
            $.ajax({
                url: "{{ route('space.amenities') }}",
                method: "POST",
                data: { venue_id: venue_id, _token: '{{csrf_token()}}' },
                dataType:"json",
                success: function(data) {

                    var $el = $("#free_amenity");

                    $el.empty(); // remove old options
                    for (i = 0; i < data.length; i++) {
                        //  alert(data[i]['id']);
                        $el.append($("<option></option>")
                            .attr("value", data[i]['id'])
                            .text(data[i]['name']));
                    }

                }
            });
        });



        $('#venue_id').change(function() {
            event.preventDefault();
            var venue_id = $(this).val();
            $.ajax({
                url: "{{ route('space.addons') }}",
                method: "POST",
                data: { venue_id: venue_id, _token: '{{csrf_token()}}' },
                dataType:"json",
                success: function(data) {
                    console.log(data);
                    var $el = $("#amenities_id");

                    $el.empty(); // remove old options
                    for (i = 0; i < data.length; i++) {
                        //  alert(data[i]['id']);
                        $el.append($("<option></option>")
                            .attr("value", data[i]['id'])
                            .text(data[i]['name']));
                    }

                }
            });
        });

    </script>
    <script type="text/javascript">

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
            var sittingplan = {!! json_encode($sittingplans) !!};
            //  console.dir(sittingplan)
            var options = '<option disabled selected>- Select Plan -</option>';
            for(var i = 0; i < sittingplan.length; i++) {

                var sittingplan_id = sittingplan[i]['id'];
                var sittingplan_title = sittingplan[i]['title'];
                //if(usedlist.indexOf(sittingplan_id) < 0) {
                //  console.log('<option value="'+sittingplan[i]['id']+'">'+sittingplan[i]['title']+'</option>');
                options = options.concat('<option value="' + sittingplan[i]['id'] + '">' + sittingplan[i]['title'] + '</option>');
                //}
            }
            // console.log(options);
            return options;

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
                //if(usedlist.indexOf(sittingplan_id) < 0) {
                //  console.log('<option value="'+sittingplan[i]['id']+'">'+sittingplan[i]['title']+'</option>');
                options = options.concat('<option value="' + sittingplan[i]['id'] + '">' + sittingplan[i]['title'] + '</option>');
                //}
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
                var newIn = ' <div id="field'+ next +'" name="field'+ next +'"><!-- Text input--><div class="form-group"> <label class="col-md-10 control-label" for="action_id">Sitting Plan</label> <div class="col-md-10"> <select name="sitting-plans-'+ next +'" onchange="checkTheDropdowns()" class="form-control custom-scroll more-sitting-plan sitting-select-box" required>'+options+'</select> </div></div><br><br> <!-- Text input--><div class="form-group"> <label class="col-md-10 control-label" for="action_name">Capacity</label> <div class="col-md-10"> <input name="capacity-'+ next +'" type="number" placeholder="" class="form-control input-md more-sitting-plan" required><input name="count" type="hidden" value="'+next+'" /> </div></div><br><br></div></div>';
                var newInput = $(newIn);
                var removeBtn = '<div class="form-group" id="remove_section' + (next - 1) + '"><div class="col-md-10" style="text-align: right;"> <input type="button" value="remove" onclick="remove_entry(this.id)" id="remove' + (next - 1) + '" class="btn btn-danger remove-me"</div></div></div></div><div id="field">';
                var removeButton = $(removeBtn);
                $(addto).after(newInput);
                $(addRemove).after(removeButton);
                $("#field" + next).attr('data-source',$(addto).attr('data-source'));
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
        //cover image  plugin
        $("#image").fileinput({
            uploadUrl:  "{{ isset($spaces) ? url('storage/images/spaces/') : '' }}",
            dropZoneEnabled: false,
            showUpload: false, // The "Upload" button
            initialPreviewShowDelete: false,
            initialPreview: "{{ isset($spaces) ? url('storage/images/spaces/'.$spaces->image) : '' }}",
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
            msgErrorClass: 'alert alert-block alert-danger',
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });


        var spaces = '@php echo isset($spaces->gallery); @endphp';
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        if (spaces)
        {
            var space_id = $.parseJSON($('#space_id').val());
            var gallery = $.parseJSON($('#images_name').val());
            var data = [];
            for (var i = 0; i < gallery.length; i++)
            {
                var url = base_url + '/storage/images/spaces/'+space_id+'/'+gallery[i];
                data.push(url);
            }
        } else {
            var data = [];
        }

        var delete_data = [];
        if (spaces)
        {
            var delete_data = get_space_images_delete($('#space_id').val(), $('#images_name').val());

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
                        arr['url'] = base_url+ '/admin/space/images/delete';
                        arr['key'] = images_name[i];
                        arr['extra'] = extra;
                        delete_data.push(arr);
                    }
                }
                return delete_data;
            }
        }



        //image gallery plugin
        $("#image_gallery").fileinput({
            uploadUrl:  "{{ isset($spaces) ? url('storage/images/spaces/'.$spaces->id.'/') : '' }}",
            dropZoneEnabled: false,
            showUpload: false, // The "Upload" button
            showRemove: "{{ isset($spaces) ? 'false' : 'true' }}", // The "Remove" button
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

        // DO NOT REMOVE : GLOBAL FUNCTIONS!

        $(document).ready(function() {
            $('#amenities_id').select2({
                tags: true
            });
            $('#addons_id').select2({
                tags: true
            });


            $('#accessibility_id').select2();
            $('#free_amenity').select2();
            CKEDITOR.replace( 'ckeditor', { height: '180px', startupFocus : true,  allowedContent:true} );
        });


        var error_message = "Please enter the required field";
        $(document).ready(function () {
            $.validator.addClassRules('more-sitting-plan', {
                required: true,
            });
        });
        $("#add_space_form").validate(
            {
                ignore: [],
                debug: false,
                rules: {
                    ckeditor:
                        {
                            required: function () {
                                CKEDITOR.instances.ckeditor.updateElement();
                            },
                            minlength: 10
                        },
                    title: {
                        required: true
                    },
                    cancellation_policy: {
                        required: true
                    },
                    hours: {
                        required: true
                    },
                    cancel_cost: {
                        required: true
                    },
                    price: {
                        required: true
                    },
                    venue_id: {
                        required: true
                    },
                    "space-type": {
                        required: true
                    },
                    "sitting-plans-0": {
                        required: true
                    },
                    "capacity-0": {
                        required: true
                    },
                    "amenities_id[]": {
                        required: true
                    },
                    "accessibility_id[]": {
                        required: true
                    },
                    "free_amenity[]": {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages:
                    {

                        ckeditor: {
                            required: error_message,
                            minlength: "Please enter 10 characters"
                        },
                        title: {
                            required: error_message
                        },
                        cancellation_policy: {
                            required: error_message
                        },
                        hours: {
                            required: error_message
                        },
                        cancel_cost: {
                            required: error_message
                        },
                        price: {
                            required: error_message
                        },
                        venue_id: {
                            required: error_message
                        },
                        "space-type": {
                            required: error_message
                        },
                        "sitting-plans-0": {
                            required: error_message
                        },
                        "capacity-0": {
                            required: error_message
                        },
                        "amenities_id[]": {
                            required: error_message
                        },
                        "accessibility_id[]": {
                            required: error_message
                        },
                        "free_amenity[]": {
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
                        // alert()
                        error.insertAfter(element);
                    }
                }
            }
        );
        /*$('#add-new-space').click(function () {
            if ($(".more-sitting-plan").valid() === false ) {
                $('#add-more-error').show();
            }else{
                $('#add-more-error').hide();
            }
        });*/
    </script>

@endsection

