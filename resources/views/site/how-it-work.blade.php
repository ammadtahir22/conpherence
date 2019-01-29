@extends('site.layouts.app')

@section('head')
	{{--<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>--}}
@endsection

@section('header-class', 'home-header')

@section('header')
	@include('site.layouts.header')
@endsection

@section('content')
	<section class="banner sub-banner how-banner">
		<div class="container">
			<div class="col-xs-12 banner_info fade-down-ani">
				<h1>Discover great places to meet</h1>
				<h3>Book over 130,000 meeting spaces online now</h3>
				<img src="images/bar.png" alt="" />
			</div>
		</div>
			<div class="clearfix"></div>
	</section>
	<section class="how-section">
		<div class="container">
			<div class="how-wrap">
				<div class="how-img how-r-img col-sm-7 fade-right-ani">
					<img src="images/how-img.png" alt="" />
				</div>
				<div class="how-info col-sm-5 fade-left-ani">
					<h3>Search Verified Places </h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
				</div>
				<div class="how-img col-sm-7 fade-left-ani">
					<img src="images/how-img.png" alt="" />
				</div>
				<div class="how-info col-sm-5 fade-right-ani">
					<h3>Select Your Place</h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
				</div>
				<div class="how-img how-r-img col-sm-7 fade-left-ani">
					<img src="images/how-img.png" alt="" />
				</div>
				<div class="how-info col-sm-5 fade-right-ani">
					<h3>Book Online</h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
				</div>
			</div>
			<div class="how-txt fade-down-ani">
				<h3>Lorem Ipsum</h3>
				<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
			</div>
		</div>
		<div class="clearfix"></div>
	</section>
@endsection

@section('site.footer')
    @include('site.layouts.footer')
@endsection

@section('site.scripts')
    @include('site.layouts.scripts')
@endsection




