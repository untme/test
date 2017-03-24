<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){
	
    // For map tags draggable.
    $(".cross").live('mouseover', function(){
    	
    	$(this).draggable({
	    	containment: "parent",
	    	stop: function(e, ui){
	    		// Get this tag position information alert(ui.position.top); 
	    		$(this).attr('left', ui.position.left);
	    		$(this).attr('top', ui.position.top);
	    	}
	    });
    	
    });
    
    // Double click to delete this tag dom.
    $(".cross").live("dblclick", function(){
    	
    	$(this).remove();
    	
    });
    
    // Call facebox to show add new tag store form.
    $('.addStoreTag').click(function(){
    	
    	var mt = $(this).attr('type');
    	
    	if (mt == 'mbig') {
    		
    		$(".createNewStoreTag").attr('type', 'mbig');
    		
    	}else if(mt == 'mmiddle') {
    		
    		$(".createNewStoreTag").attr('type', 'mmiddle');
    		
    	}else if (mt == 'msmall'){
    		
    		$(".createNewStoreTag").attr('type', 'msmall');
    		
    	}
    	
    	$.facebox({ div: "#addNewST" });
    	
    	
    });
    
    // Create new store tag in map.
    $(".createNewStoreTag").live('click', function(){
    	
    	var sName = $(this).parent(".popdiv_buttons").siblings(".popdiv_content").find("#NS_name").val();
    	var sLink = $(this).parent(".popdiv_buttons").siblings(".popdiv_content").find("#NS_link").val();
    	var tag = '<div class="cross" link="'+sLink+'">'+sName+'</div>';
    	var mt = $(this).attr('type');
    	
    	if (sName == '') {
    		
    		alert('请填写商家名称!');
    		return false;
    		
    	}
    	
    	if (mt == 'mbig') {
    		
    		$("#store_map_big").append(tag);
    		
    	}else if (mt == 'mmiddle') {
    		
    		$("#store_map_middle").append(tag);
    		
    	}else if (mt == 'msmall') {
    		
    		$("#store_map_small").append(tag);
    		
    	}
    	
    	$.facebox.close();
    	
    });
    
    // Save Big map data
    $(".saveBigMapData").click(function(){
    	
    	var data = [];
    	
    	$("#store_map_big div").each(function(i){
    		
    		var name = $(this).html();
    		var link = $(this).attr('link');
    		var left = $(this).attr('left');
    		var top = $(this).attr('top');
    		
    		//data[i] = "name="+name+"&link="+link+"&left="+left+"&top="+top;
    		data[i] = '{"name": "'+name+'", "link": "'+link+'", "left": "'+left+'", "top": "'+top+'"}';
      		
    	});
    	
    	// Post the data to server handle.
    	$.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/store/map_json_data/big/",
        	data: {store_id: <?= $store['store_id']; ?>, map_data: data},
        	beforeSend: function(XMLHttpRequest){
        		$.facebox({ div: '#doing' });
        	},
        	success: function(data){
        		$.facebox({ alert: data });
        	},
        	error: function(){
        		$.facebox({ alert: '对不起! 请求出现错误,请重新尝试!' });
        	}
        });
    	
    });
    
    // Save Middle map data
    $(".saveMiddleMapData").click(function(){
    	
    	var data = [];
    	
    	$("#store_map_middle div").each(function(i){
    		
    		var name = $(this).html();
    		var link = $(this).attr('link');
    		var left = $(this).attr('left');
    		var top = $(this).attr('top');
    		
    		//data[i] = "name="+name+"&link="+link+"&left="+left+"&top="+top;
    		data[i] = '{"name": "'+name+'", "link": "'+link+'", "left": "'+left+'", "top": "'+top+'"}';
      		
    	});
    	
    	// Post the data to server handle.
    	$.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/store/map_json_data/middle/",
        	data: {store_id: <?= $store['store_id']; ?>, map_data: data},
        	beforeSend: function(XMLHttpRequest){
        		$.facebox({ div: '#doing' });
        	},
        	success: function(data){
        		$.facebox({ alert: data });
        	},
        	error: function(){
        		$.facebox({ alert: '对不起! 请求出现错误,请重新尝试!' });
        	}
        });
    	
    });
    
    // Save Small map data
    $(".saveSmallMapData").click(function(){
    	
    	var data = [];
    	
    	$("#store_map_small div").each(function(i){
    		
    		var name = $(this).html();
    		var link = $(this).attr('link');
    		var left = $(this).attr('left');
    		var top = $(this).attr('top');
    		
    		//data[i] = "name="+name+"&link="+link+"&left="+left+"&top="+top;
    		data[i] = '{"name": "'+name+'", "link": "'+link+'", "left": "'+left+'", "top": "'+top+'"}';
      		
    	});
    	
    	// Post the data to server handle.
    	$.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/store/map_json_data/small/",
        	data: {store_id: <?= $store['store_id']; ?>, map_data: data},
        	beforeSend: function(XMLHttpRequest){
        		$.facebox({ div: '#doing' });
        	},
        	success: function(data){
        		$.facebox({ alert: data });
        	},
        	error: function(){
        		$.facebox({ alert: '对不起! 请求出现错误,请重新尝试!' });
        	}
        });
    	
    });
    
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

