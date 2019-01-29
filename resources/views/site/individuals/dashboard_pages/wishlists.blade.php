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
                    @include('site.individuals.dashboard_nev',['active_wishlist' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active" id="wishlist">
                    <div class="welcome-title full-col">
                        <h2>Wish List</h2>
                    </div>

                    <div class="booking-wrap wishlist-wrap">
                        <div class="tabs">
                            <div class="tab-button-outer">
                                <ul id="tab-button" class="booking-tab">
                                    <li class="venue-tab is-active"><a href="#venues">Venues</a></li>
                                    <li class="space-tab"><a href="#spaces">Spaces</a></li>
                                </ul>

                            </div>
                            @include('site.layouts.session_messages')
                            <div id="venues" class="tab-contents venue-wishlist search-result">
                                <div class="full-col book-result">
                                    <div class="col-sm-6 book-result-info">
                                        {{--<p>Showing 15 results</p>--}}
                                    </div>
                                    <div class="col-sm-6 book-result-form">
                                        {{--<form action="#" method="post">--}}
                                            <div class="col-xs-4 form-group">
                                                <select id="venue_orderby" class="selectpicker" onchange="get_search_data()">
                                                    <option>Sort by</option>
                                                    <option value="asc">Accending Order</option>
                                                    <option value="desc">Deccending Order</option>
                                                </select>
                                            </div>
                                        {{--</form>--}}
                                            <div class="col-xs-8 form-group">
                                                {{--<form id="searching" method="get">--}}
                                                    @csrf
                                                    <input id="venue_search" type="text"  name="date" placeholder="Search" class="search_wishlist_data form-control" onkeyup="get_search_data()">
                                                {{--</form>--}}
                                            </div>

                                    </div>
                                </div>
                                <div id="wishlist-venues">
                                @if(count($wish_venues) > 0)
                                    @foreach($wish_venues as $wish_venue)
                                        @php $venue = get_venue($wish_venue->item_id) @endphp
                                        <div class="book-list" id="venue_box_{{$wish_venue->id}}">
                                            <div class="b-list-img col-sm-2">
                                                <img src="{{ isset($venue) ? url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image) : url('images/edit-profile-iconh.png') }}" alt="" />
                                            </div>
                                            <div class="b-list-info col-sm-5">
                                                <h3>{{$venue->title}}</h3>
                                                <h5><a href="#">{{$venue->city}}</a></h5>
                                            </div>
                                            <div class="b-list-rate col-sm-2">
                                                {{--@php--}}
                                                {{--$json = json_decode($venue->reviews);--}}
                                                {{--$total_average_percentage = ($json[4]/5) * 100;--}}
                                                {{--@endphp--}}
                                                {{$venue->reviews}}
                                                @php echo get_stars_view($venue->reviews); @endphp

                                            </div>
                                            <div class="widh-list-del col-sm-1">
                                                <a class="del-btn" onclick="remove_item_wishlist('{{$venue->id}}','venue', 'venue_box_{{$wish_venue->id}}', 'test')"><img src="{{url('images/delete.png')}}" alt="edit"/></a>
                                            </div>
                                            <div class="b-list-btn col-sm-2">
                                                <a href="{{url('venue/'.$venue->slug)}}" class="btn get-btn">
                                                    <span>View Listing </span><span></span><span></span><span></span><span></span>
                                                </a>
                                            </div>
                                        </div><!--booking list-->
                                    @endforeach
                                @else
                                    <div class="pay-inner-card"><div class="dash-pay-gray"> No Venue added yet. </div> </div>
                                @endif
                                </div>
                            </div>
                            <div id="spaces" class="tab-contents space-wishlist search-result">
                                <div class="full-col  book-result">
                                    <div class="col-sm-6 book-result-info">
                                        {{--<p>Showing 15 results</p>--}}
                                    </div>
                                    <div class="col-sm-6 book-result-form">
                                        {{--<form action="#" method="post">--}}
                                            <div class="col-xs-4 form-group">
                                                <select id="space_orderby" class="selectpicker" onchange="get_search_data()">
                                                    <option>Sort by</option>
                                                    <option value="asc">Accending Order</option>
                                                    <option value="desc">Deccending Order</option>
                                                </select>
                                            </div>
                                        {{--</form>--}}
                                            <div class="col-xs-8 form-group">
                                                {{--<form id="searching" method="get">--}}
                                                    @csrf
                                                    <input id="space_search" type="text"  name="date" placeholder="Search" class="search_wishlist_data form-control" onkeyup="get_search_data()">
                                                {{--</form>--}}
                                            </div>

                                    </div>
                                </div>
                                <div id="wishlist-space">
                                @if(count($wish_spaces) > 0)
                                    @foreach($wish_spaces as $wish_space)
                                        @php $space= get_space($wish_space->item_id) @endphp
                                        <div class="book-list" id="space_box_{{$wish_space->id}}">
                                            <div class="b-list-img col-sm-2">
                                                <img src="{{ isset($space) ? url('storage/images/spaces/'.$space->image) : url('images/edit-profile-iconh.png') }}" alt="" />
                                            </div>
                                            <div class="b-list-info col-sm-5">
                                                <h4>{{$space->venue->title}}</h4>
                                                <h3>{{$space->title}}</h3>
                                                <h5><a href="#">{{$space->venue->city}}</a></h5>
                                            </div>
                                            <div class="b-list-rate col-sm-2">
                                                {{--@php--}}
                                                    {{--$json = json_decode($space->reviews_count);--}}
                                                    {{--$total_average_percentage = ($json[4]/5) * 100;--}}
                                                {{--@endphp--}}
                                                {{$space->reviews_total}}
                                                @php echo get_stars_view($space->reviews_total); @endphp
                                            </div>
                                            <div class="widh-list-del col-sm-1">
                                                <a class="del-btn" onclick="remove_item_wishlist('{{$space->id}}','space', 'space_box_{{$wish_space->id}}', 'test')"><img src="{{url('images/delete.png')}}" alt="edit"/></a>
                                            </div>
                                            <div class="b-list-btn col-sm-2">
                                                <a href="{{url('venue/space/'.$space->slug)}}" class="btn get-btn">
                                                    <span>View Listing </span><span></span><span></span><span></span><span></span>
                                                </a>
                                            </div>
                                        </div><!--booking list-->
                                    @endforeach
                                @else
                                    <div class="pay-inner-card"><div class="dash-pay-gray"> No Space added yet. </div></div>
                                @endif
                                </div>
                            </div>
                            {{--{{ $venues->links() }}--}}
                        </div><!--wrapper-->
                    </div>
                </div>
            </div>
            <!-- /tabs -->
            <div class="clearfix"></div>
        </div>
    </section>

    <!-- wishlist popup -->
    <div class="modal fade list-popup" id="wishlistpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3 id="wishlistmsg"></h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}
@section('scripts')
    @include('site.layouts.scripts')
    <script type="text/javascript">
        function get_search_data(){

            if($('.venue-tab').hasClass( "is-active" )){
                $Activetab = 1;
                var search_order = $('#venue_orderby').val();
                var search = $('#venue_search').val();
               // alert(search);
            }else{
                $Activetab = 0;
                var search_order = $('#space_orderby').val();
                var search = $('#space_search').val();
               // alert(search);
            }

            $.ajax({
                type : "GET",
                url : "{{ route('user.dashboard.wishlist-search') }}",
                data:{'search':search,'activetab':$Activetab,'search_order': search_order},
                success:function(data){
                    //console.log(data);
                    // exit();
                    if($('.venue-tab').hasClass( "is-active" )){
                        $('#wishlist-venues').html("");
                        $('#wishlist-venues').html(data);
                    }else{
                        console.log(data);
                        $('#wishlist-space').html("");
                        $('#wishlist-space').html(data);
                    }
                }
            });
        }
    </script>
@endsection
