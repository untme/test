<?php
namespace Home\Controller;
use Think\Controller;
use Com\CIA\WxPayApi;
use Com\CIA\WxPayConfig;
// use Com\CIA\WxPayData;
// use Com\CIA\WxPayException;
use Com\CIA\WechatAuth;
use Com\CIA\JsApiPay;
use Com\CIA\WxPayNotify;
use Com\CIA\PayNotifyCallBack;
use Com\CIA\WxPayUnifiedOrder;
// use Com\CIA\WxPayJsApiPay;
require "./core/Library/Com/CIA/WxPayData.class.php";

class NotifyController extends Controller {
	public $AppID ="wx98f88ea5f4791167";
	public $AppSecret ="2dbabd5a854dcaec0ef0f13db1d4bb8c";
	public $wechatAuth;
	
	public function index(){
		$this->getToken();
		trace($this->wechatAuth, 'wechatAuth', 'debug', true);
		$notify=new PayNotifyCallBack();
		// $notify->setWechatAuth($this->wechatAuth);
		trace($notify, 'notify', 'debug', true);
		$notify->Handle(true,$this->wechatAuth);
	}
	public function getToken(){
	    S(array('type'=>'file','expire'=>7200,'prefix'=>'bpat'));
	    if (S('access_token')) {
	        $token=S('access_token');
	        $b=$this->wechatAuth= new WechatAuth($this->AppID,$this->AppSecret,$token);
	    }else{
	        $b=$this->wechatAuth= new WechatAuth($this->AppID,$this->AppSecret);
	        $token=$this->wechatAuth->getAccessToken();
	        S('access_token',$token['access_token']);
	        $token=$token['access_token'];
	    }
	    return $token;
	}
}