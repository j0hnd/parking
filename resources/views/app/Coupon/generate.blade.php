@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <form id="airport-form" class="form-horizontal" method="post" action="{{ url('/admin/coupons') }}">
                    <div class="box-body">
                        @include('common.flash')

                        <div class="col-xs-6">
                            <div class="box-header with-border">
                                <h3 class="box-title">Fill up Coupon Information</h3>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Number of Coupons </label>

                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="no_coupons"
                                           placeholder="Number of Coupon"
                                           value="10"
                                           autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Percent Discount </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="reward"
                                           placeholder="Percent Discount"
                                           autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Expiration Date </label>

                                <div class="col-sm-9">
                                    <input type="text" id="expiry-date" class="form-control" name="expiry_date"
                                           placeholder="Expiration Date"
                                           autocomplete="off">
                                </div>
                            </div>
                            <!-- form start -->
                        </div>

                        {{ csrf_field() }}

                    </div>

                    <div class="box-footer">
                        <a href="{{ url('/admin/coupons') }}" class="btn btn-default pull-right margin-left5" >Cancel</a>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript">
$(function () {
    $('#expiry-date').datepicker({
        autoclose: true,
        orientation: 'bottom',
        format: 'dd/mm/yyyy'
    })
});
</script>
@stop
