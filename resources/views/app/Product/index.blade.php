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
                        <tbody>
                        <tr>
                            <th>Carpark</th>
                            <th>Airport</th>
                            <th>Product</th>
                            <th></th>
                        </tr>
                        @if(count($products))
                            @foreach($products as $product)
                                @if(isset($product->airport[0]))
                                    @if(is_null($product->airport[0]->deleted_at))
                                        <tr>
                                            <td>
                                                @php($carpark = json_decode($product->carpark, true))
                                                {{ $carpark['name'] }}
                                            </td>
                                            <td>
                                                <ul>
                                                    <li>{{ $product->airport[0]->airport_name }}</li>
                                                </ul>
                                            </td>
                                            <td>{{ $product->prices[0]->categories->category_name }}</td>
                                            <td>
                                                <a href="{{ url('/admin/product/'.$product->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $product->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No products listed</td>
                            </tr>
                        @endif
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
        });
    </script>
@stop