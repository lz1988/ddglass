<?php

class LogadminAction extends CommonAction {
    public function logadmin_list(){//管理员操作日志列表
    	$logadmin=M("logadmin");
    	import('@.ORG.Page');  
        $arr="";
        if($_GET['findsub']){ 
        	$content=trim($_GET['content']); 
        	if(!empty($content)){$arr['cms_logadmin.content'] = array('LIKE',"%".$content."%");$this->assign("content", $_GET['content']);} 
        	if($_GET['admin_id']!=0){$arr['cms_admin.admin_id'] = array('eq',$_GET['admin_id']);$this->assign('admin_id',$_GET['admin_id']);} 
        	if($_GET['module']!=""){$arr['cms_logadmin.module'] = array('eq',"$_GET[module]");$this->assign('module',$_GET['module']);} 
        	if (!empty($_GET['start_time']) AND !empty($_GET['end_time'])){
        		$arr['action_time'] = array(array('egt',strtotime($_GET['start_time'])),array('lt',strtotime($_GET['end_time'])+24*60*60));$this->assign("end_time", $_GET['end_time']);$this->assign("start_time", $_GET['start_time']);
        	}elseif(!empty($_GET['start_time']) AND empty($_GET['end_time'])){
        		$arr['action_time'] = array('egt',strtotime($_GET['start_time']));$this->assign("start_time", $_GET['start_time']);
        	}elseif(!empty($_GET['end_time']) AND empty($_GET['start_time'])){
        		$arr['action_time'] = array('lt',strtotime($_GET['end_time'])+24*60*60);$this->assign("end_time", $_GET['end_time']);
        	}
        } 
         
        $count = $logadmin->where($arr)->count();    //计算总数 
        $p = new Page($count, 15);
        $logadmin_list = $logadmin->join('cms_logadmin LEFT JOIN cms_admin ON cms_logadmin.admin_id = cms_admin.admin_id')->where($arr)->order('cms_logadmin.log_id DESC')->field('cms_admin.account,cms_logadmin.*')->limit($p->firstRow . ',' . $p->listRows)->select();
        $page = $p->show();
        $this->assign("page", $page);   
    	$this->assign('logadmin_list', $logadmin_list);  
    	
    	/**管理员列表**/
    	$admin=M("admin");
    	$admininfo = $admin->select();  
    	$this->assign('admininfo',$admininfo);
    	
    	$MODULES_MENU_ALL=C('MODULES_MENU_ALL');
     	$MOD_NAME_ARR=C('MOD_NAME_ARR'); 
    	$modarr="";
    	$dmodarr="";
    	foreach ($MODULES_MENU_ALL as $bk=>$bkey){ 
    		foreach ($bkey as $mod=>$modkey){  
    		   $modarr[]=array('name'=>$MOD_NAME_ARR[$mod]);  
    		}    
    	} 
    	$this->assign('arr',$modarr); 
    	
        $this->display("Log:logadmin_list"); 
    }
    
    
 
    public function logadmin_del(){//删除管理员操作日志
    	if($_GET["_URL_"][2]){
    		$log_id=$_GET["_URL_"][2];
    	}else{
    	    $log_id=$_POST['log_id'];
    	}
    	if (!empty($log_id)) {
            $logadmin = M("logadmin");
            if(is_array($log_id)){
            	$log_id=implode(",",$log_id);
            	$result = $logadmin->where("log_id in($log_id)")->delete();   
            }else{
            	$result = $logadmin->delete($log_id);  
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
     
}