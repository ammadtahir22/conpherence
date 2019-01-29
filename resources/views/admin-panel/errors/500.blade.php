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
            <ol class="breadcrumb">
                <li>Home</li><li>Error 500</li>
            </ol>
        </div>
        <!-- END RIBBON -->



        <!-- MAIN CONTENT -->
        <div id="content">

            <!-- row -->
            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="text-center error-box">
                                <h1 class="error-text tada animated"><i class="fa fa-times-circle text-danger error-icon-shadow"></i> Error 500</h1>
                                <h2 class="font-xl"><strong>Oooops, Something went wrong!</strong></h2>
                                <br />
                                <p class="lead semi-bold">
                                    <strong>You have experienced a technical error. We apologize.</strong><br><br>
                                    <small>
                                        We are working hard to correct this issue. Please wait a we will fix this issue ASAP
                                    </small>
                                </p>
                                {{--<ul class="error-search text-left font-md">--}}
                                    {{--<li><a href="javascript:void(0);"><small>Go to My Dashboard <i class="fa fa-arrow-right"></i></small></a></li>--}}
                                    {{--<li><a href="javascript:void(0);"><small>Contact SmartAdmin IT Staff <i class="fa fa-mail-forward"></i></small></a></li>--}}
                                    {{--<li><a href="javascript:void(0);"><small>Report error!</small></a></li>--}}
                                    {{--<li><a href="javascript:void(0);"><small>Go back</small></a></li>--}}
                                {{--</ul>--}}
                            </div>

                        </div>

                    </div>

                </div>

            </div>
            <!-- end row -->

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
@endsection

