@extends('member-portal')

@section('css')
    <link href="{{ asset('/css/member-portal.css') }}" rel="stylesheet">
@stop

@section('main-content')
    @include('member-portal.partials.nav-mobile')

    @include('member-portal.partials.nav-header')

    <br/>
    <!-- PAGE CONTENT-->
    <div class="page-content--bgf7">
        <!-- BREADCRUMB-->
        @include('member-portal.partials.breadcrumbs', ['page_title' => 'Dashboard'])
        <!-- END BREADCRUMB-->

        <!-- WELCOME-->
        <section class="welcome p-t-10">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title-4">Welcome back
                            <span>{{ $user->members->first_name }}!</span>
                        </h1>
                        <hr class="line-seprate">
                    </div>
                </div>
            </div>
        </section>
        <!-- END WELCOME-->

        <!-- STATISTIC-->
        <section class="statistic statistic2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">overview</h2>

                        </div>
                    </div>
                </div>
                <div class="row m-t-25">
                    <div class="col-sm-6 col-lg-4">
                        <div class="overview-item overview-item--c1">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-calendar-note"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{ count($ongoing_bookings) }}</h2>
                                        <span>ongoing booking</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="overview-item overview-item--c3">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-check"></i>
                                    </div>
                                    <div class="text">
                                        <h2>{{ count($total_bookings) }}</h2>
                                        <span>total bookings</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="overview-item overview-item--c4">
                            <div class="overview__inner">
                                <div class="overview-box clearfix">
                                    <div class="icon">
                                        <i class="zmdi zmdi-star"></i>
                                    </div>
                                    <div class="text">
                                        <h2>0</h2>
                                        <span>total point you earned</span>
                                    </div>
                                </div>
                                <div class="overview-chart">
                                    <canvas id="widgetChart4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END STATISTIC-->

        <!-- DATA TABLE-->
        <section class="p-t-20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if($user->roles[0]->slug == 'member' or $user->roles[0]->slug == 'travel_agent')
                            <h3 class="title-5 m-b-35">Your Bookings</h3>
                            @if(!is_null($affiliate))
                            <p class="text-right m-b-10">Affiliate link: {{ url('/affiliate/' . $affiliate->code) }}</p>
                            @endif
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    @include('member-portal.partials.member')
                                </table>
                            </div>
                        @endif
                        @if($user->roles[0]->slug == 'vendor')
                            <h3 class="title-5 m-b-35">Your Bookings</h3>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    @include('member-portal.partials.vendor')
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <input type="hidden" id="token" value="{{ csrf_token() }}">
        </section>
        <br/>
        <br/>
        <br/>
        <!-- END DATA TABLE-->
    @include('parking.templates.footer')
@stop

@section('js')

@stop
