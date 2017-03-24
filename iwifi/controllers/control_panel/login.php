<?php

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();

        $checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.

        if ($checkAdmin == 'true') {
        
        	redirect('/control_panel/index/', 'refresh');
        	 
        }
        
	}
	
	/**
	 * 贝儿美图榜
	 * @位置  后台管理首页 -- 管理员登陆
	 */
	public function index() {
		
		$data ['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data ['title'] = '管理员登陆 - Aiwifi';
		
		if ($this->input->post ( 'action' ) == 'true') {
			
			$check['admin_name'] = $this->input->post('admin_name');
			$check['passwd'] = md5($this->input->post('passwd'));
			$check_admin = $this->aiwifi->comm_check('admin', $check);
			
			if (empty ( $check_admin )) {
				
				$data ['note'] = '<font color="red">输入的信息有误!</font>';
				$this->load->view ( 'control_panel/login', $data );
				
			}else{
				
				// If there is this admin, get his data and save them in session.
				$admin_info = $this->aiwifi->comm_info('admin', 'admin_name', $check['admin_name']);
				$sess['admin_name'] = $check['admin_name'];
				$sess['admin_id'] = $admin_info['admin_id'];
				$sess['admin_type'] = $admin_info['admin_type'];
				$sess['admin_islogin'] = 'true';
				
				$this->session->set_userdata ( $sess );
				redirect ( '/control_panel/index/', 'refresh' );
			}
		} else {
			
			$data ['note'] = '输入管理员邮箱和密码即可登陆到后台了!';
			
			$this->load->view ( 'control_panel/login', $data );
		}
	}

}

/* End of file home.php in the controllers*/
