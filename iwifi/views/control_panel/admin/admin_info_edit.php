<script type="text/javascript">
$(document).ready(function(){
    $(".cancel").click(function(){
        $(document).trigger('close.facebox');
    });

    $(".yes").click(function(){
        
		var admin_id = $("#admin_id").val();
		var admin_name = $("#admin_name").val();
		var admin_email = $("#admin_email").val();
		var passwd = $("#admin_passwd").val();
		var retype = $("#retype").val();
		
		if (admin_name == '' || admin_email == '') {
			
			alert('请填写管理员账号和管理员邮箱!');
			
			return false; 
		}
		
		if (passwd != retype) {
			
			alert('两次输入的密码不一致!');
			
			return false; 
		}

        $.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/admin/admin_edit_doing/",
        	data: "admin_id=" + admin_id + "&admin_name=" + admin_name +"&admin_email=" + admin_email + "&passwd=" + encodeURIComponent(passwd),
        	beforeSend: function(XMLHttpRequest){
        		$.facebox({ div: '#doing' });
        	},
        	success: function(data){
        		$.facebox({ alert: data });
        		setTimeout("window.location.reload()", 3000);
        	},
        	error: function(){
        		$.facebox({ alert: '对不起! 请求出现错误,请重新尝试!' });
        	}
        });
    });
});
</script>
<div class='popdiv'>
  <div class='popdiv_title'>修改管理员信息</div>
  <div class='popdiv_content'>
    <form>
        <p>
            <span>管理员账号 : </span>
            <input type="hidden" id="admin_id" value="<?= $admin['admin_id']; ?>" />
            <label><input id="admin_name" class="text-input medium-input" type="text" name="admin_name" value="<?= $admin['admin_name']; ?>" /></label>
        </p>

        <p>
            <span>管理员邮箱 : </span>
            <label><input id="admin_email" class="text-input medium-input" type="text" name="admin_email" value="<?= $admin['admin_email']; ?>" /></label>
        </p>

        <p>
            <span>设置新密码 : </span>
            <label><input id="admin_passwd" class="text-input medium-input" type="password" name="admin_passwd" value="" /></label>
        </p>

        <p>
            <span>重复新密码 : </span>
            <label><input id="retype" class="text-input medium-input" type="password" name="retype" value="" /></label>
        </p>

    </form>
  </div>
  <div class='popdiv_buttons'>
      <a class='buttons cancel' href='javascript:void(0);' >取消</a>
      <a class='buttons yes' href='javascript:void(0);' >提交</a>
  </div>
</div>