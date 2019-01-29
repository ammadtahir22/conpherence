@extends('admin-panel.layouts.app')

@section('css-link')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
@endsection

{{--@section('header')--}}
{{----}}
{{--@endsection--}}

@section('left-panel')
@include('admin-panel.layouts.left-panel')
@endsection

@section('main-panel')
{{--@include('admin-panel.layouts.main-panel')--}}
        <!-- MAIN PANEL -->
<div id="main" role="main">

    <!-- RIBBON -->
    <div id="ribbon">
        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li>Home / @php if(isset($spacetype)){ echo "Edit Space Type"; }else{ echo 'Add Space Type'; } @endphp</li>
        </ol>

    </div>
    <!-- END RIBBON -->


    <!-- MAIN CONTENT -->
    <div id="content">
        <!--
            The ID "widget-grid" will start to initialize all widgets below
            You do not need to use widgets if you dont want to. Simply remove
            the <section></section> and you can use wells or panels instead
            -->

        <!-- widget grid -->
        <section id="widget-grid" class="">
            <!-- row -->
            <div class="row">
                <form action="{{url('/admin/space/spacetype/save')}}" method="post" id="add_space_type_form" enctype="multipart/form-data">
                    @csrf
                    <input name="id" value="{{isset($spacetype) ? $spacetype->id : ''}}" type="hidden">
                    <input name="user_id" value="{{Auth::guard('admin')->id()}}" type="hidden">

                    <!-- NEW WIDGET START -->
                    <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget" id="wid-id-0">
                            <!-- widget content -->
                            <div class="widget-body">
                                <div class="form-horizontal">
                                    <fieldset>
                                        <legend>@php if(isset($spacetype)){ echo "Edit Space Type"; }else{ echo 'Add New Space Type'; } @endphp</legend>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Name</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="title" value="{{isset($spacetype) ? $spacetype->title : ''}}" placeholder="Name" type="text" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Slug</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="slug" value="{{isset($spacetype) ? $spacetype->slug : ''}}" placeholder="Slug" type="text" required>
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
                                                <textarea class="form-control" name="description" placeholder="Description" rows="4" required>{{isset($spacetype) ? $spacetype->description : ''}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{route('index.space.spacetype')}}" class="btn btn-default"> Cancel </a>
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fa fa-save"></i>
                                                        Submit
                                                    </button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>

<script type="text/javascript">
    //cover image  plugin
    $("#image").fileinput({
        uploadUrl:  "{{ isset($spacetype) ? url('storage/images/space-type/') : '' }}",
        dropZoneEnabled: false,
        showUpload: false, // The "Upload" button
        initialPreviewShowDelete: false,
        initialPreview: "{{ isset($spacetype) ? url('storage/images/space-type/'.$spacetype->image) : '' }}",
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
</script>
<script type="text/javascript">

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function() {

        // $("#add_category_form").bootstrapValidator({
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
        var error_message = "Please enter the required field";
        $("#add_space_type_form").validate(
            {
                ignore: [],
                debug: false,
                rules: {
                    title: {
                        required: true
                    },
                    slug: {
                        required: true
                    },
                    description: {
                        required: true
                    }
                },
                messages:
                    {
                        title: {
                            required: error_message
                        },
                        slug: {
                            required: error_message
                        },
                        description: {
                            required: error_message
                        }
                    },
                // errorPlacement: function (error, element) {
                //     if (element.prop("type") === "radio") {
                //         error.insertAfter(".venue_status_area");
                //     } else {
                //         error.insertAfter(element);
                //     }
                // }
            }
        );

    });

</script>

@endsection

