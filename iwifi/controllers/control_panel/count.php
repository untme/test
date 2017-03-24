<?php
/**
 * Mall 
 * 商场相关的操作
 * 
 *
 * @uses CI
 * @uses _Controller
 * @package 
 * @version $id$
 * @copyright 2015-2015 The AIWIFI Group
 * @author houweiozng <houweizong@gmail.com> 
 */
class Count extends CI_Controller {

	function __construct(){
		parent::__construct();

		//获取管理员是否后台登陆信息.
		$checkAdmin = $this->session->userdata('admin_islogin'); 

		if ($checkAdmin != 'true'){
			redirect('/control_panel/login/', 'refresh');
		}
        	
		$admin_type = $this->session->userdata('admin_type');
        	(!_auth($admin_type, 'super'))&&(!_auth($admin_type, 'analyze'))&& show_404();
	}


	/**
	 * index 
	 * 统计系统的后台列表首页
	 * 
	 *
	 * @access public
	 * @return void
	 */
	public function ulog(){
		$data['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data['title'] = "后台管理系统 - Aiwifi";
		$data['nav_title'] = '用户登录信息统计';
		$data['path'] = '用户登录信息统计';
		$this->load->library('pagination');
		$config['base_url'] = sprintf(
				'%scontrol_panel/%s/%s/%s/',
				$data['base'],
				strtolower(__class__),
				strtolower(__function__),
				$this->uri->segment(4)
				);
		$config['per_page'] = 50;
		$config['uri_segment'] = 5;
		$config['num_links'] = 10;
		$config['anchor_class'] = 'class="number" ';
		$config['cur_tag_open'] = '<a class="number current">';
		$config['cur_tag_close'] = '</a>';		
		$query = $this->uri->segment(4);
		$like = array();
		
		if($query!='0'){
			$args = array_map('urldecode', explode('_', $query));
			list($start, $end, $type, $key)= $args;
			///////////////////按注册地点查询///////////////////////
			if(!empty($key)){
				$like = array();
				if($type==2){
					$like['username'] = $key;  
				}elseif($type==1){
					$like['server_name'] = $key;
				}elseif($type==4){
					$like['store_name'] = $key;
				}
			}
			
			//////////////////按时间查询////////////////////////////
			if($start==0){	
				$start = date("Y-m-d H:i:s", 0);
				$today = strtotime($end);
				$yesterday = $today-24*60*60;
				$byesterday = $yesterday-24*60*60;
				$data['t'] = date("Y-m-d", $today);
				$data['y'] = date("Y-m-d", $yesterday);
				$data['by'] = date("Y-m-d", $byesterday);
			}else{  
				$today = strtotime($end);
				$yesterday = $today-24*60*60;
				$byesterday = $yesterday-24*60*60;
				$data['t'] = date("Y-m-d", $today);
				$data['y'] = date("Y-m-d", $yesterday);
				$data['by'] = date("Y-m-d", $byesterday);
			}	
		}else{
			$start = date("Y-m-d H:i:s", 0);
			$today = time();
			$end = date("Y-m-d H:i:s", $today);
			$yesterday = $today-24*60*60;
			$byesterday = $yesterday-24*60*60;
			$data['t'] = date("Y-m-d", $today);
			$data['y'] = date("Y-m-d", $yesterday);
			$data['by'] = date("Y-m-d", $byesterday);
		}
		$where = array(
			'_time >='=>$start,
			'_time <'=>$end
		);
		$data['total_rows'] = $this->aiwifi->comm_num_like_where(
                                'user_login_log',
                                $like,
                                $where
                                );
		$config['total_rows'] = $data['total_rows'];
		$data['logs'] = $this->aiwifi->comm_like_where(
                                'user_login_log',
                                $like,
                                $where,
                                '_id',
                                'DESC',
                                $config['per_page'],
                                $this->uri->segment(5)
                                );

		$data['t_total_rows'] = $this->aiwifi->comm_like_num(
					'user_login_log',
                    array_merge($like,array('_time'=>$data['t']))
					);
		$data['y_total_rows'] = $this->aiwifi->comm_like_num(
					'user_login_log',
                    array_merge($like,array('_time'=>$data['y']))
					);
		$data['by_total_rows'] = $this->aiwifi->comm_like_num(
					'user_login_log',
                    array_merge($like,array('_time'=>$data['by']))
					);			
		
		$data['max'] = $end;
		$data['min'] = $start!=date("Y-m-d H:i:s", 0)?$start:'';
		$data['key'] = empty($key)?'':$key;
		$data['type'] = empty($type)?'':$type;
		$this->pagination->initialize($config);
		$this->load->view('control_panel/count/ulog_list', $data);
	}

	/**
	 * index 
	 * 统计系统的后台列表首页
	 * 
	 *
	 * @access public
	 * @return void
	 */
	public function ureg(){
		$data['base'] = $this->config->item('base_url');
		$data ['source'] = $data ['base'].'source/';
		$data['title'] = "后台管理系统 - Aiwifi";
		$data['nav_title'] = '用户注册信息统计';
		$data['path'] = '用户注册信息统计';
		////////////////////////////配置分页组件//////////////////////
		$this->load->library('pagination');
		$config['base_url'] = sprintf(
				'%scontrol_panel/%s/%s/%s/',
				$data['base'],
				strtolower(__class__),
				strtolower(__function__),
				$this->uri->segment(4)
				);
		$config['per_page'] = 50;
		$config['uri_segment'] = 5;
		$config['num_links'] = 10;
		$config['anchor_class'] = 'class="number" ';
		$config['cur_tag_open'] = '<a class="number current">';
		$config['cur_tag_close'] = '</a>';
		// List all questions with language type.
		/////////////////////////////
		$query = $this->uri->segment(4);
		$like = array();
		if($query!='0'){
			$args = array_map('urldecode', explode('_', $query));
			list($start, $end, $type, $key)= $args;
			///////////////////按注册地点查询///////////////////////
			if(!empty($key)){
				$byRegAdress = true;
				$like = array();
				$like['store_name'] = $key;
			}
			
			//////////////////按时间查询////////////////////////////
			if($start==0){	
				$start = 0;
				$end = strtotime($end);	
				$today = $end;
				$todays = strtotime(date('Y-m-d 00:00:00', $today));
				$data['t'] = date("Y-m-d", $today);
			}else{  
				$start = strtotime($start);
				$end = strtotime($end);	
				$today = $end;
				$todays = strtotime(date('Y-m-d 00:00:00', $today));
				$data['t'] = date('Y-m-d', $end);
			}	
		}else{
			$start = 0;
			$end = time();
			$today = $end;
			$todays = strtotime(date('Y-m-d 00:00:00', $today));
			$data['t'] = date("Y-m-d", $today);
			
		}
		$where = array(
					'regTime >='=>$start,
					'regTime <'=>$end
				);
		$yesterday = $todays-24*60*60;
		$byesterday = $yesterday-24*60*60;
		$data['y'] = date("Y-m-d", $yesterday);
		$data['by'] = date("Y-m-d", $byesterday);
		
		$data['total_rows'] = $this->aiwifi->comm_num_like_where(
                                'user',
                                $like,
                                $where
                                );
		$config['total_rows'] = $data['total_rows'];
		$data['users'] = $this->aiwifi->comm_like_where(
                                'user',
                                $like,
                                $where,
                                'uid',
                                'DESC',
                                $config['per_page'],
                                $this->uri->segment(5)
                                );
		
		$data['t_total_rows'] = $this->aiwifi->comm_num_like_where(
					'user',
                                	$like,
					array(
						'regTime >='=>$todays,
						'regTime <='=>$today
					     )
					);
		$data['y_total_rows'] = $this->aiwifi->comm_num_like_where(
				'user',
                                $like,
				array(
					'regTime >='=>$yesterday,
					'regTime <'=>$todays
				     )
				);
		$data['by_total_rows'] = $this->aiwifi->comm_num_like_where(
				'user',
                                $like,
				array(
					'regTime >='=>$byesterday,
					'regTime <'=>$yesterday
				     )
				);

		$data['max'] = date('Y-m-d H:i:s', $end);
		$data['min'] = $start>1?date('Y-m-d H:i:s', $start):'';
		$data['key'] = empty($key)?'':$key;
		$this->pagination->initialize($config);
		$this->load->view('control_panel/count/ureg_list', $data);
	}
	
	function search($key){
		$key = urldecode($key);
		$mall = $this->aiwifi->comm_like_where(
				'store',
				array('store_name'=>$key),
				array(),	
                                'store_id',
                                'DESC',
                                100,
				0
				);
	        ob_clean();
		exit(json_encode($mall));	
	}	
}
