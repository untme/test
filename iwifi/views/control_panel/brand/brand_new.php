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
    	
        var brand_name = $('#barnd_name').val();
        var brand_aiwifi_floor_pk_floor = $('#brand_aiwifi_floor_pk_floor').val();
        
        if (brand_name == '') {
        	
        	$.facebox({ alert: "请填写品牌名称!"});
        	return false;
        	
        }
        
        if (brand_aiwifi_floor_pk_floor == '') {
        	
        	$.facebox({ alert: "请填写楼层信息!"});
        	return false;
        	
        }
        
        $("#store_basic").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	
    	window.location.href="<?= $base; ?>control_panel/brand/index/";
    	
    });
   
   $("#brand_aiwifi_floor_aiwifi_mall_pk_mall").change(function(){
	var api = '/control_panel/floor/getfloors/'+$(this).val();
   	$.getJSON(api,function(res){
		if(res.length == 0){
			alert('不能选择这个商场，没有楼层信息');
			return false;
		}
		var temp = '';
		for(i in res){
			item = res[i];
			temp += '<option value='+item.pk_floor+'>'+item.name+'</option>'; 
                }
		$("#brand_aiwifi_floor_pk_floor").html(temp);	
	});
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

				<form id="store_basic" enctype="multipart/form-data" method="post" target="_self" action="<?= $base; ?>control_panel/brand/processAddForm/">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>品牌名称 : </span>
					<input class="text-input small-input" type="text" id="brand_name" name="name" />
                    <br /><small>品牌名称</small>
				</p>
                <p>
					<span>品牌LOGO : </span>
					<input type="file" value="" class="text-input small-input" name="logo" id="brand_logo">
					<br /><small>商家的品牌LOGO</small>
				</p>
                <p>
					<span>活动焦点 : </span>
					<input type="file" value="" class="text-input small-input" name="focus" id="brand_focus">
                    <br /><small>商家的活动焦点图</small>
				</p>	
                <p>
					<span>活动横幅 : </span>
					<input type="file" value="" class="text-input small-input" name="hrad" id="brand_hrad">
                    <br /><small>商家的活动横幅</small>
				</p>
				<p>
					<span>归属商家 : </span>
					<select id="brand_aiwifi_floor_aiwifi_mall_pk_mall" name="aiwifi_floor_aiwifi_mall_pk_mall">
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
					<span>所属楼层 : </span>
					<select id="brand_aiwifi_floor_pk_floor" name="aiwifi_floor_pk_floor">
			        	<?php foreach($floorNumMap as $k=>$v): ?>
						<option value="<?= $k; ?>"><?= $v; ?></option>	
						<?php endforeach; ?>
			        </select>		        
                    <br /><small>标明所属楼层</small>
				</p>
				<p>
					<span>所属类别 : </span>
					<select id="brand_type" name="type">
						<?php foreach($floorType as $k=>$v): ?>
						<option value="<?= $k; ?>"><?= $v; ?></option>	
						<?php endforeach; ?>
			        </select>		        
                    <br /><small>标明所属活动</small>
				</p>
				<p>
					<span>手工排序 : </span>
					<input class="text-input small-input" type="text" id="brand_poroder" name="porder" />
                    <br /><small>序号越小，越靠前显示.</small>
				</p>				
				<p>
					<span class="display:block">品牌简介 : </span>
					<textarea class="text-input medium-input" id="brand_description" name="description" style="height:200px; width:800px;"></textarea>
				</p>  
				<p>
					<span>品牌详情 :</span>
					<textarea class="text-input medium-input" id="brand_detail" name="detail" style="height:300px; width:800px;"></textarea>
				</p> 
				<p>
					<span>活动详情 :  (在活动规定时间内会显示，非活动时间段隐藏)</span>
					<textarea class="text-input medium-input" id="action_detail" name="action_detail" style="height:300px; width:800px;"></textarea>
				</p>				
				
				<div class="shopTitle">状态设置</div>
				<p>
					<span>展示状态 : </span>
					<input type="checkbox" <?php if($brandStateSelected=='on'){?>checked="checked"<?php }?> value="<?= $brandState[$brandStateSelected];?>" name="state"> 开启展示状态
				</p>

                <p>
				  <input class="button submitStoreBasic" type="button" value="添加品牌" />
					<input class="button backtouserlist" type="button" value="返回品牌列表" />
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
	K.create('#brand_detail,#action_detail', {
		allowFileManager : true,
		afterBlur: function(){this.sync();}
	});
});
</script>
</body>
</html>