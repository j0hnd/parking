@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Fill up User Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="user-form" class="form-horizontal" method="post" action="{{ url('/admin/users') }}">
                    @include('app.User.partials._form')

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
            $('#role-id').select2({ placeholder: '-- Roles --' });
        });
    </script>
@stop
