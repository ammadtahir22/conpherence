@extends('site.layouts.app')

@section('head')
    {{--<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>--}}


@endsection

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="contact-section">
        <div class="container">
            <div class="wrap">
                <div class="contact-left col-sm-6">
                    <h3>Contact Us</h3>
                    <p>Reach out to us for any inquiry</p>
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <form id="contactus" method="post" action="{{route('contactus.store')}}">
                        @csrf

                        <div class="form-group">
                            <input type="text" name="name" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Message" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn get-btn"><span>Contact Now</span><span></span><span></span><span></span><span></span></button>
                        </div>
                    </form>
                </div>
                <div class="contact-right col-sm-6">
                    <div id="map" class="mapwrap"></div>
                </div>
                <div class="contact-info full-col">
                    <div class="contact-detail col-xs-4">
                        <div class="contact-detail-img">
                            <img src="{{url('images/contact-icon.png')}}">
                        </div>
                        <div class="contact-detail-info">
                            <h4>Phone Number:</h4>
                            <p>0971 215 02548</p>
                        </div>
                    </div>
                    <div class="contact-detail contact-detail-mid col-xs-4">
                        <div class="contact-detail-img">
                            <img src="{{url('images/contact-icon1.png')}}">
                        </div>
                        <div class="contact-detail-info">
                            <h4>Email:</h4>
                            <p><a href="mailto:info@conpherence.com">info@conpherence.com</a></p>
                        </div>
                    </div>
                    <div class="contact-detail contact-detail-right col-xs-4">
                        <div class="contact-detail-img">
                            <img src="{{url('images/contact-icon2.png')}}">
                        </div>
                        <div class="contact-detail-info">
                            <h4>Location:</h4>
                            <p>Building name, 2nd Floor, <br/>office # 14</p>
                        </div>
                    </div>
                </div>
            </div><!-- container -->
            <div class="clearfix"></div>
        </div>
    </section>

@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
        $("#contactus").validate({
            messages: {
                name: {
                    required: "Name is required",
                },
                email: {
                    required: "Email address is required",
                    email: "Should be a valid email address"
                },
                message: {
                    required: "Message is required",
                }
            }
        });
    </script>
    <script type="text/javascript">
        // When the window has finished loading create our google map below
        google.maps.event.addDomListener(window, 'load', init);

        function init() {
            // Basic options for a simple Google Map
            // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
            var mapOptions = {
                // How zoomed in you want the map to start at (always required)
                zoom: 15,

                // The latitude and longitude to center the map (always required)
                center: new google.maps.LatLng(25.099448, 55.161948), // New York

                // How you would like to style the map.
                // This is where you would paste any style found on Snazzy Maps.

            };

            // Get the HTML DOM element that will contain your map
            // We are using a div with id="map" seen below in the <body>
            var mapElement = document.getElementById('map');

            // Create the Google Map using our element and options defined above
            var map = new google.maps.Map(mapElement, mapOptions);

            // Let's also add a marker while we're at it

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(25.099448, 55.161948),
                map: map,
                title: 'Snazzy!',
                icon: '{{url('images/locator1.png')}}'
            });

        }
    </script>

@endsection




