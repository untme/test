<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">
<meta name="baidu_union_verify" content="875e158707bac4a58df4e03194d50aa8">
<link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<script type="text/javascript" src="<?= $source; ?>scripts/jquery.cookie.js"></script>
<script type="text/javascript" src="<?= $source; ?>scripts/tab.js"></script>
<title><?= $this->lang->line('sign_title'); ?></title>
<script type="text/javascript">
	$(function(){
		// load name & pwd from cookie
		var savedPhone = $.cookie('savedPhone'),
			savedKey = $.cookie('savedKey');
		$("#login_phone").val(savedPhone);
		$("#passwd").val(savedKey);		
		// Login Check out.
		$("#submitLogin").click(function(){
			
			var phone = $("#login_phone").val();
			var passwd = $("#passwd").val();
			var code = $("#login_code").val();
			var hold = $("#login_code").attr('placeholder');
			var ori_code = $(".add").attr("code");
			var remember;
			$("#remember").attr("checked") == 'checked' ? remember = 1 : remember = 0;
			
			if (phone == '') {
				
				alert('<?= $this->lang->line('sign_login_error_phone'); ?>!');
				return false;
				
			}
			
			if (passwd == '') {
				
				alert('<?= $this->lang->line('sign_login_error_passwd'); ?>!');
				return false;
				
			}
			
			if (code == '' || code == hold) {
				
				alert('<?= $this->lang->line('sign_login_error_code_empty'); ?>!');
				return false;
				
			}
			
			if (code != ori_code) {
				
				alert('<?= $this->lang->line('sign_login_error_code'); ?>!');
				return false;
				
			}
			
			if(remember){
				$.cookie('savedPhone',phone);
				$.cookie('savedKey',passwd);
			}
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>sign/user_signin/",
	        	data: {phone: phone, passwd: passwd, remember: remember},
	        	beforeSend: function(XMLHttpRequest){
	        		
					$(".login_word").html('<font color="green"><?= $this->lang->line('sign_loading'); ?>...</font>');
	        	},
	        	success: function(data){
	        		
					$(".login_word").html('');
					if (data == 0){
						
						// Phone or Passwd does not exist.
						alert('<?= $this->lang->line('sign_login_wrong'); ?>');
						
					}else if (data == 1){
						
						window.location.href = "<?= $base; ?>ask/";
					}
					
	        	},
	        	error: function(){
	        		
	        		alert('<?= $this->lang->line('sign_server_error'); ?>');
	        	}
	        });
			
		});
		
		// onFocus input #login_code 
		$("#login_code").focus(function(){
			
			var code = $(this).val();
			var hold = $(this).attr('placeholder');
			
			if (code == hold) {
				
				$(this).val('');
				
			}
			
		});
		
		// onBlur input $login_code
		$("#login_code").blur(function(){
			
			var code = $(this).val();
			var hold = $(this).attr('placeholder');
			
			if (code == '') {
				
				$(this).val(hold);
			}
			
		});
		
		// Click Button of get text message.
		$(".sign_code").click(function(){
			
			if ($(this).hasClass("waiting")) {
				
				return false;
				
			}
			
			var reg_phone = $("#reg_phone").val();
			if (reg_phone == '') {
				alert('<?= $this->lang->line('sign_login_error_phone'); ?>');
				return false;
				
			}
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>sign/get_text_code/",
	        	data: {phone: reg_phone},
	        	dataType: 'json',
	        	beforeSend: function(XMLHttpRequest){
	        		
					$(".sign_code").addClass("waiting");
					$(".sign_code").val('180');
	        	},
	        	success: function(json){
	        		alert(json.text);
					/*
					//处理返回数据 [LiBin]
					//======================
					if (data == 1){
						//发送成功
						alert('短信发送成功, 请耐心等待, 如果没有收到短信请3分钟后重新发送!');
						start = setInterval("count_time()", 1000);
						
					}else if (data < 0){
						//用户名已经注册过
						alert('您输入的手机号码已经注册!');
						$(".sign_code").removeClass("waiting").val( $(".sign_code").attr('ori') );
						
					}else if (data == 0){
						//发送失败
						alert('短信发送失败，请与客服联系!');
						$(".sign_code").removeClass("waiting").val( $(".sign_code").attr('ori') );
						
					}
					//================== end
					*/
	        	},
	        	error: function(){
	        		
	        		alert('<?= $this->lang->line('sign_server_error'); ?>');
	        	}
	        });
			
		});
		
		// Submit sign up to next step.
		$(".submitSignup").click(function(){
			
			var phone = $("#reg_phone").val();
			var text_code = $("#text_code").val();
			var item;
			$("#item").attr("checked") == 'checked' ? item = 1 : item = 0;
			var reg_code = $("#reg_code").val();
			var ori_code = $(".add").attr("code");
			var hold = $("#reg_code").attr('placeholder');
			
			if (phone == '' || text_code == '' || item != 1) {
				
				alert("<?= $this->lang->line('sign_reg_error'); ?>");
				return false;
				
			}
			
			if (reg_code == '' || reg_code == hold) {
				
				alert('<?= $this->lang->line('sign_login_error_code_empty'); ?>!');
				return false;
				
			}
			
			if (reg_code != ori_code) {
				
				alert('<?= $this->lang->line('sign_login_error_code'); ?>!');
				return false;
				
			}

			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>sign/submit_signup/",
	        	data: {phone: phone, text_code: text_code},
	        	beforeSend: function(XMLHttpRequest){
	        		
					$(".signup_word").html('<font color="green"><?= $this->lang->line('sign_loading'); ?>...</font>');
	        	},
	        	success: function(data){
	        		
					if (data == 0){
						
						alert('<?= $this->lang->line('sign_text_code_error'); ?>');
						
					}else{
						
						window.location.href = "<?= $base; ?>sign/complete/"+phone;
					}
					
	        	},
	        	error: function(){
	        		
	        		alert('<?= $this->lang->line('sign_server_error'); ?>');
	        	}
	        });

		});
		
		// onFocus input #reg_code 
		$("#reg_code").focus(function(){
			
			var code = $(this).val();
			var hold = $(this).attr('placeholder');
			
			if (code == hold) {
				
				$(this).val('');
				
			}
			
		});
		
		// onBlur input $reg_code
		$("#reg_code").blur(function(){
			
			var code = $(this).val();
			var hold = $(this).attr('placeholder');
			
			if (code == '') {
				
				$(this).val(hold);
			}
			
		});
		
	});
	
	function count_time(){
		
		var nowCount = parseInt( $(".sign_code").val() );
		
		if (nowCount <= 0) {
			
			clearInterval(start);
			$(".sign_code").removeClass("waiting").val( $(".sign_code").attr('ori') );
			
		}else{
			
			nowCount -= 1;
			$(".sign_code").val(nowCount);
			
		}
		
	}
