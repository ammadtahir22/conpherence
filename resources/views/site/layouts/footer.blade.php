<footer class="footer">
    <div class="container">
        <div class="col-sm-4 col-xs-6 footer-info fade-left-ani">
            <a href="#"><img src="{{url('images/footer-logo.png')}}" alt="logo"/></a>
            <ul>
                <li><div class="foot-img"><img src="{{url('images/footer-icon.png')}}" alt="" /></div><div class="foot-info"><a href="#">0971 215 02548</a></div></li>
                <li><div class="foot-img"><img src="{{url('images/footer-icon1.png')}}" alt="" /></div><div class="foot-info"><a href="mailto:info@conpherence.com">info@conpherence.com</a></div></li>
                <li>
                    {{--<div class="foot-img"><img src="{{url('images/footer-icon2.png')}}" alt="" /></div><div class="foot-info">Payment options</div>--}}
                    {{--<ol>--}}
                        {{--<li><a href="#"><img src="{{url('images/Capa-1.png')}}" alt=""/></a></li>--}}
                        {{--<li><a href="#"><img src="{{url('images/Capa-2.png')}}" alt=""/></a></li>--}}
                    {{--</ol>--}}
                </li>
            </ul>
        </div>
        <div class="col-sm-2 col-xs-6 footer-link fade-down-ani">
            <ul>
                <li class=""><a href="{{url('/page/about-us')}}">About Us</a></li>
                <li><a href="{{url('/contact-us')}}">Contact Us</a></li>
                {{--<li><a href="{{url('/career')}}">Careers</a></li>--}}
                <li><a href="{{url('/page/how-it-works')}}">How it Works</a></li>
                {{--<li><a href="#">Company account</a></li>--}}
                {{--<li><a href="#">Strategic Meetings Management</a></li>--}}
            </ul>
        </div>
        <div class="col-sm-2 col-xs-6 footer-link fade-down-ani">
            <ul>
                {{--<li><a href="{{url('/blogs')}}">Blog</a></li>--}}
                {{--<li><a href="{{url('/news')}}">News</a></li>--}}
                <li><a href="{{url('/page/terms-of-use')}}">Terms Of Use</a></li>
                <li><a href="{{url('/page/privacy-policy')}}">Privacy Policy</a></li>
                {{--<li><a href="#">Venue Technology</a></li>--}}
                {{--<li><a href="#">White Paper</a></li>--}}
            </ul>
        </div>
        <div class="col-sm-4 col-xs-6 footer-search fade-right-ani">
            <h4>Let’s Stay in Touch</h4>
            <form id="subscribe" method="post">
                @csrf
                <span id="form_output"></span>
                <div class="col-xs-7 f-mail no_padding">
                    <input type="email" name="email" placeholder="Email Address" class="form-control">
                </div>
                <div class="col-xs-5 f-btn">
                    <button type="submit" name="submit" class="get-btn" >
                        <span>Subscribe</span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </form>

         <script type="text/javascript" src="https://code.jquery.com/jquery-1.8.3.min.js"></script>

            <script type="text/javascript">

                    $('#subscribe').on('submit', function(event){
                        event.preventDefault();
                        var form_data = $(this).serialize();
                        $.ajax({
                            url: "{{ route('subscribers') }}",
                            method: "POST",
                            data: form_data,
                            dataType:"json",
                            success: function(data) { // What to do if we succeed
                                if (data.error.length > 0) {
                                    var error_html = '';
                                    for (var count = 0; count < data.error.length; count++) {
                                        error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                                    }
                                    $('#form_output').html(error_html);
                                } else {
                                    $('#form_output').html(data.success);

                                }
                            }
                        });
                    });

            </script>
            <h4>Follow Us</h4>
            <ul class="social">
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="flaticon-google-plus-symbol google"></i></a></li>
                <li><a href="#"><i class="flaticon-linkedin-logo linkedin"></i></a></li>
                <li><a href="#"><i class="flaticon-youtube youtube"></i></a></li>
            </ul>
        </div>
    </div><div class="clearfix"></div>
    <div class="footer-btm">
        <div class="container">
            <div class="footer-btm-left col-sm-6">
                <ul>
                    <li>© 2018 conpherence.com</a></li>
                    <li><a href="#">All Rights Reserved</a></li>
                </ul>
            </div>
            <div class="footer-btm-right col-sm-6">
                <p>Powered by <a href="http://bits-global.com" target="_blank"><img src="{{url('images/bits.png')}}" alt="" /></a></p>
            </div>
        </div>
    </div>
</footer>


