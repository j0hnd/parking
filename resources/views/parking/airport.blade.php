@extends('parking-app')
@section('css')
    <link href="{{ asset('/css/airport.css') }}" rel="stylesheet">
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
        <div class="row">
 
                <div class="col-md-6 form-section">
                    <ul>
                    <li>
                        <select name="Location" class="form-control" data-track-name="location"><option value="ABZ">Aberdeen</option><option value="BHD">Belfast City (George Best)</option><option value="BFS">Belfast International</option><option value="BHX">Birmingham</option><option value="BOH">Bournemouth</option><option value="BRS">Bristol</option><option value="CWL">Cardiff</option><option value="DSA">Doncaster-Sheffield (Robin Hood)</option><option value="DUB">Dublin</option><option value="MME">Durham Tees Valley</option><option value="EMA">East Midlands</option><option value="EDI">Edinburgh</option><option value="EXT">Exeter</option><option value="LGW">Gatwick</option><option value="GLA">Glasgow International</option><option value="PIK">Glasgow Prestwick</option><option value="LHR">Heathrow</option><option value="HUY">Humberside </option><option value="INV">Inverness</option><option value="LBA">Leeds Bradford</option><option value="LPL">Liverpool</option><option value="LCY">London City</option><option value="LTN">Luton</option><option value="MAN">Manchester</option><option value="NCL">Newcastle</option><option value="NWI">Norwich</option><option value="SNN">Shannon</option><option value="SOU">Southampton</option><option value="SEN">Southend</option><option value="STN" selected="selected">Stansted</option></select>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Parking From</label>
                                <input type="date" class="form-control parking-from" />
                            </div>
                            <div class="col-md-6">
                                <label>&nbsp;</label>
                                <input type="time" class="form-control parking-from-time" />
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Returning to collect car</label>
                                <input type="date" class="form-control parking-from" />
                            </div>
                            <div class="col-md-6">
                                <label>&nbsp;</label>
                                <input type="time" class="form-control parking-from-time" />
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-md-6">
                                <br>
                                <button class="form-control btn btn-primary">Find Parking <i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </li>
                    </ul>
                </div>
               

                <div class="col-md-6">
                <img src="{{ asset('/img/carpark.jpg') }}" alt="Airport Car Park" class="carpark">
                </div>
         
         </div>

         <div class="row">
            <div class="col-md-12">
                <div class="airport-desc">
                    <h2>Stansted Airport Parking</h2>
                    <p>Booking parking at Stansted airport in advance can get you significant money off the on-the-gate parking price. You could save up to 60% if you pre-book online with Airparks far enough ahead.</p>
                    <p>Not only does pre-booking save you money, but you will also benefit from having a parking space reserved and waiting for you when you arrive at the airport. This can be a life-saver if you are running late and don’t have time to hunt for that elusive space in packed car parks.</p>
                    <p>From affordable, off-site parking with direct transfers to the airport terminal, to our Meet and Greet option where you hand over your keys at the terminal doors and your car is parked for you while you board your flight; we have an Stansted airport parking solution for everyone.</p>
                </div>
            </div>
         </div>       
    </div>
    <br/><br/>
    </div>
@stop

@section('js')
    <script src="{{ asset('/js/navigation.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/affix.js') }}" type="text/javascript"></script>
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
        });
    </script>
@stop