<?php
namespace Manage\Controller;
use Think\Controller;
class IndexController extends GlobalController {
    public function index(){
		$this->display();
    }
    public function dashboard()
    {
    	$works=array();
    	if($this->employee['is_super']=='1'){
			$map=array();
			$map['status'] = '1';
			$map['created'] = array('gt', date('Y-m-01'));
			$r = M('Project')->where($map)->count();
			$works[] = array('name'=>'本月新增项目','url'=>U('Project/index'),'count'=>$r);
			$r = M('Member')->where($map)->count();
			$works[] = array('name'=>'本月新增用户','url'=>U('Member/index'),'count'=>$r);
			
			$map=array();
			$map['status'] = '1';
			$r = M('Project')->where($map)->count();
			$works[] = array('name'=>'项目总数','url'=>U('Project/index'),'count'=>$r);
			$r = M('Member')->where($map)->count();
			$works[] = array('name'=>'用户总数','url'=>U('Member/index'),'count'=>$r);
    		
    	}else{
			$map=array();
			$map['status'] = '1';
			$map['project_id'] = $this->employee['project_id'];
			$map['created'] = array('gt', date('Y-m-d'));
			$r = M('PrizeLog')->where($map)->count();
			$works[] = array('name'=>'今日中奖用户','url'=>U('PrizeLog/index'),'count'=>$r);
			$r = M('GameLog')->where($map)->count();
			$works[] = array('name'=>'今日游戏记录','url'=>U('GameLog/index'),'count'=>$r);
			
			$data = $this->dateStat(date('Y-m-d'), 0);
			$works[] = array('name'=>'游戏总数','count'=>$data['gamelog'][0],'url'=>'');
			$works[] = array('name'=>'用户总数','count'=>$data['member'][0],'url'=>'');
			
			$project_cfg = unserialize($this->project['config']);
			$memberfrom=array(
				//'wx'=>array('微信','wx'),
				//'sina'=>array('新浪','sina'),
				//'qq'=>array('腾讯','qq'),
				//'web'=>array('WEB','web'),
			);
			$i=0;
			$sda=array();
			while(1){
				//需要设置活动开始和结束时间才能计算统计 超过30天不统计
				if( !(intval($project_cfg['start_date'])>0 && intval($project_cfg['end_date'])>0) ) break;
				if($project_cfg['end_date']-$project_cfg['start_date'] > 30*24*3600) break;
				if(time() < $project_cfg['start_date']) break;
				if(time() > $project_cfg['end_date']) break;
				$i++;
				$today = date('Y-m-d', strtotime('-'.$i.' day'));
				if(strtotime($today) < $project_cfg['start_date']) break;
	    		$_sda=array();
				$_sda[0] = $today.'日统计';
				$data2 = $this->dateStat($today, 1);
				$_sda[1][] = array('name'=>'交互总数','count'=>$data2['gamelog'][0],'url'=>'');
				foreach ($memberfrom as $v) {
				 	$_sda[1][] = array('name'=>'['.$v[0].']交互数','count'=>$data2['gamelog'][$v[1]]);
				}
				$_sda[1][] = array('name'=>'用户总数','count'=>$data2['member'][0],'url'=>'');
				foreach ($memberfrom as $v) {
				 	$_sda[1][] = array('name'=>'['.$v[0].']用户数','count'=>$data2['member'][$v[1]]);
				}
				$sda[] = $_sda;
			}
			$this->assign('sda', $sda);
		}
		$this->assign('works', $works);
    	$this->display();
    }
    
    function dateStat($date, $isf=1){
    	$sname = $this->employee['project_id'].'/st_'.$date;
    	$data = F($sname);
    	if($data) return $data;
    	$data = array();
    	
		$memberfrom=array(
			array('微信','wx'),
			array('WEB','web'),
		);
		
		$map1=array();
		$map1['status'] = '1';
		$map1['project_id'] = $this->employee['project_id'];
		$map1['created'] = array('BETWEEN', array($date, $date.' 23:59:59'));
		$data['gamelog'][0] = M('GameLog')->where($map1)->count();
		$data['member'][0] = M('ProjectMember')->where($map1)->count();
		if($isf) F($sname, $data);
		return $data;
    }
    function test(){
    	//print_r($this->dateStat('2015-03-11',0));
    	//print_r($this->dateStat('2015-03-10',0));
    	//print_r($this->dateStat('2015-03-09',0));
    }
    
	public function clearCache()
    {
    	$this->ctool->clearAllCache();
    	$this->success("清除缓存成功。");
    }
}