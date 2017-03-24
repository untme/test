<?php
/**
 * App 
 * 商场相关的操作
 * 
 *
 * @uses CI
 * @uses _Controller
 * @package 
 * @version $id$
 * @copyright 2015-2015 The AIWIFI Group
 * @author houweiozng <houweizong@gmail.com> 
 */
class App extends CI_Controller {

	function __construct(){
		parent::__construct();

		//获取管理员是否后台登陆信息.
		$checkAdmin = $this->session->userdata('admin_islogin'); 

		if ($checkAdmin != 'true'){
			redirect('/control_panel/login/', 'refresh');
		}
	}


	/**
	 * index 
	 * 商场的后台列表首页
	 * 
	 *
	 * @access public
	 * @return void
	 */
	public function index(){
		$data['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data['title'] = "后台管理系统 - Aiwifi";
		$data['nav_title'] = 'App列表';
		$data['path'] = 'App列表';
		// List all questions with language type.
		$config['total_rows'] = $this->aiwifi->comm_num('app');
		$this->load->library('pagination');
		$config['base_url'] = sprintf(
				'%scontrol_panel/%s/%s/',
				$data['base'],
				strtolower(__class__),
				strtolower(__function__)
				);
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$config['anchor_class'] = 'class="number" ';
		$config['cur_tag_open'] = '<a class="number current">';
		$config['cur_tag_close'] = '</a>';
		$this->pagination->initialize($config);
		$data['apps'] = $this->aiwifi
			->comm_list_where(
					'app',
					array(),
					$config['per_page'],
					$this->uri->segment(4),
					'pk_app',
					'DESC'
					);
		$data += $this->config->item('app');
		$this->load->view('control_panel/app/app_list', $data);
	}

	/**
	 * addForm 
	 * 展示添加新商家的表单
	 *
	 * @access public
	 * @return void
	 */
	public function addForm(){
		$data['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data['title'] = "后台管理系统 - Aiwifi";
		$data['nav_title'] = '添加商家';
		$data['path'] = '添加商家';
		$data += $this->config->item('app');

		$this->load->view('control_panel/app/app_new', $data);

	}

	/**
	 * processAddForm 
	 * 处理添加商场的表单数据
	 *
	 * @access public
	 * @return void
	 */
	public function processAddForm(){
		$this->load->library('mupload');
		$app = array();
		try{
			$focus = $this->mupload->upload($this->config->item('base_url'), 'focus', false);
			$app['focus'] = current($focus);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$app['focus'] = false;	
			}else{
				throw $e;	
			}
		}
		
		$app['name'] = $this->input->post('name');	
		$app['porder'] = (int)$this->input->post('porder');	
		$app['type'] = (int)$this->input->post('type');	
		$app['description'] = $this->input->post('description');	
		$app['url'] = $this->input->post('url');	
		$app['state'] = (int)$this->input->post('state');	
		$app['pubtime'] = time();	
		$app['mtime'] = $app['pubtime'];	
		$this->aiwifi->comm_instert('app', $app);
		$appId = mysql_insert_id();
		redirect('/control_panel/app/index/', 'refresh');
	}

	/**
	 * editForm 
	 * 展示编辑商场信息的表单
	 *
	 * @access public
	 * @return void
	 */
	public function editForm($appID){
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			$data['base'] = $this->config->item('base_url');
	        $data ['source'] = $data ['base'].'source/';
	    	$data['title'] = "后台管理系统 - Aiwifi";
	    	$data['nav_title'] = '修改APP信息';
	    	$data['path'] = '修改APP信息';
			$data += $this->config->item('app');
	    	
	    	// Get store info
	    	$data['app'] = $this->aiwifi->comm_info('app', 'pk_app', $appID);
	    	$this->load->view('control_panel/app/app_edit', $data);
		}
		
	}

	public function processEditForm($appID){
		$this->load->library('mupload');
		$app = array();
		try{
			$focus = $this->mupload->upload($this->config->item('base_url'), 'focus', false);
			$app['focus'] = current($focus);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$app['focus'] = $this->input->post('old_focus');	
			}else{
				throw $e;	
			}
		}
		
		$app['name'] = $this->input->post('name');	
		$app['porder'] = (int)$this->input->post('porder');	
		$app['type'] = (int)$this->input->post('type');	
		$app['description'] = $this->input->post('description');	
		$app['url'] = $this->input->post('url');	
		$app['state'] = (int)$this->input->post('state');	
		$app['mtime'] = time();	
		$this->aiwifi->comm_update('app', $app, 'pk_app', $appID);
		//redirect('/control_panel/app/editForm/'.$appID, 'refresh');
		redirect('/control_panel/app/index/', 'refresh');
	}
	
	// Delete this brand
	public function delete_app($appID) {
		$this->aiwifi->comm_delete('app', array('pk_app' => $appID));
		echo '删除品牌成功!';
	}
}
