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
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home</li><li>All Bookings</li>
            </ol>
        </div>
        <!-- END RIBBON -->

        <!-- MAIN CONTENT -->
        <div id="content">
            <!-- widget grid -->
            <section id="widget-grid" class="">
                <!-- row -->
                <div class="row">
                    @if (session('msg-success'))
                        <p class="alert alert-success" role="alert">
                            {{ session('msg-success') }}
                        </p>
                    @endif

                    @if (session('msg-error'))
                        <p class="alert alert-success" role="alert">
                            {{ session('msg-error') }}
                        </p>
                @endif

                <!-- NEW WIDGET START -->
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                            <header>
                                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                <h2>Bookings </h2>
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
                                            <th class="hasinput" style="width:1%">
                                                <input type="text" class="form-control" placeholder="Filter Sr. No" />
                                            </th>
                                            <th class="hasinput" style="width:0%">
                                                <input type="text" class="form-control" placeholder="Filter User Name" />
                                            </th>
                                            <th class="hasinput" style="width:16%">
                                                <input type="text" class="form-control" placeholder="Filter Venue Title" />
                                            </th>
                                            <th class="hasinput" style="width:10%">
                                                <input type="text" class="form-control" placeholder="Filter Space Title" />
                                            </th>
                                            <th class="hasinput" style="width:10%">
                                                <input type="text" class="form-control" placeholder="Filter Total" />
                                            </th>
                                            <th class="hasinput ">
                                                <input id="dateselect_filter" type="text" placeholder="Filter Start Date" class="form-control datepicker" data-dateformat="yy-mm-dd" />
                                                <label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter Start Date"></label>
                                            </th>
                                            <th class="hasinput ">
                                                <input id="dateselect_filter2" type="text" placeholder="Filter End Date" class="form-control datepicker" data-dateformat="yy-mm-dd" />
                                                <label for="dateselect_filter2" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter End Date"></label>
                                            </th>
                                            <th class="hasinput ">
                                                <input id="dateselect_filter3" type="text" placeholder="Filter Created At" class="form-control datepicker" data-dateformat="yy-mm-dd" />
                                                <label for="dateselect_filter3" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter Created At"></label>
                                            </th>
                                            <th class="hasinput" style="width:10%">
                                                <input type="text" class="form-control" placeholder="Filter Status" />
                                            </th>
                                            <th class="hasinput" style="width:10%">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>User Name</th>
                                            <th>Venue Title</th>
                                            <th>Space Title</th>
                                            <th>Total</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th class="remove-sort">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($booking_infos))
                                            @foreach($booking_infos as $key => $booking_info)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>@if($booking_info->user_id == 0)
                                                            {{$booking_info->booking_firstname.' '.$booking_info->booking_lastname}}
                                                            @else
                                                            {{$booking_info->user->name}}
                                                        @endif
                                                    </td>
                                                    <td>{{$booking_info->space->venue->title}} - {{$booking_info->space->venue->city}}</td>
                                                    <td>{{$booking_info->space->title}}</td>
                                                    <td>AED {!! $booking_info->grand_total !!}</td>
                                                    <td>{{date('d M Y', strtotime($booking_info->start_date))}}</td>
                                                    <td>{{date('d M Y', strtotime($booking_info->end_date))}}</td>
                                                    <td>{{date('d M Y', strtotime($booking_info->created_at))}}</td>

                                                    <td>@if($booking_info->status == 0) Pending @elseif($booking_info->status == 1) Approved @else Cancelled @endif</td>
                                                    <td>
                                                        @php if($booking_info->user_id == 0){
                                                        $url = url('/admin/booking/detail/manual-detail/'.$booking_info->id);
                                                    }else{
                                                        $url = url('/admin/booking/detail/'. $booking_info->id);
                                                    }
                                                        @endphp
                                                        <a href="{{$url}}" class="">
                                                            <i class="fa fa-pencil-square-o fa-lg"></i>
                                                        </a>

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

