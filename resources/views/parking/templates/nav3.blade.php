@if(isset($success))
	@php(print_r('xxx 1'))
@else
	@php(print_r('xxx 2'))
@endif

<ul class="navbar-nav ul-pos" style="margin-left: 135px; position: absolute;">
	<li class="nav-item active-2"><a class="nav-link link-2" href="#">Airport</a></li>
	<li class="nav-item not-active"><a class="nav-link link-2" href="#">Meet & Greet</a></li>
	<li class="nav-item not-active"><a class="nav-link link-2" href="#">On Airport</a></li>
	<li class="nav-item not-active"><a class="nav-link link-2" href="#">Off Airport</a></li>
</ul>