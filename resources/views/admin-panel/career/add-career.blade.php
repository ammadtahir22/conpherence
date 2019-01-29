@extends('admin-panel.layouts.app')

@section('css-link')

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
                @if(isset($career->id) && $career->id != '')
                    <li>Home / Edit Career</li>
                @else
                    <li>Home / Add Career</li>
                @endif
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
                    <form action="{{url('/admin/career/save')}}" method="post" id="add_career_form" enctype="multipart/form-data">
                        @csrf
                        <input name="id" value="{{isset($career) ? $career->id : ''}}" type="hidden">
                    <!-- NEW WIDGET START -->
                    <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget" id="wid-id-0">
                            <!-- widget content -->
                            <div class="widget-body">
                                <div class="form-horizontal">
                                    <fieldset>
                                        @if(isset($career->id) && $career->id != '')
                                            <legend>Edit Career</legend>
                                        @else
                                            <legend>Add New Career</legend>
                                        @endif
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Title</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="title" value="{{isset($career)? $career->title : ''}}" placeholder="Title" type="text" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Slug</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="slug" value="{{isset($career) ? $career->slug : ''}}" placeholder="Slug" type="text" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Location</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="location" value="{{isset($career) ? $career->location : ''}}" placeholder="Location" type="text" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Description</label>
                                            <div class="col-md-10">
                                                <!-- widget content -->
                                                <div class="widget-body">
                                                    <textarea name="ckeditor">
                                                        {{isset($career) ? $career->description : ''}}
                                                    </textarea>
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
                                        <legend>Category</legend>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="select-1">Category</label>
                                            <div class="col-md-10">

                                                <select class="form-control" name="category" id="select-1" required>
                                                    @foreach($categories as $key=>$category)
                                                        @if(isset($career) && $category->id == $career->category_id)
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

                                                <a href="{{url(route('create.career.category'))}}">
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
                                                        <input type="radio" name="status"  {{isset($career) && $career->status == 1 ? 'checked' : ''}} value="1" class="radiobox style-2" data-bv-field="status">
                                                        <span>Publish</span>
                                                    </label>

                                                    <label class="radio radio-inline">
                                                        <input type="radio" name="status" {{isset($career) && $career->status == 0 ? 'checked' : ''}} value="0" class="radiobox style-2" data-bv-field="status">
                                                        <span>Draft</span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-12 col-md-10 ">
                                                    <div class="career_status_area"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ route('all.careers') }}" class="btn btn-default"> Cancel </a>
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
    <script type="text/javascript">

        // DO NOT REMOVE : GLOBAL FUNCTIONS!

        $(document).ready(function() {

            CKEDITOR.replace( 'ckeditor', { height: '180px', startupFocus : true} );
            var error_message = "Please enter the required field";
            $("#add_career_form").validate(
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
                        slug: {
                            required: true
                        },
                        location: {
                            required: true
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
                        ckeditor: {
                            required: "Please enter the required field",
                            minlength: "Please enter 10 characters"
                        },
                        title: {
                            required: error_message
                        },
                        slug: {
                            required: error_message
                        },
                        location: {
                            required: error_message
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
                            error.insertAfter(".career_status_area");
                        } else {
                            error.insertAfter(element);
                        }
                    }
                }
            );
        });

    </script>

@endsection

