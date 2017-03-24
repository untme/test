<?php

class Navigator extends CI_Controller {

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
    	$data['nav_title'] = '会员导航链接管理';
    	$data['path'] = '会员导航链接管理';
    	// List default navigator list with page navigation.
    	$data['total_nav'] = $this->aiwifi->comm_number('navigator', array('default' => 1));
    	$this->load->library('pagination');
    	$config['base_url'] = $data['base'].'control_panel/navigator/index/';
    	$config['total_rows'] = $data['total_nav'];
    	$config['per_page'] = 30;
    	$config['uri_segment'] = 4;
    	$config['num_links'] = 5;
    	$config['anchor_class'] = 'class="number" ';
    	$config['cur_tag_open'] = '<a class="number current">';
    	$config['cur_tag_close'] = '</a>';
    	$this->pagination->initialize($config);
    	$data['nav'] = $this->aiwifi->comm_list_where('navigator', array('default' => 1), $config['per_page'],$this->uri->segment(4), 'nav_sort', 'ASC');
    	
    	$this->load->view('control_panel/navigator/nav_list', $data);
		
	}
	
	// Add a new navigator.
	public function new_nav(){
		
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			$data['base'] = $this->config->item('base_url');
			$data ['source'] = $data ['base'].'source/';
			$data['title'] = "后台管理系统 - Aiwifi";
			$data['nav_title'] = '添加新导航链接';
			$data['path'] = '添加新导航链接';
			
			$this->load->view('control_panel/navigator/nav_new', $data);
			
		}else{
			
			$nav['nav_title'] = $this->input->post('nav_title');
			$nav['nav_link'] = $this->input->post('nav_link');
			$nav['nav_sort'] = $this->input->post('nav_sort');
			$nav['default'] = 1;
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
			redirect('/control_panel/navigator/index/', 'refresh');
			
		}
		
		
	}
	
	// Modify this link...
	public function modify_nav($nav_id){
		
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			$data['base'] = $this->config->item('base_url');
			$data ['source'] = $data ['base'].'source/';
			$data['title'] = "后台管理系统 - Aiwifi";
			$data['nav_title'] = '添加新导航链接';
			$data['path'] = '添加新导航链接';
			// Get this navigator infomation
			$data['navinfo'] = $this->aiwifi->comm_info('navigator', 'nav_id', $nav_id);
			
			$this->load->view('control_panel/navigator/nav_modify', $data);
			
		}else{
			
			$nav['nav_title'] = $this->input->post('nav_title');
			$nav['nav_link'] = $this->input->post('nav_link');
			$nav['nav_sort'] = $this->input->post('nav_sort');
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
			
			if (!empty($file['raw_name'])){
				
				$nav['nav_img'] = $file['raw_name'].$file['file_ext'];
				
			}
			
			
			$this->aiwifi->comm_update('navigator', $nav, 'nav_id', $nav_id);
			redirect('/control_panel/navigator/index/', 'refresh');
			
		}
		
	}
	
	// Delete this navigator.
	public function delete_nav(){
		
		$nav_id = $this->input->post('nav_id');
		
		$this->aiwifi->comm_delete('navigator', array('nav_id' => $nav_id));
		
		echo '该链接已经成功删除!';
		
	}

}

/* End of file home.php in the controllers*/