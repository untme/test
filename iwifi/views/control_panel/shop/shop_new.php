<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<link type="text/css" href="/source/style/control_panel/lhgcalendar.css" rel="stylesheet">
<script type="text/javascript" src="/source/scripts/lhgcalendar.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
    //检查用户表是否存在这个成员,并且将成员信息发布过来确认.
    $('.submitStoreBasic').click(function(){
    	
        var mall_name = $('#mall_name').val();
        var mall_location = $('#mall_location').val();
        var mall_server = $('#mall_servername').val();
        
        if (mall_name == '') {
        	
        	$.facebox({ alert: "请填写商家名称!"});
        	return false;
        	
        }
        
        if (mall_location == '') {
        	
        	$.facebox({ alert: "请填写商家区县!"});
        	return false;
        	
        }
        if (mall_server == '') {
        	$.facebox({ alert: "请填写商家热点名称!"});
        	return false;
        }
        
        $("#store_basic").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	window.location.href="<?= $base; ?>control_panel/mall/index/";
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

				<form id="store_basic" enctype="multipart/form-data" method="post" target="_self" action="<?= $base; ?>control_panel/mall/processAddForm/">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>商家名称 : </span>
					<input class="text-input small-input" type="text" id="mall_name" name="name" />
                    <br /><small>商家的名称</small>
				</p>
                <p>
					<span>热点名称 : </span>
					<input class="text-input small-input" type="text" id="mall_server" name="servername" />
                    <br /><small>热点的名称</small>
				</p>
                <p>
					<span>商家LOGO : </span>
					<input type="file" value="" onchange="ImagePreview('file','preview');" class="text-input small-input" name="logo" id="file"> <span class="upLogoSize">建议大小为：136*71</span>
                    <br /><small>商家的LOGO</small>
				</p>	
                <div class="peise">
					<span>按钮颜色 : </span>
					<input class="color" value="66ff00" name="bgColor" /><span class="bgwird">配色</span>
					<br /><small>按钮背景颜色</small>
					<div class="colorPT hide"><img src="/source/images/colorAll.jpg" ></div>
				</div>
                <p>
					<span>文本颜色 : </span>
					<input class="color" value="66ff00" name="txtBgColor" />
                    <br /><small>按钮文本颜色</small>
				</p>
                <p>
					<span>商家信息标题更改 : </span>
					<input value="<?= $mall['malltitle'];?>" name="malltitle" placeholder="默认：商家信息" />
                    <br /><small>商家信息</small>
				</p>
                <p>
					<span>楼层提示标题更改 : </span>
					<input value="<?= $mall['floortip'];?>" name="floortip" placeholder="默认：楼层提示" />
                    <br /><small>楼层提示</small>
				</p>
                <p>
					<span>品牌查询标题更改 : </span>
					<input value="<?= $mall['brandqy'];?>" name="brandqy" placeholder="默认：品牌查询" />
                    <br /><small>品牌查询</small>
				</p>
                <p>
					<span>免费上网标题更改 : </span>
					<input value="<?= $mall['freenet'];?>" name="freenet" placeholder="默认：免费上网" />
                    <br /><small>免费上网</small>
				</p>
                <p>
					<span>活动标题更改 : </span>
					<input value="" name="adtitle" placeholder="默认：最新活动" />
                    <br /><small>最新活动改名</small>
				</p>
                <p>
					<span>活动英文标题更改 : </span>
					<input value="" name="adetitle" placeholder="默认：Latest Events" />
                    <br /><small>最新活动英文改名</small>
				</p>				
				<p>
					<span>商家区县 : </span>
					<input class="text-input small-input" type="text" id="mall_location" name="location" />					<!--
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
					-->
                    <br /><small>标明商家所在的区, 例如 北京 海淀</small>
				</p>
				<p>
					<span>手工排序 : </span>
					<input class="text-input small-input" type="text" id="mall_porder" name="porder" />
                    <br /><small>序号越小，越靠前显示.</small>
				</p>				
				<p>
					<span>商家地址 : </span>
					<input class="text-input small-input" type="text" id="mall_address" name="address" />
                    <br /><small>商家的地址.不用写上面的区了.直接写街道即可.</small>
				</p>
				
				<p>
					<span>商家电话 : </span>
					<input class="text-input small-input" type="text" id="mall_tel" name="telephone" />
                    <br /><small>商家的电话联系方式.</small>
				</p>

				<p>
					<span style="display:block; margin-bottom:10px;"><input value="<?= $mall['dname'];?>" name="dname" placeholder="默认：商家简介" /> : </span>
					<textarea class="text-input medium-input" id="content" name="description" style="height:300px; width:800px;"></textarea>
				</p>  

				<p>
					<span style="display:block; margin-bottom:10px;"><input value="<?= $mall['cbname'];?>" name="cbname" placeholder="默认：公交路线" /> : </span>
					<textarea class="text-input medium-input" id="busline" name="citybus" style="height:300px; width:800px;"></textarea>
				</p>  

				<p>
					<span style="display:block; margin-bottom:10px;"><input value="<?= $mall['fbname'];?>" name="fbname" placeholder="默认：免费班车" /> : </span>
					<textarea class="text-input medium-input" id="carqin" name="freebus" style="height:300px; width:800px;"></textarea>
				</p> 

				<p>
					<span style="display:block; margin-bottom:10px;"><input value="<?= $mall['pkname'];?>" name="pkname" placeholder="默认：地下车库" /> : </span>
					<textarea class="text-input medium-input" id="carkoo" name="park" style="height:300px; width:800px;"></textarea>
				</p>  

				<div class="shopTitle">焦点图设置</div>
				<p>
					<span>第一张 : </span>
					<input type="file" value="" class="text-input small-input" name="focus[]" id="file1">
					<input class="text-input small-input" value="" type="text" id="focus_0_url" name="focus_url[]" placeholder="链接地址" />
				</p>  
				<p>
					<span>第二张 : </span>
					<input type="file" value="" class="text-input small-input" name="focus[]" id="file2">
					<input class="text-input small-input" value="" type="text" id="focus_1_url" name="focus_url[]" placeholder="链接地址" />
				</p> 
				<p>
					<span>第三张 : </span>
					<input type="file" value="" class="text-input small-input" name="focus[]" id="file3">
					<input class="text-input small-input" value="" type="text" id="focus_2_url" name="focus_url[]" placeholder="链接地址" />
				</p> 
				<p>
					<span>第四张 : </span>
					<input type="file" value="" class="text-input small-input" name="focus[]" id="file4">
					<input name="focus_4" type="checkbox" value="1" checked="checked"/>开启
                    <input class="text-input small-input" value="" type="text" id="focus_3_url" name="focus_url[]" placeholder="链接地址" />
				</p> 
				<p>
					<span>第五张 : </span>
					<input type="file" value="" class="text-input small-input" name="focus[]" id="file5">
                    <input name="focus_5" type="checkbox" value="1" checked="checked"/>开启
					<input class="text-input small-input" value="" type="text" id="focus_4_url" name="focus_url[]" placeholder="链接地址" />
				</p>
				<div class="shopTitle">商家可控广告位</div>
				<p>
					<span>第一张 : </span>
					<input type="file" value="" class="text-input small-input" name="topad[]" id="file6">
					<input class="text-input small-input" value="<?= $mall['topad_url'][0];?>" type="text" id="topad_0_url" name="topad_url[]" placeholder="链接地址" /><span class="metaImg
					">建议：900*80</span>
					<!--<input class="text-input small-input" type="text" id="store_address" name="store_address" placeholder="链接地址" />-->
				</p>  
				<p>
					<span>第二张 : </span>
					<input type="file" value="" class="text-input small-input" name="topad[]" id="file7">
					<input class="text-input small-input" value="<?= $mall['topad_url'][1];?>" type="text" id="topad_1_url" name="topad_url[]" placeholder="链接地址" /><span class="metaImg
					">建议：900*80</span>	
					<!--<input class="text-input small-input" type="text" id="store_address" name="store_address" placeholder="链接地址" />-->
				</p> 
				<p>
					<span>第三张 : </span>
					<input type="file" value="" class="text-input small-input" name="topad[]" id="file8">
					<input class="text-input small-input" value="<?= $mall['topad_url'][2];?>" type="text" id="topad_1_url" name="topad_url[]" placeholder="链接地址" /><span class="metaImg
					">建议：900*80</span>	
					<!--<input class="text-input small-input" type="text" id="store_address" name="store_address" placeholder="链接地址" />-->
				</p> 

				<div class="shopTitle">状态设置</div>
				<p>
					<span>展示状态 : </span>
					<input name="state" type="checkbox" value="1" checked="checked"/> 开启展示状态
				</p>

                <p>
				  <input class="button submitStoreBasic" type="submit" value="添加商家" />
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
<script type="text/javascript" src="/source/scripts/jscolor.js"></script>
<script type="text/javascript">
KindEditor.ready(function(K) {
	K.create('#content,#busline,#carqin,#carkoo', {
		allowFileManager : true,
		afterBlur: function(){this.sync();}
	});

});
</script>
</body>
</html>