<?php
/**
 * Class ActivityAction
 * @title 加油卡活动
 * @author lizhi
 * @create on 2015-05-07
 */
header("Content-type:text/html;charset=utf-8");
class ActivityAction extends PublicAction {


    /**
     * @title 加油卡
     * @author lizhi
     * @create on 2015-05-05
     */
    public function get_glasses()
    {
        $this->error("对不起哦，请求页面出错咯！");
        die();
        $_SESSION = array();
        if(session('openid')==''){
            $code=$this->_get('code');
            if(!empty($code)){
                $open_id=get_openid($code);
            }elseif(!empty($_GET['openid'])){
                session('openid',$_GET['openid']);
            }
        }

        $this->assign('openid',$_SESSION['openid']);
        $user = M("user");
        //$rs = $user->field('username')->join('right join cms_user_integral on cms_user.openid=cms_user_integral.click_openid')->where('cms_user_integral.openid = "'.$_SESSION['openid'].'"')->select();

        $user_integral = M("user_integral");

        //关注者明细
        $rs = $user_integral->field('*')->where('cms_user_integral.openid = "'.$_SESSION['openid'].'"')->select();

        $come_count = $user_integral->where('openid = "'.$_SESSION['openid'].'"')->count();

        $this->assign('come_count',$come_count);

        if ($rs)
        {

            $this->assign('rs',$rs);
        }

        $this->isUserOrder();
        $this->display('get_glasses');
    }

    /*function jssdk(){
        $appid  = C('APPID');
        $secret = C('SECRET');
        $_title = '微信';
        $code = $_GET['code'];//获取code
        $_SESSION['code'] = $code;//设置code缓存给微信付账使用
        $auth = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token
        $jsonauth = json_decode($auth); //对JSON格式的字符串进行编码
        $arrayauth = get_object_vars($jsonauth);//转换成数组
        $openid = $arrayauth['openid'];//输出openid
        $access_token = $arrayauth['access_token'];
        $_SESSION['openid'] = $openid;

        $accesstoken = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."");//获取access_token
        $token = json_decode($accesstoken); //对JSON格式的字符串进行编码
        $t = get_object_vars($token);//转换成数组
        $access_token = $t['access_token'];//输出access_token

        $jsapi = file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi");
        $jsapi = json_decode($jsapi);
        $j = get_object_vars($jsapi);
        $jsapi = $j['ticket'];//get JSAPI

        $time = 14999923234;
        $noncestr= $time;
        $jsapi_ticket= $jsapi;
        $timestamp=$time;
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $and = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$noncestr."&timestamp=".$timestamp."&url=".$url."";
        $signature = sha1($and);
        return $signature;
    }*/



    /**
     * @title 分享链接显示给好友加油或者参加活动页
     * @author lizhi
     * @create on 2015-05-07
     */

    function test()
    {
        $this->error("对不起哦，小伙伴太给力，服务器都没办法使用啦！");
        die();
    }

    public function show_share_activity()
    {
        /*$this->error("对不起，小伙伴太给力，服务器都没办法使用啦！");
        die();*/
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        var_dump($_SESSION["openid"]);
        die();

        //获取来源的openid
        $share_user_openid = $_REQUEST['shareopenid'];

        //判断当前用户是否关注公众号
        $user = M("user");
        $check_user_guanzhu = $user->field('openid')->where("openid = '".$_SESSION[openid]."'")->count();
        $this->assign('check_user_guanzhu',$check_user_guanzhu);


        //当前用户获取点赞信息
        $user_integral = M("user_integral");

        //关注者明细
        $rs = $user_integral->field('*')->where('cms_user_integral.openid = "'.$share_user_openid.'"')->select();

        $come_count = $user_integral->where('openid = "'.$share_user_openid.'"')->count();

        $this->assign('come_count',$come_count);

        if ($rs){
            $this->assign('rs',$rs);
        }
        //end

        //判断是否满足点赞数
        $Daointegral = M("user_integral");
        $number = $Daointegral->where("openid='" . $_SESSION["openid"] . "'")->count();

        $Dao = M("come_order");
        $order = $Dao->where("openid ='" . $_SESSION["openid"] . "'")->count();

        $order_info = $Dao->where("openid ='" . $_SESSION["openid"] . "'")->find();
        //var_dump($order_info);

        $this->assign('number',$number);
        $this->assign('order',$order);
        $this->assign('order_info',$order_info);
   /*     echo '<pre>';
        print_r($order);*/

        //获奖用户的信息
        $gift_tmp = M('gift_tmp');
        $gift_data = $gift_tmp->where("openid ='" . $_SESSION["openid"] . "'")->find();

         if ($gift_data)
         {
             $this->display('notice_gift_info');
             die();
         }



        $user = M("user");
        $userinfo = $user->field('openid,username')->where("openid = '".$share_user_openid."'")->find();

        //获取当前用户的openid
        $this->assign('openid',$_SESSION['openid']);
        $this->assign('userinfo',$userinfo);

        $this->display('show_share_activity');
    }

