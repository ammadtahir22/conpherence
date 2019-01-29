@extends('admin-panel.layouts.app')

@section('css-link')
    <style>
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
                <li>Home</li><li>All Reviews</li>
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
                                <h2>User Reviews </h2>

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

                                    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="hasinput" style="width:10%">
                                                <input type="text" class="form-control" placeholder="Filter Sr. No" />
                                            </th>
                                            <th class="hasinput" style="width:16%">
                                                <input type="text" class="form-control" placeholder="Filter Space Name" />
                                            </th>
                                            <th class="hasinput" style="width:1%">
                                                <input type="text" class="form-control" placeholder="Filter Feedback" />
                                            </th>
                                            <th class="hasinput" style="width:16%">
                                                <input type="text" class="form-control" placeholder="Filter Customer Service Rate" />
                                            </th>
                                            <th class="hasinput" style="width:16%">
                                                <input type="text" class="form-control" placeholder="Filter Amenities Rate" />
                                            </th>
                                            <th class="hasinput" style="width:16%">
                                                <input type="text" class="form-control" placeholder="Filter Meeting Facility Rate" />
                                            </th>
                                            <th class="hasinput" style="width:16%">
                                                <input type="text" class="form-control" placeholder="Filter Food Rate" />
                                            </th>
                                            <th class="hasinput icon-addon">
                                                <input id="dateselect_filter" type="text" placeholder="Filter Date" class="form-control datepicker" data-dateformat="yy-mm-dd">
                                                <label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter Date"></label>
                                            </th>
                                            <th class="hasinput" style="width:10%">
                                                <input type="text" class="form-control" placeholder="Filter Status" />
                                            </th>
                                            <th class="hasinput" style="width:5%">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th >Sr.No</th>
                                            <th>Space Name</th>
                                            <th>Feedback</th>
                                            <th>Customer Service Rate</th>
                                            <th>Amenities Rate</th>
                                            <th>Meeting Facility Rate</th>
                                            <th>Food Rate</th>
                                            {{--<th>Total Rate</th>--}}
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th class="remove-sort">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($reviews))
                                            @foreach($reviews as $key => $review)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{get_space_title($review->space_id)}}</td>
                                                    <td>{{ substr($review->feedback, 0, 10) }}</td>
                                                    <td>{{ $review->customer_service_rate }}  Stars</td>
                                                    <td>{{ $review->amenities_rate }}  Stars</td>
                                                    <td>{{ $review->meeting_facility_rate }}  Stars</td>
                                                    <td>{{ $review->food_rate }}  Stars</td>
                                                    {{--<td>{{ $review->total_stars }}</td>--}}
                                                    <td>{{date('Y-m-d', strtotime($review->created_at))}}</td>
                                                    @php $activated = $review->r_status == 1  ? 'Active' : 'Deactive'; @endphp
                                                    <td>{{$activated}}</td>
                                                    <td>
                                                        <form action="{{url('/admin/change_review_status')}}" method="POST" class="smart-form" id="user_status_form{{$key}}">
                                                            @csrf
                                                            <input type="hidden" name="review_id" value="{{$review->id}}">
                                                            <input type="hidden" name="booking_id" value="{{$review->booking_id}}">
                                                            <label class="toggle">
                                                                <input type="checkbox" name="active" @php if ($review->r_status == 1) echo 'checked="checked"'; @endphp onchange="changeUserStatus({{$key}})">
                                                                <i data-swchon-text="On" data-swchoff-text="Off"></i>
                                                            </label>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

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
        $( document ).ready(function() {

            var pageURL = window.location.href;
            var lastURLSegment = pageURL.substr(pageURL.lastIndexOf('/') + 1);
            if(lastURLSegment == 'change_review_status'){
                location.href = location.href.replace(
                    lastURLSegment , 'reviews')
            }
        });
        function changeUserStatus(id) {
            var form_id = '#user_status_form'+id;

            $(form_id).submit();
        }
        $(document).ready(function() {
            /* COLUMN FILTER  */
            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet : 1024,
                phone : 480
            };
            var otable = $('#dt_basic').DataTable({
                "columnDefs": [ {
                    "targets": 'remove-sort',
                    "orderable": false,
                } ],
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
                    "t"+
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "autoWidth" : true,
                "oLanguage": {
                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                },
                "preDrawCallback" : function() {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_datatable_fixed_column) {
                        responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                    }
                },
                "rowCallback" : function(nRow) {
                    responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
                },
                "drawCallback" : function(oSettings) {
                    responsiveHelper_datatable_fixed_column.respond();
                }

            });
            // custom toolbar
            // $("div.toolbar").html('<div class="text-right"><img src="img/logo.png" alt="SmartAdmin" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');

            // Apply the filter
            $("#dt_basic thead th input[type=text]").on( 'keyup change', function () {

                otable
                    .column( $(this).parent().index()+':visible' )
                    .search( this.value )
                    .draw();

            } );
        } );
    </script>

@endsection

