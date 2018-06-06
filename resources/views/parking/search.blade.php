@extends('parking-app')

@section('css')
<link href="{{ asset('/css/parking-search.css') }}" rel="stylesheet">
<link href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@stop

@section('main-content')
 <div id="mobileNav" class="overlay-nav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content">
        <a href="/contact">Contact Us</a>
        <a href="#">Login</a>
        <a href="#">Live Chat</a>
        <a href="#">Airport Parking</a>
      </div>
    </div>
    <nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
        <a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo.png') }}" class="navbar-brand"></a>
        @include('parking.templates.nav2')
        <span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
    </nav>


    <br/><br/><br/><br/><br/>

    <nav class="navbar-expand-lg navbar-light bg-light navbar-2">
        @include('parking.templates.nav3')
    </nav>
    <div class="navbar-2-mobile">
            @include('parking.templates.nav3-mobile')
        </div>

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
<script src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('/js/parking-app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/search.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $('#airport').select2();
    });
</script>
@stop