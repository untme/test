<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title>活动详情页</title>
    <link href="<?= $source ;?>style/css/frame.css" type="text/css" rel="stylesheet">
    <link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
    <script src="<?= $source ;?>js/jquery.js"></script>
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
                        <a href="javascript:void(0);return false;"><img src="<?= array_shift($activity['focus']) ;?>" class="pic">
                        </a>
                    </div>
                </div>
            </div>

           

           <!-- <div class="G_modwrap">
                <div class="G_pic_col_2 clearfix">
                    <div class="pic_con">
                    </div>
                </div>
            </div> -->


             <div class="G_modwrap">
                <div class="G_text_a S_line1">
				       <!-- <p><?= $activity['name'];?></p>-->
					
					<?= $activity['description'];?>
					<!--
                    <p>3月5日到3月11日，精选春日商品享受<em class="G_tcol_orange G_fb G_f22">7.5</em>折优惠，详询服务员。</p>
					-->
				</div>
            </div>

 

        </div>


    </div>

    <div class="G_footer">
                    <p class="text G_fb G_tcol_red">客服热线：4001681799</p>
                    <p class="text">服务提供商：北京立时世通科技有限公司</p>
            </div>
</body>


</html>
