<?php

class Ask extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.

        if ($checkAdmin != 'true')
        {
        	redirect('/control_panel/login/', 'refresh');
        }
	}

	// With different languages of all questions list.
	public function index($lang = ''){
		
		$this->load->helper('aiwifi');
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '问讯问题列表';
    	$data['path'] = '问讯问题列表';
    	empty($lang) ? $lang = 1 : $lang ;
    	$data['lang'] = advertisement_lang_type($lang);
    	$data['langs'] = advertisement_lang_type();
    	// List all questions with language type.
    	$data['total_question'] = $this->aiwifi->comm_number('ask_question', array('aq_lang' => $lang));
    	$this->load->library('pagination');
    	$config['base_url'] = $data['base'].'control_panel/ask/index/'.$lang;
    	$config['total_rows'] = $data['total_question'];
    	$config['per_page'] = 20;
    	$config['uri_segment'] = 5;
    	$config['num_links'] = 5;
    	$config['anchor_class'] = 'class="number" ';
    	$config['cur_tag_open'] = '<a class="number current">';
    	$config['cur_tag_close'] = '</a>';
    	$this->pagination->initialize($config);
    	$data['questions'] = $this->aiwifi->comm_list_where('ask_question', array('aq_lang' => $lang), $config['per_page'],$this->uri->segment(5), 'sequence','ASC');
    	foreach($data['questions'] as &$r){
			$r['answerNum'] = (int)$this->aiwifi->comm_number('aiwifi_ask_answer',array('aq_id'=>$r['aq_id']));
		}
    	$this->load->view('control_panel/ask/question_list', $data);
	}
	
	// Add New Question
	public function add_new_question($lang){
		
		$action = $this->input->post('action');
		$this->load->helper('aiwifi');
		
		if (empty($action)) {
			
			$data['base'] = $this->config->item('base_url');
	        $data ['source'] = $data ['base'].'source/';
	    	$data['title'] = "后台管理系统 - Aiwifi";
	    	$data['nav_title'] = '添加问题';
	    	$data['path'] = '添加问题';
	    	$data['lang'] = advertisement_lang_type($lang);
    		$data['langs'] = advertisement_lang_type();
    		
    		$this->load->view('control_panel/ask/question_new', $data);
			
		}else{
			
			$q['aq_title'] = $this->input->post('aq_title');
			$q['aq_lang'] = $this->input->post('aq_lang');
			$q['aq_type'] = $this->input->post('aq_type');
			$q['aq_level'] = (int)$this->input->post('aq_level');
			$q['sequence'] = (int)$this->input->post('sequence');
			$this->aiwifi->comm_instert('ask_question', $q);
			
			redirect('/control_panel/ask/index/'.$lang, 'refresh');
		}
		
	}
	
	// Modify this question
	public function modify_question($lang, $aq_id){
		
		$action = $this->input->post('action');
		$this->load->helper('aiwifi');
		
		if (empty($action)) {
			$data['base'] = $this->config->item('base_url');
	        $data ['source'] = $data ['base'].'source/';
	    	$data['title'] = "后台管理系统 - Aiwifi";
	    	$data['nav_title'] = '添加问题';
	    	$data['path'] = '添加问题';
	    	$data['lang'] = advertisement_lang_type($lang);
    		$data['langs'] = advertisement_lang_type();
    		$data['qinfo'] = $this->aiwifi->comm_info('ask_question', 'aq_id', $aq_id);
    		$this->load->view('control_panel/ask/question_modify', $data);
		}else{
			$q['aq_title'] = $this->input->post('aq_title');
			$q['aq_lang'] = $this->input->post('aq_lang');
			$q['aq_type'] = $this->input->post('aq_type');$q['aq_level'] = (int)$this->input->post('aq_level');
			$q['sequence'] = (int)$this->input->post('sequence');
			$this->aiwifi->comm_update('ask_question', $q, 'aq_id', $aq_id);
				
			redirect('/control_panel/ask/index/'.$lang, 'refresh');
		}
		
	}
	
	// Delete this question
	public function delete_question(){
		
		$aq_id = $this->input->post('aq_id');
		
		$this->aiwifi->comm_delete('ask_question', array('aq_id' => $aq_id));
		
		echo '问题已经成功删除!';
		
	}
	
	// Answer list for single question.
	public function answer($aq_id){
		
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '问讯问题答案列表';
    	$data['path'] = '问讯问题答案列表';
    	// Get the answer list for this question.
    	$data['aq_id'] = $aq_id;
    	$data['answer'] = $this->aiwifi->comm_list_where('ask_answer', array('aq_id' => $aq_id), 100, 0, 'aa_id', 'ASC');
    	//取得问题记录
		$data['question'] = $this->aiwifi->comm_info('aiwifi_ask_question', 'aq_id',$aq_id);
		
    	$this->load->view('control_panel/ask/answer_list', $data);
		
	}
	
	// Add a new answer.
	public function new_answer($aq_id){
		
		$action = $this->input->post('action');
		
		if (empty($action)) {
			
			$data['base'] = $this->config->item('base_url');
			$data['aq_id'] = $aq_id;
			
			$this->load->view('control_panel/ask/answer_new', $data);
			
		}else{
			
			$a['aq_id'] = $aq_id;
			$a['aa_title'] = $this->input->post('aa_title');
			
			$this->aiwifi->comm_instert('ask_answer', $a);
			echo '问题答案添加成功.';
			
		}
		
	}
	
	// Modify this answer.
	public function modify_answer($aq_id, $aa_id){
	
		$action = $this->input->post('action');
	
		if (empty($action)) {
				
			$data['base'] = $this->config->item('base_url');
			$data['aq_id'] = $aq_id;
			$data['ainfo'] = $this->aiwifi->comm_info('ask_answer', 'aa_id', $aa_id);
				
			$this->load->view('control_panel/ask/answer_modify', $data);
				
		}else{
				
			$aa_title = $this->input->post('aa_title');
				
			$this->aiwifi->comm_update('ask_answer', array('aa_title' => $aa_title), 'aa_id', $aa_id);
			echo '问题答案修改成功.';
				
		}
	
	}
	
	// Delete this answer.
	public function delete_answer(){
		
		$aa_id = $this->input->post('aa_id');
		
		$this->aiwifi->comm_delete('ask_answer', array('aa_id' => $aa_id));
		
		echo '答案已经成功删除!';
		
	}
	
	// The question statistics page.
	public function statis($aq_id){
		
		$data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
    	$data['title'] = "后台管理系统 - Aiwifi";
    	$data['nav_title'] = '问讯统计';
    	$data['path'] = '问讯统计';
    	
    	// Get the number of all user who voted.
    	$data['total_voted_number'] = $this->aiwifi->comm_number('ask_user_log', array('aq_id' => $aq_id));
    	// Get all answers of this question.
    	$data['answer'] = $this->aiwifi->comm_list_where('ask_answer', array('aq_id' => $aq_id), 100, 0, 'aa_id', 'ASC');
    	// Get this question info
    	$data['question'] = $this->aiwifi->comm_info('ask_question', 'aq_id', $aq_id);
    	$this->load->view('control_panel/ask/statis', $data);
		
	}
	

}

/* End of file home.php in the controllers*/