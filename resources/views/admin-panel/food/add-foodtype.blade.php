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
                @if(isset($food_types->id) && $food_types->id != '')
                    <li>Home / Edit Food Type</li>
                @else
                    <li>Home / Add Food Type</li>
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
                    <form action="{{url('/admin/food/type/save')}}" method="post" id="add_food_type_form">
                        @csrf
                        <input name="id" value="{{isset($food_types) ? $food_types->id : ''}}" type="hidden">
                        <input name="user_id" value="{{Auth::guard('admin')->id()}}" type="hidden">
                        <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>

                                            @if(isset($food_types->id) && $food_types->id != '')
                                                <legend>Edit Food Type</legend>
                                            @else
                                                <legend>Add New Food Type</legend>
                                            @endif
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Name</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" name="title" value="{{isset($food_types) ? $food_types->title : ''}}" placeholder="Name" type="text" required>
                                                </div>
                                            </div>


                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <a href="{{ route('all.foodtype') }}" class="btn btn-default"> Cancel </a>
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

        var error_message = "Please enter the required field";
        $("#add_food_type_form").validate(
            {
                ignore: [],
                debug: false,
                rules:
                    {
                        title:
                            {
                                required: true
                            }
                    },
                messages:
                    {
                        title:
                            {
                                required: error_message
                            }
                    }
            }
        );

    </script>

@endsection

