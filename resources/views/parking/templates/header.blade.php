<div class="fullscreen-bg">
    <video loop muted autoplay class="fullscreen-bg__video">
        <source src="{{ asset('/video/headers.mp4') }}" type="video/mp4">
    </video>
</div>

<div class="container book">
    <div class="row">
        <div class="col-md-12 main-header">
            <img src="{{ asset('/img/header-logo-light.png') }}" class="header-logo">
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 text-center" style="color:#ffffff; font-size:20px; margin-top:55px; margin-bottom:-45px;">
            <h4>Select your dates below to start booking your First Meet and Greet Parking Now</h4>
        </div>
    </div>
    @include('parking.partials._search')
    <div class="row v-align">
        <div class="col-md-12"><a href="#layer2" data-scroll class="v-scroll"><i class="fas fa-angle-down"></i></a></div>
    </div>
</div>
