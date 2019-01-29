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
                    @include('site.individuals.dashboard_nev',['active_payment' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active" id="payment">
                    <div class="welcome-title full-col">
                        <h2>Payment</h2>
                    </div>
                    <div class="dash-box dash-pay-left col-xs-6">
                        @include('site.layouts.session_messages')
                        <div id="flash_message_ajax">

                        </div>
                        <h3 class="dashboard-title">My Payment Methods</h3>
                        <a href="#" class="btn get-btn" data-toggle="modal" data-target="#cardpopup"><span>Add New</span><span></span><span></span><span></span><span></span></a>
                        <div class="dash-box-inner dash-pay-inner" id="credit_cards">
                            @if(count($credit_cards) > 0)
                                @foreach($credit_cards as $credit_card)
                                    <div class="pay-inner-card">
                                        <h4>Visa {{$credit_card->card_number}}</h4>
                                        <h5>Last charged 07/04/2018</h5>
                                        <a href="#" class="del-card" data-toggle="modal" data-target="#delpopup" onclick="show_delete({{$credit_card->id}})"><img src="{{url('images/delete.png')}}" alt=""></a>
                                        <a href="#" class="edit" data-toggle="modal" data-target="#editpopup" onclick="show_edit({{$credit_card->id}})"><img src="{{url('images/edit.png')}}" alt="" /></a>
                                        <div class="dash-pay-gray">
                                            <div class="dash-pay-l-gray col-xs-6">
                                                <p>Card Holder Name<span>{{$credit_card->first_name}} {{$credit_card->last_name}} </span></p>
                                                <p>Expires<span>{{$credit_card->month}} / {{$credit_card->year}}</span></p>
                                                <p>Currency<span>{{$credit_card->currency}}</span></p>
                                            </div>
                                            <div class="dash-pay-r-gray col-xs-6">
                                                <p>Email<span><a href="mailto:{{$credit_card->email}}">{{$credit_card->email}}</a></span></p>
                                                <p>Billing Information
                                                    <span>{{$credit_card->address}} </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="pay-inner-card">
                                    <div class="dash-pay-gray">
                                        No Credit Card added yet.
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="dash-box dash-pay-right col-xs-6">
                        <h3 class="dashboard-title">Loyalty Points</h3>
                        <div class="dash-box-inner loyalty-box">
                            <h4>My Loyalty Points</h4>
                            <p>Loyalty Points are redeemed during checkout. When you checkout, you’ll see your available Loyalty Points in the Payment Info section under the heading Payment Method. Your order total will be discounted immediately!</p>
                            <ul>
                                <li>
                                    <div class="loyal-title">Pending<span>Points</span></div>
                                    <div class="value">40</div>
                                </li>
                                <li>
                                    <div class="loyal-title">Total<span>Points</span></div>
                                    <div class="value">240</div>
                                </li>
                                <li>
                                    <div class="loyal-title">Total<span>Points</span></div>
                                    <div class="value">240</div>
                                </li>
                                <li>
                                    <div class="loyal-title">Value</div>
                                    <div class="value">AED 24</div>
                                </li>
                            </ul>
                            <a href="#" data-toggle="modal" data-target="#loyaltypopup">Policies for the Customer Loyalty Rewards</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /tabs -->
            <div class="clearfix"></div>
        </div>
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
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}
@section('scripts')
    @include('site.layouts.scripts')
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

        $('#cardpopup').on('hidden.bs.modal', function () {
            $('#save_card').validate().resetForm();
            $('.error').removeClass('error');
        });

        $(".close").click(function() {
            validator.resetForm();
        });

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


