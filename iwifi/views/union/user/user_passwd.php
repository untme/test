<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title><?= $this->lang->line('passwd_title'); ?></title>
    <link href="<?= $source; ?>style/css/frame.css" type="text/css" rel="stylesheet">
    <link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
    <script src="<?= $source; ?>js/jquery.js"></script>
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
    <div class="G_topbar"></div>
    <div class="G_frame">
        <div class="G_main">
            <div class="G_head">
                 <?= $this->load->view('header'); ?>
                <div class="ad"><a href="<a href="/union/user/upgrade?type=1"><img src="<?= $source; ?>images/pic01.png" class="pic"></a></div>
                <?= $this->load->view('/union/header_welcome'); ?>
            </div>

            <div class="G_modwrap">
                <div class="G_form_a S_line1">
                    <h1 class="form_title"><?= $this->lang->line('passwd_welcome'); ?></h1>
                    <div class="formbox">
                        <form action="#" method="post" node-type="form">
                        <div class="item clearfix">
                            <p class="name"><?= $this->lang->line('passwd_now'); ?></p>
                            <p class="ipt_area"><input type="password" class="ipt_text" name="passwd_now" id="passwd_now" /></p>
                        </div>
                        <div class="item clearfix">
                            <p class="name"><?= $this->lang->line('passwd_new'); ?></p>
                            <p class="ipt_area"><input type="password" class="ipt_text" name="passwd" id="passwd" /></p>
                        </div>
                        <div class="item clearfix">
                            <p class="name"><?= $this->lang->line('passwd_retype'); ?></p>
                            <p class="ipt_area"><input type="password" class="ipt_text" name="passwd" id="passwd" /></p>
                        </div>
                        <div class="item clearfix">
                            <p class="name"></p>
                            <p class="ipt_area"><a href="javascript:void(0)" class="G_btn_a metro_blue button1" action-type="form-sub"><?= $this->lang->line('profile_button_done'); ?></a></p>
                        </div>
						<div class="prompt2"></div>
                        </form>
                    </div>
                </div>
            </div>


        </div>


    </div>

	<?= $this->load->view('union/foot'); ?>
	
</body>
</html>
