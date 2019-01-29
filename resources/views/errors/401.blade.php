@extends('layouts.app')

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')
    <section class="not-found-section">
        <div class="container">
            <h1>401</h1>
            <p>Unauthorized</p>
        </div>
        <!-- /tabs -->
        <div class="clearfix"></div>
    </section>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection

@section('scripts')
    @include('layouts.scripts')
@endsection