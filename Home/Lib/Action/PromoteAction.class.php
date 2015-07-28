<?php
//员工通道入口
//1.获取用户信息，
//		未登录过： 让其填写员工身份，业务员，设计师。。
//		登录过  ： 根据身份判断跳转到对应页面

class PromoteAction extends PublicAction
{
    public function index()
    {
        $code = $this->_get('code');
        check_openid($code);
        $openid = session('openid');
        if ($openid == null) {
            $openid = 0;
			#echo 11;
			exit;
        }
		
		#session('openid','oWaRTuEhODLNahGWzyWRfLH_q5_0');
		
		$user=M('user');
		$u_where['openid']=array('eq',session('openid'));
		$u_data['status']=1;
		$userInfo = $user->where($u_where)->limit(1)->select();
		$is_promote = $userInfo[0]['is_promote'];
		$user_id = $userInfo[0]['user_id'];
		$code_id = $user_id;
		
		/*
		$code = M('code');
		$code_where['user_id'] = array('eq',$user_id);
		$codeRes = $code->where($code_where)->limit(1)->select();
		if($codeRes){
			$code_id = $codeRes[0]['id'];
		}else{
			$c_data['title'] = $userInfo[0]['username'];
			$c_data['info_id'] = '';
			$c_data['label_id'] = '';
			$c_data['vip_id'] = '';
			$c_data['user_id'] = $user_id;
			$c_data['keywords'] = '';
			$c_data['images'] = '';
		
			
			$code_id = $code->add($c_data);
			
		}
		*/
		
		//粉丝
		$sql_fans = "select u.username from cms_user_customer as uc 
		left join cms_user as u on uc.customer_id = u.user_id 
		where uc.user_id = {$user_id} and is_zhipai=0
		";
		$fans_list = M()->query($sql_fans);
		
		
		//房间列表
		$sql_fangjian = "select  c.* from cms_user_customer as uc 
		left join cms_customer as c  on c.id = uc.fangjian_id
		where  uc.user_id = {$user_id} and is_zhipai=1
		";
		$fangjian_list = M()->query($sql_fangjian);
		
		/*	
		$rows = $m->query($sql);
		$customerModel = M('customer');
		$where['user_id'] = $user_id;
		$where['isdelete'] = 0;
		$list = $customerModel->where($where)->select();
		*/
		$rows = array();
		foreach($fangjian_list as $val){
			$str = $val['xiaoqu'].$val['qi'].'期'.$val['dong'].'栋'.$val['lou'].'楼'.$val['fangjian'].'房间';
			$str .=' 姓名：'.$val['xingming'].' 电话：'.$val['dianhua'].' 微信：'.$val['weixin'] . '  qq:'.$val['qq'];
			$rows[] = $str;
		}
		
		$this->assign('fangjian_list',$rows);
		$this->assign('fans_list',$fans_list);
		
		
		
		$qrcodeSrc = qrcode($code_id);
		$this->assign('qrcodeSrc',$qrcodeSrc);
		$this->display('kefu_index');
		
		/*
		if($is_promote){
			//是推广员  用其user_id做渠道号
			
		}else{
			
		}
		
		switch($code_id){
			case 2:
				//客服
				
				$this->kefu_index($code_id);
				break;
			case 9:
				//业务员
				$this->yewu_index($code_id);
				break;
				
			case 7:
				//设计师
				$this->design_index($code_id);
				break;
				
			case 8:
				//工程人员
				$this->enginer_index($code_id);
				break;
				
			default:
				
			
		}
		*/
		#print_r($userInfo);
		exit;
		
		
		
    }
	
	function my_customer(){
		//两部分 粉丝 和  后台指定的房间
		$code = $this->_get('code');
        check_openid($code);
        $openid = session('openid');
        if ($openid == null) {
            $openid = 0;
			#echo 11;
			exit;
        }
		
		#session('openid','oWaRTuEhODLNahGWzyWRfLH_q5_0');
		
		$user=M('user');
		$u_where['openid']=array('eq',session('openid'));
		$u_data['status']=1;
		$userInfo = $user->where($u_where)->limit(1)->select();
		$is_promote = $userInfo[0]['is_promote'];
		$user_id = $userInfo[0]['user_id'];
		
		//粉丝
		$sql_fans = "select u.username from cms_user_customer as uc 
		left join cms_user as u on uc.customer_id = u.user_id 
		where uc.user_id = {$user_id} and is_zhipai=0
		";
		$fans_list = M()->query($sql_fans);
		
		
		//房间列表
		$sql_fangjian = "select  c.* from cms_user_customer as uc 
		left join cms_customer as c  on c.id = uc.fangjian_id
		where  uc.user_id = {$user_id} and is_zhipai=1
		";
		$fangjian_list = M()->query($sql_fangjian);
		
		/*	
		$rows = $m->query($sql);
		$customerModel = M('customer');
		$where['user_id'] = $user_id;
		$where['isdelete'] = 0;
		$list = $customerModel->where($where)->select();
		*/
		$rows = array();
		foreach($fangjian_list as $val){
			$str = $val['xiaoqu'].$val['qi'].'期'.$val['dong'].'栋'.$val['lou'].'楼'.$val['fangjian'].'房间';
			$str .=' 姓名：'.$val['xingming'].' 电话：'.$val['dianhua'].' 微信：'.$val['weixin'] . '  qq:'.$val['qq'];
			$rows[] = $str;
		}
		
		$this->assign('fangjian_list',$rows);
		$this->assign('fans_list',$fans_list);
		$this->display('my_customer');
		
		
		
	}
	

	private function kefu_index($code_id){
		//客服
		
		$qrcodeSrc = qrcode($code_id);
		$this->assign('qrcodeSrc',$qrcodeSrc);
		$this->display('kefu_index');
	}
	private function yewu_index($code_id){
		$qrcodeSrc = qrcode($code_id);
		$this->assign('qrcodeSrc',$qrcodeSrc);
		$this->display('yewu_index');
	}
	private function design_index($code_id){
		$qrcodeSrc = qrcode($code_id);
		$this->assign('qrcodeSrc',$qrcodeSrc);
		$this->display('design_index');
	}
	private function enginer_index($code_id){
		$qrcodeSrc = qrcode($code_id);
		$this->assign('qrcodeSrc',$qrcodeSrc);
		$this->display('enginer_index');
	}
	
	
	
}

?>