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
    	
    	window.location.href="<?= $base; ?>control_panel/floor/index/";
    	
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
					<span>楼层名称 : </span>
					<input class="text-input small-input" type="text" id="store_name" name="store_name" />
                    <br /><small>楼层名称</small>
				</p>
                <p>
					<span>楼层地图 : </span>
					<input type="file" value="1/0/2d34aa3dcd0bf81bd8b37f5ca42a68f0.jpg" onchange="ImagePreview('file','preview');" class="text-input small-input" name="adImg" id="file">
                    <br /><small>商家楼层图片</small>
				</p>
				<p>
					<span>选择楼层 : </span>
					<select id="type" name="type">
			        	<option selected="" value="-5">-5F</option>
			        	<option value="20F">20F</option>
			        </select>		        
                    <br /><small>标明所属商家楼层</small>
				</p>	
				<p>
					<span>归属商家 : </span>
					<select id="type" name="type">
			        	<option selected="" value="1000000">明日大酒店</option>
			        	<option value="2000000">全日空航空</option>
			        </select>		        
                    <br /><small>标明所属商家</small>
				</p>
				<p>
					<span>手工排序 : </span>
					<input class="text-input small-input" type="text" id="store_address" name="store_address" />
                    <br /><small>序号越小，越靠前显示.</small>
				</p>				
			
				<p>
					<span>楼层详情 : </span>
					<textarea class="text-input medium-input" id="content" name="store_descript" style="height:300px; width:800px;"></textarea>
				</p>  

				<div class="shopTitle">状态设置</div>
				<p>
					<span>展示状态 : </span>
					<input type="checkbox" checked="checked" value="1" name="status"> 开启展示状态
				</p>
                <p>
				  <input class="button submitStoreBasic" type="button" value="添加楼层" />
					<input class="button backtouserlist" type="button" value="返回楼层列表" />
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

<script charset="utf-8" src="/source/keditor/kindeditor.js"></script>
<script charset="utf-8" src="/source/keditor/lang/zh_CN.js"></script>
<script type="text/javascript">
KindEditor.ready(function(K) {
	K.create('#content,#busline,#carqin,#carkoo', {
		allowFileManager : true
	});

});

</script>
</body>
</html>