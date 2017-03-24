<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no" />
    <title><?= $this->lang->line('nav_title'); ?></title>
    <link href="<?= $source; ?>style/css/frame.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
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
        <div class="G_modwrap">
            <div class="G_bar line_metro_blue">
                <!--<form method="post" target="_blank" action="/api/service?_t=1370097498"></form>-->
                <input type="hidden" id="id" value="<?=$id?>" />
                <input type="hidden" id="o" value="<?=$o?>" />
                <span class="bar_title" value=""><?=$title?></span>
                <a href="javascript:void(0);" id="submit" class="bar_btn metro_blue metro_gray">开通</a>
            </div>
            <script>
				setTimeout(function(){
					$('#submit').removeClass('metro_gray');
				},4500)
                $('#submit').on('click',function(){
					if(!$(this).hasClass('metro_gray')){
						var id = $('#id').val();
						var o = $('#o').val();
						var name = $('.bar_title').text();
						$.ajax({
							type:"POST",
							url:"/api/service",
							data:"o="+o,
							success:function(msg){
								var data = eval('(' + msg + ')');
								console.log(data.text);
								if(data.value){
									alert(data.text);
									location.href="/";
								}else{
									alert(data.text);
								}
							}
						});
					}else{
						alert("不要着急，先仔细观察下页面，等等就有奇迹出现的！");	
					}
                });
            </script>
        </div>
        <div class="G_modwrap">
            <div class="G_ad_a S_line1">
                <div class="adbox">
                    <script type="text/javascript">
                        /*20:3 创建于 2015-03-06*/
                        var cpro_id = "u1974392";
                    </script>
                    <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                </div>
            </div>
        </div>
        <div class="G_modwrap">
            <div class="G_ad_a S_line1">
                <div class="adbox">
                    <script type="text/javascript">
                        /*20:3 创建于 2015-03-06*/
                        var cpro_id = "u1974403";
                    </script>
                    <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                </div>
            </div>
        </div>
        <div class="G_modwrap">
            <div class="G_ad_a S_line1">
                <div class="adbox">
                    <script type="text/javascript">
                        /*20:3 创建于 2015-03-06*/
                        var cpro_id = "u1974407";
                    </script>
                    <script src="http://cpro.baidustatic.com/cpro/ui/cm.js" type="text/javascript"></script>
                </div>
            </div>
        </div>
    </div>
    <?= $this->load->view('foot'); ?>
</div>
</body>
</html>
