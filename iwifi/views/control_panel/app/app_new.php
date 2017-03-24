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
    	
        var app_name = $('#app_name').val();
        var app_url = $('#app_url').val();
        
        if (app_name == '') {
        	
        	$.facebox({ alert: "请填写应用名称!"});
        	return false;
        	
        }
        
        if (app_url == '') {
        	
        	$.facebox({ alert: "请填写应用下载地址!"});
        	return false;
        	
        }
        
        $("#store_basic").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	
    	window.location.href="<?= $base; ?>control_panel/app/index/";
    	
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

				<form id="store_basic" enctype="multipart/form-data" method="post" target="_self" action="<?= $base; ?>control_panel/app/processAddForm/">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>APP名称 : </span>
					<input class="text-input small-input" type="text" id="app_name" name="name" />
                    <br /><small>APP的名称</small>
				</p>
                <p>
					<span>App缩略图 : </span>
					<input type="file" class="text-input small-input" name="focus" id="file">
                    <br /><small>App缩略图</small>
				</p>	
				<p>
					<span>App分类 : </span>
					<select id="type" name="type">		
						<?php foreach($appType as $k=>$v){?>
						<option <?php if($appTypeSelected==$k){?>selected="selected"<?php }?> value="<?= $k;?>"><?= $v;?></option>
						<?php }?>
			        </select>		        
                    <br /><small>标明APP所属的栏目</small>
				</p>	
				<p>
					<span>手工排序 : </span>
					<input class="text-input small-input" type="text" id="app_porder" name="porder" />
                    <br /><small>序号越小，越靠前显示.</small>
				</p>
				<p>
					<span>下载地址 : </span>
					<input class="text-input small-input" type="text" id="app_url" name="url" />
                    <br /><small>App的下载路径.</small>
				</p>

				<p>
					<span>APP简介 : </span>
					<textarea class="text-input medium-input" id="app_description" name="description" style="height:380px; width:800px;"></textarea>
				</p>  

				<div class="shopTitle">状态设置</div>
				<p>
					<span>展示状态 : </span>
					<input type="checkbox" <?php if($appStateSelected=='on'){?>checked="checked"<?php }?> value="<?= $appState[$appStateSelected];?>" name="state"> 开启展示状态
				</p>
                <p>
				  <input class="button submitStoreBasic" type="button" value="添加App" />
					<input class="button backtouserlist" type="button" value="返回App列表" />
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
	K.create('#app_description', {
		allowFileManager : true,
		afterBlur: function(){this.sync();}
	});

});

</script>
</body>
</html>