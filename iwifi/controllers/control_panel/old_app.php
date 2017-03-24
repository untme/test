<?php
ob_clean();
class App extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.

        if ($checkAdmin != 'true')
        {
        	redirect('/control_panel/login/', 'refresh');
        }
	}

	
	// List of all store 
	public function index(){
		
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = 'APP下载列表';
    	$data['path'] = 'APP下载列表';
    	// List all questions with language type.
    	$data['total_store'] = $this->aiwifi->comm_num('store');
    	$this->load->library('pagination');
    	$config['base_url'] = $data['base'].'control_panel/shop/index/';
    	$config['total_rows'] = $data['total_store'];
    	$config['per_page'] = 30;
    	$config['uri_segment'] = 5;
    	$config['num_links'] = 5;
    	$config['anchor_class'] = 'class="number" ';
    	$config['cur_tag_open'] = '<a class="number current">';
    	$config['cur_tag_close'] = '</a>';
    	$this->pagination->initialize($config);
    	$data['stores'] = $this->aiwifi->comm_list_where('store', array(), $config['per_page'],$this->uri->segment(5), 'store_id', 'DESC');
    	
    	$this->load->view('control_panel/app/app_list', $data);
		
	}
	
	// Add new store page.
	public function new_app_show(){
		
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '添加APP下载';
    	$data['path'] = '添加APP下载';
    	
    	$this->load->view('control_panel/app/app_new', $data);
		
	}
	
	// store basic infomation received.
	public function store_basic_new(){
		
		$store['store_name'] = $this->input->post('store_name');
		$store['store_location'] = $this->input->post('store_location');
		$store['store_address'] = $this->input->post('store_address');
		$store['store_tel'] = $this->input->post('store_tel');
		$store['store_descript'] = $this->input->post('store_descript');
		$store['store_mac_one'] = $this->input->post('store_mac_one');
		$store['store_mac_two'] = $this->input->post('store_mac_two');
		$store['status'] = (int)$this->input->post('status');
		$this->aiwifi->comm_instert('store', $store);
		$store_id = mysql_insert_id();
		redirect('/control_panel/store/store_modify/'.$store_id, 'refresh');
	}
	
	// store modify page.
	public function store_modify($store_id){
		
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			$data['base'] = $this->config->item('base_url');
	        $data ['source'] = $data ['base'].'source/';
	    	$data['title'] = "后台管理系统 - Aiwifi";
	    	$data['nav_title'] = '修改商家信息';
	    	$data['path'] = '修改商家信息';
	    	
	    	// Get store info
	    	$data['store'] = $this->aiwifi->comm_info('store', 'store_id', $store_id);
	    	
	    	$this->load->view('control_panel/store/store_modify', $data);
	    	
		}else{
			
			$store['store_name'] = $this->input->post('store_name');
			$store['store_location'] = $this->input->post('store_location');
			$store['store_address'] = $this->input->post('store_address');
			$store['store_tel'] = $this->input->post('store_tel');
			$store['store_descript'] = $this->input->post('store_descript');
			$store['store_mac_one'] = $this->input->post('store_mac_one');
			$store['store_mac_two'] = $this->input->post('store_mac_two');
			$store['status'] = (int)$this->input->post('status');
			$this->aiwifi->comm_update('store', $store, 'store_id', $store_id);
			
			redirect('/control_panel/store/store_modify/'.$store_id, 'refresh');
			
		}
		
	}
	
	// Upload store pics for these.
	public function store_upload($store_id, $item){
		
		if (! is_dir ( 'data/store/' . $store_id . '/' )) {
			mkdir ( 'data/store/' . $store_id . '/' );
		}
		
		// Upload picture to server.
		$save_path = './data/store/' . $store_id ;
		$config['upload_path'] = $save_path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '5120';
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		
		if ($item == 'banner') {
			
			
			$this->upload->do_upload("store_banner");
			
			
		}else if ($item == 'logo') {
			
			$this->upload->do_upload("store_logo");
			
		}else if ($item == 'map_big') {
			
			$this->upload->do_upload("store_map_big");
			
		}else if ($item == 'map_middle') {
			
			$this->upload->do_upload("store_map_middle");
			
		}else if ($item == 'map_small') {
			
			$this->upload->do_upload("store_map_small");
			
		}
		
		#获取图片的相关信息
		$file = $this->upload->data();
		
		if (empty($file['file_ext'])) {
			
			redirect('/control_panel/store/store_modify/'.$store_id, 'refresh');
			
		}else{
			
			$store['store_'.$item] = $store_id . '/' . $file['raw_name'].$file['file_ext'];
			
			$this->aiwifi->comm_update('store', $store, 'store_id', $store_id);
			redirect('/control_panel/store/store_modify/'.$store_id, 'refresh');
		}
		
	}
	
	// Map json data handle.
	public function map_json_data($type){
		
		$store_id = $this->input->post('store_id');
		$map_data = $this->input->post('map_data');
		
		// Make up to a json format to save into database.		
		for ($i = 0; $i < count($map_data); $i++) {
			
			$mapd[$i] = json_decode($map_data[$i]);
			
		}
		
		$saveData =  json_encode($mapd);
		
		if ($type == 'big') {
			
			$this->aiwifi->comm_update('store', array('store_map_big_json' => $saveData), 'store_id', $store_id);
			
		}else if ($type == 'middle') {
			
			$this->aiwifi->comm_update('store', array('store_map_middle_json' => $saveData), 'store_id', $store_id);
			
		}else if ($type == 'small') {
			
			$this->aiwifi->comm_update('store', array('store_map_small_json' => $saveData), 'store_id', $store_id);
			
		}
		
		echo '保存成功!';
		
	}
	
	// Delete this store
	public function delete_store() {
		
		$store_id = $this->input->post('store_id');
		
		$this->aiwifi->comm_delete('store', array('store_id' => $store_id));
		
		echo '删除商家成功!';
		
	}
	
	// 招牌 Management
	public function shop_sign($store_id){
		
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '商家展示列表';
    	$data['path'] = '商家展示列表';
    	$data['store_id'] = $store_id;
    	
    	$data['sign'] = $this->aiwifi->comm_list_where('store_sign', array('store_id' => $store_id), 100, 0, 'sign_id', 'DECS');
    	
    	$this->load->view('control_panel/store/store_sign_list', $data);
		
	}
	
	// Delete sign .
	public function delete_sign(){
		
		$sign_id = $this->input->post('sign_id');
		
		$this->aiwifi->comm_delete('store_sign', array('sign_id' => $sign_id));
		
		echo '删除商家展示图片成功!';
		
	}
	
	// Add new sign
	public function new_sign($store_id){
		
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			$data['base'] = $this->config->item('base_url');
	        $data ['source'] = $data ['base'].'source/';
	    	$data['title'] = "后台管理系统 - Aiwifi";
	    	$data['nav_title'] = '添加商家展示';
	    	$data['path'] = '添加商家展示';
	    	$data['store_id'] = $store_id;
	    	
	    	$this->load->view('control_panel/store/store_sign_new', $data);
			
		}else{
			
			$sign['sign_word'] = $this->input->post('sign_word');
			
			if (! is_dir ( 'data/store/' . $store_id . '/' )) {
				mkdir ( 'data/store/' . $store_id . '/' );
			}
			
			// Upload picture to server. small
			$save_path = './data/store/' . $store_id ;
			$config['upload_path'] = $save_path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '5120';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload("sign_small");
			#获取图片的相关信息
			$file_small = $this->upload->data();
			
			$sign['sign_small'] = $store_id . '/' . $file_small['raw_name'].$file_small['file_ext'];
			
			// Upload picture to server. big
			$save_path = './data/store/' . $store_id ;
			$config['upload_path'] = $save_path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '5120';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload("sign_big");
			#获取图片的相关信息
			$file_big = $this->upload->data();
				
			$sign['sign_big'] = $store_id . '/' . $file_big['raw_name'].$file_big['file_ext'];
			
			$sign['store_id'] = $store_id; 
			
			$this->aiwifi->comm_instert('store_sign', $sign);
			
			redirect('/control_panel/store/shop_sign/'.$store_id, 'refresh');
			
		}
		
	}
	
	// Add new sign
	public function modify_sign($store_id, $sign_id){
	
		$action = $this->input->post('action');
	
		if (empty($action)) {
				
			$data['base'] = $this->config->item('base_url');
			$data ['source'] = $data ['base'].'source/';
			$data['title'] = "后台管理系统 - Aiwifi";
			$data['nav_title'] = '修改商家展示';
			$data['path'] = '修改商家展示';
			$data['store_id'] = $store_id;
			$data['sign'] = $this->aiwifi->comm_info('store_sign', 'sign_id', $sign_id);
	
			$this->load->view('control_panel/store/store_sign_modify', $data);
				
		}else{
				
			$sign['sign_word'] = $this->input->post('sign_word');
				
			if (! is_dir ( 'data/store/' . $store_id . '/' )) {
				mkdir ( 'data/store/' . $store_id . '/' );
			}
				
			// Upload picture to server. small
			$save_path = './data/store/' . $store_id ;
			$config['upload_path'] = $save_path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '5120';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload("sign_small");
			#获取图片的相关信息
			$file_small = $this->upload->data();
				
			if (!empty($file_small['file_ext'])) {
				
				$sign['sign_small'] = $store_id . '/' . $file_small['raw_name'].$file_small['file_ext'];
				
			}
			
				
			// Upload picture to server. big
			$save_path = './data/store/' . $store_id ;
			$config['upload_path'] = $save_path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '5120';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload("sign_big");
			#获取图片的相关信息
			$file_big = $this->upload->data();
	
			if (!empty($file_big['file_ext'])) {
				
				$sign['sign_big'] = $store_id . '/' . $file_big['raw_name'].$file_big['file_ext'];
				
			}
				
			$sign['store_id'] = $store_id;
				
			$this->aiwifi->comm_update('store_sign', $sign, 'sign_id', $sign_id);
				
			redirect('/control_panel/store/shop_sign/'.$store_id, 'refresh');
				
		}
	
	}
	
	// Comment show list page.
	public function comment_list($store_id){
		
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '评论列表';
    	$data['path'] = '评论列表';
    	#分页配置
    	$data['total_comment'] = $this->aiwifi->comm_number('comment', array('store_id' => $store_id) );
    	$this->load->library('pagination');
    	$config['base_url'] = $data['base'].'control_panel/store/comment_list/'.$store_id;
    	$config['total_rows'] = $data['total_comment'];
    	$config['per_page'] = 30;
    	$config['uri_segment'] = 5;
    	$config['num_links'] = 5;
    	$config['anchor_class'] = 'class="number" ';
    	$config['cur_tag_open'] = '<a class="number current">';
    	$config['cur_tag_close'] = '</a>';
    	$this->pagination->initialize($config);
    	$data['comments'] = $this->aiwifi->comm_list_where('comment', array('store_id' => $store_id), $config['per_page'],$this->uri->segment(5), 'comment_id', 'DESC');
    	
    	$this->load->view('control_panel/store/comment_list', $data);
		
	}
	
	// Delete this comment
	public function del_comment(){
		
		$comment_id = $this->input->post('comment_id');
		
		$this->aiwifi->comm_delete('comment', array('comment_id' => $comment_id));
		
		echo '删除这条评论成功!!';
		
	}
	
	// Check comment info
	public function view_comment($comment_id){
		
		$data['comment_info'] = $this->aiwifi->comm_info('comment', 'comment_id', $comment_id);
		$data['user'] = $this->aiwifi->comm_value_where('user', array('uid' => $data['comment_info']['uid']), 'nickname');
		
		$this->load->view('control_panel/store/comment_info', $data);
		
	}

}
