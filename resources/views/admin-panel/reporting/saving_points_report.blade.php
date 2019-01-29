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
    div.dataTables_paginate ul.pagination{
        margin-bottom: 20px;
    }
    .buttons-html5.buttons-csv,.buttons-html5.buttons-pdf{
        padding: 0px;
        margin-right: 7px;
        border:transparent !important;
    }

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
<div id="main" role="main">
    <!-- RIBBON -->
    <div id="ribbon">
        <ol class="breadcrumb">
            <li>Home / View Report</li>
        </ol>
    </div>
    <div id="content">
        <section id="widget-grid" class="">
            <div class="row">
                <form action="{{route('admin.getuser.savingreport')}}" method="post" id="booking_report_form">
                    @csrf
                    <article class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <div class="jarviswidget" id="wid-id-0">
                            <div class="widget-body">
                                <div class="form-horizontal">
                                    <fieldset>
                                        <legend>View Report</legend>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Start Date<span class="req_fil">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="report_start_date" autocomplete="off" id="report_start_date" data-dateformat="yy-mm-dd" placeholder="Start Date"
                                                    class="form-control datepicker" required>
                                            </div>
                                            <label class="col-md-2 control-label">End Date<span class="req_fil">*</span></label>
                                            <div class="col-md-4">
                                                <input type="text" name="report_end_date" id="report_end_date" autocomplete="off" data-dateformat="yy-mm-dd" placeholder="End Date"
                                                    class="form-control datepicker" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">User</label>
                                            <div class="col-md-10">
                                                <select multiple class="form-control select2" name="user[]" id="user">
                                                    <option value="">Select User</option>
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
                            </div>
                        </div>
                    </article>
                </form>
            </div>
        </section>

        <!-------------------------------------------------------------------------------------------------------------------------------------------->
        @if(isset($saving_report) && count($saving_report) > 0)
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
                                <th>Saved Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $total_amount = 0 @endphp
                            @php $total_discount = 0 @endphp
                            @foreach($saving_report as $key => $saving)
                                @php $discount = $saving->total - $saving->grand_total; @endphp
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$saving->booking_number}}</td>
                                    <td>{{$saving->booking_firstname." ".$saving->booking_lastname}}</td>
                                    <td>{{$saving->booking_email}}</td>
                                    <td>{{$saving->purpose}}</td>
                                    <td>{{get_venue_title($saving->venue_id)}} ({{get_city_by_venue($saving->venue_id)}})</td>
                                    <td>{{get_space_title($saving->space_id)}}</td>
                                    <td>{{date('d M Y', strtotime($saving->start_date))}} to {{date('d M Y', strtotime($saving->end_date))}}</td>
                                    <td>AED  {{number_format($saving->grand_total,2)}}/- </td>
                                    <td>AED  {{number_format($discount,2)}}/- </td>
                                </tr>
                                @php $total_amount = $total_amount + $saving->grand_total; @endphp
                                @php $total_discount = $total_discount + $discount; @endphp
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
                                <th style="border-left: none;">AED   {{number_format($total_discount,2)}}/-</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </article>
        @endif
        @if($no_record != '')
            <div class="text-danger" style="text-align: center;"><h3>{{$no_record}}</h3></div>
        @endif
        <!-------------------------------------------------------------------------------------------------------------------------------------------->

    </div>


</div>
@endsection

@section('scripts')
<!-- <script src="js/plugin/select2/select2.min.js"></script> -->
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

        $('#configreset').click(function(){
            $('#booking_report_form')[0].reset();
        });
    });
    
    
</script>
@endsection
