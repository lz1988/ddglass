<?php
/* @author weiyuhuang
 * @info 商家信息
 */
Class SellerAction extends CommonAction {
	public function index(){
	    import('@.ORG.Page');
	    $arr="";
		$m=M('seller');
		if($_GET['findsub']){
			
			if(!empty($_GET['sellname'])){$arr['sell_name'] = array('LIKE',"%".trim($_GET['sellname'])."%");$this->assign("sellname", $_GET['sellname']);}
		}
		$count = $m->where($arr)->count();    //计算总数
		$p = new Page($count, 10);
		$index_list = $m->where($arr)->limit($p->firstRow . ',' . $p->listRows)->select();
		$page = $p->show();
		$this->assign("page", $page);
		$this->assign('seller',$index_list);
	
		$this->display();
	}
	
	public  function add_seller(){
		$res_activity=M('ShopActivity')->select();
		 
		 $this->assign('rs_activity',$res_activity);
		 $this->assign('res',$res);
		$this->display();
		
		
	}
	public function add(){
		$sid=$_REQUEST['admin_id'];
		
	
		
		if(!empty($sid)){
			
			if(!empty($_REQUEST['password'])){
				
		    $data['sell_pwd']=md5($_POST['password']);
			}
		    $checkbox=$_REQUEST['acheckbox'];
		    $shop_id=$_REQUEST['shop_id'];
		    /* echo $shop_id;
		    die('ppp'); */
		    $result1 = $this->insert_activity($sid, $checkbox);
		    $this->insert_user_shop($sid, $shop_id);
		    
		    		    $m=M('seller');	
			$rs=$m->where('id='.$sid)->save($data);
			//echo M("seller")->getLastSql();
			$this->edit($sid);
			
		}
		else {
		$data['sell_name']=$_POST['username'];
		$data['sell_pwd']=md5($_POST['password']);
        $checkbox=$_REQUEST['acheckbox'];
		$m=M('seller');
		$rs=$m->add($data);
		$this->insert_activity($rs, $checkbox);
	
	    //echo $m->getLastSql();
	    
		if($rs !==false){
		  
			$this->redirect('__APP__/Seller/index');
			
		
		}
		else{
			
			$this->error('错误提交');
		}
	  }
	}
	
	
	public function dele_seller(){
		$id=$_GET['id'];
		$m=M('seller');
		$rs=$m->where('id='.$id)->delete();
		if($rs){
			$this->redirect('__APP__/Seller/index');
			
			}
		else{
			$this->error('删除错误');
			
		}
		
	}
	public function edit($id){
		if(empty($id)){
		 $id=$_GET['id'];
		}
		 $m=M('seller');
		 $res=$m->where('id='.$id)->field('id,sell_name,sell_pwd')->find();
		 $res_activity=M('ShopActivity')->select();
		 $res_user_activity=M('ByUserActivity')->where('uid='.$id)->select();
		 $res_user_shop=M('UserShop')->join('left join cms_shop on cms_user_shop.shop_id=cms_shop.id')->field('name,addr,cms_user_shop.id')->where('cms_user_shop.uid='.$id )->select();
		 /* var_dump($res_user_shop);  */
		 $this->assign('res_user_shop',$res_user_shop);
		  /* echo  M('UserShop')->getLastSql();
		 die('zzzz');   */  
		 $this->assign('activity',$res_user_activity);
		 $this->assign('rs_activity',$res_activity);
		 $this->assign('res',$res);
		 $this->display('add_seller');
		
	}
	
	public function set_status()
	{
		$status = $_REQUEST['status'];
		$cid    = $_REQUEST['cid'];
		$status = ($status == 'open') ? '0' : '1';
		$m = M("seller");
		$save['isdel'] = $status;
		$res = $m->where('id = '.$cid)->save($save);
		
		if ($res !== false){
			echo '1';
		}else{
			echo '0';
		}
	
	}
	/*魏玉煌
	 * @method:得到关键词，搜索商店
	 * 
	 */
	public function get_shop()
	{
       $keywords=$_REQUEST['keywords'];
       
         
       $shop=M('shop');
       $where['name']=array('like',$keywords.'%');
       $res_shop=$shop->where($where)->field('name,addr,id')->select();
       
      
       //echo '{"data":'.json_encode($res_shop).'}';
	   echo json_encode($res_shop);
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
	/* 插入商店 jackwei */
   public function insert_user_shop($id,$shop_id){
   	/* echo $id;
   	echo $shop_id;
   	die('ppp'); */
   	    $where['uid']=$id;
   	    $where['shop_id']=$shop_id;
   	    $where['fstcreate']=time();
   	    M('UserShop')->data($where)->add();
   	    
   	
   }
   /*删除用户商店  */
   public function dele_user_shop(){
   	$did=$_REQUEST['act_id'];
   	$id=$_REQUEST['act_sid'];
   	
   	
   	M('UserShop')->where('id='.$did)->delete();
   	
   	$this->edit($id);
   }
    
	
	
		
	
}