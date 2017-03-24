<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    // Delete this navigator.
    $(".delNav").click(function(){
    	
    	var nav_id = $(this).attr('rel'),
    	    sureDelNav = confirm('你确定要删除这个链接吗?');
    	
    	if (sureDelNav) {
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>control_panel/navtop/delete_nav/",
	        	data: {nav_id: nav_id},
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

                <table>

					<thead>
						<tr>
						   <th style="width: 25px;"><input class="check-all" type="checkbox" /></th>
						   <th style="width: 50px;">链接ID</th>
						   <th style="width: 150px;">链接名称</th>
						   <th style="width: 100px;">链接排序</th>
						   <th style="width: 150px;">是否有图标</th>
						   <th style="width: 150px;">操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
									<a class="button" href="<?= $base; ?>control_panel/navtop/new_nav/">添加新链接</a>
								</div>
								<div class="pagination">
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<? foreach($nav as $rows): ?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td><?= $rows['nav_id']; ?></td>
							<td><a href="<?= $rows['nav_link']; ?>" target="_blank"><?= $rows['nav_title']; ?></a></td>
							<td><?= $rows['nav_sort']; ?></td>
							<td><?= empty($rows['nav_img']) ? '没有图标' : '有图标'; ?></td>
							<td class="operate">
                                <a href="<?= $base; ?>control_panel/navtop/modify_nav/<?= $rows['nav_id']; ?>" title="修改链接属性">修改</a>    
                                <a href="javascript:void(0);" rel="<?= $rows['nav_id']; ?>" class="delNav" title="删除这条链接">删除</a>    
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