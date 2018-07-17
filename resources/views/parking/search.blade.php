@extends('parking-app')
@section('title')
Parking Search |
@stop
@section('css')
    <link href="{{ asset('/css/parking-search.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/jquery.steps.css') }}" rel="stylesheet">
    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
		 * element that contains the map. */
        #map {
            height: 100%;
        }
    </style>
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
                {{--<div class="dropdown-menu" aria-labelledby="ratings">--}}
                    {{--<a class="dropdown-item" href="#">Sample 1</a>--}}
                    {{--<a class="dropdown-item" href="#">Sample 2</a>--}}
                    {{--<a class="dropdown-item" href="#">Sample 3</a>--}}
                {{--</div>--}}
            </div>

            <div class="dropdown">
                <a href="#" class="filter dropdown-toggle" id="lowest-price" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lowest Price</a>
                <div class="dropdown-menu" aria-labelledby="lowest-price">
                    <a class="dropdown-item" href="javascript:void(0)" data-type="price" data-value="0-50">Below £50</a>
                    <a class="dropdown-item" href="javascript:void(0)" data-type="price" data-value="51-100">£51 - £100</a>
                    <a class="dropdown-item" href="javascript:void(0)" data-type="price" data-value="101-200">£101 - £200</a>
                    <a class="dropdown-item" href="javascript:void(0)" data-type="price" data-value="101-Up">Above £200</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#" class="filter dropdown-toggle" id="filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select Filter</a>
                <div class="dropdown-menu" aria-labelledby="filters">
                @if($services)
                    @foreach($services as $service)
                    <a class="dropdown-item" href="javascript:void(0)" data-type="service" data-value="{{ urlencode($service->service_name) }}">{{ $service->service_name }}</a>
                    @endforeach
                @endif
                </div>
            </div>

            {{--<div class="dropdown">--}}
                {{--<a href="#" class="filter dropdown-toggle" id="terminals" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select Terminal</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="terminals">--}}
                    {{--@if($terminals)--}}
                        {{--@foreach($terminals as $terminal)--}}
                            {{--<a class="dropdown-item" href="javascript:void(0)" data-type="terminal" data-value="{{ $terminal->subcategory_name }}">{{ $terminal->subcategory_name }}</a>--}}
                        {{--@endforeach--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
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
    <script src="{{ asset('/js/jquery.steps.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/parking-app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/search.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_api') }}&callback=initMap" async defer></script>
    <script type="text/javascript">
        $(function () {
            $('#airport').select2();
            $(".detail-tab").steps({
                headerTag: "h4",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",
                enableFinishButton: true,
                enablePagination: false,
                enableAllSteps: true,
                titleTemplate: "#title#",
                cssClass: "tabcontrol"
            });
        });
    </script>
@stop