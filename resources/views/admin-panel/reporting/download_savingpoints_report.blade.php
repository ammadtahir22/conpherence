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
@section('left-panel')
    @include('admin-panel.layouts.left-panel')
@endsection
@section('main-panel')
    <div id="main" role="main">
        <div id="ribbon">
            <ol class="breadcrumb">
                <li>Home</li><li>Discount Report</li>
            </ol>
        </div>
        <div id="content">
            <section id="widget-grid" class="">
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
                    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                            <header>
                                <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                <h2>Discount Report </h2>
                            </header>
                            <div>
                                <div class="jarviswidget-editbox">
                                </div>
                                <div class="widget-body no-padding">

                                    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Sr#</th>
                                            <th>Booking Number</th>
                                            <th>Customer Name</th>
                                            <th>Customer Email</th>
                                            <th>Name of Meeting</th>
                                            <th>Venue Name</th>
                                            <th>Space Name</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Discount</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $total_amount = 0 @endphp
                                        @php $total_discount = 0 @endphp
                                        @foreach($saving_report as $key => $saving)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$saving->booking_number}}</td>
                                                <td>{{$saving->booking_firstname." ".$saving->booking_lastname}}</td>
                                                <td>{{$saving->user->email}}</td>
                                                <td>{{$saving->purpose}}</td>
                                                <td>{{get_venue_title($saving->venue_id)}} ({{get_city_by_venue($saving->venue_id)}})</td>
                                                <td>{{get_space_title($saving->space_id)}}</td>
                                                <td>{{date('d M Y', strtotime($saving->start_date))}} to {{date('d M Y', strtotime($saving->end_date))}}</td>
                                                <td>AED  {{$saving->grand_total}}/- </td>
                                                <td>AED  {{$saving->discount}}/- </td>
                                            </tr>
                                            @php $total_amount = $total_amount + $saving->grand_total; @endphp
                                            @php $total_discount = $total_discount + $saving->discount; @endphp
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
                                                <th style="border-left: none;">AED   {{$total_discount}}/-</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('footer')
    @include('admin-panel.layouts.footer')
@endsection
{{--@section('shortcut')--}}
{{--@include('admin-panel.layouts.shortcut')--}}
{{--@endsection--}}
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

        // $(document).ready(function() {
        //     /* COLUMN FILTER  */
        //     var responsiveHelper_dt_basic = undefined;
        //     var responsiveHelper_datatable_fixed_column = undefined;
        //     var responsiveHelper_datatable_col_reorder = undefined;
        //     var responsiveHelper_datatable_tabletools = undefined;
        //
        //     var breakpointDefinition = {
        //         tablet : 1024,
        //         phone : 480
        //     };
        //     var otable = $('#dt_basic').DataTable({
        //         "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
        //             "t"+
        //             "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
        //         "autoWidth" : true,
        //         "oLanguage": {
        //             "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
        //         },
        //         "preDrawCallback" : function() {
        //             // Initialize the responsive datatables helper once.
        //             if (!responsiveHelper_datatable_fixed_column) {
        //                 responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
        //             }
        //         },
        //         "rowCallback" : function(nRow) {
        //             responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
        //         },
        //         "drawCallback" : function(oSettings) {
        //             responsiveHelper_datatable_fixed_column.respond();
        //         }
        //     });
        //     // Apply the filter
        //     $("#dt_basic thead th input[type=text]").on( 'keyup change', function () {
        //         otable
        //             .column( $(this).parent().index()+':visible' )
        //             .search( this.value )
        //             .draw();
        //     } );
        // } );
    </script>
@endsection

