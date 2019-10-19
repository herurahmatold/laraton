@php
echo cdn_datatables();
echo cdn_select2();
@endphp
<p>
<div class="row">
    <div class="col-md-2">
        <a href="{{ route('core.users.user.add') }}" class="btn btn-primary btn-flat btn-sm">Add User</a>
    </div>
    <div class="col-md-3">
        <select id="status" data-allow-clear="true" class="form-control select2" style="width:100%" data-placeholder="Choose Status" >
            <option></option>
            @if (!empty($status))
            @foreach ($status as $k=>$v)
            <option value="{{$k}}">{{$v}}</option>
            @endforeach
            @endif
        </select>
    </div>
    <div class="col-md-5">
        <select id="group" class="form-control " style="width:100%" data-placeholder="Choose User Group" >
            <option></option>
        </select>
    </div>
    
</div>
</p>

<div class="table-responsive">
    <table class="table table-bordered table-hover" id="datatables">
        <thead>
            <th>Full Name</th>
            <th>User Group</th>
            <th>Email</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
$(document).ready(function(){

    refresh_data();

    $("#status").on('change',function(){
        refresh_data();
    });

    $("#group").on('change',function(){
        refresh_data();
    });

    $("#group").select2({
        allowClear:true,
        ajax:{
            url:"{{route('core.users.group.get')}}",
            dataType:'json',
            delay:0,
            data:function(params){
                return {
                    q: params.term,
                    };
            },
            processResults: function (data,params) {
                params.page = params.page || 1;
                    return {
                    results: $.map(data, function(obj) {
                        return { id: obj.id, text: obj.value };
                    }),
                };
            },
            cache:true
        },
    });

});

function refresh_data()
{
    var status=$("#status").val();
    if(typeof status=='undefined')
    {
        status='';
    }
    var group=$("#group").val();
    if(typeof group=='undefined')
    {
        group='';
    }
    $('#datatables').dataTable().fnDestroy();
    $('#datatables').DataTable({
        serverSide: true,
        processing: true,
        ajax: '<?=route("core.users.user.get");?>?status='+status+"&group="+group,
        columns: [
            {data: 'nama', name: 'nama'},
            {data: 'group', name: 'group'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action'}
        ]
    });
}
</script>