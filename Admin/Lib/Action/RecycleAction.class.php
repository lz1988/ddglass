<?php
class RecycleAction extends CommonAction {
    public function recycle_list(){//数据回收站
    	$recycle=M("recycle");
    	import('@.ORG.Page');  
        $arr="";
        if($_GET['findsub']){  
        	if($_GET['admin_id']!=0){$arr['cms_recycle.admin_id'] = array('eq',$_GET['admin_id']);$this->assign('admin_id',$_GET['admin_id']);} 
        	
        	if($_GET['module']!=""){$arr['cms_recycle.module'] = array('eq',"$_GET[module]");$this->assign('module',$_GET['module']);} 
        	if (!empty($_GET['start_time']) AND !empty($_GET['end_time'])){
        		$arr['cms_recycle.recycle_time'] = array(array('egt',strtotime($_GET['start_time'])),array('lt',strtotime($_GET['end_time'])+24*60*60));$this->assign("end_time", $_GET['end_time']);$this->assign("start_time", $_GET['start_time']);
        	}elseif(!empty($_GET['start_time']) AND empty($_GET['end_time'])){
        		$arr['cms_recycle.recycle_time'] = array('egt',strtotime($_GET['start_time']));$this->assign("start_time", $_GET['start_time']);
        	}elseif(!empty($_GET['end_time']) AND empty($_GET['start_time'])){
        		$arr['cms_recycle.recycle_time'] = array('lt',strtotime($_GET['end_time'])+24*60*60);$this->assign("end_time", $_GET['end_time']);
        	}
        } 
         
        $count = $recycle->where($arr)->count();    //计算总数 
        $p = new Page($count, 15);
        $recycle_list = $recycle->join('cms_recycle LEFT JOIN cms_admin ON cms_recycle.admin_id=cms_admin.admin_id')->field('cms_recycle.*,cms_admin.account')->where($arr)->order('cms_recycle.recy_id DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
        $page = $p->show(); 
        $this->assign("page", $page);   
    	$this->assign('recycle_list', $recycle_list);  
    	
    	$admin_menu=M('admin_menu');
    	$meun_where['level']=array('eq',2);
    	$meun_where['status']=array('eq',1);
    	$meun_res=$admin_menu->field('menu_title,func_name')->where($meun_where)->select();
    	$menu_arr='';
    	foreach ($meun_res as $res) {
    		$menu_arr[$res[func_name]]=$res['menu_title'];
    	}
    	
    	$this->assign('mod', $menu_arr);
    	
    	/**管理员列表**/
    	$admin=M("admin");
    	$admininfo = $admin->select();  
    	$this->assign('admininfo',$admininfo);
    	
    	$this->assign('arr',$meun_res); 
    	
        $this->display("Manage:recycle_list"); 
    }
     
    public function recycle_del(){//删除回收站数据
    	if($_GET["_URL_"][2]){
    		$recy_id=$_GET["_URL_"][2];
    	}else{
    	    $recy_id=$_POST['recy_id'];
    	}
    	
    	if (!empty($recy_id)) {
            $recycle = M("recycle");
            
            if(is_array($recy_id)){
            	$reid=implode(",",$recy_id);
            	foreach ($recy_id as $id){
            		$recy_list=$recycle->where("recy_id=$id")->find();
			    	$table   =$recy_list['table'];//表名 
			    	$id_val  =$recy_list['id_val'];//值
			    	$ojbbtable=M($table);   
			    	$data_del = $ojbbtable->delete($id_val);
            	}
            	//if($data_del){
            		$result = $recycle->where("recy_id in($reid)")->delete();  
            	//} 
            }else{
            	$recy_list=$recycle->where("recy_id=$recy_id")->find();
		    	$table   =$recy_list['table'];//表名 
		    	$id_val  =$recy_list['id_val'];//值
		    	$ojbbtable=M($table);   
		    	$data_del = $ojbbtable->delete($id_val);
		    	//if($data_del){
		    		$result = $recycle->delete($recy_id);  
		    	//} 
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
    
    public function recycle_restore(){//恢复回收站数据
    	 if($_GET["_URL_"][2]){
    		$recy_id=$_GET["_URL_"][2];
    	}else{
    	    $recy_id=$_POST['recy_id'];
    	}
    	
        if (!empty($recy_id)) {
            $recycle = M("recycle");
	    	if(is_array($recy_id)){ 
	            foreach ($recy_id as $id){
	            	$result=$this->data_restore($id);
	            }
	        }else{
	           $result=$this->data_restore($recy_id);
	        }
            if (false !== $result) { 
               $this->success('数据恢复成功！');
	        } else {
	           $this->error('数据恢复出错！');
	        }
        }else {
            $this->error('数据恢复项不存在！');
        }  
        exit;
    	
    }
}