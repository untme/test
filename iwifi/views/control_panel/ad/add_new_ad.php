<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){
	
    //检查用户表是否存在这个成员,并且将成员信息发布过来确认.
    $('.submitNewAD').click(function(){
    	
        var ad_code = $('#ad_code').val();
        var ad_code_word = $('#ad_code_word').val();
        
        if (ad_code == '' && ad_code_word == '') {
        	
        	$.facebox({ alert: "请填写广告验证码和广告验证码提示文字!"});
        	return false;
        	
        }
        
        $("#checkfrom").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	
    	window.location.href="<?= $base; ?>control_panel/advertisement/page_lang/<?= $ad_page['page_type_id']; ?>/<?= $lang['lang_type_id']; ?>";
    	
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

				<form id="checkfrom" method="post" target="_self" action="<?= $base; ?>control_panel/advertisement/new_advertisement/<?= $ad_page['page_type_id']; ?>/<?= $lang['lang_type_id']; ?>" enctype="multipart/form-data">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>广告所在页面 : </span>
					<b><?= $ad_page['page_name']; ?></b>
				</p>
				
				<p>
					<span>广告图片要求 : </span>
					<b>宽度: <font color="red"><?= !empty($ad_page['page_ad_size_width']) ? $ad_page['page_ad_size_width'] : '不限制'; ?></font> 高度: <font color="red"><?= !empty($ad_page['page_ad_size_height']) ? $ad_page['page_ad_size_height'] : '不限制'; ?></font></b> (请上传的广告图片必须按照这个宽度和长度上传)
				</p>
				
				<p>
					<span>广告所属分类 : </span>
					<?php $langs = advertisement_lang_type(); ?>
					<select name="ad_lang_type">
						<?php foreach($langs as $row): ?>
						<?php if($row['lang_type_id'] == $lang['lang_type_id']): ?>
						<option value="<?= $row['lang_type_id']; ?>" selected="selected"><?= $row['lang_name']; ?></option>
						<?php else: ?>
						<option value="<?= $row['lang_type_id']; ?>"><?= $row['lang_name']; ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</p>

                <p>
					<span>上传广告图片 : </span>
					<input class="text-input small-input" type="file" id="adImg" name="adImg" />
                    <br /><small>选择要上传的广告图片.</small>
				</p>
				
                <p>
					<span>广告图片验证码 : </span>
					<input class="text-input small-input" type="text" id="ad_code" name="ad_code" />
                    <br /><small>输入相对应的该图片中的广告验证码.</small>
				</p>
				
                <p>
					<span>验证码提示文字 : </span>
					<input class="text-input small-input" type="text" id="ad_code_word" name="ad_code_word" />
                    <br /><small>输入验证码提示的文字内容.</small>
				</p>

                <p>
					<input class="button submitNewAD" type="button" value="添 加" />
					<input class="button backtouserlist" type="button" value="返回该页面广告列表" />
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