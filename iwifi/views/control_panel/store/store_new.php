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

				<form id="store_basic" method="post" target="_self" action="<?= $base; ?>control_panel/store/store_basic_new/">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>商家名称 : </span>
					<input class="text-input small-input" type="text" id="store_name" name="store_name" />
                    <br /><small>商家的名称</small>
				</p>
				
				<p>
					<span>商家区县 : </span>
					<input class="text-input small-input" type="text" id="store_location" name="store_location" />
                    <br /><small>标明商家所在的区, 例如 北京 海淀</small>
				</p>
				
				<p>
					<span>商家地址 : </span>
					<input class="text-input small-input" type="text" id="store_address" name="store_address" />
                    <br /><small>商家的地址.不用写上面的区了.直接写街道即可.</small>
				</p>
				
				<p>
					<span>商家电话 : </span>
					<input class="text-input small-input" type="text" id="store_tel" name="store_tel" />
                    <br /><small>商家的电话联系方式.</small>
				</p>
				
				<p>
					<span>商家绑定的MAC地址 1 : </span>
					<input class="text-input small-input" type="text" id="store_mac_one" name="store_mac_one" />
                    <br /><small>商家绑定的MAC地址 1.</small>
				</p>
				
				<p>
					<span>商家绑定的MAC地址 2 : </span>
					<input class="text-input small-input" type="text" id="store_mac_two" name="store_mac_two" />
                    <br /><small>商家绑定的MAC地址 2.</small>
				</p>
				
				<p>
					<span>商家简介 : </span>
					<textarea class="text-input medium-input" name="store_descript" style="height:100px;"></textarea>
                    <br /><small>商家的名称</small>
				</p>                
				<p>
					<span>状态 : </span>
					<input name="status" type="checkbox" value="1" checked="checked"/> 开启商家正常状态
				</p>
                <p>
				  <input class="button submitStoreBasic" type="button" value="添 加" />
					<input class="button backtouserlist" type="button" value="返回商家列表" />
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