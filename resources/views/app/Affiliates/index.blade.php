@extends('admin_template')

@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			@include('common.flash')
			<div class="box">
				<div class="box-header">
					<a href="{{ url('/admin/affiliates/create') }}" class="btn bg-navy btn-flat">Create Affiliate</a>

					<div class="box-tools" style="margin-top: 7px">
						<form action="{{ url('/admin/affiliates/search') }}" method="post">
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
							<th class="col-md-3">Travel Agent</th>
							<th class="col-md-5">Affiliate Link</th>
							<th class="col-md-2">Distributions</th>
							<th class="col-md-2"></th>
						</tr>

						<tbody>
						@if(count($affiliates))
							@foreach($affiliates as $affiliate)
							<tr>
								<td>{{ $affiliate->travel_agent->members->first_name }} {{ $affiliate->travel_agent->members->last_name }}</td>
								<td>{{ url('/affiliate/' . $affiliate->code . '/' . base64_encode($affiliate->travel_agent->members->affiliate_id)) }}</td>
								<td>
									<p>Admin: {{ $affiliate->percent_admin }}%</p>
									<p>Vendor: {{ $affiliate->percent_vendor }}%</p>
									<p>Travel Agents: {{ $affiliate->percent_travel_agent }}%</p>
								</td>
								<td>
									<a href="{{ url('/admin/affiliates/'.$affiliate->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									<button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $affiliate->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
								</td>
							</tr>
							@endforeach
						@else
						<tr>
							<td colspan="4" class="text-center">No affiliates found</td>
						</tr>
						@endif
						</tbody>

						@if(count($affiliates))
						<tfoot>
							<tr>
								<td colspan="4">{{ $affiliates->links() }}</td>
							</tr>
						</tfoot>
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
<script type="text/javascript">
    $(function () {
        $(document).on('click', '#toggle-delete', function (e) {
            var id = $(this).data('id');
            if (confirm('Delete the selected affiliate?')) {
                $.ajax({
                    url: '/admin/affiliates/' + id + '/delete',
                    type: 'post',
                    data: { _token: '{{ csrf_token() }}' },
                    dataType: 'json',
                    success: function (response) {
                        if (response) {
                            window.location = '/admin/affiliates';
                        }
                    }
                });
            }
        });
    });
</script>
@stop