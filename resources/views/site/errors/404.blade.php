@extends('site.layouts.app')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')
    <section class="not-found-section">
        <div class="container">
            <h1>404</h1>
            <p>Page not found</p>
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