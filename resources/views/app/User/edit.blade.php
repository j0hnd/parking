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
                <form id="airport-form" class="form-horizontal" method="post" action="{{ url('/admin/users/update') }}">
                    @include('app.User.partials._form')

                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-right" style="margin-left: 7px;">Cancel</button>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Update</button>
                    </div>
                    <!-- /.box-footer -->

                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $user->id }}">
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $('#role-id').select2({ placeholder: '-- Role --' });
        });
    </script>
@stop
