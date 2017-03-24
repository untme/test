<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){
	
    //检查用户表是否存在这个成员,并且将成员信息发布过来确认.
    $('.submitNewQuestion').click(function(){
    	
        var aq_title = $('#aq_title').val();
        
        if (aq_title == '') {
        	
        	$.facebox({ alert: "请填写问题!"});
        	return false;
        	
        }
        
        $("#checkfrom").submit();

    });
    
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	
    	window.location.href="<?= $base; ?>control_panel/ask/index/<?= $lang['lang_type_id']; ?>";
    	
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

	<?php $this->load->view('control_panel/icon'); ?>

	<div class="clear"></div> <!-- End .clear -->

    <!-- Start Notifications -->

    <?php $this->load->view('control_panel/notice'); ?>

    <!-- End Notifications -->

	<div class="content-box"><!-- Start Content Box -->

		<div class="content-box-header">

			<h3><?= $nav_title; ?></h3>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tablefield">

				<form id="checkfrom" method="post" target="_self" action="<?= $base; ?>control_panel/ask/add_new_question/<?= $lang['lang_type_id']; ?>">
                
                <input type="hidden" name="action" value="action" />
                
                <p style="display:none;">
					<span>问题语言 : </span>
					<select name="aq_lang">
						<?php foreach($langs as $l): ?>
						<?php if($l['lang_type_id'] == 0): ?>
						<?php else: ?>
							<?php if($l['lang_type_id'] == $lang['lang_type_id']): ?>
						<option value="<?= $l['lang_type_id']; ?>" selected="selected"><?= $l['lang_name']; ?></option>
							<?php else: ?>
						<option value="<?= $l['lang_type_id']; ?>"><?= $l['lang_name']; ?></option>
							<?php endif; ?>
						<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</p>
                
                <p>
					<span>问题名称 : </span>
					<input class="text-input small-input" type="text" id="aq_title" name="aq_title" />
                    <br /><small>问题的名称.不同语言使用对应的语言填写.</small>
				</p>
				
				<p>
					<span>问题类型 : </span>
					<select name="aq_type">
						<option value="1">单选</option>
						<option value="2">多选</option>
					</select>
				</p>
				<p>
					<span>问题级别 : </span>
                    <input name="aq_level" type="text" value="0" size="10" maxlength="10"/>
                    ( 如果填写"0"表示基础问题; 如果是扩展问题,则填写所属基础问题的指定答案ID )
                </p>
                <p>
					<span>顺序排号 : </span>
                    <input name="sequence" type="text" value="9999" size="10" maxlength="10"/>
					( 按照排列序号从小到大的顺序来显示 )
                </p>
              	<p>
					<input class="button submitNewQuestion" type="button" value="添 加" />
					<input class="button backtouserlist" type="button" value="返回问题列表" />
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