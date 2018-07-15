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
            <form id="user-form" class="form-horizontal" method="post" action="{{ url('/admin/users/update') }}">
                @include('app.User.partials._form')

                <div class="form-group">
                    <label class="col-sm-2 control-label">New Password</label>

                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Confirm Password</label>

                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" autocomplete="off">
                    </div>
                </div>

                <div class="box-footer">
                    <a href="{{ url('/admin/users') }}" class="btn btn-default pull-right margin-left5" >Cancel</a>
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
        $('#role-id').select2({ placeholder: '-- Roles --' });
    });
</script>
@stop
