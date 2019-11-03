@php
echo add_css(asset('assets/css/profile.css'));
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
			  <img src="<?=user_avatar("200");?>" class="img-circle img-bordered my-avatar-medium"/>
			  <form id="formphoto">
                @csrf
			  	<input type="file" name="file" id="file" style="display: none;"/>
			  </form>
			</div>            
			
			<div class="progress" style="display: none;">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
			  </div>
            </div>
            <h3 class="profile-username text-center">{{user_info('name')}}</h3>
            <p class="text-muted text-center">{{user_group_name()}}</p>
        </div>
	</div>
	<div class="col-md-9">
		<form method="post" action="{{route('user.profile.update')}}" class="form-horizontal">
        @csrf
        <div class="form-group row required">
            <label class="control-label col-sm-3">Name</label>
            <div class="col-md-7">
                <input type="text" name="name" id="name" class="form-control " required="" placeholder="Name" value="{{user_info('name')}}"/>
            </div>
        </div>
        <div class="form-group  row required">
            <label class="control-label col-sm-3">Email</label>
            <div class="col-md-6">
                <input type="email" name="email" id="email" class="form-control " required="" placeholder="Email" value="{{user_info('email')}}"/>
            </div>
        </div>
        <div class="form-group ">
            <label class="control-label col-sm-3">&nbsp;</label>
            <div class="col-md-9">
                <label class="checkbox-inline">
                    <input type="checkbox" name="chp" id="chp"/> I want reset my password
                </label>  
            </div>
        </div>
        <?php
        $arr=array('p1'=>'Old Password','p2'=>'New Password','p3'=>'Confirm Password');
        foreach($arr as $k=>$v)
        {
            ?>
            <div class="form-group required chp-div" style="display:none;">
                <label class="control-label col-sm-3"><?=$v;?></label>
                <div class="col-md-4">
                    <input type="password" name="<?=$k;?>" id="<?=$k;?>" class="form-control chp-input" autocomplete="off" minlength="6" placeholder="Entri <?=$v;?>"/>
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
		    url: "{{route('user.profile.avatar.update')}}",
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

});
</script>