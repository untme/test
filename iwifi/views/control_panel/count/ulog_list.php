<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){
		$('#submitSoBtnDT').bind('click',function(){
			var query = [];
			var start = $('#dt').val();
			query.push(encodeURI(start))
			var end = $('#dt2').val();
			query.push(encodeURI(end))
			var type   = $('#filterAp option:selected').val();
			query.push(encodeURI(type))
			var key = $('#key').val();
			query.push(encodeURI(key))
			href = '/control_panel/count/ulog/'+query.join('_')+'/0/';
			window.location.href = href;
			})

		});
</script>
<link type="text/css" href="/source/style/control_panel/lhgcalendar.css" rel="stylesheet">
<script type="text/javascript" src="/source/scripts/lhgcalendar.js"></script>
<script type="text/javascript" src="/source/scripts/countJs.js"></script>
<script>
 //获取UA
 function appInfo(){  
    var browser = {appname: 'unknown', version: 0},  
        userAgent = window.navigator.userAgent.toLowerCase();  
//IE,firefox,opera,chrome,netscape  
    if ( /(msie|firefox|opera|chrome|netscape)\D+(\d[\d.]*)/.test( userAgent ) ){  
        browser.appname = RegExp.$1;  
        browser.version = RegExp.$2;  
    } else if ( /version\D+(\d[\d.]*).*safari/.test( userAgent ) ){ // safari  
        browser.appname = 'safari';  
        browser.version = RegExp.$2;  
    }  
    return browser;  
}
var testBrowser = appInfo();console.log(testBrowser.appname+testBrowser.version);
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
<div class="dataNow">
<ul class="clearfix">
<li><i class="nowDat day"><?=$t;?></i>:登陆<i class="red"><?=$t_total_rows; ?></i>次</li>
<li><i class="yesDat day"><?=$y;?></i>:登陆<i class="red"><?=$y_total_rows; ?></i>次</li>
<li><i class="yeyeDat day"><?=$by;?></i>:登陆<i class="red"><?=$by_total_rows; ?></i>次</li>
</ul>
</div>

<div class="searchTab clearfix" id="searchTab">
	<div class="globePoster">
		<input class="v" placeholder="请选择检索关键词" data-attr="ulog" value="<?=$key; ?>" id="key" type="text">
		<div class="autoKey">
			<ul id="autoKeyUl">
				<li>数据加载中...</li>
			</ul>
		</div>
	</div>
	<select name="" class="v selt" id="filterAp">
		<option value="4" <?php if($type==4){ ?>selected="selected"<?php }?>>商超检索</option>
		<option value="1" <?php if($type==1){ ?>selected="selected"<?php }?>>设备检索</option>
		<option value="2" <?php if($type==2){ ?>selected="selected"<?php }?>>用户检索</option>
	</select>
	<input value="<?=$min;?>" class="v auto-time" id="dt" placeholder="请选择起始日期" type="text">
	<input value="<?=$max; ?>" class="v auto-time2" id="dt2" placeholder="请选择结束日期" type="text">
	<input class="btn regUerBtn" type="submit" id="submitSoBtnDT" value="查询" />
	<span class="countNum">搜到<i><?=$total_rows;?></i>条</span>
</div>


<!-- <div class="searchTab clearfix" id="searchTab">
	<input value="<?=$max;?>" class="v auto-time" id="dt" placeholder="请选择筛选日期" type="text">
	<input value="<?=$min; ?>" class="v auto-time2" id="dt2" placeholder="请选择筛选日期" type="text">
	<input class="btn regUerBtn" type="submit" id="submitSoBtnDT" value="按时间查询" />
</div>
<div class="clear"></div> -->
<!-- End .clear -->
<!-- <div class="searchTab clearfix" id="searchTab">
<input class="v" placeholder="请选择检索关键词" id="key" type="text">
<select name="" class="v selt" id="filterAp">
	<option value="1">设备检索</option>
	<option value="2">用户检索</option>
	<option value="4">商超检索</option>
</select>
<input class="btn" type="submit" id="submitSoBtn" value="确定" />
</div> -->



<div class="clear"></div><!-- End .clear -->
<table>

<thead class="tableHeader">
	<tr>
		<th style="width: 6%;text-align:center; ">序号</th>
		<th style="width: 20%;text-align:center;">storeName</th>
		<th style="width: 18%;text-align:center;">用户账号</th>
		<th style="width: 18%;text-align:center;">用户MAC</th>
		<th style="width: 20%;text-align:center;">登陆时间</th>
		<th style="width: 18%;text-align:center;">UserAgent</th>
	</tr>
</thead>

<tfoot>
<tr>
<td colspan="6">
<!-- <div class="bulk-actions align-left">
<a class="button" href="<?= $base; ?>control_panel/shop/new_shop_show/">添加商家信息</a>
</div> -->
<div class="pagination">
<?= $this->pagination->create_links(); ?>
</div>
<div class="clear"></div>
</td>
</tr>
</tfoot>

<tbody class="countUser">
<?php foreach($logs as $log){?>
	<tr>
		<th height="30"><?= $log['_id'];?></th>
		<td height="30"><?= $log['store_name'];?></td>
		<td height="30"><?= $log['username'];?></td>
		<td height="30"><?= $log['mac'];?></td>
		<td height="30"><?= $log['_time'];?></td>
		<td height="30"><?= $log['ua'];?></td>
		</tr>
		<?php }?>
		</tbody>

		</table>

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
