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
    <form>
        <div class="row book-box">
            <div class="col-md-3 input1">
                <i><img src="{{ asset('/img/plane-mini.png') }}"></i> Airport <br/>
                <select class="form-control-sm">
                    <option>Lorem ipsum dolor sit amet</option>
                    <option>Lorem ipsum dolor sit amet</option>
                    <option>Lorem ipsum dolor sit amet</option>
                </select>
            </div>
            <div class="col-md-2 input2">
                <i><img src="{{ asset('/img/calendar.png') }}"></i> Drop off <br/>
                <input id="datefield" type='date' min='' name="" class="form-control-sm"></input>
            </div>
            <div class="col-md-1 input3">
                <input type="time" name="" class="form-control-sm">
            </div>
            <div class="col-md-2 input4">
                <i><img src="{{ asset('img/calendar.png') }}"></i> Drop off <br/>
                <input id="datefield" type='date' min='' name="" class="form-control-sm"></input>
            </div>
            <div class="col-md-1 input5">
                <input type="time" name="" class="form-control-sm">
            </div>
            <div class="col-md-3 input6">
                <button type="submit" class="btn btn-primary btn-sm"><i><img src="{{ asset('/img/search.png') }}"/></i> Search Car Park</button>
            </div>
        </div>
    </form>
    <div class="row v-align">
        <div class="col-md-12"><a href="#layer2" data-scroll class="v-scroll"><i class="fas fa-angle-down"></i></a></div>
    </div>
</div>
