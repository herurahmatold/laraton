@php
echo cdn_select2();
@endphp

<form method="post" id="frmadd" enctype="multipart/form-data" class="form-horizontal">
@csrf

    <div class="form-group required">
		<label class="control-label col-sm-2">User Group</label>
		<div class="col-md-7">
			<select id="group" name="group" class="form-control ipts select2" required="" style="width: 100%" data-placeholder="Choose User Group">
				<option></option>
			</select>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Full Name</label>
		<div class="col-md-10">
			<input type="text" name="full_name" id="full_name" class="form-control ipt" required="" placeholder="Full Name" value="{{old('full_name')}}"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Username</label>
		<div class="col-md-4">
			<input type="text" name="username" id="username" class="form-control ipt" required="" placeholder="Username" value="{{old('username')}}"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Email</label>
		<div class="col-md-6">
			<input type="email" name="email" id="email" class="form-control ipt" required="" placeholder="Email" value="{{old('email')}}"/>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">New Password</label>
		<div class="col-md-4">
			<?=com_password('p1','New Password',TRUE,'ipt');?>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">Confirm Password</label>
		<div class="col-md-4">
			<?=com_password('p2','Confirmation Password',TRUE,'ipt');?>
		</div>
	</div>
	<div class="form-group required">
		<label class="control-label col-sm-2">User Status</label>
		<div class="col-md-3">
			<select id="status" name="status" class="form-control ipts select2" required="" style="width: 100%" data-placeholder="Choose Status User">
				<option></option>
				@if (!empty($status))
                @foreach ($status as $k=>$v)
                <option value="{{$k}}">{{$v}}</option>
                @endforeach
                @endif
			</select>
		</div>
	</div>
	<div class="form-group ">
		<label class="control-label col-sm-2">Action After Added</label>
		<div class="col-md-10">
			<label class="checkbox-inline">
				<input type="checkbox" name="reload"/> Add New Record After Added
			</label>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2">&nbsp;</label>
		<div class="col-md-10">
			<button type="submit" class="btn btn-primary">Add User</button>
			<a href="{{route('core.users.user')}}" class="btn btn-default">Cancel</a>
		</div>
	</div>

</form>

<script>
$(document).ready(function(){

    $("#frmadd").on('submit',function(e){
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "{{route('core.users.user.store')}}",
            data: formData,
            type: "post",
            dataType : "json",
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(  ) {
                overlay_show();
              },
            })
              .done(function( x ) {
                if(x.status==true)
		  		{
					if(x.reload==0)
					{
                        alert(x.message);
						$(".ipt").val('');
						$(".ipts").val('').trigger('change');
					}else if(x.reload==1)
					{
                        alert(x.message);
						window.location="{{route('core.users.user')}}";
					}
				}else{
					alert(x.message);
				}
				overlay_hide();
              })
              .fail(function( ) {
                alert('Server not respond!!');
                overlay_hide();
              })
              .always(function( ) {
                
        });
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
</script>