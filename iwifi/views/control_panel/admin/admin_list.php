<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    // Show add new admin div
    $('#addNewAdmin').click(function(){

        $.facebox({ ajax:"<?= $base; ?>control_panel/admin/new_admin_form/" });
        
    });
    
    // Show edit admin box
    $(".editAdmin").click(function(){
    	
    	var admin_id = $(this).parents("tr").attr('id');
    	
    	$.facebox({ ajax:"<?= $base; ?>control_panel/admin/edit_admin_all/"+admin_id });
    	
    });
    
    // Delete this admin.
    $(".deleteAdmin").click(function(){
    	
    	var sureDel = confirm("你确定要删除这个管理员吗?");
    	
    	if (sureDel) {
    		
    		var admin_id = $(this).parents("tr").attr('id');
    		
    		$.post('<?= $base; ?>control_panel/admin/del_admin', {admin_id: admin_id}, function(data) {
			  
				if (data == 1) {
					
					window.location.reload();
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
						   <th style="width: 130px;">管理员账号</th>
						   <th style="width: 150px;">邮箱地址</th>
						   <th style="width: 190px;">管理员类型</th>
						   <th>操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
<!--									<select name="dropdown">
										<option value="option1">选择执行方案</option>
										<option value="option2">批量删除</option>
										<option value="option3">批量邮件</option>
                                        <option value="option3">批量消息</option>
									</select>-->
									<a class="button" id="addNewAdmin" href="javascript:void(0);">添加管理员</a>
								</div>

								<div class="pagination">
                                    
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<? foreach($admins as $rows): ?>
                        <tr id="<?= $rows['admin_id']; ?>">
							<td><input type="checkbox" /></td>
							<td id="admin_id"><?= $rows['admin_name']; ?></td>
							<td><?= $rows['admin_email']; ?></td>
							<?php if(_auth($rows['admin_type'], 'super')): ?>
							<td>超级管理员</td>
							<?php elseif(_auth($rows['admin_type'], 'analyze')): ?>
							<td>数据管理员</td>
							<?php elseif(_auth($rows['admin_type'], 'shop')): ?>
							<td>商铺管理员</td>
							<?php endif; ?>
							<td class="operate">
                                <a href="javascript:void(0);" class="editAdmin" title="修改管理员的账户名称,邮箱,角色和密码">修改管理员</a>
                                <?php if($rows['admin_id'] == 1): ?>
                                <?php else: ?>
                                <a href="javascript:void(0);" class="deleteAdmin" title="删除这个管理员">删除管理员</a>
                                <?php endif; ?>
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
