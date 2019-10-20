<?php
echo cdn_datatables();
?>
<div class="row">
    <div class="col-md-3">
        <form method="post" action="{{route('core.users.group.store')}}">
            @csrf
            <div class="form-group required">
                <label class="ctl">Name</label>
                <input type="text" name="name" id="name" pattern="[^\s]+" class="form-control no-space" placeholder="User Group Name" maxlength=30 required/>
                <small class="help-block">(*) without space</small>
            </div>
            <div class="form-group required">
                <label class="ctl">Title</label>
                <input type="text" maxlength=100 name="value" id="value" class="form-control " placeholder="User Group Title" required/>
            </div>
            <div class="form-group required">
                <button type="submit" class="btn btn-primary btn-flat">Add User Group</button>
            </div>
        </form>
    </div>
    <div class="col-md-9">
        <div class="table-responsive">
            <table class="table table-bordered datatable-render">
                <thead>
                    <th>User Group Name</th>
                    <th>User Group Title</th>
                    <th></th>
                </thead>
                <tbody>
                @if (isset($data))
                @foreach ($data as $row)
                <tr>
                    <td>{{ $row->group_name }}</td>
                    <td>{{ $row->group_value }}</td>
                    <td>
                        <a href="{{ route('core.users.group.edit', $row->id) }}" class="btn btn-xs btn-info" title="Edit"><i class="fa fa-edit"></i></a>
                        <a onclick="return confirm('Are you sure delete this user group?');" href="{{ route('core.users.group.delete', $row->id) }}" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>