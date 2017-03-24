<script type="text/javascript">
$(document).ready(function(){
    $(".makesure").click(function(){
        $(document).trigger('close.facebox');
    });
});
</script>
<div class='popdiv'>
  <div class='popdiv_title'>用户基本信息查看</div>
  <div class='popdiv_content'>
    <form>
        <p>
            <span>手机号码 : </span>
            <label><?= $user_info['phone']; ?></label>
        </p>

        <p>
            <span>邮箱地址 : </span>
            <label><?= $user_info['email']; ?></label>
        </p>
        
  <p>
            <span>真实姓名 : </span>
            <label><?= $user_info['realname']; ?></label>
        </p>
        
        <p>
            <span>会员昵称 : </span>
            <label><?= $user_info['nickname']; ?></label>
        </p>

        <p>
            <span>会员类型 : </span>
            <? if ($user_info['type'] == 0): ?>
            <label><font>普通会员</font></label>
            <? elseif ($user_info['type'] == 1):?>
            <label><font color="green">金牌会员</font></label>
            <? endif; ?>
        </p>

        <p>
            <span>注册日期 : </span>
            <label><?= date('Y年m月d日 H:i:s', $user_info['regTime']); ?></label>
        </p>
        
        <p>
            <span>登陆日期 : </span>
            <label><?=(int)$user_info['loginTime']?date('Y年m月d日 H:i:s',$user_info['loginTime']):'无';?></label>
        </p>
    </form>
  </div>
  <div class='popdiv_buttons'>
      <a class='buttons makesure' href='javascript:void(0);' >关 闭</a>
      <a class='buttons makesure' href='/control_panel/user/exportUserInfo/<?php echo (int)$user_info['uid'];?>' target="_blank">导出完整资料</a>  </div>
  </div>