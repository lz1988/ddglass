<?php

class MessageAction extends CommonAction {
    public function message_list(){//新闻资讯列表
    	$news=M("news");
    	import('@.ORG.Page');
        $arr="";
        if(isset($_GET['findsub'])){
        	$title=trim($_GET['title']);
        	if(!empty($title)){$arr['cms_news.title'] = array('LIKE',"%".$title."%");$this->assign("title", $_GET['title']);}
        	if($_GET['type_id']!=0){$arr['cms_news.type_id'] = array('eq',$_GET['type_id']);$this->assign('type_id',$_GET['type_id']);}

        	if(!empty($_GET['create_time']) AND !empty($_GET['update_time'])){
        		$arr['cms_news.create_time'] = array(array('egt',strtotime($_GET['create_time'])),array('lt',strtotime($_GET['update_time'])+24*60*60),'AND');$this->assign("update_time", $_GET['update_time']);$this->assign("create_time", $_GET['create_time']);
        	}elseif(!empty($_GET['create_time']) AND empty($_GET['update_time'])){
        		$arr['cms_news.create_time'] = array('egt',strtotime($_GET['create_time']));$this->assign("create_time", $_GET['create_time']);
        	}elseif(!empty($_GET['update_time']) AND empty($_GET['create_time'])){
        		$arr['cms_news.create_time'] = array('lt',strtotime($_GET['update_time'])+24*60*60);$this->assign("update_time", $_GET['update_time']);
        	}
        }elseif($_GET['type_id']!=0){
        	if($_GET['type_id']!=0){$arr['cms_news.type_id'] = array('eq',$_GET['type_id']);$this->assign('type_id',$_GET['type_id']);}
        }
        $arr['is_del']=array('eq',0);
        $count = $news->where($arr)->count();    //计算总数 

        $p = new Page($count, 20);
        $news_list = $news->where($arr)->field('id,title,type_id,sort,create_time,status,click_num')->order('sort ASC,create_time DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
        $page = $p->show();
        $this->assign("page", $page);
    	$this->assign('news_list', $news_list);

    	/**新闻分类**/
    	$newstype=M("newstype");
    	$newstypeinfo = $newstype->where("is_del='0'")->order('sort ASC')->select();
    	$this->assign('newstypearr',$newstypeinfo);
        $arr_type='';
    	foreach ($newstypeinfo as $res){
    		$arr_type[$res['type_id']]=$res['type_name'];
    	}
    	$this->assign('arr_type', $arr_type);
        $this->display("Message:message_list");
    }

    public function message_add(){//添加资讯
    	    $newsup=D("news");
    		if($_POST){
    		$bold='';
    		if(!empty($_POST['bold'])){
    			$bold=$_POST['bold'];
    		}
//    		if(empty($_POST['bgcolor'])){
//    			$_POST['bgcolor']='000000';
//    		}
    		$_POST['title_style']='font-weight:'.$bold.';color:#'.$_POST['bgcolor'].';';
    		$bold='';
    		if(!empty($_POST['bold'])){
    			$bold=$_POST['bold'];
    		}
    		if(empty($_POST['bgcolor'])){
    			$_POST['bgcolor']='000000';
    		}
    		$_POST['title_style']='font-weight:'.$bold.';color:#'.$_POST['bgcolor'].';';
    		if(!empty($_POST['create_time'])){$crteatime=strtotime($_POST['create_time']);}else{$crteatime=time();}


    		$_POST['create_time']=$crteatime;
    		$_POST['update_time']=time();
    		$_POST['content']= str_replace('src="/Uploads/Attached/', 'src="http://'.$_SERVER[SERVER_NAME].'/Uploads/Attached/', $_POST['content']);

    		if ($vo = $newsup->create()) {
	            $list = $newsup->add();
	            if ($list !== false) {
	            	$orgnews=D("orgnews"); /**添加到官网资讯里begin**/
	            	$orgtype_id=$_POST['orgtype_id'];
	            	$_POST['sort']=$_POST['sort'];
	            	for($i=0;$i<count($orgtype_id);$i++){
	            		$gt_arr=explode('_',$orgtype_id[$i]);
	            		$_POST['game_id']=$gt_arr[0];
	            		$_POST['type_id']=$gt_arr[1];
		            	if ($vo_new = $orgnews->create()) {
		                   $list_new = $orgnews->add();
		            	}
	            	}
	            	if ($list_new !== false) {
                        $this->redirect("__APP__/Message/message_list/");exit;
	                }
	            	/**添加到官网资讯里end**/
                    $this->redirect("__APP__/Message/message_list/");exit;
	            } else {
	                $this->error("数据写入错误!","__APP__/Message/message_list/");
	            }
	        } else {
	            $this->error($newsup->getError());
	        }
	        exit;
    	}

    	/**游戏**/
    	$game=M("game");
    	//$wheregame['status']=array('eq','1');
    	$wheregame['is_del']=array('eq','0');
    	$gameinfo = $game->where($wheregame)->order('sort DESC')->select();
    	$this->assign('gamearr',$gameinfo);

    	/**新闻分类**/
    	$newstype=M("newstype");
    	$newstypeinfo = $newstype->where("is_del='0' and status='1'")->order('sort ASC')->select();
    	$this->assign('newstypearr',$newstypeinfo);

    	/**新闻图片路径**/
    	$con=C('NEWIMGURL');
    	$this->assign('newimgurl',$con);

    	/**官网栏目**/
    	$orgtype=M("orgtype");
    	$orgtypeinfo = $orgtype->where("is_del='0'")->select();
    	$this->assign('orgtypeinfo',$orgtypeinfo);

    	$arr[0]['create_time']=time();
    	$this->assign('arr',$arr);

    	//$this->assign('color','000000');
    	$this->assign('updivishide',"style='display:none;'");
    	$this->assign('updivisshow',"style=''");
    	$this->assign('updivishide2',"style='display:none;'");
    	$this->assign('updivisshow2',"style=''");
    	$this->assign('typeName',"添加资讯");
    	$this->assign('typeUrl',"__APP__/Message/message_add/");
    	$this->display("Message:message_add");
    }

    public function message_edit(){//资讯编辑
    	if($_POST){
    		$newsup=D("news");
    		$id=$_POST['id'];
    		$bold='';
    		if(!empty($_POST['bold'])){
    			$bold=$_POST['bold'];
    		}
//    		if(empty($_POST['bgcolor'])){
//    			$_POST['bgcolor']='000000';
//    		}

    		$_POST['title_style']='font-weight:'.$bold.';color:#'.$_POST['bgcolor'].';';

    		if(!empty($_POST['create_time'])){$_POST['create_time']=strtotime($_POST['create_time']);}else{$_POST['create_time']=time();}
    		$_POST['update_time']=time();
    		$_POST['content']= str_replace('src="/Uploads/Attached/', 'src="http://'.$_SERVER[SERVER_NAME].'/Uploads/Attached/', $_POST['content']);
    		if($_POST['is_home']==1){$_POST['is_home']='1';}else{$_POST['is_home']='0';}
    	    if($_POST['is_hot']==1){$_POST['is_hot']='1';}else{$_POST['is_hot']='0';}
    		if ($vo = $newsup->create()) {
	            $list = $newsup->save();
	            if ($list !== false) {
	            	$orgnews=D("orgnews"); /**添加到官网资讯里begin**/
	            	$orgtype_id=$_POST['orgtype_id'];
	            	$_POST['sort']=$_POST['sort'];
	            	for($i=0;$i<count($orgtype_id);$i++){
	            		$gt_arr=explode('_',$orgtype_id[$i]);
	            		$_POST['game_id']=$gt_arr[0];
	            		$_POST['type_id']=$gt_arr[1];
		            	if ($vo_new = $orgnews->create()) {
		                   $list_new = $orgnews->add();
		            	}
	            	}
	            	if ($list_new !== false) {
                        $this->redirect("__APP__/Message/message_list/");exit;
	                }
	            	/**添加到官网资讯里end**/
                    $this->redirect("__APP__/Message/message_list/");exit;
	            } else {
	                $this->error("没有更新任何数据!","__APP__/Message/message_list/");
	            }
	        } else {
	            $this->error($newsup->getError());
	        }
	        exit;
    	}
    	/**游戏**/
    	$game=M("game");
    	$gameinfo = $game->where("is_del='0'")->order('sort DESC')->select();
    	$this->assign('gamearr',$gameinfo);

    	/**新闻分类**/
    	$newstype=M("newstype");
    	$newstypeinfo = $newstype->where("is_del='0' and status='1'")->order('sort ASC')->select();
    	$this->assign('newstypearr',$newstypeinfo);

    	/**新闻图片路径**/
    	$con=C('NEWIMGURL');
    	$this->assign('newimgurl',$con);

    	/**官网栏目**/
    	$orgtype=M("orgtype");
    	$orgtypeinfo = $orgtype->where("is_del='0'")->select();
    	$this->assign('orgtypeinfo',$orgtypeinfo);

    	$news=M("news");
    	$id=$_GET["_URL_"][2];
    	$condition['id'] = $id; //使用查询条件
        $infoAll = $news->where($condition)->select();
        $infoAll[0]['icon2']=$con.$infoAll[0]['icon'];
        $this->assign('arr',$infoAll);

        if($infoAll[0][icon]==""){
    		$this->assign('updivisshow',"");
    		$this->assign('updivishide',"style='display:none;'");
    	}else{
    		$this->assign('updivishide',"");
    		$this->assign('updivisshow',"style='display:none;'");
    	}
    	if($infoAll[0][document]==""){
    		$this->assign('updivisshow2',"");
    		$this->assign('updivishide2',"style='display:none;'");
    	}else{
    		$this->assign('updivishide2',"");
    		$this->assign('updivisshow2',"style='display:none;'");
    	}

    	$title_style=$infoAll[0]['title_style'];
    	$ts_arr=explode(';',$title_style);
    	$bold_arr=explode('font-weight:',$ts_arr[0]);
    	$color_arr=explode('color:#',$ts_arr[1]);

    	if($bold_arr[1]=='bold'){
    		$this->assign('checked','checked="checked"');
    	}
    	if(empty($color_arr[1])){
    		#$color='000000';
    		$color='';
    	}else{
    		$color=$color_arr[1];
    	}
    	$this->assign('color',$color);

    	$this->assign('nodate',"disabled='disabled'");
    	$this->assign('update',"最后更新时间：".date('Y-m-d H:i:s',$infoAll[0]['update_time']));

    	$this->assign('typeName',"新闻资讯编辑");
    	$this->assign('typeUrl',"__APP__/Message/message_edit/");
    	$this->display("Message:message_add");
    }

    public function message_del(){//删除新闻资讯
    	if($_GET["_URL_"][2]){
    		$id=$_GET["_URL_"][2];
    	}else{
    	    $id=$_POST['id'];
    	}
    	if (!empty($id)) {
            //$news = M("news");
            if(is_array($id)){
            	//$id=implode(",",$id);
            	//$result = $news->where("id in($id)")->delete();
            	$result=$this->add_recycle('news','id',$id);
            }else{
            	//$result = $news->delete($id);
            	$result=$this->add_recycle('news','id',array($id));
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

    public function message_upall(){//新闻资讯更新
    	if($_POST){
    		$newsup=D("news");
    		$id=$_POST['sortid'];
    		$sort=$_POST['sort'];
    		for($i=0;$i<count($id);$i++){
    			$arr['sort']=$sort[$i];
    			$list =$newsup->where("id=$id[$i]")->save($arr); // 根据条件保存修改的数据
    		}
    		if($list !== false){
    			$this->success('数据更新成功！');
    			exit;
    		}else {
	            $this->error($newsup->getError());exit;
	        }
    	}else{
    		$this->error('操作错误！');exit;
    	}
    }

}