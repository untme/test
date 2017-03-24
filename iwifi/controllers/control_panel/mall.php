<?php
/**
 * Mall 
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
class Mall extends CI_Controller {

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
		$data['nav_title'] = '商家信息列表';
		$data['path'] = '商家信息列表';
		// List all questions with language type.
		$data['total_store'] = $this->aiwifi->comm_num('mall');
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
		$data['malls'] = $this->aiwifi
			->comm_list_where(
					'mall',
					array(),
					$config['per_page'],
					$this->uri->segment(4),
					'pk_mall',
					'DESC'
					);
		$this->load->view('control_panel/shop/shop_list', $data);
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

		$this->load->view('control_panel/shop/shop_new', $data);

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
		$mall = array();
		try{
			$logo = $this->mupload->upload($this->config->item('base_url'), 'logo', false);
			$mall['logo'] = current($logo);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$mall['logo'] = false;	
			}else{
				throw $e;	
			}
		}
		
		try{
			$topad = $this->mupload->upload($this->config->item('base_url'), 'topad', true);
			$mall['topad'] = $topAd;
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$mall['topad'] = array();	
			}else{
				throw $e;	
			}
		}
		
		try{
			$focus = $this->mupload->upload($this->config->item('base_url'), 'focus', true);
			$mall['focus'] = $focus;	
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$mall['focus'] = array();	
			}else{
				throw $e;	
			}
		}
		$mall['name'] = $this->input->post('name');	
		$this->load->library('pinyin');
		$pinyin = $this->pinyin->getPinyin($mall['name'], 'UTF-8', true);
		$mall['pinyin'] = $pinyin;
		$mall['porder'] = $this->input->post('porder');	
		$mall['address'] = $this->input->post('address');	
		$mall['servername'] = $this->input->post('servername');	
		$mall['telephone'] = $this->input->post('telephone');	
		$mall['description'] = $this->input->post('description');
        $mall['dname'] = $this->input->post('dname');
		$mall['citybus'] = $this->input->post('citybus');
        $mall['cbname'] = $this->input->post('cbname');
		$mall['freebus'] = $this->input->post('freebus');	
        $mall['fbname'] = $this->input->post('fbname');
		$mall['park'] = $this->input->post('park');	
        $mall['pkname'] = $this->input->post('pkname');
		$mall['location'] = $this->input->post('location');	
		$mall['bgcolor'] = $this->input->post('bgColor');	
		$mall['txtbgcolor'] = $this->input->post('txtBgColor');
		$mall['adtitle'] = $this->input->post('adtitle');	
		$mall['adetitle'] = $this->input->post('adetitle');		
		$mall['malltitle'] = $this->input->post('malltitle');	
		$mall['floortip'] = $this->input->post('floortip');	
		$mall['brandqy'] = $this->input->post('brandqy');	
		$mall['freenet'] = $this->input->post('freenet');	
		$mall['focus'] = json_encode($mall['focus']);
		$mall['topad'] = json_encode($mall['topad']);		
		$focus_url_new = (array)$this->input->post('focus_url');
		$mall['focus_open'] = array(5=>0,4=>0);
		if(intval($this->input->post('focus_5'))==1){
		    $mall['focus_open'][5] = 1;
		}
		if(intval($this->input->post('focus_4'))==1){
		    $mall['focus_open'][4] = 1;
		}
		$mall['focus_open'] = json_encode($mall['focus_open']);
		$mall['focus_url'] = array();
		foreach($focus_url_new as $k=>$url){
			$mall['focus_url'][$k]=$url;
		}
		$mall['topad_url'] = array();	
		$topad_url_new = (array)$this->input->post('topad_url');
		foreach($topad_url_new as $k=>$url){
			$mall['topad_url'][$k]=$url;
		}
		$mall['focus_url'] = json_encode($mall['focus_url']);	
		$mall['topad_url'] = json_encode($mall['topad_url']);
		$this->aiwifi->comm_instert('mall', $mall);
		$mallId = mysql_insert_id();
		redirect('/control_panel/mall/index/', 'refresh');
	}

	/**
	 * editForm 
	 * 展示编辑商场信息的表单
	 *
	 * @access public
	 * @return void
	 */
	public function editForm($mallID){
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			$data['base'] = $this->config->item('base_url');
	        $data ['source'] = $data ['base'].'source/';
	    	$data['title'] = "后台管理系统 - Aiwifi";
	    	$data['nav_title'] = '修改商家信息';
	    	$data['path'] = '修改商家信息';
	    	//GET PUSH INFO
            $mallPushAr = $this->aiwifi->comm_list_where('push', array('pk_mall'=>$mallID, 'starttime <='=>time()), 1, 0, 'starttime', 'DESC');
       
     if(is_array($mallPushAr) && count($mallPushAr)>0){
				$pushBrand = current($mallPushAr);
				$data['pushBrand'] = $pushBrand;
			}else{
                $data['pushBrand'] = array('pk_brand'=>False, 'bname'=>False, 'starttime'=>False);
            }
            
	    	// Get store info
	    	$data['mall'] = $this->aiwifi->comm_info('mall', 'pk_mall', $mallID);
            $data['mall']['focus_5'] = 0;
            $data['mall']['focus_4'] = 0;
            if($data['mall']['focus_open']){
                $data['mall']['focus_open'] = json_decode($data['mall']['focus_open'], true);
                if(isset($data['mall']['focus_open'][5]) && $data['mall']['focus_open'][5]==1){
                    $data['mall']['focus_5'] = 1;
                }
                if(isset($data['mall']['focus_open'][4]) && $data['mall']['focus_open'][4]==1){
                    $data['mall']['focus_4'] = 1;
                }
            }
	    	(!empty($data['mall']['focus'])) && $data['mall']['focus'] = json_decode($data['mall']['focus'], true);
	    	(!empty($data['mall']['focus_url'])) && $data['mall']['focus_url'] = json_decode($data['mall']['focus_url'], true);
	    	(!empty($data['mall']['topad'])) && $data['mall']['topad'] = json_decode($data['mall']['topad'], true);
			(!empty($data['mall']['topad_url'])) && $data['mall']['topad_url'] = json_decode($data['mall']['topad_url'], true);
	    	$this->load->view('control_panel/shop/shop_edit', $data);
		}
		
	}

	public function processEditForm($mallID){
		$this->load->library('mupload');
		$mall = array();
		try{
			$logo = $this->mupload->upload($this->config->item('base_url'), 'logo', false);
			$mall['logo'] = current($logo);
		}catch(UploadException $e){
			if($e->getCode() ==  40006){
				$mall['logo'] = $this->input->post('old_logo');	
			}else{
				throw $e;	
			}
		}
		try{
			$mall['focus'] = urldecode($this->input->post('old_focus'));
			(!empty($mall['focus'])) && $mall['focus']=json_decode($mall['focus'], true);
			$focus = $this->mupload->upload($this->config->item('base_url'), 'focus', true);
			foreach($focus as $k=>$v){
					$mall['focus'][$k] = $v;	
			}	
		}catch(UploadException $e){
			if($e->getCode() !=  40006){
				throw $e;	
			}
		}
		
		try{
			$mall['topad'] = urldecode($this->input->post('old_topad'));
			(!empty($mall['topad'])) && $mall['topad']=json_decode($mall['topad'], true);
			$topad = $this->mupload->upload($this->config->item('base_url'), 'topad', true);
			foreach($topad as $k=>$v){
					$mall['topad'][$k] = $v;	
			}	
		}catch(UploadException $e){
			if($e->getCode() !=  40006){
				throw $e;	
			}
		}
		$mall['name'] = $this->input->post('name');	
		$this->load->library('pinyin');
		$pinyin = $this->pinyin->getPinyin($mall['name'], 'UTF-8', true);
		$mall['pinyin'] = $pinyin;
		$mall['location'] = $this->input->post('location');	
		$mall['porder'] = $this->input->post('porder');	
		$mall['address'] = $this->input->post('address');	
		$mall['servername'] = $this->input->post('servername');	
		$mall['telephone'] = $this->input->post('telephone');	
		$mall['description'] = $this->input->post('description');
        $mall['dname'] = $this->input->post('dname');
		$mall['citybus'] = $this->input->post('citybus');
        $mall['cbname'] = $this->input->post('cbname');
		$mall['freebus'] = $this->input->post('freebus');	
        $mall['fbname'] = $this->input->post('fbname');
		$mall['park'] = $this->input->post('park');	
        $mall['pkname'] = $this->input->post('pkname');
		$mall['state'] = (int)$this->input->post('state');	
		$mall['bgcolor'] = $this->input->post('bgColor');	
		$mall['txtbgcolor'] = $this->input->post('txtBgColor');	
		$mall['adtitle'] = $this->input->post('adtitle');	
		$mall['adetitle'] = $this->input->post('adetitle');
		$mall['malltitle'] = $this->input->post('malltitle');	
		$mall['floortip'] = $this->input->post('floortip');	
		$mall['brandqy'] = $this->input->post('brandqy');	
		$mall['freenet'] = $this->input->post('freenet');	
		$mall['focus_url'] = array();	
		$focus_url_new = (array)$this->input->post('focus_url');
		foreach($focus_url_new as $k=>$url){
			$mall['focus_url'][$k]=$url;
		}
		$mall['topad_url'] = array();	
		$topad_url_new = (array)$this->input->post('topad_url');
		foreach($topad_url_new as $k=>$url){
			$mall['topad_url'][$k]=$url;
		}
		
		$mall['focus_open'] = array(5=>0,4=>0);
		if(intval($this->input->post('focus_5'))==1){
		    $mall['focus_open'][5] = 1;
		}
		if(intval($this->input->post('focus_4'))==1){
		    $mall['focus_open'][4] = 1;
		}
		$mall['focus_open'] = json_encode($mall['focus_open']);
		$mall['focus'] = json_encode($mall['focus']);
		$mall['topad'] = json_encode($mall['topad']);
		$mall['focus_url'] = json_encode($mall['focus_url']);	
		$mall['topad_url'] = json_encode($mall['topad_url']);
		$this->aiwifi->comm_update('mall', $mall, 'pk_mall', $mallID);
		$push['bname'] = $this->input->post('bname');
		$push['mname'] = $mall['name'];
		$push['pk_brand'] = $this->input->post('pk_brand');
		$push['pk_mall'] = $mallID;
		$push['starttime'] = $this->input->post('starttime');
		try{
			if(!empty($push['pk_brand']) && !empty($push['starttime'])){
				$push['starttime'] = strtotime($push['starttime']);
                $this->aiwifi->comm_delete('push', array('pk_mall' => $mallID, 'starttime'=>$push['starttime']));
				$this->aiwifi->comm_instert('push', $push);
			}
		}catch(Exception $e){
			
		}
		redirect('/control_panel/mall/index/', 'refresh');
	}

	// Delete this mall
	public function delete_mall($mallID) {
		$this->aiwifi->comm_delete('floor', array('aiwifi_mall_pk_mall' => $mallID));
		$this->aiwifi->comm_delete('brand', array('aiwifi_floor_aiwifi_mall_pk_mall' => $mallID));
		$this->aiwifi->comm_delete('activity', array('aiwifi_mall_pk_mall' => $mallID));
		$this->aiwifi->comm_delete('mall', array('pk_mall' => $mallID));
		echo '删除商家成功!';
	}	
}
