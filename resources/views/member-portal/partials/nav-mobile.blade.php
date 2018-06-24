<div id="mobileNav" class="overlay-nav">
	<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
	<div class="overlay-content">
		<a href="{{ url('/members/dashboard') }}">Dashboard</a>
		@if($user->roles[0]->slug == 'vendor')
			<a href="{{ url('/members/products') }}">My Products</a>
		@endif
		<a href="{{ url('/members/profile') }}">Profile</a>
		<a href="{{ url('/members/inbox') }}">Inbox</a>
		<a href="{{ url('/logout') }}">Logout</a>
	</div>
</div>