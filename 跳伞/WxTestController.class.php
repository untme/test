<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
use Com\CIA\WechatAuth;
use Com\CIA\Wechat;
class WxTestController extends Controller {
    public $token ="bpat";
    public $AppID ="wx98f88ea5f4791167";
    public $AppSecret ="2dbabd5a854dcaec0ef0f13db1d4bb8c";
    public $accessToken;
	private $data,$wechat;
    public $user;
    public function index(){
        
    	define("TOKEN", "bpat");
        // $this->valid();
    	$this->wechat= new Wechat($this->token);
        $token=$this->getToken();
        $this->accessToken=$token;
    	$this->data = $this->wechat->request();
        $this->user=$user=$this->wechatAuth->userInfo($this->data['FromUserName']);
        unset($user['subscribe']);
        unset($user['language']);
        unset($user['tagid_list']);
        unset($user['unionid']);
        $is_user=M("User")->where("openid='".$this->data['FromUserName']."'")->find();       
        if ($is_user) {
            M("User")->where("openid='".$this->data['FromUserName']."'")->save($user);
        }else{
            M("User")->add($user);
        }
    	// 判断是否触发了事件
    	if($this->data['MsgType']=='event'){
    		$this->event($this->data['Event']);
    	}else{
    		$this->msgtype($this->data['MsgType']);
    	}
    }
    public function getToken(){
        
        // S("access_token",null);
        if (S('access_token')) {
            $token=S('access_token');
            $b=$this->wechatAuth= new WechatAuth($this->AppID,$this->AppSecret,$token);
        }else{
            $b=$this->wechatAuth= new WechatAuth($this->AppID,$this->AppSecret);
            $token=$this->wechatAuth->getAccessToken();
            S(array('type'=>'file','expire'=>7200,'prefix'=>'bpat'));
            S('access_token',$token['access_token']);
            $token=$token['access_token'];
        }
        return $token;
    }
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
                
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        
        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
	public function event($event){
    	switch ($event) {
    		case Wechat::MSG_EVENT_SUBSCRIBE://关注事件

    			// 获取access_token
				/*$text="欢迎你加入李宁品牌官方微信。\r\n点击下方菜单栏：\r\n【品牌+】可浏览最近李宁品牌及其运动资源相关的赛事、活动及资讯信息；\r\n【体验+】可了解当季新品；\r\n【服务+】可查找附近的店铺信息以及其它服务类信息";*/
                // $this->wechatAuth= new WechatAuth($this->AppID,$this->AppSecret,$this->accessToken);
                // 获取个人信息
                $user = $this->wechatAuth->userInfo($this->data['FromUserName']);
                // $this->wechat->replyText($user['errcode']);
                if ($user['errcode']!=40013) {
                    unset($user['language']);
                    unset($user['subscribe']);
                    unset($user['tagid_list']);
                    unset($user['unionid']);
                    $is_user=M("User")->where("openid='".$this->data['FromUserName']."'")->find();
                    if ($is_user) {
                        $aa=M("User")->where("openid='".$this->data['FromUserName']."'")->save($user);
                    }else{
                        M("User")->add($user);
                    }
                }
				// $new=array(
				// 	'欢迎关注李宁官方微信，点击进入首页！',
				// 	 "★你可随时输入【首页】获得本页面推送\r\n★发送对话框下面“+”菜单中的“位置”，可以查询离你最近的李宁门店\r\n\r\n更多功能请进入首页查看帮助",
    //                 //"★你可随时输入【首页】获得本页面推送\r\n\r\n更多功能请进入首页查看帮助",
				// 	'http://lining.iblacktree.com/Index/home',
    //                 // 'http://lining.qiniudn.com/1456712529670.jpg'
				// 	'http://lining.iblacktree.com/Public/img/1456712529670.jpg'
				// );
				// $this->wechat->replyNews($new);  
                $this->wechat->replyText("嘿，相遇总是美好的，很幸运你发现了我。");  
    			break;
    		case Wechat::MSG_EVENT_UNSUBSCRIBE://取消关注事件
    			break;
    		case Wechat::MSG_EVENT_CLICK:
                // if ($this->data['EventKey']=="contact_us") {
                //     $content="你好，如果有任何问题，请拨打我们的客服电话";
                //     $this->wechat->replyText($content);
                // }
    			break;
            case Wechat::MSG_EVENT_SCAN:
            /*管理员扫码弹出：

            订单号：565466511
            下单时间：2016.08.23
            刘璨
            男
            1987.11.08
            135 6655 4478
            北京训练场
            8000米 手持摄像

            扫码验证通过


            用户将收到：

            订单号：565466511
            下单时间：2016.08.23
            刘璨
            男
            1987.11.08
            135 6655 4478
            北京训练场
            8000米 手持摄像

            已扫码验证*/
                // $this->wechat->replyText('扫码获取事件：'.$this->data['EventKey']);
                $ordernumber=$this->data['EventKey'];
                $order=M("Order")->where("ordernumber='$ordernumber'")->find();
                $content="订单号：".$order['ordernumber']."\r";
                $content.="下单时间：".$order['addtime']."\r";
                $content.=$order['name']."\r";
                $content.=($order['gender']==0) ? "男"."\r" : "女"."\r";
                $content.=$order['birthday']."\r";
                $content.=$order['mobile']."\r";
                $content.=$order['basename']."\r";
                $content.=$order['planname']."\r";
                $content.=$order['date']."\r";
                $status=array("-1"=>"取消","0"=>"全额未付款","1"=>"定金未付款","2"=>"定金已付","3"=>"尾款线上已付","4"=>"尾款现金已付","5"=>"尾款刷卡已付","6"=>"全额线上已付","7"=>"全额线下现金已付","8"=>"全额线下刷卡已付","9"=>"已完成跳伞");
                $content.=$status[$order['status']]."\r\r";
                $content1=$content."扫码验证通过";
                $content2=$content."已扫码验证";
                $admin=array("oofSRwiZZa-xAMing2xVXLnt5EOc","oofSRwle8onh6mdkxvV_VskwhExI","oofSRwhiSMbnWR5fNen2cHs7Se4M","oofSRwlFFbwMyfOBJgLLSNYeoLrU");
                if (in_array($this->data['FromUserName'], $admin)) {
                    $this->wechatAuth->messageCustomSend($order['openid'],$content2);
                    $this->wechat->replyText($content1);
                }else{
                    echo "";
                }
                
                break;
    		case 'scancode_push':
    			// $this->wechat->replyText('扫码获取事件：'.$this->data['EventKey']);
    			break;
    	}
	}
    public function msgtype($msgtype){
    	switch ($msgtype) {
    		case Wechat::MSG_TYPE_TEXT://文本消息
    				$content=$this->data["Content"];
                    $where="name='".trim($content)."' and status > '-1'";
                    $replyData=M("Text")->where($where)->find();
                    if ($replyData) {
                        $this->wechat->replyText($replyData['content']);
                    }else {
                        $whe="keyword='".trim($content)."' and status > '-1'";
                        $rows=M("News")->where($whe)->select();
                        if ($rows) {
                            $news=array();
                            foreach ($rows as $k => $v) {
                                $news[]=array(
                                    $v['title'],
                                    str_replace("|", "\r\n", $v["description"]),
                                    $v['url'],
                                    "http://".$_SERVER['HTTP_HOST'].ltrim($v['picurl'],".")
                                );
                            }
                            $this->wechat->response($news,"news");
                        }else{
                            echo "";
                        }
                    }
    			break;
    		case Wechat::MSG_TYPE_IMAGE://图片消息
                /*$media_id=$this->data['MediaId'];
                $image=$this->wechatAuth->mediaGet($media_id);
                $image=file_get_contents($image);
                $name=mt_rand(100,1000).time().".jpg";
                $r=file_put_contents("./Public/Wx/".$name, $image);
                $data=array();
                $data['openid']=$this->data['FromUserName'];
                $data['nickname']=$this->user['nickname'];
                $data['content']="./Public/Wx/".$name;
                $data['type']="image";
                $data['addtime']=$this->data['CreateTime'];
                M("Message")->add($data);*/
    			// $this->wechat->replyText('您的消息我们收到啦，感谢您对泛太平洋的支持与关注！');
    			// $this->wechat->replyImage($this->data['MediaId']);
    			break;
    		case Wechat::MSG_TYPE_VOICE://语音消息
    			// $this->wechat->replyVoice($this->data['MediaId']);
                echo "";
    			break;
    		case Wechat::MSG_TYPE_VIDEO://视频
    			// $this->wechat->replyVideo($this->data['MediaId'],'标题','简介');
                echo "";
    			break;
    		case Wechat::MSG_TYPE_SHORTVIDEO://小视频，Wechat未实现功能方法
    			// $this->wechat->replyVideo($this->data['MediaId'],'标题','简介');
                echo "";
    			break;
    		case Wechat::MSG_TYPE_LOCATION://地理位置消息
                /*$location=array();
                $location['openid']=$this->data['FromUserName'];
                $location['nickname']=$this->user['nickname'];
                $location['lat']=$this->data['Location_X'];
                $location['lng']=$this->data['Location_Y'];
                $location['lable']=$this->data['lable'];
                $location['addtime']=$this->data['CreateTime'];
                $location['type']="location";
                M("Message")->add($location);
                $news=$this->getNews();
                $this->wechat->response($news,"news");*/
                /*$news=$this->getNews();
                $this->wechat->response($news,"news");*/
                // $this->wechat->replyText($a);
                // echo "";
                // $this->wechat->replyText("你的坐标是".$this->data['Location_X'].",".$this->data['Location_Y']);
                echo "";
    			break;
    		case Wechat::MSG_TYPE_LINK://链接消息
    			# code...
    			break;
    	}
    }
    public function getNews(){
        $re=$this->getlist();
        /*$news = array(
            $row['title'],
            "",
            $row['link'], 
            $row['picurl'],
        );*/
        $news=array();
        if ($re) {
            $news[]=array(
                "找到以下".count($re)."个距您最近的店铺，点击查询李宁全国店铺",
                "",
                "http://lining.iblacktree.com/Map/all/lat/".$this->data['Location_X']."/lng/".$this->data['Location_Y']."/lable/".$this->data['Label'],
                "http://lining.iblacktree.com/Public/images/1-1_1.jpg"
            );
            foreach ($re as $k => $v) {
                $url=getHost().U("Map/index",array("id"=>$k,"lat"=>$this->data['Location_X'],"lng"=>$this->data['Location_Y']));
                if ($v['distance']>1000) {
                    $meter=($v['distance']/1000)."公里";
                }else{
                    $meter=$v['distance']."米";
                }
                $news[]=array(
                    $v['mingcheng']." 距离: ".$meter,
                    "","$url","",
                );
            }
        }else{
            $news[]=array(
                "对不起，在您附近暂未找到李宁的店铺",
                "点击查询李宁全国店铺",
                "http://lining.iblacktree.com/Map/all/lat/".$this->data['Location_X']."/lng/".$this->data['Location_Y'],
                "http://lining.iblacktree.com/Public/images/1-1_1.jpg"
            );
        }
        return $news;
    }
    public function getlist(){
        $citys=M("Shop")->field("distinct city")->cache(true)->select();
        $lable=$this->data['Label'];
        foreach ($citys as $k => $v) {
            if (preg_match("/".$v['city']."/", $lable)) {
                $city=$v['city'];
                break;
            }
        }
        if ($city) {
            $shops=M("Shop")->where("city='{$city}' and lat!='' and lng!=''")->field("id,mingcheng,lat,lng")->select();
        }else{
            $shops=M("Shop")->where("lat!='' and lng!=''")->field("id,mingcheng,lat,lng")->select();
        }
        if ($shops) {
            $distance=array();
            foreach ($shops as $k => $v) {
                $distance[$v['id']]=getDistance($this->data['Location_X'],$this->data['Location_Y'],$v['lat'],$v['lng']);
            }
            asort($distance);
            $nin=array_slice($distance,0,9,true);
            $nine=array();
            foreach ($nin as $k => $v) {
                if ($v<10000) {
                    $nine[$k]=$v;
                }
            }
            if (!empty($nine)) {
                $ids=array_keys($nine);
                $whe['id']=array("IN",$ids);
                $data=M("Shop")->where($whe)->getField("id,mingcheng",true);
                $list=array();
                foreach ($nine as $k => $v) {
                    $list[$k]["distance"]=$v;      
                    $list[$k]["mingcheng"]=$data[$k];      
                }  
                return $list;
            }else{
                return false;
            }
              
        }else{
            return false;
        }
            
    }    
    public function edit(){    	 
    	
    	$apps_id = intval(I('get.apps_id'));
    	
    	$data = M($this->model)->find($apps_id);
    	
    	//获取应用信息
    	$appid = $data['appid'];		
		C(include CACHE_PATH.LANG_SET.'.WxApps.php');
		$cache = C('WxApps');
		$cache = $cache[$appid];
		if (!is_array($cache))$this->error("未获取接口信息");		
		$corpid = $cache['corpid'];
    	$corpsecret = $cache['corpsecret'];    	
    	$token = file_get_contents("./Public/".$corpid."_".$appid."_access_token.json");
		$wa = new WechatAuth($corpid, $corpsecret, $token, true);
		$rst = $dept = $wa->getAgent($appid);
		if ($rst['errcode'] != '0')$this->error($rst['errmsg']);
    	//更新可视范围
    	$allow_partys = $rst['allow_partys']['partyid'];
    	$allow_userinfos = $rst['allow_userinfos']['user'];
    	$allow_tags = $rst['allow_tags']['tagid'];
    	
    	if (count($allow_partys))
    	$deptList = M("WxDepartment")->where("id in (".join(",",$allow_partys).")")->select();
    	
    	if (count($allow_userinfos))
    	{
    		$userArr = array();
    		for($i = 0; $i < count($allow_userinfos); $i++)
    		{
    			$userArr[] = $allow_userinfos[$i]['userid'];
    		}
    		
	    	$memberList = M("WxUser")->where("id in ('".join("','",$userArr)."')")->select();
	    	
	    }
	    $data['redirect_domain'] = $rst['redirect_domain'];
	    $this->assign("data", $data);
	    $this->assign("deptList", $deptList);
	    $this->assign("memberList", $memberList);
    	$this->assign("sideBar", $this->sideBar);
		$this->display();
    }
    public function save()
	{		
		$data = I('post.data');		
		$corpid = trim($data['corpid']);
		$name = trim($data['name']);
		$id = intval($data['id']);
        if ($corpid == "") $this->error("应用ID不能为空");
        if ($name == "") $this->error("应用名称不能为空");
        if ($data['wx_type'] == "3" && intval($data['appid']) <= 0) $this->error("应用ID必须大于0");
        $dao = M($this->model);
        if ($id > 0)
        {
            //判断同级名称重复问题
            $count = $dao->where("id != '$id' and company_id = '".$this->employee['company_id']."' and corpid = '$corpid'")->count();
        }
        else
        {
            //判断同级名称重复问题
            $count = $dao->where("corpid = '$corpid' and company_id = '".$this->employee['company_id']."'")->count();
        }
        if ($count > 0) $this->error("同一帐号下应用已存在。"); 
        if ($data['wx_type'] != "3")$data['appid'] = null;      
        $data['company_id'] = $this->employee['company_id'];
        $data['updated'] = NOW;       
        $logTitle = "新增";
        if ($id > 0)
        {

            $dao->save($data);            
            $logTitle = "修改";
        }
        else
        {
        	$data['created'] = NOW;
            $id = $dao->add($data);            
        }
        $this->cacheWxApps();
        $logSql[]= $dao->_sql();
        $this->_loger($logTitle, $id, $logSql);	
        $this->success("操作成功", U('index'));	        
	}
    public function menu(){    	 
    	
    	$apps_id = intval(I('get.apps_id'));
		
		$catList = array();
		$catList = M("WxMenu")->where("apps_id = '$apps_id'")->order("sort asc, pid asc, id asc")->select();
       
        $this->assign("dataList", $catList);
		
    	$this->assign("sideBar", $this->sideBar);
		$this->display();
    }
    public function menuEdit(){    	 
    	$id = intval(I('request.id'));
    	$apps_id = intval(I('request.apps_id'));
		$pid = intval(I('request.pid'));		  
        $dao = M("WxMenu");
        $data = array();
        if ($id > 0)
        {
            $data = $dao->where("id = '$id' and apps_id = '$apps_id' and company_id = '".$this->employee['company_id']."'")->find();
            
        }
        //新增
        else
        {          
        	$apps_id = intval(I('apps_id'));
            $data['pid'] = $pid;
            $data['apps_id'] = $apps_id;
        }        
        $this->assign("data", $data);
        
        $this->assign("sideBar", $this->sideBar);		
		$this->display();
    }
    public function menuSave()
	{		
		$data = I('post.data');
		$id = intval($data['id']);
		$pid = intval($data['pid']);
		$apps_id = intval($data['apps_id']);
		$name = trim($data['name']);
        if ($name == "") $this->error("菜单名称不能为空");
        $dao = M("WxMenu");
        $count = 0;
        if ($id > 0)
        {
            //判断同级名称重复问题
            $count = $dao->where("id != '$id' and name = '$name' and pid = '$pid' and apps_id = '$apps_id' and company_id = '".$this->employee['company_id']."'")->count();
        }
        else
        {
            //判断同级名称重复问题
            $count = $dao->where("name = '$name' and pid = '$pid' and apps_id = '$apps_id' and company_id = '".$this->employee['company_id']."'")->count();
        }
        if ($count > 0 )$this->error("同一级别，已有重名。");
		$data['company_id'] = $this->employee['company_id'];
        $data['updated'] = NOW;
        $data['company_id'] = $this->employee['company_id'];
        $logTitle = "新增";
        if ($id > 0)
        {
            $dao->save($data); 
            $logTitle = "修改";  
            $logSql[]= $dao->_sql(); 
        }
        else
        {
        	$data['created'] = NOW;
        	$id = $dao->add($data);
        	$logSql[]= $dao->_sql();
        	 //新增时只需处理父节点   
        	if ($pid > 0)
            {
                $da = array();
                $da["id"] = $pid;
                $da["children_count"] = array('exp', 'children_count + 1');
                $dao->save($da);
                
                $logSql[]= $dao->_sql();
            }         
        }        
          
        $this->_loger($logTitle, $id, $logSql);  
        $this->success("操作成功", U('menu', array("apps_id"=>$apps_id)));   
	}
	public function menuSync()
	{		
		$apps_id = intval(I('get.apps_id'));
		
		//删除原来的数据
		$dao = M('WxMenu');
		$dao->where("company_id = '".$this->employee['company_id']."' and apps_id = '$apps_id'")->delete();
		$logSql[]= $dao->_sql();
		$wa = $this->getWechatAuthInstance($apps_id);
		$cache = C('WxApps');
		$v = $cache[$apps_id];		
		$rst = $wa->menuGet($v['appid']);		 
		//print_r($rst);
		//exit;
		$menuData = array();
		$button = $rst['menu']['button'];
		for($i = 0; $i < count($button); $i++)
		{
			$menu = array();
			$menu['company_id'] = $this->employee['company_id'];
			$menu['apps_id'] = $apps_id;
			$menu['pid'] = '0';
			$menu['name'] = $button[$i]['name'];
			$menu['menu_key'] = $button[$i]['key'];
			$menu['menu_type'] = $button[$i]['type'];
			if ($button[$i]['type'] == '')
			{
				$menu['menu_type'] = 'menu';
			}
			else if ($button[$i]['type'] == 'view')
			{
				$menu['view_url'] = $button[$i]['url'];
			}
			$id = $dao->add($menu);
			$logSql[]= $dao->_sql();
			if (count($button[$i]['sub_button']))
			{
				for($j = 0; $j < count($button[$i]['sub_button']); $j++)
				{	
					$row = $button[$i]['sub_button'][$j];
					$menu = array();
					$menu['company_id'] = $this->employee['company_id'];
					$menu['apps_id'] = $apps_id;
					$menu['pid'] = $id;
					$menu['name'] = $row['name'];
					$menu['menu_key'] = $row['key'];
					$menu['menu_type'] = $row['type'];
					if ($row['type'] == '')
					{
						$menu['menu_type'] = 'menu';
					}
					else if ($row['type'] == 'view')
					{
						$menu['view_url'] = $row['url'];
					}
					$dao->add($menu);
					$logSql[]= $dao->_sql();
				}
			}
		}
		$logTitle = '同步订单';
		$this->_loger($logTitle, null, $logSql);  
        $this->success("操作成功", U('menu', array("apps_id"=>$apps_id))); 
	}
	public function menuDelete()
	{
		$id = intval(I('post.id'));
		$pid = intval(I('post.pid'));
		$apps_id = intval(I('post.apps_id'));		
		if ($id > 0)
		{
			$dao = M("WxMenu");
			$cat = $dao->where("apps_id = '$apps_id' and id = '$id'")->find();
			
			if ($cat['children_count'] > 0)$this->error('此菜单下有子菜单不允许删除');
			if (is_array($cat) && $cat['pid'] > 0)
			{								
				$parentCat['id'] = $cat['pid'];
                $parentCat["children_count"] = array('exp', 'children_count - 1');	                
                $dao->save($parentCat);
                $logSql[] = $dao->_sql();
			}
			$dao->where("apps_id = '$apps_id' and id = '$id'")->delete();
			$logSql[]= $dao->_sql();  
			//删除永久素材			
		}
		else
		{
			$this->error('参数传输错误');	
		}
		$logTitle = "彻底删除";
		
        $this->_loger($logTitle, $id, $logSql);             
        $this->success("操作成功", U('menu', array('apps_id'=>$apps_id)));   
	}
	
