<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理系统 - Aiwifi</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
</head>

<body>
<div id="frame_content">
        <div class="smallpanel">
    	<div class="pcont-1"><div class="pcont-2"><div class="pcont-3">
    		<div id="adminbarleft">当前所在的位置 : 广告管理 - 更新新验证图片</div>
    		<div id="adminbar">欢迎您回来, 
            <span> <?= $this->session->userdata('admin_name'); ?> !&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" id="edit_admin_info">修改信息</a></span>
            <script type="text/javascript">
				$("#edit_admin_info").click(function(){
					$.facebox({ajax:"/control_panel/admin/admin_edit/"});
				});
			</script>
            <a href="javascript: history.back();" class="logout">返回上一步</a>  </div>
    	</div></div></div>
    </div>
    <div class="clear"></div>
	<div class="content-box">
		<div class="content-box-header">
			<h3>广告管理 - 更新验证图片</h3>
			<div class="clear"></div>
		</div>
  		<div class="content-box-content">
			<div class="tab-content default-tab" id="tablefield">
           	  <form id="form1" method="post" enctype="multipart/form-data" action="">
                <p>
                  <input name="o" type="hidden" value="ok"/>
                  <input name="id" type="hidden" value="<?php echo $r['ad_id'];?>"/>
                </p>
                <p>广告名称: <input name="ad_name" type="text" value="<?php echo $r['ad_name'];?>" class="text-input small-input"></p>
                <p>上传图片: <input id="file" type="file" name="adImg" class="text-input small-input" onchange="ImagePreview('file','preview');" value="<?php echo $r['ad_img'];?>"></p>
                <p>预览:<br /><div id="localImag" style="width:300px; height:150px;"><img id="preview" src="/data/ad/<?php echo $r['ad_img'];?>" width="300" height="150" border="1"/></div></p>
                <p>验证码: <input name="ad_code" type="text" value="<?php echo $r['ad_code'];?>" class="text-input small-input"></p>
                <p>提示文字: <input name="ad_code_word" type="text" value="<?php echo $r['ad_code_word'];?>" class="text-input small-input"></p>
           	  </form>
              <hr />
              <div class="clear"></div>
			<a class="button" href="javascript:$('#form1').submit();">更新</a>
			<a class="button" href="/control_panel/advertisement/loginPic_index/">返回列表</a>
		  </div>
		</div>
	</div>
	<div class="clear"></div>
    <?php $this->load->view("control_panel/doing"); ?>
	<?php $this->load->view('control_panel/footer'); ?>
    <!-- End #footer -->
</div>
<script>
//图片预览
function ImagePreview(FileId,ImageId) 
{
	var docObj=document.getElementById("file");
	var imgObjPreview=document.getElementById("preview");
	if(docObj.files && docObj.files[0]){
		//火狐下，直接设img属性
		imgObjPreview.style.display = 'block';
		//火狐7以上版本不能用上面的getAsDataURL()方式获取，需要一下方式  
		imgObjPreview.src = window.URL.createObjectURL(docObj.files[0]);
	}else{
		//IE下，使用滤镜
		docObj.select();
		var imgSrc = document.selection.createRange().text;
		var localImagId = document.getElementById("localImag");
		//图片异常的捕捉，防止用户修改后缀来伪造图片
		try{
			localImagId.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
			localImagId.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = imgSrc;
		}catch(e){
			alert("您上传的图片格式不正确，请重新选择!");
			return false;
		}
		imgObjPreview.style.display = 'none';
		document.selection.empty();
	}
	return true;
}
</script>
</body>
</html>