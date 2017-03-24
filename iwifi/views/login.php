<!DOCTYPE html>
<html>
  <head>
    <title>iWiFi无线上网服务-登录/注册</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="baidu_union_verify" content="875e158707bac4a58df4e03194d50aa8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/source/css/bootstrap.min.css">
    <!--[if lt IE 9]>
        <script src="/source/js/html5shiv.min.js"></script>
        <script src="/source/js/respond.min.js"></script>
    <![endif]-->
  	<style type="text/css">
	body {background-image: url("/source/images/bg.png");}
	.hide{ display:none;}
	.oneKey{ overflow: hidden;}
	.oneKey .btn{width:57%; padding:20px; font-size: 30px;}
	.oneKey .login_phone,.oneKey .login_password,.oneKey .login_check{ display: none;}
	.changAcc{ color: #555; margin-top:10px; cursor: pointer;}
	@media screen and (max-width:375px){
	.oneKey .btn{width:100%;}
	}
	</style>
	<script>
	//统计代码
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "//hm.baidu.com/hm.js?36843460f29427175466198812464215";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
	</script>
  </head>
  <body>
  
  	<div class="container">
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
		<div class="row" style="height:5px; background-color:#000000;"></div>
		<div class="row" style="margin-top:10px;">
			<div class="col-xs-6"><img src="/source/images/logo.png" class="img-responsive" code="<?php echo $ad['ad_code']; ?>"></div>
			<div class="col-xs-6"></div>
		</div>
		<div class="row" style="height:10px;"></div>
		<div class="row thumbnail" style="padding:10px; margin-top:10px; margin-bottom:20px;">
			<div class="row">
				<div class="col-xs-10"><h4>欢迎光临<?= $store['store_name']; ?></h4></div>
			</div>
			<div class="row">
			<div class="col-xs-12 col-sm-6">
				<img src="/data/ad/<?= $ad['ad_img']; ?>" class="img-responsive"><br>
			</div>
			<div class="col-xs-12 col-sm-6">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" id="myTab">
				  <li><a href="#login" data-toggle="tab">会员登录</a></li>
				  <li><a href="#register" data-toggle="tab">注册会员</a></li>
				  <li><a href="#find" data-toggle="tab">找回密码</a></li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
				
				  <!-- 登录 -->
				  <div class="tab-pane active" id="login" style="padding:10px;">
					<form class="form-horizontal" role="form">
					  <div class="form-group login_phone">
						<label for="login_phone" class="col-sm-3 control-label">手机号</label>
						<div class="col-sm-6">
						  <input name="phone" type="text" class="form-control " id="login_phone" maxlength="11" placeholder="手机号">
						</div>
					  </div>
					  <div class="form-group login_password">
						<label for="passwd" class="col-sm-3 control-label">密码</label>
						<div class="col-sm-6">
						  <input name="passwd" type="password" class="form-control" id="login_password" maxlength="20" placeholder="密码">
						</div>
					  </div>
					  <div class="form-group">
						<label for="login_code" class="col-sm-3 control-label">验证码</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control" id="login_code" placeholder="<?= $ad['ad_code_word']; ?>" value="<?= $ad['ad_code_word']; ?>">
						</div>
					  </div>
					  <div class="form-group login_check">
						<div class="col-sm-offset-3 col-sm-10">
						  <div class="checkbox">
							<label><input name="remember" type="checkbox" id="remember" value="1" checked> 记住我</label>
						  	&nbsp;&nbsp;
							<a href="javascript:;" onClick="$('#myTab a:last').tab('show');">找回密码</a>
						  </div>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
						  <button type="button" class="btn btn-primary" onClick="login();">登录</button>
						</div>
					  </div>
					  <div class="form-group" id="changAcc" style="display:none;">
						  <div class="col-sm-offset-3 col-sm-10">
						  	<span class="changAcc">切换其他账号</span>
						  </div>
					  </div>
					</form>
				  </div>
				  
				  <!-- 注册 -->
				  <div class="tab-pane" id="register" style="padding:10px;">
				  	<form class="form-horizontal" role="form">
					  <div class="form-group">
						<label for="login_phone" class="col-sm-3 control-label">手机号</label>
						<div class="col-sm-5">
						  <input name="phone" type="text" class="form-control" id="register_phone" maxlength="11" placeholder="手机号">
						</div>
					  </div>
					  <div class="form-group">
						<label for="login_phone" class="col-sm-3 control-label">短信验证</label>
						<div class="col-sm-5">
						  <input name="smscode" type="text" class="form-control" maxlength="10" placeholder="短信验证码">
						</div>
						<div class="col-sm-4">
						  <button type="button" class="btn btn-default" id="register_timer" 
						  onClick="send_smscode('register_timer',$('#register_phone').val());">点击获取</button>
						</div>
					  </div>
					  <!--<div class="form-group">
						<label for="login_code" class="col-sm-3 control-label">验证码</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control" id="login_code2" placeholder="<?= $ad['ad_code_word']; ?>" value="<?= $ad['ad_code_word']; ?>">
						</div>
					  </div>-->
					  <div class="form-group">
						<label for="passwd" class="col-sm-3 control-label">密码</label>
						<div class="col-sm-5">
						  <input name="passwd" type="password" class="form-control" id="register_password" maxlength="20" placeholder="密码">
						</div>
					  </div>
					  <div class="form-group" style="display:none;">
						<label for="passwd" class="col-sm-3 control-label">重复密码</label>
						<div class="col-sm-5">
						  <input name="passwd_re" type="password" class="form-control" maxlength="20" placeholder="重复密码">
						</div>
					  </div>
					  
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<input type="checkbox" name="agree" checked value="1"> 
							本人已阅并同意<a href="javascript:msg('msg1');">《信息采集声明》</a> 和
							<a href="javascript:msg('msg2');">《无线网络服务条款及细则》</a>
							</div>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
						  <button type="button" class="btn btn-primary" onClick="register();">注册</button>
						</div>
					  </div>
					</form>
				  </div>
				  
				  <!-- 找回密码 -->
				  <div class="tab-pane" id="find" style="padding:10px;">
				  	<form class="form-horizontal" role="form">
					  <div class="form-group">
						<label for="login_phone" class="col-sm-3 control-label">手机号</label>
						<div class="col-sm-5">
						  <input name="phone" type="text" class="form-control" id="find_phone" maxlength="11" placeholder="手机号">
						</div>
					  </div>
					  <div class="form-group">
						<label for="login_phone" class="col-sm-3 control-label">短信验证</label>
						<div class="col-sm-5">
						  <input name="smscode" type="text" class="form-control" maxlength="10" placeholder="短信验证码">
						</div>
						<div class="col-sm-4">
						  <button type="button" class="btn btn-default" id="find_timer" 
						  onClick="send_smscode('find_timer',$('#find_phone').val());">点击获取</button>
						</div>
					  </div>
					  <div class="form-group">
						<label for="login_code" class="col-sm-3 control-label">验证码</label>
						<div class="col-sm-6">
						  <input type="text" class="form-control" id="login_code3" placeholder="<?= $ad['ad_code_word']; ?>" value="<?= $ad['ad_code_word']; ?>">
						</div>
					  </div>
					  <div class="form-group">
						<label for="passwd" class="col-sm-3 control-label">新密码</label>
						<div class="col-sm-5">
						  <input name="newpassword" type="password" class="form-control" maxlength="20" placeholder="新密码">
						</div>
					  </div>
					  <div class="form-group" style="display:none;">
						<label for="passwd" class="col-sm-3 control-label">重复密码</label>
						<div class="col-sm-5">
						  <input name="repassword" type="password" class="form-control" maxlength="20" placeholder="重复密码">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
						  <button type="button" class="btn btn-primary" onClick="findpassword();">修改密码</button>
						</div>
					  </div>
					</form>
				  </div>
				  
				</div>
			</div>
			</div>
      	</div>
		</div>
		
		</div>
		
		<p class="text-center h4" style="color:#FF0000">客服热线：4001681799</p>
		<p class="text-center">服务提供商：北京立时世通科技有限公司</p>
	</div>
    <script src="/source/js/jquery-1.8.3.min.js"></script>
    <script src="/source/js/bootstrap.min.js"></script>
	<script src="/source/js/jquery_function.js"></script>
	<script src="/source/js/cexCookie.class.js"></script>
	
	<script>
		var cookieTime = 2592000; //cookie保存的时间(单位:秒
		
	  $(function(){
		$('#myTab a:first').tab('show'); //显示第一个标签
		
		
		$("#login_code,#login_code2,#login_code3").focus(function(){
			var code = $(this).val();
			var hold = $(this).attr('placeholder');
			if (code==hold){
				$(this).val('');
			}
		});
		$("#login_code,#login_code2,#login_code3").blur(function(){
			var code = $(this).val();
			var hold = $(this).attr('placeholder');
			if(code==''){
				$(this).val(hold);
			}
		});
		
		var phone = $.trim(cexCookie.get('phone'));
		var password = $.trim(cexCookie.get('password'));
		if(phone!=''){
			$('#login_phone').val(phone);
			$('#login_password').val(password);
			if(password!=''){
				$('#login').addClass('oneKey');
				$('#login .btn').html('一键登录');
				$('#changAcc').show();
			}
			//$('#register_phone').val(phone);
			$('#find_phone').val(phone);
		}else{
			$('#login').removeClass('oneKey');
			$('#login .btn').html('登录');
		}
		
	  });
	  
	  //登录
	  function login()
	  {
	  	var phone = $.trim($('#login_phone').val());
		var password = $.trim($('#login_password').val());
		var login_code = $.trim($('#login_code').val());
		if('<?php echo trim($ad['ad_code']); ?>'!=login_code){
			alert('验证码错误');
			return;
		}
		
	  	var data = $("#login form").serializeArray();
		$.ajax({
	        	type: "POST",
	        	url: "/sign/user_signin/",
	        	data: data,
	        	success: function(data){
	        		var ipadd,imac = "";
	        		if(GetQueryString("cip")){
	        			ipadd = GetQueryString("cip");
	        		}
	        		if(GetQueryString("mac")){
	        			imac = GetQueryString("mac");
	        		}
	        		var reg = new RegExp(":","g"); //创建正则RegExp对象    
					var newstr = imac.replace(reg,"-").toUpperCase();
					//任我行数据接口
					$.get('http://175.25.30.4:80/client/login.htm?account='+phone+'&username='+phone+'&groupname=technology&mac='+newstr+'&ipaddr='+ipadd+'&type=007');
					if(data == 0){
						alert('您输入的手机号码或密码有误!');
					}else if(data == 1){
						cexCookie.set('phone', phone, cookieTime); //在cookie中保存手机号码
						if($('#remember').attr('checked')){cexCookie.set('password', password, cookieTime);} //在cookie中保存密码
						window.location.href = "/ask/";
					}
	        	},
	        	error: function(){
	        		alert('对不起! 服务器出现故障, 请重新尝试');
	        	}
	        });
		
	  }
	  
	  
	  //注册
	  function register()
	  {
	  	var login_code = $.trim($('#login_code2').val());
		if('<?php echo trim($ad['ad_code']); ?>'!=login_code){
			//alert('验证码错误');
			//return;
		}
		
	  	$("#register input[name='passwd_re']").val($("#register input[name='passwd']").val());
	  	var phone = $.trim($('#register_phone').val());
	  	var password = $.trim($('#register_password').val());
	  	var data = $("#register form").serializeArray();
		$.post('/sign/register/',data,function(json){
			alert(json.text);
			if(json.value){
				cexCookie.set('phone', phone, cookieTime); //在cookie中保存手机号码
				cexCookie.set('password', password, cookieTime); //在cookie中保存手机号码
				window.location.reload();
			}
		}, "json");
	  }
	  
	  
	  //找回密码
	  function findpassword()
	  {
	  	var login_code = $.trim($('#login_code3').val());
		if('<?php echo trim($ad['ad_code']); ?>'!=login_code){
			alert('验证码错误');
			return;
		}
		
	  	$("input[name='repassword']").val($("input[name='newpassword']").val());
	  	var data = $("#find form").serializeArray();
		$.getJSON('/api/updateUserPassword?o=update',data,function(json){
			alert(json.text);
			if(json.value){
				cexCookie.set('phone', $('#find_phone').val(), cookieTime); //在cookie中保存手机号码
				window.location.reload();
			}
		});
	  }
	  
	  //获取短信码
	  function send_smscode(id,phone)
	  {
	  	id = $.trim(id);
		phone = $.trim(phone);
	  	var time = 180; //获取间隔秒数
		//发送短信
		var url = '';
		if(id=='find_timer'){
			url = '/api/updateUserPassword?o=sendSmsCode&_t='+now('0'); //找回密码
		}
		if(id=='register_timer'){
			url = '/sign/get_text_code/'; //注册
		}
		$.post(url,{phone: phone},function(json){
			alert(json.text);
			if(json.value){
				//计时开始
				$('#'+id).html(time);
				timer(id);
			}
		}, "json");
	  }
	  
	  //倒计时
	  function timer(id)
	  {
	  	var num = parseInt($.trim( $('#'+id).html() ));
		num = num - 1;
	  	if(num){
		//计时
			$('#'+id).html(num);
			$('#'+id).attr('disabled',true);
			window.setTimeout('timer("'+id+'",1000)',1000);
		}else{
		//计时结束
			$('#'+id).html('点击获取');
			$('#'+id).attr('disabled',false);
		}
	  }
	  
	  //取得文本内容
	  function msg(type)
	  {
	  	type = $.trim(type);
	  	text = cexAjax.getText('/sign/'+type,{}); //取得url的内容
		alert(text);
	  }
	//JS获取参数
	function GetQueryString(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
		var r = window.location.search.substr(1).match(reg);
		if (r!=null) return (r[2]); return null;
	}
	
	  $(function(){
	  	$('.changAcc').click(function(){
			$('#login').removeClass('oneKey');
			$('#login .btn').html('登录');
			$('#changAcc').hide();
	  	})
	  })
	 </script>
	 
	 <!-- 同步退出热点机标记 -->
     <!-- <img id='link_logout' width='1' height='1' src='http://10.5.0.1/logout?<?php echo time();?>'> -->
	
  </body>
</html>