</script>
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
    <div class="wrapper_top"></div>
    <div class="wrapper">
        <div class="main">
            <?= $this->load->view('head'); ?>
            <div class="main_center">
                <h2><?= $this->lang->line('sign_welcome'); ?><?= $store['store_name']; ?></h2>
                <?php if (!empty($ad['ad_img'])): ?>
                <img src="<?= $base; ?>data/ad/<?= $ad['ad_img']; ?>" class="add" code="<?= $ad['ad_code']; ?>" />
                <?php endif; ?>
                <div class="sign" id="login_box">
                    <div class="signin"><?= $this->lang->line('sign_in'); ?></div>
                    <div class="signup"><?= $this->lang->line('sign_up'); ?></div>
                    <div></div>
					<div class="fot1">
						<a href="javascript:void(0);" class="close1"><img src="<?= $source; ?>images/closelabel.png" class="close_image1" title="close"/></a>
						<div class="fecon">
							&nbsp;&nbsp;&nbsp;&nbsp;为配合国内公安机关加强网络管理，根据中华人民共和国《互联网上网服务营业场所管理条例 》第二十三条规定，
							我公司需要对您使用该网络的设备进行相关的资料登记。
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;您所填写的个人信息，将由我公司收集并严格妥善保管；
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;如有疑问，可通过以下方式与我公司联系：
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;客户服务热线：400-168-1799
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;传真：010－63397577
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;联系地址：北京市西城区马连道路4号通信管理局312室
							<br />
							&nbsp;&nbsp;&nbsp;&nbsp;邮编：100055
						</div>
					</div>
					<div class="fot2">
						<a href="javascript:void(0);" class="close1"><img src="<?= $source; ?>images/closelabel.png" class="close_image" title="close"/></a>
						<div class="fecon">
							&nbsp;&nbsp;&nbsp;&nbsp;本免费无线宽带上网服务（“AiWiFi”）是由北京立时世通科技有限公司提供。除使用免费上网服务外，客户亦可通过付费的方式使用无线上网服务，以享受更多的优惠服务。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;请阅读以下免费无线宽带上网服务的条款与细则，使用者须遵守本服务条款与细则才可以享用本服务。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;1.	使用者使用本服务时必须登记个人资料，请务必提交真实姓名以及联系方式。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;2.	使用者在使用本服务时应遵守国家法律、法规、规章等相关规定。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;3.	此服务容许使用者透过任何支持Wi-Fi的手机、手提电脑等终端设备来使用本无线宽带网络登入互联网。使用者必须使用可以支持Wi-Fi的手机或手提电脑及相关软件。使用者有责任确保此服务与其手机、手提电脑或设备来配合使用。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;4.	本公司有权随时修改、提升或终止此服务。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;5.	使用者已清楚明白及同意下列各项：
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a)	服务须根据指定的设定用法去运作，并且只适用于安装好的相关设备及软件；
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b)	此服务的提供将会透露使用者当前所在地的资料，有关资料的使用及保存，均受AiWiFi的标准私隐政策所限；
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c)	使用者可根据我公司所订立的条款, 在指定的热点免费享用无线宽带上网服务；我公司有权在客户使用免费无线宽带上网服务期间加插广告；我公司有权随时更改客户每天可享用的免费无线宽带上网服务时间的权利；
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d)	我公司及热点场地供应商不会对于使用无线网络以外的有关费用负责、追讨以及赔偿，（包括任何关于暂停服务或无线上网连线终断或服务质量而导致使用者的损失）亦没义务向使用者或任何第三者负责，不管此类损失是否直接或间接的任何类型，包括盈利、损失、利润或任何基于合同法、民事侵权法、成文法律或其他方面的结果性的损失（包括疏忽）；
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e)	使用者凡是延迟未能履行全部或部分条款与细则而造成的损失或损害，导致延误或未能履行条款与细则等因素, 并不是我公司及热点场地供应商可以合理控制的，又或者其它原因的过失或疏忽导致造成，包括第三者所为等各种因素的过失（包括电信网络营运商、资讯服务内容提供者及设备供应商），原料短缺、战争、战争来临的威胁、暴动、或其他群众骚动或行为、叛乱、天灾、任何政府或其他超越法律当局所实行的限制，工业或贸易争议、火灾、爆炸、风暴、水灾、闪电、地震及其他自然灾害，我公司及热点场地供应商均毋须负责。
							<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;6.	无线网络于该服务覆盖的使用及连线情况，我公司及热点场地供应商将不会对服务质量或服务网络作任何担保。如该服务受到无法控制的因素影响，我公司在此表明保留权利终止此服务。
						</div>
					</div>
                    <div class="signcenter1">
                        <div class="sign_z">
                            <div class="sign_word"><?= $this->lang->line('sign_phone'); ?></div>
                            <div class="iptn1 sign_ipt">
                                <input type="text" id="login_phone" value="<?= empty($cookie_phone) ? '' : $cookie_phone; ?>" />
                            </div>
                        </div>
                        <div class="sign_z">
                            <div class="sign_word"><?= $this->lang->line('sign_passwd'); ?></div>
                            <div class="iptn1 sign_ipt">
                                <input type="password" id="passwd" />
                            </div>
                        </div>
                        <div class="sign_z">
                            <div class="sign_word"><?= $this->lang->line('sign_auth'); ?></div>
                            <div class="iptn1 sign_ipt">
                                <input type="text" placeholder="<?= $ad['ad_code_word']; ?>" value="<?= $ad['ad_code_word']; ?>" id="login_code" />
                            </div>
                        </div>
                        <div class="sign_z">
                            <div class="checkm">
                                <label class="check1">
                                    <input type="checkbox" id="remember" />
                                    <?= $this->lang->line('sign_remember'); ?>
                                </label>
                                &nbsp;|<a href="javascript:;" onClick="$('#login_box').load('/api/updateUserPassword');">&nbsp;<?= $this->lang->line('sign_forget_pw'); ?>?</a>
                            </div>
                        </div>
                        <input type="button" class="button" id="submitLogin" value="<?= $this->lang->line('sign_button_login'); ?>"/>
                        <div class="prompt1 login_word"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="signcenter2">
                        <div class="sign_z">
                            <div class="sign_word"><?= $this->lang->line('sign_phone'); ?></div>
                            <div class="iptn1 sign_ipt">
                                <input type="text" id="reg_phone" />
                            </div>
                        </div>
                        <div class="sign_z">
                            <div class="sign_word"><?= $this->lang->line('sign_auth_text'); ?></div>
                            <div class="iptn2 sign_ipt">
                                <input type="text" id="text_code" />
                            </div>
                            <input type="button" ori="<?= $this->lang->line('sign_get_text'); ?>" value="<?= $this->lang->line('sign_get_text'); ?>" class="sign_code"/>
                        </div>
                        <div class="sign_z">
                            <div class="sign_word"><?= $this->lang->line('sign_auth'); ?></div>
                            <div class="iptn1 sign_ipt">
                                <input type="text" placeholder="<?= $ad['ad_code_word']; ?>" value="<?= $ad['ad_code_word']; ?>" id="reg_code" />
                            </div>
                        </div>
                        <div class="sign_z">
                            <label class="check">
                                <input type="checkbox" id="item"/>
                                <?= $this->lang->line('sign_allow_item'); ?>
                            </label>
                        </div>
                        <input type="button" class="button submitSignup" value="<?= $this->lang->line('sign_button_signup'); ?>"/>
                        <div class="prompt1 signup_word"></div>
                    </div>
                </div>
                <div class="sign_shu"></div>
                <div class="cash"><span><?= $this->lang->line('sign_client'); ?></span><img src="<?= $source; ?>images/cash.png"/></div>
            </div>
            <?= $this->load->view('foot'); ?>
        </div>
    </div>
    
    <!-- 同步退出热点机标记 [Libin] -->
    <img id='link_logout' width='1' height='1' src='http://10.5.0.1/logout?<?php echo time();?>'>
   
</body>
</html>
