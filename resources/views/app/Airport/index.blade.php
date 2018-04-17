@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('/admin/airport/create') }}" class="btn bg-navy btn-flat">Add Airport</a>

                    <div class="box-tools" style="margin-top: 7px">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    @include('common.flash')

                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Airport Name</th>
                                <th>City</th>
                                <th>County/State</th>
                                <th></th>
                            </tr>
                            @if($airports->count())
                                @foreach($airports->get() as $airport)
                                <tr>
                                    <td>{{ $airport->airport_name }}</td>
                                    <td>{{ $airport->city }}</td>
                                    <td>{{ $airport->county_state }}</td>
                                    <td>
                                        <button type="button" class="btn bg-maroon btn-flat" data-id="{{ $airport->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        <button type="button" class="btn bg-orange btn-flat" data-id="{{ $airport->id }}"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        <button type="button" class="btn bg-olive btn-flat" data-id="{{ $airport->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center">No airport listed</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop