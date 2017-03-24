<?php

class Free extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		//检测用户是否来自热点 [LiBin]
		$this->aiwifi->isFromHotspot();
		
		// Check if user has already login.
        $user_login = $this->session->userdata('islog');
        /*if(!empty($_SESSION) && isset($_SESSION['logged-in']) && $_SESSION['logged-in']!="no"){
            $user_login = $user_login;
        }else{
        		$this->session->unset_userdata( array('islog' => '', 'ask' => '') );
            $user_login =False;
        }*/
        // Check if user answer the questions.
        $user_ask = $this->session->userdata('ask');
        if ($user_login != 'true')
        {
        	redirect('/sign', 'refresh');
        }
        
        if ($user_ask != 'true') {
        	
        	redirect('/ask', 'refresh');
        }
	}

    // Sign up AND Sign in show page.
	public function index()
	{
		$this->load->helper('aiwifi');
        if(isset($_GET['debug'])){
            var_dump($_SESSION);exit();
        }
		
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
        $uid = $this->session->userdata('uid');

		ob_clean();
		
		$this->load->view('union/free/index.html',$data);
	}
	

}

/* End of file index.php in the controllers*/
