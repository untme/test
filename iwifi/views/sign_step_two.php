<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<title><?= $this->lang->line('signtwo_title'); ?></title>
<script type="text/javascript">
	
	$(function(){
		$(".button1").click(function(){
			var objexp; //正则对象
			
			var realname = $("#realname").val();
			var nickname = $("#nickname").val();
			var email = $("#email").val();
			var passwd = $.trim($("#passwd").val());
			var repasswd = $("#repasswd").val();
			var ad_code = $("#ad_code").val();
			var ori_code = $(".add1").attr('code');
			if(realname == '' || nickname == '' || email == '' || passwd == '' || repasswd == '' || ad_code == '') {
				alert('<?= $this->lang->line('signtwo_submit_empty'); ?>');
				return false;
			}
			//验证真实姓名
			objexp = /^[^\d]{2,}$/;
			if(!objexp.test(realname)){
				alert('请填写正确的姓名');
				return false;
			}
			if(passwd != repasswd){
				alert('<?= $this->lang->line('signtwo_passwd_error'); ?>');
				return false;
			}
			//密码长度
			if(passwd.length<6){
				alert('密码长度不能小于6位');
				return false;
			}
			//密码安全检测
			if(passwd=='123456' || passwd=='1234567' || passwd=='12345678' || passwd=='123456789' || passwd=='012345'){
				alert('为了帐号安全,禁止使用连续数字做为密码');
				return false;
			}
			if(ad_code != ori_code){
				alert('<?= $this->lang->line('signtwo_code_error'); ?>');
				return false;
			}
			//验证email格式 [LiBin]
			objexp = /^[A-Za-z0-9]+[.A-Za-z0-9_-]+[A-Za-z0-9]{1}@[A-Za-z0-9]{1,}(.[A-Za-z0-9-]+){0,3}.[A-Za-z]{2,6}$/;
			if(!objexp.test(email)){
				alert('Email格式不正确');
				return false;
			}
			
			//提交表单
			$("#user_complete").submit();
		});
		
	});
	
</script>
</head>
<body>
    <div class="wrapper_top"></div>
    <div class="wrapper">
        <div class="main">
            <?= $this->load->view('head'); ?>
            
            <?php if (!empty($ad['ad_img'])): ?>
            <img src="<?= $base; ?>data/ad/<?= $ad['ad_img']; ?>" class="add1" code="<?= $ad['ad_code']; ?>" />
            <?php endif; ?>
            <div class="main_center">
                <div class="head"><?= $this->lang->line('signtwo_welcome'); ?></div>
                <div class="smipt"><?= $this->lang->line('signtwo_item'); ?> </div>
                <div class="password">
                	<form method="post" action="<?= $base; ?>sign/complete/<?= $phone; ?>" id="user_complete">
                	<input type="hidden" name="action" value="true" />
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('signtwo_realname'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input name="realname" type="text" id="realname" maxlength="15" />
                        </div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('signtwo_nickname'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input name="nickname" type="text" id="nickname" maxlength="15" />
                        </div>
                        <div class="fo_po"><?= $this->lang->line('signtwo_nickname_for'); ?></div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('signtwo_email'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input name="email" type="text" id="email" maxlength="50" />
                        </div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('signtwo_passwd'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input name="passwd" type="password" id="passwd" maxlength="20" />
                        </div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('signtwo_repasswd'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input type="password" id="repasswd" maxlength="20" />
                        </div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('signtwo_code'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input type="text" id="ad_code" maxlength="32" />
                        </div>
                        <div class="fo_po"><?= empty($ad['ad_code_word']) ? '' : $ad['ad_code_word']; ?></div>
                    </div>
                    <input type="button" class="button1" value="<?= $this->lang->line('signtwo_button_done'); ?>"/>
                    <div class="prompt2"></div>
                    </form>
                </div>
            </div>
            <?= $this->load->view('foot'); ?>
        </div>
    </div>
</body>
</html>