<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理系统 - Aiwifi</title>
<?php $this->load->view('control_panel/head_meta'); ?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

<!-- 载入baidu Map -->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=629d250d8dffa90f0e1bb0ba9aee0d40"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />

<!--二次开发baidu类-->
<script type="text/javascript" src="/source/scripts/baiduMap.class.js"></script>
</head>
<body>

<div id="frame_content">
<!-- Page Head -->
    <!-- smallpanel [begin] -->
    <div class="smallpanel">
    	<div class="pcont-1"><div class="pcont-2"><div class="pcont-3">
    		<div id="adminbarleft">当前所在的位置 : 商家地图</div>
    		<div id="adminbar">欢迎您回来, 
            <span> <?= $this->session->userdata('admin_name'); ?> !&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" id="edit_admin_info">修改信息</a></span>
            <script type="text/javascript">
				$("#edit_admin_info").click(function(){
					$.facebox({ajax:"/control_panel/admin/admin_edit/"});
				});
			</script>
            <a href="javascript: history.back();" class="logout">返回上一步</a>  </div>
    	</div></div></div>
    </div>
    <div class="clear"></div> <!-- End .clear -->

	<div class="content-box"><!-- Start Content Box -->
		<div class="content-box-header">
			<h3>商家地图</h3>
			<div class="clear"></div>
		</div> <!-- End .content-box-header -->
		
        <div style="margin:30px;">
          <form action="" method="post" enctype="multipart/form-data" id="storeMap" name="storeMap">
            <dl>
                <dd>
                    <ul>
                        <li>商家：
                          <select id="store_id" name="store_id" onChange="gourl('/control_panel/store/map/'+this.value);">
                            <?php foreach($stores as $r){
									$selected = $store_id==$r['store_id']?'selected':'';
							?>
                            <option value="<?php echo $r['store_id'];?>" <?php echo $selected;?>><?php echo $r['store_name'];?></option>
                            <?php }?>
                    	  </select>
                      </li>
                        <li style="display:none;">
                          位置：经度 <input name="x" type="text" id="x" value="<?php echo empty($mapInfo['x'])?'116.404':$mapInfo['x'];?>"> 纬度 <input name="y" type="text" id="y" value="<?php echo empty($mapInfo['y'])?'39.915':$mapInfo['y'];?>">
                            缩放级别: <input name="zoom" type="text" id="zoom" value="<?php echo empty($mapInfo['zoom'])?15:$mapInfo['zoom'];?>">
                        </li>
                        <li>标题：<input name="title" type="text" id="title" value="<?php echo empty($mapInfo['title'])?$store_name:$mapInfo['title'];?>" size="18" maxlength="16"></li>
                        <li>地址：<input name="address" type="text" id="address" value="<?php echo $mapInfo['address'];?>" size="50" maxlength="50"></li>
                        <li>电话：<input name="tel" type="text" id="tel" value="<?php echo $mapInfo['tel'];?>" size="18" maxlength="16"></li>
                        <li>图片：<input type="file" name="pic" id="pic"> 图片尺寸: 100px X 100px</li>
                        <li>简介：<input name="content" type="text" id="content" value="<?php echo $mapInfo['content'];?>" size="100" maxlength="100"></li>
                        <li>前端显示：<input name="isshow" type="checkbox" value="1" <?php if($mapInfo['isshow'] || empty($mapInfo)){echo 'checked';}?>><input type="hidden" name="o" value="ok"/></li>
                        <br />
                        <li>设置地图上不显示商家ID：(<strong><span style="color: #F00">各商家ID之间用,逗号隔开</span></strong>)<br /><textarea name="noShowStoreList" cols="45" rows="5"><?php echo $mapInfo['noShowStoreList'];?></textarea></li>
                        <input type="button" value="保存" onClick="save();">
                        <input type="button" value="刷新信息框" onClick="showInfo();">
                    </ul>
                </dd>
            </dl>
	    </form>
        	选择地图坐标:<br><br>
			<div id="container" style="width:760px; height:450px;"></div>
        </div>
    </div> <!-- End .content-box -->

	<div class="clear"></div>
    <?php $this->load->view("control_panel/doing"); ?>
	<?php $this->load->view('control_panel/footer'); ?>
    <!-- End #footer -->
</div>

<script type="text/javascript">
//生成地图对象
var map = new mapX("container");

//默认指向北京中心 - 天安门
var x = $('#x').val();
var y = $('#y').val();
var zoom = $('#zoom').val();
map.center(x,y,zoom);

//生成当前商家的活动标点
map.EditMarker({
	   id: $('#store_id').val(),
	   x:x,
	   y:y,
	   title: $('#title').val(),
	   address: $('#address').val(),
	   tel: $('#tel').val(),
	   pic: '<?php echo $mapInfo['pic'];?>',
	   content: $('#content').val(),
	   isshow:true
  });

//生成其它商家的固定标点
<?php
foreach($stores as $r){
	if($store_id!=$r['store_id'] && !empty($r['mapInfo'])){
?>
map.marker({
   id: '<?php echo $r['mapInfo']['id'];?>',
   x: '<?php echo $r['mapInfo']['x'];?>',
   y: '<?php echo $r['mapInfo']['y'];?>',
   title: '<?php echo $r['mapInfo']['title'];?>',
   address: '<?php echo $r['mapInfo']['address'];?>',
   tel: '<?php echo $r['mapInfo']['tel'];?>',
   pic: '<?php echo $r['mapInfo']['pic'];?>',
   content: '<?php echo $r['mapInfo']['content'];?>',
   isshow: <?php echo (int)$r['mapInfo']['isshow'];?>
});
<?php
	}
}?>


//保存商家的地图信息
function save()
{
	var id = $('#store_id').val();
	//回填地图参数到表单
	$('#x').val(map.getXY(id).x);
	$('#y').val(map.getXY(id).y);
	$('#zoom').val(map.mapInfo().zoom);
	//提交表单
	$('#storeMap').submit();
}

//展示信息
function showInfo()
{
	var data = {
			id: $('#store_id').val(),
			title: $('#title').val(),
			address: $('#address').val(),
			tel: $('#tel').val(),
			pic: $('#pic').val(),
			content: $('#content').val(),
			isshow: true
		};
	map.setInfoWindows(data);
}
</script>
</body>
</html>