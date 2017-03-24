<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title><?php if($mall['fbname']){ echo $mall['fbname']; }else{ echo '免费班车'; } ?></title>
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
                <div class="G_tabtext">
                    <div class="tabs clearfix">
                        <?php if($mall['description']){ ?>
                        <a href="/union/mall/info/<?= $pk_mall;?>/0" class="tab"><?php if($mall['dname']){ echo $mall['dname']; }else{ echo '商家信息'; } ?></a>
                        <?php } ?>
                        <?php if($mall['citybus']){ ?>
                        <a href="/union/mall/info/<?= $pk_mall;?>/1" class="tab"><?php if($mall['cbname']){ echo $mall['cbname']; }else{ echo '公交线路'; } ?></a>
                        <?php } ?>
                        <?php if($mall['freebus']){ ?>
                        <a href="/union/mall/info/<?= $pk_mall;?>/2" class="tab current"><?php if($mall['fbname']){ echo $mall['fbname']; }else{ echo '免费班车'; } ?></a>
                        <?php } ?>
                        <?php if($mall['park']){ ?>
                        <a href="/union/mall/info/<?= $pk_mall;?>/3" class="tab"><?php if($mall['pkname']){ echo $mall['pkname']; }else{ echo '地下车库'; } ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="G_modwrap">
                <div class="G_pictext_a">
                  <div class="iCross S_line1"><?= $content ;?></div>
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
