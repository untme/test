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
    	
        var activity_name = $('#activity_name').val();
              
        if (activity_name == '') {
        	
        	$.facebox({ alert: "请填写活动名称!"});
        	return false;
        	
        }
        
        $("#store_basic").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	
    	window.location.href="<?= $base; ?>control_panel/action/index/";
    	
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

				<form id="store_basic"  enctype="multipart/form-data" method="post" target="_self" action="<?= $base; ?>control_panel/activity/processAddForm/">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>活动名称 : </span>
					<input class="text-input small-input" type="text" id="activity_name" name="name" />
                    <br /><small>活动名称</small>
				</p>
                <p>
					<span>活动图片 : </span>
					<input type="file" value="" class="text-input small-input" name="focus[]" id="focus_0">
                    <br /><small>商家的活动图片</small>
				</p>	
				<p>
					<span>归属商家 : </span>
					<select id="activity_aiwifi_mall_pk_mall" name="aiwifi_mall_pk_mall">
						<?php foreach($mallList as $k=>$malls):?>
						<optgroup label="<?= $k; ?>"></optgroup>
							<?php foreach($malls as $mall): ?>
								<option value="<?= $mall['pk_mall'];?>"><?= $mall['name'];?></option>
							<?php endforeach; ?>
						<?php endforeach; ?>
			        </select>		        
                    <br /><small>标明所属商家</small>
				</p>
				<p>
					<span>手工排序 : </span>
					<input class="text-input small-input" type="text" id="activity_porder" name="porder" />
                    <br /><small>序号越小，越靠前显示.</small>
				</p>				
			
				<p>
					<span>活动简介 : </span>
					<textarea class="text-input medium-input" id="activity_desc" name="description" style="height:300px; width:800px;"></textarea>
				</p>  

				

				
				<div class="shopTitle">状态设置</div>
				<p>
					<span>展示状态 : </span>
					<select id="type" name="state">
			        	<option selected="" value="1">活动正常</option>
			        	<option value="0">活动关闭</option>
			        	<option value="2">置顶排序</option>
			        	<option value="3">活动页置顶</option>
			        	<option value="4">品牌页置顶</option>
			        </select>	
				</p>
                <p>
				  <input class="button submitStoreBasic" type="button" value="添加活动" />
					<input class="button backtouserlist" type="button" value="返回活动列表" />
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
	K.create('#activity_desc', {
		allowFileManager : true,
		afterBlur: function(){this.sync();}
	});

});

</script>
</body>
</html>