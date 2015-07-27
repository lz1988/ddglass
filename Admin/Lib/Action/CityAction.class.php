<?php

class CityAction extends CommonAction {
    public function city_list(){//管理员列表
    	$city=M("city");
    	import('@.ORG.Page');  
        $arr="";
        if($_GET['findsub']){ 
        	$name=trim($_GET['name']); 
        	if(!empty($name)){$arr['name'] = array('LIKE',"%".$name."%");$this->assign("name", $_GET['name']);}
        }
       // $arr['level']=array('eq',1);
        if($_GET[pid]){
       	    $arr['pid']=array('eq',$_GET[pid]);
        }else{
       		$arr['pid']=array('eq','1');
        }
        $count = $city->where($arr)->count();    //计算总数 
        $p = new Page($count, 15);
        $city_list = $city->where($arr)->limit($p->firstRow . ',' . $p->listRows)->order('status desc')->select();//->order('cms_admin.admin_id DESC')
        
        $page = $p->show(); 
        $this->assign("page", $page);   
    
    	$this->assign('city_list', $city_list);  
    	$this->assign('pid', 0); 
        $this->display(); 
    }
    
     
    public function city_add(){//添加城市
    	if($_POST){
    		$city=D("Region"); 
    		if ($vo = $city->create()) { 
	            $list = $city->add();  
	            if($list==true){
                    $this->redirect("__APP__/City/city_list/");
		        }else{
		        	$this->error("数据写入错误!","__APP__/City/city_list/");
		        }
	        } else { 
	        	$this->error($city->getError(),"__APP__/City/city_list/");
	        }
	        exit;
    	} 
    	$pid=$_GET["pid"]; 
    	$level=$_GET['level'];
    	$arr['pid']=$pid;
    	$arr['level']=$level;; 
    	$this->assign('arr', $arr); 
    	$this->display();
    }
    
    public function city_edit(){//城市编辑
    	if($_POST){
    		$city=D("city");
    		if ($vo = $city->create()) { 
	            $list = $city->save();  
	            if($list==true){
                    $this->redirect("__APP__/City/city_list/pid/".$_POST[pid]);
		        }else{
		        	$this->error("数据写入错误!","__APP__/City/city_list/pid/".$_POST[pid]);
		        }
	        }else {
	            $this->error($city->getError(),"__APP__/City/city_list/pid/".$_POST[pid]);
	        }
	        exit;
    	}
    	  
    	$city=M("city");
    	$city_id=$_GET["cid"];   
    	$condition['cid'] = $city_id; //使用查询条件 
        $infoAll = $city->where($condition)->find();  
        
        $this->assign('arr',$infoAll);
    	$this->display("city_add");
    }
 
    public function city_del(){//删除管理员
    	if($_GET["_URL_"][2]){
    		$id=$_GET["_URL_"][2];
    	}else{
    	    $id=$_POST['id'];
    	}
    	if (!empty($id)) {
            $city = M("city"); 
            if(is_array($id)){
            	$id=implode(",",$id);
            	$result = $city->where("id in($id)")->delete();    
            }else{
            	$result = $city->delete($id);   
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
        $m = M("city");
        $save['status'] = $status;
        $res = $m->where('cid = '.$cid)->save($save);
        //echo $m->getLastSql();
        if ($res !== false){
            echo '1';
        }else{
            echo '0';
        }

    }
   
}