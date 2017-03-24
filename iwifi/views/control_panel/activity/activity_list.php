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
	        	url: "<?= $base; ?>control_panel/activity/delete_activity/"+store_id,
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
						   <th style="width: 10%; text-align:center; ">系统ID</th>
						   <th style="width: 10%; text-align:center; ">排序</th>
						   <th style="width: 15%;">活动标题</th>
						   <th style="width: 15%;text-align:center;">归属商家</th>
                           <th style="width: 10%;text-align:center;">活动状态</th>
                           <th style="width: 20%;text-align:center;">发布日期</th>
						   <th style="width: 20%;text-align:center;">功能操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
									<a class="button" href="<?= $base; ?>control_panel/activity/addForm/">添加活动信息</a>
								</div>
		  						<div class="pagination">
                                    <?= $this->pagination->create_links(); ?>
		                        </div><!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<?php foreach($activity as $row){?>
                        <tr>
                        	<td class="txt_center"><?= $row['pk_activity']; ?></td>
							<td class="txt_center">1</td>
							<td><?= $row['name']; ?></td>
							<td class="txt_center"><?= $mall[$row['aiwifi_mall_pk_mall']]['name'];?></td>
							<!--状态   正常，关闭，置顶排序，活动页置顶，品牌页置顶-->
							<td class="txt_center"><?= getActivityState($row['state']); ?></td>
							<td class="txt_center"><?= date("Y-m-d", $row['pubtime']);?></td>
							<td class="operate txt_center">
                            <a href="<?= $base; ?>control_panel/activity/editForm/<?= $row['pk_activity']; ?>" title="修改活动基础信息">修改</a>
                            <a href="javascript:void(0);" rel="<?= $row['pk_activity']; ?>" class="delStore" title="删除活动">删除</a> 
                            <!--<a href="<?= $base; ?>control_panel/activity/switch/<?= $rows['store_id']; ?>" title="关闭/开启展示" class="red">关闭/开启展示</a>--> 
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
