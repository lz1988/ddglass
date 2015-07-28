<?php
/**
 * @author  
 * @uses 橡树平台首页文件
 * 
 */

// 本类由系统自动生成，仅供测试用途
class ItemAction extends PublicAction {
	/*
	 *  首页
	 */
     public function item_list(){
    	if(session('openid')==''){
    		$code=$this->_get('code');
    		if(!empty($code)){
		    	$open_id=get_openid($code);
			}elseif(!empty($_GET['openid'])){
				session('openid',$_GET['openid']);
			}
    	}
    	if($_GET['keyword']){
    		$keyword=$this->_get('keyword');
    		if(!empty($keyword)){
    			$item_where['item_name']=array('like',"%$keyword%");
    			$where_param['item_name']=$keyword;
    		}
    	}
    	foreach (C('ITEM_SEARCH') as $key=>$res){
    		if($_GET[$key]){
	    		$item_where[$key]=array('eq',$_GET[$key]);
	    		$where_param[$key]=$_GET[$key];
    		}
    	}
    	$item=M('item');
    	$item_where['status']=array('eq',1);
    	$item_list=$item->where($item_where)->where($item_where)->limit(8)->field('item_id,item_name,item_price,ori_price,icon')->select();
    	$temp='item_list';
    	if(empty($item_list)){
    		$temp='search';
    	}
    	$this->assign('item_list',$item_list);
    	$item_cart=M('item_cart');
    	$cart_where['openid']=array('eq',session('openid'));
    	$cart_list=$item_cart->field('item_id')->where($cart_where)->select();
    	foreach ($cart_list as $list){
    		$item_idarr[]=$list[item_id];
    	}
    	$this->assign('item_idarr',$item_idarr);
    	/**新闻分类**/
    	$newstype=M("newstype");
    	$newstypeinfo = $newstype->where("is_del='0' and pid<8 and status=1")->order('sort ASC')->select();  
    	$this->assign('newstypearr',$newstypeinfo);
    	$this->assign('where_param',$where_param);
		$this->display($temp);
    }
    
    /*
	 *  首页
	 */
     public function ajaxitem_list(){
    	if($_GET['keyword']){
    		$keyword=$this->_get('keyword');
    		if(!empty($keyword)){
    			$item_where['item_name']=array('like',"%$keyword%");
    			$where_param['item_name']=$keyword;
    		}
    	}
    	$page=$this->_get('page');
    	//$page=$page+1;
    	foreach (C('ITEM_SEARCH') as $key=>$res){
    		if($_GET[$key]){
	    		$item_where[$key]=array('eq',$_GET[$key]);
	    		$where_param[$key]=$_GET[$key];
    		}
    	}
    	$item=M('item');
    	$item_where['status']=array('eq',1);
    	$item_list=$item->where($item_where)->where($item_where)->limit("$page,8")->field('item_id,item_name,item_price,ori_price,icon')->select();
    	if($item_list){
    		$this->ajaxReturn($item_list,'',1);
    	}else{
    		$this->ajaxReturn($item_list,'',-1);
    	}
    }
    
    public function detail(){
    	if(session('openid')==''){
    		$code=$this->_get('code');
    		if(!empty($code)){
		    	$open_id=get_openid($code);
			}elseif(!empty($_GET['openid'])){
				session('openid',$_GET['openid']);
			}
    	}
    	$item=M('item');
    	$item_id=intval($this->_get('item_id'));
    	$item_where['status']=array('eq',1);
    	$item_where['item_id']=array('eq',$item_id);
    	$item_list=$item->where($item_where)->find();//->field('item_name,item_price,icon,detail,color,model')
    	
    	$this->assign('res',$item_list);
    	 
    	//$item_brother=M('item_brother');
        //$br_where['item_id']=array('eq',$item_id);
        //$brother_list=$item_brother->field('brother_item_id')->where($br_where)->select();
        //$brother_list=$item_brother->join('as b LEFT JOIN cms_item as i ON i.item_id=b.brother_item_id')->field('i.item_name,i.color,i.item_id')->where($br_where)->select();
        //$item_arr[]=$item_id;
        //$this->assign('brother_list',$brother_list);
        //foreach ($brother_list as $th){
        	//$item_arr[]=$th['brother_item_id'];
        //}
        //$item_str_id=implode(',',$item_arr);
       // $color_where['item_id']=array('in',"$item_str_id");
        $color_where['model']=array('eq',"$item_list[model]");
        $color_list=$item->where($color_where)->field('color,item_id')->order('item_id ASC')->select();
        $this->assign('color_list',$color_list);
        //$color_arr=explode(',',$item_list['color']);
        //$this->assign('color_arr',$color_arr);
        
    	
    	$item_images=M('item_images');
    	$img_list=$item_images->where('item_id='.$item_id)->field('img_path')->order('sort ASC')->select();
    	$this->assign('img_list',$img_list);
    	
    	/**新闻分类**/
    	$newstype=M("newstype");
    	$newstypeinfo = $newstype->where("is_del='0' and pid<8")->order('sort ASC')->select();  
    	$this->assign('newstypearr',$newstypeinfo);
    	
    	foreach($newstypeinfo as $list){
    		$pp_arr[$list[type_id]]=$list['type_name'];
    	}
    	$this->assign('pp_arr',$pp_arr);
    	
		$this->display();
    }
    
