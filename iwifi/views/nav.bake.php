<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,user-scalable=no" />
<link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<title><?= $this->lang->line('nav_title'); ?></title>
<script type="text/javascript">
	$(function(){
		
		// Open the box.
		$("#openBox").click(function(){
			
			$("#facebox_overlay").show();
			$("#facebox").show();
			
		});
		// Close the box.
		$(".close").click(function(){
			
			$("#facebox_overlay").hide();
			$("#facebox").hide();
			
		});
		
		//试用20分钟 [LiBin]
		$("#tryGoldUser").click(function(){
			if ($(this).hasClass('trialed')) {
				return false;
			}
			//退出计费系统的登录
			$('#link_logout').attr("src",'http://10.5.0.1/logout?<?php echo time();?>');
			//提交试用
			var url = '/api/service?o=hot-test-00';
			$.getJSON(url,{},function(json){
				$("#tryGoldUser").addClass('trialed');
				alert(json.text);
				if(json.value){
					//如果成功则跳转到登录页面
					window.location.replace('/api/goLoginUrl');
				}
			});
		});
		
	});
</script>
</head>
<body>
    <div class="wrapper_top"></div>
    <div class="wrapper">
        <div class="main">
            <?= $this->load->view('head'); ?>
            <?= $this->load->view('_welcome'); ?>
			<div class="head_y">
                <div>
				您已成功连接到互联网，当前服务类型为：<?php echo $service['title'];?>
                <?php if($service['id']==31){ ?>
                ， <a href="<?= $base;?>user/upgrade"><?php echo '<strong><font color="#FF0000">现在升级高速上网</font></strong>';?></a>
                <?php } ?>
                </div>
                <div class="head_right"></div>
            </div>
            <div class="main_center">
                <div class="nav_left"><a href="<?= $base; ?>store/index/<?= $store['store_id']; ?>" class="blue"><?= $store['store_name']; ?><?= $this->lang->line('nav_discount'); ?></a></div>
                
                <!-- 试用20分钟 [LiBin] -->
                <?php if(!$trial): ?>
                <!--
              <div class="nav_right" id="tryGoldUser" style="cursor: pointer;"><?= $this->lang->line('nav_trial_button'); ?></div>
                -->
                <a href="javascript:;" id="tryGoldUser" class="nav_right"><img src="/source/images/try20mNet.jpg" width="250" height="40" /></a>
				<?php else: ?>
                <!--<div class="nav_right trialed" id="tryGoldUser"><?= $this->lang->line('nav_trial_button'); ?></div>-->
                <?php endif; ?>
                
                <div class="navigation">
                    <?php foreach ($nav as $one): ?>
                    <a href="<?= $one['nav_link']; ?>" target="_blank">
                        <div class="album_pic"><img src="<?= $base.'data/navigator/'.$one['nav_img']; ?>"/></div>
                        <div class="album_der"><?= $one['nav_title']; ?></div>
                    </a>
                    <?php endforeach; ?>
                    <?php foreach ($nav_user as $two): ?>
                    <a href="<?= $two['nav_link']; ?>" target="_blank">
                        <div class="album_pic"><img src="<?= $base.'data/navigator/'.$two['nav_img']; ?>"/></div>
                        <div class="album_der"><?= $two['nav_title']; ?></div>
                    </a>
                    <?php endforeach; ?>
                    <a href="javascript:void(0);" id="openBox">
                        <div class="album_pic"><img src="<?= $source; ?>images/ab.png"/></div>
                        <div class="album_der"><?= $this->lang->line('nav_diy'); ?></div>
                    </a>
                </div>
                
                <div id="facebox" style="top: 139px; left: 513px; display: none;">       
                    <div class="popup">        
                        <div class="content">
                            <div class="popdiv">
                                <div class="popdiv_title"><div style="float: left;"><?= $this->lang->line('nav_diy'); ?></div>
                                <a href="javascript:void(0);" class="close"><img src="<?= $source; ?>images/closelabel.png" class="close_image" title="close"/></a> 
                                 </div>
                                
                                <div class="popdiv_content">
                                	<form action="<?= $base; ?>user/add_link/" method="post" enctype="multipart/form-data">
                                    <p>
                                        <span>&nbsp;&nbsp;&nbsp;&nbsp;<?= $this->lang->line('nav_diy_upload_pic'); ?> : </span>
                                        <input type="file" name="nav_img" class="popdiv_text1"/>
                                    </p>
                                    <p>
                                        <span><?= $this->lang->line('nav_diy_add_title'); ?>: </span>
                                        <input type="text" name="nav_title" value="" class="popdiv_text"/>
                                    </p>
                                    <p>
                                        <span><?= $this->lang->line('nav_diy_add_address'); ?> : </span>
                                        <input type="text" name="nav_link" value="" class="popdiv_text"/>
                                    </p>
                                    <p>
                                        <input type="submit" class="button" value="<?= $this->lang->line('nav_diy_sure'); ?>"/>
                                    </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>     
                </div>
                <div id="facebox_overlay" class="facebox_hide facebox_overlayBG" style="display: none; opacity: 0.2; "></div>
            </div>
            <?php if (!empty($ad['ad_img'])): ?>
            <img src="<?= $base; ?>data/ad/<?= $ad['ad_img']; ?>" class="add1" />
            <?php endif; ?>
            <?= $this->load->view('foot'); ?>
        </div>
    </div>
    
    <!-- 同步退出热点机标记 [Libin] 勿动-->
    <img id='link_logout' width='1' height='1' src='#'>
    
</body>
</html>