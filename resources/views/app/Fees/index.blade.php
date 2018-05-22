@extends('admin_template');
@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			@include('common.flash')
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody>
						<tr>
							<th>Fees</th>
							<th>Amount</th>
							<th></th>
						</tr>
						@if(count($fees))
							@foreach($fees as $fee)
								<tr>
									<td>{{ ucwords(str_replace('_', ' ', $fee->fee_name)) }}</td>
									<td>£{{ $fee->amount }}</td>
									<td>
										<a href="{{ url('/admin/fees/'.$fee->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										{{--<button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $fee->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>--}}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4" class="text-center">No fees listed</td>
							</tr>
						@endif
						</tbody>
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
                if (confirm('Delete the selected fee?')) {
                    $.ajax({
                        url: '/admin/fee/' + id + '/delete',
                        type: 'post',
                        data: { _token: '{{ csrf_token() }}' },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                window.location = '/admin/fee';
                            }
                        }
                    });
                }
            });
		});
	</script>
@stop