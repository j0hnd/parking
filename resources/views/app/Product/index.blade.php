@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('/admin/product/create') }}" class="btn bg-navy btn-flat">Add Product</a>

                    <div class="box-tools" style="margin-top: 7px">
                        <form action="{{ url('/admin/product/search') }}" method="post">
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
                                <th>Carpark</th>
                                <th>Airport</th>
                                <th>Product</th>
                                <th></th>
                            </tr>
                        </thead>


                        <tbody id="products-container">
                            @include('app.Product.partials._list')
                        </tbody>

                        @if(count($products))
                            <tfoot>
                            <tr>
                                <td colspan="4" style="padding-right: 20px; text-align: right;">{{ $products->links() }}</td>
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
    <script>
        $(function () {
            $(document).on('click', '#toggle-delete', function () {
                var id = $(this).data('id');
                if (confirm("Delete this product?")) {
                    $.ajax({
                        url: '/admin/product/'+ id +'/delete',
                        type: 'post',
                        data: { _token: '{{ csrf_token() }}' },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                window.location = '/admin/product';
                            }
                        }
                    });
                }
            });

            $(document).on('click', '.toggle-product', function () {
                var _status = $(this).data('status');
                var _id = $(this).data('id');

                if (_status == 'deactivate') {
                    if (confirm('Deactivate this product?')) {
                        toggleProduct(_id, _status);
                    }
                }

                if (_status == 'activate') {
                    toggleProduct(_id, _status);
                }
            });

            function toggleProduct(id, status) {
                var _data= {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                };

                $.ajax({
                    url: "{{ url('/admin/product/toggle') }}",
                    type: "post",
                    data: _data,
                    dataType: 'json',
                    success: function (response) {
                        alert(response.message);
                        if (response.status) {
                            $('#products-container').html(response.data.html)
                        }
                    }
                });
            }
        });
    </script>
@stop