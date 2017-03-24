<?php

class Store extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}

    // Sign up AND Sign in show page.
	public function index($store_id)
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
		
		$store_id = (int)$store_id;
		$data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
        $uid = $this->session->userdata('uid');
        
        // Get adertisement for this page.
        $data['ad'] = $this->aiwifi->get_advertisement($data['lang_type'], 5);
        
        // Get store data information.
		if($store_id){
        	$data['store'] = $this->aiwifi->comm_info('store', 'store_id', $store_id);
		}else{
			$rs = $this->aiwifi->query("select * from aiwifi_store order by store_id limit 1");
			$data['store'] = $rs[0];
		}
        
        // Get store list pics
        $data['sign'] = $this->aiwifi->comm_list_where('store_sign', array('store_id' => $store_id), 100, 0, 'sign_id', 'ASC');
        
        // User if login
        $data['islog'] = $this->session->userdata('islog');
        
        // User comments
        $data['comment'] = $this->aiwifi->comm_list_where('comment', array('store_id' => $store_id), 100, 0, 'comment_id', 'DESC');
        
        // Relative Stores
        $data['store_relative'] = $this->aiwifi->get_relative_store($store_id);

		$this->load->view('store',$data);
		
	}
	
	// User Post comments
	public function comments(){
		
		$comment['uid'] = $this->session->userdata('uid');
		$comment['store_id'] = $this->input->post('store_id');
		$comment['content'] = $this->input->post('content');
		$comment['post_date'] = time();
		
		if (empty($comment['uid'])) {
			
			exit(0);
			
		}else{
			
			$this->aiwifi->comm_instert('comment', $comment);
		
			echo 1;
		}
		
		
		
	}

}

/* End of file index.php in the controllers*/
