<?php

class upgrade extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $checkAdmin = $this->session->userdata('admin_islogin'); //获取管理员是否后台登陆信息.
        if($checkAdmin != 'true'){
            redirect('/control_panel/login/', 'refresh');
        }
    }
    /*
     * upgrade list
     */
    public function index(){

        $data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
        $data['title'] = "后台管理系统 - Aiwifi";
        $data['nav_title'] = '宽带升级方案管理';
        $data['path'] = '宽带升级方案管理';

        $data['upgrade'] = $this->aiwifi->comm_list('service_case');
        $case = $this->aiwifi->comm_list('service');
        foreach($data['upgrade'] as $key => $value){
            foreach($case as $v){
                if($v['id'] == $value['case_id']){
                    $data['upgrade'][$key]['case_id'] = $v['title'];
                }
            }
        }
        $this->load->view('control_panel/upgrade/upg_list',$data);
    }

    /*
     * new upgrade
     */
    public function new_upg(){
        if($_POST){
            $info['case_id'] = $this->input->post('case_id');
            $info['ad_num'] = $this->input->post('ad_num');
            $this->aiwifi->comm_instert('service_case', $info);

           redirect('/control_panel/upgrade/index/', 'refresh');
        }

        //添加页面
        $data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
        $data['title'] = "后台管理系统 - Aiwifi";
        $data['nav_title'] = '宽带升级方案管理';
        $data['path'] = '宽带升级方案管理';
        $data['case'] = $this->aiwifi->comm_list('service');
        //删除已经添加的
        $data['upgrade'] = $this->aiwifi->comm_list('service_case');
        foreach($data['case'] as $key => $value){
            foreach($data['upgrade'] as $k => $v){
                if($value['id'] == $v['case_id']){
                    unset($data['case'][$key]);
                }
            }
        }
        $this->load->view('control_panel/upgrade/upg_new',$data);
    }

    /*
     * modefy upgrade
     */
    public function modify_upg($id){
        if($_POST){
            $info['id'] = $this->input->post('id');
            $info['case_id'] = $this->input->post('case_id');
            $info['ad_num'] = $this->input->post('ad_num');
            $this->aiwifi->comm_update('service_case', $info, 'id', $info['id']);
            redirect('/control_panel/upgrade/index/', 'refresh');
        }
        //记录信息
        $data['base'] = $this->config->item('base_url');
        $data ['source'] = $data ['base'].'source/';
        $data['title'] = "后台管理系统 - Aiwifi";
        $data['nav_title'] = '宽带升级方案管理';
        $data['path'] = '宽带升级方案管理';
        $data['case'] = $this->aiwifi->comm_list('service');
        $data['upgrade'] = $this->aiwifi->comm_info('service_case', 'id', $id);
        foreach($data['case'] as $value){
            if($value['id'] == $data['upgrade']['case_id']){
                $data['upgrade']['case_title'] = $value['title'];
            }
        }
        $this->load->view('control_panel/upgrade/upg_modify',$data);
    }

    /*
     * delete upgrade
     */
    public function delete_upg(){
        $id = $this->input->post('id');

        $this->aiwifi->comm_del('service_case', 'id', $id);

        echo 1;
    }


}

/* End of file upgrade.php in the controllers*/