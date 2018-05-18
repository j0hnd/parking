@extends('parking-app')

@section('css')
<link href="{{ asset('/css/parking-search.css') }}" rel="stylesheet">
<link href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css"/>
@stop

@section('main-content')
    <nav class="navbar navbar-expand-sm navbar" data-toggle="affix">
        <a href="index.html"> <img src="{{ asset('/img/logo.png') }}" class="navbar-brand"></a>
        @include('parking.templates.nav2')
    </nav>

    <br/><br/><br/><br/><br/>

    <nav class="navbar-expand-lg navbar-light bg-light navbar-2">
        <ul class="navbar-nav ul-pos" style="margin-left: 135px; position: absolute;">
            <li class="nav-item active-2"><a class="nav-link link-2" href="#">Airport</a></li>
            <li class="nav-item not-active"><a class="nav-link link-2" href="#">Meet & Greet</a></li>
            <li class="nav-item not-active"><a class="nav-link link-2" href="#">On Airport</a></li>
            <li class="nav-item not-active"><a class="nav-link link-2" href="#">Off Airport</a></li>
        </ul>
    </nav>

    <header id="header">
        <div class="container book">
            {{-- search form --}}
            @include('parking.partials._search')

            <a href="#" class="filter">Rating <i class="fas fa-angle-down"></i></a>
            <a href="#" class="filter">Lowest Price <i class="fas fa-angle-down"></i></a>
            <a href="#" class="filter">Select Filter <i class="fas fa-angle-down"></i></a>
        </div>
    </header>

    <div class="container park-search">
        <div class="row">
            @include('parking.partials._cards')
        </div>
    </div>
@stop

@section('js')
<script src="{{ asset('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/parking-app.js') }}" type="text/javascript"></script>
@stop