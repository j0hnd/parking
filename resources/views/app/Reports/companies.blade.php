@extends('admin_template')

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-tools" style="margin-top: 7px">
						<form action="{{ url('/admin/airport/search') }}" method="post">
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

				<div class="box-body table-responsive no-padding margin-top30">
					<table class="table table-hover">
						<thead>
						<tr>
							<th>Company Name</th>
							<th>Phone No./Mobile No.</th>
							<th>Email</th>
							<th>POC Name</th>
							<th>POC Contact No.</th>
							<th>POC Contact Email</th>
						</tr>
						</thead>
						<tbody>
						@if($companies)
							@foreach($companies as $company)
							<tr>
								<td>{{ $company->company_name }}</td>
								<td>{{ ($company->phone_no) ? $company->phone_no : 'N/A' }} <span class="margin-left5 margin-right5">/</span> {{ ($company->mobile_no) ? $company->mobile_no : 'N/A' }} </td>
								<td>{{ $company->email }}</td>
								<td>{{ ucwords($company->poc_name) }}</td>
								<td>{{ $company->poc_contact_no }}</td>
								<td>{{ $company->poc_contact_email }}</td>
							</tr>
							@endforeach
						@endif
						</tbody>
						@if(count($companies))
						<tfoot>
							<tr>
								<td colspan="6" style="padding-right: 20px; text-align: right;">{{ $companies->links() }}</td>
							</tr>
						</tfoot>
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>
@stop