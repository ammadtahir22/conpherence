@extends('site.layouts.app')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')
    <section class="not-found-section">
        <div class="container">
            <h1>{{$exception->getStatusCode()}}</h1>
            <p>{{$exception->getMessage() ? $exception->getMessage() : 'You have experienced a technical error. We apologize.'}}</p>
            <small>
                We are working hard to correct this issue. Please wait a we will fix this issue ASAP
            </small>
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