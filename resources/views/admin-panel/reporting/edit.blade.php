@extends('admin-panel.layouts.app')

@section('css-link')
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
                <li>Home / Add Page</li>
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
                    <form action="{{url('/admin/page/'.$pages->id.'/update')}}" method="post" id="add_post_form">
                        @csrf
                                <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            <legend>Add New Page</legend>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Title</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" name="title" placeholder="Title" type="text" value="{{ $pages->title }}" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Slug</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" name="slug" placeholder="Slug" type="text" value="{{ $pages->slug }}" required>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Textarea</label>
                                                <div class="col-md-10">
                                                    <!-- widget content -->
                                                    <div class="widget-body">
                                                            <textarea name="ckeditor">
                                                                {!! $pages->content !!}
                                                            </textarea>
                                                    </div>
                                                </div>


                                            </div>
                                        </fieldset>
                                    </div>
                                    <!-- this is what the user will see -->

                                </div>
                                <!-- end widget content -->

                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            <legend>SEO</legend>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Meta Keyword</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" name="keyword" placeholder="Meta Keyword" type="text" value="{{ $pages->keyword }}" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Meta Description</label>
                                                <div class="col-md-10">
                                                    <textarea class="form-control" name="seo" rows="3" placeholder="Meta Description" required>{{ $pages->seo }}</textarea>
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
                                                        <input type="radio" class="radiobox style-0" name="status" {{ $pages->status == 1 ? 'checked':'' }} value="1">
                                                        <span>Publish</span>
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" class="radiobox style-0"  name="status" {{ $pages->status == 1 ? 'checked':'' }} value="0">
                                                        <span>Draft</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i>
                                                    Publish
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



    <script type="text/javascript">

        // DO NOT REMOVE : GLOBAL FUNCTIONS!

        $(document).ready(function() {

            CKEDITOR.replace( 'ckeditor', { height: '180px', startupFocus : true, allowedContent:true} );

        })

        $("#add_post_form").validate(
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
                        }
                    },
                    messages:
                    {

                        ckeditor: {
                            required: "Please enter Description first",
                            minlength: "Please enter 10 characters"
                        }
                    }
                }
        );

    </script>

@endsection

