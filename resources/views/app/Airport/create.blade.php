@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Fill up Airport Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="airport-form" class="form-horizontal" method="post" action="{{ url('/admin/airport') }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Airport Name</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="airport_name" placeholder="Airport Name" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Description</label>

                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="address" placeholder="Address" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address 2</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="address2" placeholder="Address 2" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">City</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="city" placeholder="City" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">County/State</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="county_state" placeholder="County/State" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Country</label>

                            <div class="col-sm-6">
                                <select name="country_id" id="countries" class="form-control">
                                    <option value="">-- Country --</option>
                                    @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Postal Code</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="zipcode" placeholder="Postal Code" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Longitude</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="longitude" placeholder="Longitude" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Latitude</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="latitude" placeholder="Latitude" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Sub-Category</label>

                            <div class="col-sm-6">
                                <select name="subcategory" id="subcategory" class="form-control"></select>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->

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
        $('#countries').select2();
        $('#subcategory').select2();
    });
</script>
@stop