<?php
class AdminuserAction extends CommonAction {
    public function adminuser_list(){//管理员列表
    	$admin=M("admin");
    	import('@.ORG.Page');  
        $arr="";
        if($_GET['findsub']){ 
        	$account=trim($_GET['account']); 
        	if(!empty($account)){$arr['account'] = array('LIKE',"%".$account."%");$this->assign("account", $_GET['account']);}  
        	if(!empty($_GET['phone'])){$arr['phone'] = array('LIKE',"%".trim($_GET['phone'])."%");$this->assign("phone", $_GET['phone']);}
        	if(!empty($_GET['admin_name'])){$arr['admin_name'] = array('LIKE',"%".trim($_GET['admin_name'])."%");$this->assign("admin_name", $_GET['admin_name']);}
        	if($_GET['status']!=3){$arr['status'] = array('eq',$_GET['status']);$this->assign("status", $_GET['status']);}            else{
        		$this->assign("status",3);
        	} 
        	$city_id=intval($this->_get('city_id'));
        	if($city_id>0){$arr['city_id'] = array('eq',$city_id);$this->assign("city_id", $city_id);}
        }else{
        	$this->assign("status",3);
        }
        $arr['is_del']=array('eq','0');
        $arr['admin_id']=array('neq',1);
        $count = $admin->where($arr)->count();    //计算总数 
        $p = new Page($count, 15);
        $admin_list = $admin->where($arr)->limit($p->firstRow . ',' . $p->listRows)->select();//->order('cms_admin.admin_id DESC')
        $page = $p->show(); 
        $this->assign("page", $page);   
    
    	$this->assign('admin_list', $admin_list);  
    	$city=M('Region');
    	$city_where['status']=array('eq',1);
    	$city_where['pid']=array('eq',0);
    	$city_list=$city->where($city_where)->order('sort ASC')->select();
    	foreach ($city_list as $list){
    		$city_arr[$list[id]]=$list['name'];
    	}
    	$this->assign('city_arr', $city_arr); 
    	$this->assign('city_list', $city_list); 
        $this->display("Manage:adminuser_list"); 
    }
    
    public function adminuser_add(){//添加管理员
    	if($_POST){  
    		$_POST['admin_type']="admin";
    		$_POST['password']=md5($_POST['password']);
    		$_POST['temp_style']='green';
    		$adminup=D("admin"); 
    		$adminov=false;
    		if ($vo = $adminup->create()) { 
	            $list = $adminup->add();  
	            if ($list !== false) { 
	            	$adminov=true; 
	            } else { 
	                $adminov=false;
	            }
	        } else { 
	            $adminov=false;
	        }
	        
	        if($adminov==true){
                $this->redirect("__APP__/Adminuser/adminuser_list/");
	        }else{
	        	$this->error("数据写入错误!","__APP__/Adminuser/adminuser_list/");
	        }
	        exit;
    	}
    	$city=M('Region');
    	$city_where['status']=array('eq',1);
    	$city_where['pid']=array('eq',0);
    	$city_list=$city->where($city_where)->order('sort ASC')->select();
    	$this->assign('city_list', $city_list); 
    	$this->assign('arr',array('status'=>1));
    	$this->display("Manage:adminuser_add");
    }
    
    public function adminuser_edit(){//管理员编辑
    	if($_POST){
    		$adminup=D("admin");
    		$_POST['admin_type']="admin";
    		if(empty($_POST['password'])){
    			
    			$arrpassword=$adminup->where("admin_id=$_POST[admin_id]")->field('password')->find();
    			$_POST['password']=$arrpassword['password'];
    		}else{
    			$_POST['password']=md5($_POST['password']);
    		}
    		
    		if ($vo = $adminup->create()) { 
	            $list = $adminup->save();  
	        }  
	        
	       
	        if($list !== false){
                $this->redirect("__APP__/Adminuser/adminuser_list/");
	        }else {
	            $this->error("没有更新任何数据!","__APP__/Adminuser/adminuser_list/");
	        }
	        exit;
    	}
    
    	$admin=M("admin");
    	$admin_id=$_GET["_URL_"][2];   
    	$condition['cms_admin.admin_id'] = $admin_id; //使用查询条件 
        $infoAll = $admin->where($condition)->find();  
        if($infoAll['status']==0){$infoAll['status']=3;}
        $this->assign('arr',$infoAll);
         
    	$this->assign('acc',"readonly"); 
    	
    	$city=M('Region');
    	$city_where['status']=array('eq',1);
    	$city_where['pid']=array('eq',0);
    	$city_list=$city->where($city_where)->order('sort ASC')->select();
    	
    	
    	$this->assign('jstype', 'edit'); 
    	$this->assign('city_list', $city_list); 
    	$this->display("Manage:adminuser_add");
    }
 
