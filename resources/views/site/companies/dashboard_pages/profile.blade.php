@extends('site.layouts.app')

@section('head')
    {{--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>--}}
    <link rel='stylesheet' href='{{url('css/intlTelInput.css')}}'>
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
                    @include('site.companies.dashboard_nev',['active_profile' => "active"])
                </ul>
            </aside>
            <div class="tab-content dashboard-wrap">
                <div class="tab-pane active" id="profile">
                    <div class="welcome-title full-col">
                        <h2>Edit Profile</h2>
                    </div>
                    @include('site.layouts.session_messages')
                    <div class="dash-box col-xs-5 dash-profile-photo">
                        <h3 class="dashboard-title">Profile Photo</h3>
                        <div class="dash-box-inner profile-photo-box">
                            <form action="{{route('company.profile.update')}}" method="post" id="profile_pic_form" enctype="multipart/form-data">
                            @csrf
                            <!-- <div class="profile-img"><img src="images/edit-profile.png" alt=""/></div>
                    <p> Be sure to use a photo that clearly shows your face and doesn’t include any personal or sensitive info .</p>
                    <a href="#" class="btn get-btn"><span>Upload Photo</span><span></span><span></span><span></span><span></span></a> -->
                                <div class="file-upload">
                                    <div class="image-upload-wrap">
                                        <input class="file-upload-input" type='file' name="profile_pic" onchange="readURL(this);" accept="image/*" />
                                    </div>
                                    <div class="file-upload-content">
                                        <div class="profile-img"><img class="file-upload-image " src="{{get_user_image(Auth::user()->id)}}" alt="your image" /></div>
                                        <button class="file-remove-btn btn get-btn" id="file_remove" type="button" style="display: none" onclick="removeUpload()"><span>Remove Photo</span><span></span><span></span><span></span><span></span></button>
                                        <p> Be sure to use a photo that clearly shows your face and doesn’t include any personal or sensitive info .</p>
                                        <button class="file-upload-btn btn get-btn" id="file_upload"  type="button" onclick="$('.file-upload-input').trigger( 'click' );"><span>Upload Photo</span><span></span><span></span><span></span><span></span></button>
                                        <button class="file-save btn get-btn" id="file_save" type="submit" style="display: none"><span>Save Photo</span><span></span><span></span><span></span><span></span></button>
                                    </div>
                                </div><!-- file-upload -->
                            </form>
                        </div>
                    </div>
                    <div class="dash-box dash-personal col-xs-7">
                        <h3 class="dashboard-title">Personal Info</h3>
                        <div class="dash-box-inner dash-personal-box">
                            <form action="{{route('company.profile.update')}}" method="post" id="profile_form">
                                @csrf
                                <div class="col-sm-6 form-group per-form-group">
                                    <input type="text" name="name" placeholder="Name" value="{{Auth::user()->name}}" class="form-control" minlength="2" required/>
                                </div>
                                <div class="col-sm-6 form-group per-form-group">
                                    <input type="email" name="email" placeholder="Email Address" value="{{Auth::user()->email}}" class="form-control" required/>
                                </div>

                                <div class="col-sm-6 form-group per-form-group">
                                    <input type="text" name="company_name" placeholder="Hotal Name" value="{{$company->name}}"  class="form-control" disabled/>
                                </div>
                                <div class="col-sm-6 form-group per-form-group">
                                    <input type="email"  name="company_email" placeholder="Work Email" value="{{$company->company_email}}" class="form-control" />
                                </div>

                                <div class="col-sm-6 form-group per-form-group">
                                    <select class="selectpicker select2" name="timezone">
                                        <option selected disabled>Select Timezone</option>
                                        @foreach($timezones as $kay=>$timezone)
                                            @if($kay == $company->timezone)
                                                @php $selected = 'selected'; @endphp
                                            @else
                                                @php $selected = ''; @endphp
                                            @endif
                                            <option {{$selected}} value="{{$kay}}">{{$timezone}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group per-form-group">
                                    <select class="selectpicker select2" name="language">
                                        <option selected disabled>Select language</option>
                                        @foreach($languages as $kay=>$language)
                                            @if($kay == $company->language)
                                                @php $selected = 'selected'; @endphp
                                            @else
                                                @php $selected = ''; @endphp
                                            @endif
                                            <option {{$selected}} value="{{$kay}}">{{$language}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group per-form-group">
                                    <input type="tel" class="form-control telephone" id="telephone" value="{{Auth::user()->phone_number}}"
                                           name="phone_number" placeholder="Phone Number" required>
                                </div>
                                <div class="col-sm-6 form-group per-form-group">
                                    <select class="selectpicker" name="currency">
                                        <option selected disabled>Select Currency</option>
                                        @foreach($currencies as $kay=>$currency)
                                            @if($kay == $company->currency)
                                                @php $selected = 'selected'; @endphp
                                            @else
                                                @php $selected = ''; @endphp
                                            @endif
                                            <option {{$selected}} value="{{$kay}}">{{$currency}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12 form-group per-form-group">
                                    <input type="text" name="address" value="{{$company->address}}" placeholder="Where You Live" class="form-control" />
                                </div>
                                <div class="col-sm-2 form-group per-form-group">
                                    <button class="btn get-btn" type="submit"><span>Update Info</span><span></span><span></span><span></span><span></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="dash-box dash-personal dash-password col-xs-7">
                        <h3 class="dashboard-title">Personal Password</h3>
                        <div class="dash-box-inner dash-personal-box">
                            <form action="{{route('change.password')}}" method="post" id="password_form">
                                @csrf
                                <div class="col-sm-6 form-group per-form-group">
                                    <input type="password" name="current_password" placeholder="Old Password" value="" class="form-control" minlength="6" required/>
                                </div>
                                <div class="col-sm-6 form-group per-form-group">
                                    <input type="password" name="new_password" id="new_password" placeholder="New Password" value="" class="form-control" minlength="6" required/>
                                </div>

                                <div class="col-sm-6 form-group per-form-group">
                                    <input type="password" name="confirmed" placeholder="Confirm Password" value="" class="form-control" required/>
                                </div>

                                <div class="col-sm-12 form-group per-form-group">

                                </div>
                                <div class="col-sm-2 form-group per-form-group">
                                    <button class="btn get-btn" type="submit"><span>Save</span><span></span><span></span><span></span><span></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>--}}
@section('scripts')
    @include('site.layouts.scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}
    {{--<script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js'></script>--}}
    <script src='{{url('js/intlTelInput.min.js')}}'></script>
    <script>

        $('document').ready(function(){
            var input = document.querySelector("#telephone");
            window.intlTelInput(input, {
                nationalMode: false,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
            });
            // $(".telephone").intlTelInput({
            //     nationalMode: false,
            //     utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
            // });
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
    </script>

@endsection
