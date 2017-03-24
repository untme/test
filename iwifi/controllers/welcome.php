<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function index()
	{
		//跳转到登录的url
		echo "<script language='JavaScript'>window.location.href='/sign?called=&res=notyet&challenge=no&mac=';</script>";
		
	}
}
?>