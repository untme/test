<?php

class Index extends CI_Controller {

	function __construct()
	{
		parent::__construct();

        $checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.
		$this->load->helper('aiwifi');
        if ($checkAdmin != 'true')
        {
        	redirect('/control_panel/login/', 'refresh');
        }
	}

    /**
     * 管理中心 - 中心框架页 
     * @Note 用于显示管理中心框架展示
    */
	public function index()
	{
        $data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
    	$data['title'] = '管理中心 - Aiwifi';

		$this->load->view('control_panel/index',$data);
	}

    /**
     * @位置  后台管理首页 - 框架内首页 功能型首页.
    */
    public function home()
    {
        $data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
    	$data['title'] = '后台管理系统 - Aiwifi';
        $data['path'] = '后台管理首页';
		
		//取得短信剩余数 [libin]
//		$arr = sms::getSurplusNum();
		$data['SmsSurplusNum'] = @$arr['text'];
		//取得会员总数
		$data['memberTotal'] = (int)$this->aiwifi->comm_num('aiwifi_user');
		//今日登录会员数
		$time = strtotime(date('Y-m-d'));
		$arr = $this->aiwifi->query("select count(1) as num from aiwifi_user where loginTime>$time");
		$data['memberLoginTotal'] = @$arr[0]['num'];
		//今日注册会员数
		$arr = $this->aiwifi->query("select count(1) as num from aiwifi_user where regTime>$time");
		$data['memberRegTotal'] = @$arr[0]['num'];
		
		$this->load->view('control_panel/home',$data);
    }
    
    /**
     * @位置  后台管理员退出登录.
     */
     public function logout()
     {
        $this->session->unset_userdata('admin_islogin');
		redirect('/control_panel/login/', 'refresh');
     }
	
	//导出xls
	public function export($type)
	{
		set_time_limit(0);
		ini_set('memory_limit','128M');
		ob_end_clean();
		$type = trim($type);
		if($type==''){
			return ;
		}
		
		//导出会员信息
		if($type=='member_info'){
			$filename = 'user_list_'.date('Ymd').'.xls';
			header("Content-Disposition:filename=$filename");
			header("Content-type:unknown/unknown");
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<table>
			  <tr>
				<td>用户名</td>
				<td>姓名</td>
				<td>email</td>
				<td>昵称</td>
				<td>注册时间</td>
				<td>最后登录时间</td>
				<td>分配的IP</td>
				<td>所属服务</td>
				<td>服务的有效时间</td>
			  </tr>';
			$rs = $this->aiwifi->query("select * from aiwifi_user as u,aiwifi_user_ipdata as ip,aiwifi_service as s where 
			u.phone=ip.username and u.service_id=s.id");
			foreach($rs as $r){
				$r['regTime'] = date('Y-m-d H:i:s',$r['regTime']);
				$r['loginTime'] = date('Y-m-d H:i:s',$r['loginTime']);
				echo "<tr>
				<td>{$r[phone]}</td>
				<td>{$r[realname]}</td>
				<td>{$r[email]}</td>
				<td>{$r[nickname]}</td>
				<td>{$r[regTime]}</td>
				<td>{$r[loginTime]}</td>
				<td>{$r[ip]}</td>
				<td>{$r[title]}</td>
				<td>{$r[service_endtime]}</td>
			  	</tr>";
			}
			echo '</table>';
			return ;
		}
		
		//导出会员问答记录
		if($type=='member_aq'){
			$filename = 'user_aq'.date('Ymd').'.xls';
			header("Content-Disposition:filename=$filename");
			header("Content-type:unknown/unknown");
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<table>
			  <tr>
				<td>用户名</td>
				<td>姓名</td>
				<td>问题</td>
				<td>回答</td>
			  </tr>';
			$rs = $this->aiwifi->query("select * from aiwifi_ask_user_log as log,aiwifi_user as u,aiwifi_ask_question as q where log.uid=u.uid and log.aq_id=q.aq_id order by log.uid");
			foreach($rs as $r){
				//取得回答的选择记录
				$aids = explode(',',$r['aa_id']);
				$answer = array();
				foreach($aids as $aid){
					$answer[] = trim($this->aiwifi->comm_value('aiwifi_ask_answer','aa_id',(int)$aid,'aa_title'));
				}
				$r['answer'] = implode(',',$answer);
				echo "<tr>
						<td>{$r[phone]}</td>
						<td>{$r[realname]}</td>
						<td>{$r[aq_title]}</td>
						<td>{$r[answer]}</td>
					  </tr>";
			 }
			echo '</table>';
			return ;
		}
		
		//导出会员设备MAC信息
		if($type=='member_mac'){
			$filename = 'user_mac'.date('Ymd').'.xls';
			header("Content-Disposition:filename=$filename");
			header("Content-type:unknown/unknown");
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<table>
				  <tr>
					<td>用户名</td>
					<td>姓名</td>
					<td>设备MAC地址</td>
					<td>MAC地址所属商家</td>
					<td>设备最后使用时间</td>
				  </tr>';
			$rs = $this->aiwifi->query("select * from aiwifi_user_mac as mac,aiwifi_user as u where mac.username=u.phone");
			foreach($rs as $r){
				  echo "<tr>
					<td>{$r[username]}</td>
					<td>{$r[realname]}</td>
					<td>{$r[mac]}</td>
					<td>{$r[mac_info]}</td>
					<td>{$r[_time]}</td>
				  </tr>";
			}
			echo '</table>';
			return;
		}
	}
    /*php方法添加数据表*/
    public function index_home_test(){

echo 'test<br>';
$sql0 = "INSERT INTO `aiwifi_service` VALUES ('48', 'hot-2m-00', '1800 seconds', '0.00', '2M 试用30分钟', '4M 试用30分钟', '1', '');";

$sql1 = "CREATE TABLE `aiwifi_servicead_click`(`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`uid` varchar(32) NOT NULL COMMENT '用户ID',`ad_id` varchar(100) NOT NULL COMMENT '广告ID',PRIMARY KEY (`id`))ENGINE=InnoDB AUTO_INCREMENT=717 DEFAULT CHARSET=utf8 COMMENT='用户点击广告情况表';";

$sql2 = "CREATE TABLE `aiwifi_service_case`(`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`case_id` int(11) NOT NULL COMMENT '方案ID',`ad_num` int(4) NOT NULL,PRIMARY KEY (`id`))ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='点击广告升级带宽方案';";

        $re0 = $this->db->query($sql0);
        $re1 = $this->db->query($sql1);
        $re2 = $this->db->query($sql2);
        var_dump($re0);
        var_dump($re1);
        var_dump($re2);

    }

}

/* End of file index.php in the controllers*/