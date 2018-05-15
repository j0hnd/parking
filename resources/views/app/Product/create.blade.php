@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Fill up Product Details</h3>
                </div>
                <!-- /.box-header -->

                @if(isset($product))
                    @php($action_url = url("/admin/product/update"))
                @else
                    @php($action_url = url("/admin/product"))
                @endif

                <!-- form start -->
                <form id="carpark-form" class="form-horizontal" method="post" action="{{ $action_url }}">
                    @include('app.Product.partials._form')

                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-right" style="margin-left: 7px;">Cancel</button>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Save</button>
                    </div>
                    <!-- /.box-footer -->

                    {{ csrf_field() }}
                    @if(isset($product))
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @endif
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $('#carpark-id').select2({ placeholder: '-- Carpark --' });
            $('#airport-id').select2({ placeholder: '-- Airport --' });

            $('#description').wysihtml5();
            $('#on_arrival').wysihtml5();
            $('#on_return').wysihtml5();

            $('.overrides').daterangepicker();

            var row_limit = 15;
            var row_count = '{{ $row_count }}';

            $(document).on('keyup', '.price-value', function (e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });

            $(document).on('click', '#toggle-create-row', function () {
                var src = $('#first-row').clone();
                if (row_count < row_limit) {
                    src.find('input').val(0);
                    $('#prices-container').append(src);
                    row_count++;
                } else {
                    alert("You can only add "+ row_limit +" price category variance.");
                }
            });

            $(document).on('click', '#toggle-remove-row', function () {
                var row = $(this).parent().parent().parent();
                if (row_count == 1) {
                    alert('Unable to delete this last row.');
                } else {
                    row_count--;
                    row.remove();
                }
            });

            $(document).on('click', '.toggle-create-override-row', function () {
                var src = $('#override-wrapper').clone();
                if (row_count < row_limit) {
                    src.find('input').val(0);
                    $('#override-container').append(src);
                    $('.overrides').daterangepicker();
                    row_count++;
                } else {
                    alert("You can only add "+ row_limit +" override variance.");
                }
            });

            $(document).on('click', '.toggle-remove-override-row', function () {
                var row = $(this).parent().parent().parent();
                if (row_count == 1) {
                    alert('Unable to delete this last row.');
                } else {
                    row_count--;
                    row.remove();
                }
            });
        });
    </script>
@stop
