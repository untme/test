<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title><?= $this->lang->line('nav_title'); ?></title>
    <link href="<?= $source; ?>style/css/frame.css" type="text/css" rel="stylesheet">
    <link  rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
    <script src="<?= $source; ?>js/jquery.js"></script>
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
    <div class="G_topbar"></div>
    <div class="G_frame">
        <div class="G_main">

            <div class="G_head">
                <?= $this->load->view('header'); ?>
                <div class="ad"><a href="<?= $base; ?>user/upgrade?type=1"><img src="<?= $source; ?>images/pic01.png" class="pic"></a></div>
                <?= $this->load->view('header_welcome'); ?>
            </div>

            <div class="G_modwrap">
                <div class="G_tipbar S_line1">您已成功连接到互联网，当前服务类型为：<?php echo $service['title'];?>
                </div>
            </div>

            <div class="G_modwrap">
                <form target="_blank" action="http://www.baidu.com/baidu">
                    <div class="G_search line_metro_blue clearfix">
                        <input type="hidden" value="baidu" name="tn">
                        <input type="text" name="word" class="ipt_text">
                        <input id="cre" class="search_btn metro_blue" type="submit" value="搜索">
                    </div>
                </form>
            </div>

            <div class="G_modwrap">
                <div class="G_navbox S_line1">
                    <div class="tips">
                        <p class="text"><a href="/store/index/1">立时世通-AiWiFi无线系统欢迎您，更多优惠和惊喜请点击我，有本店折扣哟</a>
                        </p>
                    </div>

                    <div class="nav">
                        <ul class="ul_nav clearfix">
                            <?php foreach ($nav as $one): ?>
                            <li>
                                <a href="<?= $one['nav_link']; ?>" class="link" target="_blank">
                                    <div class="pic_box"><img src="<?= $base.'data/navigator/'.$one['nav_img']; ?>" class="pic"></div>
                                    <div class="title G_autocut"><?= $one['nav_title']; ?></div>
                                </a>
                            </li>
                            <?php endforeach; ?>
                            <?php foreach ($nav_user as $two): ?>
                                <li>
                                    <a href="<?= $two['nav_link']; ?>" class="link" target="_blank">
                                        <div class="pic_box"><img src="<?= $base.'data/navigator/'.$two['nav_img']; ?>" class="pic"></div>
                                        <div class="title G_autocut"><?= $two['nav_title']; ?></div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <li>
                                <a href="javascript:void(0);" id="openBox" class="link">
                                    <div class="pic_box"><img src="<?= $source; ?>images/ab.png" class="pic"></div>
                                    <div class="title G_autocut"><?= $this->lang->line('nav_diy'); ?></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="G_modwrap">
                <div class="G_ad_a S_line1">
                    <div class="adbox">
                        <script type="text/javascript">
                            /*20:3 创建于 2015-02-13*/
                            var cpro_id = "u1952671";
                        </script>
                        <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                    </div>
                </div>
            </div>
            <div class="G_modwrap">
                <div class="G_ad_a S_line1">
                    <div class="adbox">
                        <script type="text/javascript">
                            /*20:3 创建于 2015-02-13*/
                            var cpro_id = "u1952687";
                        </script>
                        <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                    </div>
                </div>
            </div>
            <div class="G_modwrap">
                <div class="G_ad_a S_line1">
                    <div class="adbox">
                        <script type="text/javascript">
                            /*20:3 创建于 2015-02-13*/
                            var cpro_id = "u1952787";
                        </script>
                        <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                    </div>
                </div>
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
    </div>
    <?= $this->load->view('foot'); ?>
</body>

</html>
