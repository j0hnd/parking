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
                            <th></th>
                        </tr>
                        @if(count($products))
                            @foreach($products as $product)
                                <tr>
                                    <td>
                                        @php($carpark = json_decode($product->carpark, true))
                                        {{ $carpark['name'] }}
                                    </td>
                                    <td>
                                        @if($product->airport)
                                            <ul>
                                            @foreach($product->airport as $airport)
                                            <li>{{ $airport->airport_name }}</li>
                                            @endforeach
                                            </ul>
                                        @else
                                        <span>Not Available</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/product/'.$product->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $product->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">No products listed</td>
                            </tr>
                        @endif
                        </tbody>
                        @if(count($products))
                            <tfoot>
                            <tr>
                                <td colspan="3" style="padding-right: 20px; text-align: right;">{{ $products->links() }}</td>
                            </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop