<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    // Delete this navigator.
    $(".delAnswer").click(function(){
    	
    	var aa_id = $(this).attr('rel'),
    	    sureDelA = confirm('你确定要删除这个问题吗?');
    	
    	if (sureDelA) {
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>control_panel/ask/delete_answer/",
	        	data: {aa_id: aa_id},
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
    
    // Add a new answer
    $(".addNewAnswer").click(function(){
    	
    	var aq_id = <?= $aq_id; ?>;
    	
    	$.facebox({ajax:"<?= $base; ?>control_panel/ask/new_answer/"+aq_id});
    	
    });
    
    // Modify this answer
    $(".modifyAnswer").click(function(){
    	
    	var aq_id = <?= $aq_id; ?>;
    	var aa_id = $(this).attr("rel");
    	
    	$.facebox({ajax:"<?= $base; ?>control_panel/ask/modify_answer/"+aq_id+"/"+aa_id});
    	
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
				<div><strong>问题： <?php echo $question['aq_title'];?></strong></div>
                <table>
					<thead>
						<tr>
						   <th style="width: 25px;"><input class="check-all" type="checkbox" /></th>
						   <th style="width: 50px;">答案ID</th>
						   <th style="width: 150px;">答案名称</th>
						   <th style="width: 150px;">操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
									<a class="button addNewAnswer" href="javascript:void(0);">添加一个答案</a>
									<a class="button" href="javascript: history.back();">返回上一步</a>
								</div>
								<div class="pagination">
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<? foreach($answer as $rows): ?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td><?= $rows['aa_id']; ?></td>
							<td><?= $rows['aa_title']; ?></td>
							<td class="operate">
                                <a href="javascript:void(0);" class="modifyAnswer" rel="<?= $rows['aa_id']; ?>" title="修改这个答案">修改</a>    
                                <a href="javascript:void(0);" rel="<?= $rows['aa_id']; ?>" class="delAnswer" title="删除这个答案">删除</a>    
							</td>
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