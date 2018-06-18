@extends('parking-app')

@section('css')
<link href="{{ asset('/css/contact.css') }}" rel="stylesheet">
@stop

@section('main-content')
 @include('parking.templates.nav-mobile')
    <nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
        <a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
        @include('parking.templates.nav2')
        <span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
    </nav>


    <br/><br/><br/><br/><br/>

    <nav class="navbar-expand-lg navbar-light bg-light navbar-2">
       
    </nav>
    <div class="navbar-2-mobile">
        </div>

    <div class="container font-set">
        <div class="row">
            <div class="col-md-12">
                <h1 class="get-in-touch">GET IN TOUCH WITH US</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-5 con1">
                <p class="con-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.</p>
            </div>
            <div class="col-md-5 col-sm-6 contact-card">
                <div class="row">
                    <div class="col-md-12">
                        <p class="contact-head">Social</p>
                        <br/>
                        <p class="con-content1">Follow us for quick updates and links on our very own social media pages. Additionally, use these to get in touch with us: </p>
                        <br/>
                        <i class="fab fa-facebook-f" style="color: #3B5998; font-size: 25px;"> <a href="" target="_blank" class="con-link1"> My Traveled Compared.com on Facebook</i></a><br/><br/>
                        <i class="fab fa-twitter" style="color: #326ada; font-size: 25px;"> <a href="" target="_blank" class="con-link2"> My Traveled Compared.com on Twitter</a></i>
                        <br/><br/><br/>
                        <p class="contact-head">Direct & Fast</p>
                        <br/>
                        <p class="con-content1">If you're looking to try our app, but want to talk to us first you can go ahead and chat live with us by this following link:</p>
                        <br/>
                        <br/>
                        <a href="#" class="chat">Click here, to chat with us!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container lvl-2">
        <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form>
                <div class="row">
                    <div class="col-md-6">
                       <div class="group">      
                          <input type="text" class="input1" required>
                          <span class="highlight"></span>
                          <span class="bar1"></span>
                          <label>Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="group">      
                          <input type="email" class="input1" required>
                          <span class="highlight"></span>
                          <span class="bar1"></span>
                          <label>Email</label>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="group">      
                          <textarea class="input2" required></textarea>
                          <span class="highlight"></span>
                          <span class="bar2"></span>
                          <label>Message</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="contact-send button_slide">Send</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    </div>
      

    
@stop

@section('js')
<script src="{{ asset('/js/navigation.js') }}" type="text/javascript"></script>
@stop