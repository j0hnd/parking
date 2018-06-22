<div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
	<div class="text-center" id="navbarsExample11">
		@if(isset($user))
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link contact" href="{{ url('/members/dashboard') }}">Dashboard</a></li>
			<li><div class="vl Vl"></div></li>
			<li class="nav-item"><a class="nav-link contact" href="{{ url('/members/profile') }}">Profile</a></li>
			<li><div class="vl Vl"></div></li>
			<li class="nav-item"><a class="nav-link contact" href="{{ url('/logout') }}">Logout</a></li>
			<li><div class="vl Vl"></div></li>
			<li><div class="noti__item js-item-menu data-toggle="tooltip" title="Inbox"">
                                        <i class="zmdi zmdi-email"></i>
                                        <span class="quantity">3</span>
                                        <div class="email-dropdown js-dropdown">
                                            <div class="email__title">
                                                <p>You have 3 New Emails</p>
                                            </div>
                                            <div class="email__item">
                                                <div class="content">
                                                	<a href="{{ url('/members/email') }}">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, 3 min ago</span>
                                                	</a>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="content">
                                                	<a href="{{ url('/members/email') }}">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, Yesterday</span>
                                                	</a>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="content">
                                                	<a href="{{ url('/members/email') }}">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, April 12,,2018</span>
                                                	</a>
                                                </div>
                                            </div>
                                            <div class="email__footer">
                                                <a href="{{ url('/members/inbox') }}">See all emails</a>
                                            </div>
                                        </div>
                                    </div></li>
		</ul>
		@endif
	</div>
</div>