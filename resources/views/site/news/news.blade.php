@extends('site.layouts.app')

@section('head')

@endsection

@section('header-class', '')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="blog-banner blog-banner-detail" style="background-image: url({{'../storage/images/news/'.$news->id.'/'.$news->image}});">
        <div class="container">
            <div class="banner_info">
                <h1>{{$news->title}}</h1>
                <img src="{{url('images/bar.png')}}" alt="" />
                <div class="full-col bloq-banner-btm">
                    <div class="date">{{ date('d M Y', strtotime($news->created_at)) }}</div>
                </div>
            </div>
        </div><!-- container -->
        <div class="clearfix"></div>
    </section>
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <div class="boq-wrap blog-detail-wrap">
                    {!! $news->description !!}
                    <img src="{{url('storage/images/news/'.$news->id.'/'.$news->image)}}" alt=""/>

                    <!--<div class="blog-move">-->
                    <!--    <a class="pre-btn" href="#"><span><</span>Previous is Lorem Ipsum is simply </a>-->
                    <!--    <a class="pre-btn next-btn active" href="#">Next is Lorem Ipsum is simply<span>></span></a>-->
                    <!--</div>-->
                </div><!-- row -->
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
    <script>
        $("#comment_form").validate({
            rules: {
                comment: {
                    required: true,
                }
            },
            messages: {
                comment: {
                    required: "Response is Required",
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    data: $('#comment_form').serialize(),
                    url: '{{url('/blog/comment')}}',
                    success: function (response) {
                        $('#comment_form').trigger("reset");

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
    </script>

@endsection

