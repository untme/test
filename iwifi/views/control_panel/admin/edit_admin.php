<script type="text/javascript">

	// Submit Add new admin requests.
    $("#editAdminBox").click(function(){
    
    	var editAdminID = $("#editAdminID").val();
    	var editAdminName = $("#edit_admin_name").val();
    	var editAdminEmail = $("#edit_admin_email").val();
    	var editAdminType = $("#edit_admin_type").val();
    	var editAdminPasswd = $("#edit_admin_passwd").val();
    	var editRetype = $("#edit_retype").val();
    
    	if (editAdminName == '') {
    		
    		alert("请填写管理员登陆账号!");
    		return false;
    		
    	}
    	
    	if (editAdminPasswd != editRetype) {
    		
    		alert("两次填写的密码不一致!");
    		return false;
    		
    	}
    	
    	$.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/admin/editing_admin_info/",
        	data: "editAdminID="+editAdminID+"&editAdminName=" + editAdminName + "&editAdminEmail=" + editAdminEmail +"&editAdminType=" + editAdminType + "&editAdminPasswd=" + editAdminPasswd,
        	beforeSend: function(XMLHttpRequest){
        		$.facebox({ div: '#doing' });
        	},
        	success: function(data){
        		
				if(data == 1) {
					
					window.location.reload();
				}
        	},
        	error: function(){
        		$.facebox({ alert: '对不起! 请求出现错误,请重新尝试!' });
        	}
        });
     
    });
    
</script>

<div class='popdiv'>
	<div class='popdiv_title'>
		编辑管理员
	</div>
	<div class='popdiv_content'>
		<form>
			<p>
				<span>管理员账号 : </span>
				<label>
					<input type="hidden" value="<?= $admin_info['admin_id']; ?>" id="editAdminID" />
					<input id="edit_admin_name" class="text-input medium-input" type="text" name="edit_admin_name" value="<?= $admin_info['admin_name']; ?>" />
				</label>
			</p>

			<p>
				<span>管理员邮箱 : </span>
				<label>
					<input id="edit_admin_email" class="text-input medium-input" type="text" name="edit_admin_email" value="<?= $admin_info['admin_email']; ?>" />
				</label>
			</p>

			<p>
				<span>管理员角色 : </span>
				<label>
					<select id="edit_admin_type">
						<?php if(_auth($admin_info['admin_type'], 'super')): ?>
						<option value="1" selected="selected">超级管理员</option>
						<option value="2">数据管理员</option>
						<option value="4">商铺管理员</option>
						<?php elseif(_auth($admin_info['admin_type'], 'analyze')): ?>
						<option value="1">超级管理员</option>
						<option value="2" selected="selected">数据管理员</option>
						<option value="4">商铺管理员</option>
						<?php elseif(_auth($admin_info['admin_type'], 'shop')): ?>
						<option value="1">超级管理员</option>
						<option value="2">数据管理员</option>
						<option value="4" selected="selected">商铺管理员</option>
						<? endif; ?>
					</select></label>
			</p>

			<p>
				<span>设置新密码 : </span>
				<label>
					<input id="edit_admin_passwd" class="text-input medium-input" type="password" name="edit_admin_passwd" value="" />
				</label>
			</p>

			<p>
				<span>重复新密码 : </span>
				<label>
					<input id="edit_retype" class="text-input medium-input" type="password" name="edit_retype" value="" />
				</label>
			</p>

		</form>
	</div>
	<div class='popdiv_buttons'>
		<a class='buttons' id="editAdminBox" href='javascript:void(0);' >修 改</a>
	</div>
	
</div>
