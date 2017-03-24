<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?= $source; ?>style/style.css"/>
<script type="text/javascript" src="<?= $source; ?>scripts/common.js"></script>
<title><?= $this->lang->line('upgrade_two_title'); ?></title>
</head>
<body>
    <div class="wrapper_top"></div>
    <div class="wrapper">
        <div class="main">
            <?= $this->load->view('head'); ?>
            <?= $this->load->view('_welcome'); ?>
            <div class="main_center">
               <div class="upgrade_title"><?= $this->lang->line('upgrade_two_welcome'); ?></div>
               <div class="upgrade_contant">
					<?= $this->lang->line('upgrade_two_paymentsNote'); ?>
               </div>
            </div>
            <div class="upgrade_3">
                <div class="upgrade_onem"><?= $this->lang->line('upgrade_two_alipay'); ?></div>
                <div class="upgrade_but">
                    <form target="_self" action="<?= $base; ?>user/alipay/" method="post">
                    	<input type="hidden" name="price" value="<?= $this->input->post('price'); ?>" />
                    	<input type="hidden" name="days" value="<?= $this->input->post('days'); ?>" />
                    	<input type="submit" class="taobao" value="" />
                    </form>
                </div>
            </div>
            <div class="upgrade_4">
                <div class="upgrade_onem"><?= $this->lang->line('upgrade_two_other'); ?></div>
                <div class="upgrade_but">
                    <?= $this->lang->line('upgrade_two_otherWord'); ?>
                </div>
            </div>
            <?= $this->load->view('foot'); ?>
        </div>
    </div>
</body>
</html>