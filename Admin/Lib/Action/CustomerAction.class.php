<?php

/*
 * @author weiyuhuang
 * @title 商户信息表
 * @create on 2015/4/15
 * * */

class CustomerAction extends CommonAction {

    public function customer_index() {
        import('@.ORG.Page');

        $arr = "";
        $byshopactivity = M('ByShopActivity');
        $customer = M('shop');
        if ($_GET['findsub']) {
            $addr = trim($_GET['addr']);
            $name = trim($_GET['shopname']);
            if (!empty($addr)) {
                $arr['addr'] = array('like', "%" . $addr . "%");
                $this->assign("addr", $_GET['addr']);
            }
            if (!empty($name)) {
                $arr['name'] = array('like', "%" . $name . "%");
                $this->assign("shopname", $_GET['shopname']);
            }

            if ($_GET['status'] != 3) {
                $arr['isdelete'] = array('eq', $_GET['status']);
                $this->assign("status", $_GET['status']);
            } else {
                $this->assign("status", 3);
            }
            if (isset($_REQUEST['iscooperate'])){
                if($_REQUEST['iscooperate'] !=3) {
                    $arr['iscooperate'] = array('eq', $_REQUEST['iscooperate']);
                    $this->assign('iscooperate', $_REQUEST['iscooperate']);
                }else{
                    $this->assign('iscooperate',3);
                }
            }

            if (!empty($_GET['activity'])) {


                $activity = $_GET['activity'];
                $activity = $activity - 1;
                $arr['activity_id'] = $activity;

                $this->assign('activity', $_GET["activity"]);
            }
            if (!empty($_GET['service_type'])) {

                $service_id = $_GET['service_type'];
                $arr['service_id'] = $service_id;

                $this->assign('service_type', $service_id);
            }
        }


        
       
       
        if($_SESSION['JACK'] !=''){
        $this->assign('yourname',1);
       
        $name=$_SESSION['JACK'];
        
        $admin=M('Admin');
        $res_admin_id=$admin->field('admin_id')->where('account='."'".$name."'" )->find();
        
        $arr['cms_user_shop.uid']= intval($res_admin_id['admin_id']);
        /* echo $arr['admin_id']; */
        }
        else{
        $this->assign('yourname',0);
        }
        $count = $customer->where($arr)->count();    //计算总数
        $p = new Page($count, 50);
        $index_list = $customer
                        ->join(' left join cms_by_shop_service on cms_shop.id=cms_by_shop_service.shop_id')
                        ->join(' left join cms_by_shop_activity on cms_shop.id=cms_by_shop_activity.shop_id')
                        ->join(' left join cms_user_shop on cms_shop.id=cms_user_shop.shop_id')
                        ->field('cms_shop.*')
                        ->where($arr)->group('cms_shop.id')->order('cms_shop.id desc')->limit($p->firstRow . ',' . $p->listRows)->select();
        
        $page = $p->show();
        foreach ($index_list as $key => $v) {
            $index_list[$key][comment_num] = $this->get_comment_num($v[id]);
        }
        //echo $customer->getLastSql();
        
        $this->assign("page", $page);
        
        //$this->assign('yourname',$name);
        $this->assign('customer_info', $index_list);
        $this->display();
    }

    //添加商户信息
    public function add_customer() {
        $m = M('ShopService');
        $res = $m->select();
        $e = M('ShopActivity');
        $rs = $e->select();
        $this->assign('rs', $rs);
        $this->assign('result', $res);
        // var_dump($res);
        $this->display();
    }

