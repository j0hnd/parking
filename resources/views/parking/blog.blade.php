@extends('parking-app')

@section('css')
<link href="{{ asset('/css/contact.css') }}" rel="stylesheet">
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
       
    </nav>
    <div class="navbar-2-mobile">
        </div>

   
      

    
@stop

@section('js')
<script src="{{ asset('/js/navigation.js') }}" type="text/javascript"></script>
@stop