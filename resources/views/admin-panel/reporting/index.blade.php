@extends('admin-panel.layouts.app')

@section('css-link')
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<style>
.dt-buttons{
    position: relative;
    float: left;
    width: 50%;
    text-align: left;
    padding:10px 5px 5px 15px;
}
.dataTables_filter{
    display: none;
    text-align: left;
}
div.dataTables_filter label{
    float: left;
    width:100%;
}
div.dataTables_info{
    padding-left: 10px;
    float: left;
    padding-top: 13px;
}
div.dataTables_paginate {
    padding-top: 5px;
    padding-right: 10px;
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
                <li>Home</li><li>Booking Report</li>
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
                        <p class="alert alert-danger" role="alert">
                            {{ session('msg-error') }}
                        </p>
                @endif

                <!-- NEW WIDGET START -->
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <!-- Widget ID (each widget will need unique ID)-->
                        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                            <header>
                                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                <h2>Booking Report </h2>

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
                                            <th>Sr#</th>
                                            <th>Customer Name</th>
                                            <th>Customer Email</th>
                                            <th>Name of Meeting</th>
                                            <th>Venue Name</th>
                                            <th>Space Name</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $total_amount = 0 @endphp
                                        @foreach($booking_infos as $key => $bookingreport)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$bookingreport->booking_firstname." ".$bookingreport->booking_lastname}}</td>
                                                <td>{{$bookingreport->user->email}}</td>
                                                <td>{{$bookingreport->purpose}}</td>
                                                <td>{{get_venue_title($bookingreport->venue_id)}} ({{get_city_by_venue($bookingreport->venue_id)}})</td>
                                                <td>{{get_space_title($bookingreport->space_id)}}</td>
                                                <td>{{date('d M Y', strtotime($bookingreport->start_date))}} to {{date('d M Y', strtotime($bookingreport->end_date))}}</td>
                                                <td>@if($bookingreport->status == 0) Pending @elseif($bookingreport->status == 1) Approved @else Cancelled @endif</td>
                                                <td>AED   {{$bookingreport->grand_total}}/-</td>
                                            </tr>
                                            @php $total_amount = $total_amount + $bookingreport->grand_total; @endphp
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th style="border-right: none;    border-left: none;"></th>
                                            <th  style="border-right: none;    border-left: none;"></th>
                                            <th style="border-right: none;    border-left: none;"></th>
                                            <th  style="border-right: none;    border-left: none;"></th>
                                            <th style="border-right: none;    border-left: none;"></th>
                                            <th  style="border-right: none;    border-left: none;"></th>
                                            <th style="border-right: none;    border-left: none;"></th>
                                            <th style="text-align:right;border-left: none;">Total:</th>
                                            <th style="border-left: none;">AED   {{$total_amount}}/-</th>
                                        </tr>
                                        </tfoot>
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

    <script src="{{url('js/admin-panel/plugin/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('js/admin-panel/plugin/datatables/buttons.flash.min.js')}}"></script>
    <script src="{{url('js/admin-panel/plugin/datatables/jszip.min.js')}}"></script>
    <script src="{{url('js/admin-panel/plugin/datatables/pdfmake.min.js')}}"></script>
    <script src="{{url('js/admin-panel/plugin/datatables/vfs_fonts.js')}}"></script>
    <script src="{{url('js/admin-panel/plugin/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{url('js/admin-panel/plugin/datatables/buttons.print.min.js')}}"></script>

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
           $('#dt_basic').DataTable({
               dom: 'Bfrtip',
               buttons: [
                   {
                       extend: 'csvHtml5',
                       footer: true
                   },
                   {
                       extend: 'pdfHtml5',
                       orientation: 'landscape',
                       pageSize: 'LEGAL',
                       footer: true
                   },
               ]

            });
        } );
    </script>

@endsection

