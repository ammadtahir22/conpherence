@extends('site.layouts.app')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
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
                    @include('site.companies.dashboard_nev',['active_venue' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active" id="venue">
                    <div class="welcome-title full-col">
                        <h2>Venue</h2>
                        <a href="{{url('company/dashboard/venue/add')}}" class="get-btn"><span>Add Venue</span></a>
                    </div>
                    <div class="booking-wrap">
                        <div class="tabs">
                            <div class="tab-button-outer">
                                <ul id="tab-button" class="booking-tab">
                                    <li class="is-active active-venue-link"><a href="#active-venues">Active Venues</a></li>
                                    <li class="inactive-venue-link"><a href="#inactive-venues">Inactive Venues</a></li>
                                </ul>

                            </div>
                            @include('site.layouts.session_messages')
                            <div id="active-venues" class="search-result tab-contents vaneu-booking">
                                <div class="full-col book-result">
                                    <div class="col-sm-6 book-result-info">
                                        {{--<p>Showing 15 results</p>--}}
                                    </div>
                                    <div class="col-sm-6 book-result-form">
                                        {{--<form action="#" method="post">--}}
                                        <div class="col-xs-4 form-group">
                                            <select id="actv_orderby" class="selectpicker" onchange="get_venue_search()">
                                                <option value="">Sort by</option>
                                                <option value="asc">Accending Order</option>
                                                <option value="desc">Deccending Order</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8 form-group">
                                            {{--<form id="searching" method="get">--}}
                                            @csrf
                                            <input id="actv_search" type="text"  name="date" placeholder="Search" class="form-control" onkeyup="get_venue_search()">
                                            {{--</form>--}}
                                        </div>
                                        {{--</form>--}}
                                    </div>
                                </div>
                                <div id="active-venue-search">
                                    @if(count($active_venues) > 0)
                                        @foreach($active_venues as $venue)
                                            <div class="book-list" id="venue_box_{{$venue->id}}">
                                                <div class="b-list-img col-sm-2">
                                                    <img src="{{ isset($venue) ? url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image) : url('images/edit-profile-iconh.png') }}" alt="" />
                                                </div>
                                                <div class="b-list-info col-sm-4">
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
                                                    {{--4.5--}}
                                                    {{--<div class="star-ratings-css">--}}
                                                    {{--<div class="star-ratings-css-top" style="width: 95%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>--}}
                                                    {{--<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>--}}
                                                    {{--</div>--}}
                                                </div>
                                                <div class="vanu-edit col-sm-2">
                                                    <a class="del-btn" onclick="show_delete({{$venue->id}})"><img src="{{url('images/delete.png')}}" alt="edit"/></a>
                                                    <a href="{{url('company/dashboard/venue/edit/'.$venue->id)}}" class="edit-btn"><img src="{{url('images/edit.png')}}" alt="edit"/></a>
                                                </div>
                                                <div class="b-list-btn col-sm-2">
                                                    <a href="{{url('/company/dashboard/space/index/'.$venue->id)}}" class="btn get-btn">
                                                        <span>View Listing </span><span></span><span></span><span></span><span></span>
                                                    </a>
                                                </div>
                                            </div><!--booking list-->
                                        @endforeach
                                    @else
                                        <div class="pay-inner-card"><div class="dash-pay-gray"> No Venue added yet. </div></div>
                                    @endif
                                </div>
                                {{ $active_venues->links() }}
                            </div>
                            <div id="inactive-venues" class="tab-contents search-result vaneu-booking">
                                <div class="full-col book-result">
                                    <div class="col-sm-6 book-result-info">
                                        {{--<p>Showing 15 results</p>--}}
                                    </div>
                                    <div class="col-sm-6 book-result-form">
                                        {{--<form action="#" method="post">--}}
                                        <div class="col-xs-4 form-group">
                                            <select id="inactv_orderby" class="selectpicker" onchange="get_venue_search()">
                                                <option value="">Sort by</option>
                                                <option value="asc">Accending Order</option>
                                                <option value="desc">Deccending Order</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8 form-group">
                                            {{--<form id="searching" method="get">--}}
                                            @csrf
                                            <input id="inactv_search" type="text"  name="date" placeholder="Search" class="form-control" onkeyup="get_venue_search()">
                                            {{--</form>--}}
                                        </div>
                                        {{--</form>--}}
                                    </div>
                                </div>
                                <div id="inactive-venue-search">
                                    @if(count($inactive_venues) > 0)
                                        @foreach($inactive_venues as $venue)
                                            <div class="book-list" id="venue_box_{{$venue->id}}">
                                                <div class="b-list-img col-sm-2">
                                                    <img src="{{ isset($venue) ? url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image) : url('images/edit-profile-iconh.png') }}" alt="" />
                                                </div>
                                                <div class="b-list-info col-sm-4">
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
                                                    {{--4.5--}}
                                                    {{--<div class="star-ratings-css">--}}
                                                    {{--<div class="star-ratings-css-top" style="width: 95%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>--}}
                                                    {{--<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>--}}
                                                    {{--</div>--}}
                                                </div>
                                                <div class="vanu-edit col-sm-2">
                                                    <a class="del-btn" onclick="show_delete({{$venue->id}})"><img src="{{url('images/delete.png')}}" alt="edit"/></a>
                                                    <a href="{{url('company/dashboard/venue/edit/'.$venue->id)}}" class="edit-btn"><img src="{{url('images/edit.png')}}" alt="edit"/></a>
                                                </div>
                                                <div class="b-list-btn col-sm-2">
                                                    <a href="{{url('/company/dashboard/space/index/'.$venue->id)}}" class="btn get-btn">
                                                        <span>View Listing </span><span></span><span></span><span></span><span></span>
                                                    </a>
                                                </div>
                                            </div><!--booking list-->
                                        @endforeach
                                    @else
                                        <div class="pay-inner-card"><div class="dash-pay-gray"> No Venue added yet. </div></div>
                                    @endif

                                </div>
                                {{ $inactive_venues->links() }}
                            </div>
                        </div><!--wrapper-->
                    </div>
                </div>
            </div>
        </div>
        <!-- /tabs -->
        <div class="clearfix"></div>
    </section>

    <!--Delete popup-->
    <div class="modal fade card-popup" id="delpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <!-- <h3>Delete Payment Method</h3> -->
                    <p style="text-align: center;"> Are you sure you want delete it</p>
                    <form id="delete_venue_form">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" id="delete_venue_id">
                        <div class="form-group form-btn half-l-field">
                            <button type="submit" class="btn ani-btn" id="delete_card_button">Yes</button>
                        </div>
                        <div class="form-group form-btn half-r-field">
                            <button type="button" class="btn ani-btn cancel-btn" data-dismiss="modal" aria-label="Close">No</button>
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
@section('scripts')
    @include('site.layouts.scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>

    <script>

        function show_delete(id)
        {
            $('#delete_venue_id').val(id);
            $('#delpopup').modal('toggle');
        }

        $("#delete_venue_form").validate({
            submitHandler: function(form) {
                $.ajax({
                    type: 'delete',
                    data: $('#delete_venue_form').serialize(),
                    url: '{{url('/company/dashboard/venue/delete')}}',
                    success: function (response) {
                        $('#delpopup').modal('toggle');

                        if (response.success !== '') {
                            $('#flash_massage').html(response.success);
                            var venue_div_id = '#venue_box_'+$('#delete_venue_id').val();
                            $(venue_div_id).remove();
                        } else {
                            $('#flash_massage').html(response.error);
                        }
                    }
                });
            }
        });
    </script>

    <script>
        function edit_venue(venue_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/venue/edit')}}',
                type: 'get',
                datatype: 'json',
                data: {
                    venue_id: venue_id,
                },
                success: function (response) {

                    console.log(response);
                    if(response.status == 1)
                    {
                        $('#add_venue_switch').toggle( this.checked );
                    } else {
                        $('#add_venue_switch').toggle( !this.checked );
                    }

                    $('#add_venue_status').val(response.status);
                    $('#add_venue_id').val(response.id);
                    $('#add_venue_company_id').val(response.company_id);
                    $('#add_venue_descriprion').val(response.description);
                    $('#food_array').val(response.food_array);
                    $('#add_venue_cancellation_policy').val(response.cancellation_policy);
                    $('#searchmap_venue').val(response.location);
                    $('#add_venue_latitude').val(response.latitude);
                    $('#add_venue_longitude').val(response.longitude);
                    reset_inner_classes();


                    var data = [];
                    data = get_venue_images_url(response.id, response.images);
                    console.log(data);


                    $("#image_gallery_venue").fileinput({
                        uploadUrl:  "{{ url('storage/images/venues/') }}",

                        dropZoneEnabled: false,
                        maxFileCount: 10,
                        validateInitialCount: true,
                        overwriteInitial: false,
                        initialPreview: data,
                        initialPreviewConfig: [
                            {
                                fileType: 'image',
                                previewAsData: true,
                            }
                        ],
                        allowedFileExtensions: ["jpg", "png", "gif"],
                        showUpload: false, // The "Upload" button
                        showRemove: false, // The "Remove" button
                        allowedPreviewTypes: ['image'],
                    });

                }
            });

            function get_venue_images_url(id, images)
            {
                var images_name = $.parseJSON(images);
                if (id)
                {

                    var data = [];
                    for (var i = 0; i < images_name.length; i++)
                    {
                        var url = base_url + '/storage/images/venues/'+id+'/'+images_name[i];
                        data.push(url);
                    }
                } else {
                    var data = [];
                }
                return data;
            }
        }
    </script>
    <script type="text/javascript">
        function get_venue_search(){
            if($('.active-venue-link').hasClass( "is-active" )){
                var activetab = 1;
                var search_order = $('#actv_orderby').val();
                var search = $('#actv_search').val();
            }else{
                var activetab = 0;
                var search_order = $('#inactv_orderby').val();
                var search = $('#inactv_search').val();
            }
            console.log('Order: '+search_order);
            $.ajax({
                type : "GET",
                url : "{{ route('company.dashboard.venue.listingsearch') }}",
                data:{'search':search,'activetab':activetab, 'search_order': search_order},
                success:function(data){
                    //console.log(data);
                    if($('.active-venue-link').hasClass( "is-active" )){
                        console.log('Active Here');
                        $('#active-venue-search').html("");
                        $('#active-venue-search').html(data.html);
                        //$('#a_label').html(data.counter);
                    }else{
                        console.log('Inactive Here');
                        //$('#p_label').html(data.counter);
                        $('#inactive-venue-search').html("");
                        $('#inactive-venue-search').html(data.html);
                    }
                }
            });
        }
    </script>
@endsection

































