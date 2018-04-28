<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">First Name</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="first_name" placeholder="First Name" autocomplete="off" value="{{ isset($user->members->first_name) ? $user->members->first_name : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Last Name</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="last_name" placeholder="Last Name" autocomplete="off" value="{{ isset($user->members->last_name) ? $user->members->last_name : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Email Address</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="email" placeholder="Email Address" autocomplete="off" value="{{ isset($user->email) ? $user->email : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Role</label>

        <div class="col-sm-6">
            <select name="role_id" id="role-id" class="form-control">
                <option value="" readonly>-- Roles --</option>
                @foreach($roles as $role)
                    @if($user->roles[0]->id == $role->id)
                    <option value="{{ $role->id }}"selected>{{ $role->name }}</option>
                    @else
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
