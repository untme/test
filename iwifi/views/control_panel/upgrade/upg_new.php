<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    //表达提交事件
    $('.submitNewNav').click(function(){

        var case_id = $('#case_id').val();
        var ad_num = $('#ad_num').val();

        if (case_id == '' || ad_num == '' || ad_num > 8) {
        	alert("请确定方案！");
        	return false;
        }
        $("#checkfrom").submit();
    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	window.location.href="<?= $base; ?>control_panel/upgrade/index/";
    });
    
});
</script>
</head>

<body>
<div id="frame_content">
<!-- Page Head -->
    <!-- smallpanel [begin] -->
    <?php $this->load->view('control_panel/navigation'); ?>
    <div class="clear"></div> <!-- End .clear -->

	<div class="content-box"><!-- Start Content Box -->

		<div class="content-box-header">

			<h3><?= $nav_title; ?></h3>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tablefield">

				<form id="checkfrom" method="post" target="_self" action="<?= $base; ?>control_panel/upgrade/new_upg/" enctype="multipart/form-data">
                
                <input type="hidden" name="action" value="action" />
                
                <p>
					<span>方案名称 : </span>
                    <select id="case_id" name="case_id" ">
                        <?php foreach($case as $v){?>
                            <option value="<?php echo $v['id'];?>"><?php echo $v['title'];?></option>
                        <?php }?>
                    </select>
                    <br /><small>将要升级宽带的方案方案标题名称.</small>
				</p>
				
				<p>
					<span>点击次数 : </span>
					<input class="text-input small-input" type="text" id="ad_num" name="ad_num" />
                    <br /><small>需要点击页面上广告的个数(最多8个).</small>
				</p>
				
                <p>
					<input class="button submitNewNav" type="button" value="添 加" />
					<input class="button backtouserlist" type="button" value="返回方案列表" />
				</p>

                </form>

				<div class="clear"></div><!-- End .clear -->
				<div class="user_list2" id="show_result"></div>
                <div class="clear"></div><!-- End .clear -->

			</div> <!-- End #tab2 -->

		</div> <!-- End .content-box-content -->

	</div> <!-- End .content-box -->


	<div class="clear"></div>
    <?php $this->load->view("control_panel/doing"); ?>

	<?php $this->load->view('control_panel/footer'); ?>
    <!-- End #footer -->
</div>
</body>
</html>