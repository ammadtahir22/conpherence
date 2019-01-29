@extends('site.layouts.app')

@section('head')
	{{--<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>--}}
@endsection

@section('header-class', 'home-header')

@section('header')
	@include('site.layouts.header')
@endsection

@section('content')
	<section class="banner sub-banner vanu-sub-banner">
		<div class="container">
			<div class="col-xs-12 banner_info fade-down-ani">
				<h1>Discover great places to meet</h1>
				<h3>Book over 130,000 meeting spaces online now</h3>
				<img src="images/bar.png" alt="" />
			</div>
			@include('site.layouts.search-banner')
		</div>
		<div class="clearfix"></div>
	</section>
	<!--Top Rated Section-->
	@foreach($data as $key => $first)
		@if(isset($first['venus']))
			@php if($key%2 == 0) $add_class = '';
			else $add_class = 'gray-catagory'; @endphp
            <div class="full-h-screen">
			<section class="rated-section rated-detail-section catagory-section {{$add_class}}">
				<div class="container">
					<div class="cata-info midtext fade-down-ani">
						<h2>{{$first['type']->title}}</h2>
						<p>{{$first['type']->description}}</p>
					</div>
					<div class="catagory-wrap row">
						@foreach($first['venus'] as $venue)
							{{--@php print_r($venue->id); @endphp--}}
							{{--@php  print_r($venue) @endphp--}}
							<div class="rated-box col-xs-3 fade-down-ani active" onclick="location.href='{{url('venue/'.$venue->slug)}}'" >
								<figure>
									<img src="{{url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image)}}" alt="" />
									@if($venue->top_rate == 1)
										<div class="top-rate">
											<img src="{{url('images/ribben.png')}}" alt=""/>
										</div>
									@endif
								</figure>
								<div class="rated-box-info">
									@if($venue->verified == 1)
										<h3>Verified by Conpherence</h3>
									@endif
										<h2>{{$venue->title}}</h2>
										<h4>{{$venue->city}}</h4>
									@php
										$averge = ($venue->reviews/5)*100;
                                       // echo $averge;
									@endphp
									<div class="star-bar">
										<h3>
											<div class="star-ratings-css">
												<div class="star-ratings-css-top" style="width: {{$averge}}%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
												<div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
											</div>
										</h3>
									</div>
								</div>
							</div><!-- rated-box -->
						@endforeach

						<div class="col-xs-12 rated-btn">
							<form action="{{url('venues/search')}}" method="GET" id="search_category_{{$first['type']->id}}">
								<input type="hidden" name="space_type" value="{{$first['type']->slug}}">
								<a class="get-btn black-btn" onclick="submitForm('search_category_{{$first['type']->id}}')">
									<span>Load more</span>
									<span></span>
									<span></span>
									<span></span>
									<span></span>
								</a>
							</form>
						</div>
					</div><!--catagpry-wrapper-->
				</div>
				<div class="clearfix"></div>
			</section>
    </div>
		@endif
	@endforeach

@endsection

@section('footer')
	@include('site.layouts.footer')
@endsection

@section('scripts')
	@include('site.layouts.scripts')
	<script>
        $("#venue_search_main").validate({
            rules: {
                location: {
                    required: true
                },
                people: {
                    required: true
                },
            },
            messages: {
                location: {
                    required: "Please select a Location",
                },
                people: {
                    required: "Attendees is Required",
                }
            }
        });


        function submitForm(id) {
            $("#"+id).submit();
        }

        // search city added
        var cities = {!! json_encode($cities) !!};
        var options = "";

        $(document).ready(function() {
            $.each(cities, function (key, value) {
                // console.log(value);
                options += '<option value="'+value+'">'+value+'</option>';
            });
            $("#Search-location").html(options);
        });

	</script>
@endsection




