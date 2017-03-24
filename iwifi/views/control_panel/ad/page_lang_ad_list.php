<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

	// Delete this advertisement
	$(".deleteAd").click(function(){
		
		var ad_id = $(this).attr('rel'),
		    sureDel = confirm('你确定要删除这个广告吗?');
		
		if (sureDel) {
			
			$.ajax({
	        	type: "POST",
	        	url: "<?= $base; ?>control_panel/advertisement/del_ad/",
	        	data: {ad_id: ad_id},
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
						   <th style="width: 80px;">广告ID</th>
						   <th style="width: 120px;">广告所在页面</th>
						   <th style="width: 150px;">广告所属语言</th>
						   <th style="width: 150px;">广告位置</th>
						   <th style="width: 100px;">广告类型</th>
						   <th>操作</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
									<a class="button" href="<?= $base; ?>control_panel/advertisement/new_advertisement/<?= $ad_page['page_type_id']; ?>/<?= $lang['lang_type_id']; ?>">添加新广告</a>
									<a class="button" href="<?= $base; ?>control_panel/advertisement/index/">返回广告页面列表</a>
								</div>
								<div class="pagination">
                                    <?= $this->pagination->create_links(); ?>
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<? foreach($ad_list as $rows): ?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td id="user_id"><?= $rows['ad_id']; ?></td>
							<td><?= $ad_page['page_name']; ?></td>
							<td><?= $lang['lang_name']; ?></td>
							<td><?= empty($rows['ad_position_desc']) ? 'N/a' : $rows['ad_position_desc']; ?></td>
                            <td><?= empty($rows['ad_code']) ? '无验证码' : '有验证码'; ?></td>
							<td class="operate">
                                <a href="<?= $base; ?>control_panel/advertisement/modify_ad/<?= $ad_page['page_type_id']; ?>/<?= $lang['lang_type_id']; ?>/<?= $rows['ad_id']; ?>" class="modify" title="修改广告信息">修改</a>
                                <a href="javascript:void(0);" class="deleteAd" rel="<?= $rows['ad_id']; ?>" title="删除该广告">删除</a>
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