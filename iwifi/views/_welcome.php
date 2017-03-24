<div class="welcome">
	欢迎您 <a href="<?= $base; ?>user/"><?= $this->session->userdata('nickname'); ?></a>!&nbsp;&nbsp;&nbsp;
    <a href="<?= $base; ?>user/profile"><?= $this->lang->line('user_statu_profile'); ?></a>&nbsp;&nbsp;&nbsp;
    <a href="<?= $base; ?>user/passwd"><?= $this->lang->line('user_statu_passwd'); ?></a>&nbsp;&nbsp;&nbsp;
    <a href="<?= $base; ?>user/upgrade" class="blue"><font color="#FF0000">升级高速上网</font></a>
</div>
