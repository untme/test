<?php

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		//检测用户是否来自热点 [LiBin]
		$this->aiwifi->isFromHotspot();
		
		// Check if user has already login.
        $user_login = $this->session->userdata('islog');
        // Check if user answer the questions.
        $user_ask = $this->session->userdata('ask');

        if ($user_login != 'true')
        {
        	redirect('/sign', 'refresh');
        }
        
        if ($user_ask != 'true') {
        	
        	redirect('/ask', 'refresh');
        }
	}

    // Sign up AND Sign in show page.
	public function index()
	{
		$this->load->helper('aiwifi');
		
		// Get session language type.
		$lang_type = $this->session->userdata('lang_type');
		
		if (empty($lang_type) || $lang_type == 1) {
        	
        	$this->lang->load('aiwifi', 'chinese');
        	$data['lang_type'] = 1;
        	
        }else if ($lang_type == 2) {
        	
        	$this->lang->load('aiwifi', 'english');
        	$data['lang_type'] = 2;
        	
        }else if ($lang_type == 3) {
        	
        	$this->lang->load('aiwifi', 'japanese');
        	$data['lang_type'] = 3;
        	
        }else if ($lang_type == 4) {
        	
        	$this->lang->load('aiwifi', 'korean');
        	$data['lang_type'] = 4;
        	
        }
		
		$data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
        $uid = $this->session->userdata('uid');
        
        // Get adertisement for this page.
        $data['ad'] = $this->aiwifi->get_advertisement($data['lang_type'], 4);
        
        // Get default navs here.
        $data['nav'] = $this->aiwifi->comm_list_where('navigator', array('default' => 1), 100, 0, 'nav_sort', 'ASC');
        // Get user's navs here.
        $data['nav_user'] = $this->aiwifi->comm_list_where('navigator', array('uid' => $uid), 100, 0, 'nav_id', 'ASC');

        // Get store data information.
        $data['store'] = $this->aiwifi->comm_info('store', 'store_id', $this->session->userdata('store_id'));
        
        //检测用户今天是否已经申请了试用20分钟服务 [LiBin]
		$uid = $this->session->userdata('phone'); //取得用户ID
		$data['trial'] = $this->aiwifi->isTrial20($uid);
		//取得当前会员的服务类型 [LiBin]
		$data['service'] = $this->aiwifi->getNowServiceByUserID($uid);
		if(isset($_SESSION['HotspotInfo']) && isset($_SESSION['HotspotInfo']['server-name'])){
			$hot = $_SESSION['HotspotInfo'];
		}else{
			$hot = array('server-name'=>'');
		} 
		redirect('/union/user?called='.$hot['server-name'], 'refresh');	
		$this->load->view('nav_new',$data);
	}
	
	// 体验金牌会员点击提交.
	public function trial(){
		
		$action = $this->input->post('action');
		if ($action != 'true') {
			
			exit(0);
			
		}
		
		$uid = $this->session->userdata('uid');
		
		// Should check if this user has already signed today
		$is_trial = $this->aiwifi->comm_check('trial', array('uid' => $uid));
		
		if (!empty($is_trial)) {
			
			exit(0);
		}
		
		$user = $this->aiwifi->comm_info('user', 'uid', $uid);
		$time = time();
		$this->aiwifi->comm_instert('trial', array('uid' => $uid, 'trial_date' => $time));
		// Empty user login and ask session.
		$unsetSession = array('islog' => 'false', 'ask' => 'false');
		$this->session->unset_userdata($unsetSession);
		
		// Call API.
		// ---------------------------------------------------------------------------------------- Start Here
		$this->load->helper('aiwifi');
		include_once APPPATH.'libraries/client.php';
		radius_change_group($user['phone'],'trialMember');
		// ---------------------------------------------------------------------------------------- End Here
		
		echo 1;
		
	}
	
	// Add new pics
	public function add_link(){
		
		$nav['nav_title'] = $this->input->post('nav_title');
		$nav['nav_link'] = $this->input->post('nav_link');
		$nav['uid'] = $this->session->userdata('uid');
		// Upload picture to server.
		$save_path = './data/navigator/';
		$config['upload_path'] = $save_path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '5120';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->upload->do_upload("nav_img");
		#获取图片的相关信息
		$file = $this->upload->data();
			
		if ($file['image_width'] > 350) {
		
			//
		
		}
			
		if ($file['image_height'] > 300) {
		
			//
		
		}
			
		$nav['nav_img'] = $file['raw_name'].$file['file_ext'];
			
		$this->aiwifi->comm_instert('navigator', $nav);
		redirect('/union/user', 'refresh');	
	}
	
	// Edit user profile.
	public function profile(){
		
		$this->load->helper('aiwifi');
		
		// Get session language type.
		$lang_type = $this->session->userdata('lang_type');
		
		if (empty($lang_type) || $lang_type == 1) {
        	
        	$this->lang->load('aiwifi', 'chinese');
        	$data['lang_type'] = 1;
        	
        }else if ($lang_type == 2) {
        	
        	$this->lang->load('aiwifi', 'english');
        	$data['lang_type'] = 2;
        	
        }else if ($lang_type == 3) {
        	
        	$this->lang->load('aiwifi', 'japanese');
        	$data['lang_type'] = 3;
        	
        }else if ($lang_type == 4) {
        	
        	$this->lang->load('aiwifi', 'korean');
        	$data['lang_type'] = 4;
        	
        }
		
		$data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
        $uid = $this->session->userdata('uid');
        
        $data['userinfo'] = $this->aiwifi->comm_info('user', 'uid', $uid);
        
        $this->load->view('user_profile_edit',$data);
		
	}
	
	// Submit user profile modified
	public function profile_submit(){
		
		$user['nickname'] = $this->input->post('nickname');
		$user['email'] = $this->input->post('email');
		$uid = $this->session->userdata('uid');
		
		$this->aiwifi->comm_update('user', $user, 'uid', $uid);
		// Update seesion
		$this->session->set_userdata(array('nickname' => $user['nickname']));
		
		echo 1;
		
	}
	
	// Passwd change
	public function passwd(){
		
		$this->load->helper('aiwifi');
		
		// Get session language type.
		$lang_type = $this->session->userdata('lang_type');
		
		if (empty($lang_type) || $lang_type == 1) {
        	
        	$this->lang->load('aiwifi', 'chinese');
        	$data['lang_type'] = 1;
        	
        }else if ($lang_type == 2) {
        	
        	$this->lang->load('aiwifi', 'english');
        	$data['lang_type'] = 2;
        	
        }else if ($lang_type == 3) {
        	
        	$this->lang->load('aiwifi', 'japanese');
        	$data['lang_type'] = 3;
        	
        }else if ($lang_type == 4) {
        	
        	$this->lang->load('aiwifi', 'korean');
        	$data['lang_type'] = 4;
        	
        }
		
		$data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
        $uid = $this->session->userdata('uid');
        
        $this->load->view('user_passwd',$data);
		
	}
	
	// Passwd submit and change it.
	public function passwd_submit(){
		
		$old = md5( $this->input->post('passwd_now') );
		$now = md5( $this->input->post('passwd') );
		$uid = $this->session->userdata('uid');
		
		$check_old = $this->aiwifi->comm_check('user', array('uid' => $uid, 'passwd' => $old));
		
		if (empty($check_old)) {
			
			echo 0;
			
		}else{
			
			$this->aiwifi->comm_update('user', array('passwd' => $now), 'uid', $uid);
			
			// Change user passwd, Call API.
			// ---------------------------------------------------------------------------------------- Start Here
			$this->load->helper('aiwifi');
			$user = $this->aiwifi->comm_info('user', 'uid', $uid);
			//include_once APPPATH.'libraries/client.php';
			//radius_change_password($user['phone'], $this->input->post('passwd'));
			// ---------------------------------------------------------------------------------------- End Here
			
			echo 1;
		}
	}
	
	//用户购买服务
	public function upgrade(){
		
		$this->load->helper('aiwifi');
		
		// Get session language type.
		$lang_type = $this->session->userdata('lang_type');
		
		if (empty($lang_type) || $lang_type == 1) {
			 
			$this->lang->load('aiwifi', 'chinese');
			$data['lang_type'] = 1;
			 
		}else if ($lang_type == 2) {
			 
			$this->lang->load('aiwifi', 'english');
			$data['lang_type'] = 2;
			 
		}else if ($lang_type == 3) {
			 
			$this->lang->load('aiwifi', 'japanese');
			$data['lang_type'] = 3;
			 
		}else if ($lang_type == 4) {
			 
			$this->lang->load('aiwifi', 'korean');
			$data['lang_type'] = 4;
			 
		}
		
		$data['base'] = $this->config->item('base_url');
		$data['source'] = $data['base'].'source/';
		$uid = $this->session->userdata('uid');
		
		//取得收费服务列表 [LiBin]
		$data['payService'] = $this->aiwifi->getPayService();
        //换页面
        $data['clickService'] = $this->upgrade_click();
        $case = $this->aiwifi->comm_list('service_case');
        foreach($data['payService'] as $key => $value){
            foreach($case as $k=>$v){
                if($value['id'] == $v['case_id']){
                    $data['payService'][$key]['ad_num'] = $v['ad_num'];
                }
            }
        }
        $type = intval($_GET['type']);
        if($type == "1"){
            $this->load->view('upgrade_step_click',$data);
        }else{
            $this->load->view('upgrade_step_one',$data);
        }
//		$this->load->view('upgrade_step_one',$data);
	}
    //返回点击广告升级的方案
    private function upgrade_click(){
        $case = $this->aiwifi->comm_list('service_case');
        $server = $this->aiwifi->comm_list('service');
        $server_case = array();
        foreach($case as $value){
            foreach($server as $k => $v){
                if($value['case_id'] == $v['id']){
                    $server[$k]['ad_num'] = $value['ad_num'];
                    $server_case[] = $server[$k];
                }
            }
        }
        return $server_case;
    }
    //点击进入
    public function upgrade_after(){
        $data['title'] = htmlspecialchars($_GET['title']);
        $data['o'] = htmlspecialchars($_GET['o']);
        $data['id'] = htmlspecialchars($_GET['id']);
        $this->load->helper('aiwifi');
        // Get session language type.
        $lang_type = $this->session->userdata('lang_type');

        if (empty($lang_type) || $lang_type == 1) {

            $this->lang->load('aiwifi', 'chinese');
            $data['lang_type'] = 1;

        }else if ($lang_type == 2) {

            $this->lang->load('aiwifi', 'english');
            $data['lang_type'] = 2;

        }else if ($lang_type == 3) {

            $this->lang->load('aiwifi', 'japanese');
            $data['lang_type'] = 3;

        }else if ($lang_type == 4) {

            $this->lang->load('aiwifi', 'korean');
            $data['lang_type'] = 4;

        }
        $this->load->helper('aiwifi');
        $data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
        $uid = $this->session->userdata('uid');
        $this->load->view('upgrade_step_after',$data);
    }
	
	// User upgrage to second step.
	public function upgrade_select_payment() {
		
		$type = $this->input->post('type');
		
		$this->load->helper('aiwifi');
		
		// Get session language type.
		$lang_type = $this->session->userdata('lang_type');
		
		if (empty($lang_type) || $lang_type == 1) {
		
			$this->lang->load('aiwifi', 'chinese');
			$data['lang_type'] = 1;
		
		}else if ($lang_type == 2) {
		
			$this->lang->load('aiwifi', 'english');
			$data['lang_type'] = 2;
		
		}else if ($lang_type == 3) {
		
			$this->lang->load('aiwifi', 'japanese');
			$data['lang_type'] = 3;
		
		}else if ($lang_type == 4) {
		
			$this->lang->load('aiwifi', 'korean');
			$data['lang_type'] = 4;
		
		}
		
		$data['base'] = $this->config->item('base_url');
		$data['source'] = $data['base'].'source/';
		$uid = $this->session->userdata('uid');
		
		$this->load->view('upgrade_step_two',$data);
		
	}

}

/* End of file index.php in the controllers*/
