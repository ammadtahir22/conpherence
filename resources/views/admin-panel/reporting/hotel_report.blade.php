@extends('admin-panel.layouts.app')
@section('css-link')
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
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
        .req_fil{
            color: #b94a48;
        }
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
        .buttons-html5.buttons-csv,.buttons-html5.buttons-pdf{
            padding: 0px;
            margin-right: 7px;
            border:transparent !important;
        }
    </style>
@endsection
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
    <!-- MAIN PANEL -->
    <div id="main" role="main">

        <!-- RIBBON -->
        <div id="ribbon">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>Home / View Report</li>
            </ol>

        </div>
        <!-- END RIBBON -->


        <!-- MAIN CONTENT -->
        <div id="content">


            <!-- widget grid -->
            <section id="widget-grid" class="">
                <!-- row -->
                <div class="row">
                    <form action="{{route('admin.hotelowner.gethotelreport')}}" method="post" id="booking_report_form">
                    @csrf
                    <!-- NEW WIDGET START -->
                        <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <!-- Widget ID (each widget will need unique ID)-->
                            <div class="jarviswidget" id="wid-id-0">
                                <!-- widget content -->
                                <div class="widget-body">
                                    <div class="form-horizontal">
                                        <fieldset>
                                            <legend>View Report</legend>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Start Date<span class="req_fil">*</span></label>
                                                <div class="col-md-4">
                                                    <input type="text" name="report_start_date" id="report_start_date" autocomplete="off" data-dateformat="yy-mm-dd" placeholder="Start Date"
                                                           class="form-control datepicker" required>
                                                </div>
                                                <label class="col-md-2 control-label">End Date<span class="req_fil">*</span></label>

                                                <div class="col-md-4">
                                                    <input type="text" name="report_end_date" id="report_end_date" autocomplete="off" data-dateformat="yy-mm-dd" placeholder="End Date"
                                                           class="form-control datepicker" required>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Booking Type</label>
                                                <div class="col-md-10">
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="">Select Type</option>
                                                        <option value="0">Pending</option>
                                                        <option value="1">Approved</option>
                                                        <option value="2">Cancelled</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Hotel</label>
                                                <div class="col-md-10">
                                                    <select multiple class="form-control select2" name="hotel[]" id="hotel">
                                                        <option value="">Select Hotel</option>
                                                        @if(isset($all_companies) && count($all_companies) > 0)
                                                            @foreach($all_companies as $company)
                                                                <option value="{{$company->user_id}}">{{$company->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">User</label>
                                                <div class="col-md-10">
                                                    <select multiple class="form-control select2" name="user[]" id="user">
                                                        @if(isset($all_users) && count($all_users) > 0)
                                                            @foreach($all_users as $user)
                                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <a id="configreset" href="#" class="btn btn-default"> Cancel </a>
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
                        <!-- WIDGET END -->

                        <!-- WIDGET END -->
                    </form>
                </div>

                <!-- end row -->


            </section>
            <!-- end widget grid -->

            <!--------------------------------------------------------------------------------------------------------------------------------------------->
            @if(isset($booking_infos) && count($booking_infos) > 0)
            <div id="content">
                <section id="widget-grid" class="">
                    <div class="row">
                        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                                <header>
                                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                    <h2>Booking Report </h2>
                                </header>
                                <div>
                                    <div class="jarviswidget-editbox">
                                    </div>
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
                                                    <td>{{$bookingreport->booking_email}}</td>
                                                    <td>{{$bookingreport->purpose}}</td>
                                                    <td>{{get_venue_title($bookingreport->venue_id)}} ({{get_city_by_venue($bookingreport->venue_id)}})</td>
                                                    <td>{{get_space_title($bookingreport->space_id)}}</td>
                                                    <td>{{date('d M Y', strtotime($bookingreport->start_date))}} to {{date('d M Y', strtotime($bookingreport->end_date))}}</td>
                                                    <td>@if($bookingreport->status == 0) Pending @elseif($bookingreport->status == 1) Approved @else Cancelled @endif</td>
                                                    <td>AED   {{number_format($bookingreport->grand_total, 2)}}/-</td>
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
                                                <th style="border-left: none;">AED   {{number_format($total_amount,2)}}/-</th>
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
            @endif
            @if($no_record != '')
                <div class="alert-danger" style="text-align: center;"><h3>{{$no_record}}</h3></div>
            @endif
            <!--------------------------------------------------------------------------------------------------------------------------------------------->
        </div>
    </div>
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

    <script type="text/javascript">
        $(document).ready(function () {
            $('#booking_report_form').validate({
                ignore: [],
                rules: {
                    report_start_date: {
                        required: true
                    },
                    report_end_date: {
                        required: true
                    }
                }
            });
            $('.select2').select2({});

            $('#configreset').click(function(){
                $('#booking_report_form')[0].reset();
            });
        });

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
                ,
                initComplete: function() {
                    $('.buttons-csv').html('<img src="'+base_url+'/images/doc1.png" alt="excel">');
                    $('.buttons-pdf').html('<img src="'+base_url+'/images/doc.png" alt="pdf">');
                }

            });
        } );




    </script>
@endsection
