<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){
	
    //检查用户表是否存在这个成员,并且将成员信息发布过来确认.
    $('.submitStoreBasic').click(function(){
    	
        var store_name = $('#store_name').val();
        var store_location = $('#store_location').val();
        
        if (store_name == '') {
        	
        	$.facebox({ alert: "请填写商家名称!"});
        	return false;
        	
        }
        
        if (store_location == '') {
        	
        	$.facebox({ alert: "请填写商家区县!"});
        	return false;
        	
        }
        
        $("#store_basic").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	
    	window.location.href="<?= $base; ?>control_panel/store/index/";
    	
    });
    
});

</script>
</head>

<body>
<div id="frame_content">
<!-- Page Head -->
    <!-- smallpanel [begin] -->
    <?php $this->load->view('control_panel/navigation'); ?>
    <div class="clear"></div> <!-- End .clear -->

	<?php $this->load->view('control_panel/icon'); ?>

	<div class="clear"></div> <!-- End .clear -->

    <!-- Start Notifications -->

    <?php $this->load->view('control_panel/notice'); ?>

    <!-- End Notifications -->

	<div class="content-box"><!-- Start Content Box -->

		<div class="content-box-header">

			<h3><?= $nav_title; ?></h3>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tablefield">

				<form id="checkform" method="post" target="_self" action="<?= $base; ?>control_panel/store/modify_sign/<?= $store_id; ?>/<?= $sign['sign_id']; ?>" enctype="multipart/form-data">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>商家展示小图 : </span>
					<input class="text-input small-input" type="file" id="sign_small" name="sign_small" />
                    <br /><small>小图展示, 缩率图尺寸为: </small>
				</p>
				
				<?php if (!empty($sign['sign_small'])): ?>
				<p><img src="<?= $base; ?>data/store/<?= $sign['sign_small']; ?>" /></p>
				<?php endif; ?>
				
				<p>
					<span>商家展示大图 : </span>
					<input class="text-input small-input" type="file" id="sign_big" name="sign_big" />
                    <br /><small>小图展示, 缩率图尺寸为: </small>
				</p>
				
				<?php if (!empty($sign['sign_big'])): ?>
				<p><img src="<?= $base; ?>data/store/<?= $sign['sign_big']; ?>" /></p>
				<?php endif; ?>
				
				<p>
					<span>展示说明文字 : </span>
					<input class="text-input medium-input" type="text" id="sign_word" name="sign_word" value="<?= $sign['sign_word']; ?>" />
                    <br /><small>说明该展示, 会在前台显示.</small>
				</p>
				
                <p>
					<input class="button" type="submit" value="修 改" />
					<input class="button backtouserlist" type="button" onclick="history.back();" value="返回上一步" />
				</p>

                </form>
                
				<div class="clear"></div><!-- End .clear -->
				<div class="user_list2" id="show_result"></div>
                <div class="clear"></div><!-- End .clear -->

			</div> <!-- End #tab2 -->

		</div> <!-- End .content-box-content -->

	</div> <!-- End .content-box -->


	<div class="clear"></div>
    <?php $this->load->view("control_panel/doing"); ?>

	<?php $this->load->view('control_panel/footer'); ?>
    <!-- End #footer -->
</div>
</body>
</html>