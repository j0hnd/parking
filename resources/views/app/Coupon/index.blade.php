@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('/admin/coupons/generate') }}" class="btn bg-navy btn-flat">Generate Coupons</a>

                    <div class="box-tools" style="margin-top: 7px">
                        <form action="{{ url('/admin/users/search') }}" method="post">
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
                        <thead>
                            <tr>
                                <th>Promo Codes</th>
                                <th>Discount</th>
                                <th>Expiry Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="coupons-container">
                            @include('app.Coupon.partials._coupons')
                        </tbody>
                        <tfoot>
                        @if(count($promocodes))
                            <tr>
                                <td colspan="3">{{ $promocodes->links() }}</td>
                            </tr>
                        @endif
                        </tfoot>
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
		e.preventDefault();
        var id = $(this).data('id');
        if (confirm("Delete this coupon?")) {
            $.ajax({
                url: "{{ url('/admin/coupons/delete') }}/" + id,
                type: 'post',
                data: { _token: "{{ csrf_token() }}" },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#coupons-container').html(response.html);
                        alert('Coupon has been deleted');
                    } else {
                        alert(response.message);
                    }
                }
            });
		}
    });
});
</script>
@stop