    public function add() {
        $id = $_POST['id'];
        if ($_POST && !empty($_FILES)) {
            if (empty($id)) {

                $customer = M('shop');
                //$data['uid']=$_POST['account'];
                $data['name'] = $_POST['admin_name'];
                $data['addr'] = $_POST['addr'];
                $data['isdelete'] = $_POST['status'];
                $data['password'] = $_POST['password'];
                $data['phone'] = $_POST['phone'];
                $data['lon'] = $_POST['clon'];
                $data['lat'] = $_POST['clat'];
                $data['postcode'] = $_POST['email'];
                $data['city']=$_POST['city'];
                $data['remark']=$_POST['info'];
                $data['iscooperate'] = $_POST['cooperate'];
                $checked = $_POST['checkbox'];
                $achecked = $_POST['acheckbox'];
                $images_type = $_REQUEST['select_images'];


                /* var_dump($checked);
                  die(1111); */
                $rs = $customer->add($data);
                if ($rs !== false) {
                    $result = $this->insert_service($rs, $checked);
                    $ressult1 = $this->insert_activity($rs, $achecked);
                    if (!empty($_FILES['file']['name'][0])) {
                        $res = $this->insert($rs, $images_type);
                    }
                    $this->redirect("__APP__/Customer/add_customer/");
                } else {
                    $this->error("错误提交");
                }
            } else {
                //编辑信息处理

                $customer = M('shop');
                $data['name'] = $_POST['admin_name'];
                $data['addr'] = $_POST['addr'];
                $data['isdelete'] = $_POST['status'];
                $data['password'] = $_POST['password'];
                $data['phone'] = $_POST['phone'];
                $data['lon'] = $_POST['clon'];
                $data['lat'] = $_POST['clat'];
                $data['postcode'] = $_POST['email'];
                $data['iscooperate'] = $_POST['cooperate'];
                $data['lastmodify'] = date('Y-m-d-H-i-s');
                $data['city']=$_REQUEST['city'];
                $data['remark']=$_REQUEST['info'];
                /* $achecked = $_POST["acheckbox"]; */
                
                
                //var_dump($achecked);   
                $checked = $_POST['checkbox'];
                $images_type = $_REQUEST['select_images'];
                $rs = $customer->where('id=' . $id)->save($data);

                $m = M('ByShopService');
                /* $acti = M('ByShopActivity');
                $acti->where('shop_id=' . $id)->delete(); */
                $m->where('shop_id=' . $id)->delete();
                $result = $this->insert_service($id, $checked);
             /*    $result1 = $this->insert_activity($id, $achecked); */
               
                
                
                if (!empty($_FILES['file']['name'][0])) {

                    $this->insert($id, $images_type);
                }
                $this->assign('images_type',$images_type);
                $this->customer_edit($id);
                
            }
        } else {

            $this->error('请输入信息');
        }
    }

    public function customer_del() {

        $id = $_GET['id'];

        $customer = M('shop');
        $res = $customer->where("id=$id")->delete();
        //echo  M("shop")->getLastSql();
        if ($res !== false) {
            $this->redirect("__APP__/Customer/customer_index/");
        } else {
            $this->error('删除错误');
        }
    }

