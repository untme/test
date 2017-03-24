<?php 
if(!(int)$store['status']){
	js::goback('此商家已失效！');
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<link href="<?= $source; ?>style/demo1/style.css" class="piro_style" media="screen" title="white" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<script type="text/javascript" src="<?= $source; ?>scripts/jcarousel.js"></script>
<script type="text/javascript" src="<?= $source; ?>scripts/pirobox.min.js"></script>

<!-- 载入baidu Map -->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=629d250d8dffa90f0e1bb0ba9aee0d40"></script>
<script type="text/javascript" src="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js"></script>
<link rel="stylesheet" href="http://api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.css" />
<!--二次开发baidu类-->
<script type="text/javascript" src="/source/scripts/baiduMap.class.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$(".pirobox_gall").piroBox({
			my_speed: 400, //animation speed
			bg_alpha: 0.1, //background opacity
			slideShow : true, // true == slideshow on, false == slideshow off
			slideSpeed : 4, //slideshow duration in seconds(3 to 6 Recommended)
			close_all : '.piro_close,.piro_overlay'// add class .piro_overlay(with comma)if you want overlay click close piroBox

	});
	$('#mycarousel').jcarousel();
});
</script>

<title><?= $store['store_name']; ?></title>
</head>
<body>
    <div class="wrapper_top"></div>
    <div class="wrapper">
        <div class="main">
            <?= $this->load->view('head'); ?>
            
            <?php if ( $islog == 'true' ): ?>
            <div class="welcome">
                <?= $this->lang->line('user_statu_welcome'); ?> <a href="<?= $base; ?>user/"><?= $this->session->userdata('nickname'); ?></a>!&nbsp;&nbsp;&nbsp;
                <a href="<?= $base; ?>user/profile"><?= $this->lang->line('user_statu_profile'); ?></a>&nbsp;&nbsp;&nbsp;
                <a href="<?= $base; ?>user/passwd"><?= $this->lang->line('user_statu_passwd'); ?></a>&nbsp;&nbsp;&nbsp;
                <a href="<?= $base; ?>user/upgrade"><?= $this->lang->line('user_statu_upgrade'); ?></a>
            </div>
            <?php endif; ?>
            <div class="main_center">
               <div class="shore_tile"><?= $store['store_name']; ?>欢迎您~!</div>
               <div class="shore_right"><div class="changbule" style="height: 1%;"></div><div class="right_word">我有金牌享受优惠</div></div>
               <img src="<?= $base; ?>data/store/<?= $store['store_banner']; ?>" class="add3"/>
               <div class=" jcarousel-skin-tango">
                    <div class="jcarousel-container jcarousel-container-horizontal" style="position: relative; display: block; ">
                        <div class="jcarousel-clip jcarousel-clip-horizontal" style="overflow-x: hidden; overflow-y: hidden; position: relative; ">
                            <ul id="mycarousel" class="jcarousel-list jcarousel-list-horizontal">
                                <?php foreach ($sign as $rows): ?>
                                <li><a href="<?= $base; ?>data/store/<?= $rows['sign_big']; ?>" class="pirobox_gall" title="<?= $rows['sign_word']; ?>"><img src="<?= $base; ?>data/store/<?= $rows['sign_small']; ?>" /></a></li>
                                <?php endforeach; ?>
                            </ul>
                    </div>
                    <div class="jcarousel-prev Triangle-me" style="display: block; " disabled="true"></div>
                    <div class="jcarousel-next Triangle-he" style="display: block; " disabled="false"></div>
                </div>
               </div>
               <div class="shore_r">
                    <div class="shore_tile">Aiwifi分布图</div>
                    <div class="shore_tap" curr="big" id="container" style="width:760px; height:450px;">
                    <!--
                        <img src="<?= $base; ?>data/store/<?= $store['store_map_big']?>" class="map1" map="big"/>
                        <img src="<?= $base; ?>data/store/<?= $store['store_map_middle']?>" class="map2" map="middle" style="display: none;"/>
                        <img src="<?= $base; ?>data/store/<?= $store['store_map_small']?>" class="map3" map="small" style="display: none;"/>
                        <div class="top_map"></div>
                        <div class="bottom_map"></div>
                    -->
                    </div>
