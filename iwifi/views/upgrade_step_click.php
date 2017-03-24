<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title><?= $this->lang->line('nav_title'); ?></title>
    <link href="<?= $source; ?>style/css/frame.css" type="text/css" rel="stylesheet">
    <script src="<?= $source; ?>js/jquery.js"></script>
</head>
<body>
<div class="G_topbar"></div>
<div class="G_frame">
    <div class="G_main">
        <div class="G_head">
            <?= $this->load->view('header'); ?>
            <?= $this->load->view('header_welcome'); ?>
        </div>
        <?php foreach($clickService as $v): ?>
        <div class="G_modwrap">
            <div class="G_bar line_metro_blue">
                <input type="hidden" id="id" value="<?=$v['id']?>"/>
                <span class="bar_title" id="bar_title"><?=$v['title']?></span>
                <a href="javascript:void(0);" id="ad_<?=$v['id']?>" class="bar_btn metro_blue">进入</a>
                <input type="hidden" value="<?=$v['name']?>" id="name"/>
                <input type="hidden" value="<?=$v['ad_num']?>" id="ad_num_<?=$v['id']?>"/>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="G_modwrap">
            <div class="G_bar line_metro_grass">
                <span class="bar_title">APP下载</span>
                <a href="#" id="app_down" class="bar_btn metro_grass">进入</a>
            </div>
            <script>
                $('#ad_37').on('click',function(){
                    var bar_title = $('#bar_title').html();
                    var case_id = $('#id').val();
                    var o = $('#name').val();
                    location.href = '/user/upgrade_after?title='+bar_title+'&id='+case_id+'&o='+o;
                });
                $('#ad_48').on('click',function(){
                    alert('此功能暂未开放，敬请期待！');
                });
                $('#app_down').on('click',function(){
                    alert('此功能暂未开放，敬请期待！');
                });
            </script>
        </div>

        <div class="G_modwrap">
            <div class="G_bar line_metro_orange">
                <span class="bar_title">VIP缴费升级</span>
                <a href="<?= $base;?>user/upgrade" class="bar_btn metro_orange">进入</a>
            </div>
        </div>

        <div class="G_modwrap">
            <div class="G_ad_a S_line1">
                <div class="baidu_ads_top"></div>
                <div class="adbox">
                    <script type="text/javascript">
                        /*20:3 创建于 2015-02-13*/
                        var cpro_id = "u1952694";
                    </script>
                    <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                </div>
            </div>
        </div>

        <div class="G_modwrap">
            <div class="G_ad_a S_line1">
                <div class="baidu_ads_top"></div>
                <div class="adbox">
                    <script type="text/javascript">
                        /*20:3 创建于 2015-02-13*/
                        var cpro_id = "u1952696";
                    </script>
                    <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                </div>
            </div>
        </div>
        <div class="G_modwrap">
            <div class="G_ad_a S_line1">
                <div class="baidu_ads_top"></div>
                <div class="adbox">
                    <script type="text/javascript">
                        /*20:3 创建于 2015-02-13*/
                        var cpro_id = "u1952784";
                    </script>
                    <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->load->view('foot'); ?>
</body>
</html>