<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理系统 - Aiwifi</title>
<?php $this->load->view('control_panel/head_meta'); ?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
</head>
<body>

<div id="frame_content">
<!-- Page Head -->
    <!-- smallpanel [begin] -->
    <div class="smallpanel">
    	<div class="pcont-1"><div class="pcont-2"><div class="pcont-3">
    		<div id="adminbarleft">当前所在的位置 : 行为日志</div>
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
			<h3>行为日志</h3>
			<div class="clear"></div>
		</div> <!-- End .content-box-header -->
      <div style="margin:30px;">
      <form action="/control_panel/syslog/index/" method="post" id="syslog">
      	日期: <input name="day" type="text" id="day" value="<?php echo empty($day)?date('Y-m-d'):$day;?>" readonly/>
   	    几点: <select name="hour" id="hour">
        <?php for($i=0;$i<24;$i++){?>
        <option value="<?php echo $i?>" <?php if((int)$hour==$i){echo "selected";}?>><?php echo $i;?></option>
      	<?php }?>
        </select> 
        行为类型: <select name="type" id="type">
        <option value="www" <?php if(trim($type)=='www'){echo "selected";}?>>网页</option>
        <option value="qqlogin" <?php if(trim($type)=='qqlogin'){echo "selected";}?>>QQ</option>
        </select>
        关键字:<input type="text" name="keyword" id="keyword" value="<?php echo trim($keyword);?>" />
        <input type="submit" value="查询" />
      </form>
      <div class="clear"></div><!-- End .clear -->
      <table>
          <thead>
              <tr>
                 <th>时间</th>
                 <th>IP</th>
                 <th>title</th>
                 <th>Log</th>
              </tr>
          </thead>
          <tfoot>
              <tr>
                  <td colspan="6">
                      <div class="pagination">
                          <?= $this->pagination->create_links(); ?>
                      </div> <!-- End .pagination -->
                      <div class="clear"></div>
                  </td>
              </tr>
          </tfoot>
          <tbody>
              <?php foreach($rs as $r){
				  		$userId = syslogd::getUserIdByIp($r['ip']);
				  ?>
              <tr>
                  <td><?= $r['time']; ?></td>
                  <td>
                  <?php if($userId){?>
                  <a href="javascript:;" onclick="userinfo('<?php echo $userId;?>');" title="显示会员的详细资料"><?= $r['ip']; ?></a>
                  <?php }else{
                      		echo $r['ip'];
				  		}
				  ?>
                  </td>
                  <td><?= $r['content']; ?></td>
                  <td><?= $r['log']; ?></td>
              </tr>
              <?php }?>
          </tbody>

		</table>
      </div>
    </div> <!-- End .content-box -->

	<div class="clear"></div>
    <?php $this->load->view("control_panel/doing"); ?>
	<?php $this->load->view('control_panel/footer'); ?>
    <!-- End #footer -->
</div>
<script>
<?php if(!$value){echo "alert('{$text}');";}?>

//查看会员详细统计信息
function userinfo(user_id)
{
	if(user_id){
		$.facebox({ajax:"/control_panel/user/user_functions/info/"+user_id});
	}else{
		return false;
	}
}
	
$(function(){
	$("#day").datepicker({
		/* 区域化周名为中文 */
		dayNamesMin : ["日", "一", "二", "三", "四", "五", "六"],
		/* 每周从周一开始 */
		firstDay : 1,
		/* 区域化月名为中文习惯 */
		monthNames : ["1月", "2月", "3月", "4月", "5月", "6月","7月", "8月", "9月", "10月", "11月", "12月"],
		/* 月份显示在年后面 */
		showMonthAfterYear : true,
		/* 年份后缀字符 */
		yearSuffix : "年",
		/* 格式化中文日期
		（因为月份中已经包含“月”字，所以这里省略） */
		dateFormat : "yy-mm-dd"
	});
});
</script>
</body>
</html>