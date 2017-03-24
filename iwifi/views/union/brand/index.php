<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title>品牌详情页</title>
    <link href="<?= $source;?>style/css/frame.css" type="text/css" rel="stylesheet">
    <link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
    <script src="<?= $source;?>js/jquery.js"></script>
</head>
<body>
    <div class="G_topbar"></div>
    <div class="G_frame">
        <div class="G_main">
            <div class="G_head">
                <?= $this->load->view('union/mallHead'); ?>
            </div>
            <div class="G_hline metro_blue" <?php if($mall['bgcolor']){ echo "style='background-color:#{$mall['bgcolor']}'";} ?>></div>

            <div class="G_modwrap">
                <div class="G_ad_a">
                    <div class="adbox">
                        <a target="_blank" href="/union/activity/index/<?= $actop['aiwifi_mall_pk_mall'];?>/<?= $actop['pk_activity'];?>/"><img src="<?= $actop['focus'] ;?>" class="pic">
                        </a>
                    </div>
                </div>
            </div>

            <div class="G_modwrap">

                <div class="G_pt_a S_line1">
                    <h1 class="modtitle">品牌查询<!-- <a href="#1" class="morelink">more &raquo;</a> --></h1>
                    <div class="m_wrap">
						<form method="get" action="/union/brand/search/<?= $mallID;?>/">
                        <div class="G_search line_metro_blue clearfix">
                            <input type="text" class="ipt_text" value="" placeholder="请输入你想要找的品牌">
                            <input href="#" class="search_btn metro_blue" value="搜索">
                        </div>
                        <div class="selbox">
                            <span class="sel">经营类型：
                        		<select  id="type" name="type">
                        			<option value="0">全部</option>
									<?php foreach($floorType as $k=>$type):?>
										<option value="<?= $k;?>"><?= $type;?></option>
									<?php endforeach ;?>
                        		</select>
                        	</span>
                            <span class="sel">楼层：
                        		<select  id="type" name="type">
                        			<option value="0">全部</option>
									<?php foreach($floorNumMap as $k=>$map):?>
										<option value="<?= $k;?>"><?= $map;?></option>
									<?php endforeach ;?>
                        		</select>
                        	</span>
                        </div>
						</form>
		<div class="ptlist">
			<ul class="ul_list clearfix">
				<?php foreach($brands as $brand): ?>
				<li class="li_item">
					<div class="picbox">
						<a target="_blank" href="/union/brand/detail/<?= $brand['pk_brand'];?>"><img src="<?= $brand['logo'];?>" class="pic"></a>
					</div>
					<div class="title G_autocut"><?= $brand['name'];?></div>
					<div class="subtitle G_autocut S_txt2"><?= $floorNumMap[$brand['aiwifi_floor_pk_floor']];?> <?= $floorType[$brand['type']];?></div>
				</li>	
				<?php endforeach ; ?>
				<!--
				<li class="li_item">
					<div class="picbox">
						<a href="#1"><img src="images/_temp/ad06.jpg" class="pic"></a>
					</div>
					<div class="title G_autocut">品牌名称</div>
					<div class="subtitle G_autocut S_txt2">楼层 分类</div>
				</li>
				<li class="li_item">
					<div class="picbox">
						<a href="#1"><img src="images/_temp/ad06.jpg" class="pic"></a>
					</div>
					<div class="title G_autocut">品牌名称</div>
					<div class="subtitle G_autocut S_txt2">楼层 分类</div>
				</li>
				<li class="li_item">
					<div class="picbox">
						<a href="#1"><img src="images/_temp/ad06.jpg" class="pic"></a>
					</div>
					<div class="title G_autocut">品牌名称</div>
					<div class="subtitle G_autocut S_txt2">楼层 分类</div>
				</li>
				<li class="li_item">
					<div class="picbox">
						<a href="#1"><img src="images/_temp/ad06.jpg" class="pic"></a>
					</div>
					<div class="title G_autocut">品牌名称</div>
					<div class="subtitle G_autocut S_txt2">楼层 分类</div>
				</li>
				-->
			</ul>
		</div>

		<div class="G_page clearfix">
			<?= $this->pagination->create_links(); ?>
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
</body>
</html>
