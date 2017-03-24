<?php

class Ask extends CI_Controller {

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
        
        if($user_ask == 'true'){
        	//redirect('/user', 'refresh');
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
        $uid = (int)$this->session->userdata('uid');
        //取得所有session
		$session = $this->session->all_userdata();
		$data['nickname'] = $session['nickname'];
		
        // Get adertisement for this page.
        $data['ad'] = $this->aiwifi->get_advertisement($data['lang_type'], 3);
        
		//今天是否已经回答过问题,如果答过题就不用再答题了，如果没有答过题，就输出问题。
		$user = C::T('aiwifi_user')->getr("uid=$uid");
		if(date('Y-m-d',strtotime($user['lastAskTime']))==date('Y-m-d')){
			$data['question'] = array();
		}else{
			$data['question'] = $this->aiwifi->get_ask_questions($data['lang_type'],$uid);
			//print_r($data['question']);exit;
		}
		
		//暂停问题功能
		$data['question'] = array();
		
		$this->load->view('ask',$data);
		
	}
	
	// Submit ask questions and answers
	public function submit_ask (){
		
		$post_data = $this->input->post();
		$question_number = count($post_data);
		$uid = (int)$this->session->userdata('uid');
		
		for ($i = 1; $i <= $question_number; $i++){
			
			if ( is_array($post_data['question_'.$i]) ) {
				
				$aunit = array();
				// If this one is an array.
				for ($n = 0; $n < count($post_data['question_'.$i]); $n++) {
					
					$ids = explode('_', $post_data['question_'.$i][$n]);
					$aq_id = $ids[1];
					// Get this answer's count number.
					$aa_number = $this->aiwifi->comm_value_where('ask_answer', array('aa_id' => $ids[0]), 'aa_count');
					// Update new number
					$this->aiwifi->comm_update('ask_answer', array('aa_count' => $aa_number+1), 'aa_id', $ids[0]);
					// Pust this value to $aunit array
					//array_push($aunit, $ids[0]);
					$aunit[$n] = $ids[0];
					
				}
				
				// Make $aunit as a string.
				$aaids = implode(',', $aunit);
				
				// Insert into user log database.
				$this->aiwifi->comm_instert('ask_user_log', array('uid' => $uid, 'aq_id' => $aq_id, 'aa_id' => $aaids));
				
			}else{
				
				// If this value is not an array. Get queation and answer's ID
				$ids = explode('_', $post_data['question_'.$i]);
				// Get this answer's record number.
				$aa_number = $this->aiwifi->comm_value_where('ask_answer', array('aa_id' => $ids[0]), 'aa_count');
				// Update new number
				$this->aiwifi->comm_update('ask_answer', array('aa_count' => $aa_number+1), 'aa_id', $ids[0]);
				// Add new record into ask_user_log table.
				$this->aiwifi->comm_instert('ask_user_log', array('uid' => $uid, 'aq_id' => $ids[1], 'aa_id' => $ids[0]));
				
			}
			
		}
		
		// Add a session to ensure user asked
		$this->session->set_userdata(array('ask' => 'true'));
		
		//保存 [答题时间]
		db::table('aiwifi_user')->update("uid=$uid",array('lastAskTime'=>date('Y-m-d H:i:s')));
		//取得会员信息
		$user = $this->aiwifi->comm_info('user', 'uid', $uid);
		/*
		// Connect to Internet, Call API.
		// ---------------------------------------------------------------------------------------- Start Here
		$this->load->helper('aiwifi');
		include_once APPPATH.'libraries/client.php';
		radius_logon($user['phone'],$this->session->userdata('temp_passwd'));
		$this->session->unset_userdata('temp_passwd');
		// ---------------------------------------------------------------------------------------- End Here
		*/
		
		// Go to User navigation page.
		//redirect('/user', 'refresh');
		
		//[LiBin]
		$this->toHotspotLogin();
	}
	
	// Go to Internet
	public function go(){
		
		$uid = $this->session->userdata('uid');
		$this->session->set_userdata(array('ask' => 'true'));
		
		/*
		// Connect to Internet, Call API.
		// ---------------------------------------------------------------------------------------- Start Here
		$this->load->helper('aiwifi');
		$user = $this->aiwifi->comm_info('user', 'uid', $uid);
		include_once APPPATH.'libraries/client.php';
		radius_logon($user['phone'],$this->session->userdata('temp_passwd'));
		$this->session->unset_userdata('temp_passwd');
		// ---------------------------------------------------------------------------------------- End Here
		*/
		
		//redirect('/user', 'refresh');
		
		//[LiBin]
		$this->toHotspotLogin();
	}
	
	//去Hotspot服务器登录 [LiBin]
	public function toHotspotLogin()
	{
		//取得Hotspot服务器信息
		$data['hotspot'] = $this->aiwifi->Hotspot();
		
		//取得当前登录的用户信息
		$uid = $this->session->userdata('uid');
		$data['user'] = $this->aiwifi->comm_info('user','uid',$uid);
		
		$this->load->view('toHotspotLogin',$data);
	}

}

/* End of file index.php in the controllers*/
?>