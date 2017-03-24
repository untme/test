<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $title; ?></title>
<link rel="stylesheet" href="<?= $source; ?>style/control_panel/reset.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?= $source; ?>style/control_panel/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?= $source; ?>style/control_panel/invalid.css" type="text/css" media="screen" />
</head>

<body id="login">

	<div id="login-wrapper" class="png_bg">
		<div id="login-top">
			<h1>Aiwifi</h1>
			<!-- Logo (221px width) -->
			<img id="logo" src="<?= $source; ?>images/control_panel/logo.png" alt="Aiwifi 管理员登陆" />
		</div>
        <!-- End #logn-top -->
		<div id="login-content">
			<form action="<?= $base; ?>control_panel/login/" method="post">
            <input type="hidden" name="action" value="true" />
				<div class="notification information png_bg">
					<div>
						<?= $note; ?>
					</div>
				</div>
				<p>
					<label>管理员 : </label>
					<input class="text-input" name="admin_name" type="text" value="" />
				</p>
				<div class="clear"></div>
				<p>
					<label>密码 : </label>
					<input class="text-input" id="pw" name="passwd" type="password" />
				</p>
				<div class="clear"></div>
				<p>
					<input class="button" type="submit" value="登 陆" />
				</p>
			</form>
		</div>
        <!-- End #login-content -->
	</div>
    <!-- End #login-wrapper -->

</body>
</html>