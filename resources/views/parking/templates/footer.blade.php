<footer>
    <div class="container" style="position: relative;">
        <div class="row">
            <div class="col-md-4">
                {{--<p class="foot-col1">Lorem ipsum dolor sit amet,<br/>
                    consectetur adipisicing elit,<br/>
                    sed do eiusmodtempor incididunt<br/>
                    labore et dolore magna aliqua.
                </p>--}}
            </div>
            <div class="col-md-4 text-center" style="text-align: center !important;">
                <img src="{{ asset('/img/logo-white.png') }}" class="foot-logo">
            </div>
            <div class="col-md-4">
                <div class="col3-align">
                <p class="foot-col3">
                    CONTACT US!
                </p>
                <div class="info">
                    {{--<i style="margin-right: 15px;" class="mob-icon"><img src="{{ asset('/img/tele.png') }}"></i> (028)231 5344<br/><br/>--}}
                    <i style="margin-right: 15px;" class="mob-icon"><img src="{{ asset('img/email.png') }}"></i> <a href="mailto:{{ config('app.company_email') }}">{{ config('app.company_email') }}</a> <br/><br/>
                    {{--<i style="margin-right: 18px;" class="mob-icon"><img src="{{ asset('img/gps.png') }}"></i> --}}{{--Lorem ipsum dolor sit amet <p class="foot-gps" ">consectetur adipisicing elit.</p>--}}
                </div>
            </div>
            </div>
        </div>
        <hr style="color: #fff; background-color: #fff; height: 2px; width: 100%; border: #fff;">
        <div class="row">
            <div class="col-md-6 footer-con">
                <ul>
                    <li>
                        <a href="/terms" class="link-con terms">Term and Condition</a>
                    </li>
                    <li>
                        <div class="fl"></div>
                    </li>
                    <li>
                        <a href="/privacy" class="link-con privacy">Privacy Policy</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
