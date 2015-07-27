<?php
/** 
 * @date 2012.7.24
 * @author IT部门dapeng.chen 
 * @deprecated 橡树游戏平台，莱科版权所有
 * @abstract 新闻栏目
 */  
class AppmenuAction extends CommonAction {
    public function menu_list(){//新闻栏目列表
    	$app_menu=M("app_menu");
    	import('@.ORG.Page');  
        $arr="";
        if($_GET['findsub']){ 
        	$type_name=trim($_GET['name']);
        	 
        	if(!empty($type_name)){$arr['name'] = array('LIKE',"%".$type_name."%");$this->assign("name", $_GET['name']);}  
        } 
        $arr['is_del']=array('eq',0);
        $arr['pid']=array('eq',0);
        $count = $app_menu->where($arr)->count();    //计算总数 
        $p = new Page($count, 15);
        $menu_list = $app_menu->where($arr)->order('sort ASC,create_time DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
        $page = $p->show(); 
        $this->assign("page", $page);   
    	$this->assign('menu_list', $menu_list);  
    	
    	$arr_id='';
    	foreach ($menu_list as $list){
    		$arr_id[]=$list['id'];
    	}
    	
    	$arr['pid']=array('in',$arr_id);
    	$p_res=$app_menu->where($arr)->order('sort ASC,create_time DESC')->select();
    	$this->assign("p_res", $p_res);   
    	
        $this->display(); 
    }
    
    public function menu_add(){//添加新闻栏目
    	$app_menu=M("app_menu"); 
    	if($_POST){ 
    		$_POST['remark']= str_replace('src="/Uploads/Attached/', 'src="http://'.$_SERVER[SERVER_NAME].'/Uploads/Attached/', $_POST['remark']); 
    		if ($vo = $app_menu->create()) { 
	            $list = $app_menu->add(); 
	            if ($list !== false) {
                    $this->redirect("__APP__/Appmenu/menu_list/");
	            } else {
	                $this->error("数据写入错误!");
	            }
	        } else {
	            $this->error($app_menu->getError());
	        } 
	        exit;
    	}
    	 
    	$type_where['is_del']=array('eq',0);
    	$type_where['pid']=array('eq',0);
        $infoAll = $app_menu->field('id,name')->where($type_where)->select();  
        $this->assign('typelist',$infoAll);
        
        $arr['pid']=$_GET["_URL_"][2];   
        $arr['sort']=99;   
        $this->assign('arr',$arr); 
    	$this->display();
    }
    
    public function menu_edit(){//新闻栏目编辑
    	if($_POST){
    		$app_menu=D("app_menu"); 
    		$_POST['remark']= str_replace('src="/Uploads/Attached/', 'src="http://'.$_SERVER[SERVER_NAME].'/Uploads/Attached/', $_POST['remark']); 
    		if ($vo = $app_menu->create()) { 
	            $list = $app_menu->save(); 
	            if ($list !== false) {
                    $this->redirect("__APP__/Appmenu/menu_list/");
	            } else {
	                $this->error("没有更新任何数据!");
	            }
	        } else {
	            $this->error($newstypeup->getError());
	        } 
	        exit;
    	}
    	 
    	$app_menu=M("app_menu");
    	$type_id=$_GET["_URL_"][2];   
    	$condition['id'] = $type_id; //使用查询条件 
        $infoAll = $app_menu->where($condition)->find();  
        $this->assign('arr',$infoAll);
        
        $type_where['is_del']=array('eq',0);
    	$type_where['pid']=array('eq',0);
        $list = $app_menu->field('id,name')->where($type_where)->select();  
        $this->assign('typelist',$list);
           
    	$this->display("menu_add");
    }
 
    public function menu_del(){//删除新闻栏目
    	if($_GET["_URL_"][2]){
    		$id=$_GET["_URL_"][2];
    	}else{
    	    $id=$_POST['id'];
    	}
    	if (!empty($id)) { 
            if(is_array($id)){
            	$result=$this->add_recycle('app_menu','id',$id);
            }else{
            	$result=$this->add_recycle('app_menu','id',array($id));  
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
    
    public function create_menu(){//生成菜单高级接口使用
    	$app_menu=M("app_menu");
    	$menu_where['status']=array('eq',1);
    	$menu_where['is_del']=array('eq',0);
    	$menu_list=$app_menu->field('id,name,type,key_url,pid')->order('sort ASC,create_time DESC')->where($menu_where)->select();
    	$create_data['button']=array();
    	$code_arr='';
    	$APPID=C('APPID');
    	$SECRET=C('SECRET');
    	foreach ($menu_list as $list){
    		if($list[pid]==0){
    			$list_arr3=array();
    			$num=0;
    			foreach ($menu_list as $list2){
    				unset($list2_arr);
    				if($list2[pid]==$list[id]){
    					$name=sprintf('%05s',$list2['id']).time();
    					$code_arr[$list2['name']]=$name;
    					$list2_arr['name']=$name;
    					$list2_arr['type']=$list2['type'];
    					if($list2_arr['type']=='view'){
    						$type_val='url';
    						$key_url=urlencode($list2['key_url']);
    						//$key_url=$list2['key_url'];
    						$list2['key_url']="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$APPID&redirect_uri=$key_url&response_type=code&scope=snsapi_base&state=leg3s#wechat_redirect";
    					}else{
    						$type_val='key';
    					}
    					$list2_arr[$type_val]=$list2['key_url'];
    					array_push($list_arr3,$list2_arr);
    					$num++;
    				}
    			}
    			if($num==0){
    					$name=sprintf('%05s',$list['id']).time();
    					$code_arr[$list['name']]=$name;
    					$list_arr['name']=$name;
    					$list_arr['type']=$list['type'];
    					if($list_arr['type']=='view'){
    						$type_val='url';
    					}else{
    						$type_val='key';
    					}
    				#	$list_arr[$type_val]=$list['key_url'];
					$key_url=$list['key_url'];
					$list_arr[$type_val]="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$APPID&redirect_uri=$key_url&response_type=code&scope=snsapi_base&state=leg3s#wechat_redirect";
    					array_push($create_data['button'],$list_arr);
    			}else{
    				$name=sprintf('%05s',$list['id']).time();
    				$code_arr[$list['name']]=$name;
    				array_push($create_data['button'],array('name'=>$name,'sub_button'=>$list_arr3));
    			}
    		}
    	}
    	$create_data=json_encode($create_data);
    	foreach ($code_arr as $key=>$list){
    		$create_data=str_replace($list, $key, $create_data);
    	}
    	//$create_data=preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $create_data);
    	
        //获取token
        $access_token_new = new_getAccessToken();

    	$return_data=$this->post_curl("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token_new",$create_data);
    	
    	$res=@get_object_vars(@json_decode($return_data));
    	if($res['errmsg']=='ok'){
    		$this->success('菜单创建成功！');
    	}else{
    		$this->error('菜单创建失败！'.$return_data);
    	}
    	 
    }
    
    public function create_menu2(){//生成菜单
    	$app_menu=M("app_menu");
    	$menu_where['status']=array('eq',1);
    	$menu_where['is_del']=array('eq',0);
    	$menu_list=$app_menu->field('id,name,type,key_url,pid')->order('sort ASC,create_time DESC')->where($menu_where)->select();
    	$create_data['button']=array();
    	$code_arr='';
    	$APPID=C('APPID');
    	$SECRET=C('SECRET');
    	foreach ($menu_list as $list){
    		if($list[pid]==0){
    			$list_arr3=array();
    			$num=0;
    			foreach ($menu_list as $list2){
    				unset($list2_arr);
    				if($list2[pid]==$list[id]){
    					$name=sprintf('%05s',$list2['id']).time();
    					$code_arr[$list2['name']]=$name;
    					$list2_arr['name']=$name;
    					$list2_arr['type']=$list2['type'];
    					if($list2_arr['type']=='view'){
    						$type_val='url';
    					}else{
    						$type_val='key';
    					}
    					$list2_arr[$type_val]=$list2['key_url'];
    					array_push($list_arr3,$list2_arr);
    					$num++;
    				}
    			}
    			if($num==0){
    					$name=sprintf('%05s',$list['id']).time();
    					$code_arr[$list['name']]=$name;
    					$list_arr['name']=$name;
    					$list_arr['type']=$list['type'];
    					if($list_arr['type']=='view'){
    						$type_val='url';
    					}else{
    						$type_val='key';
    					}
    					$list_arr[$type_val]=$list['key_url'];
    					array_push($create_data['button'],$list_arr);
    			}else{
    				$name=sprintf('%05s',$list['id']).time();
    				$code_arr[$list['name']]=$name;
    				array_push($create_data['button'],array('name'=>$name,'sub_button'=>$list_arr3));
    			}
    		}
    	}
    	$create_data=json_encode($create_data);
    	foreach ($code_arr as $key=>$list){
    		$create_data=str_replace($list, $key, $create_data);
    	}
    	//$create_data=preg_replace("#\\\u([0-9a-f]+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $create_data);
    	$access_token=$this->get_curl("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$SECRET");
    	$access_token=@get_object_vars(@json_decode($access_token));

    	$return_data=$this->post_curl("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token[access_token]",$create_data);
    	$res=@get_object_vars(@json_decode($return_data));
    	if($res['errmsg']=='ok'){
    		$this->success('菜单创建成功！');
    	}else{
    		$this->error('菜单创建失败！'.$return_data);
    	}
    	 
    }
    
     
}
