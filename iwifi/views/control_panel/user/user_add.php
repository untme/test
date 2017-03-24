<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>添加会员</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
<script type="text/javascript">
$(document).ready(function(){
    // Back to user list page.
    $(".backtouserlist").click(function(){
    	window.location.href="/control_panel/user/index/";
    });
});

//添加会员
function user_add()
{
	var url = '/control_panel/user/user_add';
	var data = $('#addfrom').serializeArray();
	var json = cexAjax.getJson(url,data); //返回一个json串的对象
	if(json){
		if(json.text){
			alert(json.text);
		}
		if(json.value){
			gourl(url);
		}
	}
}
</script>
</head>

<body>
<div id="frame_content">
<!-- Page Head -->
    <!-- smallpanel [begin] -->
    <?php $this->load->view('control_panel/navigation'); ?>
    <div class="clear"></div> <!-- End .clear -->

    <!-- End Notifications -->

	<div class="content-box"><!-- Start Content Box -->

		<div class="content-box-header">

			<h3>添加会员</h3>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">
			<div class="tab-content default-tab" id="tablefield">
				<form id="addfrom" method="post">
                <p>
					<span>手机号码: </span>
					<input name="phone" type="text" class="text-input small-input" id="phone" maxlength="11" /> 
					<span style="color: #F00">*</span><br /><small>用户手机号必须唯一,且只能注册一次。</small>
				</p>
				<p>
					<span>密　　码: </span>
					<input name="password" type="password" class="text-input small-input" id="password" maxlength="20" />
                    <span style="color: #F00">*</span>
				</p>
                <p>
					<span>重复密码: </span>
					<input name="password1" type="password" class="text-input small-input" id="password1" maxlength="20" />
                    <span style="color: #F00">*</span>
				</p>
                <p>
					<span>真实姓名: </span>
					<input name="realname" type="text" class="text-input small-input" id="realname" maxlength="15" />
					<span style="color: #F00">*</span><br /><small>用户真实姓名.</small>
				</p>
				<p>
					<span>昵　　称: </span>
					<input name="nickname" type="text" class="text-input small-input" id="nickname" maxlength="20" />
				</p>
                <p>
					<span>E-mail　: </span>
					<input name="email" type="text" class="text-input small-input" id="email" size="50" />
				</p>
                <p>
					<input class="button search_user" type="button" value="提交" onclick="user_add();"/>
					<input class="button backtouserlist" type="button" value="返回会员列表" />
				</p>
                </form>
				<div class="clear"></div><!-- End .clear -->
				<div class="user_list2" id="show_result"></div>
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