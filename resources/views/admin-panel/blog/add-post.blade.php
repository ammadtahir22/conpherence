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
    <!-- MAIN PANEL -->
    <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">
            <!-- breadcrumb -->
            @if(isset($post->id) && $post->id != '')
                <ol class="breadcrumb">
                    <li>Home / Edit Post</li>
                </ol>
            @else
                <ol class="breadcrumb">
                    <li>Home / Add Post</li>
                </ol>
            @endif

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
                    <form action="{{url('/admin/post/save')}}" method="post" id="add_post_form" enctype="multipart/form-data">
                        @csrf
                        <input name="id" value="{{isset($post) ? $post->id : ''}}" type="hidden">
                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            @if(isset($post->id) && $post->id != '')
                                                <legend>Edit Post</legend>
                                            @else
                                                <legend>Add New Post</legend>
                                            @endif
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Title</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" name="title" value="{{isset($post)? $post->title : ''}}" placeholder="Title" type="text" required>
                                                </div>
                                            </div>

                                            {{--<div class="form-group">--}}
                                            {{--<label class="col-md-2 control-label">Image</label>--}}
                                            {{--<div class="col-md-10">--}}
                                            {{--<input class="form-control" id="image_input" name="image" placeholder="File" type="file" required>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Image</label>
                                                <div class="col-md-10">
                                                    <input id="image_cover" type="file" name="image" class="file form-control">
                                                </div>
                                            </div>

                                            {{--<div class="form-group">--}}
                                            {{--<label class="col-md-2 control-label">Image Preview</label>--}}
                                            {{--<div class="col-md-10">--}}
                                            {{--<img id="image_priview" src="{{isset($post) ? url('storage/images/blogs/'.$post->id.'/'.$post->image) : ''}}" alt="No Image selected" style="max-width: 50%;"/>--}}
                                            {{--</div>--}}
                                            {{--</div>--}}

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Description</label>
                                                <div class="col-md-10">
                                               <textarea name="description" id="ckeditor">
                                                   {{isset($post) ? $post->description : ''}}
                                               </textarea>
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
                                        <legend>Category</legend>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="select-1">Category</label>
                                            <div class="col-md-10">

                                                <select class="form-control" name="category_id" id="select-1" required>
                                                    @foreach($categories as $key=>$category)
                                                        @if(isset($post) && $category->id == $post->category_id)
                                                            @php $selected = 'selected'; @endphp
                                                        @else
                                                            @php $selected = ''; @endphp
                                                        @endif
                                                        <option {{$selected}} value="{{$category->id}}">{{$category->title}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="select-1"></label>
                                            <div class="col-md-10">

                                                <a href="{{url(route('create.category'))}}">
                                                    <i class="fa fa-plus"> </i>  Add New Category
                                                </a>

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
                                            <div class="row">
                                                <div class="col-sm-12 col-md-10">
                                                    <label class="radio radio-inline no-margin">
                                                        <input type="radio" name="status"  {{isset($post) && $post->status == 1 ? 'checked' : ''}} value="1" class="radiobox style-2" data-bv-field="status">
                                                        <span>Publish</span>
                                                    </label>

                                                    <label class="radio radio-inline">
                                                        <input type="radio" name="status" {{isset($post) && $post->status == 0 ? 'checked' : ''}} value="0" class="radiobox style-2" data-bv-field="status">
                                                        <span>Draft</span>
                                                    </label>
                                                    <div class="col-sm-12 col-md-10 ">
                                                        <div class="post_status_area"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('all.posts') }}" class="btn btn-default"> Cancel </a>
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i>
                                                    {{isset($post) ? 'Update' : 'Submit'}}
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
        $("#image_cover").fileinput({
            uploadUrl:  "{{ isset($post) ? url('storage/images/blogs/'.$post->id.'/') : '' }}",
            showUpload: false, // The "Upload" button
            dropZoneEnabled: false,
            initialPreviewShowDelete: false,
            initialPreview: "{{ isset($post) ? url('storage/images/blogs/'.$post->id.'/'.$post->image) : '' }}",
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

        $(document).ready(function() {

            {{--remove_required();--}}
            {{--function remove_required()--}}
            {{--{--}}
            {{--var post = '@php echo isset($post) @endphp';--}}

            {{--if(post)--}}
            {{--{--}}
            {{--$("#image_input").prop('required',false);--}}
            {{--$("#image_input").prop('name','image_update');--}}
            {{--} else {--}}
            {{--$("#image_input").prop('required',true);--}}
            {{--$("#image_input").prop('name','image');--}}
            {{--}--}}
            {{--}--}}

            CKEDITOR.replace( 'ckeditor', { height: '180px', startupFocus : true, allowedContent:true} );

            // $('#add_post_form').bootstrapValidator({
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
        $("#add_post_form").validate(
            {
                ignore: [],
                debug: false,
                rules: {
                    title:
                        {
                            required: true
                        },
                    description:
                    {
                        required: function () {
                                CKEDITOR.instances.ckeditor.updateElement();
                        },
                       minlength: 10
                    },
                    category: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages:
                    {
                        title:
                            {
                                required: error_message
                            },
                        description: {
                            required: "Please enter the required field",
                            minlength: "Please enter at least 10 characters"
                        },
                        category: {
                            required: error_message
                        },
                        status: {
                            required: error_message
                        }
                    },
                errorPlacement: function (error, element) {
                    if (element.prop("type") === "radio") {
                        error.insertAfter(".post_status_area");
                    } else {
                        error.insertAfter(element);
                    }
                }
            }
        );

        // function readURL(input) {
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();
        //
        //         reader.onload = function (e) {
        //             $('#image_priview').attr('src', e.target.result);
        //         }
        //
        //         reader.readAsDataURL(input.files[0]);
        //     }
        // }
        //
        // $("#image_input").change(function(){
        //     readURL(this);
        // });

    </script>

@endsection