    /**
     * @title 给好友点赞
     * @author lizhi
     * @create on 2015-05-07
     */
    public function getgood()
    {
        $_SESSION = array();
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }


        //echo $user->getLastSql();

        $share_openid = $_REQUEST['share_openid'];

        if (empty($share_openid))
        {
            $this->error('对不起，页面失效');
            exit();
        }

        if (empty($_SESSION['openid']))
        {
            $this->error('对不起，用户信息失效');
            exit();
        }
       /* print_r(array($share_openid,$_SESSION['openid']));
        die();*/

        if ($share_openid == $_SESSION['openid'])
        {
            echo '对不起，本人不可以给自己点赞哦';
            exit();
        }

        $user = M("user");
        $userinfo = $user->field('openid,username')->where("openid = '".$_SESSION[openid]."'")->find();

        //分享者
        $share_userinfo = $user->field('openid,username')->where("openid = '".$share_openid."'")->find();

        if ($userinfo)
        {
            $user_integral = M("user_integral");
            $user_integral->join("join cms_user on cms_user.openid = cms_user_integral.openid")->field('username');
            $check_click_data = $user_integral->where('click_openid = "'.$userinfo['openid'].'" and cms_user_integral.openid="'.$share_openid.'"')->find();

            if ($check_click_data)
            {
               /* echo "您好， 你已经为你的好友【".$check_click_data[username]."】点赞过了"."\n\n";
                echo "参加活动，请先关注微信号【didipeijing】";*/
                $this->redirect('hascome_activity',array('shareopenid'=>$_SESSION['openid']));
            }
            else
            {
                $data['openid']         = $share_userinfo['openid'];
                $data['weixin_key']     = $share_userinfo['username'];
                $data['click_openid']   = $userinfo['openid'];
                $data['click_username'] = $userinfo['username'];
                $user_integral->add($data);
                $this->redirect('come_success',array('shareopenid'=>$_SESSION['openid']));
            }
        }
        else
        {
            //echo "对不起，您暂时没有关注该微信号，请先关注微信号【didipeijing】";
            $this->redirect('guanzhu',array('shareopenid'=>$_SESSION['openid']));
        }
    }
    
    //成功点赞
     public function come_success()
    {
        $this->assign('openid',$_REQUEST['shareopenid']);
        $this->display();
    }

    public function guanzhu()
    {
        $this->assign('openid',$_REQUEST['shareopenid']);
        $this->display();
    }

    //提示已被点过赞
    public function hascome_activity()
    {
        $this->assign('openid',$_REQUEST['shareopenid']);
        $this->display();
    }

    /**
     * @title 用户下单
     * @author lizhi
     * @create on 2015-05-25
     */
    public function user_order()
    {

        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        $come_order = M("come_order");
        $add['username']    = $_REQUEST['username'];
        $add['openid']      = $_SESSION['openid'];
        $add['weixin_key']  = $_SESSION['username'];
        $add['tel']         = $_REQUEST['tel'];
        $add['address']     = $_REQUEST['address'];
        $add['gift']        = $_REQUEST['gift'];

        if (empty($_REQUEST['username']))
        {
            $this->error("收件人错误");
        }

        if(empty($_SESSION['openid']))
        {
            $this->error("当前用户信息错误");
        }

        if(empty($_REQUEST['tel']))
        {
            $this->error("手机错误");
        }

        if (empty($_REQUEST['address']))
        {
            $this->error("收货地址错误");
        }

        if (empty($_REQUEST['gift']))
        {
            $this->error("请选择礼物");
        }

        $count = $come_order->where("openid='".$_SESSION['openid']."'")->count();

        if($count==0){
            $rs = $come_order->add($add);
        }else{
            $this->error("您已经下过单");
        }

        $this->redirect('success');
    }

    function success()
    {
        $_SESSION = array();
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        $this->assign('openid',$_REQUEST['openid']);
        $this->display();
    }

    //判断用户是否重复下单 若超过50个赞赏只能下单一次 ，第二次不能下单 
    function isUserOrder(){
        //获取用户有多少张加油卡
        $Dao = M("come_order");
        $count = $Dao->where("openid ='".$_SESSION["openid"]."'")->count();
        
        if($count>0){
           $_SESSION["isOrder"]="true";
        }
    }
    
    //ajax到了40个赞
    function AjaxcomeCount(){
        $get_openid = $_REQUEST['get_openid'];

        if ($get_openid != $_SESSION['openid'])
        {
            $Daointegral = M("user_integral");
            $count["number"] = $Daointegral->where("openid='" . $_SESSION["openid"] . "'")->count();

            $Dao = M("come_order");
            $count["order"] = $Dao->where("openid ='" . $_SESSION["openid"] . "'")->count();

            echo json_encode($count);
        }
    }

	/*
	 *  活动首页
	 */	
    public function index(){
        $code=$this->_get('code');
		if(!empty($code)){
	    	$open_id=get_openid($code);
		}elseif(!empty($_GET['weixin_key'])){
			session('weixin_key',$_GET['weixin_key']);
		}
    	for($i=0;$i<12;$i++){
    		$t=strtotime("$i month");
    		$str=date("Y年m月", strtotime("$i month"));
    		$date_arr[]=array($t,$str);
    	}
     	$this->assign('list',$date_arr);
		$this->display();
    }
    
    /*
	 *  活动列表页
	 */	
    public function activity_list(){
    	$act_time=$this->_get('act_time');
    	$begin_time=strtotime(date('Y-m',$act_time).'-01');
    	$d_str=date('Y-m',$act_time).'-01';
    	$end_time=strtotime(date('Y-m-d', strtotime("$d_str +1 month -1 day")));
    	$news=M('news');
    	$act_where['create_time'] = array(array('egt',$begin_time),array('lt',$end_time+24*3600));
    	$act_where['status']=array('eq',1);
    	$act_where['is_del']=array('eq',0);
    	$act_where['type_id']=array('eq',6);
    	$news_list=$news->field('id,title')->where($act_where)->order('id DESC')->limit(30)->select();
    	 
    	$newstype=M('newstype');
	    $newstype->where("type_id=6")->setInc('click_num');
    	
     	$this->assign('list',$news_list);
		$this->display();
    }
    
    /*
	 *  活动列表页
	 */	
    public function activity_detail(){
    	$id=$this->_get('id');
    	$activity_apply=M('activity_apply');
    	$apply_where['act_id']=array('eq',$id);
    	$apply_where['weixin_key']=array('eq',session('weixin_key'));
    	$apple_res=$activity_apply->where($apply_where)->find();
    	
    	$list=get_news_detail($id,'title,content,create_time');
    	if(!empty($apple_res)){
    		$is_apple=3;#已报名
    	}elseif($list['create_time']<time()){
    		$is_apple=2;#已过期
    	}else{
    		$is_apple=1;#活动正常
    	}
    	$this->assign('is_apple',$is_apple);
     	$this->assign('list',$list);
     	$this->assign("seo_title",$list['title']);
		$this->display();
    }
    
    /*
	 *  活动报名
	 */	
    public function activity_apply(){
		$this->display();
    }
    
    
    /*
	 * AXAX提交活动报名
	 */	
    public function ajaxSubActivity(){
    	//session('weixin_key','ssdwukk');
    	$id=$this->_post('id');
    	$username=$this->_post('username');
    	$identity=$this->_post('identity');
    	$tel=$this->_post('tel');
    	$weixin_key=session('weixin_key');
    	if(!empty($weixin_key)){
    		$activity_apply=M('activity_apply');
    		$act_where['act_id']=array('eq',$id);
    		$act_where['weixin_key']=array('eq',$weixin_key);
    		$act_res=$activity_apply->where($act_where)->find();
    		if(!empty($act_res)){
    			$this->ajaxReturn('',"该活动你已经报过名了！",-2);
    		}else{
    			$add_data['act_id']=$id;
    			$add_data['username']=$username;
    			$add_data['identity']=$identity;
    			$add_data['weixin_key']=$weixin_key;
    			$add_data['tel']=$tel;
    			$add_data['create_time']=time();
    			$res=$activity_apply->add($add_data);
    			if($res){
    				$this->ajaxReturn('',"报名成功！",1);
    			}else {
    				$this->ajaxReturn('',"报名失败！",-5);
    			}
    		}
    	}else{
    		$this->ajaxReturn('',"请通过菜单重新进入！",-1);
    	}
    }
    
    
    /*
	 *  首页
	 */	
    public function wq_essence(){
    	$code=$this->_get('code');
		if(!empty($code)){
	    	$open_id=get_openid($code);
		}elseif(!empty($_GET['weixin_key'])){
			session('weixin_key',$_GET['weixin_key']);
		}
		$cur_time=strtotime('2014-01-01');
    	for($i=1;$i<13;$i++){
    		$t=strtotime("-$i month");
    		if($t>$cur_time){
    			$str=date("Y年m月", strtotime("-$i month"));
    		    $date_arr[]=array($t,$str);
    		}
    	}
     	$this->assign('list',$date_arr);
		$this->display();
    }
    
    public function ajaxMyActivity(){//我的活动-ajax分页
    	$p=$this->_get('p');#页
    	$begin_page=$p*8+1;  #开始
    	$end_page=$begin_page+8;
    	$activity=M('Activity');
    	$activity_where['is_del']=array('eq',0);
    	$activitys=$activity->field('id,title,logo,begin_time,end_time,age_begin,age_end,sign_end_time')->where($activity_where)->limit(8)->limit("$begin_page,$end_page")->order('create_time DESC')->select(); 
    	$agearr=C('USER_AGE');
    	foreach($activitys as $key=>$list){
    		$arr[$key]['id']=$list[id];
    		$arr[$key]['name']=$list[title];
    		$arr[$key]['logo']=$list[logo];
    		$arr[$key]['time']=date('Y-m-d H:i',$list[begin_time]).' 至 '.date('Y-m-d H:i',$list[end_time]);
    		$arr[$key]['age']=$agearr[$list['age_begin']].'-'.$agearr[$list['age_end']];
    		//if($act[end_time]<time()){$arr[$key]['status']='<i class="cutoff">已结束</i>';}elseif($act[sign_end_time]<time()){$arr[$key]['status']='<i class="cutoff">报名截止</i>';}elseif(in_array($act[id],$learn_arr)){$arr[$key]['status']='<i class="cutoff">已报名</i>';}else{$arr[$key]['status']='<i class="apply">我要报名</i>';}
    		if($act[end_time]<time()){$arr[$key]['status']='';}elseif($act[sign_end_time]<time()){$arr[$key]['status']='';}elseif(in_array($act[id],$learn_arr)){$arr[$key]['status']='<i class="cutoff">已报名</i>';}else{$arr[$key]['status']='<i class="apply">我要报名</i>';}
    	}
    	$this->ajaxReturn($arr,"",0);
    }
    
	/*
	 *  活动明细
	 */	
    public function detail(){
    	$id =intval($_GET['id']);
    	$activity=M('Activity');
    	$activitys=$activity->where("id=$id")->field('id,title,logo,address,activity_type,age_begin,age_end,begin_time,end_time,content,sign_end_time')->find();
    	//$aid=intval($_GET['id']);
    	$type=$activitys['activity_type'];   	
    	
    	$endtime=$activitys['end_time'];
    	$current=time();
    	$learn=M('learn');   	
    	$id=$activitys[id];   	
    	$le_where['related_id']=array('eq',$id);
    	$le_where['type_id']  =array('eq',1);
    	$le_where['weixin_key']  =array('eq',session('weixin_key'));
    	$wxk=$learn->where($le_where)->find();
    	if($activitys['end_time']<time()){
    		//$bm_status="<div class='apply-btn'><a style='background: #9f9f9f;border-color: #8e8e8e;box-shadow: inset 0 1px 0 0 #afafaf;'>已结束</a></div>";
    	}elseif($activitys['sign_end_time']<time()){
    		//$bm_status="<div class='apply-btn'><a style='background: #9f9f9f;border-color: #8e8e8e;box-shadow: inset 0 1px 0 0 #afafaf;'>报名截止</a></div>";
    	}elseif(!empty($wxk)){
    		//$bm_status="<div class='apply-btn'><a style='background: #9f9f9f;border-color: #8e8e8e;box-shadow: inset 0 1px 0 0 #afafaf;'>已报名</a></div>";
    	}else{
    		$bm_status="<div class='apply-btn'><a href='__URL__/apply/id/$id'>我要报名</a></div>";
    	}
    	$activity_type=C('ACTIVITY_TYPE');
    	$activitys[bm_status]=$bm_status;
    	$activitys['activity_type']=$activity_type[$activitys[activity_type]];
    	//判断活动时间是否为同一天
    	$beginday=date('Y-m-d',$activitys['begin_time']);
    	$endday=date('Y-m-d',$activitys['end_time']);
    	if($beginday==$endday){
    		$activitys['state']=1;
    	}else{
    		$activitys['state']=0;
    	}
    	
    	$this->assign('activity',$activitys);
    	//$activity_type=intval($activitys['activity_type']);
    	$now_time=time();
    	$correlations=$activity->where("activity_type=$type AND is_del=0 AND end_time>$now_time AND id<>$id")->field('id,title')->order('create_time desc')->select();
    	
    	$this->assign('correlation',$correlations);
    	$config=M('config');
    	$con=$config->field('tel,address')->find();
    	$this->assign('config',$con);
		$this->assign('agearr',C('USER_AGE'));
		$this->display('detail');
    }

    public function apply(){
    	$id =intval($_GET['id']);
    	$this->assign('id',$id);
    	$this->display('apply');
    }
    
    public function subAjax(){
    	    $add_date['weixin_key']=session('weixin_key');
    		$add_date['related_id']=$_POST['id'];
        	$add_date['create_time']=time();
    		$add_date['tel']=$_POST['tel'];
    		$add_date['name']=  $_POST['name'];
    		$add_date['sex']=  $_POST['sex'];
    		$year=           $_POST['year'];
    		$month=           $_POST['month'];
    		$day=           $_POST['day'];
    		$add_date['birthday']= strtotime("$year-$month-$day");
    		$learn=M('Learn');
    		$activity=M('activity');
    		$act_res=$activity->where("id=$add_date[related_id]")->field('limit_num')->find();
    		if($act_res['limit_num']>0){ #判断活动是否限制人数
    			$cou_where['related_id']=array('eq',$add_date[related_id]);
    			$cou_where['type_id']=array('eq',1);
    			$count=$learn->where($cou_where)->count(); #已报名人数
    			
    			if($act_res['limit_num']<$count or $act_res['limit_num']==$count){
    				echo -1;exit;
    			}
    		}
    		$weixin_key=session('weixin_key');
    		$old_where['type_id']=array('eq',1);
    		$old_where['related_id']=array('eq',$add_date[related_id]);
    		$old_where['weixin_key']=array('eq',"$weixin_key");
    		$lesrn_res=$learn->where($old_where)->field('id')->find();
    		if(!empty($lesrn_res)){
    			echo -2;exit;
    		}
    		
    		$result=intval($learn->add($add_date));
    		if ($result){
    			echo 1;
    		}else {
    			echo 0;
    		}
    		exit;
    }
    

}


?>