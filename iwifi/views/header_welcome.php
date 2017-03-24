<div class="opt clearfix">
    <a href="<?= $base; ?>user/" class="item">欢迎您，<?= $this->session->userdata('nickname'); ?></a>
    <a href="<?= $base; ?>user/profile" class="item"><?= $this->lang->line('user_statu_profile'); ?></a>
    <a href="<?= $base; ?>user/passwd" class="item"><?= $this->lang->line('passwd_welcome'); ?></a>
    <a href="<?= $base; ?>user/upgrade?type=1" class="item">升级高速上网</a>
</div>