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
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($promocodes))
                            @foreach($promocodes as $promocode)
                                @if(strtotime(date('Y-m-d')) < strtotime($promocode->expiry_date))
                                <tr>
                                    <td>{{ $promocode->code }}</td>
                                    <td>{{ $promocode->reward * 100 }}%</td>
                                    <td>{{ date('d/m/Y', strtotime($promocode->expiry_date)) }}</td>
                                </tr>
                                @endif
                            @endforeach
                        @endif
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

});
</script>
@stop
