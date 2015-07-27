<?php

class MessagetypeAction extends CommonAction {
    public function messagetype_list(){//新闻栏目列表
    	$newstype=M("newstype");
    	import('@.ORG.Page');  
        $arr="";
        if($_GET['findsub']){ 
        	$type_name=trim($_GET['type_name']);
        	 
        	if(!empty($type_name)){$arr['qu_orgtype.type_name'] = array('LIKE',"%".$type_name."%");$this->assign("type_name", $_GET['type_name']);} 
        	if($_GET['game_id']!=0){$arr['qu_orgtype.game_id'] = array('eq',$_GET['game_id']);$this->assign('game_id',$_GET['game_id']);} 
        } 
        $arr['is_del']=array('eq','0');
        $arr['pid']=array('eq',0);
        $count = $newstype->where($arr)->count();    //计算总数 
        $p = new Page($count, 15);
        $newstype_list = $newstype->where($arr)->order('sort ASC,type_id DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
        $page = $p->show(); 
        $this->assign("page", $page);   
    	$this->assign('newstype_list', $newstype_list);  
    	
    	$arr_id='';
    	foreach ($newstype_list as $list){
    		$arr_id[]=$list['type_id'];
    	}
    	
    	$arr['pid']=array('in',$arr_id);
    	$p_res=$newstype->where($arr)->select();
    	$this->assign("p_res", $p_res);   
    	
        $this->display("Message:messagetype_list"); 
    }
    
    public function messagetype_add(){//添加新闻栏目
    	$newstypeup=M("newstype"); 
    	if($_POST){ 
    		
    		if ($vo = $newstypeup->create()) { 
	            $list = $newstypeup->add(); 
	            if ($list !== false) {
                    $this->redirect("__APP__/Messagetype/messagetype_list/");
	            } else {
	                $this->error("数据写入错误!","__APP__/Messagetype/messagetype_list/");
	            }
	        } else {
	            $this->error($newstypeup->getError());
	        } 
	        exit;
    	}
    	 
    	$type_where['is_del']=array('eq',0);
    	$type_where['pid']=array('eq',0);
        $infoAll = $newstypeup->field('type_id,type_name')->where($type_where)->select();  
        $this->assign('typelist',$infoAll);
        
        $arr['pid']=$_GET["_URL_"][2];   
        $this->assign('arr',$arr);
        
    	$this->assign('typeName',"添加新闻栏目");
    	$this->assign('typeUrl',"__APP__/Message/messagetype_add/");
    	$this->display("Message:messagetype_add");
    }
    
    public function messagetype_edit(){//新闻栏目编辑
    	if($_POST){
    		$newstypeup=D("newstype"); 
    		if ($vo = $newstypeup->create()) { 
	            $list = $newstypeup->save(); 
	            if ($list !== false) {
                    $this->redirect("__APP__/Messagetype/messagetype_list/");
	            } else {
	                $this->error("没有更新任何数据!","__APP__/Messagetype/messagetype_list/");
	            }
	        } else {
	            $this->error($newstypeup->getError());
	        } 
	        exit;
    	}
    	 
    	$newstype=M("newstype");
    	$type_id=$_GET["_URL_"][2];   
    	$condition['type_id'] = $type_id; //使用查询条件 
        $infoAll = $newstype->where($condition)->find();  
        $this->assign('arr',$infoAll);
        
        $type_where['is_del']=array('eq',0);
    	$type_where['pid']=array('eq',0);
        $list = $newstype->field('type_id,type_name')->where($type_where)->select();  
        $this->assign('typelist',$list);
          
    	$this->assign('typeName',"新闻栏目编辑");
    	$this->assign('typeUrl',"__APP__/Message/messagetype_edit/");
    	$this->display("Message:messagetype_add");
    }
 
    public function messagetype_del(){//删除新闻栏目
    	if($_GET["_URL_"][2]){
    		$type_id=$_GET["_URL_"][2];
    	}else{
    	    $type_id=$_POST['type_id'];
    	}
    	if (!empty($type_id)) {
            $news = M("news");
            if(is_array($type_id)){
            	$wheretypeId=implode(",",$type_id);
            	$gamewhere['type_id']=array('in',$wheretypeId);
             	$game_info=$news->field('type_id')->where($gamewhere)->limit(1)->find(); 
            	if(empty($game_info)){
            	    $result=$this->add_recycle('newstype','type_id',$type_id);
            	}else{
            		$this->error('您所选的类型下有新闻信息，不能删除！');
            	}
            }else{
            	$gamewhere['type_id']=array('eq',$type_id);
             	$game_info=$news->field('type_id')->where($gamewhere)->limit(1)->find(); 
            	if(empty($game_info)){
                	$result=$this->add_recycle('newstype','type_id',array($type_id));  
            	}else{
            		$this->error('您所选的类型下有新闻信息，不能删除！');
            	}
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
    
    public function messagetype_upall(){//游戏官网栏目更新
    	if($_POST){
    		$newstypeup=D("newstype");
    		$type_id=$_POST['sortid'];
    		$sort=$_POST['sort']; 
    		for($i=0;$i<count($type_id);$i++){
    			$arr['sort']=$sort[$i];
    			$list =$newstypeup->where("type_id=$type_id[$i]")->save($arr); // 根据条件保存修改的数据
    		}
    		if($list !== false){
    			$this->success('数据更新成功！');
    			exit;
    		}else {
	            $this->error($newstypeup->getError());exit;
	        }  
    	}else{
    		$this->error('操作错误！');exit;
    	}  
    }
    
    //生成静态
    public function messagetype_engender(){
    	
    }
}