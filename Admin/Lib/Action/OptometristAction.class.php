<?php

/**
 * Class CustomerAction
 * @title 验光师管理
 */
class OptometristAction extends CommonAction
{
    /**
     * @title 验光师列表
     */
    public function optometrist_list()
    {

        //如果是商家
        if ($_SESSION[ROLE][0]['role_id'] == 11) {
            $where = " 1 = 1 and cms_user_shop.uid=" . $_SESSION['USER_ID'];
        }
        $m = D("optometrist");
        import('@.ORG.Page');
        $count = $m->where($where)->join('left join cms_user_shop on cms_user_shop.shop_id=cms_optometrist.shop_id left join cms_shop on cms_shop.id=cms_optometrist.shop_id')->count();
        $page = new Page($count, 20);
        $show = $page->show();
        $rows = $m->where($where)
            ->join('left join cms_user_shop on cms_user_shop.shop_id=cms_optometrist.shop_id left join cms_shop on cms_shop.id=cms_optometrist.shop_id')
            ->limit($page->firstRow . ',' . $page->listRows)->order('cms_optometrist.id desc')->field('cms_optometrist.*,cms_shop.name as shopname')->select();
        //echo $m->getLastSql();

        $this->assign("page", $show);
        $this->assign("rows", $rows);

        $this->display();
    }
//http://open.weixin.qq.com/connect/oauth2/authorize?appid=wxf4607bbc7db59103&redirect_uri=http://crm.yeezoo.com/index.php/Customer/index&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect
    /**
     * @title 新增验光师
     */
    public function optometrist_add()
    {
        $user_shop = M("user_shop");
        $data = $user_shop->where('cms_user_shop.uid = '.$_SESSION['USER_ID'])->join("join cms_shop on cms_shop.id=cms_user_shop.shop_id")->field('cms_shop.id,cms_shop.name')->select();
        //var_dump($data);
        $this->assign('data',$data);
        //echo $user_shop->getLastSql();
        $this->display();
    }

    public function optometrist_addmod()
    {

        if(empty($_FILES)){
            $this->error('请选择需要上传的文件');
        }else{
            $data = $this -> upload_img();

            $ymd = date("Ymd"); //图片路径地址
            $img = M('optometrist');
            $save['name']   = $_POST['name'];
            $save['job']    = $_POST['job'];
            $save['service_price']    = $_POST['service_price'];
            $save['skill']    = $_POST['skill'];
            $save['content'] = $_POST['content'];
            $save['shop_id'] = $_POST['shop_id'];

            if ($data) {
                if (!empty($_FILES['images_url']['name']) && !empty($_FILES['info_url']['name'])) {
                    $save['images_url'] = "/" . $data[0]['savepath'] . str_ireplace($ymd . '/', $ymd . '/thumb_', $data[0]['savename']);
                    $save['info_url'] = "/" . $data[1]['savepath'] . str_ireplace($ymd . '/', $ymd . '/thumb_', $data[1]['savename']);
                } elseif (!empty($_FILES['images_url']['name'])) {
                    $save['images_url'] = "/" . $data[0]['savepath'] . str_ireplace($ymd . '/', $ymd . '/thumb_', $data[0]['savename']);
                } elseif (!empty($_FILES['info_url']['name'])) {
                    $save['info_url'] = "/" . $data[1]['savepath'] . str_ireplace($ymd . '/', $ymd . '/thumb_', $data[1]['savename']);
                }
            }

                $img->data($save)->add();

        }

        $this->redirect("optometrist/optometrist_list");
    }

