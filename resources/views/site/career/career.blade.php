@extends('site.layouts.app')

@section('head')

@endsection

@section('header-class', '')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="career-detail-section">
        <div class="container">
            <div class="wrap fade-down-ani">
                <div class="back-to full-col fade-right-ani hidden visible animated fadeInRight full-visible">
                    <a href="{{url('/career')}}"><img src="{{url('images/back.png')}}" alt="">Back to listing page</a>
                </div>
                @if (session('msg-success'))
                    <p class="alert alert-success" role="alert" style="float: left; width: 100%;">
                        {{ session('msg-success') }}
                    </p>
                @endif

                @if (session('msg-error'))
                    <p class="alert alert-danger" role="alert">
                        {{ session('msg-error') }}
                    </p>
                @endif
                <div class="job-info-top full-col">
                    <div class="job-info-left">
                        <h2>{{$career->title}}, {{$career->career_category->title}}<span>{{$career->location}}  </span></h2>
                    </div>
                    <div class="job-info-right">
                        <div class="post-date">
                            <span>Posted on </span>{{date('d M Y', strtotime($career->created_at))}}
                        </div>
                        <a class="get-btn smooth-scroll" href="#apply-job" >Apply Now</a>
                    </div>
                </div>
                {!! $career->description !!}
            </div>
        </div>
        <div class="clearfix"></div>
    </section>
    <section class="career-job-section" id="apply-job">
        <div class="container">
            <div class="wrap fade-down-ani center">
                <div class="form-wrap dash-personal-box">
                    <h3>Apply for this Job</h3>
                    <form action="{{route('career.apply')}}" method="POST" id="application_form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="career_id" value="{{$career->id}}">
                        <div class="col-sm-6 form-group per-form-group">
                            <input type="text" name="name" placeholder="Name" class="form-control"/>
                        </div>
                        <div class="col-sm-6 form-group per-form-group">
                            <input type="email"  name="email" placeholder="Email Address" class="form-control" />
                        </div>
                        <div class="col-sm-6 form-group per-form-group">
                            <input type="tel" name="phone_number" class="form-control telephone" placeholder="Phone Number">
                        </div>
                        <div class="col-sm-6 form-group per-form-group">
                            <!-- <input name="myfile" type="file"> -->
                            <span id="filename">Resume/CV</span>
                            <label for="file-upload"><span>Upload</span><input type="file" name="resume" id="file-upload"></label>
                        </div>
                        <div class="col-sm-12 form-group per-form-group per-btn-group">
                            <button class="btn ani-btn" type="submit">Apply Now</button>
                            <a href="{{url('/career')}}" ><button class="btn ani-btn cancle-btn" type="button">Cancel</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </section>

@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')

    <script>
        $("#application_form").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true
                },
                phone_number: {
                    required: true,
                },
                resume: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: "Name is Required",
                },
                email: {
                    required: "Email is Required",
                },
                phone_number: {
                    required: "Phone Number is Required",
                },
                resume: {
                    required: "Please upload your Resume",
                }
            }
        });
            {{--submitHandler: function(form) {--}}
                {{--var formData = new FormData($("#application_form")[0]);--}}

                {{--console.log(formData);--}}
                {{--$.ajax({--}}
                    {{--type: 'POST',--}}
                    {{--mimeType: 'multipart/form-data',--}}
                    {{--// data: $('#application_form').serialize(),--}}
                    {{--data:new FormData( this ),--}}
                    {{--url: '{{url('/career/apply')}}',--}}
                    {{--success: function (response) {--}}
                        {{--$('#application_form').trigger("reset");--}}
                        {{--// $('#cardpopup').modal('toggle');--}}
                        {{--// $('#credit_cards').html(response.data);--}}

                        {{--// $("#credit_cards").load(" #credit_cards");--}}

                        {{--console.log(response);--}}

                        {{--// if (response.error.length > 0) {--}}
                        {{--//     var error_html = '';--}}
                        {{--//     for (var count = 0; count < data.error.length; count++) {--}}
                        {{--//         error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';--}}
                        {{--//     }--}}
                        {{--//     $('#flash_massage').html(error_html);--}}
                        {{--// } else {--}}
                        {{--//     $('#flash_massage').html(response.success);--}}
                        {{--//--}}
                        {{--// }--}}

                        {{--// $('.flash_message').empty();--}}
                        {{--// if(data.flag == 1){--}}
                        {{--//     $('.flash_message').append('<p class="text-success">Sucessfully Password Changed!</p>');--}}
                        {{--// }else if(data.flag == 0){--}}
                        {{--//     $('.flash_message').append('<p class="text-danger">Your Old Password Not Found</p>');--}}
                        {{--// }--}}
                        {{--// $("form")[0].reset();--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}

    </script>
@endsection

