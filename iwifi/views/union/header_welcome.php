<div class="opt clearfix">
    <a href="<?= $base; ?>union/user/" class="item">欢迎您，<?= $this->session->userdata('nickname'); ?></a>
    <a href="<?= $base; ?>union/user/profile" class="item"><?= $this->lang->line('user_statu_profile'); ?></a>
	<a href="<?= $base; ?>union/user/passwd" class="item"><?= $this->lang->line('passwd_welcome'); ?></a>
</div>