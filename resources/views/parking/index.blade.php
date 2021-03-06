@extends('parking-app')

@section('css')
<link href="{{ asset('/css/parking-app.css') }}" rel="stylesheet">
{{-- Add the slick-theme.css if you want default styling --}}
<link href="{{ asset('/css/slick.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('/css/slick-theme.css') }}" rel="stylesheet" type="text/css"/>
{{-- Bootstrap datepicker --}}
<link href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('main-content')
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark" data-toggle="affix">
        @include('parking.templates.nav')
    </nav>

    {{-- header --}}
    <header id="header">
        @include('parking.templates.header')
    </header>

    {{-- sections --}}
    @include('parking.templates.sections')
@stop

@section('js')
<script src="{{ asset('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src='{{ asset('/js/slick.min.js') }}' type="text/javascript"></script>
<script src="{{ asset('/js/parking-app.js') }}" type="text/javascript"></script>
@stop