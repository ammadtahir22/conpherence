@extends('site.layouts.app')

@section('head')
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />--}}
    {{--<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>--}}
@endsection

@section('header-class', 'dashboard-header')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="dashboard">
        <div class="tabbable tabs-left">
            <aside class="dashboard-sidebar">
                <ul class="nav nav-tabs ">
                    @include('site.individuals.dashboard_nev',['active_saving' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active" id="savings">
                    <div class="welcome-title full-col">
                        <h2>Savings</h2>
                        <div class="report-btn">
                            <a href="#" data-toggle="modal" data-target="#reportpopup">Generate Report</a>
                        </div>
                    </div>

                    <div class="dash-box col-xs-8 dash-saving">
                        <h3 class="dashboard-title">Membership Types</h3>
                        <div class="dash-box-inner dash-saving-box">
                            <div class="dash-saving-box-inner">
                                <table>
                                    <tr>
                                        <th>Badge Type</th>
                                        <th>Number of Bookings</th>
                                        <th>Discount (%)</th>
                                    </tr>
                                    <tr>
                                        <td><span><img src="{{url('images/silver.png')}}" alt="" />Silver</span></td>
                                        <td>{{isset($discount_silver) ? $discount_silver->no_of_booking : 0}}</td>
                                        <td>{{isset($discount_silver) ? $discount_silver->discount : 0}}%</td>
                                    </tr>
                                    <tr>
                                        <td><span><img src="{{url('images/gold.png')}}" alt="" />Gold</span></td>
                                        <td>{{isset($discount_gold) ? $discount_gold->no_of_booking : 0}}</td>
                                        <td>{{isset($discount_gold) ? $discount_gold->discount : 0}}%</td>
                                    </tr>
                                    <tr>
                                        <td><span><img src="{{url('images/platinum.png')}}" alt="" />Platinum</span></td>
                                        <td>{{isset($discount_platinum) ? $discount_platinum->no_of_booking : 0}}</td>
                                        <td>{{isset($discount_platinum) ? $discount_platinum->discount : 0}}%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="dash-box col-xs-4 dash-earncard">
                        <h3 class="dashboard-title">You’ve The {{$badge}} Badge</h3>
                        <div class="dash-box-inner dash-earncard-box">
                            @if($badge == 'Platinum')
                                <img src="{{url('images/platinum.png')}}" alt="" />
                                <h4>Platinum Badge</h4>
                            @elseif($badge == 'Gold')
                                <img src="{{url('images/gold.png')}}" alt="" />
                                <h4>Gold Badge</h4>
                            @elseif($badge == 'Sliver')
                                <img src="{{url('images/silver.png')}}" alt="" />
                                <h4>Silver Badge</h4>
                            @elseif($badge == 'Classic')
                                <img src="{{url('images/clasic.png')}}" alt="" />
                                <h4>Classic Badge</h4>
                            @endif

                                <div class="progress">
                                    <div class="progress-bar dash-bar-clasic" role="progressbar" style="width:25%">
                                        <span>Classic</span>
                                    </div>
                                    @php
                                        $sliver_bar = '';
                                            if($badge == 'Sliver' || $badge == 'Gold'  || $badge == 'Platinum')
                                            {
                                                $sliver_bar = 'dash-bar-silver';
                                            }
                                    @endphp

                                    <div class="progress-bar {{$sliver_bar}}" role="progressbar" style="width:50%">
                                        <span>Silver</span>
                                    </div>

                                    @php
                                        $gold_bar = '';
                                            if($badge == 'Gold' || $badge == 'Platinum')
                                            {
                                                $gold_bar = 'dash-bar-gold';
                                            }
                                    @endphp
                                    <div class="progress-bar {{$gold_bar}}" role="progressbar" style="width:51%">
                                        <span>Gold</span>
                                    </div>

                                    @php
                                        $platinum_bar = '';
                                            if($badge == 'Platinum')
                                            {
                                                $platinum_bar = 'dash-bar-platinum';
                                            }
                                    @endphp
                                    <div class="progress-bar {{$platinum_bar}}" role="progressbar" style="width:76%">
                                        <span>Platinum</span>
                                    </div>
                                </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /tabs -->
            <div class="clearfix"></div>
        </div>
    </section>


    <!-- generate repost popup -->
    <div class="modal fade card-popup" id="reportpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3>Generate Report</h3>
                    <form method="post" action="{{url('/user/saving/report')}}" target="_blank" id="saving_report">
                        @csrf
                        <div class="form-group half-l-field">
                            <legend>Start Date</legend>
                            <input type="text" name="start_date" class="form-control" id="report_start_date" placeholder="Start Date">
                        </div><!--form-group-->
                        <div class="form-group half-r-field">
                            <legend for="date">End Date</legend>
                            <input type="text" name="end_date" class="form-control" id="report_end_date" placeholder="End Date">
                        </div><!--form-group-->
                        <div class="form-group form-btn half-l-field">
                            <button type="submit" class="btn ani-btn">Generate Report</button>
                        </div>
                        <div class="form-group form-btn half-r-field">
                            <button type="button" class="btn ani-btn cancle-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')
    <script>
        new Pikaday({
            field: document.getElementById('report_start_date'),
        });
        new Pikaday({
            field: document.getElementById('report_end_date'),
        });

        $("#saving_report").validate({
            rules: {
                start_date: {
                    required: true
                },
                end_date: {
                    required: true
                }
            },
            messages: {
                start_date: {
                    required: "Please select required field"
                },
                end_date: {
                    required: "Please select required field"
                }
            }
        });
    </script>


@endsection