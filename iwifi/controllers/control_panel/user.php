<?php

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.

        if ($checkAdmin != 'true')
        {
        	redirect('/control_panel/login/', 'refresh');
        }
	}

	// User list page for manage.
	public function index(){
		
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '会员列表';
    	$data['path'] = '会员列表';
    	#分页配置
    	$data['total_user'] = $this->aiwifi->comm_num('user');
    	$this->load->library('pagination');
    	$config['base_url'] = $data['base'].'control_panel/user/index/';
    	$config['total_rows'] = $data['total_user'];
    	$config['per_page'] = 30;
    	$config['uri_segment'] = 4;
    	$config['num_links'] = 5;
    	$config['anchor_class'] = 'class="number" ';
    	$config['cur_tag_open'] = '<a class="number current">';
    	$config['cur_tag_close'] = '</a>';
    	$this->pagination->initialize($config);
    	$data['user_list'] = $this->aiwifi->comm_page_list_order('user', $config['per_page'],$this->uri->segment(4), 'uid', 'DESC');
    	$this->load->view('control_panel/user/all_users', $data);
	}
	
	//后台手工添加会员
	public function user_add()
	{
		if(!empty($_POST)){
			$data = array_map('trim',$_POST);
			//参数处理
			if(''.(float)$data['phone']!=$data['phone'] || strlen($data['phone'])!=11){
				C::toJson(array('value'=>false,'text'=>'手机号码错误'));
			}
			if(empty($data['realname'])){
				C::toJson(array('value'=>false,'text'=>'真实姓名不能为空'));
			}
			if(empty($data['password']) || strlen($data['password'])<6){
				C::toJson(array('value'=>false,'text'=>'密码不能为空,且长度不能小于6位'));
			}
			if($data['password']!=$data['password1']){
				C::toJson(array('value'=>false,'text'=>'两次密码不一致'));
			}
			//提交操作
			$r = array(
				'phone'=>$data['phone'],
				'email'=>$data['email'],
				'realname'=>$data['realname'],
				'nickname'=>$data['nickname'],
				'passwd'=>md5($data['password']),
				'password'=>$data['password'],
				'type'=>'手工添加',
				'regTime'=>time(),
			);
			//入库
			$redata = array();
			$db = C::T('aiwifi_user');
			if($db->count("phone='{$r['phone']}'")){
				C::toJson(array('value'=>false,'text'=>'手机号码已经存在'));
			}
			$bool = $db->insert($r);
			$redata = array('value'=>$bool,'text'=>$bool?'操作成功':'操作失败，请重试');
			C::toJson($redata);
		}
		$this->load->view('control_panel/user/user_add', $data);
	}
	
    /**
     * @位置 后台 用户管理中心.
     * @参数 $operate: 可选 操作类型; $user_id: 可选 用户ID.
     */
	public function search($operate = '')
	{
        $data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";

        if ($operate == 'search_user' || $operate == ''){
        	
        	#查找会员页面
        	$data['nav_title'] = '会员查询';
        	$data['path'] = '会员查询';

            $this->load->view('control_panel/user/search_user',$data);

        }else if ($operate == 'user_result'){

        	#查找会员页面 结果页面
        	$data['nav_title'] = '会员查询结果';
        	$data['path'] = '会员查询结果';
        	
        	$uid = $this->input->post('uid');
            $phone = $this->input->post('phone');
            $realname = $this->input->post('realname');
            
            if (!empty($uid)) {
            	
            	$data['user_list'] = $this->aiwifi->comm_list_where('user', array('uid' => $uid), 1, 0, 'uid');
            	
            }else if (!empty($phone)) {
            	
            	$data['user_list'] = $this->aiwifi->comm_list_where('user', array('phone' => $phone), 1, 0, 'uid');
            	
            }else if (!empty($realname)) {
            	
            	$data['user_list'] = $this->aiwifi->comm_list_where('user', array('realname' => $realname), 1, 0, 'uid');
            	
            }else{
            	
            	$data['user_list'] = null;
            }
            
            $this->load->view('control_panel/user/search_result',$data);

        }

	}

     /**
     * @位置 后台 用户管理中心 - 管理员操作用户.
     * @参数 $operate: 可选 操作类型; $user_id: 可选 用户ID.
     */
     public function user_functions ($operate = '', $user_id = '')
     {
        $data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';

        if ($operate == 'info' || $operate == ''){

            #查看用户详细统计信息
            $data['user_info'] = $this->aiwifi->comm_info('user', 'uid', $user_id);

            $this->load->view('control_panel/user/functions/user_info',$data);
            
        }if ($operate == 'config'){

            #修改用户详细统计信息
            $data['user_info'] = $this->aiwifi->comm_info('user', 'uid', $user_id);

            $this->load->view('control_panel/user/functions/user_config',$data);
            
        }if ($operate == 'config_doing'){

            #修改用户详细统计信息 Posting data.
            $uid = $this->input->post('uid');
            $user['phone'] = $this->input->post('phone');
            $user['email'] = $this->input->post('email');
            $user['realname'] = $this->input->post('realname');
            $user['nickname'] = $this->input->post('nickname');
            
            $this->aiwifi->comm_update('user', $user, 'uid', $uid);
            
            echo '会员基本资料已经成功更新!';
            
        }else if ($operate == 'passwd'){

            #重置会员密码
            if ($this->input->post('action') == 'true'){

                $newpd = urldecode( $this->input->post('passwd') );
                $newpasswd['passwd'] = md5($newpd);
                $uid = $this->input->post('uid');

                $this->aiwifi->comm_update('user', $newpasswd, 'uid', $uid);

                echo '用户密码已经重置!';

            }else{

                # Show Passwd change form.
                $data['uid'] = $user_id;
            	$this->load->view('control_panel/user/functions/user_passwd',$data);
            }
            
        }else if ($operate == 'deleteUser'){
        	
        	$uid = $this->input->post('uid');
        	
        	$this->aiwifi->comm_delete('user', array('uid' => $uid));
        	
        	echo '该会员已经成功删除!';
        	
        }
        
     }
	
	//导出用户信息
	public function exportUserInfo($uid)
	{
		$uid = (int)$uid;
		//取得用户基础信息
		$userInfo = $this->aiwifi->comm_info('user', 'uid', $uid);
		$username = trim($userInfo['phone']);
		$userInfo = is_array($userInfo)?$userInfo:array();
		$userInfo['regTime'] = (int)$userInfo['regTime']?date('Y-m-d H:i:s',(int)$userInfo['regTime']):'无';
		$userInfo['loginTime'] = (int)$userInfo['loginTime']?date('Y-m-d H:i:s',(int)$userInfo['loginTime']):'无';
		//取得用户的IP
		$userInfo['ip'] = trim($this->aiwifi->comm_value('aiwifi_user_ipdata','username',$userInfo['phone'],'ip'));
		//取得用户的服务名称
		$userInfo['service_name'] = trim($this->aiwifi->comm_value('aiwifi_service','id',$userInfo['service_id'],'title'));
		//用户使用过的MAC地址
		$userInfo['macRs'] = $this->aiwifi->query("select mac,mac_info from aiwifi_user_mac where username='".$userInfo['phone']."'");
		//用户购买服务记录
		$userInfo['PaySericeRs'] = $this->aiwifi->query("select p.id as orderID,s.title,p.ordertime from aiwifi_service_order as p,aiwifi_service as s where p.username='".$userInfo['phone']."' and p.ispay=1 and p.service_id=s.id order by p.ordertime desc");
		//用户问答记录
		$userInfo['aqRs'] = $this->aiwifi->query("select q.aq_title,log.aa_id from aiwifi_ask_user_log as log, aiwifi_ask_question as q where log.uid='{$uid}' and log.aq_id=q.aq_id order by log.aq_id");
		foreach($userInfo['aqRs'] as &$_r){
			//取得回答的选择记录
			$aids = explode(',',$_r['aa_id']);
			$answer = array();
			foreach($aids as $aid){
				$answer[] = trim($this->aiwifi->comm_value('aiwifi_ask_answer','aa_id',(int)$aid,'aa_title'));
			}
			$_r['answer'] = implode(',',$answer);
		}
		//用户的登录日志记录,倒序 (来自热点机,mac,mac厂商,登录时间
		$userInfo['loginRs'] = $this->aiwifi->query("select * from aiwifi_user_login_log where username='$username' order by _id desc");
		if(!is_array($userInfo['loginRs'])){
			$userInfo['loginRs'] = array();
		}
		
		//print_r($userInfo);exit;
		$filename = "userID_{$uid}.xls";
		header("Content-Disposition:filename=$filename");
		header("Content-type:unknown/unknown");
		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		echo "
<table border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td><strong>用户名</strong></td>
    <td>".$userInfo['phone']."</td>
  </tr>
  <tr>
    <td><strong>姓名</strong></td>
    <td>".$userInfo['realname']."</td>
  </tr>
  <tr>
    <td><strong>email</strong></td>
    <td>".$userInfo['email']."</td>
  </tr>
  <tr>
    <td><strong>昵称</strong></td>
    <td>".$userInfo['nickname']."</td>
  </tr>
  <tr>
    <td><strong>注册时间</strong></td>
    <td>".$userInfo['regTime']."</td>
  </tr>
  <tr>
    <td><strong>最后登录时间</strong></td>
    <td>".$userInfo['loginTime']."</td>
  </tr>
  <tr>
    <td><strong>分配的IP</strong></td>
    <td>".$userInfo['ip']."</td>
  </tr>
  <tr>
    <td><strong>所属服务</strong></td>
    <td>".$userInfo['service_name']."</td>
  </tr>
  <tr>
    <td><strong>服务的有效时间</strong></td>
    <td>".$userInfo['service_endtime']."</td>
  </tr>";
  
  //用户所使用的上网设备的MAC信息
  echo "
  <tr>
    <td colspan='2'><strong>用户所使用的上网设备的MAC信息：</strong></td>
  </tr>";
  foreach($userInfo['macRs'] as $r){
	  echo "<tr>
		<td>".$r['mac']."</td>
		<td>".$r['mac_info']."</td>
	  </tr>";
  }
  
  //用户的服务订单
  echo "
  <tr>
    <td colspan='2'><strong>用户的服务订单：</strong></td>
  </tr>";
  foreach($userInfo['PaySericeRs'] as $r){
  	echo "<tr>
		<td>".$r['title']."</td>
		<td>订单号：".$r['orderID']." 时间：".$r['ordertime']."</td>
	  </tr>";
  }
  
  //用户的问答记录
  echo "
  <tr>
    <td colspan='2'><strong>用户的问答记录：</strong></td>
  </tr>";
  foreach($userInfo['aqRs'] as $r){
	  echo "<tr>
		<td>".$r['aq_title']."</td>
		<td>".$r['answer']."</td>
	  </tr>";
  }
  
  //用户的登录日志记录
  echo "
  <tr>
    <td colspan='2'><strong>用户的登录日志记录：</strong></td>
  </tr>";
  foreach($userInfo['loginRs'] as $r){
	  echo "<tr>
		<td>".$r['_time']." | ".$r['store_name']."</td>
		<td>".$r['mac']." | ".$r['mac_info']."</td>
	  </tr>";
  }
  
  echo "
</table>";
		
	}
	
}

/* End of file home.php in the controllers*/
