<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">

$(function(){
	
	//
	
});

</script>
</head>

<body>
<div id="frame_content">
<!-- Page Head -->
    <!-- smallpanel [begin] -->
    <?php $this->load->view('control_panel/navigation'); ?>
    <div class="clear"></div> <!-- End .clear -->

	<?php  $this->load->view('control_panel/icon'); ?>

	<div class="clear"></div> <!-- End .clear -->

    <!-- Start Notifications -->

    <?php $this->load->view('control_panel/notice'); ?>

    <!-- End Notifications -->

	<div class="content-box column-left">
		<div class="content-box-header">
			<h3>全站24小时统计概况</h3>
		</div> <!-- End .content-box-header -->
		<div class="content-box-content">
			<div class="tab-content default-tab">
				<p>短信剩余数：<strong><?php echo $SmsSurplusNum;?></strong></p>
				<p>会员总数：<strong><?php echo $memberTotal;?></strong></p>
                <p>今日登录会员数：<strong><?php echo $memberLoginTotal;?></strong></p>
                <p>今日注册会员数：<strong><?php echo $memberRegTotal;?></strong></p>
			</div> <!-- End #tab3 -->
		</div> <!-- End .content-box-content -->
	</div> <!-- End .content-box -->

    <div class="content-box column-right">
		<div class="content-box-header">
			<h3>系统管理</h3>
		</div> <!-- End .content-box-header -->
		<div class="content-box-content">
			<div class="tab-content default-tab">
				<p><a href="/control_panel/index/export/member_info" target="_blank">导出会员信息</a></p>
				<p><a href="/control_panel/index/export/member_aq" target="_blank">导出会员问答记录</a></p>
                <p><a href="/control_panel/index/export/member_mac" target="_blank">导出会员设备MAC信息</a></p>
		  </div> <!-- End #tab3 -->
		</div> <!-- End .content-box-content -->
	</div> <!-- End .content-box -->

	<div class="clear"></div>
    <?php $this->load->view("control_panel/doing"); ?>
	<?php $this->load->view('control_panel/footer'); ?>
    <!-- End #footer -->
</div>
</body>
</html>