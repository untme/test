<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<!--jquery-ui.js-->
<link rel="stylesheet" type="text/css" href="/source/style/control_panel/smoothness/jquery-ui.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/jquery-ui.js"></script>
<title><?= $this->lang->line('upgrade_one_title'); ?></title>
<script>
//函数说明: 转向其它网址
//函数引用: gourl("转向的网址",是否不能后退)
function gourl(url,isnoback)
{
	if(url){
		if(isnoback){
			window.location.href = url;
		}else{
			window.location.replace(url);
		}
	}
}
</script>
</head>
<body>
    <div class="wrapper_top"></div>
    <div class="wrapper">
        <div class="main">
            <?= $this->load->view('head'); ?>
            <?= $this->load->view('_welcome'); ?>
            <div class="main_center">
               <div class="upgrade_title"><?= $this->lang->line('upgrade_one_welcome'); ?></div>
               <div class="upgrade_contant">
               <?= $this->lang->line('upgrade_one_main'); ?>
            </div>
            <br /><br /><br />

            <!-- 收费服务列表 [LiBin] -->
            <fieldset style="width:99%">
                <legend><strong>自助上网服务: </strong></legend>
                <br />
                <?php
				//接收参数
				$type = trim($_GET['type'])==''?'4M':trim($_GET['type']);
				
			   //服务分类处理
			   $sevice = array();
			   foreach($payService as $key=>$r){
			   		$_type = trim($r['type']);
			   		!empty($_type) && $sevice[$_type][] = $r;
			   }
			   ?>
               选择带宽：
               <select name="type" onchange="gourl('?type='+this.value);">
               <?php foreach($sevice as $key=>$s){?>
                 <option value="<?php echo $key?>" <?php if($type==$key){echo 'selected';}?>><?php echo $key?> 宽带</option>
               <?php }?>
         	   </select>
               <br /><br />
          	   <?php if(!empty($sevice[$type])){?>
               <form method="post" target="_blank" action="/api/service?_t=1370097498">
               选择时长：
                <select name="name">
                <?php foreach($sevice[$type] as $r){?>
                  <option value="<?php echo $r['name'] ?>"><?php echo $r['title']?> － ￥<?php echo $r['price']?></option>
                <?php }?>
                </select>
                <input type="hidden" name="o" value="buy">
                <br /><br />
                <input id="button_buy" type="submit" value="购买">
       	        <script>$( "#button_buy" ).button();</script>
              </form>
			  <?php }?>
            </fieldset>
            <br />
            详情请咨询客服电话 4001681799
            </div>
          </div>
        <!-- 收费服务列表 End [LiBin] -->
        
            <?= $this->load->view('foot'); ?>
        </div>
    </div>
</body>
</html>