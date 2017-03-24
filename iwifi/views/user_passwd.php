<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<title><?= $this->lang->line('passwd_title'); ?></title>
<script type="text/javascript">
	
	$(function(){
		
		$(".button1").click(function(){
			
			var passwd_now = $("#passwd_now").val();
			var passwd = $("#passwd").val();
			var repasswd = $("#repasswd").val();
			
			if (passwd_now == "" || passwd == "") {
				
				alert('<?= $this->lang->line('profile_submit_empty'); ?>');
				return false;
				
			}
			
			if ( passwd != repasswd ) {
				
				alert('<?= $this->lang->line('passwd_retype_error'); ?>');
				return false;
				
			}
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>user/passwd_submit/",
	        	data: {passwd_now: passwd_now, passwd: passwd},
	        	beforeSend: function(XMLHttpRequest){
	        		
					$(".prompt2").html('<font color="green"><?= $this->lang->line('profile_loading'); ?>...</font>');
	        	},
	        	success: function(data){
	        		
					$(".prompt2").html('');
					if (data == 1){
						
						alert('<?= $this->lang->line('profile_success'); ?>');
						
					}else if (data == 0) {
						
						alert('<?= $this->lang->line('passwd_curri_error'); ?>');
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
                <div class="head"><?= $this->lang->line('passwd_welcome'); ?></div>
                <div class="password">
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('passwd_now'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input type="password" name="passwd_now" id="passwd_now" />
                        </div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('passwd_new'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input type="password" name="passwd" id="passwd" />
                        </div>
                    </div>
                    <div class="password_z">
                        <div class="reset_word"><?= $this->lang->line('passwd_retype'); ?></div>
                        <div class="iptn3 sign_ipt">
                            <input type="password" id="repasswd" name="repasswd" />
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