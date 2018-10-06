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
                <form id="carpark-form" class="form-horizontal" method="post" action="{{ $action_url }}" enctype="multipart/form-data">
                    @include('app.Product.partials._form')

                    <div class="box-footer">
                        <a href="{{ url('/admin/product') }}" class="btn btn-default pull-right margin-left5" >Cancel</a>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Save</button>
                    </div>
                    <!-- /.box-footer -->

                    {{ csrf_field() }}
                    @if(isset($product))
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="price-id" name="price_ids">
                    @endif
                </form>
            </div>
        </div>
    </div>
@stop

@section('styles')
    <style>
        .override-date {
            background-color: #FFFFFF !important;
        }
    </style>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $('#carpark-id').select2({ placeholder: '-- Carpark --' });
            $('#airport-id').select2({ placeholder: '-- Airport --' });

            $('#description').wysihtml5();
            $('#on_arrival').wysihtml5();
            $('#on_return').wysihtml5();

            $('.overrides').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('.overrides').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            $('.closed_date').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('.closed_date').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            var row_limit = 31;
            var override_count = '{{ $override_count }}';
            var row_count = '{{ $row_count }}';
            var row_count_cd = '{{ $row_count_cd }}';
            var price_id = new Array();

            if (row_count == 1) {
                row_count = 1;
            }

            if (row_count_cd == 1) {
                row_count_cd = 1;
            }

            $(document).on('blur', '.price-value', function (e) {
                if (/^[0-9]+(\.[0-9]{1,3})?$/.test($(this).val())) {
                    return true;
                } else {
                    $(this).val('0');
                }
            });

            $(document).on('click', '#toggle-create-row', function () {
                var src = $('#first-row').clone();
                src.find('input').val(0);
                src.find('.price-category').val($('#first-row select.price-category').val()).prop('selected', true);
                src.find('.price-category').attr('disabled', 'disabled');
                $('#prices-container').append(src);
                row_count++;
            });

            $(document).on('click', '#toggle-remove-row', function () {
                var row = $(this).parent().parent().parent();
                if (row_count == 1) {
                    alert('Unable to delete this last row.');
                } else {
                    // if ($(this).data('price-id') !== undefined) {
                    //     price_id.push($(this).data('price-id'));
                    //     $('#price-id').val(price_id.join(':'));
                    // }
                    
                    row_count--;
                    row.remove();
                }
            });

            $(document).on('click', '.toggle-create-override-row', function () {
                var src = $('#override-wrapper').clone();
                if (override_count < row_limit) {
                    src.find('.override-date').val('');
                    src.find('.override-price').val(0);
                    $('#override-container').append(src);
                    $('.overrides').daterangepicker({
                        autoUpdateInput: false,
                        locale: {
                            format: 'DD/MM/YYYY'
                        }
                    });

                    $('.override-date').on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                    });

                    override_count++;
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

            $(document).on('click', '.toggle-create-row-cd', function () {
                var src = $('#first-row-cd').clone();
                src.find('input').val('');
                $('#closed-date-container').append(src);
                $('.closed_date').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                });

                $('.closed_date').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                });

                row_count_cd++;
            });

            $(document).on('click', '.toggle-remove-row-cd', function () {
                var row = $(this).parent().parent().parent();
                if (row_count_cd == 1) {
                    if ($(this).parent().parent().parent().find('.closed_date').val().length > 0) {
                        $('.toggle-create-row-cd').trigger('click');
                        row_count_cd--;
                    row.remove();
                    } else {
                        alert('Unable to delete this last row.');
                    }
                } else {
                    row_count_cd--;
                    row.remove();
                }
            });
        });
    </script>
@stop
