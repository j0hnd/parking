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
             <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                                    <div class="au-card-title" style="background-image:url('../img/bg-title-01.jpg');">
                                        <div class="bg-overlay bg-overlay--blue"></div>
                                        <h3>
                                            <i class="zmdi zmdi-account-calendar"></i>{{$date}}</h3>
                                    </div>
                                    <div class="au-task js-list-load">
                                        <div class="au-task__title">
                                            <p>Emails for {{ $user->members->first_name }} {{ $user->members->last_name }}</p>
                                        </div>
                                        <div class="au-task-list js-scrollbar3">
                                            <div class="au-task__item au-task__item--primary">
                                                <div class="au-task__item-inner">
                                                	<div class="container">
                                                	<div class="row">
                                                	<div class="col-lg-4">
                                                		<span class="time">Admin</span>
                                                	</div>
                                                	<div class="col-lg-5">
                                                    <h5 class="task">
                                                        <a href="{{ url('/members/email') }}"><a href="{{ url('/members/email') }}">Meeting about plan for Admin Template 2018</a>
                                                    </h5>
                                                	</div>
                                                	<div class="col-lg-3 text-right">
                                                    <span class="time">10:00 AM</span>
                                                	</div>
                                                </div>
                                            	</div>
                                                </div>
                                            </div>
                                            <div class="au-task__item au-task__item--success">
                                                <div class="au-task__item-inner">
                                                	<div class="container">
                                                	<div class="row">
                                                	<div class="col-lg-4">
                                                		<span class="time">Admin</span>
                                                	</div>
                                                	<div class="col-lg-5">
                                                    <h5 class="task">
                                                        <a href="{{ url('/members/email') }}">Create new task for Dashboard</a>
                                                    </h5>
                                                    </div>
                                                	<div class="col-lg-3 text-right">
                                                    <span class="time">11:00 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                            </div>
                                            <div class="au-task__item au-task__item--success">
                                                <div class="au-task__item-inner">
                                                	<div class="container">
                                                	<div class="row">
                                                	<div class="col-lg-4">
                                                		<span class="time">Admin</span>
                                                	</div>
                                                	<div class="col-lg-5">
                                                    <h5 class="task">
                                                        <a href="{{ url('/members/email') }}">Meeting about plan for Admin Template 2018</a>
                                                    </h5>
                                                    </div>
                                                	<div class="col-lg-3 text-right">
                                                    <span class="time">02:00 PM</span>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                            </div>
                                            <div class="au-task__item au-task__item--success">
                                                <div class="au-task__item-inner">
                                                	<div class="container">
                                                	<div class="row">
                                                	<div class="col-lg-4">
                                                		<span class="time">Admin</span>
                                                	</div>
                                                	<div class="col-lg-5">
                                                    <h5 class="task">
                                                        <a href="{{ url('/members/email') }}">Create new task for Dashboard</a>
                                                    </h5>
                                                    </div>
                                                	<div class="col-lg-3 text-right">
                                                    <span class="time">03:30 PM</span>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                            </div>
                                            <div class="au-task__item au-task__item--success js-load-item">
                                                <div class="au-task__item-inner">
                                                	<div class="container">
                                                	<div class="row">
                                                	<div class="col-lg-4">
                                                		<span class="time">Admin</span>
                                                	</div>
                                                	<div class="col-lg-5">
                                                    <h5 class="task">
                                                        <a href="{{ url('/members/email') }}">Meeting about plan for Admin Template 2018</a>
                                                    </h5>
                                                    </div>
                                                	<div class="col-lg-3 text-right">
                                                    <span class="time">10:00 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                            </div>
                                            <div class="au-task__item au-task__item--success js-load-item">
                                                <div class="au-task__item-inner">
                                                	<div class="container">
                                                	<div class="row">
                                                	<div class="col-lg-4">
                                                		<span class="time">Admin</span>
                                                	</div>
                                                	<div class="col-lg-5">
                                                    <h5 class="task">
                                                        <a href="{{ url('/members/email') }}">Create new task for Dashboard</a>
                                                    </h5>
                                                    </div>
                                                	<div class="col-lg-3 text-right">
                                                    <span class="time">11:00 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="au-task__footer">
                                            <button class="au-btn au-btn-load js-load-btn">load more</button>
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
</div>
	@include('parking.templates.footer')

@stop

@section('js')
@stop