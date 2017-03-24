<?php
ob_clean();
class Syslog extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.
        if($checkAdmin != 'true'){
        	redirect('/control_panel/login/', 'refresh');
        }
	}
	
	//日志查询
	public function index()
	{
		$data = C::data($this);
		empty($data['day']) && $data['day']=date('Y-m-d');
		empty($data['hour']) && $data['hour']=date('H');
		empty($data['type']) && $data['type'] = 'www';
		$data['page'] = intval((int)$this->uri->segment(12)/30)+1;
		
		$this->load->library('pagination');
		$redata = array('value'=>1);
		if(!empty($data['keyword'])){
			//查询
			$redata = syslogd::search(array(
				'time'=>"{$data['day']} {$data['hour']}:00:00",
				'type'=>trim($data['type']),
				'keyword'=>trim($data['keyword']),
				'page'=>$data['page'],
				'n'=>30,
			));
			#分页配置
    		$this->pagination->initialize(array(
					'base_url'=>"/control_panel/syslog/index/day/{$data['day']}/hour/{$data['hour']}/type/{$data['type']}/keyword/{$data['keyword']}/",
					'total_rows'=>(int)$redata['num'],
					'uri_segment'=>12,
					'per_page'=>$redata['n'],
					'num_links'=>5,
					'anchor_class'=>'class="number" ',
					'cur_tag_open'=>'<a class="number current">',
					'cur_tag_close'=>'</a>',
				));
		}
		
		$this->load->view('control_panel/syslog/index', $data+$redata);
	}
	
}
?>