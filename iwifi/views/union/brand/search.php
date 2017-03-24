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
                        <div class="G_search line_metro_blue clearfix" id="SearchForm">
                            <input type="text" class="ipt_text" value="<?= $like['name'];?>" placeholder="请输入你想要找的品牌">
                            <input class="search_btn metro_blue" value="搜索" id="sosoBtn" data-action="/union/brand/search/<?= $where['aiwifi_floor_aiwifi_mall_pk_mall'];?>/">
                        </div>
                        <div class="selbox">
                            <span class="sel">经营类型：
                        		<select id="type" name="type">
                        			<option value="0">全部</option>
									<?php foreach($floorType as $k=>$type):?>
										<option <?php if($where['type']==$k){ ?>selected="selected"<?php }?> value="<?= $k;?>"><?= $type;?></option>
									<?php endforeach ;?>
                        		</select>
                        	</span>
                            <span class="sel">楼层：
                        		<select id="floor" name="floor">
                        			<option value="0">全部</option>
									<?php foreach($floorNumMap as $k=>$map):?>
										<option <?php if($where['aiwifi_floor_pk_floor']==$k){ ?>selected="selected"<?php }?> value="<?= $k;?>"><?= $map;?></option>
									<?php endforeach ;?>
                        		</select>
                        	</span>
                        </div>
		
		<div class="ptlist">
			<ul class="ul_list clearfix">
				<?php foreach($brands as $brand): ?>
				<li class="li_item">
					<div class="picbox">
						<a href="/union/brand/detail/<?= $brand['pk_brand'];?>"><img src="<?= $brand['logo'];?>" class="pic"></a>
					</div>
					<div class="title G_autocut"><?= $brand['name'];?></div>
					<div class="subtitle G_autocut S_txt2"><?= $floorNumMap[$brand['aiwifi_floor_pk_floor']];?> <?= $floorType[$brand['type']];?></div>
				</li>	
				<?php endforeach ; ?>
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
<script type="text/javascript">
$(function(){

	$('#sosoBtn').bind('click',function(){
		var key    = $('.ipt_text').val();
		var action = $(this).attr('data-action');
		var type   = $('#type option:selected').val();
		var floor  = $('#floor option:selected').val();

		if(key!=''){
			window.location.href = action+type+'_'+floor+'_'+encodeURI(key);
		}else{
			alert('请输入您要搜索的关键词');
		}
	})

	$('#SearchForm .ipt_text').bind('keydown',function(event){
		if(event.keyCode == 13) {
			var key = $(this).val();
			var action = $(this).next().attr('data-action');
			var type   = $('#type option:selected').val();
			var floor  = $('#floor option:selected').val();
		
			if(key!=''){
				window.location.href = action+type+'_'+floor+'_'+encodeURI(key);
			}else{
				alert('请输入您要搜索的关键词');
			}
		}
	})
})
</script>
</body>
</html>
