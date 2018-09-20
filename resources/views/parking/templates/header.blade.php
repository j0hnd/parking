<div class="fullscreen-bg">
    <video loop muted autoplay class="fullscreen-bg__video">
        <source src="{{ asset('/video/headers.mp4') }}" type="video/mp4">
    </video>
</div>

<div class="row">
    <div class="col-md-12 padding-20" style="text-align:right">
        <ul class="navbar-nav" style="margin-right:30px; color:#ffffff">
            <li>Call Us on <strong>020 3589 2280</strong></li>
        </ul>
    </div>
</div>

<div class="container book">
    <div class="row">
        <div class="col-md-12 main-header">
            <img src="{{ asset('/img/header-logo-light.png') }}" class="header-logo">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center search-notes" style="color:#ffffff; font-size:20px; margin-top:55px; margin-bottom:-45px;">
            <h4>Select your dates below to start booking your First Meet and Greet Parking Now</h4>
        </div>
    </div>

    @include('parking.partials._search')

    <div class="row" id="toggle-book-now">
        <div class="col-xl-md padding-10" style="margin-left:auto; margin-right:auto;">
            <button type="button" id="book-stansted" class="btn btn-info">Book Now at Stansted!</button>
        </div>
    </div>

    <div class="row v-align">
        <div class="col-md-12"><a href="#layer2" data-scroll class="v-scroll"><i class="fas fa-angle-down"></i></a></div>
    </div>
</div>
