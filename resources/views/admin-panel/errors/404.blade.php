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
                <li>Home</li><li>Error 404</li>
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
                                <h1 class="error-text-2 bounceInDown animated"> Error 404 <span class="particle particle--c"></span><span class="particle particle--a"></span><span class="particle particle--b"></span></h1>
                                <h2 class="font-xl"><strong><i class="fa fa-fw fa-warning fa-lg text-warning"></i> Page <u>Not</u> Found</strong></h2>
                                <br />
                                <p class="lead">
                                    The page you requested could not be found, either contact your admin or try again. Use your browsers <b>Back</b> button to navigate to the page you have previously come from
                                </p>
                                {{--<div class="row">--}}

                                    {{--<div class="col-sm-12">--}}
                                        {{--<ul class="list-inline">--}}
                                            {{--<li>--}}
                                                {{--&nbsp;<a href="javascript:void(0);">Dashbaord</a>&nbsp;--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--.--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--&nbsp;<a href="javascript:void(0);">Inbox (14)</a>&nbsp;--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--.--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--&nbsp;<a href="javascript:void(0);">Calendar</a>&nbsp;--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--.--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--&nbsp;<a href="javascript:void(0);">Gallery</a>&nbsp;--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--.--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--&nbsp;<a href="javascript:void(0);">My Profile</a>&nbsp;--}}
                                            {{--</li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}

                                {{--</div>--}}

                            </div>

                        </div>

                    </div>

                </div>

                <!-- end row -->

            </div>

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

