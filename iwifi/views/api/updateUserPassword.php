<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="signin signend" onclick="window.location.reload();">会员登录</div>
<div class="signup">找回密码</div>
<div class="clear"></div>
<form id="form_updateUserPassword" method="post" action="/api/updateUserPassword?o=update&_t=<?php echo uniqid(); ?>" style="margin:0px; padding:0px;">
<div class="signcenter2" style="display: block;">
    <div class="sign_z">
        <div class="sign_word">手机号</div>
        <div class="iptn1 sign_ipt">
            <input name="phone" type="text" id="phone"/>
        </div>
    </div>
    <div class="sign_z">
        <div class="sign_word">短信验证码</div>
        <div class="iptn2 sign_ipt">
            <input name="smscode" type="text" id="text_code"/>
        </div>
        <input type="button" class="sign_code" value="点击获取" ori="点击获取"/>
    </div>
    <div class="sign_z">
        <div class="sign_word">新密码</div>
        <div class="iptn1 sign_ipt">
            <input type="password" name="newpassword" id="newPassword"/>
        </div>
    </div>
    <div class="sign_z">
        <div class="sign_word">重复新密码</div>
        <div class="iptn1 sign_ipt">
          <input type="password" name="repassword" id="rePassword"/>
        </div>
    </div>
    <div class="sign_z">
    <input type="button" id="btn_updateUserPassword" class="button" style="margin: 5px 0 0 40px;" value="提 交">
    <input type="button" class="button submitSignup" style="margin: 5px 0 0 40px;" onClick="window.location.reload();" value="返 回">
    </div>
</div>
</form>
<script>
$('#btn_updateUserPassword').click(function(){
	var data = $('#form_updateUserPassword').serialize();
	var url = $("#form_updateUserPassword").attr("action");
	$.getJSON(url,data,function(json){
		alert(json.text);
		if(json.value){
			window.location.reload();
		}
	});
});

$(".sign_code").click(function(){
	if ($(this).hasClass("waiting")){
		return false;
	}
	
	$(".sign_code").addClass("waiting");
	$(".sign_code").val('180');
	start = setInterval("count_time()", 1000);
	
	var phone = $("#phone").val();
	if (phone == '') {
		alert('请输入手机号码');
		return false;
	}
	
	//提交发送
	var data = $('#form_updateUserPassword').serialize();
	var url = '/api/updateUserPassword?o=sendSmsCode&_t=<?php echo uniqid(); ?>';
	$.getJSON(url,data,function(json){
		alert(json.text);
	});
	
});
</script>