<?php
Class ActivityAction extends  CommonAction{
	public function activity_list(){
		//$this->display();
	   import('@.ORG.Page');
	   $arr='';
	 
	   $name=$_GET['username'];  
	   
	   if(!empty($name)){
	   $arr['ul.username'] = array('like', "%" . $name . "%");
	   $this->assign("username", $_GET['username']);
	            }
	    else{
	    	$arr['ul.username'] = array('EXP', "<> ''");
	    }
	    
	   if(!empty($_REQUEST['datetime'])){
	            	$arr['cms_user_integral.fstcreate'] = array('GT',$_REQUEST['datetime']);
	            	$this->assign("datatime", $_GET['datatime']);
	            }
	  

       // $arr['ul.username'] = array('EXP', "<> ''");
	   $userintegral=M('UserIntegral');
	   $count = $userintegral->where($arr)->join('LEFT JOIN cms_user as ul ON  cms_user_integral.openid=ul.openid')
            ->join('LEFT JOIN cms_user as u2 ON cms_user_integral.click_openid=u2.openid')->count();    //计算总数
	   $p = new Page($count, 100);
	   $res_userintegral=$userintegral->join('LEFT JOIN cms_user as ul ON  cms_user_integral.openid=ul.openid')
	     ->join('LEFT JOIN cms_user as u2 ON cms_user_integral.click_openid=u2.openid')
	     ->field('ul.username as a,u2.username as b,ul.openid,click_openid,ul.headimgurl,cms_user_integral.fstcreate as f,id')
	     ->where($arr)
	     ->order('ul.user_id')
	     ->limit($p->firstRow . ',' . $p->listRows)
	     ->select(); 
	   //$count = $userintegral->where($arr)->count();    //计算总数
	   //$p = new Page($count, 10);
	   
	   $page = $p->show();
	   $this->assign("page", $page);
       // echo $userintegral->getLastSql();
	   $this->assign('list',$res_userintegral); 
	   //var_dump($res_userintegral);
	   $this->display();
		
	}
	public function activity_get(){
		header("Content-type:text/html;charset=utf-8");
		import('@.ORG.Page');
		$arr='';
		
			$phone=$_GET['phone'];
		    if(!empty($phone)){
			$arr['cms_come_order.tel'] = array('like', "%" . $phone . "%");
			$this->assign("phone", $_GET['phone']);
		    }
		    if(!empty($_REQUEST['datetime'])){
		    	$arr['cms_come_order.fstcreate'] = array('GT',$_REQUEST['datetime']);
		    	$this->assign("datatime", $_GET['datatime']);
		    }
		    if(!empty($_REQUEST['ordername'])){
		    	$arr['cms_come_order.username'] =array('like', "%" . $_REQUEST['ordername'] . "%");
		    	$this->assign("ordername", $_GET['ordername']);
		    }
		    /* if(!empty($_REQUEST['username'])){
		    	$user=M('User');
		    	$user_data=$user->where('username='.$_REQUEST['username'])->field('openid')->select();
		    	echo $user->getLastSql();
		    	var_dump($user_data);
		    	$arr['cms_come_order.username'] =array('like', "%" . $_REQUEST['ordername'] . "%");
		    	$this->assign("ordername", $_GET['ordername']);
		    } */
		    if(!empty($_REQUEST['gift'])){
		    	
		    	$arr['cms_come_order.gift']=array('eq',$_REQUEST['gift']);
		    	$this->assign("gift", $_GET['gift']);
		    }
	       
	
		
		
		$comeorder=M('ComeOrder');
		$count = $comeorder->where($arr)->count('distinct(openid)');    //计算总数
        //echo $comeorder->getLastSql();
		$p = new Page($count, 100);
		$res_get=$comeorder->join('LEFT JOIN cms_user as u ON u.openid=cms_come_order.openid')
		->field('cms_come_order.openid as o,cms_come_order.username as n,cms_come_order.tel as t,address,cms_come_order.fstcreate as f,headimgurl,gift,u.username as name,id,issend,sendtime')
		->where($arr)->order('cms_come_order.id desc')
		->limit($p->firstRow . ',' . $p->listRows)->group('o')
		->select();
		//echo $comeorder->getLastSql();
		 if($_REQUEST['execute']){
		 	
			/* $data=array(array('name'=>'微信号','n'=>'姓名','t'=>'手机号码','address'=>'地址','gift'=>'礼物','f'=>'创建时间'));
			$data1=array_merge($data,$res_get);
		   $filename="D:/wamp/www/ddglass/".date('Y-m-d')."获奖名单.csv";
		   
	 	    $file=fopen($filename,"w");
			
			fwrite($file,chr(255).chr(254));
				
			foreach($data1 as $val){
		   
		
		   fwrite($file, iconv("UTF-8", "UTF-16LE", "$val[name]\t$val[n]\t$val[t]\t$val[address]\t$val[gift]\t$val[f]\r\n"));
		    
			
				
			}
			
			fclose($file);   
			 $filename=date('Y-m-d')."获奖名单.csv";
			$this->export_csv($filename,$data1);   */
		 	//$Arr=$arr['cms_come_order.fstcreate'];
		 	$Arr['fstcreate']=array('GT',$_REQUEST['datetime']);
		 	
		 	$user=M('ComeOrder');
		 	$datalist = $user->order('id desc')->field('openid,weixin_key,username,tel,address,fstcreate')->where($Arr)->select(); 
		 	
		 	$filename = time().".csv";
		 	
		 	$head_array = array('openid'=>'微信id','weixin_key'=>'微信号', 'username'=>'收件人','tel'=>'电话','address'=>'地址','fstcreate'=>'下单时间');
		 	
		    $this->download_csv($filename,$head_array,$datalist);
		 	
		 	
		 	
			
		}
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign('list',$res_get);
		//var_dump($res_get);
		$this->display();
		
	}
	public function activity_dele(){
		$userintegral=M('UserIntegral');
		$id=$_REQUEST['id'];
		$userintegral->where('id='.$id)->delete();
		if ($res !== false) {
			$this->redirect("__APP__/Activity/activity_list/");
		} else {
			$this->error('删除错误');
		}
	}
	
	public function set_status() {
		$status = $_REQUEST['status'];
		//echo $status;
		$cid = $_REQUEST['cid'];
		$status = ($status == 'open') ? '1' : '0';
		$m= M("ComeOrder");
		if($status=='1'){
	       $data['sendtime']=date('Y-m-d-H-i-s');
	       
	       $m->where('id=' . $cid)->save($data);
		}
		else{
			$data['sendtime']=null;
			$m->where('id=' .$cid)->save($data);
			//var_dump($data['sendtime']);
		}
		//echo $status;
		
		$save['issend'] =intval($status);
		
		$res = $m->where('id=' . $cid)->save($save);
		
		//echo $m->getLastSql();
		if ($res !== false) {
			echo '1';
		} else {
			echo '0';
		}
	}

	
 function export_csv($filename,$data1) { 
	
	 header("Content-type:text/html;charset=utf-8");
	
	header("Content-type:text/csv");
	header("Content-Disposition:attachment;filename=".$filename);
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public');
	$file=fopen($filename,"w");
	
	fwrite($file,chr(255).chr(254));
    
    foreach($data1 as $val){
    	
    	 //echo iconv("UTF-8", "gb2312", "$val[name]"."'".\t."'"."$val[n]"."'".\t."'"."$val[t]"."'".\t."'"."$val[address]"."'".\t."'"."$val[gift]"."'".\t."'"."$val[f]\r\n");
    	
    	
    echo iconv("UTF-8", "gb2312", "$val[name]\t$val[n]\t$val[t]\t$val[address]\t$val[gift]\t$val[f]\r\n");
    
    }
    
    fclose($file);
    
    exit;
}  
	
	 
}
