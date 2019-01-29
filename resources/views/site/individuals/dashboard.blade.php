@extends('site.layouts.app')
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
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
                    <li ><a href="#dashboard" data-toggle="tab"><img src="{{url('images/dash-iconh.png')}}" alt="" /><span>Dashboard</span></a></li>
                    <li class="active"><a href="#profile" data-toggle="tab"><img src="{{url('images/dash-iconh1.png')}}" alt="" /><span>Edit Profile</span></a></li>
                    <li><a href="#payment" data-toggle="tab"><img src="{{url('images/dash-iconh2.png')}}" alt="" /><span>Payment</span></a></li>
                    <li><a href="#bookings" data-toggle="tab"><img src="{{url('images/dash-iconh3.png')}}" alt="" /><span>Bookings</span></a></li>
                    <li><a href="#reviews" data-toggle="tab"><img src="{{url('images/dash-iconh4.png')}}" alt="" /><span>Reviews</span></a></li>
                    <li><a href="#team" data-toggle="tab"><img src="{{url('images/dash-iconh5.png')}}" alt="" /><span>Team Management</span></a></li>
                    <li><a href="#savings"data-toggle="tab" ><img src="{{url('images/dash-iconh.png')}}" alt="" /><span>Savings</span></a></li>
                </ul>
                <button class="sidebar-toggle"><span></span></button>
            </aside>
            <div class="tab-content dashboard-wrap">
                    @include('site.layouts.session_messages')
                    @include('site.individuals.dashboard_pages.dashboard')
                    @include('site.individuals.dashboard_pages.profile')
                    @include('site.individuals.dashboard_pages.payment')
                    @include('site.individuals.dashboard_pages.bookings')
                    @include('site.individuals.dashboard_pages.reviews')
                    @include('site.individuals.dashboard_pages.team')
                    @include('site.individuals.dashboard_pages.savings')
            </div>
        </div>
        <!-- /tabs -->
        <div class="clearfix"></div>
    </section>

    <!-- add card popup -->
    <div class="modal fade card-popup" id="cardpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" onclick="myReset()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3>Add New Payment Method</h3>
                    <form id="save_card">
                        @csrf
                        <div class="form-group full-field">
                            <input type="number" name="card_number" id="card_number" placeholder="Card number" class="form-control">
                        </div><!--form-group-->
                        <legend>Expires on</legend>
                        <div class="form-group half-l-field">
                            <select class="selectpicker" name="card_month" id="card_month">
                                <option selected disabled value="">-- Select a month --</option>
                                @foreach($months as $month)
                                    <option value="{{$month}}">{{$month}}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->
                        <div class="form-group half-r-field">
                            <select class="selectpicker" name="card_year" id="card_year">
                                <option selected disabled value="">-- Select a year --</option>
                                @foreach($card_years as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->
                        <div class="form-group half-l-field">
                            <input type="text" name="card_security_code" id="card_security_code" placeholder="Security Code" class="form-control">
                        </div><!--form-group-->
                        <div class="form-group half-r-field">
                            <select class="selectpicker" name="card_currency" id="card_currency">
                                <option selected disabled value="">-- Select a currency --</option>
                                @foreach($currencies as $kay=>$currency)
                                    <option value="{{$kay}}">{{$currency}}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->
                        <div class="form-group half-l-field">
                            <input type="text"  name="card_first_name" id="card_first_name" placeholder="First Name" class="form-control">
                        </div><!--form-group-->
                        <div class="form-group half-r-field">
                            <input type="text" name="card_last_name" id="card_last_name" placeholder="Last Name" class="form-control">
                        </div><!--form-group-->
                        <!--<div class="form-group full-field">-->
                        <!--    <input type="email" name="card_email" id="card_email" placeholder="Email" class="form-control">-->
                        <!--</div><!--form-group-->
                        <div class="form-group full-field">
                            <input type="text" name="card_address" id="card_address" placeholder="Billing Address" class="form-control">
                        </div><!--form-group-->
                        <div class="form-group form-btn half-l-field">
                            <button type="submit" class="btn ani-btn" id="add_card">Add Card</button>
                        </div>
                        <div class="form-group form-btn half-r-field">
                            <button type="button" class="btn ani-btn cancle-btn" onclick="myReset()" data-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit card popup -->
    <div class="modal fade card-popup" id="editpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h3>Update Payment Method</h3>
                    <form id="edit_card">
                        @csrf
                        <input type="hidden" name="id" value="" id="modal_card_id">
                        <div class="form-group full-field">
                            <input type="text" name="card_number" id="modal_card_number" placeholder="Card number" class="form-control">
                        </div><!--form-group-->
                        <legend>Expires on</legend>
                        <div class="form-group half-l-field">
                            <select class="selectpicker" name="card_month" id="modal_card_month">
                                <option selected disabled value="">-- Select a month --</option>
                                @foreach($months as $month)
                                    <option value="{{$month}}">{{$month}}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->
                        <div class="form-group half-r-field">
                            <select class="selectpicker" name="card_year" id="modal_card_year">
                                <option selected disabled value="">-- Select a year --</option>
                                @foreach($card_years as $year)
                                    <option value="{{$year}}">{{$year}}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->
                        <div class="form-group half-l-field">
                            <input type="text" name="card_security_code" id="modal_card_security_code" placeholder="Security Code" class="form-control">
                        </div><!--form-group-->
                        <div class="form-group half-r-field">
                            <select class="selectpicker" name="card_currency" id="modal_card_currency">
                                <option selected disabled value="">-- Select a currency --</option>
                                @foreach($currencies as $kay=>$currency)
                                    <option value="{{$kay}}">{{$currency}}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->
                        <div class="form-group half-l-field">
                            <input type="text"  name="card_first_name" id="modal_card_first_name" placeholder="First Name" class="form-control">
                        </div><!--form-group-->
                        <div class="form-group half-r-field">
                            <input type="text" name="card_last_name" id="modal_card_last_name" placeholder="Last Name" class="form-control">
                        </div><!--form-group-->
                        <!--<div class="form-group full-field">-->
                        <!--    <input type="email" name="card_email" id="modal_card_email" placeholder="Email" class="form-control">-->
                        <!--</div><!--form-group-->
                        <div class="form-group full-field">
                            <input type="text" name="card_address" id="modal_card_address" placeholder="Billing Address" class="form-control">
                        </div><!--form-group-->
                        <div class="form-group form-btn half-l-field">
                            <button type="submit" class="btn ani-btn" id="update_card">Update Card</button>
                        </div>
                        <div class="form-group form-btn half-r-field">
                            <button type="button" class="btn ani-btn cancel-btn" data-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                    <form id="delete_card">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" id="delete_card_id">
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


@section('scripts')
    @include('site.layouts.scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>

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
                // card_email: {
                //     required: true
                // },
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
                // card_email: {
                //     required: "Email is Required",
                // },
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
                // card_email: {
                //     required: true
                // },
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
                // card_email: {
                //     required: "Email is Required",
                // },
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
                    // $('#modal_card_email').val(response.data.email);
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
        

    </script>


@endsection