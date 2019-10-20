@php
echo add_css(asset('assets/css/profile.css'));
echo cdn_select2();
@endphp

<div class="row">
	<div class="col-md-3">
		
		<div class="profil-left-box">
			
			<div class="image-wrapper">
			  <span class="image-overlay" id="ovv-img">
			    <span class="content" >
			    	<a href="javascript:;" id="tukarphoto"><i class="fa fa-camera"></i> <br/>Change Avatar</a>
			    </span>
			  </span>
			  <img src="<?=user_avatar_custom($data->id,"200");?>" class="img-circle img-bordered my-avatar-medium"/>
			  <form id="formphoto">
                @csrf
			  	<input type="file" name="file" id="file" style="display: none;"/>
			  </form>
			</div>            
			
			<div class="progress" style="display: none;">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
			  </div>
            </div>
            <h3 class="profile-username text-center">{{user_info_custom($data->id,'name')}}</h3>
            <p class="text-muted text-center">{{user_group_name_custom($data->id)}}</p>
        </div>
	</div>
	<div class="col-md-9">
		<form method="post" action="{{route('core.users.user.update')}}" class="form-horizontal">
        @csrf
        <input type="hidden" name="userid" value="{{$data->id}}"/>
        <div class="form-group required">
            <label class="control-label col-sm-3">User Group</label>
            <div class="col-md-7">
                <select id="group" name="group" class="form-control ipts select2" required="" style="width: 100%" data-placeholder="Choose User Group">
                    <option></option>
                    @if (!empty($data->user_group_id))
                    <option value="{{ $data->user_group_id }}" selected="">{{user_group_value_custom($data->id)}}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="form-group row required">
            <label class="control-label col-sm-3">Name</label>
            <div class="col-md-7">
                <input type="text" name="name" id="name" class="form-control " required="" placeholder="Name" value="{{user_info_custom($data->id,'name')}}"/>
            </div>
        </div>
        <div class="form-group  row required">
            <label class="control-label col-sm-3">Email</label>
            <div class="col-md-6">
                <input type="email" name="email" id="email" class="form-control " required="" placeholder="Email" value="{{user_info_custom($data->id,'email')}}"/>
            </div>
        </div>
        <div class="form-group required">
            <label class="control-label col-sm-3">User Status</label>
            <div class="col-md-3">
                <select id="status" name="status" class="form-control ipts select2" required="" style="width: 100%" data-placeholder="Choose Status User">
                    <option></option>
                    <?php
                    if(!empty($status))
                    {
                        foreach($status as $k=>$v)
                        {
                            $cs='';
                            if($data->status==$k)
                            {
                                $cs='selected=""';
                            }
                            echo '<option value="'.$k.'" '.$cs.'>'.$v.'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group ">
            <label class="control-label col-sm-3">&nbsp;</label>
            <div class="col-md-9">
                <label class="checkbox-inline">
                    <input type="checkbox" name="chp" id="chp"/> Reset Password
                </label>  
            </div>
        </div>
        <?php
        $arr=array('p2'=>'New Password','p3'=>'Confirm Password');
        foreach($arr as $k=>$v)
        {
            ?>
            <div class="form-group required chp-div" style="display:none;">
                <label class="control-label col-sm-3"><?=$v;?></label>
                <div class="col-md-4">
                    <input type="password" name="<?=$k;?>" id="<?=$k;?>" class="form-control chp-input" autocomplete="off" placeholder="Entri <?=$v;?>"/>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="form-group  row">
            <label class="control-label col-sm-3">&nbsp;</label>
            <div class="col-md-9">
                <button type="submit" class="btn btn-flat btn-primary">Change Profile</button>
            </div>
        </div>
        </form>
	</div>
</div>

<script>
$(document).ready(function(){

    $("#chp").on('change',function(){
        if(this.checked)
        {
            $(".chp-input").val('');
            $(".chp-input").attr('required',true);
            $(".chp-div").show('fade');
        }else{
            $(".chp-input").val('');
            $(".chp-input").attr('required',false);
            $(".chp-div").hide('fade');
        }
    });

    $("#tukarphoto").click(function(e){
        e.preventDefault();
        $("#file").trigger('click');
    });
    
    $("#file").change(function(){
        var photo=$(this).val();
        if(photo=="")
        {
            return false;
        }else{
            $("#formphoto").trigger('submit');
        }
    });

    $("#formphoto").on('submit',function(e){
		e.preventDefault();
		var formData = new FormData($(this)[0]);
		$.ajax({
		    url: "{{route('core.users.user.avatarupdate',$data->id)}}",
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
                    $(".my-avatar-medium").attr('src',x.img);
				}else{
                    alert(x.message);
                }
				overlay_hide();
		  	})
		  	.fail(function( ) {
		    	alert('Server Not Respond');
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