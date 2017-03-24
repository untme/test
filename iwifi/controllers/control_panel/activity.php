<?php
/**
 * Activity 
 * 活动相关的操作
 * 
 *
 * @uses CI
 * @uses _Controller
 * @package 
 * @version $id$
 * @copyright 2015-2015 The AIWIFI Group
 * @author houweiozng <houweizong@gmail.com> 
 */
class Activity extends CI_Controller {

	function __construct(){
		parent::__construct();

		//获取管理员是否后台登陆信息.
		$checkAdmin = $this->session->userdata('admin_islogin'); 

		if ($checkAdmin != 'true'){
			redirect('/control_panel/login/', 'refresh');
		}
		$admin_type = $this->session->userdata('admin_type');
        	(!_auth($admin_type, 'super'))&&(!_auth($admin_type, 'shop'))&& show_404();
	}

	private function getBrand(){
		$tmp = $this->aiwifi->comm_list_order('mall', 'pinyin, pk_mall', 'ASC');
		foreach($tmp as $k=>$v){
			$p = substr($v['pinyin'], 0, 1);
			if(!isset($tmp[$p])) $tmp[$p] = array();
			array_unshift($tmp[$p], $v);
			unset($tmp[$k]);
		}
		return $tmp;
	}
	
	/**
	 * index 
	 * 活动的后台列表首页
	 * 
	 *
	 * @access public
	 * @return void
	 */
	public function index(){
		$data['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data['title'] = "后台管理系统 - Aiwifi";
		$data['nav_title'] = '商家活动列表';
		$data['path'] = '商家活动列表';
		// List all questions with language type.
		$data['total_store'] = $this->aiwifi->comm_num('activity');
		$this->load->library('pagination');
		$config['base_url'] = sprintf(
				'%scontrol_panel/%s/%s/',
				$data['base'],
				strtolower(__class__),
				strtolower(__function__)
				);
		$config['total_rows'] = $data['total_store'];
		$config['per_page'] = 15;
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$config['anchor_class'] = 'class="number" ';
		$config['cur_tag_open'] = '<a class="number current">';
		$config['cur_tag_close'] = '</a>';
		$this->pagination->initialize($config);
		$data['activity'] = $this->aiwifi
			->comm_list_where(
					'activity',
					array(),
					$config['per_page'],
					$this->uri->segment(4),
					'pk_activity',
					'DESC'
					);
		$mallIDs = $mall = array();
		foreach($data['activity'] as $item){
			array_push($mallIDs, $item['aiwifi_mall_pk_mall']);	
		}
		$mallIDs = array_unique($mallIDs);
		if(!empty($mallIDs)){
			$mall = $this->aiwifi
				->comm_list_where_in(
						'mall',
						'pk_mall',
						$mallIDs,
						count($mallIDs),
						0,
						'pk_mall'
						);
			foreach($mall as $k=>$item){
					unset($k);
					$mall[$item['pk_mall']] = $item;
			}
		}
		$data['mall'] = $mall;	
				
		$this->load->view('control_panel/activity/activity_list', $data);
	}

	/**
	 * addForm 
	 * 展示添加新活动的表单
	 *
	 * @access public
	 * @return void
	 */
	public function addForm(){
		$data['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data['title'] = "后台管理系统 - Aiwifi";
		$data['nav_title'] = '添加活动';
		$data['path'] = '添加活动';
		$data['mallList'] = $this->getBrand();
		
		$this->load->view('control_panel/activity/activity_new', $data);

	}

	/**
	 * processAddForm 
	 * 处理添加活动的表单数据
	 *
	 * @access public
	 * @return void
	 */
	public function processAddForm(){
		$this->load->library('mupload');
		$activity = array();
		try{
			$activity['focus'] = array();	
			$focus = $this->mupload->upload($this->config->item('base_url'), 'focus', true);
			$activity['focus'] = $focus;	
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$activity['focus'] = array();	
			}else{
				throw $e;	
			}
		}
		$activity['name'] = $this->input->post('name');	
		$activity['state'] = $this->input->post('state');	
		$activity['pubtime'] = time();	
		$activity['mtime'] = $activity['pubtime'];	
		$activity['aiwifi_mall_pk_mall'] = $this->input->post('aiwifi_mall_pk_mall');	
		$activity['porder'] = $this->input->post('porder');	
		$activity['description'] = $this->input->post('description');	
		$activity['focus'] = json_encode($activity['focus']);	
		$this->aiwifi->comm_instert('activity', $activity);
		$mallId = mysql_insert_id();
		redirect('/control_panel/activity/index/', 'refresh');
	}

	/**
	 * editForm 
	 * 展示编辑商场信息的表单
	 *
	 * @access public
	 * @return void
	 */
	public function editForm($activityID){
		$action = $this->input->post('action');

		if (empty($action)) {

			$data['base'] = $this->config->item('base_url');
			$data ['source'] = $data ['base'].'source/';
			$data['title'] = "后台管理系统 - Aiwifi";
			$data['nav_title'] = '修改活动信息';
			$data['path'] = '修改活动信息';
			$data['mallList'] = $this->getBrand();
			
			// Get store info
			$data['activity'] = $this->aiwifi->comm_info('activity', 'pk_activity', $activityID);
			if(!empty($data['activity']['focus'])){
				$data['activity']['focus'] = json_decode($data['activity']['focus'], true);
			}else{
				$data['activity']['focus'] = array();
			}
			$this->load->view('control_panel/activity/activity_edit', $data);
		}

	}

	public function processEditForm($activityID){
		$this->load->library('mupload');
		$activity = array();
		try{
			$activity['focus'] = urldecode($this->input->post('old_focus'));
			(!empty($activity['focus'])) && $activity['focus']=json_decode($activity['focus'], true);
			$focus = $this->mupload->upload($this->config->item('base_url'), 'focus', true);
			foreach($focus as $k=>$v){
				$activity['focus'][$k] = $v;	
			}	
		}catch(UploadException $e){
			if($e->getCode() !=  40006){
				throw $e;	
			}
		}
		$activity['name'] = $this->input->post('name');	
		$activity['state'] = $this->input->post('state');	
		$activity['mtime'] = time();	
		$activity['aiwifi_mall_pk_mall'] = $this->input->post('aiwifi_mall_pk_mall');	
		$activity['porder'] = $this->input->post('porder');	
		$activity['description'] = $this->input->post('description');	
		$activity['focus'] = json_encode($activity['focus']);	
		$this->aiwifi->comm_update('activity', $activity, 'pk_activity', $activityID);
		//redirect('/control_panel/activity/editForm/'.$activityID, 'refresh');
		redirect('/control_panel/activity/index/', 'refresh');
	}
	
	// Delete this brand
	public function delete_activity($activityID) {
		$this->aiwifi->comm_delete('activity', array('pk_activity' => $activityID));
		echo '删除品牌成功!';
	}
}
