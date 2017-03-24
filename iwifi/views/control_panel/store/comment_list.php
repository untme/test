<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    // Delete this navigator.
    $(".delC").click(function(){
    	
    	var comment_id = $(this).attr('rel'),
    	    sureDelC = confirm('你确定要删除这个评论吗?');
    	
    	if (sureDelC) {
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>control_panel/store/del_comment/",
	        	data: {comment_id: comment_id},
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
    
    // View this comment
    $(".view").click(function(){
    	
    	var comment_id = $(this).next().attr('rel');
    	
    	$.facebox({ ajax: "<?= $base; ?>control_panel/store/view_comment/"+comment_id });
    	
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
                
                <table>

					<thead>
						<tr>
						   <th style="width: 25px;"><input class="check-all" type="checkbox" /></th>
						   <th style="width: 50px;">评论ID</th>
						   <th style="width: 200px;">评论内容(简短)</th>
						   <th style="width: 100px;">操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
									<a class="button" href="<?= $base; ?>control_panel/store/index/">返回商家列表</a>
								</div>
								<div class="pagination">
									<?= $this->pagination->create_links(); ?>
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<? foreach($comments as $rows): ?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td><?= $rows['comment_id']; ?></td>
							<td><div style="float: left;overflow: hidden;width: 200px;height: 16px"><?= $rows['content']; ?></div></td>
							<td class="operate">
                                <a href="javascript:void(0);" class="view" title="查看评论详细内容">查看</a>   
                                <a href="javascript:void(0);" rel="<?= $rows['comment_id']; ?>" class="delC" title="删除评论">删除</a>    
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