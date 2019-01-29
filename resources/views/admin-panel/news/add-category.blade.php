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
            @if(isset($category->id) && $category->id != '')
                <li>Home / Edit News Category</li>
            @else
                <li>Home / Add News Category</li>
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
                    <form action="{{url('/admin/news/category/save')}}" method="post" id="add_category_form" enctype="multipart/form-data">
                        @csrf
                        <input name="id" value="{{isset($category) ? $category->id : ''}}" type="hidden">

                        <!-- NEW WIDGET START -->
                    <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget" id="wid-id-0">
                            <!-- widget content -->
                            <div class="widget-body">
                                <div class="form-horizontal">
                                    <fieldset>
                                        @if(isset($category->id) && $category->id != '')
                                            <legend>Edit New Category</legend>
                                        @else
                                            <legend>Add New Category</legend>
                                        @endif
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Title</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="title" value="{{isset($category) ? $category->title : ''}}" placeholder="Title" type="text" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Slug</label>
                                            <div class="col-md-10">
                                                <input class="form-control" name="slug" value="{{isset($category) ? $category->slug : ''}}" placeholder="Slug" type="text" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Description</label>
                                            <div class="col-md-10">
                                                <textarea class="form-control" name="description" placeholder="Description" rows="4">{{isset($category) ? $category->description : ''}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{ route('all.news.categories') }}" class="btn btn-default"> Cancel </a>
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



    <script type="text/javascript">

        // DO NOT REMOVE : GLOBAL FUNCTIONS!

        $(document).ready(function() {

             CKEDITOR.replace( 'ckeditor', { height: '180px', startupFocus : true,  allowedContent:true} );

        });


        var error_message = "Please enter the required field";
        $("#add_category_form").validate(
            {
                ignore: [],
                rules: {
                    title:{
                        required: true
                    },
                    slug:{
                        required: true
                    },
                    description:{
                        required: true
                    }
                },
                messages:
                    {
                        description: {
                            required: error_message
                        },
                        title: {
                            required: error_message
                        },
                        slug: {
                            required: error_message
                        }
                    }
            }
        );


    </script>

@endsection

