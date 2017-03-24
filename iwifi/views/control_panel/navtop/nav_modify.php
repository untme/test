<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){
	
    //检查用户表是否存在这个成员,并且将成员信息发布过来确认.
    $('.submitNewNav').click(function(){
    	
        var nav_title = $('#nav_title').val();
        var nav_link = $('#nav_link').val();
        
        if (nav_title == '' && nav_link == '') {
        	
        	$.facebox({ alert: "请填写链接名称和链接地址!"});
        	return false;
        	
        }
        
        $("#checkfrom").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	
    	window.location.href="<?= $base; ?>control_panel/navtop/index/";
    	
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

				<form id="checkfrom" enctype="multipart/form-data" method="post" target="_self" action="<?= $base; ?>control_panel/navtop/modify_nav/<?= $navinfo['nav_id']; ?>" enctype="multipart/form-data">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>链接名称 : </span>
					<input class="text-input small-input" type="text" id="nav_title" name="nav_title" value="<?= $navinfo['nav_title']; ?>" />
                    <br /><small>链接标题名称.</small>
				</p>
				
				<p>
					<span>链接地址 : </span>
					<input class="text-input small-input" type="text" id="nav_link" name="nav_link" value="<?= $navinfo['nav_link']; ?>" />
                    <br /><small>改链接的地址, 包括http://.</small>
				</p>
				
				<p>
					<span>链接排序 : </span>
					<input class="text-input small-input" type="text" id="nav_sort" name="nav_sort" value="<?= $navinfo['nav_sort']; ?>" />
                    <br /><small>更改链接的排序规则, 数字越小越靠前, 默认9999.</small>
				</p>

                <?php if(!empty($navinfo['nav_img'])): ?>
                <p>
					<span>图标预览 : </span>
					<img src="<?= rtrim($base, '/'); ?>/data/navigator/<?= $navinfo['nav_img']; ?>" />
				</p>
				<?php endif; ?>
                
                <p>
					<span>修改图标 : </span>
					<input class="text-input small-input" type="file" id="nav_img" name="nav_img" />
                    <br /><small>选择要上传的链接图标.</small>
				</p>
				
                <p>
					<input class="button submitNewNav" type="button" value="修 改" />
					<input class="button backtouserlist" type="button" value="返回链接列表" />
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