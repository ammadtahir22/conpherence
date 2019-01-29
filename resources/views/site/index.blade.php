@extends('site.layouts.app')

@section('head')

@endsection

@section('header-class', 'home-header')

@section('header')
	@include('site.layouts.header')
@endsection

@section('content')

	<section class="banner">
		<div class="container">
			<div class="banner_inner full-col">
				<div class="col-xs-12 banner_info fade-down-ani">
					<h1>Let’s get you </br>  an ideal space for your meetings!</h1>
					<h3>Explore and reserve the spot-on meeting spaces worldwide.</h3>
					<img src="{{url('images/bar.png')}}" alt="" />
				</div>
			</div>
			@include('site.layouts.search-banner')
		</div>
		<div class="clearfix"></div>
	</section>
	<section class="about-section">
		<div class="container">
			<h2>Select the venue of your choice.</h2>
			<div class="row">

				@if(isset($spacetypes))
					@foreach($spacetypes as $key => $spacetype)
						@if($spacetype->title != 'Uncategorized')
							<div class="about-box col-sm-3 col-xs-6 fade-left-ani">
								<form action="{{url('venues/search')}}" method="GET" id="venue_search_category_{{$key}}">
									<input type="hidden" name="space_type" value="{{$spacetype->slug}}">
									<a class="ab-box-info" onclick="submitForm('venue_search_category_{{$key}}')">
										<img src="{{url('/storage/images/space-type/'.$spacetype->image)}}" alt=""/>
										<div class="ab-txt">
											<div class="ab-title">{{$spacetype->title}}</div>
											<img src="{{url('images/white-bar.png')}}" alt=""/>
										</div>
									</a>
								</form>
							</div>
						@endif
					@endforeach
				@endif

				<a href="{{url('/categories')}}" class="get-btn black-btn">
					<span>Load more</span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</a>

			</div><!--row-->
		</div><!--container-->
		<div class="clearfix"></div>
	</section>
	<!-- Why Choose Conpherence section -->
	<section class="why-section">
		<div class="container">
			<h2>Why Choose Conpherence?</h2>
			<p>Conpherence.com is a booking portal transforming the process by facilitating its clients with hassle-free, efficient and real-time automated bookings.</p>
			<div class="midtext wrap col-md-9">
				<div class="why-box col-sm-4 fade-left-ani">
					<div class="why-box-img">
						<img src="images/ser-icon.png" alt=""/>
					</div>
					<h3>Verified listings</h3>
					<p>
						We provide a list of verified meeting spaces that offer top-notch venue and menu facilities.
					</p>
				</div><!--why-box-->
				<div class="why-box col-sm-4 fade-down-ani">
					<div class="why-box-img">
						<img src="images/ser-icon1.png" alt=""/>
					</div>
					<h3>Real time booking</h3>
					<p>
						Our online booking system is designed to book your preferred meeting space with a few clicks.
					</p>
				</div><!--why-box-->
				<div class="why-box col-sm-4 fade-right-ani">
					<div class="why-box-img">
						<img src="images/ser-icon2.png" alt=""/>
					</div>
					<h3>Responsiveness</h3>
					<p>Our well-built system along with customer support caters your worries and queries around the clock.</p>
				</div><!--why-box-->
			</div><!--why-wrap-->
		</div><!--container-->
		<div class="clearfix"></div>
	</section>
	<!--Top Rated Section-->
	<section class="rated-section">
		<div class="container">
			<div class="rated-info midtext col-md-9">
				<h2>Top Rated Spaces</h2>
				{{--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>--}}
			</div>
			<div class="rated-wrap">
				<div class="owl-carousel owl-theme relat-slide">

					@if(isset($spaces))
						@foreach($spaces as $key => $space)
							<div class="item">
								<div class="rated-box full-rate-box">
									<figure>
										<img src="{{url('storage/images/spaces/'.$space->image)}}" alt="" />
										@if($space->top_rate == 1)
											<div class="top-rate">
												<img src="{{url('images/ribben.png')}}" alt=""/>
											</div>
										@endif

										<div class="favrt">
											@if(check_wish_list($space->id,'space'))
												@php $filled = 'block' @endphp
												@php $un_filled = 'none' @endphp
											@else
												@php $filled = 'none' @endphp
												@php $un_filled = 'block' @endphp
											@endif

											<img src="{{url('images/hearthover.png')}}" alt="" id="filled_space{{$space->id}}" style="display: {{$filled}};"
												 onclick="remove_item_wishlist('{{$space->id}}','space', this.id, 'un_filled_space{{$space->id}}')" class=""/>

											<img src="{{url('images/heart.png')}}" alt="" class="f-heart" id="un_filled_space{{$space->id}}" style="display: {{$un_filled}};"
												 onclick="save_item_wishlist('{{$space->id}}','space', this.id, 'filled_space{{$space->id}}')" />
										</div>
									</figure>
									<div class="rated-box-info">
										<div class="ra-detail col-xs-4">
											<div class="ra-star-bar full-col">
												<p>{{$space->reviews_total}}</p>
												@php echo get_stars_view($space->reviews_total); @endphp
												<em>{{get_space_reviews_count($space->id)}} reviews</em>
											</div>
											<div class="aed"><span>aed</span>{{$space->price}}</div>
										</div>
										<div class="ra-info col-xs-8">
											@if($space->verified == 1)
												<div class="Veri-box">Verified by Conpherence</div>
											@endif

											<h4>{{$space->venue->title}}</h4>
											<h2>{{$space->title}}</h2>
											<p>{{$space->venue->city}}</p>
											@if($space['cancel_cost'] <= 0)
												<p>Free Cancellation</p>
											@endif
										</div>
										<div class="full-col ra-feature">
											<div class="ra-l-half col-xs-12">
												<h5 class="head">Capacity</h5>
												@foreach($space->spaceCapacityPlan as $keys=>$cap)
													@php $image = get_sitting_plan_imagename($cap->sitting_plan_id);
													@endphp
													<p><img src=" {{url('storage/images/sitting-plan/'.$image)}}" alt="" data-toggle="tooltip" data-placement="auto" title="{{get_sitting_plan_name($cap->sitting_plan_id)}}"><span>{{$cap->capacity}}</span></p>
												@endforeach
											</div>
											<div class="ra-r-half col-xs-12">
												<h5 class="head">Free with this space</h5>
												{{--@php dump(json_decode($space->free_amenities)); @endphp--}}
												@if(!empty($space->free_amenities))
													@foreach(json_decode($space->free_amenities) as $amenity)
														@php $aimage = get_amenity_image($amenity);
																$amenity_name = get_amenity_name($amenity);
														@endphp
														<p><img src=" {{url('storage/images/amenities/'.$aimage)}}" alt="" data-toggle="tooltip" data-placement="auto" title="{{$amenity_name}}"></p>
													@endforeach
												@else
													<p> <span class="myspan">Amenities not available</span></p>
												@endif
												<a href="{{url('venue/space/'.$space->slug)}}" class="btn get-btn"><span>View Details</span><span></span><span></span><span></span><span></span> </a>
											</div>
										</div>
									</div>
								</div><!-- rated-box -->
							</div><!--item-->
						@endforeach
					@endif

				</div><!--slider-->
			</div>
		</div>
		<div class="clearfix"></div>
	</section>
	<section class="feature">
		<div class="container">
			<h2>Thousands of companies accommodation options</h2>
			<div class="owl-carousel owl-theme feature-slide">
				@if(isset($venues))
					@foreach($venues as $key => $venue)
						@if($venue->title != 'Uncategorized')
							<div class="item fade-down-ani">
								<a href="{{url('venue/'.$venue->slug)}}">
									<figure class="round-eff ">
										<img src="{{url('storage/images/venues/'.$venue->id.'/cover/'.$venue->cover_image)}}" alt="">
										<div class="overlay">
										</div>
									</figure>
									<div class="feature-info">
										<h2><span>{{$venue->title}}</span></h2>
										<h3>{{$venue->country}}, {{$venue->city}}</h3>
									</div>
								</a>
							</div>
						@endif
					@endforeach
				@endif



			</div>
		</div>
		<div class="clearfix"></div>
	</section>
	<section class="client-section">
		<div class="container">
			<div class="owl-carousel owl-theme client-slide">
				<div class="item">
					<div class="client-info fade-left-ani col-sm-6">
						<h3>What clients have to say</h3>
						<p>I am thankful to Conpherence.com for making my events and meetings a success with its innovative and facilitating booking services for event venue, group accommodations, parking and other services.<i>“</i></p>
						<h4><a href="#">Steve Jobs</a></h4>
					</div>
					<div class="client-img fade-right-ani col-sm-6">
						<img src="{{url('images/img4.png')}}" alt="" />
					</div><!-- client-img fade-right-ani -->
				</div><!-- item -->
				<div class="item">
					<div class="client-info fade-left-ani col-sm-6">
						<h3>What clients have to say</h3>
						<p>The venue technology and automated bookings that I experienced at Conpherence.com are one of its kind. It not only saved my time and money but also saved me from efforts that are involved in the manual bookings procedure.<i>“</i></p>
						<h4><a href="#">Jack Stephen</a></h4>
					</div>
					<div class="client-img fade-right-ani col-sm-6">
						<img src="{{url('images/img4.png')}}" alt="" />
					</div><!-- client-img fade-right-ani -->
				</div><!-- item -->
				<div class="item">
					<div class="client-info fade-left-anifade-left-ani col-sm-6">
						<h3>What clients have to say</h3>
						<p>At different occasions I have booked rooms through conpherence.com for interview, training and private workshops. The settings and services have been near to perfect. Thank you guys for making my meetings success stories.<i>“</i></p>
						<h4><a href="#">Fatima Hasan</a></h4>
					</div>
					<div class="client-img fade-right-ani col-sm-6">
						<img src="{{url('images/img4.png')}}" alt="" />
					</div><!-- client-img fade-right-ani -->
				</div><!-- item -->
				<div class="item">
					<div class="client-info fade-left-ani col-sm-6">
						<h3>What clients have to say</h3>
						<p>Conpherence.com’s meeting rooms and group accommodation services are so promising that all my guests were comfortable and enjoyed the quality times of their lives. Perfect rooms and services delivered by perfect staff. You guys rock!.<i>“</i></p>
						<h4><a href="#">Bilal Saeed</a></h4>
					</div>
					<div class="client-img fade-right-ani col-sm-6">
						<img src="{{url('images/img4.png')}}" alt="" />
					</div><!-- client-img fade-right-ani -->
				</div><!-- item -->
			</div><!-- client-slide -->
		</div>
		<div class="clearfix"></div>
	</section>
	<section class="testimoial">
		<div class="container">
			<div class="owl-carousel owl-theme testimoial-carousel">
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img1.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img2.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img3.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img4.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img1.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img2.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img3.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img4.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img1.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img2.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img3.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img4.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img1.png')}}" alt="" /></a>
				</div>
				<div class="item">
					<a href="#"><img src="{{url('images/slid-img2.png')}}" alt="" /></a>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
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
                options += '<option value="'+value+'">'+value+'</option>';
            });
            $("#Search-location").html(options);
        });

	</script>
@endsection

