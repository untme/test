<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title; ?></title>
<link rel="stylesheet" href="<?= $source; ?>style/control_panel/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?= $source; ?>style/control_panel/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?= $source; ?>style/control_panel/invalid.css" type="text/css" media="screen" />
<script type="text/javascript" >var base = "<?= $base?>"; var element_path = "<?= $source; ?>";</script>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<script type="text/javascript" src="<?= $source; ?>scripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?= $source; ?>scripts/facebox.js"></script>
<script type="text/javascript" src="<?= $source; ?>scripts/configuration.js"></script>
</head>

<body>
<div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->
    <div id="sidebar">
        <div id="sidebar-wrapper" class="sidebarWrapper"> <!-- Sidebar with logo and menu -->
        	<!-- Logo (221px wide) -->
        	<a href="<?= $base; ?>control_panel/index/"><img id="logo" src="<?= $source; ?>images/control_panel/logo.png" alt="Aiwifi" /></a>
        	<!-- Sidebar Profile links -->
        	<div id="profile-links">
        		<a href="<?= $base; ?>control_panel/index/home/" target="content" title="Go to Admin Control panel Home page!">后台首页</a> | <a href="<?= $base; ?>" target="content" title="View the Site Home Page">查看网站</a> | <a href="<?= $base; ?>control_panel/index/logout/" title="Sign Out">退出登陆</a>
        	</div>
        	<ul id="main-nav">  <!-- Accordion Menu -->
        		<li>
        			<a href="javascript:void(0);" id="useful" class="nav-top-item">后台管理模块</a>
        		</li>
        	</ul> <!-- End #main-nav -->

            <ul class="sonnav"  id="useful">
                <li><a href="<?= $base; ?>control_panel/index/home/" class="current" target="content">后台首页</a></li>
				<?php $adminType = $this->session->userdata('admin_type'); ?>
				<li><a href="<?= $base; ?>control_panel/user/index/" target="content">会员管理</a></li>
				<li><a href="<?= $base; ?>control_panel/ask/index/1/" target="content">问讯管理</a></li>
				<li><a href="<?= $base; ?>control_panel/navigator/index/" target="content">导航管理</a></li>
				<li><a href="<?= $base; ?>control_panel/advertisement/index/" target="content">广告管理</a></li>
				<li><a href="<?= $base; ?>control_panel/advertisement/loginPic_index/" target="content">验证图片</a></li>
                <li><a href="<?= $base; ?>control_panel/store/index/" target="content">商家管理</a></li>
                <li><a href="<?= $base; ?>control_panel/store/map/" target="content">商家地图</a></li>
                <li><a href="<?= $base; ?>control_panel/upgrade/index/" target="content">升级方案</a></li>
                <!--<li><a href="<?= $base; ?>control_panel/syslog/index/" target="content">行为日志</a></li>-->
            </ul>
	    <?php if(_auth($adminType, 'super')):?>	
            <div class="hrWp"><span class="hrLine"></span></div>
	    <ul class="sonnav"  id="useful">
		<li><a href="<?= $base; ?>control_panel/admin/index/" target="content">管理员管理</a></li>
            </ul>
            <?php endif;?>
	    <div class="hrWp"><span class="hrLine"></span></div>
            <ul class="sonnav"  id="useful">
	    	<?php if(_auth($adminType, 'super') || _auth($adminType, 'shop')):?>	
                <li><a href="<?= $base; ?>control_panel/mall/index/" target="content">商家信息</a></li>
                <li><a href="<?= $base; ?>control_panel/activity/index/" target="content">商家活动</a></li>
                <li><a href="<?= $base; ?>control_panel/brand/index/" target="content">商家品牌</a></li>
                <li><a href="<?= $base; ?>control_panel/floor/index/" target="content">楼层提示</a></li>
            	<?php endif;?>
                <li><a href="<?= $base; ?>control_panel/app/index/" target="content">APP下载</a></li>
		<!--<li><a href="<?= $base; ?>control_panel/navtop/index" target="content">导航顶部广告</a></li>-->
            </ul>
	    <?php if(_auth($adminType, 'super') || _auth($adminType, 'analyze')):?>	
            <div class="hrWp"><span class="hrLine"></span></div>
            <ul class="sonnav"  id="useful">
                <li><a href="<?= $base; ?>control_panel/count/ulog/0/0/" target="content">登录统计</a></li>
                <li><a href="<?= $base; ?>control_panel/count/ureg/0/0/" target="content">注册统计</a></li>
            </ul>
            <?php endif;?>
        </div>
    </div> <!-- End #sidebar -->

	<div id="main-content"> <!-- Main Content Section with everything -->
        <iframe src="/control_panel/index/home/" id="content" width="100%" name="content"></iframe>
	</div> <!-- End #main-content -->

</div>
<script type="text/javascript">
$(document).ready(function(){
    //设置内容iframe的高度
    var conHeight = function() {
        $('#content').height($(window).height() - 10 );
        $('#sidebar').height($(window).height());
    };
    conHeight();
    $(window).resize(function() {
        conHeight();
    });
    //关闭主导航下拉当点击页面的其他位置时
    $('body').click(function() {
        $('.calist').hide();
    });

    //栏目选择处理
    var statuid = $('.nav-top-item').attr('id');
    $('.sonnav#'+statuid).fadeIn();
    $('.calist li a').click(function(){
        var listid = $(this).attr('id');
        var listname = $(this).html();

        $('.nav-top-item').html(listname).attr('id', listid);
        var statuid = $('.nav-top-item').attr('id');
        $('.sonnav#'+statuid).fadeIn().siblings('ul').not('#main-nav').hide();
    });

    //点击链接制作出当前选项
    $('.sonnav li a').click(function(){
        $(this).parent('li').siblings('li').children('a').removeClass('current');
        $(this).parent('li').parent('.sonnav').siblings('ul').children('li').children('a').removeClass('current');
        $(this).addClass('current');
    });
});
</script>
</body>
</html>
