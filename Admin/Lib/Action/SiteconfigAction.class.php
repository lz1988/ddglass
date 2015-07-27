<?php

class SiteconfigAction extends CommonAction {

    public function site_list(){//编辑站点
    	if($_POST){
    		$site=M("config"); 
    		if ($vo = $site->create()) { 
	            $list = $site->save(); 
	            if ($list !== false) { 
	            	$url='./test.php';
//	            	 $fp=fopen($url,"r+"); 
//	            	 fwrite($fp,'test');
//                     fclose($fp);  
                     $config_content="<?php
                        return array(
                               'URL_MODEL'=>1,
                             'DB_TYPE'=>'mysql',
						     'DB_HOST'=>'".$this->_post('db_host')."',
						     'DB_NAME'=>'".$this->_post('db_name')."',
						     'DB_USER'=>'".$this->_post('db_user')."',
						     'DB_PWD'=>'".$this->_post('db_pwd')."',
						     'DB_PORT'=>'".$this->_post('db_port')."',
						     'DOMAIN_PATH' =>'".$this->_post('domain_path')."',
						     'DB_PREFIX'=>'".$this->_post('db_prefix')."',
						     'NEWIMGURL'=>__ROOT__.'/Uploads/New/',//新闻图片路径
						     'ADVERTIMGURL'=>__ROOT__.'/Uploads/Advert/',//广告图片路径
						     'USERIMGURL'=>__ROOT__.'/Uploads/User/',//会员头像图片路径
							 'SITE_CONFIG'=>__ROOT__.'/Uploads/site_config/',//站点文件上传路径          
                       );                     
?>";
                     file_put_contents ('./test.php',$config_content);
	                $this->success('数据更新成功！');
	            } else {
	                $this->error("没有更新任何数据!");
	            }
	        } else {
	            $this->error($site->getError());
	        } 
	        exit;
    	}
    	   
    	$siteinfo=M("config"); 
        $infoAll = $siteinfo->order('id ASC')->find();  
        if(empty($infoAll)){$data['id']=1;$siteinfo->add($data);$infoAll = $siteinfo->order('id ASC')->find();  }
        if($infoAll['page_num']<1){
        	$infoAll['page_num']=15;
        }
		if(trim($infoAll['header_img'])==""){
    		$this->assign('updivisshow',""); 
    		$this->assign('updivishide',"style='display:none;'"); 
    	}else{
    		$this->assign('updivishide',""); 
    		$this->assign('updivisshow',"style='display:none;'"); 
    	}
		$this->assign('arr',$infoAll);
    	$this->assign('headerimgurl',C('SITE_CONFIG'));
    	$this->assign('typeName',"站点信息编辑"); 
    	$this->display("Manage:site_config");
    }
  
    /**
     * 敏感词
     * **/
    public function wordclose(){
    	$site=M("wordclose"); 
    	if($_POST){
	    	if ($vo = $site->create()) { 
		        $list = $site->save(); 
		        if ($list !== false) { 
		            $this->success('数据更新成功！');
		        } else {
		            $this->error("没有更新任何数据!");
		        }
		    }else {
		        $this->error($site->getError());
		    } 
		    exit;
    	}
        $infoAll = $site->order('id ASC')->find();  
        if(empty($infoAll)){$data['id']=1;$site->add($data);$infoAll = $site->order('id ASC')->find();  }
        $this->assign('arr',$infoAll);
	    $this->display("Manage:wordclose");
   } 
    
   
}