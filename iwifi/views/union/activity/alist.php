<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title>最新活动</title>
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
                        <a href="/union/activity/index/<?= $actop['aiwifi_mall_pk_mall'];?>/<?= $actop['pk_activity']?>"><img src="<?= $actop['focus'];?>" class="pic">
                        </a>
                    </div>
                </div>
            </div>

            <div class="G_modwrap">

                <div class="G_pt_a S_line1">
                    <h1 class="modtitle">最新活动<a href="#1" class="morelink">more &raquo;</a></h1>
                    <div class="m_wrap">

                        <div class="ptlist_full">
                            <ul class="ul_list clearfix">
								<?php foreach($aclist as $ac): ?>
									<li class="li_item">
										<div class="picbox">
											<a href="/union/activity/index/<?= $ac['aiwifi_mall_pk_mall'];?>/<?= $ac['pk_activity']?>"><img src="<?= array_shift(json_decode($ac['focus'], true)); ?>" class="pic">
											<!--<?= $ac['name'];?>-->
											</a>
										</div>
									</li>
								<?php endforeach; ?>
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
