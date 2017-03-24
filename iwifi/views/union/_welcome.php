<div class="opt clearfix">
	<a class="item" href="<?= $base; ?>union/user/">欢迎您 <?= $this->session->userdata('nickname'); ?></a>
    <a class="item" href="<?= $base; ?>union/user/profile"><?= $this->lang->line('user_statu_profile'); ?></a>
    <a class="item" href="<?= $base; ?>union/user/passwd"><?= $this->lang->line('user_statu_passwd'); ?></a>
</div>