@extends('site.layouts.app')

@section('head')
    <style>
        .view-all-cursor {
            cursor: pointer;
        }
    </style>

@endsection

@section('header-class', 'home-header')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="blog-banner blog-banner-detail" style="background-image: url({{'../storage/images/blogs/'.$blog->id.'/'.$blog->image}});">
        <div class="container">
            <div class="banner_info">
                <h1>{{$blog->title}}</h1>
                <img src="{{url('images/bar.png')}}" alt="" />
                <div class="full-col bloq-banner-btm">
                    <div class="date">{{ date('d M Y', strtotime($blog->created_at)) }}</div>
                </div>
            </div>
        </div><!-- container -->
        <div class="clearfix"></div>
    </section>
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <div class="boq-wrap blog-detail-wrap">
                    <ol class="breadcrumb">
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{url('/blogs')}}">Blog</a></li>
                        <li>Blog Detail</li>
                    </ol>
                    {!! $blog->description !!}
                    <img src="{{url('storage/images/blogs/'.$blog->id.'/'.$blog->image)}}" alt=""/>



                   <div class="blog-move">
                       @if(isset($previous))
                        <a class="pre-btn active" href="{{url('blog/'. $previous->id)}}"><span><</span>Previous </a>
                           @else
                        <a class="pre-btn view-all-cursor"><span><</span>Previous </a>
                       @endif

                           @if(isset($next))
                               <a class="pre-btn next-btn active" href="{{url('blog/'. $next->id)}}">Next <span>></span></a>
                           @else
                               <a class="pre-btn next-btn view-all-cursor">Next <span>></span></a>
                           @endif
                    </div>
                    <div id="flash_massage">

                    </div>
                    <div class="blogcomment-wrap full-col fade-down-ani">
                        <h2>Responses</h2>
                        @auth
                            <form class="fill-form full-col" id="comment_form">
                                @csrf
                                <div class="form-group">
                                    <input type="text" placeholder="Write a response..." name="comment">
                                    <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                </div>
                                <div class="col-sm-2 form-group">
                                    <button class="btn get-btn" type="submit"><span>Save</span><span></span><span></span><span></span><span></span></button>
                                </div>
                            </form>
                        @endauth

                        <div class="comment full-col">
                            <div class="comment-box full-col main-commemt-box">
                                @php
                                    $div_counter = 1;
                                    $comment_counter = 1;
                                @endphp
                                @foreach($blog->blog_comments as $key=>$comment)
                                    @if($comment->status == 1)
                                        @php
                                            if($div_counter == 1)
                                            {
                                                $div_visibility = 'block';
                                                $div_check = 'total-check';
                                            } else {
                                                $div_visibility = 'none';
                                                $div_check = '';
                                            }
                                        @endphp
                                        <div class="block_div{{$div_counter}} {{$div_check}}" style="display: {{$div_visibility}};">
                                            <div id="comment_box">
                                                <div class="comment-img"><img src="{{get_user_image($comment->user_id)}}" alt="" /></div>
                                                <div class="comment-info">
                                                    <h4> {{get_user_name($comment->user_id)}}  <span class="date"> {{ date('d M Y', strtotime($comment->created_at)) }} </span></h4>
                                                    <p> {{$comment->comment}} </p>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $comment_counter++;
                                            if($comment_counter == 3)
                                            {
                                                $div_counter++;
                                                $comment_counter = 1;
                                            }
                                        @endphp
                                    @endif
                                @endforeach
                                <input type="hidden" id="div_counter" value="2">
                            </div><!-- comment-box -->
                            @if(count($blog->blog_comments) > 0)
                                <a onclick="showMoreComments()" id="blog_view_all" class="blog-viewall view-all-cursor">View all responses</a>
                            @endif
                        </div><!-- comment-wrap -->
                        <!--comment-section-->
                    </div><!-- bloq-wrap -->
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

        function showMoreComments() {

            let counter = $('#div_counter').val();

            for(let i = 1; i <= counter; i++)
            {
                $('.block_div'+counter).css('display','block');
                $('.block_div'+counter).addClass('total-check');
            }

            var db_count = <?php echo count($blog->blog_comments); ?>;
            var show_count = $('.total-check').length;
            console.log(db_count);
            console.log(show_count);

            if(db_count == show_count)
            {
                $('#blog_view_all').css('display','none');
            } else {
                $('#div_counter').val(parseInt(counter)+1);
            }


        }
    </script>

@endsection

