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
                <!-- form start -->
                <form id="carpark-form" class="form-horizontal" method="post" action="{{ url('/admin/product') }}">
                    @include('app.Product.partials._form')

                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-right" style="margin-left: 7px;">Cancel</button>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Save</button>
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
            $('#carpark-id').select2({ placeholder: '-- Carpark --' });
            $('#airport-id').select2({ placeholder: '-- Airport --' });

            $('#description').wysihtml5();
            $('#on_arrival').wysihtml5();
            $('#on_return').wysihtml5();

            var row_limit = '{{ $priceCategories->count() }}';
            var row_count = 1;

            $(document).on('click', '#toggle-create-row', function () {
                var src = $('tbody tr:first').clone();
                if (row_count < row_limit) {
                    src.find('input').val(0);
                    $('#price-form-wrapper').append(src);
                    row_count++;
                } else {
                    alert("You can only add "+ row_limit +" price category variance.");
                }
            });

            $(document).on('click', '#toggle-remove-row', function () {
                var row = $(this).closest('tr');
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