<?php

class Activity extends CI_Controller {
	private static $pnum = 5;		

	function __construct()
	{
		parent::__construct();
		
		//检测用户是否来自热点 [LiBin]
		$this->aiwifi->isFromHotspot();
		//if($this->config->item('local')) return true;
		// Check if user has already login.
        $user_login = $this->session->userdata('islog');
       
		// Check if user answer the questions.
        $user_ask = $this->session->userdata('ask');
		/*
        if ($user_login != 'true')
        {
        	redirect('/sign', 'refresh');
        }
        
        if ($user_ask != 'true') {
        	
        	redirect('/ask', 'refresh');
        }
		*/
	}
	
	private function getLangType(){
		$this->load->helper('aiwifi');
		// Get session language type.
		$lang_type = $this->session->userdata('lang_type');

		if (empty($lang_type) || $lang_type == 1) {

			$this->lang->load('aiwifi', 'chinese');
			$lang_type = 1;

		}else if ($lang_type == 2) {

			$this->lang->load('aiwifi', 'english');
			$lang_type = 2;

		}else if ($lang_type == 3) {

			$this->lang->load('aiwifi', 'japanese');
			$lang_type = 3;

		}else if ($lang_type == 4) {

			$this->lang->load('aiwifi', 'korean');
			$lang_type = 4;

		}
		return $lang_type;		
	}

	// Sign up AND Sign in show page.
	public function alist($mallID, $page)
	{
		$this->load->library('pagination');

		$data['lang_type'] = $this->getLangType();
		$data['base'] = $this->config->item('base_url');
		$data['source'] = $data['base'].'source/';
		$uid = $this->session->userdata('uid');



		$data['aclist'] = $this->aiwifi->comm_list_where_and_in(
				'activity',
				array('aiwifi_mall_pk_mall'=>$mallID),
				'state',
				array(1,2),
				self::$pnum,
				$page,
				'state, pk_activity',
				'desc'
				);
		$data['actop'] = $this->aiwifi->comm_list_where(
				'activity',
				array('aiwifi_mall_pk_mall'=>$mallID, 'state'=>3),
				1,
				0,
				'mtime',
				'desc'
				);
		if(!empty($data['actop'])){
			$data['actop'] = array_shift($data['actop']);
			$data['actop']['focus'] = array_shift(json_decode($data['actop']['focus'], true));
		}
		// List all questions with language type.
		$config['total_rows'] = $this->aiwifi->comm_num_where_and_in(
				'activity',
				array('aiwifi_mall_pk_mall'=>$mallID),
				'state',
				array(1,2)
				);
		$this->load->library('pagination');
		$config['base_url'] = sprintf(
				'/union/activity/alist/%s/',
				$mallID
				);
		$config['per_page'] = self::$pnum;
		$config['uri_segment'] = 5;
		$config['num_links'] = 5;
		$config['anchor_class'] = 'class="page" ';
		$config['cur_tag_open'] = '<a class="page current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$this->pagination->initialize($config);
		//检测用户今天是否已经申请了试用20分钟服务 [LiBin]
		$uid = $this->session->userdata('phone'); //取得用户ID
		$data['trial'] = $this->aiwifi->isTrial20($uid);
		//取得当前会员的服务类型 [LiBin]
		$data['service'] = $this->aiwifi->getNowServiceByUserID($uid);
		$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $mallID);

		$this->load->view('union/activity/alist',$data);
	}

	public function index($mallID, $activityID){
		$data['lang_type'] = $this->getLangType();
		$data['base'] = $this->config->item('base_url');
		$data['source'] = $data['base'].'source/';
		$uid = $this->session->userdata('uid');

		// Get store info
		$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $mallID);
		$data['activity'] = $this->aiwifi->comm_info('activity', 'pk_activity', $activityID);
		if(!empty($data['activity']['focus'])){
			$data['activity']['focus'] = json_decode($data['activity']['focus'], true);
		}else{
			$data['activity']['focus'] = array();
		}

		$this->load->view('union/activity/index',$data);
	}
}
	/* End of file index.php in the controllers*/
