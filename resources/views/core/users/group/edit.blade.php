<form method="post" class="form-horizontal" action="{{route('core.users.group.update')}}">
    <input type="hidden" name="id" value="{{$data->id}}"/>
@csrf
    <div class="form-group ">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-md-3">
            <input type="text" name="name" id="name" pattern="[^\s]+" class="form-control no-space" placeholder="User Group Name" maxlength=30 required value="{{$data->group_name}}"/>
            <small class="help-block">(*) without space</small>
        </div>
    </div>
    <div class="form-group ">
        <label class="control-label col-sm-2">Title</label>
        <div class="col-md-6">
            <input type="text" maxlength=100 name="value" id="value" class="form-control " placeholder="User Group Title" required value="{{$data->group_value}}"/>
        </div>
    </div>
    <div class="form-group">
            <label class="control-label col-sm-2">&nbsp;</label>
            <div class="col-md-10">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('core.users.group')}}" class="btn btn-default">Cancel</a>
            </div>
        </div>
</form>