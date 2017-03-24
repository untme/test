<script type="text/javascript">
$(document).ready(function(){

    $(".cancel").click(function(){
        $(document).trigger('close.facebox');
    });

    $(".submitUserPasswd").click(function(){
    	
    	var uid = $("#userID").val();
        var passwd = $("#passwd").val();
        var retypePasswd = $("#retype-passwd").val();
        
        if (passwd == '') {
        	
        	alert('请输入密码提交!');
        	return false; 
        	
        }
        
        if (passwd != retypePasswd) {
        	
        	alert('两次输入的密码不一致!');
        	return false;
        	
        }

        $.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/user/user_functions/passwd/",
        	data: "action=true&uid=" + uid + "&passwd="+encodeURIComponent(passwd),
        	beforeSend: function(XMLHttpRequest){
        		$.facebox({ div: '#doing' });
        	},
        	success: function(data){
        		$.facebox({ alert: data });
        	},
        	error: function(){
        		$.facebox({ alert: '对不起! 请求出现错误,请重新尝试!' });
        	}
        });
    });
});
</script>
<div class='popdiv'>
  <div class='popdiv_title'>更改用户密码</div>
  <div class='popdiv_content'>
    <form>
        <p>
            <span>重置会员密码 : </span>
            <input type="hidden" value="<?= $uid; ?>" id="userID" />
            <label><input id="passwd" class="text-input medium-input" type="text" name="passwd" value="" /></label>
        </p>

        <p>
            <span>再次输入密码 : </span>
            <label><input id="retype-passwd" class="text-input medium-input" type="text" name="retype-passwd" value="" /></label>
        </p>

    </form>
  </div>
  <div class='popdiv_buttons'>
      <a class='buttons cancel' href='javascript:void(0);' >取消</a>
      <a class='buttons submitUserPasswd' href='javascript:void(0);' >确定</a>
  </div>
</div>