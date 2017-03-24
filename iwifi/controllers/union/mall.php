<?php

class Mall extends CI_Controller {

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

        /*if ($user_login != 'true')
        {
        	redirect('/sign', 'refresh');
        }
        
        if ($user_ask != 'true') {
        	
        	redirect('/ask', 'refresh');
        }*/
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
	public function index($mallID)
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
      
		
	  
        // Get store data information.
	
		$mallPushAr = $this->aiwifi->comm_list_where('push', array('pk_mall'=>$mallID, 'starttime <='=>time()), 1, 0, 'starttime', 'desc');
     header('debug:'.json_encode($mallPushAr));
    	if(is_array($mallPushAr) && count($mallPushAr)>0){
			$mallPush = current($mallPushAr);
			$pushBrand = $this->aiwifi->comm_info('brand', 'pk_brand', $mallPush['pk_brand']);
		}
		$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $mallID);
		if($data['mall']){
			if(!empty($data['mall']['topad'])){
				$data['mall']['topad'] = json_decode($data['mall']['topad'], true);
			}else{
				$data['mall']['topad'] = array();
			}
			if(isset($pushBrand)){
				$pic = $pushBrand['hrad'];
        header('debug:'.json_encode($mallPushAr));
        array_unshift($data['mall']['topad'], $pic);
				$data['mall']['topad'] = array_slice($data['mall']['topad'], 0, 3);
			}
			if(!empty($data['mall']['focus'])){
				$data['mall']['focus'] = json_decode($data['mall']['focus'], true);
$data['mall']['focus_open'] = $data['mall']['focus_open']?json_decode($data['mall']['focus_open'], true):array(5=>0, 4=>0);
if($data['mall']['focus_open'][5]==0){
	unset($data['mall']['focus'][4]);
} 
if($data['mall']['focus_open'][4]==0){
	unset($data['mall']['focus'][3]);
} 
			}else{
				$data['mall']['focus'] = array();
			}
			if(isset($pushBrand)){
				$pic = $pushBrand['focus'];
				array_unshift($data['mall']['focus'], $pic);
				$data['mall']['focus'] = array_slice($data['mall']['focus'], 0, 5);
			}
			if(!empty($data['mall']['focus_url'])){
				$data['mall']['focus_url'] = json_decode($data['mall']['focus_url'], true);
			}else{
				$data['mall']['focus_url'] = array();
			}
			if(isset($pushBrand)){
				$url = '/union/brand/detail/'. $pushBrand['pk_brand'];
				array_unshift($data['mall']['focus_url'], $url);
				$data['mall']['focus_url'] = array_slice($data['mall']['focus_url'], 0, 5);
			}
			if(!empty($data['mall']['topad_url'])){
				$data['mall']['topad_url'] = json_decode($data['mall']['topad_url'], true);
			}else{
				$data['mall']['topad_url'] = array();
			}
			if(isset($pushBrand)){
				$url = '/union/brand/detail/'. $pushBrand['pk_brand'];
				array_unshift($data['mall']['topad_url'], $url);
				$data['mall']['topad_url'] = array_slice($data['mall']['topad_url'], 0, 3);
			}
		}

		$data['activity'] = $this->aiwifi->comm_list_where('activity', array('aiwifi_mall_pk_mall'=> $mallID, "state"=>2), 5, 0, 'pk_activity', 'DESC');
		if(count($data['activity']) < 3){
			$num = 3-count($data['activity']);
			$com = $this->aiwifi->comm_list_where('activity', array('aiwifi_mall_pk_mall'=> $mallID, "state"=>1), $num, 0, 'pk_activity', 'DESC');
			$data['activity'] = array_merge($data['activity'], $com);		
		}
		//检测用户今天是否已经申请了试用20分钟服务 [LiBin]
		$uid = $this->session->userdata('phone'); //取得用户ID
		$data['trial'] = $this->aiwifi->isTrial20($uid);
		ob_clean();
		$this->load->view('union/mall/index',$data);
	}

	public function info($mallID, $t=1){
		$type = array(
					0 => 'description',
					1 => 'citybus',
					2 => 'freebus',
					3 => 'park',
				);
		$t = isset($type[$t])?$type[$t]:$type[1];
		$data['lang_type'] = $this->getLangType();
		$data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
        $uid = $this->session->userdata('uid');
		$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $mallID);
		$data['content'] = $data['mall'][$t];
		$type = array_flip($type);
		$t = $type[$t];
		$data['pk_mall'] = $mallID;
		$this->load->view('union/mall/info_'.$t,$data);
	}

	public function floor($mallID, $floorID=0){
		$data['lang_type'] = $this->getLangType();
		$data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
		$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $mallID);
		$data['tmp'] = $this->aiwifi->comm_list_where('floor', array('aiwifi_mall_pk_mall'=> $mallID), 20, 0, 'floornum', 'ASC');
		$data['floor'] = array();
		$data['config'] = $this->config->item('floor');
		if(!empty($data['tmp'])){
			foreach($data['tmp'] as $v){
				$data['floor'][$v['pk_floor']] = $v;
			}
		}
		unset($data['tmp']);
		if((!$floorID) || !isset($data['floor'][$floorID])){
			$content = current($data['floor']);
		}else{
			$content = $data['floor'][$floorID];
		}
		$data['content'] = $content;
		$this->load->view('union/mall/floor',$data);
	}

}

/* End of file index.php in the controllers*/
