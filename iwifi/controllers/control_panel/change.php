<?php
/**
 * 快速状态切换服务 
 * 
 *
 * @uses CI
 * @uses _Controller
 * @package 
 * @version $id$
 * @copyright 2015-2015 The AIWIFI Group
 * @author houweiozng <houweizong@gmail.com> 
 */
class change extends CI_Controller {

	function __construct(){
		parent::__construct();

		//获取管理员是否后台登陆信息.
		$checkAdmin = $this->session->userdata('admin_islogin'); 

		if ($checkAdmin != 'true'){
			redirect('/control_panel/login/', 'refresh');
		}
	}


	public function open($entry, $id){
		$res = $this->aiwifi->comm_update($entry, array('state'=>1), 'pk_'.$entry, $id);	
		echo (int)$res;
	}

	public function close($entry, $id){
		$res = $this->aiwifi->comm_update($entry, array('state'=>0), 'pk_'.$entry, $id);	
		echo (int)$res;
	}
}
