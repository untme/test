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
    	
        var floor_name = $('#floor_name').val();
        var floor_location = $('#floor_location').val();
        
        if (floor_name == '') {
        	
        	$.facebox({ alert: "请填写商家名称!"});
        	return false;
        	
        }
        
        if (floor_location == '') {
        	
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

				<form id="store_basic" enctype="multipart/form-data" method="post" target="_self" action="<?= $base; ?>control_panel/floor/processAddForm/">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>楼层名称 : </span>
					<input class="text-input small-input" type="text" id="floor_name" name="name" />
                    <br /><small>楼层名称</small>
				</p>
                <p>
					<span>楼层地图 :[图片建议大小：526*400] </span>
					<input type="file" value="" class="text-input small-input" name="map[]" id="file">
                    <br /><small>商家楼层图片</small>
				</p>
				<p>
					<!--<span>选择楼层 : </span>
					<select id="type" name="floornum">
						<?php foreach($floorNumMap as $key=>$value){ ?>
			        	<option <? if($floorNumSelected==$key){ ?>selected="selected"<?php }?> value="<?= $key;?>"><?= $value;?></option>
						<?php }?>
			        </select>		        
                    <br /><small>标明所属商家楼层</small>-->
				</p>	
				<p>
					<span>归属商家 : </span>
					<select id="type" name="aiwifi_mall_pk_mall">
			        	<?php foreach($mallList as $k=>$malls):?>
						<optgroup label="<?= $k; ?>"></optgroup>
							<?php foreach($malls as $mall): ?>
								<option <?php if($mall['pk_mall']==$band['aiwifi_mall_pk_mall']){ ?>selected="selected"<?php } ?> value="<?= $mall['pk_mall'];?>"><?= $mall['name'];?></option>
							<?php endforeach; ?>
						<?php endforeach; ?>
			        </select>		        
                    <br /><small>标明所属商家</small>
				</p>
				<p>
					<span>手工排序 : </span>
					<input class="text-input small-input" type="text" id="floor_porder" name="porder" />
                    <br /><small>序号越小，越靠前显示.</small>
				</p>				
			
				<p>
					<span>楼层详情 : </span>
					<textarea class="text-input medium-input" id="floor_detail" name="detail" style="height:300px; width:800px;"></textarea>
				</p>  

				<div class="shopTitle">楼层九宫格详情</div>
				<p>
					<span>第一区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p>  
				<p>
					<span>第二区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p>  
				<p>
					<span>第三区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p>  
				<p>
					<span>第四区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p>  
				<p>
					<span>第五区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p>  
				<p>
					<span>第六区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p> 
				<p>
					<span>第七区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p>  
				<p>
					<span>第八区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p>  
				<p>
					<span>第九区 : </span>
					<input type="text" value="" class="text-input small-input" name="funpt[]">
					<input class="text-input small-input" type="text" id="store_address" name="store_address[]" placeholder="链接地址" />
				</p> 

				<div class="shopTitle">状态设置</div>
				<p>
					<span>展示状态 : </span>
					<input type="checkbox" <?php if($floorStateSelected=='on'){?>checked="checked"<?php }?> value="<?= $floorState[$floorStateSelected];?>" name="state"> 开启展示状态
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
	K.create('#floor_detail', {
		allowFileManager : true,
		afterBlur: function(){this.sync();}
	});

});

</script>
</body>
</html>
