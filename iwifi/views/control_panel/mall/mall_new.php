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
    	
    	window.location.href="<?= $base; ?>control_panel/shop/index/";
    	
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
					<span>商家LOGO : </span>
					<input type="file" value="1/0/2d34aa3dcd0bf81bd8b37f5ca42a68f0.jpg" onchange="ImagePreview('file','preview');" class="text-input small-input" name="adImg" id="file">
                    <br /><small>商家的LOGO</small>
				</p>
				<p>
					<span>商家区县 : </span>
					<select id="type" name="type">
			        	<option selected="" value="1000000">北京</option>
			        	<option value="2000000">上海</option>
			        </select>
					<select id="type" name="type">
			        	<option selected="" value="1000000">辖区</option>
			        	<option value="2000000">远郊</option>
			        </select>
					<select id="type" name="type">
			        	<option selected="" value="1000000">昌平区</option>
			        	<option value="2000000">朝阳区</option>
			        </select>		        
                    <br /><small>标明商家所在的区, 例如 北京 海淀</small>
				</p>
				<p>
					<span>手工排序 : </span>
					<input class="text-input small-input" type="text" id="store_address" name="store_address" />
                    <br /><small>序号越小，越靠前显示.</small>
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
					<span>商家简介 : </span>
					<textarea class="text-input medium-input" id="content" name="store_descript" style="height:300px; width:800px;"></textarea>
				</p>  

				<p>
					<span>公交路线 : </span>
					<textarea class="text-input medium-input" id="busline" name="store_descript" style="height:300px; width:800px;"></textarea>
				</p>  

				<p>
					<span>免费班车 : </span>
					<textarea class="text-input medium-input" id="carqin" name="store_descript" style="height:300px; width:800px;"></textarea>
				</p> 

				<p>
					<span>地下车库 : </span>
					<textarea class="text-input medium-input" id="carkoo" name="store_descript" style="height:300px; width:800px;"></textarea>
				</p>  

				<div class="shopTitle">焦点图设置</div>
				<p>
					<span>第一张 : </span>
					<input type="file" value="1/0/2d34aa3dcd0bf81bd8b37f5ca42a68f0.jpg" onchange="ImagePreview('file','preview');" class="text-input small-input" name="adImg" id="file">
					<input class="text-input small-input" type="text" id="store_address" name="store_address" placeholder="链接地址" />
				</p>  
				<p>
					<span>第二张 : </span>
					<input type="file" value="1/0/2d34aa3dcd0bf81bd8b37f5ca42a68f0.jpg" onchange="ImagePreview('file','preview');" class="text-input small-input" name="adImg" id="file">
					<input class="text-input small-input" type="text" id="store_address" name="store_address" placeholder="链接地址" />
				</p> 
				<p>
					<span>第三张 : </span>
					<input type="file" value="1/0/2d34aa3dcd0bf81bd8b37f5ca42a68f0.jpg" onchange="ImagePreview('file','preview');" class="text-input small-input" name="adImg" id="file">
					<input class="text-input small-input" type="text" id="store_address" name="store_address" placeholder="链接地址" />
				</p> 
				<p>
					<span>第四张 : </span>
					<input type="file" value="1/0/2d34aa3dcd0bf81bd8b37f5ca42a68f0.jpg" onchange="ImagePreview('file','preview');" class="text-input small-input" name="adImg" id="file">
					<input class="text-input small-input" type="text" id="store_address" name="store_address" placeholder="链接地址" />
				</p> 
				<p>
					<span>第五张 : </span>
					<input type="file" value="1/0/2d34aa3dcd0bf81bd8b37f5ca42a68f0.jpg" onchange="ImagePreview('file','preview');" class="text-input small-input" name="adImg" id="file">
					<input class="text-input small-input" type="text" id="store_address" name="store_address" placeholder="链接地址" />
				</p>
				<div class="shopTitle">状态设置</div>
				<p>
					<span>展示状态 : </span>
					<input name="status" type="checkbox" value="1" checked="checked"/> 开启展示状态
				</p>
                <p>
				  <input class="button submitStoreBasic" type="button" value="添加商家" />
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