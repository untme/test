<script type="text/javascript">

	// Submit Add new admin requests.
    $("#submitAdminBox").click(function(){
    
    	var newAdminName = $("#new_admin_name").val();
    	var newAdminEmail = $("#new_admin_email").val();
    	var newAdminType = $("#new_admin_type").val();
    	var newAdminPasswd = $("#new_admin_passwd").val();
    	var newRetype = $("#new_retype").val();
    
    	if (newAdminName == '') {
    		
    		alert("请填写管理员登陆账号!");
    		return false;
    		
    	}
    	
    	if (newAdminPasswd == '') {
    		
    		alert("请填写管理员登陆密码!");
    		return false;
    		
    	}
    	
    	if (newAdminPasswd != newRetype) {
    		
    		alert("两次填写的密码不一致!");
    		return false;
    		
    	}
    	
    	$.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/admin/adding_admin/",
        	data: "newAdminName=" + newAdminName + "&newAdminEmail=" + newAdminEmail +"&newAdminType=" + newAdminType + "&newAdminPasswd=" + newAdminPasswd,
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
		添加新管理员
	</div>
	<div class='popdiv_content'>
		<form>
			<p>
				<span>管理员账号 : </span>
				<label>
					<input id="new_admin_name" class="text-input medium-input" type="text" name="new_admin_name" value="" />
				</label>
			</p>

			<p>
				<span>管理员邮箱 : </span>
				<label>
					<input id="new_admin_email" class="text-input medium-input" type="text" name="new_admin_email" value="" />
				</label>
			</p>

			<p>
				<span>管理员角色 : </span>
				<label>
					<select id="new_admin_type">
						<option value="1" selected="selected">超级管理员</option>
						<option value="2">数据管理员</option>
						<option value="4">商铺管理员</option>
					</select></label>
			</p>

			<p>
				<span>设置新密码 : </span>
				<label>
					<input id="new_admin_passwd" class="text-input medium-input" type="password" name="new_admin_passwd" value="" />
				</label>
			</p>

			<p>
				<span>重复新密码 : </span>
				<label>
					<input id="new_retype" class="text-input medium-input" type="password" name="new_retype" value="" />
				</label>
			</p>

		</form>
	</div>
	<div class='popdiv_buttons'>
		<a class='buttons' id="submitAdminBox" href='javascript:void(0);' >提交</a>
	</div>
	
</div>
