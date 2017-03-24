    <div class="smallpanel">
    	<div class="pcont-1"><div class="pcont-2"><div class="pcont-3">
    		<div id="adminbarleft">当前所在的位置 : <?= $path; ?></div>
    		<div id="adminbar">欢迎您回来, <span> <?= $this->session->userdata('admin_name'); ?>  !&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" id="edit_admin_info">修改信息</a></span>  <a href="javascript: history.back();" class="logout">返回上一步</a>  </div>
    	</div></div></div>
    </div>
    
	<script type="text/javascript">
		$("#edit_admin_info").click(function(){
			$.facebox({ajax:"/control_panel/admin/admin_edit/"});
		});
	</script>