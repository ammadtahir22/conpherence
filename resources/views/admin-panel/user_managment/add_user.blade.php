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

@section('main-panel')
    <div id="main" role="main">
        <!-- RIBBON -->
        <div id="ribbon">
				{{--<span class="ribbon-button-alignment">--}}
					{{--<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">--}}
						{{--<i class="fa fa-refresh"></i>--}}
					{{--</span>--}}
				{{--</span>--}}

            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home</li><li>Add User</li>
            </ol>
            <!-- end breadcrumb -->

            <!-- You can also add more buttons to the
				ribbon for further usability

				Example below:

				<span class="ribbon-button-alignment pull-right">
				<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
				<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
				<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
				</span> -->

        </div>
        <!-- END RIBBON -->

        <!-- MAIN CONTENT -->
        <div id="content">

            {{--<div class="row">--}}
                {{--<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">--}}
                    {{--<h1 class="page-title txt-color-blueDark">--}}
                        {{--<i class="fa fa-table fa-fw "></i>--}}
                        {{--Table--}}
                        {{--<span>>--}}
								{{--All Users Data--}}
							{{--</span>--}}
                    {{--</h1>--}}
                {{--</div>--}}
                {{--<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">--}}
                    {{--<ul id="sparks" class="">--}}
                        {{--<li class="sparks-info">--}}
                            {{--<h5> My Income <span class="txt-color-blue">$47,171</span></h5>--}}
                            {{--<div class="sparkline txt-color-blue hidden-mobile hidden-md hidden-sm">--}}
                                {{--1300, 1877, 2500, 2577, 2000, 2100, 3000, 2700, 3631, 2471, 2700, 3631, 2471--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="sparks-info">--}}
                            {{--<h5> Site Traffic <span class="txt-color-purple"><i class="fa fa-arrow-circle-up" data-rel="bootstrap-tooltip" title="Increased"></i>&nbsp;45%</span></h5>--}}
                            {{--<div class="sparkline txt-color-purple hidden-mobile hidden-md hidden-sm">--}}
                                {{--110,150,300,130,400,240,220,310,220,300, 270, 210--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="sparks-info">--}}
                            {{--<h5> Site Orders <span class="txt-color-greenDark"><i class="fa fa-shopping-cart"></i>&nbsp;2447</span></h5>--}}
                            {{--<div class="sparkline txt-color-greenDark hidden-mobile hidden-md hidden-sm">--}}
                                {{--110,150,300,130,400,240,220,310,220,300, 270, 210--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}

            <!-- widget grid -->
            <section id="widget-grid" class="">

                <!-- row -->
                <div class="row">

                    <!-- NEW WIDGET START -->
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                            <!-- widget options:
								usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

								data-widget-colorbutton="false"
								data-widget-editbutton="false"
								data-widget-togglebutton="false"
								data-widget-deletebutton="false"
								data-widget-fullscreenbutton="false"
								data-widget-custombutton="false"
								data-widget-collapsed="true"
								data-widget-sortable="false"

								-->
                            <header>
                                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                <h2>Add New User </h2>

                            </header>

                            <!-- widget div-->
                            <div>

                                <!-- widget edit box -->
                                <div class="jarviswidget-editbox">
                                    <!-- This area used as dropdown edit box -->

                                </div>
                                <!-- end widget edit box -->

                                <!-- widget content -->
                                <div class="widget-body no-padding">
                                    <div class="widget-body">
                                        <div class="form-horizontal">
                                            <fieldset>
                                                <legend></legend>

                                                <form method="POST" action="{{ route('admin.save.users') }}" class="fill-form input" id="signup-form">
                                                    @csrf
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Name</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="name" class="form-control" placeholder="Name" value="" required>
                                                    </div>
                                                </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Email</label>
                                                        <div class="col-md-5">
                                                            <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Email" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Account Type</label>
                                                        <div class="col-md-5">
                                                            <select name="type" id="type" class="form-control" required onchange="checkadminType(this.value)">
                                                                <option disabled selected>- Select Account type -</option>
                                                                <option value="individual">Individual/Company </option>
                                                                <option value="company">Hotel Owner</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="cName" style="display: none">
                                                        <label class="col-md-2 control-label">Company Name</label>
                                                        <div class="col-md-5">
                                                            <input type="text" id="company_name" class="form-control" name="company_name" placeholder="Hotel name"
                                                                   value="" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Phone Number</label>
                                                        <div class="col-md-5">
                                                            <input type="tel" name="phone_number" class="form-control telephone" placeholder="Phone number" value=" " required>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Password</label>
                                                        <div class="col-md-5">
                                                            <input type="password" autocomplete="off" name="password" class="form-control"  placeholder="Password" minlength="6" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"></label>
                                                        <div class="col-md-5">
                                                        <button class="btn btn-primary" type="submit">Sign Up</button>
                                                        </div>
                                                    </div>
                                                </form>






                                            </fieldset>
                                        </div>
                                        <!-- this is what the user will see -->

                                    </div>


                                </div>
                                <!-- end widget content -->

                            </div>
                            <!-- end widget div -->

                        </div>
                        <!-- end widget -->


                    </article>
                    <!-- WIDGET END -->

                </div>

                <!-- end row -->

                <!-- end row -->

            </section>
            <!-- end widget grid -->

        </div>
        <!-- END MAIN CONTENT -->

    </div>

@endsection

@section('footer')
    @include('admin-panel.layouts.footer')
@endsection

@section('shortcut')
    @include('admin-panel.layouts.shortcut')
@endsection

@section('scripts')
    @include('admin-panel.layouts.scripts')
    <script>
        function checkadminType(value) {
            if(value === 'company')
            {
                $('#cName').show();
                $('#cName').prop('required',true);
            } else {
                $('#cName').hide();
                $('#cName').prop('required',false);
            }
        }
    </script>


@endsection

