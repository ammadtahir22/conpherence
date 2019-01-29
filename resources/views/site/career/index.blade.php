@extends('site.layouts.app')

@section('head')

@endsection

@section('header-class', '')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="banner sub-banner how-banner">
        <div class="container">
            <div class="col-xs-12 banner_info fade-down-ani">
                <h1>Get Your Career<br/>Moving with Conpherence</h1>
                <h3>Join our rapidly growing family!</h3>
                <img src="{{url('images/bar.png')}}" alt="" />
            </div>
            <div class="clearfix"></div>
    </section>
    <section class="career-section">
        <div class="container">
            <div class="wrap fade-down-ani">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
    <section class="offer-section">
        <div class="container">
            <div class="wrap">
                <div class="offer-info col-xs-6 fade-left-ani">
                    <h2>What We Offer</h2>
                    <h3>We are Featured</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and.  Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                    <h3>The Opportunity</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing</p>
                    <h3>Great Office Location</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing  industry. </p>
                    <h3>The Opportunity</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                </div>
                <div class="offer-img col-xs-6 fade-right-ani">
                    <div class="offer-img-inner">
                        <img src="{{url('images/offer-img.png')}}" alt="" />
                    </div>
                </div>
            </div>
        </div><!-- container -->
        <div class="clearfix"></div>
    </section>
    <section class="faq-section">
        <div class="container">
            <div class="wrap">
                <div class="search-wrap full-col">
                    <h2>Current openings</h2>
                    <div class="search-job">
                        <input type="text" name="search" placeholder="Search" onkeyup="searchCareer(this.value)"/>
                        <button><img src="{{url('images/search.png')}}" alt="" /></button>
                    </div>
                </div><!-- search-wrap -->
                <div class="accordian-group full-col">
                    <div class="panel-group" role="tablist" aria-multiselectable="true" id="search_career">
                        @foreach($career_categories as $key=>$category)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading{{$key}}">
                                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#search_career" href="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">{{$category->title}}</a> </h4>
                            </div>
                            <div id="collapse{{$key}}" class="panel-collapse collapse  no-transition" role="tabpanel" aria-labelledby="heading{{$key}}">
                                <div class="panel-body">
                                    @foreach($category->careers as $innerKey=>$career)
                                        @if($career->status == 1)
                                            <div class="faq-row full-col @php if($innerKey == 0)  echo 'active'; @endphp">
                                                <div class="faq-info col-sm-7">{{$career->title}}</div>
                                                <div class="faq-loaction col-sm-3">{{$career->location}}  </div>
                                                <div class="faq-btn col-sm-2"><a href="{{url('/career/'.$career->id)}}">Apply Now</a></div>
                                            </div><!-- faq-row -->
                                        @endif
                                    @endforeach
                                </div><!-- panel-body -->
                            </div><!-- panel-collapse -->
                        </div><!-- container-->
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')

    <script>
        function searchCareer(value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/career/search')}}',
                type: 'get',
                datatype: 'json',
                data: {
                    value: value,
                },
                success: function (response) {
                    if(response.error !== ''){
                        $('#search_career').html(response.error);
                    } else {
                        $('#search_career').html(response.data);
                    }
                }
            });
        }
    </script>
@endsection

