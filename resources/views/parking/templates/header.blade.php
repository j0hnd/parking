<div class="fullscreen-bg">
    <video loop muted autoplay class="fullscreen-bg__video">
        <source src="{{ asset('/video/headers.mp4') }}" type="video/mp4">
    </video>
</div>

<div class="container book">
    <div class="row">
        <div class="col-md-12 main-header">
            <h1 class="header">AIRPORT</h1>
            <p class="header-sub">PARKING SYSTEM</p>
        </div>
    </div>
    @include('parking.partials._search')
    <div class="row v-align">
        <div class="col-md-12"><a href="#layer2" data-scroll class="v-scroll"><i class="fas fa-angle-down"></i></a></div>
    </div>
</div>
