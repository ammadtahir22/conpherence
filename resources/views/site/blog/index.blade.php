@extends('site.layouts.app')

@section('head')

@endsection

@section('header-class', 'home-header')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="blog-banner">
        <div id="blogslider" class="carousel slide blogslider" data-ride="carousel">
            <ol class="carousel-indicators">
                @php $count = 0; @endphp
                @if(count($blogs) > 0)
                    @foreach($blogs as $kay=>$blog)
                        @if(isset($blog->image))
                            @if($count < 3)
                                    <li data-target="#blogslider" data-slide-to="{{$count}}" class="{{$count==0 ? 'active' : ''}}"></li>
                            @endif
                            @php $count++; @endphp
                        @endif
                    @endforeach
                    @else
                    <li data-target="#blogslider" data-slide-to="0" class="active"></li>
                @endif
            </ol>
            <div class="carousel-inner">
                @php $count = 0; @endphp
                @if(count($blogs) > 0)
                    @foreach($blogs as $kay=>$blog)
                        @if(isset($blog->image))
                            @if($count < 3)
                            <div class="item {{$count==0 ? 'active' : ''}}" style="background-image: url({{'storage/images/blogs/'.$blog->id.'/'.$blog->image}});">
                                <div class="container">
                                    <div class="banner_info">
                                        <h1>{{$blog->title}}</h1>
                                        <img src="{{url('images/bar.png')}}" alt="" />
                                        <div class="full-col bloq-banner-btm">
                                            <div class="date">{{ date('d M Y', strtotime($blog->created_at)) }}</div>
                                            <a href="{{url('blog/'. $blog->id)}}" class="btn get-btn"><span>View Detail</span><span></span><span></span><span></span><span></span> </a>
                                        </div>
                                    </div>
                                </div><!-- container -->
                            </div>
                            @endif
                                @php $count++; @endphp
                        @endif
                    @endforeach
                    @else
                    <div class="item active" style="background-image: url(images/bloq-banner.png);">
                        <div class="container">
                            <div class="banner_info">
                                {{--<h1>Lorem Ipsum is simply<br/>dummy text of the printing.</h1>--}}
                                {{--<img src="images/bar.png" alt="" />--}}
                                <div class="full-col bloq-banner-btm">
                                    {{--<div class="date">22 July 2018</div>--}}
                                    {{--<a href="booking-detail.html" class="btn get-btn"><span>View Detail</span><span></span><span></span><span></span><span></span> </a>--}}
                                </div>
                            </div>
                        </div><!-- container -->
                    </div>
                @endif
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li>Blog</li>
                </ol>
                <div class="boq-wrap col-sm-9">
                    @if(count($blogs) > 0)
                        @foreach($blogs as $kay=>$blog)
                            <div class="boq-box col-sm-4">
                                @if(isset($blog->image))
                                    <div class="boq-box-img"><img src="{{url('storage/images/blogs/'.$blog->id.'/'.$blog->image)}}"></div>
                                @else
                                    <div class="boq-box-img"><img src="{{url('images/placeholder.jpg')}}"></div>
                                @endif
                                <div class="boq-box-info">
                                    <a href="{{url('blog/'. $blog->id)}}"> <h3>{{ substr($blog->title,0,30) }} </h3> </a>
                                    <p> {{ substr(strip_tags($blog->description),0,100) }} <a href="{{url('blog/'. $blog->id)}}">...</a></p>
                                </div>
                            </div><!-- boq-box -->
                        @endforeach
                    @else
                        <div class="dash-box-inner dash-pay-inner" id="credit_cards">
                            <div class="pay-inner-card">
                                <div class="dash-pay-gray">
                                    No Blog Post added yet.
                                </div>
                            </div>
                        </div>
                    @endif
                </div><!-- bloq-wrap -->
                <div class="boq-side-bar col-sm-3">
                    <form action="#" method="post" class="fill-form">
                        <div class="form-group">
                            <input type="text" name="search" placeholder="search" class="form-control" list="Search-location">
                        </div>
                    </form>
                    <h4>Recent Posts</h4>

                    @if(count($blogs) > 0)
                        @foreach($blogs as $kay=>$blog)
                            @if($kay < 6)
                                <div class="sidebar-boq">
                                    @if(isset($blog->image))
                                        <div class="sidebar-boq-img"><img src="{{url('storage/images/blogs/'.$blog->id.'/'.$blog->image)}}"></div>
                                    @else
                                        <div class="sidebar-boq-img"><img src="{{url('images/placeholder.jpg')}}"></div>
                                    @endif
                                    <div class="sidebar-boq-info">
                                        <a href="{{url('blog/'. $blog->id)}}"> <h3>{{ substr($blog->title,0,20) }} </h3> </a>
                                        <p> {{ substr(strip_tags($blog->description),0,50) }} <a href="{{url('blog/'. $blog->id)}}">...</a></p>
                                    </div>
                                </div><!-- boq-box -->
                            @endif
                        @endforeach
                    @endif
                </div>
            </div><!-- row -->

            {{ $blogs->links() }}

        </div><!-- container -->
        <div class="clearfix"></div>
    </section>


@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')
@endsection

