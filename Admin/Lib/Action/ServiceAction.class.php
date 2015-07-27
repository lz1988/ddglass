<?php
class ServiceAction extends CommonAction{
	public  function index(){
		$m=M('ShopService');
		$res=$m->select();
		//service
		$this->assign('vo',$res);
		
		$this->display();
	}
	
    public function delete(){
    	$id=$_GET['id'];
    	$m=M('ShopService');
    	$data['id']=$id;
    	$res=$m->where($data)->delete();
    	if($res){
    		$this->redirect('__APP__/service/index');
    	}else{
    		$this->error("删除失败");
    	}
    	
    	
    }	
    
    public function add_service(){
    	$this->display();
    }
    
    public function add(){
    	$id=$_POST['admin_id'];
    if(empty($id)){
    	$sname=$_POST['servicename'];
    	$m=M('ShopService');
        $data['service_name']=$sname;
        $res=$m->add($data);
    	if($res){
    		$this->success('添加成功');
    	}else{
    		$this->error('添加失败');
    	}
     }else{
     	$id=$_POST['admin_id'];
     	$service=$_POST['servicename'];
     	$m=M('ShopService');
     	$data['service_name']=$service;
     	$res=$m->where('id='.$id)->save($data);
        echo $m->getLastSql();
     	if($res){
     		$this->redirect('__APP__/service/index');
     	}else{
     		$this->error('更新失败');
     		
     	}
     } 
   }
    public function edit(){
    	$id=$_GET['id'];
    	$m=M('ShopService');
    	$res=$m->where('id='.$id)->field('id,service_name')->find();
    	$this->assign('res',$res);
    	$this->display('add_service');
    	
    }
	
}