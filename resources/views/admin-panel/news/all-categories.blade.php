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
                <li>Home</li><li>All News Categories</li>
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
                                <h2>News Categories </h2>

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

                                            <th class="hasinput" style="width:17%">
                                                <input type="text" class="form-control" placeholder="Filter Sr. No" />
                                            </th>
                                            <th class="hasinput" style="width:16%">
                                                <input type="text" class="form-control" placeholder="Filter Title" />
                                            </th>
                                            <th class="hasinput" style="width:17%">
                                                <input type="text" class="form-control" placeholder="Filter Slug" />
                                            </th><th class="hasinput" style="width:17%">
                                                <input type="text" class="form-control" placeholder="Filter Description" />
                                            </th>
                                            <th class="hasinput icon-addon">
                                                <input id="dateselect_filter" type="text" placeholder="Filter Date" class="form-control datepicker" data-dateformat="yy-mm-dd">
                                                <label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Filter Date"></label>
                                            </th>
                                            <th class="hasinput" style="width:16%">
                                            </th>

                                        </tr>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Title</th>
                                            <th>Slug</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th class="remove-sort">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($categories))
                                            @foreach($categories as $key => $category)
                                                @if($category->title != 'Uncategorized')
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$category->title}}</td>
                                                    <td>{{$category->slug}}</td>
                                                    <td>{{$category->description}}</td>
                                                    <td>{{date('Y-m-d', strtotime($category->created_at))}}</td>
                                                    <td>
                                                        <a href="{{url('/admin/news/category/edit/'. $category->id)}}" class="">
                                                            <i class="fa fa-pencil-square-o fa-lg"></i>
                                                        </a>

                                                        <form style="display: inline" action="{{ url('admin/news/category/delete/'.$category->id)}}" method="post">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            @csrf
                                                            <button class="btn-del" type="submit" style="border: none" onclick="return confirm('Are you sure you want to delete?');">
                                                                <i class="fa fa-trash fa-lg"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endif
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

