<?php

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.

        if ($checkAdmin != 'true')
        {
        	redirect('/control_panel/login/', 'refresh');
        }
	}

    /**
     * @位置 后台 用户管理中心.
    */
	public function index()
	{
        // Check admin type, if this admin type is not 1 they can not view.
        $admin_type = $this->session->userdata('admin_type');
        (!_auth($admin_type, 'super')) && show_404();
		
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '管理员列表';
    	$data['path'] = '全部管理员列表';
    	
    	$data['admins'] = $this->aiwifi->comm_list('admin');

    	$this->load->view('control_panel/admin/admin_list', $data);
	}
	
	// Add new admin form html
	public function new_admin_form (){
        $admin_type = $this->session->userdata('admin_type');
        (!_auth($admin_type, 'super')) && show_404();
	
		$data ['base'] = $this->config->item('base_url');
	
		$this->load->view('control_panel/admin/new_admin', $data);
	
	}
	
	// Add new admin insert into database.
	public function adding_admin(){
        $admin_type = $this->session->userdata('admin_type');
        (!_auth($admin_type, 'super')) && show_404();
		
		$admin['admin_name'] = $this->input->post('newAdminName');
		$admin['admin_email'] = $this->input->post('newAdminEmail');
		$admin['admin_type'] = $this->input->post('newAdminType');
		$admin['passwd'] = md5( $this->input->post('newAdminPasswd') );
		
		$this->aiwifi->comm_instert('admin', $admin);
		
		echo 1;
		
	}
	
	// Edit admin...
	public function edit_admin_all ($admin_id){
        $admin_type = $this->session->userdata('admin_type');
        (!_auth($admin_type, 'super')) && show_404();
		
		$data ['base'] = $this->config->item('base_url');
		$data['admin_info'] = $this->aiwifi->comm_info('admin', 'admin_id', $admin_id);
		
		$this->load->view('control_panel/admin/edit_admin', $data);
	}
	
	// Update admin info...
	public function editing_admin_info(){
        $admin_type = $this->session->userdata('admin_type');
        (!_auth($admin_type, 'super')) && show_404();
		
		$admin_id = $this->input->post('editAdminID');
		$admin['admin_name'] = $this->input->post('editAdminName');
		$admin['admin_email'] = $this->input->post('editAdminEmail');
		$admin['admin_type'] = $this->input->post('editAdminType');
		$passwd = md5( $this->input->post('editAdminPasswd') );
		if(!empty($passwd)) {
			
			$admin['passwd'] = $passwd;
			
		}
		
		$this->aiwifi->comm_update('admin', $admin, 'admin_id', $admin_id);
		
		echo 1;
		
	}
	
	// Delete this admin
	public function del_admin(){
        $admin_type = $this->session->userdata('admin_type');
        (!_auth($admin_type, 'super')) && show_404();
		
		$admin_id = $this->input->post('admin_id');
		
		$this->aiwifi->comm_del('admin', 'admin_id', $admin_id);
		
		echo 1;
		
	}
	
	/**
	 * @位置 后台 用户管理中心. Edit current admin info.
	*/
	public function admin_edit (){
        $admin_type = $this->session->userdata('admin_type');
        (!_auth($admin_type, 'super')) && show_404();
		
		$data ['base'] = $this->config->item('base_url');
		$admin_id = $this->session->userdata('admin_id');
		$data['admin'] = $this->aiwifi->comm_info('admin', 'admin_id', $admin_id);
		
		$this->load->view('control_panel/admin/admin_info_edit', $data);
		
	}
	
	// Post to edit admin info
	public function admin_edit_doing (){
        $admin_type = $this->session->userdata('admin_type');
        (!_auth($admin_type, 'super')) && show_404();
	
		$admin_id = $this->input->post('admin_id');
		$admin['admin_name'] = $this->input->post('admin_name');
		$admin['admin_email'] = $this->input->post('admin_email');
		$passwd = md5( urldecode( $this->input->post('passwd') ) );
		
		if(!empty($passwd)) {
			
			$admin['passwd'] = $passwd;
		}
		
		$this->aiwifi->comm_update('admin', $admin, 'admin_id', $admin_id);
		
		// Update session info
		$this->session->set_userdata ( 'admin_name', $admin['admin_name']);
		
		echo "管理员信息已经成功更改! 3秒后页面将刷新一下!";
	
	}

}

/* End of file home.php in the controllers*/
