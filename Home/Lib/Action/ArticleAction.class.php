<?php
/**
 * @title 资讯管理
 * @author lizhi
 * @create on 2015-05-28
 */

class ArticleAction extends  PublicAction{

    /**
     * @title 资讯列表
     */
	
    public function article_list()
    {
    	header("Content-type:text/html;charset=utf-8");
    	/*加  */
    	    
    	if(session('openid')==''){
    		$code=$this->_get('code');
    		if(!empty($code)){
    			$open_id=get_openid($code);
    		}elseif(!empty($_GET['openid'])){
    			session('openid',$_GET['openid']);
    		}
    	}
    	/*加 */
    	
       /* if (!isset($act) || !in_array($act,array(1,2,3,4)))
       {
        header("Location:/");
      }
        $m=M('newstype');
        $e=M('news');
        $res=$m->select();
       
            
        $this->assign('res',$res);


        $title = $_POST['title'];

        if ($title)
        {
        	$keywords = " and title like '%".$title."%'";
       	}else{
            $keywords = '';
        }

        if ($act == '1' && $title){$search1 = $keywords;}
        $res1=$e->where(' type_id  = 1 '.$search1)->order('id desc')->select();
        //echo $e->getLastSql();
        $this->assign('res1',$res1);

        if ($act == '2' && $title){$search2 = $keywords;}
        $res2=$e->where(' type_id  = 2 '.$search2)->order('id desc')->select();
        //echo $e->getLastSql();
        $this->assign('res2',$res2);

        if ($act == '3' && $title){$search3 = $keywords;}
        $res3 = $e->where(' type_id  = 3 '.$search3)->order('id desc')->select();
       //echo $e->getLastSql();
        $this->assign('res3',$res3);
       

        if ($act == '4' && $title){$search4 = $keywords;}
        $res4 = $e->where(' type_id  = 4 '.$search4)->order('id desc')->select();
        //echo $e->getLastSql();
        $this->assign('res4',$res4);
       
        $this->assign('act',$act); */
       /* $act = $_REQUEST['act'];
        $newstype=M('NewsType');
        $where = "cms_newstype.type_id='" . $act . "'";
        $news=M('news');
        $res=$news->join('left JOIN cms_newstype ON cms_news.type_id=cms_newstype.type_id')
            ->field('type_name,title,content,create_time,cms_news.click_num,id')
            ->where($where)->select();

        $this->assign('res',$res);*/
        
        $this->display('guide');
    }

    public function get_article_data()
    {    /*加  */
       
        if(session('openid')==''){
            $code=$this->_get('code');
            if(!empty($code)){
                $open_id=get_openid($code);
            }elseif(!empty($_GET['openid'])){
                session('openid',$_GET['openid']);
            }
        }
        /*加 */

        $p = $_REQUEST['p'];
        $sort=$_REQUEST['sort'];
        $title=$_REQUEST['title'];
        
        $end = 9;
        $start = $end * $p;
       /* cms_news.is_del=0*/
        $where=' cms_news.is_del=0 ';
        if($title){
        	
          $openid=$_SESSION['openid'];
          $where.=" and cms_news_click.openid='" . $openid . "' ";
         //$where.=" and cms_news_click.openid='oZiSRt5jUnwjTvTyVmh_SP1Z7ol8'";
        }else{
        if(!empty($sort)){
        	//echo $title;
        	$act=$sort;
        	
        }else{
        	$act = $_REQUEST['act'];
        	//echo $act;
        } 
        $where.= " and cms_newstype.type_id='" . $act . "' ";
        }
        $newstype=M('NewsType');
       // $where = "cms_newstype.type_id='" . $act . "' ".$confition;
        $news=M('news');
        $res=$news->join('left JOIN cms_newstype ON cms_news.type_id=cms_newstype.type_id')
              ->join('left JOIN cms_news_click ON cms_news.id=cms_news_click.news_id')
            ->field('title,create_time,cms_news.id,icon')->group('cms_news.id')->order('id desc')
            ->where($where)->limit($start . "," . $end)->select();
      // echo $news->getLastSql();
       
        for($i = 0; $i < count($res);$i++)
        {
            $res[$i]['create_time'] = date('Y-m-d',$res[$i]['create_time']);
            $data['news_id']=$res[$i]['id'];
            //$data['openid']='oZiSRt5jUnwjTvTyVmh_SP1Z7ol8';//$_SESSION['openid'];
            $rs=M('NewsClick')->where($data)->select();
            //echo M('NewsClick')->getLastSql();
            //die();
            $save=count($rs);
            if($rs){
            	$res[$i]['save']=$save;
            }else{
            	$res[$i]['save']='';
            } 
        }
        echo json_encode($res);
    }

    //文章详情
    function article_detail()
    {  
    	/*加  */
    	    
    	if(session('openid')==''){
    		$code=$this->_get('code');
    		if(!empty($code)){
    			$open_id=get_openid($code);
    		}elseif(!empty($_GET['openid'])){
    			session('openid',$_GET['openid']);
    		}
    	}
    	/*加 */
        $id = $_REQUEST['id'];
        $news = M("news");
        $newsclick=M('NewsClick');
       
        
        
        
        $openid=$_SESSION['openid'];
        $where['news_id']=$id;
        $where['openid']=$openid;
        $rs = $news->where('id = '.$id)->find();
        $res=$newsclick->where($where)->select();
        $this->assign('rs',$rs);
        if(count($res)){
        $this->assign('res',1);
        }else{
        	$this->assign('res',0);
        }
        $this->display();
    }

    /* html页面咨询页面1
     *  */
    public function guide()
    {

    	$this->display();
    }

    public function save_article(){
    	/*加  */
    	    
    	if(session('openid')==''){
    		$code=$this->_get('code');
    		if(!empty($code)){
    			$open_id=get_openid($code);
    		}elseif(!empty($_GET['openid'])){
    			session('openid',$_GET['openid']);
    		}
    	}
    	/*加 */
        $where['news_id']=$_REQUEST['id'];
     
    	$where['openid']=$_SESSION['openid'];
    	
    	$news_click=M('NewsClick');
    	$res=$news_click->add($where);
    	
    	if($res){
    		echo '1';
    		
    	}else{
    		echo '0';
    	}
    }
   public function dele_article(){
   	
   	/*加  */
   	
   	if(session('openid')==''){
   		$code=$this->_get('code');
   		if(!empty($code)){
   			$open_id=get_openid($code);
   		}elseif(!empty($_GET['openid'])){
   			session('openid',$_GET['openid']);
   		}
   	}
   	/*加 */
   	  $where['news_id']=$_REQUEST['id'];
   	 
   	  $where['openid']=$_SESSION['openid'];
   	  $news_click=M('NewsClick');
   	  $res=$news_click->where($where)->delete();
   	  //echo $news_click->getLastSql();
   	  if($res){
   	  	echo '1';
   	  }else{
   	  	echo '0';
   	  }
   }
}

