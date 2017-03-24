<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){

    //

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
						   <th style="width: 50px;">页面对应ID</th>
						   <th style="width: 100px;">广告页面</th>
						   <th style="width: 150px;">广告图片宽度</th>
						   <th style="width: 150px;">广告图片高度</th>
						   <th style="width: 150px;">语言分类</th>
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="pagination">
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<? foreach($ad_pages as $rows): ?>
                        <tr>
							<td><input type="checkbox" /></td>
							<td id="user_id"><?= $rows['page_type_id']; ?></td>
							<td><?= $rows['page_name']; ?></td>
							<td><?= empty($rows['page_ad_size_width']) ? 'N/a' : $rows['page_ad_size_width']; ?></td>
							<td><?= empty($rows['page_ad_size_height']) ? 'N/a' : $rows['page_ad_size_height']; ?></td>
							<td class="operate">
                                <?php foreach ($lang as $lang_info): ?>
                                <a href="<?= $base; ?>control_panel/advertisement/page_lang/<?= $rows['page_type_id']; ?>/<?= $lang_info['lang_type_id']; ?>" title="<?= $lang_info['lang']; ?>"><?= $lang_info['lang_name']; ?></a>    
                                <?php endforeach ?>
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