<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    //查看会员详细统计信息
    $('.operate #info').live('click', function(){
        var user_id = $(this).parent('.operate').siblings('#user_id').html();

        $.facebox({ajax:"<?= $base; ?>control_panel/user/user_functions/info/"+user_id});
    });

    //修改会员详细信息
    $('.operate #config').live('click', function(){
        var user_id = $(this).parent('.operate').siblings('#user_id').html();

        $.facebox({ajax:"<?= $base; ?>control_panel/user/user_functions/config/"+user_id});
    });

    //重置用户密码
    $('#pw').live('click', function(){
        var user_id = $(this).parent('.operate').siblings('#user_id').html();

        $.facebox({ajax:"<?= $base; ?>control_panel/user/user_functions/passwd/"+user_id});
    });
    
    //重置用户密码
    $('#deleteUser').live('click', function(){
    	
        var uid = $(this).parent('.operate').siblings('#user_id').html();
		var delsure = confirm('你确定要删除这个会员吗?');
		
		if (delsure) {
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>control_panel/user/user_functions/deleteUser/",
	        	data: "uid=" + uid,
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
	<div class="content-box"><!-- Start Content Box -->
		<div class="content-box-header">

			<h3><?= $nav_title; ?></h3>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tablefield">
				<div class="bulk-actions align-left">
					<a class="button" href="<?= $base; ?>control_panel/user/search/search_user"> 搜索会员 </a>
                    <a class="button" href="<?= $base; ?>control_panel/user/user_add"> 添加会员 </a>
				</div>
                <div class="clear"></div><!-- End .clear -->

                <table>

					<thead>
						<tr>
						   <th style="width: 25px;"><input class="check-all" type="checkbox" /></th>
						   <th style="width: 100px;">会员ID</th>
						   <th style="width: 100px;">会员姓名</th>
						   <th style="width: 150px;">电话号码</th>
						   <th style="width: 150px;">邮件地址</th>
						   <th style="width: 100px;">会员类型</th>
						   <th>操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="pagination">
                                    <?= $this->pagination->create_links(); ?>
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<?php foreach($user_list as $rows){?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td id="user_id"><?= $rows['uid']; ?></td>
							<td><?= $rows['realname']; ?></td>
							<td><?= $rows['phone']; ?></td>
							<td><?= $rows['email']; ?></td>
                            <td><?php if(trim($rows['type'])=='手工添加'){echo '手工添加';}else{echo '注册会员';}?></td>
							<td class="operate">
                                <a href="javascript:void(0);" id="info" title="显示会员的详细资料">详细</a>
                                <a href="javascript:void(0);" id="config" title="修改会员详细信息">修改</a>
                                <a href="javascript:void(0);" id="pw" title="重置会员密码">密码</a>
                                <a href="javascript:void(0);" id="deleteUser" title="删除该用户">删除</a>
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