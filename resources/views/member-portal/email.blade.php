@extends('member-portal')

@section('css')
	<link href="{{ asset('/css/member-portal.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/inbox.css') }}" rel="stylesheet">
@stop

@section('main-content')
	<div id="mobileNav" class="overlay-nav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content">
        <a href="{{ url('/members/dashboard') }}">Dashboard</a>
        <a href="{{ url('/members/profile') }}">Profile</a>
        <a href="{{ url('/members/inbox') }}">Inbox</a>
        <a href="{{ url('/logout') }}">Logout</a>
      </div>
    </div>
	<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
		<a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
		@include('parking.templates.member-nav')
		<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
	</nav>

	<br/>
	 <div class="page-content--bgf7">
	 <section class="au-breadcrumb2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="au-breadcrumb-content">
                                <div class="au-breadcrumb-left">
                                    <span class="au-breadcrumb-span">You are here:</span>
                                    <ul class="list-unstyled list-inline au-breadcrumb__list">
                                        <li class="list-inline-item">Dashboard</li>
                                        <li class="list-inline-item seprate">
                                            <span>/</span>
                                        </li>
                                        <li class="list-inline-item">Inbox</li>
                                        <li class="list-inline-item seprate">
                                            <span>/</span>
                                        </li>
                                        <li class="list-inline-item">Email</li>
                                    </ul>
                                </div>
                                <form class="au-form-icon--sm" action="" method="post">
                                    <input class="au-input--w300 au-input--style2" type="text" placeholder="Search for transactions...">
                                    <button class="au-btn--submit2" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

             <!-- MAIN CONTENT-->
      <div class="main-content">
        <div class="section__content section__content--p30">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-10 align-right">
                <div class="card">
                  <div class="card-header">
                    <strong class="card-title">Email from Admin</strong>
                  </div>

                  <div class="card-body">
                    <div class="typo-headers">
                      <h2 class="pb-2 display-5">Meeting about plan for Admin Template 2018</h2>
                      <h3 class="pb-2 display-5">Today, Jun 22, 2018</h3>
                      <h4 class="pb-2 display-5">10:00 AM</h4>
                    </div>
                    <div class="typo-articles">
                        <br/>
                      <p class="email-content">
                        The unique stripes of zebras make them one of the animals most familiar to people. They occur in a variety of habitats, such as grasslands, savannas, woodlands, thorny scrublands, mountains , and coastal hills. However, various anthropogenic factors have had a severe impact on zebra populations, in particular hunting for skins and habitat destruction. Grévy's zebra and the mountain highlighted text zebra are endangered.
                    </div>
                    <br/>
                    <a href="{{ url('/members/inbox') }}" class="btn btn-info">&lt;&lt; <strong>Inbox</strong></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END PAGE CONTAINER-->

    
</div>
</div>
	@include('parking.templates.footer')

@stop

@section('js')
@stop