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

        var id = $('#id').val();
        var case_id = $('#case_id').val();
        var ad_num = $('#ad_num').val();

        $("#checkfrom").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	window.location.href="<?= $base; ?>control_panel/upgrade/index/";
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

	<div class="content-box"><!-- Start Content Box -->

		<div class="content-box-header">

			<h3><?= $nav_title; ?></h3>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tablefield">

				<form id="checkfrom" method="post" target="_self" action="<?= $base; ?>control_panel/upgrade/modify_upg/<?= $navinfo['nav_id']; ?>" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?php echo $upgrade['id'];?>" />
                
                <p>
					<span>方案名称 : </span>
                    <select id="case_id" name="case_id" ">
                        <option value="<?php echo $upgrade['case_id'];?>" selected ><?php echo $upgrade['case_title'];?></option>
                    </select>
                    <br /><small>将要升级宽带的方案方案标题名称.</small>
				</p>
				
				<p>
					<span>点击次数 : </span>
					<input class="text-input small-input" type="text" id="nav_link" name="ad_num" value="<?= $upgrade['ad_num']; ?>" />
                    <br /><small>修改需要点击页面上广告的个数.</small>
				</p>
				
                <p>
					<input class="button submitNewNav" type="button" value="修 改" />
					<input class="button backtouserlist" type="button" value="返回方案列表" />
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