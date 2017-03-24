<script type="text/javascript">
$(document).ready(function(){
    $(".cancel").click(function(){
        $(document).trigger('close.facebox');
    });

    $(".submitUserInfo").click(function(){
        var uid = $("#uid").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        var realname = $("#realname").val();
        var nickname = $("#nickname").val();

        $.ajax({
        	type: "POST",
        	url: "<?= $base; ?>control_panel/user/user_functions/config_doing/",
        	data: "uid=" + uid + "&phone="+phone+"&email="+email+"&realname="+realname+"&nickname="+nickname,
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
    });
});
</script>
<div class='popdiv'>
  <div class='popdiv_title'>修改用户基本信息</div>
  <div class='popdiv_content'>
    <form>
        <p>
            <span>手机号码 : </span>
            <input type="hidden" id="uid" value="<?= $user_info['uid']; ?>" />
            <label><input id="phone" class="text-input medium-input" type="text" name="phone" value="<?= $user_info['phone']; ?>" /></label>
        </p>

        <p>
            <span>邮箱地址 : </span>
            <label><input id="email" class="text-input medium-input" type="text" name="email" value="<?= $user_info['email']; ?>" /></label>
        </p>

        <p>
            <span>真实姓名 : </span>
            <label><input id="realname" class="text-input medium-input" type="text" name="realname" value="<?= $user_info['realname']; ?>" /></label>
        </p>
        
        <p>
            <span>会员昵称 : </span>
            <label><input id="nickname" class="text-input medium-input" type="text" name="nickname" value="<?= $user_info['nickname']; ?>" /></label>
        </p>

    </form>
  </div>
  <div class='popdiv_buttons'>
      <a class='buttons cancel' href='javascript:void(0);' >取消</a>
      <a class='buttons submitUserInfo' href='javascript:void(0);' >确定</a>
  </div>
</div>