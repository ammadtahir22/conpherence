@extends('site.layouts.app')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    <script type="text/javascript" src="{{url('js/jquery.validate.min.js')}}"></script>
@endsection

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="dashboard">
        <div class="tabbable tabs-left">
            <aside class="dashboard-sidebar">
                <ul class="nav nav-tabs ">
                    <li ><a href="#dashboard" data-toggle="tab"><img src="{{url('images/dash-iconh.png')}}" alt="" /><span>Dashboard</span></a></li>
                    <li class="active"><a href="#profile" data-toggle="tab"><img src="{{url('images/dash-iconh7.png')}}" alt="" /><span>Edit Profile</span></a></li>
                    <li><a href="#venue" data-toggle="tab" ><img src="{{url('images/dash-iconh8.png')}}" alt="" /><span>Venue</span></a></li>
                    <li><a href="#payment" data-toggle="tab"><img src="{{url('images/dash-iconh2.png')}}" alt="" /><span>Payment</span></a></li>
                    <li><a href="#bookings" data-toggle="tab"><img src="{{url('images/dash-iconh3.png')}}" alt="" /><span>Bookings</span></a></li>
                    <li><a href="#reviews" data-toggle="tab"><img src="{{url('images/dash-iconh4.png')}}" alt="" /><span>Reviews</span></a></li>
                    <li><a href="#savings"data-toggle="tab" ><img src="{{url('images/dash-iconh.png')}}" alt="" /><span>Savings</span></a></li>
                </ul>
                <button class="sidebar-toggle"><span></span></button>
            </aside>
            <div class="tab-content dashboard-wrap">


                @include('site.layouts.session_messages')

                @include('site.companies.dashboard_pages.dashboard')
                @include('site.companies.dashboard_pages.profile')
                @include('site.companies.dashboard_pages.venue')
                @include('site.companies.dashboard_pages.add_venue')
                @include('site.companies.dashboard_pages.space')
                @include('site.companies.dashboard_pages.add_space')
                @include('site.companies.dashboard_pages.payment')
                @include('site.companies.dashboard_pages.bookings')
                @include('site.companies.dashboard_pages.reviews')
                @include('site.companies.dashboard_pages.savings')
            </div>
        </div>
        <!-- /tabs -->
        <div class="clearfix"></div>
    </section>

    <!-- add cuisine popup -->
    <div class="modal fade cuisine-popup" id="cuisine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3>Cuisine / Food Menu</h3>
                    <div class="form-group cuisine-full">
                        <input type="text" name="" placeholder="Category Name" class="form-control">
                    </div>
                    <h5>Add Item <a href="#" class="hotal-addbtn">Add</a></h5>
                    <div class="form-group cuisine-helf">
                        <input type="text" name="" placeholder="Chicken Tagine" class="form-control">
                    </div>
                    <div class="form-group cuisine-helf">
                        <div class="currency-field">
                            <select>
                                <option>AED</option>
                                <option>AED</option>
                            </select>
                            <input type="number" name="" placeholder="Price" class="form-control ">
                        </div>
                    </div>
                    <div class="form-group cuisine-helf">
                        <input type="number" name="" placeholder="Chicken Tagine" class="form-control">
                    </div>
                    <div class="form-group cuisine-helf">
                        <div class="currency-field">
                            <select>
                                <option>AED</option>
                                <option>AED</option>
                            </select>
                            <input type="text" name="" placeholder="Price" class="form-control Search-location">
                        </div>
                    </div>
                    <div class="form-group form-btn">
                        <button type="button" class="btn ani-btn">Add</button>
                    </div>
                    <div class="form-group form-btn">
                        <button type="button" class="btn ani-btn cancle-btn">Cancel</button>
                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>

    <script type="text/javascript">
        //select
        $(".js-select2-multi").select2({
            templateResult: formatState,
            templateSelection: formatState,
            placeholder: "Select a Item",
            allowClear: true
        });

        function formatState (opt) {
            if (!opt.id) {
                return opt.text.toUpperCase();
            }

            var optimage = $(opt.element).attr('data-image');
            console.log(optimage)
            if(!optimage){
                return opt.text.toUpperCase();
            } else {
                var $opt = $(
                        '<span><img src="' + optimage + '" width="60px" /> ' + opt.text.toUpperCase() + '</span>'
                );
                return $opt;
            }
        };
        $('.js-select2-multi').on('select2:open', function(){

            $('.select2-dropdown--above .select2-search--dropdown').insertAfter('.select2-results');
        });
    </script>
    <script>

        {{--//image gallery plugin--}}
        {{--$("#image_gallery").fileinput({--}}
            {{--uploadUrl:  "{{ url('storage/images/venues/') }}",--}}
            {{--dropZoneEnabled: false,--}}
            {{--maxFileCount: 4,--}}
            {{--validateInitialCount: true,--}}
            {{--overwriteInitial: false,--}}
            {{--initialPreview: [--}}

            {{--],--}}
            {{--initialPreviewConfig: [--}}
                {{--{--}}
                    {{--fileType: 'image',--}}
                    {{--previewAsData: true,--}}
                {{--}--}}
            {{--],--}}
            {{--allowedFileExtensions: ["jpg", "png", "gif"],--}}
            {{--showUpload: false, // The "Upload" button--}}
            {{--allowedPreviewTypes: ['image'],--}}
        {{--});--}}

        function show_spaces(venue_id)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/ajax/get-spaces')}}',
                type: 'get',
                datatype: 'json',
                data: {
                    venue_id: venue_id,
                },
                success: function (response) {

                   // console.log(response);
                    $('#inner-tab-button').html(response.tab_buttons);
                    $('#inner_tabs_data').html(response.data);
                    reset_inner_classes();
                }
            });
        }


        //reset spaces inner tabs
        function reset_inner_classes() {
            var $tabButtonItem = $('#inner-tab-button li'),
                $tabSelect = $('#inner-tab-select'),
                $tabContents = $('.inner-tab-contents'),
                activeClass = 'is-active';

            $tabButtonItem.first().addClass(activeClass);
            $tabContents.not(':first').hide();

            $tabButtonItem.find('a').on('click', function (e) {
                var target = $(this).attr('href');

                $tabButtonItem.removeClass(activeClass);
                $(this).parent().addClass(activeClass);
                $tabSelect.val(target);
                $tabContents.hide();
                $(target).show();
                e.preventDefault();
            });

            $tabSelect.on('change', function () {
                var target = $(this).val(),
                    targetSelectNum = $(this).prop('selectedIndex');

                $tabButtonItem.removeClass(activeClass);
                $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
                $tabContents.hide();
                $(target).show();
            });
        }
        //Mehran spaces tabs


        $(document).ready(function() {
            hide_alert();
        });
        function hide_alert()
        {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000); // <-- time in milliseconds
        }

        $("#save_card").validate({
            rules: {
                card_number: {
                    required: true,
                    minlength: 16,
                    maxlength: 16
                },
                card_month: {
                    required: true
                },
                card_year: {
                    required: true,
                },
                card_security_code: {
                    required: true,
                    minlength: 3
                },
                card_currency: {
                    required: true,
                },
                card_first_name: {
                    required: true
                },
                card_last_name: {
                    required: true
                },
                card_email: {
                    required: true
                },
                card_address: {
                    required: true
                },
            },
            messages: {
                card_number: {
                    required: "Card Number is Required",
                    minlength: "Card Length should be equal to 16",
                    maxlength: "Card Length should be equal to 16"
                },
                card_month: {
                    required: "Please select Month first",
                },
                card_year: {
                    required: "Please select Year first",
                },
                card_security_code: {
                    required: "Security Code is Required",
                    minlength: "Minimum Security Code Length 3",
                },
                card_currency: {
                    required: "Currency is Required",
                },
                card_first_name: {
                    required: "First Name is Required",
                },
                card_last_name: {
                    required: "Last Name is Required",
                },
                card_email: {
                    required: "Email is Required",
                },
                card_address: {
                    required: "Address is Required",
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    data: $('#save_card').serialize(),
                    url: '{{url('/save_credit_card')}}',
                    success: function (response) {
                        $('#save_card').trigger("reset");
                        $('#cardpopup').modal('toggle');
                        $('#credit_cards').html(response.data);

                        // $("#credit_cards").load(" #credit_cards");


                        if (response.error.length > 0) {
                            var error_html = '';
                            for (var count = 0; count < data.error.length; count++) {
                                error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                            }
                            $('#flash_massage').html(error_html);
                        } else {
                            $('#flash_massage').html(response.success);

                        }

                        // $('.flash_message').empty();
                        // if(data.flag == 1){
                        //     $('.flash_message').append('<p class="text-success">Sucessfully Password Changed!</p>');
                        // }else if(data.flag == 0){
                        //     $('.flash_message').append('<p class="text-danger">Your Old Password Not Found</p>');
                        // }
                        // $("form")[0].reset();
                    }
                });
            }
        });

        $("#edit_card").validate({
            rules: {
                card_number: {
                    required: true,
                    minlength: 16,
                    maxlength: 16
                },
                card_month: {
                    required: true
                },
                card_year: {
                    required: true,
                },
                card_security_code: {
                    required: true,
                    minlength: 3
                },
                card_currency: {
                    required: true,
                },
                card_first_name: {
                    required: true
                },
                card_last_name: {
                    required: true
                },
                card_email: {
                    required: true
                },
                card_address: {
                    required: true
                },
            },
            messages: {
                card_number: {
                    required: "Card Number is Required",
                    minlength: "Card Length should be equal to 16",
                    maxlength: "Card Length should be equal to 16"
                },
                card_month: {
                    required: "Please select Month first",
                },
                card_year: {
                    required: "Please select Year first",
                },
                card_security_code: {
                    required: "Security Code is Required",
                    minlength: "Minimum Security Code Length 3",
                },
                card_currency: {
                    required: "Currency is Required",
                },
                card_first_name: {
                    required: "First Name is Required",
                },
                card_last_name: {
                    required: "Last Name is Required",
                },
                card_email: {
                    required: "Email is Required",
                },
                card_address: {
                    required: "Address is Required",
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    data: $('#edit_card').serialize(),
                    url: '{{url('/save_credit_card')}}',
                    success: function (response) {
                        $('#edit_card').trigger("reset");
                        $('#editpopup').modal('toggle');
                        $('#credit_cards').html(response.data);

                        // $("#credit_cards").load(" #credit_cards");


                        if (response.error.length > 0) {
                            var error_html = '';
                            for (var count = 0; count < data.error.length; count++) {
                                error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                            }
                            $('#flash_massage').html(error_html);
                        } else {
                            $('#flash_massage').html(response.success);

                        }

                        // $('.flash_message').empty();
                        // if(data.flag == 1){
                        //     $('.flash_message').append('<p class="text-success">Sucessfully Password Changed!</p>');
                        // }else if(data.flag == 0){
                        //     $('.flash_message').append('<p class="text-danger">Your Old Password Not Found</p>');
                        // }
                        // $("form")[0].reset();
                    }
                });
            }
        });

        $("#delete_card").validate({
            submitHandler: function(form) {
                $.ajax({
                    type: 'delete',
                    data: $('#delete_card').serialize(),
                    url: '{{url('/edit/card/delete')}}',
                    success: function (response) {
                        $('#delpopup').modal('toggle');

                        if(response.data !== ''){
                            $('#credit_cards').html(response.data);
                        }


                        if (response.success !== '') {
                            $('#flash_massage').html(response.success);
                        } else {
                            $('#flash_massage').html(response.error);
                        }
                    }
                });
            }
        });

        $("#password_form").validate({
            rules:{
                current_password: {
                    required: true,
                    minlength: 6
                },
                new_password: {
                    required: true,
                    minlength: "6",
                },
                confirmed : {
                    required: true,
                    minlength : 6,
                    equalTo : "#new_password"
                }
            },
            messages: {
                current_password: {
                    required: "Current Password is Required",
                    minlength: "Minimum length is 6"
                },
                new_password: {
                    required: "New Password is Required",
                    minlength: "Minimum length is 6"
                },
                confirmed: {
                    required: "Please Confirm your Password",
                    equalTo: 'Must be equal to new password'
                }
            }
        });

        $("#profile_form").validate({
            messages: {
                name: {
                    required: "Please enter your name first",
                    minlength: "Name Length should be more then 2"
                },
                email: {
                    required: "Email address is required",
                    email: "Should be a valid email address"
                },
                phone_number: {
                    required: "Phone number is required",
                },
            }
        });


        //Clear Form

        /* $('.modal-dialog').on('.close', function() {
             var $alertas = $('#alertas');
             $alertas.validate().resetForm();
             $alertas.find('.error').removeClass('error');
         }); */


        $('#cardpopup').on('hidden.bs.modal', function () {
            $('#save_card').validate().resetForm();
            $('.error').removeClass('error');
        });

        $(".close").click(function() {
            validator.resetForm();
        });

        //upload profile photo
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
        });

        $(".file-upload-input").change(function (){
            var fileName = $(this).val();
            if(fileName)
            {
                $('#file_remove').css("display", "block");
                $('#file_save').css("display", "block");
                $('#file_upload').css("display", "none");
            } else {
                $('#file_remove').css("display", "none");
                $('#file_save').css("display", "none");
                $('#file_upload').css("display", "block");
            }
        });

        function removeUpload() {
            var baseUrl = '@php echo url('images/edit-profile.png'); @endphp';
            $('.file-upload-input').val('');
            $('.file-upload-image').attr("src",baseUrl);


            $('.image-upload-wrap').css("display", "block");

            $('#file_remove').css("display", "none");
            $('#file_save').css("display", "none");

            $('#file_upload').css("display", "block");
        }
        //end upload profile photo

        //Make dates required
        function makeDateRequired()
        {
            $(".date-dob").each(function() {
                $(this).prop('required', true);
            });
        }

        //edit credit card
        function show_edit(id)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/edit/credit_card')}}',
                type: 'get',
                datatype: 'json',
                data: {
                    id: id,
                },
                success: function (response) {
                    $('#modal_card_id').val(response.data.id);
                    $('#modal_card_number').val(response.data.card_number);
                    $('#modal_card_month').val(response.data.month);
                    $('#modal_card_year').val(response.data.year);
                    $('#modal_card_security_code').val(response.data.security_code);
                    $('#modal_card_currency').val(response.data.currency);
                    $('#modal_card_first_name').val(response.data.first_name);
                    $('#modal_card_last_name').val(response.data.last_name);
                    $('#modal_card_email').val(response.data.email);
                    $('#modal_card_address').val(response.data.address);
                }
            });
        }

        //delete credit card
        function show_delete(id)
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/edit/credit_card')}}',
                type: 'get',
                datatype: 'json',
                data: {
                    id: id,
                },
                success: function (response) {
                    $('#delete_card_id').val(response.data.id);
                }
            });
        }


        function previewImages() {
            var preview = $('#preview').empty();


            if (this.files) $.each(this.files, readAndPreview);
            function readAndPreview(i, file) {


                if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return alert(file.name +" is not an image");
                } // else...

                var reader = new FileReader();

                $(reader).on("load", function(){

                    // preview.append($("<div class='item active'>" +
                    //     "<div class='hotal-image' id='hotal-image'"+
                    //     "<a href='#' class='img-del'>X</a>" +
                    //
                    //     "</div>" +
                    //     "</div>"));
                    //
                    //
                    // $('.hotal-image').each(function(i, obj) {
                    //     $(this).append($("<img/>", {src:this.result, height:100}));
                    // });

                    preview.append($("<img/>", {src:this.result, height:100}));

                });

                reader.readAsDataURL(file);


            }

        }

        $('#selected_space_images').on("change", previewImages);




        //venue map
        function initialize() {
            var initialLat = $('.search_latitude_venue').val();
            var initialLong = $('.search_longitude_venue').val();
            initialLat = initialLat?initialLat:31.5629793;
            initialLong = initialLong?initialLong:74.3308058;

            var latlng = new google.maps.LatLng(initialLat, initialLong);
            var options = {
                zoom: 16,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            map = new google.maps.Map(document.getElementById("map_venue"), options);

            geocoder = new google.maps.Geocoder();

            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                position: latlng
            });


            google.maps.event.addListener(marker, "dragend", function () {
                var point = marker.getPosition();
                map.panTo(point);
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        $('.search_address_venue').val(results[0].formatted_address);
                        $('.search_latitude_venue').val(marker.getPosition().lat());
                        $('.search_longitude_venue').val(marker.getPosition().lng());
                    }
                });
            });

        }
        $(document).ready(function () {
            //load google map
            initialize();

            /*
             * autocomplete location search
             */
            var PostCodeid = '#searchmap_venue';
            $(function () {
                $(PostCodeid).autocomplete({
                    source: function (request, response) {
                        geocoder.geocode({
                            'address': request.term
                        }, function (results, status) {
                            response($.map(results, function (item) {
                                return {
                                    label: item.formatted_address,
                                    value: item.formatted_address,
                                    lat: item.geometry.location.lat(),
                                    lon: item.geometry.location.lng()
                                };
                            }));
                        });
                    },
                    select: function (event, ui) {
                        $('.search_address_venue').val(ui.item.value);
                        $('.search_latitude_venue').val(ui.item.lat);
                        $('.search_longitude_venue').val(ui.item.lon);
                        var latlng = new google.maps.LatLng(ui.item.lat, ui.item.lon);
                        marker.setPosition(latlng);
                        initialize();
                    }
                });
            });

            /*
             * Point location on google map
             */
            $('.get_map').click(function (e) {
                var address = $(PostCodeid).val();
                geocoder.geocode({'address': address}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        marker.setPosition(results[0].geometry.location);
                        $('.search_address_venue').val(results[0].formatted_address);
                        $('.search_latitude_venue').val(marker.getPosition().lat());
                        $('.search_longitude_venue').val(marker.getPosition().lng());
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
                e.preventDefault();
            });

            //Add listener to marker for reverse geocoding
            google.maps.event.addListener(marker, 'drag', function () {
                geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('.search_address_venue').val(results[0].formatted_address);
                            $('.search_latitude_venue').val(marker.getPosition().lat());
                            $('.search_longitude_venue').val(marker.getPosition().lng());
                        }
                    }
                });
            });
        });


    </script>
    <script>



    </script>

@endsection