	public function createMenu()
    {    			
    	$data = I('post.data');
    	
    	$apps_id = $data['apps_id'];
		
		$menu = array();
		//查找数据库中的菜单
		$list = M("WxMenu")->where("apps_id = '$apps_id' and company_id = '".$this->employee['company_id']."'")->order("pid asc, sort asc")->select();
		$pmenu = array();
		for($i = 0; $i < count($list); $i++)
		{
			$row = $list[$i];
			if ($row['pid'] == '0')
			{
				$arr = array();
				if ($row['menu_type'] != 'menu')
				{
					$arr['type'] = $row['menu_type'];	
				}
				$arr['name'] = $row['name'];	
				if ($row['menu_type'] == 'menu')
				{
					$arr['sub_button'] = array();	
					$pmenu[] = $row['id'];
				}
				else if ($row['menu_type'] == 'view')
				{
					$arr['url'] = $row['view_url'];	
				}
				else if (in_array($row['menu_type'], array('click', 'scancode_push','scancode_waitmsg','pic_sysphoto','pic_photo_or_album','pic_weixin','location_select')))
				{
					$arr['key'] = $row['menu_key'];	
					if ($row['menu_type'] != 'click' && $row['menu_type'] != 'location_select')$arr['sub_button'] = array();
				}
				else if ($row['menu_type'] == 'media_id' || $row['menu_type'] == 'view_limited')
				{
					$arr['media_id'] = $row['media_id'];	
				}
				$menu[$row['id']] = $arr;	
			}	
			//子菜单
			else if (!in_array($row['pid'], $pmenu))
			{
				$arr = array();
				$arr['type'] = $row['menu_type'];
				$arr['name'] = $row['name'];
				if (in_array($row['menu_type'], array('click', 'scancode_push','scancode_waitmsg','pic_sysphoto','pic_photo_or_album','pic_weixin','location_select')))
				{
					$arr['key'] = $row['menu_key'];	
					if ($row['menu_type'] != 'click' && $row['menu_type'] != 'location_select')$arr['sub_button'] = array();
				}
				else if ($row['menu_type'] == 'media_id' || $row['menu_type'] == 'view_limited')
				{
					$arr['media_id'] = $row['media_id'];	
				}
				else
				{
					$arr['url'] = $row['view_url'];		
				}				
				$menu[$row['pid']]['sub_button'][] = $arr;	
			}
		}		
		$button = array();
		foreach($menu as $k => $v)
		{
			$button[] = $v;
		}
		//print_r($button);
		//exit;
		//$body = json_encode($body);
		//$body = stripslashes(preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $body));		
		
		$wa = $this->getWechatAuthInstance($apps_id);
		$cache = C('WxApps');
		$v = $cache[$apps_id];
		$appid = $v['appid'];
		$isCorp = false;
		if ($v['wx_type'] == '3')$isCorp = true;
		if (!$isCorp)$appid = '';			
		$rst = $wa->menuCreate($button, $appid);
		
    	if ($rst['errcode'] == '0')
    	{
    		$this->success('公众号菜单发布成功。');
    	}
    	else
    	{
    		$this->error($rst['errmsg']."公众号菜单发布失败");
    	}	
   	}
   	public function deleteMenu()
    {    	
    	$data = I('post.data');
    	
    	$apps_id = $data['apps_id'];		
		$wa = $this->getWechatAuthInstance($apps_id);
		$cache = C('WxApps');
		$v = $cache[$apps_id];		
		$rst = $wa->menuDelete($v['appid']);
		
    	if ($rst['errcode'] == '0')
    	{
    		$this->success('删除微信菜单成功。');
    	}
    	else
    	{
    		$this->error($rst['errmsg']."删除微信菜单失败");
    	}	
   	}
   	public function seledtWxApp()
    {    	
    	$apps_id = I('get.apps_id');
    	$list = M("WxApps")->where("id = '$apps_id' and status = '1'")->select();
    	$this->assign("list", $list);
    	$this->display();
   	}
}
