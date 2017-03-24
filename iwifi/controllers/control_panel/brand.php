<?php
/**
 * Brand 
 * 品牌相关的操作
 * 
 *
 * @uses CI
 * @uses _Controller
 * @package 
 * @version $id$
 * @copyright 2015-2015 The AIWIFI Group
 * @author houweiozng <houweizong@gmail.com> 
 */
class Brand extends CI_Controller {

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

	private function getMall(){
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
	 * 品牌的后台列表首页
	 * 
	 *
	 * @access public
	 * @return void
	 */
	public function index(){
		$data['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data['title'] = "后台管理系统 - Aiwifi";
		$data['nav_title'] = '商家品牌列表';
		$data['path'] = '商家品牌列表';
		// List all questions with language type.
		$data = array_merge($data, $this->config->item('floor'));
		$data = array_merge($data, $this->config->item('brand'));
		$config['total_rows'] = $this->aiwifi->comm_num('brand');
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
		$data['brand'] = $this->aiwifi
			->comm_list_where(
					'brand',
					array(),
					$config['per_page'],
					$this->uri->segment(4),
					'pk_brand',
					'DESC'
					);
		$mallIDs = $floorIDs = $activityIDs = array();
		foreach($data['brand'] as $item){
			$item['aiwifi_floor_pk_floor'] && array_push($floorIDs, $item['aiwifi_floor_pk_floor']);
			$item['aiwifi_floor_aiwifi_mall_pk_mall'] && array_push($mallIDs, $item['aiwifi_floor_aiwifi_mall_pk_mall']);
			$item['aiwifi_activity_pk_activity'] && array_push($activityIDs, $item['aiwifi_activity_pk_activity']);
		}
		$mallIDs = array_unique($mallIDs);
		$floorIDs = array_unique($floorIDs);
		$activityIDs = array_unique($activityIDs);
		if(!empty($mallIDs)){
			$mall = $this->aiwifi->comm_list_where_in(
					'mall',
					'pk_mall',
					$mallIDs,
					count($mallIDs),
					0,
					'pk_mall'
					);
			foreach($mall as $k=>$item){
				unset($mall[$k]);
				$mall[$item['pk_mall']] = $item;
			}
			$data['mall'] = $mall;
		}else{
			$data['mall'] = array();
		}
		if(!empty($activityIDs)){
			$activity = $this->aiwifi->comm_list_where_in(
					'activity',
					'pk_activity',
					$activityIDs,
					count($activityIDs),
					0,
					'pk_activity'
					);
			foreach($activity as $k=>$item){
				unset($activity[$k]);
				$activity[$item['pk_mall']] = $item;
			}
			$data['activity'] = $activity;
		}else{
			$data['activity'] = array();
		}
		if(!empty($floorIDs)){
			$floor = $this->aiwifi->comm_list_where_in(
					'floor',
					'pk_floor',
					$floorIDs,
					count($floorIDs),
					0,
					'pk_floor'
					);
			foreach($floor as $k=>$item){
				unset($floor[$k]);
				$floor[$item['pk_floor']] = $item;
			}
			$data['floor'] = $floor;
		}else{
			$data['floor'] = array();
		}
		$this->load->view('control_panel/brand/brand_list', $data);
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
		$data['nav_title'] = '添加品牌';
		$data['path'] = '添加品牌';
		$data['mallList'] = $this->getMall();
		$group = current($data['mallList']);
		$data = array_merge($data, $this->config->item('brand'));
		$data = array_merge($data, $this->config->item('floor'));
		if($group){
			$mall = current($group);
			$floorList = $this->aiwifi->comm_list_where('floor', array('aiwifi_mall_pk_mall'=>$mall['pk_mall'], 'state'=>1), 100, 0, 'pk_floor');
			$floorNumMap=array();
			foreach($floorList as $v){
				$floorNumMap[$v['pk_floor']] = $v['name'];
			}	
			$data['floorNumMap'] = $floorNumMap;
		}		
		$this->load->view('control_panel/brand/brand_new', $data);

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
		$brand = array();
		try{
			$logo = $this->mupload->upload($this->config->item('base_url'), 'logo', false);
			$brand['logo'] = current($logo);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$brand['logo'] = false;	
			}else{
				throw $e;	
			}
		}
		try{
			$focus = $this->mupload->upload($this->config->item('base_url'), 'focus', false);
			$brand['focus'] = current($focus);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$brand['focus'] = false;	
			}else{
				throw $e;	
			}
		}
		try{
			$hrad = $this->mupload->upload($this->config->item('base_url'), 'hrad', false);
			$brand['hrad'] = current($hrad);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$brand['hrad'] = false;	
			}else{
				throw $e;	
			}
		}
		$brand['name'] = $this->input->post('name');
		$brand['pubtime'] = time();	
		$brand['state'] = (int)$this->input->post('state');	
		$brand['mtime'] = $brand['pubtime'];			
		$brand['porder'] = $this->input->post('porder');	
		$brand['description'] = $this->input->post('description');	
		$brand['detail'] = $this->input->post('detail');
		$brand['action_detail'] = $this->input->post('action_detail');
		$brand['aiwifi_floor_pk_floor'] = $this->input->post('aiwifi_floor_pk_floor');
		$brand['aiwifi_floor_aiwifi_mall_pk_mall'] = $this->input->post('aiwifi_floor_aiwifi_mall_pk_mall');
		$brand['type'] = $this->input->post('type');
		$this->aiwifi->comm_instert('brand', $brand);
		$brandID = mysql_insert_id();
		redirect('/control_panel/brand/index/', 'refresh');
	}

	/**
	 * editForm 
	 * 展示编辑商场信息的表单
	 *
	 * @access public
	 * @return void
	 */
	public function editForm($brandID){
		$action = $this->input->post('action');

		if (empty($action)) {

			$data['base'] = $this->config->item('base_url');
			$data ['source'] = $data ['base'].'source/';
			$data['title'] = "后台管理系统 - Aiwifi";
			$data['nav_title'] = '修改品牌信息';
			$data['path'] = '修改品牌信息';
			$data = array_merge($data, $this->config->item('brand'));
			$data = array_merge($data, $this->config->item('floor'));
			$data['mallList'] = $this->getMall();
			// Get store info
			$data['brand'] = $this->aiwifi->comm_info('brand', 'pk_brand', $brandID);
			if($data['brand']['aiwifi_floor_pk_floor']){
				$data['floor'] = $this->aiwifi->comm_info('floor', 'pk_floor', $data['brand']['aiwifi_floor_pk_floor']);
				$mallID = $data['brand']['aiwifi_floor_aiwifi_mall_pk_mall'];
				$data['floorList'] = $this->aiwifi->comm_list_where('floor', array('aiwifi_mall_pk_mall'=>$mallID, 'state'=>1), 100, 0, 'pk_floor');
				$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $data['brand']['aiwifi_floor_aiwifi_mall_pk_mall']);
			}else{
				$data['floor'] = array();
				$mallID = $data['brand']['aiwifi_floor_aiwifi_mall_pk_mall'];
				$data['floorList'] = $this->aiwifi->comm_list_where('floor', array('aiwifi_mall_pk_mall'=>$mallID, 'state'=>1), 100, 0, 'pk_floor');
				$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $data['brand']['aiwifi_floor_aiwifi_mall_pk_mall']);
			}
			if($data['brand']['aiwifi_activity_pk_activity']){
				$data['activity'] = $this->aiwifi->comm_info('activity', 'pk_activity', $date['brand']['aiwifi_activity_pk_activity']);
			}else{
				$data['activity'] = array();
			}
			$this->load->view('control_panel/brand/brand_edit', $data);
		}

	}

	public function processEditForm($brandID){
		$this->load->library('mupload');
		$brand = array();
		try{
			$logo = $this->mupload->upload($this->config->item('base_url'), 'logo', false);
			$brand['logo'] = current($logo);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$brand['logo'] = $this->input->post('old_logo');	
			}else{
				throw $e;	
			}
		}
		try{
			$focus = $this->mupload->upload($this->config->item('base_url'), 'focus', false);
			$brand['focus'] = current($focus);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$brand['focus'] = $this->input->post('old_focus');	
			}else{
				throw $e;	
			}
		}
		try{
			$hrad = $this->mupload->upload($this->config->item('base_url'), 'hrad', false);
			$brand['hrad'] = current($hrad);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$brand['hrad'] = $this->input->post('old_hrad');	
			}else{
				throw $e;	
			}
		}
		$brand['name'] = $this->input->post('name');	
		$brand['state'] = (int)$this->input->post('state');	
		$brand['porder'] = $this->input->post('porder');	
		$brand['description'] = $this->input->post('description');	
		$brand['detail'] = $this->input->post('detail');
		$brand['action_detail'] = $this->input->post('action_detail');
		$brand['mtime'] = time();
		$brand['aiwifi_floor_pk_floor'] = $this->input->post('aiwifi_floor_pk_floor');
		$brand['aiwifi_floor_aiwifi_mall_pk_mall'] = $this->input->post('aiwifi_floor_aiwifi_mall_pk_mall');
		$brand['type'] = $this->input->post('type');
		$this->aiwifi->comm_update('brand', $brand, 'pk_brand', $brandID);
		//redirect('/control_panel/brand/editForm/'.$brandID, 'refresh');
		redirect('/control_panel/brand/index/', 'refresh');
	}

	// Delete this brand
	public function delete_brand($brandID) {
		$this->aiwifi->comm_delete('brand', array('pk_brand' => $brandID));
		echo '删除品牌成功!';
	}
	
	
	public function searchBrand($mall, $name){
		$name = urldecode($name);
		$brand = $this->aiwifi->comm_like_where('brand', array('name'=>$name), array('aiwifi_floor_aiwifi_mall_pk_mall'=>$mall), 'pk_brand', 'DESC', 1000, 0);
		C::toJson($brand);
	}

}
