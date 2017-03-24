<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>后台管理系统 - Aiwifi</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->load->view('control_panel/head_meta'); ?>
</head>
<body>
<div id="frame_content">
<!-- Page Head -->
    <!-- smallpanel [begin] -->
        <div class="smallpanel">
    	<div class="pcont-1"><div class="pcont-2"><div class="pcont-3">
    		<div id="adminbarleft">当前所在的位置 : 广告管理 - 登录验证码图片</div>
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
    <div class="clear"></div> <!-- End .clear -->

	<div class="content-box"><!-- Start Content Box -->
		<div class="content-box-header">
			<h3>广告管理 - 登录验证码图片</h3>
			<div class="clear"></div>
		</div> <!-- End .content-box-header -->
		
  <div class="content-box-content">
			<div class="tab-content default-tab" id="tablefield">
           	  <form id="form1" method="get" action="">
                显示广告: 
                <select name="store_id" onchange="gourl('/control_panel/advertisement/loginPic_index/'+this.value);">
                  <option value="0">全部广告图片 - 管理</option>
                  <?php foreach($stores as $s){?>
                  <option value="<?php echo $s['store_id'];?>" <?php if($store_id==$s['store_id']){echo 'selected';}?>>[<?php echo $s['store_name'];?>]</option>
                  <?php }?>
                </select>
                <hr />
              </form>
              
              <form id="adlist" name="form2" method="post" action="">
				<?php if($store_id){?>
                <input type="hidden" name="store_id" id="store_id" value="<?php echo $store_id;?>" />
                <?php }else{?>
                <!--将广告ID添加到商家的登录验证图片列表中-->
                将选中广告添加到商家:
                <select id="store_id" name="store_id">
                	<option value="0">选择商家...</option>
                  <?php foreach($stores as $s){?>
                  <option value="<?php echo $s['store_id'];?>"><?php echo $s['store_name'];?></option>
                  <?php }?>
                </select>
                <input type="button" value="添加" onclick="addToStore();" />
                <script>
                	//将广告ID添加到商家的登录验证图片列表中
					function addToStore()
					{
						var store_id = $('#store_id').val(); //商家ID
						var data = $('#adlist').serializeArray();
						$.post('/control_panel/advertisement/addToStore/?'+Math.random(),data,function(json){
									alert(json.text);
									if(json.value){
										//gourl('/control_panel/advertisement/loginPic_index/'+store_id);
									}
								},'json');
					}
                </script>
                <?php }?>
			  <table width="99%" align="center">
	  				<thead>
						<tr>
						   <th align="center"><input class="check-all" type="checkbox" /></th>
						   <th align="center">ID</th>
				           <th align="center">广告名称</th>
					       <th align="center">图片</th>
					       <th align="center">验证码</th>
					       <th align="center">提示文字</th>
                           <?php if($store_id){?>
                          <th align="center">商家</th>
                         <?php }else{?>
					       <th align="center">操作</th>
                           <?php }?>
						</tr>
					</thead>

					<tbody>
                    	<?php foreach($rs as $key=>$r){?>
           	    		<tr <?php if(!($key%2)){echo 'class="alt-row"';}?>>
						  <td align="center"><input name="ids[]" type="checkbox" value="<?php echo $r['ad_id'];?>"></td>
							<td align="center"><?php echo $r['ad_id'];?></td>
							<td align="center"><?php echo $r['ad_name'];?></td>
							<td align="center"><a href="/data/ad/<?php echo $r['ad_img'];?>" target="_blank">点击预览</a></td>
							<td align="center"><?php echo $r['ad_code'];?></td>
                            <td align="center"><?php echo $r['ad_code_word'];?></td>
							<?php if($store_id){?>
                      <td align="center"><a href="/control_panel/store/store_modify/<?php echo $r['store_id'];?>" target="_blank"><?php echo $r['store']['store_name'];?></a></td>
                            <?php }else{?>
              <td align="center" class="operate">
                                [<a title="修改广告信息" href="/control_panel/advertisement/loginPic_update/<?php echo $r['ad_id'];?>">修改</a>]
                                [<a title="删除该广告" href="javascript:delR('<?php echo $r['ad_id'];?>');">删除</a>]								
                            </td>
                            <?php }?>
						</tr>
                        <?php }?>
   		      		</tbody>
                    
					<tfoot>
						<tr>
							<td colspan="7">
								<div class="bulk-actions align-left">
                                	<?php if($store_id){?>
                                    <a class="button" href="javascript:delToStore();">从商家移除</a>
                                    <script>
										//将广告ID从商家的登录验证图片列表中移除
										function delToStore()
										{
											var store_id = $('#store_id').val(); //商家ID
											var data = $('#adlist').serializeArray();
											$.post('/control_panel/advertisement/delToStore/?'+Math.random(),data,function(json){
														alert(json.text);
														if(json.value){
															gourl('/control_panel/advertisement/loginPic_index/'+store_id);
														}
													},'json');
										}
									</script>
									<?php }else{?>
									<a class="button" href="/control_panel/advertisement/loginPic_add">添加新验证图片</a>
                                    <?php }?>
								</div>
								<div class="pagination">
                                    <?php echo $this->pagination->create_links(); ?>
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>
				</table>
			  </form>
              <div class="clear"></div><!-- End .clear -->

			</div> <!-- End #tab2 -->

		</div> <!-- End .content-box-content -->

	</div> <!-- End .content-box -->


	<div class="clear"></div>
    <?php $this->load->view("control_panel/doing"); ?>
	<?php $this->load->view('control_panel/footer'); ?>
    <!-- End #footer -->
</div>

<script>
//删除
function delR(ad_id)
{
	if (confirm('你确定要删除这个广告吗?')){
		$.ajax({
			type: "POST",
			url: "/control_panel/advertisement/del_ad/",
			data: {ad_id: ad_id},
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
	}
}
</script>
</body>
</html>