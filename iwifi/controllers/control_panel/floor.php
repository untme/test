<?php
/**
 * Floor 
 * 楼层相关的操作,应该叫做floor，只是被占用了。
 * 
 *
 * @uses CI
 * @uses _Controller
 * @package 
 * @version $id$
 * @copyright 2015-2015 The AIWIFI Group
 * @author houweiozng <houweizong@gmail.com> 
 */
class Floor extends CI_Controller {

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
	 * 楼层的后台列表首页
	 * 
	 *
	 * @access public
	 * @return void
	 */
	public function index(){
		$data['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data['title'] = "后台管理系统 - Aiwifi";
		$data['nav_title'] = '楼层列表';
		$data['path'] = '楼层列表';
		// List all questions with language type.
		$data['total_rows'] = $this->aiwifi->comm_num('floor');
		$config['total_rows'] = $this->aiwifi->comm_num('floor');
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
		$data['floors'] = $this->aiwifi
			->comm_list_where(
					'floor',
					array(),
					$config['per_page'],
					$this->uri->segment(4),
					'pk_floor',
					'DESC'
					);
		$mallIDs = $mall = array();
		foreach($data['floors'] as $item){
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
				
		$data = array_merge($data, $this->config->item('floor'));
		$this->load->view('control_panel/floor/floor_list', $data);
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
		$data['nav_title'] = '添加楼层';
		$data['path'] = '添加楼层';
		$data = array_merge($data, $this->config->item('floor'));
		$data['mallList'] = $this->getBrand();
		$this->load->view('control_panel/floor/floor_new', $data);

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
		$floor = array();
		try{
			$floor['map'] = array();	
			$map = $this->mupload->upload($this->config->item('base_url'), 'map', true);
			$floor['map'] = $map;	
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$floor['map'] = array();	
			}else{
				throw $e;	
			}
		}
		$floor['name'] = $this->input->post('name');	
		$floor['state'] = $this->input->post('state');	
		$floor['floornum'] = $this->input->post('floornum');	
		$floor['pubtime'] = time();	
		$floor['mtime'] = $floor['pubtime'];	
		$floor['aiwifi_mall_pk_mall'] = $this->input->post('aiwifi_mall_pk_mall');	
		$floor['porder'] = $this->input->post('porder');	
		$floor['detail'] = $this->input->post('detail');	
		$floor['map'] = json_encode($floor['map']);	
		$funpt = $this->input->post('funpt');
		$store_address = $this->input->post('store_address');
	        $ad = compact('funpt', 'store_address');	
		$floor['ad'] = json_encode($ad);
		$this->aiwifi->comm_instert('floor', $floor);
		$mallId = mysql_insert_id();
 	
		redirect('/control_panel/floor/index/', 'refresh');
	}

	/**
	 * editForm 
	 * 展示编辑商场信息的表单
	 *
	 * @access public
	 * @return void
	 */
	public function editForm($floorID){
		$action = $this->input->post('action');

		if (empty($action)) {

			$data['base'] = $this->config->item('base_url');
			$data ['source'] = $data ['base'].'source/';
			$data['title'] = "后台管理系统 - Aiwifi";
			$data['nav_title'] = '修改楼层信息';
			$data['path'] = '修改楼层信息';
			$data['mallList'] = $this->getBrand();
			// Get store info
			$data['floor'] = $this->aiwifi->comm_info('floor', 'pk_floor', $floorID);
			if(!empty($data['floor']['map'])){
				$data['floor']['map'] = json_decode($data['floor']['map'], true);
			}else{
				$data['floor']['map'] = array();
			}
			$data['floor']['ad'] = json_decode($data['floor']['ad'], true);
			$data = array_merge($data, $this->config->item('floor'));
			$this->load->view('control_panel/floor/floor_edit', $data);
		}

	}

	public function processEditForm($floorID){
		$this->load->library('mupload');
		$floor = array();
		try{
			$floor['map'] = urldecode($this->input->post('old_map'));
			(!empty($floor['map'])) && $floor['map']=json_decode($floor['map'], true);
			$map = $this->mupload->upload($this->config->item('base_url'), 'map', true);
			foreach($map as $k=>$v){
				$floor['map'][$k] = $v;	
			}	
		}catch(UploadException $e){
			if($e->getCode() !=  40006){
				throw $e;	
			}
		}
		$floor['name'] = $this->input->post('name');	
		$floor['state'] = $this->input->post('state');	
		$floor['floornum'] = $this->input->post('floornum');	
		$floor['mtime'] = time();	
		$floor['aiwifi_mall_pk_mall'] = $this->input->post('aiwifi_mall_pk_mall');	
		$floor['porder'] = $this->input->post('porder');	
		$floor['detail'] = $this->input->post('detail');	
		$floor['map'] = json_encode($floor['map']);	
		$funpt = $this->input->post('funpt');
		$store_address = $this->input->post('store_address');
	        $ad = compact('funpt', 'store_address');	
		$floor['ad'] = json_encode($ad);
		$this->aiwifi->comm_update('floor', $floor, 'pk_floor', $floorID);
		//redirect('/control_panel/floor/editForm/'.$floorID, 'refresh');
		redirect('/control_panel/floor/index/', 'refresh');
	}

	// Delete this brand
	public function delete_floor($floorID) {
		$this->aiwifi->comm_delete('floor', array('pk_floor' => $floorID));
		echo '删除品牌成功!';
	}

	public function getfloors($mallID){
		$list = $this->aiwifi->comm_list_where('floor', array('aiwifi_mall_pk_mall'=>$mallID, 'state'=>1), 100, 0, 'pk_floor');
		echo C::toJson($list);
	}
}
