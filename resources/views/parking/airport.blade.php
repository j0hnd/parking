@extends('parking-app')
@section('css')
    <link href="{{ asset('/css/airport.css') }}" rel="stylesheet">
    <link href="{{ asset('/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@stop

@section('main-content')
    @include('parking.templates.nav-mobile')
    <nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
        <a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo.png') }}" class="navbar-brand"></a>
        @include('parking.templates.nav2')
        <span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
    </nav>

    <br/><br/><br/><br/><br/>

<div class="airport-page">
    <div class="container">
        <form id="search-form" action="{{ url('/search') }}" method="post">
        <div class="row">
            <div class="col-md-6 form-section">
                <ul>
                <li>
                    <label for="">Select Airport</label>
                    <select id="airport_id" name="search[airport]" class="form-control">
                        <option value="">-- Select Airport --</option>
                        @if(count($airports))
                            @foreach($airports as $airport)
                                @if($airport->id == $page->airport_id)
                                <option value="{{ $airport->id }}" selected>{{ $airport->airport_name }}</option>
                                @else
                                <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Parking Date From</label>
                            <input type="date" id="drop-off-date" class="form-control parking-from" name="search[drop-off-date]" />
                        </div>
                        <div class="col-md-6">
                            <label>Drop Off Time</label>
                            <input type="time" id="drop-off-time" class="form-control parking-from-time" name="search[drop-off-time]" />
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Returning Date to Collect Car</label>
                            <input type="date" id="return-at-date" class="form-control parking-from" name="search[return-at-date]" />
                        </div>
                        <div class="col-md-6">
                            <label>Flight Landing Time</label>
                            <input type="time" id="return-at-time" class="form-control parking-from-time" name="search[return-at-time]" />
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-6">
                            <br>
                            <button id="search" class="form-control btn btn-primary">Find Parking <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </li>
                </ul>
            </div>


            <div class="col-md-6">
            @if(is_null($page->image))
            <img src="{{ asset('/img/carpark.jpg') }}" alt="Airport Car Park" class="carpark">
            @else
            <img src="{{ asset($page->image) }}" alt="Airport Car Park" class="carpark">
            @endif
            </div>
         </div>

         <div class="row">
            <div class="col-md-12">
                <div class="airport-desc">
                    <h2>{{ $page->airport->airport_name }} Parking</h2>
                    {!! $page->description_1 !!}
                </div>
            </div>
         </div>
         {{ csrf_field() }}
         </form>
    </div>
    <br/><br/>
    </div>
@stop

@php
    $mydate = date('Y-m-d', strtotime('+2 days'));
    $start_date = date('Y-m-d', strtotime($mydate));
    $end_date = date('Y-m-d', strtotime($mydate . ' +7 days'));
@endphp

@section('js')
    <script src="{{ asset('/js/navigation.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/affix.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var hh = $('#top').outerHeight();
            var fh = $('footer').outerHeight();

            $('#sidebar').affix({
                offset:{
                    top: hh + 250,
                    bottom: fh + 90
                }
            });

            $('#airport_id').select2();

            $('#drop-off-date').val('{{ $start_date }}');
            $('#drop-off-time').val('{{ date('h:i', strtotime($start_date)) }}');

            $('#return-at-date').val('{{ $end_date }}');
            $('#return-at-time').val('{{ date('h:i', strtotime($end_date)) }}');
        });
    </script>
@stop
