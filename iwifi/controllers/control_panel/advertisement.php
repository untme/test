<?php

class Advertisement extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.
        if($checkAdmin != 'true'){
        	redirect('/control_panel/login/', 'refresh');
        }
	}
	
	//将广告ID从商家的登录验证图片列表中移除
	public function delToStore()
	{
		$data = $_REQUEST;
		$store_id = (int)$data['store_id'];
		$ids = is_array($data['ids'])?$data['ids']:array(); //广告ID列表
		if(empty($ids)){
			C::toJson(array('value'=>false,'text'=>'广告记录没有选中'));
		}
		if(!$store_id){
			C::toJson(array('value'=>false,'text'=>'商家不能为空！'));
		}
		
		$r = storeX::getById($store_id);
		$ads = array_unique(array_diff($r['loginPics'],$ids));
		rsort($ads);
		$value = json_encode($ads);
		$bool = storeX::update($store_id,'loginPics',$value);
		$text = $bool?'操作成功':'操作失败';
		C::toJson(array('value'=>$bool,'text'=>$text));
	}
	
	//将广告ID添加到商家的登录验证图片列表中
	public function addToStore()
	{
		$data = $_REQUEST;
		$store_id = (int)$data['store_id'];
		$ids = is_array($data['ids'])?$data['ids']:array(); //广告ID列表
		if(empty($ids)){
			C::toJson(array('value'=>false,'text'=>'广告记录没有选中'));
		}
		if(!$store_id){
			C::toJson(array('value'=>false,'text'=>'商家不能为空！'));
		}
		
		$r = storeX::getById($store_id);
		$ads = array_unique(array_merge($ids,$r['loginPics']));
		rsort($ads);
		$value = json_encode($ads);
		$bool = storeX::update($store_id,'loginPics',$value);
		$text = $bool?'操作成功':'操作失败';
		C::toJson(array('value'=>$bool,'text'=>$text));
	}
	
	//验证码图片管理
	public function loginPic_index($store_id=0,$page=1)
	{
    	$data['path'] = '广告管理 - 登录验证码图片'; //标题
		$data['store_id'] = (int)$store_id;
		$size = 20;
		$data['page'] = (int)((int)$page/($size))+1;
		
		//取得商家记录集
		$data['stores'] = storeX::get();
		
		//取得图片记录集
		$rs = ad::rs($data['store_id'],$data['page'],$size);
		$data['rs'] = $rs['rs'];
		$this->load->library('pagination');
    	$config['base_url'] = "/control_panel/advertisement/loginPic_index/$store_id";
    	$config['total_rows'] = $rs['total'];
    	$config['per_page'] = $size;
    	$config['uri_segment'] = 5;
    	$config['num_links'] = 5;
    	$config['anchor_class'] = 'class="number" ';
    	$config['cur_tag_open'] = '<a class="number current">';
    	$config['cur_tag_close'] = '</a>';
		$this->pagination->initialize($config);
		
		$this->load->view('control_panel/ad/loginPic_index', $data);
	}
	
	//添加新验证图片
	public function loginPic_add()
	{
		$data['path'] = '广告管理 - 添加新验证图片'; //标题
		
		$o = trim($_REQUEST['o']);
		if($o=='ok'){
			$file = $_FILES['adImg'];
			$fileS = $file['tmp_name'];
			$extName = strtolower(array_pop(explode('.',trim($file['name'])))); //扩展名
			$fileName = md5(now('0i')); //文件名
			$file = "1/0/{$fileName}.{$extName}";
			$filePath = "./data/ad/$file";
			if(!in_array($extName,array('gif','jpg','png','jpeg'))){
				js::goback('上传的文件类型不正确');
			}
			//保存文件
			$bool = copy($fileS,$filePath);
			if(!$bool){
				js::goback('文件上传失败');
			}
			
			//写入数据
			$r = array(
				'ad_page_type'=>1,
				'ad_lang_type'=>0,
				'ad_img'=>$file, //图片路径
				'ad_code'=>trim($_REQUEST['ad_code']),
				'ad_code_word'=>trim($_REQUEST['ad_code_word']),
				'ad_name'=>trim($_REQUEST['ad_name']), //广告名称
			);
			ad::add($r);
			js::msgskip('操作成功','/control_panel/advertisement/loginPic_index');
		}
		$this->load->view('control_panel/ad/loginPic_add', $data);
	}
	
	//更新验证图片
	public function loginPic_update($id)
	{
		$id = (int)$id;
		if(!$id){
			js::goback('参数ID丢失');
		}
		$data['path'] = '广告管理 - 更新验证图片'; //标题
		$r = ad::r($id);
		if(empty($r)){
			js::goback('记录不存在');
		}
		
		$o = trim($_REQUEST['o']);
		if($o=='ok'){
			//图片
			$file = $_FILES['adImg'];
			if(!empty($file['size'])){
				$fileS = $file['tmp_name'];
				$extName = strtolower(array_pop(explode('.',trim($file['name'])))); //扩展名
				$fileName = md5(now('0i')); //文件名
				$file = "1/0/{$fileName}.{$extName}";
				$filePath = "./data/ad/$file";
				if(!in_array($extName,array('gif','jpg','png','jpeg'))){
					js::goback('上传的文件类型不正确');
				}
				//保存文件
				$bool = copy($fileS,$filePath);
				if(!$bool){
					js::goback('文件上传失败');
				}
			}else{
				$file = $r['ad_img'];
			}
			
			//写入数据
			$r = array(
				'ad_img'=>$file, //图片路径
				'ad_code'=>trim($_REQUEST['ad_code']),
				'ad_code_word'=>trim($_REQUEST['ad_code_word']),
				'ad_name'=>trim($_REQUEST['ad_name']), //广告名称
			);
			ad::update($id,$r);
			js::msgskip('操作成功','/control_panel/advertisement/loginPic_index');
		}
		$data['r'] = $r;
		$this->load->view('control_panel/ad/loginPic_update', $data);
	}
	
	// User list page for manage.
	public function index()
	{	
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '广告管理页面分类列表';
    	$data['path'] = '广告管理页面分类列表';
    	$this->load->helper('aiwifi');
    	$data['ad_pages'] = advertisement_page_type();
    	$data['lang'] = advertisement_lang_type();
    	
    	$this->load->view('control_panel/ad/page_ad_list', $data);
	}
	
	// Advertisement list for each languages.
	public function page_lang($page_id, $lang_id){
		
		// Call page type and lang_type
		$this->load->helper('aiwifi');
		$data['ad_page'] = advertisement_page_type($page_id);
		$data['lang'] = advertisement_lang_type($lang_id);
		// Base info
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = $data['ad_page']['page_name'].$data['lang']['lang_name'].'广告列表';
    	$data['path'] = $data['ad_page']['page_name'].$data['lang']['lang_name'].'广告列表';
    	#分页配置
    	$data['total_ad'] = $this->aiwifi->comm_number('ad', array('ad_page_type' => $page_id, 'ad_lang_type' => $lang_id) );
    	$this->load->library('pagination');
    	$config['base_url'] = $data['base'].'control_panel/advertisement/page_lang/'.$page_id.'/'.$lang_id;
    	$config['total_rows'] = $data['total_ad'];
    	$config['per_page'] = 30;
    	$config['uri_segment'] = 6;
    	$config['num_links'] = 5;
    	$config['anchor_class'] = 'class="number" ';
    	$config['cur_tag_open'] = '<a class="number current">';
    	$config['cur_tag_close'] = '</a>';
    	$this->pagination->initialize($config);
    	$data['ad_list'] = $this->aiwifi->comm_list_where('ad', array('ad_page_type' => $page_id, 'ad_lang_type' => $lang_id), $config['per_page'],$this->uri->segment(6), 'ad_id', 'DESC');
    	
    	$this->load->view('control_panel/ad/page_lang_ad_list', $data);
		
	}
	
	// Add new advertisement page and also post page itself.
	public function new_advertisement($page_id, $lang_id){
		
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			// Call page type and lang_type
			$this->load->helper('aiwifi');
			$data['ad_page'] = advertisement_page_type($page_id);
			$data['lang'] = advertisement_lang_type($lang_id);
			// Base info
			$data['base'] = $this->config->item('base_url');
			$data ['source'] = $data ['base'].'source/';
			$data['title'] = "后台管理系统 - Aiwifi";
			$data['nav_title'] = $data['ad_page']['page_name'].'添加'.$data['lang']['lang_name'].'广告';
			$data['path'] = $data['ad_page']['page_name'].'添加'.$data['lang']['lang_name'].'广告';
			
			$this->load->view('control_panel/ad/add_new_ad', $data);
			
		}else{
			
			if (! is_dir ( 'data/ad/' . $page_id . '/' )) {
				mkdir ( 'data/ad/' . $page_id . '/' );
			}
			
			if (! is_dir ( 'data/ad/' . $page_id . '/' . $lang_id . '/' )) {
				mkdir ( 'data/ad/' . $page_id . '/' . $lang_id . '/' );
			}
			
			$ad['ad_page_type'] = $page_id;
			$ad['ad_lang_type'] = $lang_id;
			$ad['ad_code'] = $this->input->post('ad_code');
			$ad['ad_code_word'] = $this->input->post('ad_code_word');
			
			// Upload picture to server.
			$save_path = './data/ad/' . $page_id . '/' . $lang_id;
			$config['upload_path'] = $save_path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '5120';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload("adImg");
			#获取图片的相关信息
			$file = $this->upload->data();
			
			$ad['ad_img'] = $page_id . '/' . $lang_id. '/'. $file['raw_name'].$file['file_ext'];
			
			$this->aiwifi->comm_instert('ad', $ad);
			
			redirect('/control_panel/advertisement/page_lang/'.$page_id.'/'.$lang_id, 'refresh');
			
		}
		
	}
	
	// Modify this Advertisement.
	public function modify_ad($page_id, $lang_id, $ad_id){
		
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			// Call page type and lang_type
			$this->load->helper('aiwifi');
			$data['ad_page'] = advertisement_page_type($page_id);
			$data['lang'] = advertisement_lang_type($lang_id);
			// Base info
			$data['base'] = $this->config->item('base_url');
			$data ['source'] = $data ['base'].'source/';
			$data['title'] = "后台管理系统 - Aiwifi";
			$data['nav_title'] = $data['ad_page']['page_name'].'添加'.$data['lang']['lang_name'].'广告';
			$data['path'] = $data['ad_page']['page_name'].'添加'.$data['lang']['lang_name'].'广告';
			// Check this advertisement's info.
			$data['adinfo'] = $this->aiwifi->comm_info('ad', 'ad_id', $ad_id);
			
			$this->load->view('control_panel/ad/modify_ad', $data);
			
		}else{
			
			$ad['ad_page_type'] = $page_id;
			$ad['ad_lang_type'] = $lang_id;
			$ad['ad_code'] = $this->input->post('ad_code');
			$ad['ad_code_word'] = $this->input->post('ad_code_word');
			
			// Upload picture to server.
			$save_path = './data/ad/' . $page_id . '/' . $lang_id;
			$config['upload_path'] = $save_path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '5120';
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload("adImg");
			#获取图片的相关信息
			$file = $this->upload->data();
			
			if (!empty($file['raw_name'])) {
				
				$ad['ad_img'] = $page_id . '/' . $lang_id. '/'. $file['raw_name'].$file['file_ext'];
			}
			
			$this->aiwifi->comm_update('ad', $ad, 'ad_id', $ad_id);
			
			redirect('/control_panel/advertisement/page_lang/'.$page_id.'/'.$lang_id, 'refresh');
			
		}
		
	}
	
	// Delete this Advertisement.
	public function del_ad(){
		
		$ad_id = $this->input->post('ad_id');
		
		$this->aiwifi->comm_delete('ad', array('ad_id' => $ad_id));
		
		echo '广告已经成功删除!';
		
	}

}

/* End of file home.php in the controllers*/
?>