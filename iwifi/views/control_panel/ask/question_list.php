<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    // Delete this navigator.
    $(".delQ").click(function(){
    	
    	var aq_id = $(this).attr('rel'),
    	    sureDelQ = confirm('你确定要删除这个问题吗?');
    	
    	if (sureDelQ) {
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>control_panel/ask/delete_question/",
	        	data: {aq_id: aq_id},
	        	beforeSend: function(XMLHttpRequest){
	        		$.facebox({ div: '#doing' });
	        	},
	        	success: function(data){
	        		$.facebox({ alert: data });
	        		window.location.reload();
	        	},
	        	error: function(){
	        		$.facebox({ alert: '对不起! 请求出现错误,请重新尝试!' });
	        	}
	        });
    	}
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

                <div class="clear"></div><!-- End .clear -->
                
                <div class="bulk-actions align-left" style="padding-bottom: 15px;margin-left: 5px;">
					<?php foreach($langs as $langinfo): ?>
					<?php if($langinfo['lang_type_id'] == 0): ?>
					<?php else: ?>
						<?php if ($lang['lang_type_id'] == $langinfo['lang_type_id']): ?>
					<a class="button" href="<?= $base; ?>control_panel/ask/index/<?= $langinfo['lang_type_id']; ?>/"><b>[<?= $langinfo['lang_name']; ?>]</b></a>
						<?php else: ?>
					<a class="button" href="<?= $base; ?>control_panel/ask/index/<?= $langinfo['lang_type_id']; ?>/"><?= $langinfo['lang_name']; ?></a>
						<?php endif; ?>
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
				
				<div class="clear"></div><!-- End .clear -->

                <table>

					<thead>
						<tr>
						   <th style="width: 25px;"><input class="check-all" type="checkbox" /></th>
						   <th style="width: 50px;">问题ID</th>
						   <th>问题名称</th>
                           <th>顺序</th>
						   <!--<th>问题语言</th>-->
						   <th>类型</th>
						   <th>级别 </th>
						   <th>操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="8">
								<div class="bulk-actions align-left">
									<a class="button" href="<?= $base; ?>control_panel/ask/add_new_question/<?= $lang['lang_type_id']; ?>">添加新问题</a>								</div>
                                <div class="pagination">
                                    <?= $this->pagination->create_links(); ?>
								</div><!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<? foreach($questions as $rows): ?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td><?= $rows['aq_id']; ?></td>
							<td><?= $rows['aq_title']; ?></td>
                            <td align="center"><?= $rows['sequence']; ?></td>
							<!--<td align="center"><?= $lang['lang_name']; ?></td>-->
							<td align="center"><?= $rows['aq_type'] == 1 ? '单选' : '多选'; ?></td>
							<td align="center"><?php echo (int)$rows['aq_level']?'扩展(关联答案ID：'.(int)$rows['aq_level'].')':'基础';?></td>
							<td align="center" class="operate">
                                <a href="<?= $base; ?>control_panel/ask/answer/<?= $rows['aq_id']; ?>" title="打开该问题下面的答案列表">答案(<?php echo $rows['answerNum'];?>)</a>    
                                <!--
                                <a href="<?= $base; ?>control_panel/ask/statis/<?= $rows['aq_id']; ?>" title="修改链接属性">统计</a>
                                -->
                                <a href="<?= $base; ?>control_panel/ask/modify_question/<?= $rows['aq_lang']; ?>/<?= $rows['aq_id']; ?>" title="修改这个问题">[修改]</a>
                                <a href="javascript:void(0);" rel="<?= $rows['aq_id']; ?>" class="delQ" title="删除这个问题">[删除]</a>							</td>
						</tr>
                        <? endforeach; ?>
					</tbody>
				</table>
				
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