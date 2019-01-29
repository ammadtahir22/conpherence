@extends('site.layouts.app')

@section('head')

@endsection

@section('header-class', '')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

    <section class="not-found-section thank-section">
        <div class="container">
            <img src="{{url('images/success.png')}}" alt="">
            <h1>Thank You</h1>
            <p>for booking space with conpherence.com. Your booking will be confirmed by Hotel owner shortly.</p>
        </div>
        <!-- /tabs -->
        <div class="clearfix"></div>
    </section>

@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')
@endsection
