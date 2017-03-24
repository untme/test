<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    // Delete this navigator.
    $(".delStore").click(function(){
    	
    	var store_id = $(this).attr('rel'),
    	    sureDelS = confirm('你确定要删除这个商家吗?');
    	
    	if (sureDelS) {
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>control_panel/store/delete_store/",
	        	data: {store_id: store_id},
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
						   <th style="width: 50px;">商家ID</th>
						   <th style="width: 150px;">商家名称</th>
						   <th style="width: 100px;">商家区县</th>
                           <th style="width: 100px;">状态</th>
						   <th style="width: 150px;">操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
									<a class="button" href="<?= $base; ?>control_panel/store/new_store_show/">添加商家</a>
								</div>
								<div class="pagination">
                <?= $this->pagination->create_links(); ?>
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<?php foreach($stores as $rows){?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td><?= $rows['store_id']; ?></td>
							<td><?= $rows['store_name']; ?></td>
							<td><?= $rows['store_location']; ?></td>
                            <td><?php echo $rows['status']?"正常":"失效"; ?></td>
							<td class="operate">
                            <a href="<?= $base; ?>control_panel/store/store_modify/<?= $rows['store_id']; ?>" title="修改商家基础信息">修改</a>
                            <a href="<?= $base; ?>control_panel/store/comment_list/<?= $rows['store_id']; ?>" title="管理该商家的用户评论留言">评论</a>
                            <a href="<?= $base; ?>control_panel/store/shop_sign/<?= $rows['store_id']; ?>" title="管理商家招牌图片">招牌管理</a>
                            <a href="javascript:void(0);" rel="<?= $rows['store_id']; ?>" class="delStore" title="删除商家">删除</a>    
							</td>
						</tr>
                        <?php }?>
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
