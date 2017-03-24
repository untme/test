<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>hotspot认证</title>
</head>
<script type="text/javascript" src="/source/scripts/common.js"></script>
<script type="text/javascript" src="/source/scripts/md5.js"></script>
<body>
<form name="sendin" action="<?php echo trim($hotspot['link-login-only'])==''?'/user':$hotspot['link-login-only'];?>" method="post">
<input id="username" type="hidden" name="username" value="<?php echo $user['phone'];?>"/>
<input id="password" type="hidden" name="password" value="<?php echo $user['password'];?>"/>
<input type="hidden" name="dst" value="http://www.iwifi.cc/user" />
<input type="hidden" name="popup" value="true" />
</form>
<script type="text/javascript">
doLogin();
function doLogin()
{
	//var username = $('#username').val();
	//var password = $('#password').val();
	//document.sendin.username.value = document.login.username.value;
	document.sendin.password.value = hexMD5('<?php echo $hotspot['chap-id'];?>' + document.sendin.password.value + '<?php echo $hotspot['chap-challenge'];?>');
	document.sendin.submit();
	return false;
}
</script>
</body>
</html>
