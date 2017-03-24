<?php

class Language extends CI_Controller {

	function __construct()
	{
		parent::__construct();

	}

    // Sign up AND Sign in show page.
	public function index()
	{
		
		$lang_type = $this->input->post('lang_type');
		
		if ($lang_type == 1 || $lang_type == 2 || $lang_type == 3 || $lang_type == 4){
		
			$this->session->set_userdata(array('lang_type' => $lang_type));
		
		}
		
	}

}

/* End of file index.php in the controllers*/