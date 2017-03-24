<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title>商户首页</title>
    <link href="<?= $source;?>style/css/frame.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
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
                <div class="G_map">
                    <div class="m_wrap clearfix">
                        <div class="map_box">
                          <div class="mapLimt">
                              <ul>
				<?php 
				$ad = $content['ad']?json_decode($content['ad'], true):array('funpt'=>array(),'store_address'=>array());
				foreach($ad['funpt'] as $i=>$funpt){ ?>
                                <li><a href="<?= $ad['store_address'][$i]; ?>"><?= $funpt; ?></a></li>	
				<?php 
				}
				?>
                              </ul>
                          </div>
						  <img src="<?= array_shift(json_decode($content['map'], true));?>" />
						</div>
                        <div class="info_box">
                            <div class="btn_con">
								<?php foreach($floor as $k=>$v): ?>
                                <a href="/union/mall/floor/<?= $v['aiwifi_mall_pk_mall'];?>/<?= $v['pk_floor'];?>/" class="G_btn_a metro_blue"><?= $v['name'];?></a>
								<?php endforeach; ?>
							</div>

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
