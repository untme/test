<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title>商户首页</title>
    <link href="<?= $source;?>style/css/frame.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
    <script src="<?= $source;?>js/jquery.js"></script>
    <style type="text/css">
    .G_hline,.G_modwrap{ margin-bottom: 4px;}
    </style>
</head>
<body>
    <div class="G_topbar"></div>
    <div class="G_frame">
        <div class="G_main">
            <div class="G_head">
                <?= $this->load->view('union/mallHead'); ?>
            </div>
            <div class="G_hline metro_blue" <?php if($mall['bgcolor']){ echo "style='background-color:#{$mall['bgcolor']}'";} ?>></div>
            <!-- <div class="G_head G_head_person"><?= $this->load->view('union/_welcome'); ?></div> -->
            <div class="G_modwrap G_plpt">
                <div class="G_ploop clearfix">
                    <div class="myfocus" id="myfocus">
                        <div class='swipe-wrap'>
							<?php 
foreach($mall['focus'] as $k=>$pic): ?>
								<div class="li"><a href="<?= $mall['focus_url'][$k]; ?>"><img src="<?= $pic;?>"></a></div>
							<?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="dotbox">
                    <ul id="position">
	           <?foreach($mall['focus'] as $k=>$pic){ ?>		
                    <li class="dot<?php if($k==0){echo ' on';} ?>"></li>
                   <?php } ?>
                    </ul>
                </div>
            </div>
			<!--商户广告开始-->	
			<?php foreach($mall['topad'] as $k=>$pic): ?>
				<div class="G_modwrap">
                <div class="G_ad_a">
                    <div class="adbox">
                        <a target="_blank" href="<?= $mall['topad_url'][$k]; ?>"><img src="<?= $pic; ?>" class="pic"></a>
                    </div>
                </div>
				</div>
			<?php endforeach; ?>
			<!--商户广告结束-->
<!-- 			<?php foreach($activity as $k=>$pic): ?>
				<div class="G_modwrap">
                <div class="G_ad_a">
                    <div class="adbox">
                        <a target="_blank" href="/union/activity/index/<?= $pic['aiwifi_mall_pk_mall'];?>/<?= $pic['pk_activity'];?>/"><img src="<?= array_shift(json_decode($pic['focus'], true)); ?>" class="pic"></a>
                    </div>
                </div>
				</div>
			<?php endforeach; ?> -->

            <div class="G_modwrap">
                <div class="G_piclist_a">
                    <div class="m_wrap clearfix">
                        <div class="item_con">
                            <a <?php if($mall['bgcolor']){ echo "style='background-color:#{$mall['bgcolor']}'";} ?> href="/union/activity/alist/<?= $mall['pk_mall'];?>/" class="btnbox">
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="title"><?php if($mall['adtitle']){echo $mall['adtitle']; }else{ echo '最新活动'; }?></p>
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="subtitle"><?php if($mall['adetitle']){echo $mall['adetitle']; }else{ echo 'Latest Events'; }?></p>
                            </a>
                        </div>
                        <div class="item_con_2">
                            <a <?php if($mall['bgcolor']){ echo "style='background-color:#{$mall['bgcolor']}'";} ?> href="/union/mall/info/<?= $mall['pk_mall'];?>/" class="btnbox">
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="title"><?php if($mall['malltitle']){ echo $mall['malltitle']; }else{ ?>商家信息<?php } ?></p>
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="subtitle">Business information</p>
                            </a>
                            <a  <?php if($mall['bgcolor']){ echo "style='background-color:#{$mall['bgcolor']}'";} ?> href="/union/mall/floor/<?= $mall['pk_mall'];?>/" class="btnbox">
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="title"><?php if($mall['floortip']){ echo $mall['floortip']; }else{ ?>楼层提示<?php } ?></p>
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="subtitle">Floors tip</p>
                            </a>
                        </div>
                        <div class="item_con_2">
                            <a <?php if($mall['bgcolor']){ echo "style='background-color:#{$mall['bgcolor']}'";} ?> href="/union/free/index" class="btnbox">
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="title"><?php if($mall['freenet']){ echo $mall['freenet']; }else{ ?>免费上网<?php } ?></p>
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="subtitle">Free internet</p>
                            </a>
                            <a <?php if($mall['bgcolor']){ echo "style='background-color:#{$mall['bgcolor']}'";} ?> href="/union/brand/search/<?= $mall['pk_mall'];?>/0_0_0/0/" class="btnbox">
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="title"><?php if($mall['brandqy']){ echo $mall['brandqy']; }else{ ?>品牌查询<?php } ?></p>
                                <p <?php if($mall['txtbgcolor']){ echo "style='color:#{$mall['txtbgcolor']}'";} ?> class="subtitle">Brand queries</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>



        </div>


    </div>

    <div class="G_footer">
        <p class="text">Aiwifi由北京立时世通科技有限公司免费提供</p>
        <p class="text G_fb G_tcol_red">服务热线：400-168-1799</p>

    </div>
<script src="<?= $source; ?>js/focus.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    //focus
    var bullets = document.getElementById('position').getElementsByTagName('li');
    window.mySwipe = Swipe(document.getElementById('myfocus'), {
       auto: 3000,
       continuous: true,
       disableScroll: true,
       stopPropagation: false,
       callback: function(pos){
          var i = bullets.length;
          while (i--){
            bullets[i].className = ' ';
          }
          bullets[pos].className = 'on';
       }
    });
    
    $('#position').on('click','li',function(){
        var index = $('#position li').index(this);
        mySwipe.slide(index);
    })

})
</script>
</body>
</html>