    /**
     * @title 验光师修改
     */
    public function optometrist_edit()
    {
        $id = $_REQUEST['id'];

        //店铺
        $user_shop = M("user_shop");
        $datalist = $user_shop->where('cms_user_shop.uid = '.$_SESSION['USER_ID'])->join("join cms_shop on cms_shop.id=cms_user_shop.shop_id")->field('cms_shop.id,cms_shop.name')->select();
        //var_dump($data);
        $this->assign('datalist',$datalist);

        $designer = M("optometrist");
        $data = $designer->where('id = '.$id)->find();
        //var_dump($data);
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * @title 验光师修改
     */
    public function optometrist_editmod()
    {
        $id = $_REQUEST['id'];
        $data = $this -> upload_img();


        $ymd = date("Ymd"); //图片路径地址
        $img = M('optometrist');
        $save['name']   = $_POST['name'];
        $save['job']    = $_POST['job'];
        $save['content'] = $_POST['content'];
        $save['service_price']    = $_POST['service_price'];
        $save['skill']    = $_POST['skill'];
        $save['shop_id'] = $_POST['shop_id'];
        if ($data)
        {
            if (!empty($_FILES['images_url']['name']) && !empty($_FILES['info_url']['name'])) {
                $save['images_url'] = "/" . $data[0]['savepath'] . str_ireplace($ymd . '/', $ymd . '/thumb_', $data[0]['savename']);
                $save['info_url'] = "/" . $data[1]['savepath'] . str_ireplace($ymd . '/', $ymd . '/thumb_', $data[1]['savename']);
            } elseif (!empty($_FILES['images_url']['name'])) {
                $save['images_url'] = "/" . $data[0]['savepath'] . str_ireplace($ymd . '/', $ymd . '/thumb_', $data[0]['savename']);
            } elseif (!empty($_FILES['info_url']['name'])) {
                $save['info_url'] = "/" . $data[0]['savepath'] . str_ireplace($ymd . '/', $ymd . '/thumb_', $data[0]['savename']);
            }
        }

        $img->where('id = '.$id)->save($save);
                /*echo $img->getLastSql();
                die();*/

        //}
        $this->redirect("optometrist/optometrist_list");
    }

    /**
     * @title 删除验光师
     */
    function optometrist_delete()
    {
        $pic_id = $_REQUEST['id'];

        $d = M("optometrist");
        $d->where('id = '.$pic_id)->delete();
        echo 1;
    }

    /**
     * @return array
     * @title 上传图片
     */
    public function upload_img(){
        import("@.ORG.UploadFile");

        import("@.ORG.Image");
        //导入上传类
        $upload = new UploadFile();
        //设置上传文件大小
        $upload->maxsize = 3145728;
        //设置上传文件类型
        $upload->allowExts = explode(',',"jpg,gif,jpeg,png");

        $ymd = date("Ymd"); //图片路径地址

        $upload->autoSub  = true ;

        $upload->thumbRemoveOrigin  = true ;
        //设置附近上传目录
        $upload->savePath = "Uploads/designer/"; //注意 目录为入口文件的相对路径
        $thumbPath ='Uploads/designer/'.$ymd.'/';//缩略图的路径
        $upload->thumbPath = $thumbPath;
        //设置需要生成缩略图他，仅对图片文件有效
        $upload->thumb = true;

        //if(!mk_dir($thumbPath)) $this->error("缩略图目录创建失败");
        //设置引用图片类库包路径
        $upload->imageClassPath = 'ORG.Net.Image';
        //设置需要生成缩略图他的文件后缀
        //$upload->thumbPrefix ='m_,s_'; //生成2张缩略图
        //设置缩略图最大宽度
        //$upload->thumbMaxWidth = '300,150';
        //设置缩略图最大高度
        // $upload->thumbMaxHeight = '300,150';

        $upload->thumbMaxWidth  = 320;
        $upload->thumbMaxHeight  = 320;
        //设置上传文件规则
        //$upload->saveRule = uniqid;
        //$upload->saveRule = time();
        $upload->saveRule = uniqid;

        $upload->subType = 'date';
        //删除原图
        //$upload->thumbRemoveOrigin = true;
        if(!$upload->upload()){
            //$this->error($upload->getErrorMsg());
        }else{
            //取得成功上传文件信息
            $info   = $upload->getUploadFileInfo();
            //$info[0]['savename']=str_ireplace($ymd.'/',$ymd.'/thumb_',$info[0]['savename']);
            //$ary['src']= $info[0]['savepath'].$info[0]['savename'];
            return $info;
        }

    }
}