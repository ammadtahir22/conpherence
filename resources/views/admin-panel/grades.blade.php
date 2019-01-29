@extends('admin-panel.layouts.app')

@section('css-link')
    <style>
        .smart-form .rating input+label:hover, .smart-form .rating input+label:hover~label {
            color: #f47a36;
        }
        .smart-form .rating input:checked~label{
            color: #f15048;
        }
        .modal-body .smart-form .rating{
            padding-left: 15px;
            padding-right: 15px;
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
                <li>Home</li><li>All Venues Grades</li>
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
                                <h2> Grades </h2>

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
                                            <th>Sr.No</th>
                                            <th>Venue Name</th>
                                            <th>Users Rating</th>
                                            {{--<th>Status</th>--}}
                                            <th>Admin Rating</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="smart-form">
                                        @if(isset($venues))
                                            @foreach($venues as $key => $venue)
                                                @php $key = $key+1; @endphp
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ $venue->title }} ({{$venue->city}})</td>
                                                    @php
                                                        $stars = $venue->reviews == null  ? 0 : $venue->reviews;
                                                    $user_select1 = '';
                                                    $user_select2 = '';
                                                    $user_select3 = '';
                                                    $user_select4 = '';
                                                    $user_select5 = '';
                                                    if(round($stars) == '1')
                                                    {
                                                        $user_select1 = 'checked';
                                                    } elseif(round($stars) == '2')
                                                    {
                                                        $user_select2 = 'checked';
                                                    } elseif(round($stars) == '3')
                                                    {
                                                        $user_select3 = 'checked';
                                                    } elseif(round($stars) == '4')
                                                    {
                                                        $user_select4 = 'checked';
                                                    } elseif(round($stars) == '5')
                                                    {
                                                        $user_select5 = 'checked';
                                                    }

                                                    @endphp
                                                    <td>
                                                        <div class="rating">
                                                            <input type="radio" name="user-rating{{$key}}" id="user_rating_5{{$key}}" {{$user_select5}} disabled>
                                                            <label for="user_rating_5{{$key}}"><i class="fa fa-star"></i></label>
                                                            <input type="radio" name="user-rating{{$key}}" id="user_rating_4{{$key}}" {{$user_select4}} disabled>
                                                            <label for="user_rating_4{{$key}}"><i class="fa fa-star"></i></label>
                                                            <input type="radio" name="user-rating{{$key}}" id="user_rating_3{{$key}}" {{$user_select3}} disabled>
                                                            <label for="user_rating_3{{$key}}"><i class="fa fa-star"></i></label>
                                                            <input type="radio" name="user-rating{{$key}}" id="user_rating_2{{$key}}" {{$user_select2}} disabled>
                                                            <label for="user_rating_2{{$key}}"><i class="fa fa-star"></i></label>
                                                            <input type="radio" name="user-rating{{$key}}" id="user_rating_1{{$key}}" {{$user_select1}} disabled>
                                                            <label for="user_rating_1{{$key}}"><i class="fa fa-star"></i></label>
                                                        </div>
                                                    </td>

                                                    <td align="center">
                                                        @if($venue->admin_rating)
                                                            @php
                                                                $admin_stars = $venue->admin_rating == null  ? 0 : $venue->reviews;
                                                            $admin_select1 = '';
                                                            $admin_select2 = '';
                                                            $admin_select3 = '';
                                                            $admin_select4 = '';
                                                            $admin_select5 = '';
                                                            if(round($admin_stars) == '1')
                                                            {
                                                                $admin_select1 = 'checked';
                                                            } elseif(round($admin_stars) == '2')
                                                            {
                                                                $admin_select2 = 'checked';
                                                            } elseif(round($admin_stars) == '3')
                                                            {
                                                                $admin_select3 = 'checked';
                                                            } elseif(round($admin_stars) == '4')
                                                            {
                                                                $admin_select4 = 'checked';
                                                            } elseif(round($admin_stars) == '5')
                                                            {
                                                                $admin_select5 = 'checked';
                                                            }

                                                            @endphp
                                                            <div class="rating">
                                                                <input type="radio" name="admin-rating{{$key}}" id="admin_rating_5{{$key}}" {{$admin_select5}}>
                                                                <label for="admin_rating_5{{$key}}"><i class="fa fa-star"></i></label>
                                                                <input type="radio" name="admin-rating{{$key}}" id="admin_rating_4{{$key}}" {{$admin_select4}}>
                                                                <label for="admin_rating_4{{$key}}"><i class="fa fa-star"></i></label>
                                                                <input type="radio" name="admin-rating{{$key}}" id="admin_rating_3{{$key}}" {{$admin_select3}}>
                                                                <label for="admin_rating_3{{$key}}"><i class="fa fa-star"></i></label>
                                                                <input type="radio" name="admin-rating{{$key}}" id="admin_rating_2{{$key}}" {{$admin_select2}}>
                                                                <label for="admin_rating_2{{$key}}"><i class="fa fa-star"></i></label>
                                                                <input type="radio" name="admin-rating{{$key}}" id="admin_rating_1{{$key}}" {{$admin_select1}}>
                                                                <label for="admin_rating_1{{$key}}"><i class="fa fa-star"></i></label>
                                                            </div>
                                                        @else
                                                            <button class="btn btn-primary btn-sm" data-venue="{{$venue->id}}" data-toggle="modal" data-target="#admin_rating_modal">
                                                                Add rating
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form action="{{url('/admin/change_review_status')}}" method="POST" class="smart-form" id="user_status_form{{$key}}">
                                                            @csrf
                                                            <input type="hidden" name="review_id" value="{{$venue->id}}">
                                                            <input type="hidden" name="booking_id" value="{{$venue->booking_id}}">
                                                            <label class="toggle">
                                                                <input type="checkbox" name="active" @php if ($venue->r_status == 1) echo 'checked="checked"'; @endphp onchange="changeUserStatus({{$key}})">
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

    <!-- Modal -->
    <div class="modal fade" id="admin_rating_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Admin Rating</h4>
                </div>
                <div class="modal-body">
                    <form action="" class="smart-form">
                        @csrf
                        <input type="hidden" name="venue_id" id="venue_id">
                        <div class="row">
                            <div class="rating">
                                <input type="radio" name="stars-rating" value="5" id="stars-rating-5">
                                <label for="stars-rating-5"><i class="fa fa-star"></i></label>
                                <input type="radio" name="stars-rating" value="4" id="stars-rating-4">
                                <label for="stars-rating-4"><i class="fa fa-star"></i></label>
                                <input type="radio" name="stars-rating" value="3" id="stars-rating-3">
                                <label for="stars-rating-3"><i class="fa fa-star"></i></label>
                                <input type="radio" name="stars-rating" value="2" id="stars-rating-2">
                                <label for="stars-rating-2"><i class="fa fa-star"></i></label>
                                <input type="radio" name="stars-rating" value="1" id="stars-rating-1">
                                <label for="stars-rating-1"><i class="fa fa-star"></i></label>
                                Stars
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary">
                        Post Article
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
        $('#admin_rating_modal').on("show.bs.modal", function (e) {
            $('#venue_id').val($(e.relatedTarget).data('venue'))
        });


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
    </script>

@endsection

