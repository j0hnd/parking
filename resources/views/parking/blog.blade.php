@extends('parking-app')

@section('css')
<link href="{{ asset('/css/blog.css') }}" rel="stylesheet">
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

        
            <div class="row">
                <div class="col-md-9 blog">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{asset('img/stansted.jpg')}}" class="img-fluid">
                            </div>
                            <div class="col-md-7 con">
                                <h5 class="name">John Doe<div></div></h5>
                                <h1 class="blog-content-title">Where to Eat at Stanstead Airport?</h1>
                                <p class="blog-content">Over the last few years Stanstead Airport has been refurbished throughout which means there are now more eateries than ever before to choose from before boarding your flight. Save time at the airport by planning where you would like to eat in advance using this handy guide and enjoy more time in duty free!</p>
                                <p class="blog-content">Cheap and Cheerful – If it is a quick bite to eat or take-away service you are after you can choose from a selection of the popular chain restaurants and coffee shops on offer such as Itsu, Burger King and Costa Coffee. These outlets have a selection of fresh sandwiches, salads and Paninis as well as coffee and cakes available all hours between the airport’s first and final flights. Many of these such as Starbucks and Pret are open 24 hours a day so there is always opportunity to grab something to eat at any time - check the airport website for current opening hours.</p>
                                <p class="blog-content">Family Friendly – Coast to Coast will suit families with even the fussiest eaters serving up American classics such as Nachos and BBQ chicken, and its legendary deep dish Chicago pizza. This casual dining outlet is great for early flyers too as it has an extensive breakfast menu serving up any type of eggs you like! If you’re in a hurry it’s no problem as they aim to serve you within 15 minutes so no need to worry about missing your flight, just relax and enjoy the start of your holiday.</p>
                                <p class="blog-content">Wine and Dine –If you’re after something a bit more upmarket relax in the calm atmosphere of the Cabin Bar which offers diners a selection of mains, salads and sharing plates to enjoy alongside the drinks list ranging from Champagne to Cocktails to Ales. Then there’s the Halo fizz bar, a great place for couples and groups who want to start off their holiday in style. This is a small piece of luxury amongst the hustle and bustle of the terminal where you can choose a drink from their extensive drinks list and a light bite from their carefully crafted menu serving items such as free range scrambled eggs and sea food plates.</p>
                                <p class="blog-content">Meeting Friends – if you’re off for a girly weekend or meeting up with the lads for an early start to a stag do, you can’t go far wrong with The JD Wetherspoon Windmill.  Again the normal opening hours are between the hours of the airport’s first and final flights, and they have both a breakfast menu serving full English breakfasts and bacon butties and a main menu with all the pub classics, real ales and craft bears.  This restaurant is located over two floors so there is more than enough room for you and all your mates to fuel up before your flight.</p>
                                <p class="blog-content">Wherever you choose, make the start of your holiday count – relax, unwind and enjoy!</p>
                                <a href="#" class="prev btn btn-info"> &lt;&lt; Previous Article</a>
                                <a href="#" class="next btn btn-info">Next Article &gt;&gt;</a>
                            </div>

                        </div>
                    </div>    
                </div>
                <div class="col-md-3 side-blog" id="top">
                    <div id="sidebar">
                     <div class="row">
                        <div class="col-md-12">
                                <div class="card">
                                    <img class="card-img-top" src="img/sun-cream.png" alt="Which sun cream is best for you?">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3 blog-content-title-2">Which sun cream is best for you?</h4>
                                        <p class="card-text">Getting sunburnt does more than spoil your holiday photos; it can also potentially have serious ...
                                        </p>
                                        <a href="#" class="continue">Continue reading...</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <br/><br/>
                    <div class="row">
                    <div class="col-md-12">
                                <div class="card">
                                    <img class="card-img-top" src="img/hand-luggage.jpeg" alt="Hand Luggage – What Should I Pack?">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3 blog-content-title-2">Hand Luggage – What Should I Pack?</h4>
                                        <p class="card-text">Whether you are travelling long haul or short haul to your holiday destination, there are some i...
                                        </p>
                                        <a href="#" class="continue">Continue reading...</a>
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