<script type="text/javascript">
<?php 
//取得当前商家的地图信息
$mapInfo = json_decode(trim($store['mapInfo']),1);
//取得当前商家地图上不需要显示的其它商家id数组
$noShowStore = explode(',',trim($mapInfo['noShowStoreList']));
$sId = (int)$store['store_id'];
?>
//生成地图对象
var map = new mapX("container");
map.center('<?php echo $mapInfo['x'];?>','<?php echo $mapInfo['y'];?>','<?php echo $mapInfo['zoom'];?>');

//生成商家的固定标点
<?php foreach(storeX::get() as $r){
	if(!empty($r['mapInfo']) && !in_array($r['store_id'],$noShowStore)){
?>
map.marker({
	id: '<?php echo $r['mapInfo']['id'];?>',
	x: '<?php echo $r['mapInfo']['x'];?>',
	y: '<?php echo $r['mapInfo']['y'];?>',
	title: '<?php echo $r['mapInfo']['title'];?>',
	address: '<?php echo $r['mapInfo']['address'];?>',
	tel: '<?php echo $r['mapInfo']['tel'];?>',
	pic: '<?php echo $r['mapInfo']['pic'];?>',
	content: '<?php echo $r['mapInfo']['content'];?><br /> <a href="/store/index/<?php echo $r['mapInfo']['id'];?>"><strong>>>>进入商家页面</strong></a>',
	isshow: <?php echo (int)$r['mapInfo']['isshow'];?>
});
<?php }
}?>
//打开当前商家的信息窗口
map.openInfoWindows("<?php echo $sId;?>");
</script>
                    <script type="text/javascript">
                    /*
                    	// 切换地图
                    	$('.top_map').click(function(){
                    		
                    		var curr = $(this).parent(".shore_tap").attr('curr');
                    		
                    		if (curr == 'big') {
                    			
                    			// Do nothing ... 
                    			
                    		}else if (curr == 'middle') {
                    			
                    			// Hide other img and hide their sons
                    			$(this).siblings("img").hide().siblings("img[map=big]").show();
                    			$(this).siblings(".shore_1").hide().siblings(".shore_1[mapSize=big]").show();
                    			$(this).parent(".shore_tap").attr('curr', 'big');
                    			
                    		}else if (curr == 'small') {
                    			
                    			$(this).siblings("img").hide().siblings("img[map=middle]").show();
                    			$(this).siblings(".shore_1").hide().siblings(".shore_1[mapSize=middle]").show();
                    			$(this).parent(".shore_tap").attr('curr', 'middle');
                    			
                    		}
                    		
                    	});
                    	
                    	$(".bottom_map").click(function(){
                    		
                    		var curr = $(this).parent(".shore_tap").attr('curr');
                    		
                    		if (curr == 'big') {
                    			
                    			$(this).siblings("img[map=middle]").show().siblings("img").hide();
                    			$(this).siblings(".shore_1").hide().siblings(".shore_1[mapSize=middle]").show();
                    			$(this).parent(".shore_tap").attr('curr', 'middle');
                    			
                    		}else if (curr == 'middle') {
                    			
                    			// Hide other img and hide their sons
                    			$(this).siblings("img[map=small]").show().siblings("img").hide();
                    			$(this).siblings(".shore_1").hide().siblings(".shore_1[mapSize=small]").show();
                    			$(this).parent(".shore_tap").attr('curr', 'small');
                    			
                    		}else if (curr == 'small') {
                    			
                    			
                    		}
                    		
                    	});
                    
                    	// 
                    	var big = <?= $store['store_map_big_json']; ?>;
                    	var middle = <?= $store['store_map_middle_json']; ?>;
                    	var small = <?= $store['store_map_small_json']; ?>;

                    	// for big
                    	for (var i = 0; i < big.length; i++) {
                    		
                    		$('.shore_tap').append('<div class="shore_1" mapSize="big" style="left:'+big[i].left+'px;top:'+big[i].top+'px;"><a href="'+big[i].link+'" target="_blank"">'+big[i].name+'</a></div>');
                    		
                    	}
                    	
                    	// for middle
                    	for (var j = 0; j < middle.length; j++) {
                    		
                    		$('.shore_tap').append('<div class="shore_1" mapSize="middle" style="display:none;left:'+middle[j].left+'px;top:'+middle[j].top+'px;"><a href="'+middle[j].link+'" target="_blank"">'+middle[j].name+'</a></div>');
                    		
                    	}
                    	
                    	// for small
                    	for (var t = 0; t < small.length; t++) {
                    		
                    		$('.shore_tap').append('<div class="shore_1" mapSize="small" style="display:none;left:'+small[t].left+'px;top:'+small[t].top+'px;"><a href="'+small[t].link+'" target="_blank"">'+small[t].name+'</a></div>');
                    		
                    	}
                    */	
                    </script>
                    <div class="shore_tile">会员评论</div>
                    <?php if ($islog == 'true'): ?>
                    <textarea class="text_are"></textarea>
                    <input type="button" class="button5" value="发布评论"/>
                    <script type="text/javascript">
                    	
                    	$(".button5").click(function(){
                    		
                    		var content = $(".text_are").val();
                    		
                    		if (content == '') {
                    			
                    			alert("请输入评论内容后提交!");
                    			return false;
                    			
                    		}
                    		
                    		$.ajax({
					        	type: "POST",
					        	url: "<?= $base; ?>store/comments/",
					        	data: {store_id: <?= $store['store_id']; ?>, content: content},
					        	beforeSend: function(XMLHttpRequest){
					        		
									$(".button5").hide();
									
					        	},
					        	success: function(data){
					        		
									if (data == 1){
										
										alert('评论发布成功!');
										window.location.reload();
										
									}else if (data == 0) {
										
										alert('评论发表失败!');
										$(".button5").show();
									}
									
					        	},
					        	error: function(){
					        		
					        		alert('000');
					        		$(".button5").show();
					        	}
					        });
                    		
                    	});
                    	
                    </script>
                    <?php else: ?>
                    <div class="shore_tile" style="font-size: 12px;margin-left: 10px;">[您没有登录所以不能发表评论.]</div>
                    <?php endif; ?>
                    <div class="tap_con">
                        <?php foreach ($comment as $com): ?>
                        <?php 
                        
                        	$user = $this->aiwifi->comm_info('user', 'uid', $com['uid']);
                        
                        ?>
                        <div class="con_title"><?= $user['nickname']; ?> (<?= $user['type'] == 'normalMember' ? '普通会员' : '金牌会员'; ?>) 于 <?= date('Y年m月d日 H:i', $com['post_date']); ?> 发布评论 :</div>
                        <div class="con_word">
                        <?= $com['content']; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
               </div>
               <div class="shore_l">
                    <div class="shore_tile">Aiwifi商家推荐</div>
                    <?php foreach ($store_relative as $s): ?>
                    <div class="shore_fri">
                        <a href="<?= $base; ?>store/index/<?= $s['store_id']; ?>">
                            <img src="<?= $base; ?>data/store/<?= $s['store_logo']; ?>"/>
                            <div class="fri_word"><span><?= $s['store_name']; ?> </span>&nbsp;&nbsp; <?= $s['store_location']; ?></div>
                        </a>
                    </div>
                    <?php endforeach; ?>
               </div>
               <?php if (!empty($ad['ad_img'])): ?>
               <img src="<?= $base; ?>data/ad/<?= $ad['ad_img']; ?>" class="add5" />
               <?php endif; ?>
            </div>
            <?= $this->load->view('foot'); ?>
        </div>
    </div>
</body>
</html>