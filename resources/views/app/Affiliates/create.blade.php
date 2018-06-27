@extends('admin_template')
@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			@include('common.flash')

			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Fill up Affiliate Details</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form id="affiliate-form" class="form-horizontal" method="post" action="{{ url('/admin/affiliates') }}">
					@include('app.Affiliates.partials._form')

					<div class="box-footer">
						<button type="button" class="btn btn-default pull-right toggle-cancel" data-back="{{ url('/admin/affiliates') }}" style="margin-left: 7px;">Cancel</button>
						<button type="submit" id="toggle-save" class="btn btn-info pull-right">Generate</button>
					</div>
					<!-- /.box-footer -->

					{{ csrf_field() }}
				</form>
			</div>
		</div>
	</div>
@stop

@section('scripts')
<script type="text/javascript">
	$(function(){
		$('#travel-agents').select2({ placeholder: '-- Travel Agents --' });

		$(document).on('blur', '#percent-admin', function () {
			var _admin = $(this).val();
			var _vendor = $('#percent-vendor').val();

			if ((parseInt(_admin) + parseInt(_vendor)) > 100) {
				$(this).val('');
				$(this).focus();
				alert('The total of admin and vendor percentage should not be greater than 100');
			}
		});

		$(document).on('blur', '#percent-vendor', function () {
			var _admin = $('#percent-admin').val();
			var _vendor = $(this).val();

			if ((parseInt(_admin) + parseInt(_vendor)) > 100) {
				$(this).val('');
				$(this).focus();
				alert('The total of admin and vendor percentage should not be greater than 100');
			}
		});
	});
</script>
@stop
