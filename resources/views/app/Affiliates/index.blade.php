@extends('admin_template')

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			@include('common.flash')
			<div class="box">
				<div class="box-header">
					<a href="{{ url('/admin/affiliates/create') }}" class="btn bg-navy btn-flat">Create Affiliate</a>

					<div class="box-tools" style="margin-top: 7px">
						<form action="{{ url('/admin/affiliate/search') }}" method="post">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" name="search" class="form-control pull-right" placeholder="Search">

								<div class="input-group-btn">
									<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
								</div>
							</div>
							{{ csrf_field() }}
						</form>
					</div>
				</div>

				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody>
						<tr>
							<th>Travel Agent</th>
							<th>Code</th>
							<th>Distributions</th>
							<th></th>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop