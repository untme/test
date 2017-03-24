<?php

class Sign extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
        // Get soft ware data for empty user session and get store mac address.
        $getData = $this->input->get();
        
        if (!empty($getData)) {
        	
        	//?res=notyet
        	$clear = $getData['res'] = 'notyet'; //清除网站的用户登录状态
        	$mac = str_replace(array('"',"'",'\\'),'',trim($getData['called']));
        	
        	if ($clear == 'notyet') {
        		$this->session->unset_userdata( array('islog' => '', 'ask' => '') );
        	}
        	
        	$where = "store_mac_one = '$mac' OR store_mac_two = '$mac'";
        	$store = $this->aiwifi->comm_information('store', $where);
        	$this->session->set_userdata(array('store_id' => $store['store_id']));
        	$this->session->set_userdata(array('servername' => $mac));
        	
        	//redirect('/sign', 'refresh');
        	
        }
        
        // Check if user has already login.
        $user_login = $this->session->userdata('islog');
        
        if ($user_login == 'true')
        {
			echo 1;
        	redirect('/user', 'refresh');
        }
	}
	
	//登录页
	public function index()
	{
		 
		$session_store = $this->session->userdata('store_id'); //商家id
		$this->load->helper('aiwifi');
		$this->load->helper('cookie');
		$data['cookie_phone'] =  get_cookie('aiwifi_user_phone');
		
		$data['base'] = $this->config->item('base_url');
        	$data['source'] = $data['base'].'source/';
		$data['store'] = storeX::getByMac(hotspot::info('server-name'));
		$data['ad'] = ad::randLoginAD($data['store']['store_id']);
		
		$this->lang->load('aiwifi', 'chinese');
		$data['lang_type'] = 1;
		
		ob_clean();
		$this->load->view('login.php',$data);
	}
	
	/*
    // Sign up AND Sign in show page.
	public function index()
	{
		$session_store = $this->session->userdata('store_id'); //商家id
		$this->load->helper('aiwifi');
		$this->load->helper('cookie');
		$data['cookie_phone'] =  get_cookie('aiwifi_user_phone');
		
		// Get session language type.
		$lang_type = $this->session->userdata('lang_type');
		if (empty($lang_type) || $lang_type == 1) {
        	$this->lang->load('aiwifi', 'chinese');
        	$data['lang_type'] = 1;
        }else if ($lang_type == 2) {
        	$this->lang->load('aiwifi', 'english');
        	$data['lang_type'] = 2;
        }else if ($lang_type == 3) {
        	$this->lang->load('aiwifi', 'japanese');
        	$data['lang_type'] = 3;
        }else if ($lang_type == 4) {
        	$this->lang->load('aiwifi', 'korean');
        	$data['lang_type'] = 4;
        }
		
		$data['base'] = $this->config->item('base_url');
        $data['source'] = $data['base'].'source/';
		$data['store'] = storeX::getByMac(hotspot::info('server-name'));
		$data['ad'] = ad::randLoginAD($data['store']['store_id']);
		
		$this->load->view('sign',$data);
	}
	*/
	
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
	
	// Get text message code.
	public function get_text_code()
	{
		$this->load->helper('aiwifi');
		$phone = trim($this->input->post('phone'));
		if(!preg_match('/^1[0-9]{10}$/',$phone)){
			C::toJson(array('value'=>false,'text'=>'手机号码错误'));
		}
		// Check out the phone is exist
		$is_phone = $this->aiwifi->comm_check('user', array('phone' => $phone));
		if (empty($is_phone)){
			//生成短信码
			$_key = "text_code_$phone";
			$code = $this->session->userdata($_key);
			empty($code) && $code = randStr(4,'NUMBER');
			$_SESSION['smscode'] = $code;
			
			// Save it to session.
			$this->session->set_userdata(array($_key=>$code));
			// Get session language type.
			$lang_type = $this->session->userdata('lang_type');
			if(empty($lang_type) || $lang_type == 1) {
				$this->lang->load('aiwifi', 'chinese');
				$data['lang_type'] = 1;
			}else if ($lang_type == 2) {
				$this->lang->load('aiwifi', 'english');
				$data['lang_type'] = 2;
			}else if ($lang_type == 3) {
				$this->lang->load('aiwifi', 'japanese');
				$data['lang_type'] = 3;
			}else if ($lang_type == 4) {
				$this->lang->load('aiwifi', 'korean');
				$data['lang_type'] = 4;
			}
			
			//取得短信内容 [LiBin]
			//$message = "会员AiWiFi注册，您的注册验证码为： {$code}，本验证码30分钟有效。";
			//发送短信验证码
			$result = sms::send($phone,$code);
			$text = $result['value']?'验证码已经发送, 外地号码接收时间可能稍长, 如果20分钟内仍没有收到短信请重试或联系客服':'验证码发送失败，请重试或联系客服';
		}else{
			$value = false;
			$text = '您输入的手机号码已经注册!';
		}
		C::toJson(array('value'=>$value,'text'=>$text));
	}
	
	// Submit signup handler
	public function submit_signup()
	{
		$phone = trim($this->input->post('phone'));
		$text_code = trim($this->input->post("text_code"));
		$text_code_sess = trim($this->session->userdata("text_code_$phone"));
		if ($text_code != $text_code_sess) {
			echo 0;
		}else{
			$this->session->set_userdata(array('reg_first' => 'true'));
			echo 1;
		}
	}
	
	// Submit signup the second step.
	public function complete($phone)
	{
		$phone = trim($phone);
		if(!preg_match('/^1[0-9]{10}$/',$phone)){
			js::goback('手机号码错误');
			exit;
		}
		$reg_first = $this->session->userdata('reg_first');
		
		if ($reg_first == 'true'){
			$action = $this->input->post('action');
			$this->load->helper('aiwifi');
			
			// Get session language type.
			$lang_type = $this->session->userdata('lang_type');
			if (empty($lang_type) || $lang_type == 1) {
				$this->lang->load('aiwifi', 'chinese');
				$data['lang_type'] = 1;
			}else if ($lang_type == 2) {
				$this->lang->load('aiwifi', 'english');
				$data['lang_type'] = 2;
			}else if ($lang_type == 3) {
				$this->lang->load('aiwifi', 'japanese');
				$data['lang_type'] = 3;
			}else if ($lang_type == 4) {
				$this->lang->load('aiwifi', 'korean');
				$data['lang_type'] = 4;
			}
			
			if (empty($action)) {
				$data['base'] = $this->config->item('base_url');
				$data['source'] = $data['base'].'source/';
				$data['phone'] = $phone;
				// Get adertisement for this page.
				$data['ad'] = $this->aiwifi->get_advertisement($data['lang_type'], 2);
				$this->load->view('sign_step_two',$data);
				
			}else{
				$user['phone'] = $phone;
				$user['realname'] = $this->input->post('realname');
				$user['nickname'] = $this->input->post('nickname');
				$user['email'] = strtolower($this->input->post('email'));
				$user['passwd'] = md5( $this->input->post('passwd') );
				$user['password'] = trim($this->input->post('passwd')); //cex 添加密码明文
				$user['type'] = 'normalMember';
				$user['regTime'] = time();
				//是否正确的邮箱格式
				$isMail = ereg('^[A-Za-z0-9_.-]+@([A-Za-z0-9_.-]+.)+[A-Za-z]{2,6}$',$user['email']);
				if(!$isMail){
					echo "<script language='JavaScript'>alert('$msg');history.back();</script>";
					exit;
				}
				$this->aiwifi->comm_instert('user', $user);
				
				// Post this new user data, Call API.
				// ---------------------------------------------------------------------------------------- Start Here
				/*
				$this->load->helper('aiwifi');
				include_once APPPATH.'libraries/client.php';
				radius_add_user($user['phone'], $this->input->post('passwd'), $user['email'], $user['phone']);
				*/
				// ---------------------------------------------------------------------------------------- End Here
				
				// redirect('/sign', 'refresh');
				$data['base'] = $this->config->item('base_url');
				$this->load->view('sign_success',$data);
				
			}
			
		}else{
			redirect('/sign', 'refresh');
		}
		
	}
	
	//注册
	function register()
	{
		$this->load->library('user_agent');
		$data = array_map('trim',$_REQUEST);
		if(!(int)$data['agree']){
			C::toJson(array('value'=>false,'text'=>'同意协议才可以注册'));
		}
		$phone = $data['phone'];
		if(!preg_match('/^1[0-9]{10}$/',$phone)){
			C::toJson(array('value'=>false,'text'=>'手机号码错误'));
		}
		$smscode = trim($this->session->userdata("text_code_$phone"));
		if($data['smscode']=='' || $smscode!=$data['smscode']){
			C::toJson(array('value'=>false,'text'=>'短信验证码错误'));
		}
		if($data['passwd']==''){
			C::toJson(array('value'=>false,'text'=>'密码不能空'));
		}
		if($data['passwd']==''){
			C::toJson(array('value'=>false,'text'=>'密码不能空'));
		}
		if(strlen($data['passwd'])<6){
			C::toJson(array('value'=>false,'text'=>'密码长度不能小于6位'));
		}
		if($data['passwd']!=$data['passwd_re']){
			C::toJson(array('value'=>false,'text'=>'两次输入密码不一致'));
		}
		$db = C::T('aiwifi_user');
		$r = $db->getr("phone='{$phone}'");
		if(!empty($r)){
			C::toJson(array('value'=>false,'text'=>'您输入的手机号码已经注册过了'));
		}
		//获取热点新	
		$hot = $this->aiwifi->getHotinfo();
		$this->load->library('user_agent');
		$ua = $this->agent->browser();
		//注册会员
		$bool = $db->insert(array(
			'phone' => $phone,
			'email' => '',
			'realname' => $phone,
			'nickname' => 'AiWiFi'.(int)($phone/2),
			'passwd' => md5($data['passwd']),
			'password' => $data['passwd'],
			'regTime' => time(),
			'server_name' => $hot['server_name'],
			'store_name' => $hot['store_name'],
			'ua' => $ua,
		));
		C::toJson(array('value'=>$bool,'text'=>$bool?'注册成功':'注册失败,请重试'));
	}
	
	//《信息采集声明》 
	function msg1()
	{
		ob_clean();
		echo ' 为配合国内公安机关加强网络管理，根据中华人民共和国《互联网上网服务营业场所管理条例 》第二十三条规定， 我公司需要对您使用该网络的设备进行相关的资料登记。
    您所填写的个人信息，将由我公司收集并严格妥善保管；
    如有疑问，可通过以下方式与我公司联系：
    客户服务热线：400-168-1799
    传真：010－63397577
    联系地址：北京市西城区马连道路4号通信管理局312室
    邮编：100055';
		exit;
	}
	
	//《无线网络服务条款及细则》
	function msg2()
	{
		ob_clean();
		echo '  本免费无线宽带上网服务（“AiWiFi”）是由北京立时世通科技有限公司提供。除使用免费上网服务外，客户亦可通过付费的方式使用无线上网服务，以享受更多的优惠服务。
    请阅读以下免费无线宽带上网服务的条款与细则，使用者须遵守本服务条款与细则才可以享用本服务。
    1. 使用者使用本服务时必须登记个人资料，请务必提交真实姓名以及联系方式。
    2. 使用者在使用本服务时应遵守国家法律、法规、规章等相关规定。
    3. 此服务容许使用者透过任何支持Wi-Fi的手机、手提电脑等终端设备来使用本无线宽带网络登入互联网。使用者必须使用可以支持Wi-Fi的手机或手提电脑及相关软件。使用者有责任确保此服务与其手机、手提电脑或设备来配合使用。
    4. 本公司有权随时修改、提升或终止此服务。
    5. 使用者已清楚明白及同意下列各项：
        a) 服务须根据指定的设定用法去运作，并且只适用于安装好的相关设备及软件；
        b) 此服务的提供将会透露使用者当前所在地的资料，有关资料的使用及保存，均受AiWiFi的标准私隐政策所限；
        c) 使用者可根据我公司所订立的条款, 在指定的热点免费享用无线宽带上网服务；我公司有权在客户使用免费无线宽带上网服务期间加插广告；我公司有权随时更改客户每天可享用的免费无线宽带上网服务时间的权利；
        d) 我公司及热点场地供应商不会对于使用无线网络以外的有关费用负责、追讨以及赔偿，（包括任何关于暂停服务或无线上网连线终断或服务质量而导致使用者的损失）亦没义务向使用者或任何第三者负责，不管此类损失是否直接或间接的任何类型，包括盈利、损失、利润或任何基于合同法、民事侵权法、成文法律或其他方面的结果性的损失（包括疏忽）；
        e) 使用者凡是延迟未能履行全部或部分条款与细则而造成的损失或损害，导致延误或未能履行条款与细则等因素, 并不是我公司及热点场地供应商可以合理控制的，又或者其它原因的过失或疏忽导致造成，包括第三者所为等各种因素的过失（包括电信网络营运商、资讯服务内容提供者及设备供应商），原料短缺、战争、战争来临的威胁、暴动、或其他群众骚动或行为、叛乱、天灾、任何政府或其他超越法律当局所实行的限制，工业或贸易争议、火灾、爆炸、风暴、水灾、闪电、地震及其他自然灾害，我公司及热点场地供应商均毋须负责。
    6. 无线网络于该服务覆盖的使用及连线情况，我公司及热点场地供应商将不会对服务质量或服务网络作任何担保。如该服务受到无法控制的因素影响，我公司在此表明保留权利终止此服务。';
		exit;
	}
}

/* End of file index.php in the controllers*/
?>