    public function adminuser_del(){//删除管理员
    	if($_GET["_URL_"][2]){
    		$admin_id=$_GET["_URL_"][2];
    	}else{
    	    $admin_id=$_POST['admin_id'];
    	}
    	if (!empty($admin_id)) {
            //$admin = M("admin");
            //$admininfo = M("admininfo");
            if(is_array($admin_id)){
//            	$admin_id=implode(",",$admin_id);
//            	$result = $admin->where("admin_id in($admin_id)")->delete();  
//            	$result2 = $admininfo->where("admin_id in($admin_id)")->delete();   
            	$result=$this->add_recycle('admin','admin_id',$admin_id); 
            }else{
//            	$result = $admin->delete($admin_id);  
//            	$result2 = $admininfo->delete($admin_id);
                $result=$this->add_recycle('admin','admin_id',array($admin_id)); 
            }
            if (false !== $result) { 
               $this->success('删除成功！');
	        } else {
	           $this->error('删除出错！');
	        }
        }else {
            $this->error('删除项不存在！');
        }  
        exit;
    }

    /**
     * @title 设置城市状态
     * @author lizhi
     * @create on 2015-04-10
     */
    public function set_status()
    {
        $status = $_REQUEST['status'];
        $cid    = $_REQUEST['cid'];
        $status = ($status == 'open') ? '1' : '0';
        $m = M("admin");
        $save['status'] = $status;
        $res = $m->where('admin_id = '.$cid)->save($save);
        //echo $m->getLastSql();
        if ($res !== false){
            echo '1';
        }else{
            echo '0';
        }

    }
   public function adminuser_change($account){
   	    if($_POST){
   	    	$account=$_REQUEST['admin_id'];
   	    	$shop_id=$_REQUEST['shop_id'];
   	    	$checkbox=$_REQUEST['acheckbox'];
   	    	$user_shop=M('UserShop');
   	        $where['uid']=$account;
   	        $where['shop_id']=$shop_id;
   	        $result1 = $this->insert_activity($account, $checkbox);
   	        if(!empty($shop_id)){
   	        $res=$user_shop->data($where)->add();
   	        }
   	    	
   	    }
     	$admin=M("admin");
     	if($_GET["_URL_"][2]){
    	$admin_id=$_GET["_URL_"][2];
     	}else{
     		$admin_id=$account;
     	} 
     	$res_activity=M('ShopActivity')->select();
     	$res_user_activity=M('ByUserActivity')->where('uid='.$admin_id)->select();
     	$res_user_shop=M('UserShop')->join('left join cms_shop on cms_user_shop.shop_id=cms_shop.id')->field('name,addr,cms_user_shop.id')->where('cms_user_shop.uid='.$admin_id )->select();
    	$condition['cms_admin.admin_id'] = $admin_id; //使用查询条件 
        $infoAll = $admin->where($condition)->find();  
        if($infoAll['status']==0){$infoAll['status']=3;}
        $this->assign('activity',$res_user_activity);
        $this->assign('rs_activity',$res_activity);
        $this->assign('res_user_shop',$res_user_shop);
        $this->assign('arr',$infoAll);
        
    	/* $this->assign('acc',"readonly"); 
    	
    	$city=M('Region');
    	$city_where['status']=array('eq',1);
    	$city_where['pid']=array('eq',0);
    	$city_list=$city->where($city_where)->order('sort ASC')->select();
    	
    	
    	$this->assign('jstype', 'edit'); 
    	$this->assign('city_list', $city_list);  */
   	    
   	
   	$this->display("Manage:adminuser_change");
   }
    
   /*@title 获得商店名
    *@author weiyuhuang
    *@create on 
    * 
    * 
    */
   public function get_shop()
   {
   	   $keywords=$_REQUEST['keywords'];
       $keywords_two=$_REQUEST['keywords_two'];
       $shop=M('shop');
   	   $where['name']=array('like',$keywords.'%');
       if($keywords_two) {
           $where['city'] = array('like', $keywords_two.'%');
       }
   	   $res_shop=$shop->where($where)->field('name,addr,id')->select();
   	 
   
   	//echo '{"data":'.json_encode($res_shop).'}';
   	echo json_encode($res_shop);
   }
   /*@title 获得商店名
    * @author weiyuhuang
   * @create on
   */
   public function insert_user_shop($id,$shop_id){
   	/* echo $id;
   	 echo $shop_id;
   	die('ppp'); */
   	$where['uid']=$id;
   	$where['shop_id']=$shop_id;
   	$where['fstcreate']=date('Y-m-d H:d:s');
   	M('UserShop')->data($where)->add();
   
   
   } 
   
  
   public function insert_activity($rs, $checked) {
   
   	$m = M('ByUserActivity');
   	$arr['uid']=$rs;
   	M('ByUserActivity')->where($arr)->delete();
   	foreach ($checked as $val) {
   		$data['uid'] = $rs;
   		$data['activity_id'] = intval($val);
   		$res = $m->data($data)->add();
   	}
   }
   
   public function dele_user_shop(){
   	 $did=$_REQUEST['act_id'];
   	 $account=$_REQUEST['act_sid'];
   	 M('UserShop')->where('id='.$did)->delete();
   	 $this->adminuser_change($account);
   }
   
}