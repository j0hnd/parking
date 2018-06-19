@extends('parking-app')

@section('css')
<link href="{{ asset('/css/privacy.css') }}" rel="stylesheet">
@stop

@section('main-content')
 <div id="mobileNav" class="overlay-nav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content">
        <a href="/contact">Contact Us</a>
        <a href="#">Login</a>
        <a href="#">Live Chat</a>
        <a href="#">Airport Parking</a>
      </div>
    </div>
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

        <div class="container outer-con">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="term-title">PRIVACY POLICY</h1>
                    <div class="container inner-con2">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="term-head">My Travel Compared.com</p>
                                <hr>
                                <p class="term-content">My Travel Compared.com is committed to protecting your privacy and maintaining the security of any personal information received from you.</p>
                                <p class="term-content">This Privacy Statement explains the types of personal information we gather when you use our websites, as well as some of the steps we take to safeguard it.</p>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 inner-con">
                                
                            <p class="term-t">Data Collection</p>
                                <hr/>
                                <p class="term-content">As you browse our website, your visit is automatically logged. This includes information such as the browser brand, operating system you use, and the date and time of your visit. This data is collated by our log analysis tool as part of our web site visitor statistics. You are not personally identifiable. All websites will perform this type of visitor logging.</p>
                            <p class="term-t">Personal Data</p>
                                <hr/>
                            <p class="term-content">Where you provide us with your name, e-mail address or other personal information on this site, e.g. when you register an enquiry, this information will be stored in our database for the purpose of contacting you in line with the mode expressed on the input form. For example, by email or telephone.</p>

                            <p class="term-t">Cookie Policy</p>
                                <hr/>
                            <p class="term-content">How we use cookies</p>

                            <p class="term-content">My Travel Compared.com uses temporary cookies (small text files stored on a computer). We use them to identify you in a coded form, not using your personal information, to enhance the experience when you browse the site and to make future improvements to the site.</p>

                            <p class="term-content">Can we use them?</p>

                            <p class="term-content">We need your permission to use cookies and will take your continued use as permission. You may delete and block all cookies from our site by changing your browser settings but this will affect the functionality of our website.</p>

                            <p class="term-content">Cookies for web metrics</p>

                            <p class="term-content">We make use of Google Analytics to track usage of our website. They use cookies to see how often people visit the site, how long they stay, and which pages they use. We use this information to make our website better and deliver a better service to our customers.</p>

                            <p class="term-content">Cookies from social networks</p>

                            <p class="term-content">When we include social 'plugins', those sites can use cookies. The cookies they set allow them to monitor use but also lets them know whether you're logged in so you can quickly share content on your networks.</p>

                            <p class="term-content">Third Party Cookies</p>

                            <p class="term-content">If we include content from other sites they may use cookies to track how people are using their site.</p>

                            <p class="term-content">More Information</p>

                            <p class="term-content" style="text-align: left;">For more detailed information about cookies please visit www.allaboutcookies.org.</p>

                             <p class="term-t">Information Sharing</p>
                                <hr/>
                            <p class="term-content">My Travel Compared.com does not sell, rent or exchange your personal information with any third-party for commercial or other reasons.</p>
                            </div>
                            <div class="col-md-4 side-banner">
                                <div class="container banner-con">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1 class="banner-percent">90%</h1>
                                            <hr>
                                            <p class="cwu">of customer would use our booking service again</p>
                                            <div class="read-review-con">
                                            <a href="#" class="read-review" >Read our reviews from<br/> the last week</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
@stop

@section('js')
<script src="{{ asset('/js/navigation.js') }}" type="text/javascript"></script>
@stop