<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){
	
    //检查用户表是否存在这个成员,并且将成员信息发布过来确认.
    $('.search_user').click(function(){
    	
        var uid = $('#uid').val();
        var phone = $('#phone').val();
        var realname = $('#realname').val();
        
        if (uid == '' && phone == '' && realname == '') {
        	
        	$.facebox({ alert: "请填写一项搜索内容后提交!"});
        	return false;
        	
        }
        
        $("#checkfrom").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	
    	window.location.href="/control_panel/user/index/";
    	
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

				<form id="checkfrom" method="post" target="_self" action="<?= $base; ?>control_panel/user/search/user_result">
                <p>
					<span>用户 I D : </span>
					<input class="text-input small-input" type="text" id="uid" name="uid" />
                    <br /><small>按照用户uid精确定位会员.</small>
				</p>

                <p>
					<span>手机号码 : </span>
					<input class="text-input small-input" type="text" id="phone" name="phone" />
                    <br /><small>按照用户手机号码进行查询.</small>
				</p>
				
                <p>
					<span>真实姓名 : </span>
					<input class="text-input small-input" type="text" id="realname" name="realname" />
                    <br /><small>按照用户真实姓名进行模糊查询.</small>
				</p>

                <p>
					<input class="button search_user" type="button" value="查 询" />
					<input class="button backtouserlist" type="button" value="返回会员列表" />
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