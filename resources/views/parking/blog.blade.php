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
    <div class="container blog-page">
        <div class="row">
            <div class="col-lg-9 blog">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            @if(is_null($post->image))
                                <img src="{{ asset('/img/default.png') }}" class="img-fluid">
                            @else
                                <img src="{{ asset($post->image) }}" class="img-fluid">
                            @endif
                        </div>
                        <div class="col-lg-7 con">
                            <h5 class="name">{{ $post->owner[0]->members->first_name }} {{ $post->owner[0]->members->last_name }}<div></div></h5>
                            <h1 class="blog-content-title">{{ $post->title }}</h1>
                            <p class="blog-content">{!! html_entity_decode($post->content) !!}</p>

                            @if(count($prev))
                                <a href="{{ url('/post/' . $prev->slug) }}" class="prev btn btn-info"> &lt;&lt; Previous Article</a>
                            @else
                                <a href="javacript:void(0)" class="prev btn btn-info disabled"> &lt;&lt; Previous Article</a>
                            @endif

                            @if(count($next))
                                <a href="{{ url('/post/' . $next->slug) }}" class="next btn btn-info">Next Article &gt;&gt;</a>
                            @else
                                <a href="javascript:void(0)" class="next btn btn-info disabled">Next Article &gt;&gt;</a>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 side-blog" id="sidebar">
                <div class="row">
                    @if($posts[0])
                    <div class="col-md-12">
                        <div class="card">
                            @if(is_null($posts[0]->image))
                            <img class="card-img-top" src="{{ asset('/img/default.png') }}" alt="{{ $posts[0]->title }}">
                            @else
                            <img class="card-img-top" src="{{ asset($posts[0]->image) }}" alt="{{ $posts[0]->title }}">
                            @endif
                            <div class="card-body">
                                <h4 class="card-title mb-3 blog-content-title-2">{{ $posts[0]->title }}</h4>
                                <p class="card-text">{!! substr(html_entity_decode($posts[0]->content), 0, 100) !!}...</p>
                                <a href="{{ url('/post/' . $posts[0]->slug) }}" class="continue">Continue reading...</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <br/><br/>
                <div class="row">
                    @if(isset($posts[1]))
                        <div class="col-md-12">
                            <div class="card">
                                @if(is_null($posts[1]->image))
                                    <img class="card-img-top" src="{{ asset('/img/default.png') }}" alt="{{ $posts[1]->title }}">
                                @else
                                    <img class="card-img-top" src="{{ asset($posts[1]->image) }}" alt="{{ $posts[1]->title }}">
                                @endif
                                <div class="card-body">
                                    <h4 class="card-title mb-3 blog-content-title-2">{{ $posts[1]->title }}</h4>
                                    <p class="card-text">{!! substr(html_entity_decode($posts[1]->content), 0, 100) !!}...</p>
                                    <a href="{{ url('/post/' . $posts[1]->slug) }}" class="continue">Continue reading...</a>
                                </div>
                            </div>
                        </div>
                    @endif
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