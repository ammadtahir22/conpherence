@extends('site.layouts.app')

@section('head')
    {{--<link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>--}}
@endsection

@section('header')
    @include('site.layouts.header')
@endsection

@section('content')

@php    if( $data->status == 1 )
    { @endphp
     {!! $data->content !!}
@php  } @endphp
@endsection

@section('footer')
    @include('site.layouts.footer')
@endsection

@section('scripts')
    @include('site.layouts.scripts')
@endsection