    public function add_cart(){
    	$item_id=intval($this->_post('item_id'));
    	$color=$this->_post('color');
    	$item_num=1;
    	$item=M('item');
    	$item_where['status']=array('eq',1);
    	$item_where['item_id']=array('eq',$item_id);
    	$item_list=$item->where($item_where)->field('item_name,item_price,icon,inventory,ori_price')->find();
    	if($item_list[inventory]<$item_num){
    		$this->ajaxReturn('','库存不足',-1);
    	}
    	if(session('sub.sub_id')<1){
    		$this->ajaxReturn('','请先预约',-2);
    	}
    	$item_cart=M('item_cart');
    	$cart_where['openid']=array('eq',session('openid'));
    	$cart_where['color']=array('eq',"$color");
    	$cart_where['item_id']=array('eq',$item_id);
    	$cart_where['sub_id']=session('sub.sub_id');
    	$cart_res=$item_cart->field('cart_id')->where($cart_where)->find();
    	if($cart_res){
    		$res=$item_cart->where($cart_where)->setInc('item_num',$item_num);
    	}else{
    		$add_data['sub_id']=session('sub.sub_id');
    		$add_data['item_name']=$item_list['item_name'];
    		$add_data['item_price']=$item_list['item_price'];
    		$add_data['ori_price']=$item_list['ori_price'];
    		
    		$add_data['icon']=$item_list['icon'];
    		$add_data['color']=$color;
    		$add_data['item_num']=$item_num;
    		$add_data['openid']=session('openid');
    		$add_data['item_id']=$item_id;
    		$add_data['add_time']=time();
    		$res=$item_cart->add($add_data);
    	}
    	if($res){
    		$this->ajaxReturn('','添加成功',1);
    	}else{
    		$this->ajaxReturn('','添加失败',-11);
    	}
    }
    
    
    #收藏
    public function add_collection(){
    	$item_id=$this->_post('item_id');
        if($item_id<1){
        	$this->ajaxReturn('','非法请求,数据错误',-1);
        }
    	 
    	$item_collection=M('item_collection');
    	$collection_data['item_id']=$item_id;
    	$collection_data['openid']=session('openid');
    	$res=$item_collection->field('col_id')->where($collection_data)->find();
    	if($res){
    		$this->ajaxReturn('','你已经收藏过了',-3);
    	}
    	$collection_data['create_time']=time();
    	$add_res=$item_collection->add($collection_data);
    	if($add_res){
    		$this->ajaxReturn('','收藏成功',1);
    	}else{
    		$this->ajaxReturn('','收藏失败',-4);
    	}
    	exit;
    }
    
    public function cart(){
    	$item_cart=M('item_cart');
    	$cart_where['openid']=array('eq',session('openid'));
    	$cart_where['sub_id']=session('sub.sub_id');
    	$cart_list=$item_cart->where($cart_where)->select();
    	$this->assign('cart_list',$cart_list);
		$this->display();
    }
    
    public function del_cart(){
    	$item_id=$this->_post('item_id');
        if($item_id<1){
        	$this->ajaxReturn('','非法请求,数据错误',-1);
        }
        $item_cart=M('item_cart');
    	$cart_where['openid']=array('eq',session('openid'));
    	$cart_where['item_id']=array('eq',$item_id);
    	$res=$item_cart->where($cart_where)->delete();
    	if($res){
    		$this->ajaxReturn('','成功',1);
    	}else{
    		$this->ajaxReturn('','删除失败',-4);
    	}
    }
}
