@extends('site.layouts.app')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    {{--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>--}}
    {{--<script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}"></script>--}}
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
                <div class="tab-pane active space-pane" id="venue">
                    <div class="welcome-title full-col">
                        <ol class="breadcrumb">
                            <li> <a href="{{url('company/dashboard/venue/index')}}"> Venue </a></li>
                            <li> Space listing</li>
                        </ol>
                        <a href="{{url('company/dashboard/space/add/'.$venue->id)}}" class="get-btn"><span>Add Space</span></a>
                        <input type="hidden" value="{{$venue->id}}" id="venue_id" />
                    </div>
                    <div class="booking-wrap">
                        <div class="tabs">
                            <div class="tab-button-outer">
                                <div class="full-col book-result">
                                    <ul id="tab-button" class="booking-tab col-sm-7">
                                        @foreach($space_types as $key=>$space_type)
                                            <li class="space-tab-area {{$key==0 ? 'is-active' : ''}}" id="{{$space_type->id}}"><a href="#inner_tab_{{$space_type->id}}">{{$space_type->title}}</a></li>
                                        @endforeach
                                    </ul>
                                    <div class="col-sm-5 book-result-form">
                                        {{--<form action="#" method="post">--}}
                                        <div class="col-xs-4 book-cata-feild form-group">
                                            <select id="orderby" class="selectpicker" onchange="search_spaces()">
                                                <option value="">Sort by</option>
                                                <option value="asc">Accending Order</option>
                                                <option value="desc">Deccending Order</option>
                                            </select>
                                        </div>
                                        <div class="col-xs-8 form-group">
                                            {{--<form id="searching" method="get">--}}
                                            @csrf
                                            <input id="search" type="text"  name="date" placeholder="Search" class="form-control" onkeyup="search_spaces()">
                                            {{--</form>--}}
                                        </div>
                                        {{--</form>--}}
                                    </div>
                                </div>
                            </div>
                            @include('site.layouts.session_messages')
                            @foreach($space_types as $key=>$space_type)
                                @php $spaces =  paginate(to_array($space_type->spaces->where('venue_id', $venue->id)),6); @endphp
                                <div id="inner_tab_{{$space_type->id}}" class="tab-contents search-result vaneu-booking {{$key==0 ? 'is-active' : ''}}">
                                    @if(count($spaces) > 0)
                                        @foreach($spaces as $space)
                                            <div class="book-list" id="space_box_{{$space->id}}">
                                                <div class="b-list-img col-sm-2">
                                                    <img src="{{url('storage/images/spaces/'.$space->image)}}" alt="">
                                                </div>
                                                <div class="b-list-info col-sm-4">
                                                    <h3>{{$space->title}}</h3>
                                                </div>
                                                <div class="b-list-rate col-sm-2">
                                                    @php
                                                        $json = json_decode($space->reviews_count);
                                                        $total_average_percentage = ($json[4]/5) * 100;
                                                    @endphp
                                                    {{$json[4]}}
                                                    @php echo get_stars_view($json[4]); @endphp
                                                </div>
                                                <div class="vanu-edit col-sm-2">
                                                    <a href="#" onclick="show_delete({{$space->id}})" class="del-btn"><img src="{{url('images/delete.png')}}" alt="edit"></a>
                                                    <a href="{{url('company/dashboard/space/edit/'.$space->id)}}" class="edit-btn"><img src="{{url('images/edit.png')}}" alt="edit"></a>
                                                </div>
                                                <div class="b-list-btn col-sm-2">
                                                    <a href="{{url('venue/space/'.$space->slug)}}" class="btn get-btn">
                                                        <span> View Space </span><span></span><span></span><span></span><span></span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    {{$spaces->links()}}
                                </div>
                            @endforeach

                        </div>

                    </div><!--wrapper-->
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
                    <form id="delete_space_form">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" id="delete_space_id">
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
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}
@section('scripts')
    @include('site.layouts.scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>--}}

    <script>

        function show_delete(id)
        {
            $('#delete_space_id').val(id);
            $('#delpopup').modal('toggle');
        }
        $("#delete_space_form").validate({
            submitHandler: function(form) {
                $.ajax({
                    type: 'delete',
                    data: $('#delete_space_form').serialize(),
                    url: '{{url('/company/dashboard/space/delete')}}',
                    success: function (response) {
                        console.log(response);
                        $('#delpopup').modal('toggle');

                        if (response.success !== '') {
                            $('#flash_massage').html(response.success);
                            var space_div_id = '#space_box_'+$('#delete_space_id').val();
                            $(space_div_id).remove();
                        } else {
                            $('#flash_massage').html(response.error);
                        }
                    }
                });
            }
        });

        $('.add-spaces').click(function () {
            var hv = $('#venue_space_id').val();
            $('#add_venue_space_id').val(hv);
        });
        var space_id = $('#space_id').val();
        function edit_space(space_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/ajax/edit-space')}}',
                type: 'get',
                datatype: 'json',
                data: {
                    space_id: space_id,
                },
                success: function (response) {

                    console.log(response);
                    $('#add_space_title').val(response.title);
                    $('#add_space_description').val(response.description);
                    //  $('#inner-tab-button').html(response.tab_buttons);
                    // $('#inner_tabs_data').html(response.data);
                    // reset_inner_classes();
                }
            });
        }
    </script>
    <script type="text/javascript">
        {{--$('#search').on('keyup',function(){--}}
        {{--$value=$(this).val();--}}

        {{--$.ajax({--}}
        {{--type : "GET",--}}
        {{--url : "{{ route('company.dashboard.space.listingsearch') }}",--}}
        {{--data:{'search':$value},--}}
        {{--success:function(data){--}}
        {{--console.log(data);--}}
        {{--// exit();--}}
        {{--$('.search-result').html(data);--}}
        {{--}--}}
        {{--});--}}
        {{--})--}}
    </script>
    <script type="text/javascript">
        function search_spaces(){
            var space_type_id = '';
            if($('.space-tab-area').hasClass('is-active')){
                space_type_id = $('.is-active').attr('id');
            }
            var search = $('#search').val();
            var search_orderby = $('#orderby').val();
            var venue_id = {{$venue_id}};
            $.ajax({
                type : "GET",
                url : "{{ route('company.dashboard.space.listingsearch') }}",
                data:{'search':search,'activetab':search_orderby,'space_type_id':space_type_id, 'venue_id': venue_id},
                success:function(data){
                    console.log('inner_tab_'+space_type_id);
                    $('#inner_tab_'+space_type_id).html(data);
                }
            });
        }
        {{--$('#orderby').change('keyup',function(){--}}
        {{--$value=$(this).val();--}}
        {{--$Activetab = $('.search-result.is-active').attr('id');--}}
        {{--$venue=$('#venue_id').val();--}}

        {{--//alert($Activetab);--}}
        {{--//exit();--}}
        {{--$.ajax({--}}
        {{--type : "GET",--}}
        {{--url : "{{ route('company.dashboard.space.listingsort') }}",--}}
        {{--data:{'sort':$value,'activetab':$Activetab,'venue_id':$venue},--}}
        {{--success:function(data){--}}
        {{--console.log(data);--}}
        {{--// exit();--}}
        {{--$('.booking-wrap').html(data);--}}
        {{--}--}}
        {{--});--}}
        {{--})--}}
    </script>

@endsection
