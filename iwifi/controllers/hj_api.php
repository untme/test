<?php
error_reporting(E_ERROR | E_PARSE | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);
ini_set('display_errors',"ON");

class Hj_api extends CI_Controller
{
	private static $HJkey = '241a7e8ea84cff5015c316cd22cd5e6f';
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('aiwifi');
		$this->data = C::data($this,3);
		if(trim($this->data['key'])!=self::$HJkey){
			array('code'=>1000,'text'=>'key错误');
		}
	}
	
	//登录
	public function login()
	{
		$phone = trim($this->data['phone']);
		$password = trim($this->data['password']);
		
		if(empty($phone)){
			C::toJson(array('code'=>1001,'text'=>'手机号码不能为空'));
		}
		if(empty($password)){
			C::toJson(array('code'=>1002,'text'=>'密码不能为空'));
		}
		if(!preg_match('/^1[0-9]{10}$/',$phone)){
			C::toJson(array('code'=>1003,'text'=>'手机号码格式错误'));
		}
		
		$db = C::T('aiwifi_user');
		//用户是否存在
		$r = $db->getr("phone='{$phone}'");
		if(empty($r)){
			C::toJson(array('code'=>1004,'text'=>'用户不存在'));
		}
		//验证密码
		if(md5($password)!=$r['passwd']){
			C::toJson(array('code'=>1005,'text'=>'密码不正确'));
		}else{
			C::toJson(array('code'=>0,'text'=>'登录成功'));
		}
	}
	
	//注册
	public function resgister()
	{
		$step = (int)$this->data['step'];
		
		$phone = trim($this->data['phone']);
		if(empty($phone)){
			C::toJson(array('code'=>1001,'text'=>'手机号码不能为空'));
		}
		if(!preg_match('/^1[0-9]{10}$/',$phone)){
			C::toJson(array('code'=>1003,'text'=>'手机号码格式错误'));
		}
		//用户判重
		$db = C::T('aiwifi_user');
		if($db->count("phone='{$phone}'")){
			C::toJson(array('code'=>1006,'text'=>'用户已经存在'));
		}
			
		//发送注册手机验证码
		if($step==0){
			$bool = $this->sendSMS($phone,__FUNCTION__);
			if($bool){
				C::toJson(array('code'=>0,'text'=>'短信码发送成功'));
			}else{
				C::toJson(array('code'=>1007,'text'=>'短信码发送失败'));
			}
		}
		
		//注册
		if($step==1){
			//验证短信码的有效性
			$identify = trim($this->data['identify']);
			if(empty($identify)){
				C::toJson(array('code'=>1008,'text'=>'短信码不能为空'));
			}
			if(!self::checkSMSCode($phone,__FUNCTION__,$code)){
				C::toJson(array('code'=>1009,'text'=>'短信码错误'));
			}
			//验证密码
			$password = trim($this->data['password']);
			if(empty($password)){
				C::toJson(array('code'=>1002,'text'=>'密码不能为空'));
			}
			
			//添加
			$bool = $db->insert(array(
				'phone'=>$phone,
				'email'=>$phone,
				'realname'=>$phone,
				'nickname'=>$phone,
				'passwd'=>md5($password),
				'password'=>$password,
				'type'=>'手机APP注册',
				'regTime'=>time(),
			));
			if($bool){
				C::toJson(array('code'=>0,'text'=>'注册成功'));
			}else{
				C::toJson(array('code'=>1011,'text'=>'注册失败'));
			}
		}
		C::toJson(array('code'=>1200,'text'=>'无效的操作'));
	}
	
	//找回密码
	public function findpass()
	{
		$step = (int)$this->data['step'];
		
		$phone = trim($this->data['phone']);
		if(empty($phone)){
			C::toJson(array('code'=>1001,'text'=>'手机号码不能为空'));
		}
		if(!preg_match('/^1[0-9]{10}$/',$phone)){
			C::toJson(array('code'=>1003,'text'=>'手机号码格式错误'));
		}
		//用户是否存在
		$db = C::T('aiwifi_user');
		if($db->count("phone='{$phone}'")){
			C::toJson(array('code'=>1004,'text'=>'用户不存在'));
		}
		
		//发送找回密码操作的手机验证码
		if($step==0){
			$bool = $this->sendSMS($phone,__FUNCTION__);
			if($bool){
				C::toJson(array('code'=>0,'text'=>'短信码发送成功'));
			}else{
				C::toJson(array('code'=>1007,'text'=>'短信码发送失败'));
			}
		}
		
		//找回密码
		if($step==1){
			//验证短信码的有效性
			$identify = trim($this->data['identify']);
			if(empty($identify)){
				C::toJson(array('code'=>1008,'text'=>'短信码不能为空'));
			}
			if(!self::checkSMSCode($phone,__FUNCTION__,$code)){
				C::toJson(array('code'=>1009,'text'=>'短信码错误'));
			}
			//验证密码
			$password = trim($this->data['password']);
			if(empty($password)){
				C::toJson(array('code'=>1002,'text'=>'密码不能为空'));
			}
			
			//重置密码
			$bool = $db->update("phone='{$phone}'",array(
							  	'passwd'=>md5($password),
								'password'=>$password,
							));
			if($bool){
				C::toJson(array('code'=>0,'text'=>'密码设置成功'));
			}else{
				C::toJson(array('code'=>1012,'text'=>'密码设置失败'));
			}
		}
		C::toJson(array('code'=>1200,'text'=>'无效的操作'));
	}
	
	//发送短信码
	private static function sendSMS($phone,$type)
	{
		$phone = trim($phone);
		$type = trim($type);
		if(empty($phone) || empty($type)){
			return false;
		}
		
		$code = rand(10000,99999);
		$sendtime = date('Y-m-d H:i:s');
		$db = C::T('hj_smscode');
		$db->insert_update(array(
						'phone'=>$phone,
						'type'=>$type,
						'code'=>$code,
						'sendtime'=>$sendtime,
					),$set="code='$code',sendtime='$sendtime'");
		$r = $db->getr("phone='{$phone}' and type='{$type}'");
		$code = trim($r['code']);
		
		//发送短信
		if($type=='resgister'){
			$msg = "您的会员注册操作验证码为： {$code}";
		}
		if($type=='findpass'){
			$msg = "您找回密码操作验证码为： {$code}";
		}
		$data = emay::send($phone,$msg.'【黑井古镇】');
		return $data['value'];
	}
	
	//验证短信码
	private static function checkSMSCode($phone,$type,$code)
	{
		$phone = trim($phone);
		$type = trim($type);
		$code = trim($code);
		if(empty($phone) || empty($type) || empty($code)){
			return false;
		}
		
		$db = C::T('hj_smscode');
		$n = $db->count("phone='{$phone}' and type='{$type}' and code='{$code}'");
		return $n;
	}
	
}
?>