    public function set_status() {
        $status = $_REQUEST['status'];
        $cid = $_REQUEST['cid'];
        $status = ($status == 'open') ? '0' : '1';
        $m = M("shop");
        $save['isdelete'] = $status;
        $res = $m->where('id = ' . $cid)->save($save);
       // echo $m->getLastSql();
        if ($res !== false) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public function customer_edit($id) {
    	if(empty($id)){
        $id = $_GET['id'];
    	}
        $s = M('shop');

        $m = M('ByShopService');
        $e = M('ShopService');
        $i = M('ShopImages'); //取出图片地址
        $activity = M('ByShopActivity');
        if($_SESSION['JACK'] !=''){
        	// var_dump($_SESSION['JACK']);
        	$this->assign('yourname',1);
        	$name=$_SESSION['JACK'];
        
        	$admin=M('Admin');
        	$res_admin_id=$admin->field('admin_id')->where('account='."'".$name."'" )->find();
        
        	$arr['cms_by_user_activity.uid']= intval($res_admin_id['admin_id']);
        	/* echo $arr['admin_id']; */
        }else{
        	$this->assign('yourname',0);
        }
        $rs = M('ShopActivity')
             ->join(' left join cms_by_user_activity on cms_shop_activity.id=cms_by_user_activity.activity_id')
             ->where($arr)
             ->field('cms_shop_activity.id,activity_name') 
             ->select();
        
        //$rs = $z->select();
        $this->assign('rs', $rs);

        $resimages = $i->where('shop_id=' . $id)->select();
        /* echo '<pre>';var_dump($resimages);
          die('pppp'); */
        $res1 = $m->where('shop_id=' . $id)->select();
        $res3 = $activity->where('shop_id=' . $id)->select();
        $res = $s->where('id=' . $id)->field("id,uid,lon,lat,name,addr,city,phone,postcode,isdelete,iscooperate,remark")->find();
        $res2 = $e->select();
        $this->assign('activity', $res3);
        $this->assign('images', $resimages);
        $this->assign('result', $res2);
        $this->assign('eresult', $res1);
        $this->assign('vo', $res);
        $this->display('Customer:add_customer');
    }
    
    public function upload() {
        import('@.ORG.UploadFile');
        //2,实例化对象，调用对象的方法
        $file = new UploadFile();
        //3,上传的话需要做一些设置
        //默认情况下是-1，代表不限制文件的大小
        $file->maxSize = '10000000000';
        //allowExts 设置上传文件的扩展名
        $file->allowExts = array('jpg', 'gif', 'png', 'jpeg');
        //允许上传文件的类型
        $file->allowTypes = array('image/png', 'image/jpg', 'image/pjpeg', 'image/gif', 'image/jpeg');
        //对上传文件进行缩略图处理
        $file->thumb = true;
        //缩略图的最大的宽度
        $file->thumbMaxWidth = '100';
        //缩略图的最大的高度
        $file->thumbMaxHeight = '100';
        //缩略图的前缀
        // $file->thumbPrefix = 's_,m_';
        $file->saveRule = uniqid;
        // 缩略图保存路径
        $ymd = date("Ymd"); //图片路径地址
        $file->thumbPath = 'Uploads/shop/shop_thumb/';
        //如果上传的图片和原图一样，是否删除原图
        $file->thumbRemoveOrigin = false;
        // 上传文件保存路径
        $file->savePath = 'Uploads/shop/shop_images/';
        // 存在同名是否覆盖
        $file->uploadReplace = true;

        if ($file->upload()) {
            $info = $file->getUploadFileInfo();

            return $info;
        } else {
            $this->error($file->getErrorMsg());
        }
    }

    public function insert($rs, $images_type) {

        foreach ($_FILES as $key => $files) {
            if (empty($files['name'])) {

                $this->error('请选择需要上传的文件');
            } else {

                $data = $this->upload();

                if (isset($data)) {

                    //如果上传文件的信息不为空，我们就将这些信息保存到数据库中
                    $res = $this->db_img($data, $rs, $images_type);
                    return true;
                } else {
                    $this->error('插入到数据库失败');
                    return false;
                }
            }
        }
    }

    public function db_img($data, $rs, $images_type) {
        $img = M('shopImages');

        foreach ($data as $v) {

            $data['shop_id'] = $rs;
            $data['images_url'] = $v['savepath'] . $v['savename'];
            $data['thumb_url'] = 'Uploads/shop/shop_thumb/thumb_' . $v['savename'];
            $data['images_type'] = $images_type;
            $img->data($data)->add();
        }
    }

    public function insert_service($rs, $checked) {
        $m = M('ByShopService');
        foreach ($checked as $val) {
            $data['shop_id'] = $rs;
            $data['service_id'] = intval($val);
            $res = $m->data($data)->add();
        }
    }

    public function insert_activity($rs, $checked) {
        $m = M('ByShopActivity');
        foreach ($checked as $val) {
            $data['shop_id'] = $rs;
            $data['activity_id'] = intval($val);
            $res = $m->data($data)->add();
            $this->success("设置成功");
        }
    }

    /*
     * 删除图片
     */

    public function dele_images() {
        /* $thumb_id=$_REQUEST['data-id'];
          $m=M('ShopImages');
          $data['id']=$thumb_id;
          $res=$m->where($data)->delete();
          //echo $m->getLastSql();

          if($res){
          $this->success('成功');
          }else{
          $this->error('失败');
          } */
        $thumb_id = $_REQUEST['data-id'];
        $id=$_REQUEST['data-shop'];
        /* echo json_encode($thumb_id);
          die('pppp'); */
        $images_type = $_REQUEST['data-image-type'];
        $m = M('ShopImages');
        $data['id'] = $thumb_id;
        $res = $m->where($data)->delete();
        if ($res) {
        	$this->assign('images_type',$images_type);
           $this->customer_edit($id);
        } else {
           $this->error();
        }
    }

    /*
     * 得到商铺对应评论条数 
     */

    public function get_comment_num($shop_id) {
        $comment = M("comment");
        $num = $comment->where("shop_id='" . $shop_id . "'")->count();
        return $num;
    }

    /**
     * 获取评论列表详情
     */
    function usercommentlist() {
        import('@.ORG.Page');
//        if ($_REQUEST['username'])
//        {
//            $condition['username'] = array("like","%".$_REQUEST['username']."%");
//        }
//
//        if (isset($_REQUEST['sex']))
//        {
//            if($_REQUEST['sex']==="1")
//            {
//                $condition['sex']="1";
//            }
//            else if ($_REQUEST['sex'] == "0")
//            {
//                $condition['sex']="0";
//            }
//        }
        $Dao = M();
        $count = $Dao->where("shop_id='" . $_REQUEST[id] . "'")->count();
        $Page = new Page($count);
        $show = $Page->show();
        $list = $Dao->table("cms_shop as a,cms_comment as b")->where("b.shop_id='" . $_REQUEST[id] . "' and a.id = b.shop_id")->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('page', $show);
        $this->assign("data", $list);
        $this->display();
    }
   public function insert_activity_info($activity_info,$activity_id,$id){
   	$data['shop_id']=$id;
   	$data['activity_id']=$activity_id;
   	//$save['activity_info']=$activity_info;
   	$m=M('ByShopActivity');
   	
   	
   	
   	$save['activity_info'] = $activity_info;
  
   	
   	
   	
    $res=$m->where($data)->save($save);
   
   	
   }
   /* 活动  */
   public function activity_index($id){
    if($_REQUEST['id']){
   	$id=$_REQUEST['id'];
    }
    
   
    /* 商店的活动类型  */
   
   	$m=M('ByShopActivity');
   	$res=$m->join('left join cms_shop on cms_by_shop_activity.shop_id=cms_shop.id')
   	  ->join('left join cms_shop_activity on cms_shop_activity.id=cms_by_shop_activity.activity_id')
   	  ->field('cms_shop.name,cms_shop_activity.activity_name,cms_by_shop_activity.activity_info,start_time,end_time,cms_by_shop_activity.id,cms_by_shop_activity.shop_id as shop_id')
   	  ->where('cms_by_shop_activity.shop_id='.$id)
   	  ->select();
 
   
   	$this->assign('data',$res);
   	$this->assign('s_id',$id);
   	$this->display('activity_index');
   }
   
   
   public function info_edit(){
   	 if($_REQUEST['id']){
   	 $shop_id=$_REQUEST['shop_id'];
   	 $id=$_REQUEST['id'];
   	 echo $id;
   	 $this->assign('id',$id);
   	 $this->assign('shop_id',$shop_id);
   	 $this->display();
   	 }
   	 if($_REQUEST['admin_id']){
   	 	$id=$_REQUEST['admin_id'];
   	 	$shop_id=$_REQUEST['shop_id'];
   	 	$content=$_REQUEST['activityname'];
   	 	$data['activity_info']=$content;
   	 	$m=M('ByShopActivity');
   	 	$m->where('id='.$id)->save($data);
   	 	$this->activity_index($shop_id);
   	 	/* $this->display('activity_index'); */
   	// echo 	$m->getLastSql();
   	 }
   	 
   }
  public function activity_add( ){
  	/* 用户名下的活动类型  */
  	if($_SESSION['JACK'] !=''){
  		// var_dump($_SESSION['JACK']);
  		$this->assign('yourname',1);
  		$name=$_SESSION['JACK'];
  	
  		$admin=M('Admin');
  		$res_admin_id=$admin->field('admin_id')->where('account='."'".$name."'" )->find();
  	
  		$arr['cms_by_user_activity.uid']= intval($res_admin_id['admin_id']);
  		/* echo $arr['admin_id']; */
  	}
  	 
  	
  	$rs = M('ShopActivity')
  	->join(' left join cms_by_user_activity on cms_shop_activity.id=cms_by_user_activity.activity_id')
  	->where($arr)
  	->field('cms_shop_activity.id,activity_name')
  	->group('id')
  	->select();
  	/* var_dump($rs);
  	die(); */
  	//$rs = $z->select();
  	$this->assign('rs', $rs);
  	
  	$id=$_REQUEST['shop_id'];
   // var_dump($rs);
  	/* 商店的活动类型  */
  	$m=M('ByShopActivity');
  	$res=$m->join('left join cms_shop on cms_by_shop_activity.shop_id=cms_shop.id')
  	->join('left join cms_shop_activity on cms_shop_activity.id=cms_by_shop_activity.activity_id')
  	->field('cms_shop.name,cms_shop_activity.activity_name,cms_shop_activity.id as activity_id,cms_by_shop_activity.activity_info,start_time,end_time,cms_by_shop_activity.id,cms_by_shop_activity.shop_id as shop_id')
  	
  	->where('cms_by_shop_activity.shop_id='.$id)
  	->select();
  	/* echo $m->getLastSql(); */
  	//var_dump($res);  
  	$this->assign('activity',$res);
  	$this->assign('shop_id',$id);
  	$this->display();
  	
  	
  }
  public function save_activity(){
  
   $acti=M('ByShopActivity');
   $id=$_REQUEST['shop_id'];
   $activity_name=$_REQUEST['activity_name'];
   $flag=false;
   $res_acti=$acti->where('shop_id='.$id)->select();
   foreach($res_acti as $val){
   	if($val['activity_id']==$activity_name){
   		$flag=true;
   	  }
   }
   if($flag==true){
   	$this->error('该活动已添加');
   }else{
   
   	$act=M('ByShopActivity');
   	$data['shop_id']=$_REQUEST['shop_id'];
   	$data['activity_id']=$activity_name;
   
   	$data['activity_info']=$_REQUEST['activity_info'];
   	$data['start_time']=$_REQUEST['start_time'];
   	$data['end_time']=$_REQUEST['end_time'];
   	$res=$act->data($data)->add();
   	
   
   	if($res){
   		$this->success('添加成功');
   	  }
    }
  }  
  
  public function dele_activity(){
  	 $id=$_REQUEST['id'];
  	 //$shop_id=$_REQUEST['shop_id'];
  	 $m=M('ByShopActivity');
  	 $res=$m->where('id='.$id)->delete();
  	 if($res){
  		$this->success('删除成功');
  	 }
  }
  
  
}
