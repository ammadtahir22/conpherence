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
                <div class="tab-pane active" id="team">
                    <div class="welcome-title full-col">
                        <h2>Team</h2>
                    </div>

                    <div class="dashboard-map col-sm-7">
                        <h3 class="dashboard-title">Our Teams</h3>
                        <div id="map" class="mapwrap"></div>
                        <div class="dash-label">

                            <div class="dash-label-right">
                                <h3>5<i class="star">★★★★★</i></h3>
                                <h4>15 Reviews<img src="{{url('images/bar.png')}}" alt=""/></h4>
                            </div>
                        </div>
                    </div><!-- map -->
                </div>
            </div>
            <!-- /tabs -->
            <div class="clearfix"></div>
        </div>
    </section>
@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}
@section('scripts')
    @include('site.layouts.scripts')
@endsection