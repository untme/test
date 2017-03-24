<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<title><?= $this->lang->line('profile_title'); ?></title>
<script type="text/javascript">
	
	$(function(){
		
		$(".button1").click(function(){
			
			var nickname = $("#nickname").val();
			var email = $("#email").val();
			if ( nickname == '' || email == '' ) {
				alert('<?= $this->lang->line('profile_submit_empty'); ?>');
				return false;
			}
			
			//验证email格式 [LiBin]
			var objexp = /^[A-Za-z0-9_.-]+@([A-Za-z0-9_.-]+.)+[A-Za-z]{2,6}$/;
			if(!objexp.test(email)){
				alert('Email格式不正确');
				return false;
			}
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>user/profile_submit/",
	        	data: {nickname: nickname, email: email},
	        	beforeSend: function(XMLHttpRequest){
					$(".prompt2").html('<font color="green"><?= $this->lang->line('profile_loading'); ?>...</font>');
	        	},
	        	success: function(data){
					$(".prompt2").html('');
					if (data == 1){
						alert('<?= $this->lang->line('profile_success'); ?>');
						window.location.reload();
					}
	        	},
	        	error: function(){
	        		alert('<?= $this->lang->line('profile_server_error'); ?>');
	        	}
	        });
			
		});
		
	});
	
</script>
</head>
<body>
    <div class="wrapper_top"></div>
    <div class="wrapper">
        <div class="main">
            <?= $this->load->view('head'); ?>
            <?= $this->load->view('_welcome'); ?>
            <div class="main_center">
                <div class="head"><?= $this->lang->line('profile_welcome'); ?></div>
                <div class="password">
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('profile_realname'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input type="text" name="realname" id="realname" readonly="true" value="<?= $userinfo['realname']; ?>" />
                        </div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('profile_nickname'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input type="text" name="nickname" id="nickname" value="<?= $userinfo['nickname']; ?>" />
                        </div>
                        <div class="fo_po"><?= $this->lang->line('profile_nickname_for'); ?></div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('profile_email'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input type="text" id="email" name="email" value="<?= $userinfo['email']; ?>" />
                        </div>
                    </div>
                    <input type="button" class="button1" value="<?= $this->lang->line('profile_button_done'); ?>"/>
                    <div class="prompt2"></div>
                </div>
            </div>
            <?= $this->load->view('foot'); ?>
        </div>
    </div>
</body>
</html>