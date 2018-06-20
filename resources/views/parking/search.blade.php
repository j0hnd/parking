@extends('parking-app')

@section('css')
    <link href="{{ asset('/css/parking-search.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    
@stop

@section('main-content')
    @include('parking.templates.nav-mobile')
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

            {{-- filters --}}
            <div class="dropdown">
                <a href="#" class="filter dropdown-toggle" id="ratings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Rating</a>
                <div class="dropdown-menu" aria-labelledby="ratings">
                    <a class="dropdown-item" href="#">Sample 1</a>
                    <a class="dropdown-item" href="#">Sample 2</a>
                    <a class="dropdown-item" href="#">Sample 3</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#" class="filter dropdown-toggle" id="lowest-price" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lowest Price</a>
                <div class="dropdown-menu" aria-labelledby="lowest-price">
                    <a class="dropdown-item" href="#">xxx</a>
                    <a class="dropdown-item" href="#">xxx</a>
                    <a class="dropdown-item" href="#">xxx</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#" class="filter dropdown-toggle" id="filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select Filter</a>
                <div class="dropdown-menu" aria-labelledby="filters">
                    <a class="dropdown-item" href="#">zzz</a>
                    <a class="dropdown-item" href="#">zzz</a>
                    <a class="dropdown-item" href="#">zzz</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container park-search">
        <div id="cards-container" class="row">
            @include('parking.partials._cards')
        </div>
    </div>

    <input type="hidden" id="token" value="{{ csrf_token() }}">
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