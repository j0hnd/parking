@extends('member-portal')

@section('css')
	<link href="{{ asset('/css/member-portal.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/inbox.css') }}" rel="stylesheet">
@stop

@section('main-content')
	@include('member-portal.partials.nav-mobile')

	@include('member-portal.partials.nav-header')

	<br/>
	<div class="page-content--bgf7">
		@include('member-portal.partials.breadcrumbs', ['page_title' => 'Inbox'])

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
										@foreach($messages as $msg)
											<div class="au-task__item au-task__item--primary">
												<div class="au-task__item-inner">
													<div class="container">
														<div class="row">
															<div class="col-lg-4">
																<span {{ ($msg->status == 'unread' ? 'class=time' : '')}}>{{$msg->name}}</span>
															</div>
															<div class="col-lg-5">
																<h5 class="task">
																	<a href="{{ url('/members/email/'.$msg['id']) }}">{{$msg->subject}}</a>
																</h5>
															</div>
															<div class="col-lg-3 text-right">
																<span {{ $msg->status == 'unread' ? 'class=time' : ''}}>{{date('h:i a', strtotime($msg->created_at))}}</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										@endforeach
									</div>
									<div class="au-task__footer">
									{{$messages->links()}}
									<!-- <button class="au-btn au-btn-load js-load-btn">load more</button> -->
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
