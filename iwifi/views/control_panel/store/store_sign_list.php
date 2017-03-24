<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    // Delete this navigator.
    $(".delSign").click(function(){
    	
    	var sign_id = $(this).attr('rel'),
    	    sureDelS = confirm('你确定要删除这个商家展示图片吗?');
    	
    	if (sureDelS) {
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>control_panel/store/delete_sign/",
	        	data: {sign_id: sign_id},
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
						   <th style="width: 50px;">展示ID</th>
						   <th style="width: 200px;">展示简介</th>
						   <th style="width: 100px;">操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
									<a class="button" href="<?= $base; ?>control_panel/store/new_sign/<?= $store_id; ?>">添加商家展示</a>
									<a class="button" href="<?= $base; ?>control_panel/store/index/">返回商家列表</a>
								</div>
								<div class="pagination">
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<? foreach($sign as $rows): ?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td><?= $rows['sign_id']; ?></td>
							<td><div style="float: left;overflow: hidden;width: 200px;height: 16px"><?= $rows['sign_word']; ?></div></td>
							<td class="operate">
                                <a href="<?= $base; ?>control_panel/store/modify_sign/<?= $store_id; ?>/<?= $rows['sign_id']; ?>" title="修改商家基础信息">修改</a>   
                                <a href="javascript:void(0);" rel="<?= $rows['sign_id']; ?>" class="delSign" title="删除商家">删除</a>    
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