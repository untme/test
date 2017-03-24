<?php
error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);
ini_set('display_errors',"ON");

class Api extends CI_Controller {
	
	//设置参数
	private static $ip = '101.254.185.94'; //计费服务器的IP
	private static $admin = 'system'; //管理员帐号
	private static $password = '2a6580e1b734f22ead605e31b15b9a7d'; //密码
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('aiwifi');
	}

//外部接口
//==================================
	
	//首页
	public function index()
	{
		echo substr('
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
FALSE:远程认证失败ok',-2,2);
		exit;
		
		echo sms::getSendNumOfToday('13466647926');
		exit;
	}
	
	//接收来自热点的服务器信息, 并保存在session中
	public function saveHotspotInfo()
	{
		$data = $_POST;
		/*
		//来自热点机的参数
		Array
		(
			[domain] => 
			[interface-name] => LAN
			[ip] => 10.5.50.254
			[logged-in] => no
			[mac] => 20:6A:8A:47:C1:CC
			[trial] => no
			[username] => 
			[host-ip] => 0.0.0.0
			[hostname] => 10.5.0.1
			[identity] => MikroTik
			[login-by] => 
			[plain-passwd] => no
			[server-address] => 10.5.50.1:80
			[ssl-login] => no
			[server-name] => hotspot
			[link-login] => http://10.5.0.1/login?dst=http%3A%2F%2Fwww.baidu.com%2F
			[link-login-only] => http://10.5.0.1/login
			[link-logout] => http://10.5.0.1/logout
			[link-status] => http://10.5.0.1/status
			[link-orig] => http://www.baidu.com/
			[session-id] => 
			[var] => 
			[error] => 
			[error-orig] => 
			[chap-id] => \170
			[chap-challenge] => \073\214\276\371\052\201\132\322\045\017\165\207\244\166\001\103
			[popup] => true
			[advert-pending] => no
			[http-status] => $(http-status)
			[http-header] => $(http-header)
			[idle-timeout] => 
			[idle-timeout-secs] => 0
			[limit-bytes-in] => 
			[limit-bytes-out] => 
			[refresh-timeout] => 
			[refresh-timeout-secs] => 0
			[session-timeout] => 
			[session-timeout-secs] => 0
			[session-time-left] => 
			[session-time-left-secs] => 0
			[uptime] => 0s
			[uptime-secs] => 0
			[button] => 提交
		)
		*/
		
		//测试用
		//file_put_contents(dirname(__FILE__).'/Post_'.date('Y-m-d_H-i-s').'.txt',print_r($_POST,1));
		
		//保存到session中去
		$_SESSION['HotspotInfo'] = $data;
		$server_name = $data['server-name']; //HotSpot服务器名称（/ IP热点菜单，设置的name属性）
		$mac = $data['mac']; //MAC地址的用户
		$isLogin = trim($data['logged-in']);
		if($isLogin=='no'){
		//未登录状态
			$url = "/sign?called={$server_name}&res=notyet&challenge=no&mac={$mac}&cip={$data['ip']}";
		}else{
		//登录状态
			$url = "/union/user?called={$server_name}";
		}
	  if(!empty($server_name)){
			$mall = $this->aiwifi->comm_info('mall', 'servername', $server_name);
			$mallconfig = $this->config->item('mall');
			if(!empty($mall) && $mall['state']==$mallconfig['state']['on']){
				$url = '/union/mall/index/'.$mall['pk_mall'].'?called={$server_name}';
			}
		}
		exit("<script>window.location.replace('$url');</script>");
	}
	
	//跳转到用户登录页面去
	//url: /api/goLoginUrl
	public function goLoginUrl()
	{
		exit("<script>window.location.replace('http://10.5.0.1/logout?".time()."');</script>");
	}

	public function test(){
		var_dump($_SESSION);
    var_dump(session_id(), session_save_path(), session_get_cookie_params());
	}
	
	//取得www.iwifi.cc用户信息,以json格式输出
	//调用网址: 'http://www.iwifi.cc/api/sync_user?username=';
	public function sync_user()
	{
		$ip = self::$ip;
		$username = trim($_GET['username']);
		if($username==''){
			$this->toJson(array());
		}
		//记录会员登录时间
		$this->aiwifi->query($sql="update aiwifi_user set loginTime='".time()."' where phone='$username'");
		
		//取得用户是否在计费系统中已经存在
		$data = json_decode(file_get_contents("http://$ip/api/sync_user/index.php?action=isbeing_user&username=$username"),1);
		if($data['value']){
			//如果存在，则更新数据
			//1.同步用户的服务信息
			$this->sync_service($username);
			
			//2.同步用户的密码及其它信息
			$curl = self::curl();
			//取得会员信息
			$r = $this->getUserInfo($username);
			$data = array(
			  'password'=>md5(trim($r['password'])), //md5加过密的密码
			  'password_src'=>trim($r['password']), //明文密码
			  
			  'firstname'=>trim($r['firstname']), //姓名
			  'lastname'=>trim($r['lastname']), //妮称
			  'phone'=>trim($r['phone']), //电话
			  'mobile'=>trim($r['mobile']), //手机
			  'email'=>trim($r['email']), //email
			  'createdon'=>trim($r['createdon']), //注册时间
			);
			//更新计费系统的相应会员信息
			$url = "http://$ip/api/sync_user/index.php?action=update_user&username=$username";
			$arr = $curl->post($url,$data);
			$html = $arr['Response']['content'];
			
			ob_end_clean();
			echo $html;
			exit;
		}else{
			//如果不存在，则用curl模拟添加此用户
			self::toJson($this->curl_adduser($username));
		}
	}
	
	//找回/修改密码
	public function updateUserPassword()
	{
		//取得外部传入的参数
		$data = $_GET + $_POST;
		$o = trim($data['o']); //操作
		$mobile = trim($data['phone']);
		$code = trim($data['smscode']);
		$newpassword = trim($data['newpassword']);
		$repassword = trim($data['repassword']);
		$codeName="smscode_findpassword_{$mobile}"; //存放验证码的session名称
		
		if($o=='sendSmsCode'){
		//发送手机短信验证码
			//手机号码格式是否正确
			if(!ereg('^[0-9]{11}$',$mobile)){
				self::toJson(array('value'=>false,'text'=>'您输入的手机号码格式不正确。'));
			}
			//当前输入的手机用户是否为会员
			$id = (int)$this->aiwifi->comm_value('user','phone',$mobile,'uid');
			if(!$id){
				self::toJson(array('value'=>false,'text'=>'您输入的手机号码还未注册会员。'));
			}
			
			//1.取得今天已经发送手机短信验证码的次数
			
			//2.如果没有超过规定次数则下发, 否则返回超过次数等信息
			$arr = sms::sendCode($mobile,$codeName,$text='会员找回密码,您的验证码为：');
			if($arr['value']){
				$arr['text'] = '验证码发送成功，请注意查收。';
			}
			//3.今天发送的手机短信验证码次数累加1
			
			//4.返回发送成功
			self::toJson($arr);
		}elseif($o=='update'){
		//提交修改密码
			//手机号码格式是否正确
			if(!ereg('^[0-9]{11}$',$mobile)){
				self::toJson(array('value'=>false,'text'=>'您输入的手机号码格式不正确。'));
			}
			//1.手机验证码是否一致
			$bool = sms::checkCode($codeName,$code);
			if(!$bool){
				self::toJson(array('value'=>false,'text'=>'你输入的验证码不正确。'));
			}
			//2.新密码是否符合长度正则
			if(strlen($newpassword)<6){
				self::toJson(array('value'=>false,'text'=>'你输入的新密码不能少于6位。'));
			}
			//3.两次输入的新密码是否一致
			if($newpassword!=$repassword){
				self::toJson(array('value'=>false,'text'=>'两次输入的密码不一致。'));
			}
			//4.修改密码
			$bool = $this->aiwifi->comm_update('user',array('passwd'=>md5($newpassword),'password'=>$newpassword),'phone',$mobile);
			//5.返回成功
			if($bool){
				unset($_SESSION[$codeName]);
				self::toJson(array('value'=>true,'text'=>'操作成功。'));
			}else{
				self::toJson(array('value'=>false,'text'=>'操作失败，请稍后重试。'));
			}
		}else{
		//输出修改密码的页面
			$this->load->view('api/updateUserPassword',$data);
		}
	}
	
	//服务与订单支付
	public function service()
	{
		
		static $servicesList = array(
				'hot-free-4M-30min'=>1,
				'hot-free-2M-30min'=>0,	
			);
		//取得外部传入的参数
		$data = $_GET + $_POST;
		$o = trim($data['o']);
		$name = trim($data['name']); //服务名称
		$username = trim($this->session->userdata('phone')); //取得当前用户ID
		if($username==''){
			$this->toJson(array('value'=>false,'text'=>'当前还没有登录会员！'));
		}
		if($o==''){
			$this->toJson(array('value'=>false,'text'=>'参数错误！'));
		}
		
		//ajax访问 4M每天试用20分钟
		//url: /api/service?o=hot-test-00&username=xxxxxx
		if($o=='hot-free-4M-30min' || isset($servicesList[$o])){
			$service_name = $o;
			//1.先取得服务参数:
			$service = $this->getServiceByName($service_name);
			$id = (int)$service['id'];
			if(!$id){
				$this->toJson(array('value'=>false,'text'=>'参数错误，此服务记录不存在！'));
			}
			$cycle = trim($service['cycle']);
			
			//2.检查用户是否具备申请服务的条件:
			//用户今天是否已经申请过
			$time = date('Y-m-d 00:00:00');
			$rs = $this->aiwifi->query($sql="select * from aiwifi_service_order where username='$username' and service_id='$id' and  ordertime>'$time' order by id");
			if($servicesList[$o] && count($rs)>=$servicesList[$o]){
				$this->toJson(array('value'=>false,'text'=>'您今天已经申请过了，请明天再来！'));
			}
			//用户是否已经是有效的付费用户了
			$time = date('Y-m-d H:i:s');
			$rs = $this->aiwifi->query($sql="select * from aiwifi_user where phone='$username' and service_endtime>'$time' and service_id not in(58,37,57,60,31)");
			if(isset($rs[0])){
				$this->toJson(array('value'=>false,'text'=>'您已经是付费用户，无需申请试用了！'));
			}
			
			//3.申请服务:
			//生成一个订单
			$orderId = $this->makeServiceOrder($username,$service_name);
			//支付一个订单
			$this->payService($orderId,$service['price']);
			//升级成试用20分钟服务
			$data = $this->update_service($username,$service_name);
			if(!$data['value']){
				$this->toJson($data);
			}
			$this->toJson(array('value'=>true,'text'=>'免费30分钟高速上网服务已经开启，请立即重新登录进行体验！'));
		}
		
		//购买服务
		if($o=='buy'){
			$ss = $this->getServiceList(); //取得所有服务的列表
			if($name=='' || !isset($ss[$name]) || !(float)$ss[$name]['price']){
				echo '参数错误，请重试！';
				exit;
			}
			$service = $ss[$name];
			
			//用户是否已经是有效的付费用户了
			$time = date('Y-m-d H:i:s');
			$rs = $this->aiwifi->query($sql="select * from aiwifi_user where phone='$username' and service_endtime>'$time' and service_id not in(31,58,37,57,60)");
			if(isset($rs[0])){
				echo '您已经是付费用户，服务还未过期，现在不能再次购买！';
				exit;
			}
			
			//生成一个订单
			$orderId = $this->makeServiceOrder($username,$name);
			$_POST['out_trade_no'] = $orderId; //订单号
			$_POST['total_fee'] = $service['price']; //总金额
			$_POST['subject'] = "Aiwifi上网服务({$service['title']})"; //订单名称
			$_POST['body'] = '用户['.$username.'] 购买 ['.$service['explain'].'] 上网服务'; //订单描述
			$_POST['extra_common_param'] = $name; //[服务名称]参数 传送过去
			
			//输出支付页面
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>正在转到支付宝...</title>
</head>';
			require_once(dirname(__FILE__).'/alipay/alipayto.php');
			echo '<body></body></html>';
			exit;
		}
		
	}
	
	//支付回调接口 - 页面跳转同步通知页面路径
	public function paid()
	{
		$data = $_GET + $_POST; //取得外部传入的参数
		require_once(dirname(__FILE__)."/alipay/alipay.config.php");
		require_once(dirname(__FILE__)."/alipay/lib/alipay_notify.class.php");
		//先保存外部的数据
		$this->aiwifi->query("update aiwifi_service_order set other_data='".json_encode($data)."' where id='".$_GET['out_trade_no']."'");
		//取得订单的信息
		$rs = $this->aiwifi->query("select * from aiwifi_service_order where id='".$_GET['out_trade_no']."'");
		$r = $rs[0];
		$username = trim($r['username']);
		$ispay = (int)$r['ispay'];
		
		//计算得出通知验证结果
		//$alipayNotify = new AlipayNotify($aliapy_config);
		//$verify_result = $alipayNotify->verifyReturn();
		if($data['is_success']=='T' && $username!='') {//验证成功
			if(!$ispay){
				//支付订单
				$this->payService($_GET['out_trade_no'],$_GET['total_fee'],$_GET['trade_no'],$data); //支付宝交易号
				//升级服务
				$this->update_service($username,$_GET['extra_common_param']);
			}
			//提示与退出
			echo "<script>alert('支付成功，重新登录之后即可开启高速上网服务！')</script>";
			$this->goLoginUrl();
		}else{
			echo '服务升级失败，请与客服联系，客服电话：4001681799。';
		}
	}
	
	//支付回调接口 - 服务器异步通知页面路径
	public function paid_api()
	{
		$data = $_GET + $_POST; //取得外部传入的参数
		require_once(dirname(__FILE__)."/alipay/alipay.config.php");
		require_once(dirname(__FILE__)."/alipay/lib/alipay_notify.class.php");
		
		//先保存外部的数据
		$this->aiwifi->query("update aiwifi_service_order set other_data='".json_encode($data)."' where id='".$_GET['out_trade_no']."'");
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($aliapy_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {//验证成功
			$rs = $this->aiwifi->query("select * from aiwifi_service_order where id='".$_GET['out_trade_no']."'");
			$r = $rs[0];
			$username = $r['username'];
			$ispay = (int)$r['ispay'];
			if(!$ispay){
				//支付订单
				$this->payService($_GET['out_trade_no'],$_GET['total_fee'],$_GET['trade_no'],$data); //支付宝交易号
				//升级服务
				$this->update_service($username,$_GET['extra_common_param']);
			}
		}
	}
	
//内部方法
//=============================
	
	//取得www.iwifi.cc用户信息,并转换成radius的用户信息数组
	private function getUserInfo($username)
	{
		$ip = self::$ip;
		$username = trim($username);
		if($username==''){
			return array();
		}
		
		//取得用户信息
		$r = $this->aiwifi->comm_info($table='user', $key='phone', $value=$username);
		$uid = (int)$r['uid'];
		if(!$uid && trim($r['phone'])!=$username){
			return array();
		}
		
		//取得用户的静态IP
		$staticip = $this->getUserIP($username);
		
		//取得服务id
		$srvid = (int)$r['service_id']?(int)$r['service_id']:31; //默认为免费服务
		//取得有效日期
		if(strtotime($r['service_endtime'])>0){
			$expiration = date('Y-m-d',strtotime($r['service_endtime']));
		}else{
			$expiration = date('Y-m-d');
		}
		//取得可用时间
		if($srvid==37){
			$uptimelimit = '00:20:00'; //试用20分钟服务
		}else{
			$uptimelimit = '00:00:00';
		}
		
		//转换数据
		$data = array(
			'username'=>trim($r['phone']),
			'password'=>trim($r['password']), //密码明文
			'groupid'=>'1',
			'enableuser'=>'1',
			'uplimit'=>'0',
			'downlimit'=>'0',
			'comblimit'=>'0',
			'firstname'=>$r['realname'],
			'lastname'=>$r['nickname'],
			'company'=>'', //公司名称
			'phone'=>trim($r['phone']),
			'mobile'=>trim($r['phone']),
			'address'=>'', //地址
			'city'=>'', //城市
			'zip'=>'', //邮编
			'country'=>'', //国家
			'state'=>'', //省
			'comment'=>'来自网站www.iwifi.cc的注册用户', //注释
			'mac'=>'',
			'usemacauth'=>'0', //仅限此MAC地址
			'expiration'=>$expiration, //用户到期时间
			'uptimelimit'=>$uptimelimit,
			'srvid'=>$srvid, //服务id
			'staticip'=>$staticip, //静态IP地址 10.5.50.32
			'usestaticip'=>'0', //是否用户静态IP地址 1
			'createdon'=>trim($r['regTime'])==''?date('Y-m-d'):date('Y-m-d',trim($r['regTime'])), //注册时间
			'acctype'=>'0',
			'credits'=>'0.00',
			'cardfails'=>'0',
			'createdby'=>self::$admin,
			'owner'=>self::$admin,
			'taxid'=>'', //身份证号
			'email'=>trim($r['email']),
			'maccm'=>'',
			'custattr'=>'',
			'warningsent'=>'0',
			'verifycode'=>'',
			'verified'=>'0',
			'selfreg'=>'0',
			'verifyfails'=>'0',
			'verifysentnum'=>'0',
			'verifymobile'=>'',
		);
		return $data;
	}
	
	//使用curl模拟登录进后台进行添加用户
	private function curl_adduser($username)
	{
		$ip = self::$ip;
		$admin = self::$admin;
		$password = self::$password;
		
		$username = trim($username);
		if($username==''){
			return array('value'=>false,'text'=>'参数错误！');
		}
		
		$user = $this->getUserInfo($username);
		if(!is_array($user) || !count($user)){
			return array('value'=>false,'text'=>'获取数据失败！');
		}
		
		$curl = self::curl();
		//登录
		$url = "http://$ip/admin.php?cont=login";
		$data = array(
			'managername'=>trim($admin),
			'password'=>'',	
			'Submit'=>'',
			'md5'=>trim($password),
			'url'=>'',
		);
		$arr = $curl->post($url,$data);
		
		//先删除radius上已经存在的用户
		//$this->curl_deluser($username);
		
		//提交 - 添加用户
		$url = "http://$ip/admin.php?cont=store_user";
		$data = $user + array(
			'password1'=>trim($user['password']),
			'password2'=>trim($user['password']),
			'mac'=>'',
			'simuse'=>1,
			'superuser'=>'1',
			'maccm'=>'',
			'adduser'=>'添加用户'
			);
		$arr = $curl->post($url,$data);
		$html = $arr['Response']['content'];
		$bool=self::isInstr(trim($html),"用户创建成功");
		if($bool){
			$text = '用户创建成功！';
		}else{
			$text = '用户创建失败！';
		}
		return array('value'=>$bool,'text'=>$text);
	}
	
	//使用curl模拟登录进后台进行删除用户
	private function curl_deluser($username)
	{
		$ip = self::$ip;
		$admin = self::$admin;
		$password = self::$password;
		
		$username = trim($username);
		if($username==''){
			return array('value'=>true,'text'=>'无效用户名，无需作删除操作');
		}
		
		$curl = self::curl();
		//登录
		$url = "http://$ip/admin.php?cont=login";
		$data = array(
			'managername'=>trim($admin),
			'password'=>'',	
			'Submit'=>'',
			'md5'=>trim($password),
			'url'=>'',
		);
		$arr = $curl->post($url,$data);
		
		//提交 - 删除用户
		$url = "http://$ip/admin.php?cont=list_users_action";
		$data = array(
			'action'=>2,
			'list[]'=>$username,
			);
		$arr = $curl->post($url,$data);
		$html = $arr['Response']['content'];
		$bool=self::isInstr(trim($html),"用户删除了");
		if($bool){
			$text = '用户删除成功！';
		}else{
			$text = '用户删除失败！';
		}
		return array('value'=>$bool,'text'=>$text);
	}
	
	
	//使用curl模拟登录进后台，取得用户当前的信息数组
	private function curl_getUserInfo($username)
	{
		$ip = self::$ip;
		$admin = self::$admin;
		$password = self::$password;
		
		$username = trim($username);
		if($username==''){
			return array();
		}
		
		$curl = self::curl();
		//登录
		$url = "http://$ip/admin.php?cont=login";
		$data = array(
			'managername'=>trim($admin),
			'password'=>'',	
			'Submit'=>'',
			'md5'=>trim($password),
			'url'=>'',
		);
		$arr = $curl->post($url,$data);
		
		//提交 - 查看用户
		$url = "http://$ip/admin.php?cont=edit_user&username=$username";
		$arr = $curl->get($url);
		$html = trim($arr['Response']['content']);
		//用户是否存在
		$bool = self::isInstr($html,'无此用户');
		if($bool){
			return array();
		}

		//用户存在，则取得用户信息:
		$status = self::isInstr($html,'<td nowrap class="normal"><strong>激活</strong></td>');
		$islink = self::isInstr($html,'<td nowrap class="normal"><strong>联机</strong></td>');
		//服务ID
		$arr = self::findall($html,'/<select name="srvid".+?<OPTION SELECTED value=([0-9]+)>.+?<\/select>/is');
		$srvid = (int)$arr[1][0];
		//账户到期时间
		$arr = self::findall($html,'/<input name="expiration"[^>]+?value="([\-0-9]+)"/is');
		$expiration = date('Y-m-d H:i:s',strtotime($arr[1][0]));
		$user = array(
			'username'=>$username,
			'status'=>$status, //用户状态: 当前是否激活
			'islink'=>$islink, //是否在线状态
			'srvid'=>$srvid, //服务ID
			'expiration'=>$expiration, //账户到期时间
		);
		return $user;
	}
	
	//将用户下线
	private function curl_downline()
	{
		//退出用户
		$url = "http://$ip/admin.php?cont=online_users_action";
		$data = array(
			'list[]'=>'9b6dbdef9a32e475',
			'action'=>0,
		);
		$curl = self::curl();
		$arr = $curl->post($url,$data);
		$html = trim($arr['Response']['content']);
		
	}
		
//公用方法
//=======================================

	//取得curl操作类
	private static function curl()
	{
		$curl = new curl();
		return $curl;
	}
	
	private static function toJson($data)
	{
		ob_end_clean();
		echo json_encode($data);
		exit;
	}
	
	// 函数说明: 检测字符串A中是否包含字符串B，包含返回true,否则为false
	// 函数引用: $bool=isInstr("源串","子串");
	private static function isInstr($strA,$strB)
	{
		if(stristr(trim($strA),trim($strB))!==false){
			return true;
		}else{
			return false;
		}
	}
	
	// 函数说明: 查找串中所有符合正则匹配的子串,返回一个数组
	// 函数引用: $array = findall('文本串','正则表达式')
	// 例子: str::findall($text,'/1[0-9]{10}/') 找出文本中所有的手机号
	public static function findall($text,$pattern)
	{
		$array = array();
		if(preg_match_all($pattern,$text,$array)){
			return $array;
		}else{
			return array();
		}
	}
	
	//取得分配给用户的静态IP
	private function getUserIP($username='')
	{
		$username=trim($username);
		if($username==''){
			return '';
		}
		
		//先取得用户是否分配过的IP
		$rs = $this->aiwifi->query($sql="select * from aiwifi_user_ipdata where username='$username'");
		$ip = trim($rs[0]['ip']);
		if($ip!=''){
			return $ip;
		}
		
		//如果用户之前没有分配过IP的话，则进行分配一个新的IP
		$rs = $this->aiwifi->query($sql="select * from aiwifi_user_ipdata where username='' limit 1");
		$ip = trim($rs[0]['ip']);
		if($ip!=''){
			$bool = $this->aiwifi->query($sql="update aiwifi_user_ipdata set username='$username' where ip='$ip'");
		}
		return $ip;
	}
	
	//根根条件取得指定的一个用户
	private function getIwifiUser($where='')
	{
		$where = trim($where);
		if($where==''){
			return array();
		}
		$rs = $this->aiwifi->query($sql="select * from aiwifi_user where $where");
		$r = (int)$rs[0]['uid']?$rs[0]:array();
		return $r;
	}
	
//服务与订单支付
//===================================
	
	//取得Radius服务器上所有服务记录的列表
	private function getRadiusServiceList()
	{
		$ip = self::$ip;
		$arr = json_decode(file_get_contents("http://$ip/api/sync_user/index.php?action=getService"),1);
		return $arr;
	}

	//取得iwifi上所有服务记录的列表
	private function getServiceList($key='name')
	{
		$_rs = $this->aiwifi->comm_list($table='service');
		$rs = array();
		
		//以什么字段做为主键返回记录数组
		$key = trim($key)=='id'?'id':'name';
		foreach($_rs as $r){
			$rs[$r[$key]] = $r;
		}
		return $rs;
	}
	
	//根据服务名称取得服务记录
	private function getServiceByName($name)
	{
		$name = trim($name);
		$rs = $this->aiwifi->query($sql="SELECT * FROM aiwifi_service where name='$name'");
		$r = isset($rs[0])?$rs[0]:array();
		return $r;
	}
	
	//同步用户的服务信息
	public function sync_service($username)
	{
		$username = trim($username);
		$_user = $this->curl_getUserInfo($username); //取得计费服务器端的用户信息
		$service_id = (int)$_user['srvid'];
		$service_endtime = $_user['expiration'];
		
		//如果当前用户是没有激活状态 或 服务ID无效
		if(!(int)$_user['status'] || !$service_id){
			//将用户切换到免费服务
			$data = $this->update_service($username,$service_name='hot-free-00');
			return $data;
		}
		
		//取得用户信息
		$user = $this->getIwifiUser($where="phone='$username'");
		
		//如果计费系统上的用户服务与iwifi网站上的服务不一致
		if($user['service_id']!=$service_id){
			//以计费系统为准，更新iwifi用户的服务信息
			$this->aiwifi->query($sql="update aiwifi_user set service_id='$service_id',service_endtime='$service_endtime' where phone='$username'");
			$user['service_id'] = $service_id;
			$user['service_endtime'] = $service_endtime;
			
			return array('value'=>true,'text'=>'成功更新iwifi用户的服务信息','data'=>$user);
		}
		
		return array('value'=>true,'text'=>'无需同步服务信息');
	}
	
	//取得指定订单的信息
	private function getServiceOrderInfo($orderId)
	{
		$orderId = trim($orderId);
		if(!(int)$orderId){
			return array('value'=>false,'text'=>'参数错误，无效的订单号。');
		}
		$rs = $this->aiwifi->query($sql="select * from aiwifi_service_order where id='$orderId'");
		$r = isset($rs[0])?$rs[0]:array();
		return $r;
	}
	
	//生成一个服务订单记录
	//返回订单号
	public function makeServiceOrder($username,$servicename)
	{
		$username = trim($username);
		$servicename = trim($servicename);
		if($servicename=='' || $username==''){
			return '';	
		}
		$service = $this->getServiceByName($servicename);
		$service_id = (int)$service['id'];
		if(!$service_id){
			return '';
		}
		//查看表中是否有此用户此服务的未支付记录 (重复利用，可以减少表中的记录数)
		$rs = $this->aiwifi->query($sql="select * from aiwifi_service_order where username='$username' and ispay=0 and service_id='$service_id'");
		$r = isset($rs[0])?$rs[0]:array();
		if(trim($r['id'])!=''){
			return $r['id'];
		}
		
		//取得一个20位的订单号
		$day = date('YmdHis');
		$time = gettimeofday();
		$usec = substr('00000'.$time['usec'],-6,6); //时间戳+当前毫微秒数
		$id = $day.$usec;
		//将订单写入数据表中
		$r = array(
			'id'=>$id,
			'service_id'=>$service_id,
			'username'=>$username,
			'ordertime'=>date('Y-m-d H:i:s'),
		);
		$this->aiwifi->comm_instert('aiwifi_service_order', $r);
		return $id;
	}
	
	//将指定的服务订单标识成支付成功，当用户支付完成后执行此方法来标识成功
	//参数: $orderId 订单号 , $payfee 支付的费用, $trade_no 支付宝交易号
	public function payService($orderId,$payfee,$trade_no='',$otherData=array())
	{
		$orderId = trim($orderId);
		$trade_no = trim($trade_no);
		if(!(int)$orderId){
			return array('value'=>false,'text'=>'参数错误，无效的订单号。');
		}
		$payfee = (float)$payfee;
		
		$order = $this->getServiceOrderInfo($orderId);
		if($order['ispay']){
			return array('value'=>true,'text'=>'此订单已经支付成功，无需重复支付。');
		}
		$r = array(
			'ispay'=>1,
			'payfee'=>$payfee,
			'trade_no'=>$trade_no, //支付宝交易号
			'paytime'=>date('Y-m-d H:i:s'),
			'other_data'=>json_encode($otherData),
		);
		$this->aiwifi->comm_update('aiwifi_service_order',$r,'id',$orderId);
		return array('value'=>true,'text'=>'支付成功。');
	}
	
	//更改用户的服务项
	private function update_service($username,$service_name)
	{
		$ip = self::$ip;
		$username = trim($username);
		$service_name = trim($service_name);
		if($username==''){
			return array('value'=>false,'text'=>'参数错误，用户名不能为空。');
		}
		
		$service = $this->getServiceList($key='name'); //取得所有服务列表
		$service = $service[$service_name]; //取得对应的服务记录
		$srvid = (int)$service['id']; //取得对应服务ID
		if(!$srvid){
			return array('value'=>false,'text'=>'参数错误，无效的服务名称。');
		}
		
		//不同的服务，不同的参数
		switch($service_name){
			case 'hot-free-4M-30min':
			case 'hot-free-2M-30min':
			//免费4M试用20分钟 服务
				$data = array(
					'srvid'=>$srvid,
					'expiration'=>date('Y-m-d H:i:s',strtotime('+'.$service['cycle'])),
					'uptimelimit'=>30*60, //秒数
				);
				break;
			case 'hot-test-00':
			//免费4M试用30分钟 服务
				$data = array(
					'srvid'=>$srvid,
					'expiration'=>date('Y-m-d H:i:s',strtotime('+'.$service['cycle'])),
					'uptimelimit'=>20*60, //秒数
				);
				break;
			default :
			//其它的服务
				$data = array(
					'srvid'=>$srvid,
					'expiration'=>date('Y-m-d H:i:s',strtotime('+'.$service['cycle'])),
					'uptimelimit'=>0,
				);
		}
		$service_endtime = $data['expiration']; //将服务终止时间存储起来
		//更新计费服务器
		$curl = self::curl();
		$url = "http://$ip/api/sync_user/index.php?action=update_service&username=$username";
		$str = json_encode($data);
                $str2 = $url;
                //file_put_contents('/tmp/up.log', $str.PHP_EOL.$str2, FILE_APPEND);
		$arr = $curl->post($url,$data);
		$html = trim($arr['Response']['content']);
		$redata = json_decode($html,1);
		if($redata['value']){
			//更新iwifi网站上的用户数据
			$this->aiwifi->query($sql="update aiwifi_user set service_id='$srvid',service_endtime='$service_endtime' where phone='$username'");
		}
		return $redata;
	}
	
	//统计信息
	public function webinfo()
	{
		ob_clean();
		
		$today = date('Y-m-d');
		$yesterday = date('Y-m-d',strtotime('-1 day'));
		echo "时间: ".date('Y-m-d H:i:s')."\r\n"; //$today
		
		$smsNum = sms::getSurplusNum();
		$smsNum = $smsNum['value']?$smsNum['text']:'获取失败';
		echo "短信余量: {$smsNum}\r\n";
		$SendNumToday = C::T('aiwifi_sms_log')->count("_time>='$today 00:00:00' and _time<='$today 23:59:59'");
		$SendNumYesterday = C::T('aiwifi_sms_log')->count("_time>='$yesterday 00:00:00' and _time<='$yesterday 23:59:59'");
		echo "短信发送: 今日($SendNumToday) 昨日($SendNumYesterday)\r\n";
		
		$userNum = C::T('aiwifi_user')->count();
		echo "会员总数: {$userNum}\r\n";
		$todayStartNum = strtotime("$today 00:00:00");
		$todayEndNum = strtotime("$today 23:59:59");
		$loginNumToday = C::T('aiwifi_user')->count("loginTime>=$todayStartNum and loginTime<=$todayEndNum");
		$regNumToday = C::T('aiwifi_user')->count("regTime>=$todayStartNum and regTime<=$todayEndNum");
		echo "今日: 登录($loginNumToday) 注册($regNumToday)\r\n";
		$yesterdayStartNum = strtotime("$yesterday 00:00:00");
		$yesterdayEndNum = strtotime("$yesterday 23:59:59");
		$loginNumYesterday = C::T('aiwifi_user')->count("loginTime>=$yesterdayStartNum and loginTime<=$yesterdayEndNum");
		$regNumYesterday = C::T('aiwifi_user')->count("regTime>=$yesterdayStartNum and regTime<=$yesterdayEndNum");
		echo "昨日: 登录($loginNumYesterday) 注册($regNumYesterday)\r\n";
		
		$orderNum = C::T('aiwifi_service_order')->count("payfee>0");
		echo "订单总数: {$orderNum}\r\n";
		$orderNumToday = C::T('aiwifi_service_order')->count("payfee>0 and paytime>='$today 00:00:00' and paytime<='$today 23:59:59'");
		$r = C::T('aiwifi_service_order')->query("select sum(payfee) as money from aiwifi_service_order where payfee>0 and paytime>='$today 00:00:00' and paytime<='$today 23:59:59'");
		$amountToday = (float)$r[0]['money'];
		echo "今日: 订单($orderNumToday) 资金($amountToday)\r\n";
		$orderNumYesterday = C::T('aiwifi_service_order')->count("payfee>0 and paytime>='$yesterday 00:00:00' and paytime<='$yesterday 23:59:59'");
		$r = C::T('aiwifi_service_order')->query("select sum(payfee) as money from aiwifi_service_order where payfee>0 and paytime>='$yesterday 00:00:00' and paytime<='$yesterday 23:59:59'");
		$amountYesterday = (float)$r[0]['money'];
		echo "昨日: 订单($orderNumYesterday) 资金($amountYesterday)\r\n";
		
		$tryNum = C::T('aiwifi_service_order')->count("payfee=0 and service_id=37");
		echo "试用总数: {$tryNum}\r\n";
		$tryNumToday = C::T('aiwifi_service_order')->count("payfee=0 and service_id=37 and paytime>='$today 00:00:00' and paytime<='$today 23:59:59'");
		$tryNumYesterday = C::T('aiwifi_service_order')->count("payfee=0 and service_id=37 and paytime>='$yesterday 00:00:00' and paytime<='$yesterday 23:59:59'");
		echo "试用: 今日($tryNumToday) 昨日($tryNumYesterday)\r\n";
		exit;
	}
	
}
?>