<style type="text/css">
	
	.mapfather{
		position: relative;
		width:670px;
		height:318px;
	}
	.mapfather .cross{
		cursor:move;
		background:blue;
		height:20px;
		line-height:20px;
		position:absolute;
		color:#FFF;
		width:auto;
		top:0;
		left:0;
	}
	
</style>

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

				<form id="store_basic" method="post" target="_self" action="<?= $base; ?>control_panel/store/store_modify/<?= $store['store_id']; ?>">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>商家名称 : </span>
					<input class="text-input small-input" type="text" id="store_name" name="store_name" value="<?= $store['store_name']; ?>" />
                    <br /><small>商家的名称</small>
				</p>
				
				<p>
					<span>商家区县 : </span>
					<input class="text-input small-input" type="text" id="store_location" name="store_location" value="<?= $store['store_location']; ?>" />
                    <br /><small>标明商家所在的区, 例如 北京 海淀</small>
				</p>
				
				<p>
					<span>商家地址 : </span>
					<input class="text-input small-input" type="text" id="store_address" name="store_address" value="<?= $store['store_address']; ?>" />
                    <br /><small>商家的地址.不用写上面的区了.直接写街道即可.</small>
				</p>
				
				<p>
					<span>商家电话 : </span>
					<input class="text-input small-input" type="text" id="store_tel" name="store_tel" value="<?= $store['store_tel']; ?>" />
                    <br /><small>商家的电话联系方式.</small>
				</p>
				
				<p>
					<span>商家绑定的MAC地址 1 : </span>
					<input class="text-input small-input" type="text" id="store_mac_one" name="store_mac_one" value="<?= $store['store_mac_one']; ?>" />
                    <br /><small>商家绑定的MAC地址 1.</small>
				</p>
				
				<p>
					<span>商家绑定的MAC地址 2 : </span>
					<input class="text-input small-input" type="text" id="store_mac_two" name="store_mac_two" value="<?= $store['store_mac_two']; ?>" />
                    <br /><small>商家绑定的MAC地址 2.</small>
				</p>
				
				<p>
					<span>商家简介 : </span>
					<textarea class="text-input medium-input" name="store_descript" style="height:100px;"><?= $store['store_descript']; ?></textarea>
                    <br /><small>商家的名称</small>
				</p>
				<p>
					<span>状态 : </span>
					<input name="status" type="checkbox" value="1" <?php if((int)$store['status']){echo 'checked';}?>/> 开启商家正常状态
				</p>                
                <p>
					<input class="button submitStoreBasic" type="button" value="修 改" />
					<input class="button backtouserlist" type="button" value="返回商家列表" />
				</p>

                </form>
                
                <hr />
                
                <div class="clear"></div><!-- End .clear -->
                
                <form method="post" target="_self" action="<?= $base; ?>control_panel/store/store_upload/<?= $store['store_id']; ?>/banner" enctype="multipart/form-data">
                	
                <p>
					<span>商家照片 : </span>
					<input class="text-input small-input" type="file" name="store_banner" />
                    <br /><small>上传商家的banner照片. 尺寸为</small> <br />
                    <input class="button" type="submit" value="上 传" />
				</p>
				
				<?php if (!empty($store['store_banner'])): ?>
				<p><span>商家照片预览 </span><br /><img src="<?= $base; ?>data/store/<?= $store['store_banner']; ?>" style="max-width: 940px;" /></p>
				<?php endif; ?>
				
				</form>
				
				<form method="post" target="_self" action="<?= $base; ?>control_panel/store/store_upload/<?= $store['store_id']; ?>/logo" enctype="multipart/form-data">
					
                <p>
					<span>商家Logo : </span>
					<input class="text-input small-input" type="file" name="store_logo" />
                    <br /><small>上传商家的logo图片. 尺寸为</small> <br />
                    <input class="button" type="submit" value="上 传" />
				</p>
				
				<?php if (!empty($store['store_logo'])): ?>
				<p><span>商家Logo预览 </span><br /><img src="<?= $base; ?>data/store/<?= $store['store_logo']; ?>" style="max-width: 940px;" /></p>
				<?php endif; ?>
				
				</form>
				
				<form method="post" target="_self" action="<?= $base; ?>control_panel/store/store_upload/<?= $store['store_id']; ?>/map_big" enctype="multipart/form-data">
					
                <p>
					<span>商家地图大 : </span>
					<input class="text-input small-input" type="file" name="store_map_big" />
                    <br /><small>上传地图远距离BIG. 尺寸为 670*318</small> <br />
                    <input class="button" type="submit" value="上 传" />
				</p>
				
				<?php if (!empty($store['store_map_big'])): ?>
				<p>
					<span>商家地图预览以及管理 </span> 
					<a href="javascript:void(0);" class="addStoreTag" type="mbig">添加商家</a> (双击可以移除)<br />
					<div class="mapfather" id="store_map_big">
						<img src="<?= $base; ?>data/store/<?= $store['store_map_big']; ?>" width="670" height="318" style="max-width: 940px;" />
					</div>
					<br />
                    <input class="button saveBigMapData" type="button" value="保存远距离地图数据" />
				</p>
				<script type="text/javascript">
					
					// Ini big map data.
					var bigData = <?= $store['store_map_big_json']; ?>;
					var bigDataSize = bigData.length;
					
					for (var i = 0; i < bigDataSize; i++) {
						
						$("#store_map_big").append('<div class="cross" link="'+bigData[i].link+'" left="'+bigData[i].left+'" top="'+bigData[i].top+'" style="top:'+bigData[i].top+'px;left:'+bigData[i].left+'px;">'+bigData[i].name+'</div>');
						
					}
					
				</script>
				<?php endif; ?>
				
				</form>
				
				<form method="post" target="_self" action="<?= $base; ?>control_panel/store/store_upload/<?= $store['store_id']; ?>/map_middle" enctype="multipart/form-data">
					
				<p>
					<span>商家地图中 : </span>
					<input class="text-input small-input" type="file" name="store_map_middle" />
                    <br /><small>上传商家地图中距离图片. 尺寸为 670*318</small> <br />
                    <input class="button" type="submit" value="上 传" />
				</p>
				
				<?php if (!empty($store['store_map_middle'])): ?>
				<p>
					<span>商家地图预览以及管理 </span> 
					<a href="javascript:void(0);" class="addStoreTag" type="mmiddle">添加商家</a> (双击可以移除)<br />
					<div class="mapfather" id="store_map_middle">
						<img src="<?= $base; ?>data/store/<?= $store['store_map_middle']; ?>" width="670" height="318" style="max-width: 940px;" />
					</div>
					<br />
                    <input class="button saveMiddleMapData" type="button" value="保存中距离地图数据" />
				</p>
				<script type="text/javascript">
					
					// Ini big map data.
					var middleData = <?= $store['store_map_middle_json']; ?>;
					var middleDataSize = middleData.length;
					
					for (var i = 0; i < middleDataSize; i++) {
						
						$("#store_map_middle").append('<div class="cross" link="'+middleData[i].link+'" left="'+middleData[i].left+'" top="'+middleData[i].top+'" style="top:'+middleData[i].top+'px;left:'+middleData[i].left+'px;">'+middleData[i].name+'</div>');
						
					}
					
				</script>
				<?php endif; ?>
				
				</form>
				
				<form method="post" target="_self" action="<?= $base; ?>control_panel/store/store_upload/<?= $store['store_id']; ?>/map_small" enctype="multipart/form-data">
				
				<p>
					<span>商家地图小 : </span>
					<input class="text-input small-input" type="file" name="store_map_small" />
                    <br /><small>上传商家近距离地图. 尺寸为 670*318</small> <br />
                    <input class="button" type="submit" value="上 传" />
				</p>
				
				<?php if (!empty($store['store_map_small'])): ?>
				<p>
					<span>商家地图预览以及管理 </span> 
					<a href="javascript:void(0);" class="addStoreTag" type="msmall">添加商家</a> (双击可以移除)<br />
					<div class="mapfather" id="store_map_small">
						<img src="<?= $base; ?>data/store/<?= $store['store_map_small']; ?>" width="670" height="318" style="max-width: 940px;" />
					</div>
					<br />
                    <input class="button saveSmallMapData" type="button" value="保存近距离地图数据" />
				</p>
				<script type="text/javascript">
					
					// Ini big map data.
					var smallData = <?= $store['store_map_small_json']; ?>;
					var smallDataSize = smallData.length;
					
					for (var i = 0; i < smallDataSize; i++) {
						
						$("#store_map_small").append('<div class="cross" link="'+smallData[i].link+'" left="'+smallData[i].left+'" top="'+smallData[i].top+'" style="top:'+smallData[i].top+'px;left:'+smallData[i].left+'px;">'+smallData[i].name+'</div>');
						
					}
					
				</script>
				<?php endif; ?>
				
                </form>

				<div class="clear"></div><!-- End .clear -->

			</div> <!-- End #tab2 -->

		</div> <!-- End .content-box-content -->

	</div> <!-- End .content-box -->


	<div class="clear"></div>
    <?php $this->load->view("control_panel/doing"); ?>

	<?php $this->load->view('control_panel/footer'); ?>
    <!-- End #footer -->
    
    <!-- Start with #addNewST -->
    <div class='popdiv' id="addNewST" style="display: none;">
	  <div class='popdiv_title'>添加新地图商家</div>
	  <div class='popdiv_content'>
	    <form>
	        <p>
	            <span>商家名称 : </span>
	            <label><input id="NS_name" class="text-input medium-input" type="text" name="NS_name" value="" /></label>
	        </p>
	
	        <p>
	            <span>商家链接 : </span>
	            <label><input id="NS_link" class="text-input medium-input" type="text" name="NS_link" value="" /></label>
	        </p>
	
	    </form>
	  </div>
	  <div class='popdiv_buttons'>
	      <a class='buttons createNewStoreTag' href='javascript:void(0);' >确定</a>
	  </div>
	</div>
	<!-- End #addNewST -->
	
</div>
</body>
</html>