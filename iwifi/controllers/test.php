<?php

class Test extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		echo '11112';
		
	}
	
	//登录页
	public function index()
	{
		
		echo '1111';
		
		$this->load->view('tshow.php',$data);
	}
 
	// User Signin handler.
	public function user_signin()
	{
		$phone = $this->input->post('phone');
		$passwd = md5($this->input->post('passwd'));
		$remember = $this->input->post('remember');
		$check_user = $this->aiwifi->comm_check('user', array('phone' => $phone, 'passwd' => $passwd));
		
		//print_r($check_user);exit;
		if (empty($check_user)) {
			echo 0;			
		}else{
			if ($remember == 1) {
				$this->load->helper('cookie');
				$cookie = array(
                	'name'   => 'aiwifi_user_phone',
                    'value'  => $phone,
                    'expire' => '1296000',
                    'path'   => '/'
                );
                set_cookie($cookie);
			}
			$user = $this->aiwifi->comm_info('user', 'phone', $phone);
			
			// Create Session
			$session_data = array(
							  'uid'=>$user['uid'],
							  'phone'=>$user['phone'],
							  'nickname'=>$user['nickname'],
							  'islog'=>'true',
							  'temp_passwd'=>$this->input->post('passwd'),
							);
			$this->session->set_userdata($session_data);
			
			//cex=========start
			//登录成功后，同步用户信息
			$url = 'http://'.$_SERVER['HTTP_HOST']."/api/sync_user?username={$phone}";
			$json = trim(file_get_contents($url));
			$data = json_decode($json,1);
			ob_end_clean();

		//print_r($data);exit;
			if((int)$data['value']){
				echo 1;
			}else{
				$this->session->set_userdata(array('islog'=>'false'));
				echo 0;
			}
			
			//记录用户设备的MAC地址
			$this->aiwifi->userMac($user['phone'],$_SESSION['HotspotInfo']['mac']);
			//cex===========end
		}
		
	}
	
}
/* End of file index.php in the controllers*/
?>
