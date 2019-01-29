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
            @if(isset($news->id) && $news->id != '')
                <ol class="breadcrumb">
                    <li>Home / Edit News</li>
                </ol>
            @else
                <ol class="breadcrumb">
                    <li>Home / Add News</li>
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
                    <form action="{{url('/admin/news/save')}}" method="post" id="add_news_form" enctype="multipart/form-data">
                        @csrf
                        <input name="id" value="{{isset($news) ? $news->id : ''}}" type="hidden">
                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            @if(isset($news->id) && $news->id != '')
                                                <legend>Edit News</legend>
                                            @else
                                                <legend>Add New News</legend>
                                            @endif
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Title</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" name="title" value="{{isset($news)? $news->title : ''}}" placeholder="Title" type="text" required>
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
                                                    {{isset($news) ? $news->description : ''}}
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
                                                        @if(isset($news) && $category->id == $news->category_id)
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

                                                <a href="{{url(route('create.news.category'))}}">
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
                                                        <input type="radio" name="status"  {{isset($news) && $news->status == 1 ? 'checked' : ''}} value="1" class="radiobox style-2" data-bv-field="status">
                                                        <span>Publish</span>
                                                    </label>

                                                    <label class="radio radio-inline">
                                                        <input type="radio" name="status" {{isset($news) && $news->status == 0 ? 'checked' : ''}} value="0" class="radiobox style-2" data-bv-field="status">
                                                        <span>Draft</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-12 col-md-10 ">
                                                    <div class="page_status_radio"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>


                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('all.news') }}" class="btn btn-default"> Cancel </a>
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i>
                                                    {{isset($news) ? 'Update' : 'Submit'}}
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
            uploadUrl:  "{{ isset($news) ? url('storage/images/news/'.$news->id.'/') : '' }}",
            dropZoneEnabled: false,
            showUpload: false, // The "Upload" button
            initialPreviewShowDelete: false,
            initialPreview: "{{ isset($news) ? url('storage/images/news/'.$news->id.'/'.$news->image) : '' }}",
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


            CKEDITOR.replace( 'ckeditor', { height: '180px', startupFocus : true, allowedContent:true} );

            // $('#add_news_form').bootstrapValidator({
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

        var req_error_msg = "Please enter required field";
        $("#add_news_form").validate(
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
                    title: {
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages:
                    {

                        description: {
                            required: "Please enter Description first",
                            minlength: "Please enter 10 characters"
                        },
                        title:{
                            required: req_error_msg
                        },
                        category_id: {
                            required: req_error_msg
                        },
                        status: {
                            required: req_error_msg
                        }
                    },
                errorPlacement: function (error, element) {
                    if (element.prop("type") === "radio") {
                        error.insertAfter(".page_status_radio");
                    }else {
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

