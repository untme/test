<?php

class Brand extends CI_Controller {
	static $pnum = 6;

	function __construct()
	{
		parent::__construct();
		
		//检测用户是否来自热点 [LiBin]
		$this->aiwifi->isFromHotspot();
		
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
	
	public function search($mallID){
		$data['lang_type'] = $this->getLangType();
		$data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
        $uid = $this->session->userdata('uid');
		$like = array('name'=>'');
		$where = array();
		$query = $this->uri->segment(5);
		$query = urldecode($query);
		$args = explode('_', $query);
		if(count($args)<3){
			exit('查询不合法');
		}else{
			$type = $args[0];	
			$floor = $args[1];
			$key = implode('_', array_splice($args, 2));
		}
		if($type){
			$where['type'] = $type;
		}
		if($floor){
			$where['aiwifi_floor_pk_floor'] = $floor;
		}
		if($key){
			$like['name'] = $key;
		}

		$data += $this->config->item('floor');
		$data['actop'] = $this->aiwifi->comm_list_where(
				'activity',
				array('aiwifi_mall_pk_mall'=>$mallID, 'state'=>4),
				1,
				0,
				'mtime',
				'desc'
				);
		if(!empty($data['actop'])){
			$data['actop'] = array_shift($data['actop']);
			$data['actop']['focus'] = array_shift(json_decode($data['actop']['focus'], true));
		}	
		if(!$key){
			$mallPushAr = $this->aiwifi->comm_list_where('push', array('pk_mall'=>$mallID, 'starttime <='=>time()), 1, 0, 'starttime', 'desc');
			if(is_array($mallPushAr) && count($mallPushAr)>0){
				$mallPush = current($mallPushAr);
				$pushBrand = $this->aiwifi->comm_info('brand', 'pk_brand', $mallPush['pk_brand']);
        $where['pk_brand !='] = $pushBrand['pk_brand'];
			  if($this->uri->segment(6) == 0){
            self::$pnum -= 1;  
        }
        }
		}
		$where['aiwifi_floor_aiwifi_mall_pk_mall'] = $mallID; 
		$data['brands'] = $this->aiwifi->comm_like_where(
				'brand',
				$like,
				$where,
				'pk_brand',
				'desc',
				self::$pnum,
				$this->uri->segment(6)
				);
			  if($this->uri->segment(6) == 0 && isset($pushBrand)){
            array_unshift($data['brands'], $pushBrand);  
        }
		$data['where'] = $where;
		$data['like'] = $like;
		/////////////////////////////////////////////////////////////////////////////////
		// List all questions with language type.
		$config['total_rows'] = $this->aiwifi->comm_num_like_where(
				'brand',
				$like,
				$where
				);

		$this->load->library('pagination');
		$config['base_url'] = sprintf(
				'/union/brand/search/%s/%s',
				$mallID,
				$this->uri->segment(5)
				);
		$config['per_page'] = self::$pnum;
		$config['uri_segment'] = 6;
		$config['num_links'] = 5;
		$config['anchor_class'] = 'class="page" ';
		$config['cur_tag_open'] = '<a class="page current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$this->pagination->initialize($config);
		$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $mallID);
		$floorList = $this->aiwifi->comm_list_where('floor', array('aiwifi_mall_pk_mall'=>$mallID, 'state'=>1), 100, 0, 'pk_floor');
		$floorNumMap=array();
		foreach($floorList as $v){
			$floorNumMap[$v['pk_floor']] = $v['name'];
		}	
		$data['floorNumMap'] = $floorNumMap;
		/////////////////////////////////////////////////////////////////////////////////
		$this->load->view('/union/brand/search',$data);
	}

	public function index($mallID,$page=1){	
		$data['lang_type'] = $this->getLangType();
		$data['base'] = $this->config->item('base_url');
		$data['source'] = $data['base'].'source/';
		$uid = $this->session->userdata('uid');
		$data += $this->config->item('floor');
		$like = array('name'=>'%');
		$where = array();
		$query = $this->uri->segment(5);
		$query = urldecode($query);
		$args = explode('_', $query);
		if(count($args)<=3){
			exit('查询不合法');
		}else{
			$type = $args[0];	
			$floor = $args[1];
			$key = implode('_', $args, 2);
		}
		if($type){
			$where['type'] = $type;
		}
		if($floor){
			$where['floor'] = $floor;
		}
		if($key){
			$like['name'] = '%'.$key.'%';
		}


		$data['actop'] = $this->aiwifi->comm_list_where(
				'activity',
				array('aiwifi_mall_pk_mall'=>$mallID, 'state'=>4),
				1,
				0,
				'mtime',
				'desc'
				);
		if(!empty($data['actop'])){
			$data['actop'] = array_shift($data['actop']);
			$data['actop']['focus'] = array_shift(json_decode($data['actop']['focus'], true));
		}
		$data['brands'] = $this->aiwifi->comm_list_where(
				'brand',
				array('aiwifi_floor_aiwifi_mall_pk_mall'=>$mallID),
				self::$pnum,
				$page,
				'pk_brand',
				'desc'
				);
		/////////////////////////////////////////////////////////////////////////////////
		// List all questions with language type.
		$config['total_rows'] = $this->aiwifi->comm_num_list_where(
				'brand',
				array('aiwifi_floor_aiwifi_mall_pk_mall'=>$mallID)
				);
		$this->load->library('pagination');
		$config['base_url'] = sprintf(
				'/union/brand/index/%s/',
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
		/////////////////////////////////////////////////////////////////////////////////
		$this->load->view('/union/brand/index',$data);
	}

	public function detail($BrandID){

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
		$data['ad'] = 0;
		$data['base'] = $this->config->item('base_url');
		$data['source'] = $data['base'].'source/';
		$uid = $this->session->userdata('uid');
		$data['brand'] = $this->aiwifi->comm_info('brand', 'pk_brand', $BrandID);
    $mallID = $data['brand']['aiwifi_floor_aiwifi_mall_pk_mall'];
		$mallPushAr = $this->aiwifi->comm_list_where('push', array('pk_mall'=>$mallID, 'starttime <='=>time()), 1, 0, 'starttime', 'DESC');
		if(is_array($mallPushAr) && count($mallPushAr)>0){
				$mallPush = current($mallPushAr);
				$pushBrand = $this->aiwifi->comm_info('brand', 'pk_brand', $mallPush['pk_brand']);
				if($pushBrand['pk_brand']==$BrandID){
					$data['ad'] = 1;
				}
			}
		$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $data['brand']['aiwifi_floor_aiwifi_mall_pk_mall']);

		$this->load->view('union/brand/detail.html',$data);
	}

}

/* End of file index.php in the controllers*/
