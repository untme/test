<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?= $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>

<script type="text/javascript" src="<?= $source; ?>scripts/jquery.superfish.min.js"></script>
<script type="text/javascript" src="<?= $source; ?>scripts/jquery.supersubs.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
    // Administry object setup

    if (!Administry) var Administry = {}

    // progress() - animate a progress bar "el" to the value "val"

    Administry.progress = function (el, val, max) {

        var duration = 400;

        var span = $(el).find("span");

        var b = $(el).find("b");

        var w = Math.round((val / max) * 100);

        $(b).fadeOut('fast');

        $(span).animate({

            width: w + '%'

        }, duration, function () {

            $(el).attr("value", val);

            $(b).text(w + '%').fadeIn('fast');

        });

    }



    /* progress bar animations - setting initial values */

	<?php foreach ($answer as $a): ?>
	Administry.progress("#progress<?= $a['aa_id']; ?>", <?= $a['aa_count']; ?>, <?= $total_voted_number; ?>);
	<?php endforeach; ?>

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

	            <p><span>问题 : <b><?= $question['aq_title']; ?></b></span></p>
	
	            <p><span>目前为止共有 : <?= $total_voted_number; ?> 人投票</span></p>
	
	            <p></p>
	            <table class="no-style full">
					<tbody>
						
						<?php foreach ($answer as $rows): ?>
						<tr><td colspan="3"><b><?= $rows['aa_title']; ?></b></td></tr>
						<tr>
							<td class="ta-right"> 投票次数: <?= $rows['aa_count']; ?></td>
							<td><div id="progress<?= $rows['aa_id']; ?>" class="progress progress-green"><span><b></b></span></div></td>
						</tr>
						<?php endforeach; ?>
						
					</tbody>
				</table>
	            <p></p>
	            
	            <p>
					<a class="button" href="javascript: history.back();">返回上一步</a>
				</p>
	
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