<?php

class GoodsAction extends CommonAction {

    public $model;

    function __construct() {
        parent::__construct();
        $this->model = M("goods");
    }

    public function index() {
        import('@.ORG.Page');
        $this->model = M("goods");
        if ($_REQUEST['goods_name']) {
            $condition['goods_name'] = array("like", "%" . $_REQUEST['goods_name'] . "%");
        }
        if ($_REQUEST['is_on_sale'] != "") {
            $condition['is_on_sale'] = $_REQUEST['is_on_sale'];
        }
        $count = $this->model->where($condition)->count();
        $Page = new Page($count);
        $show = $Page->show();
        $goods_list = $this->model->where($condition)->limit($Page->firstRow . ',' . $Page->listRows)->order('goods_id desc')->select();

        $this->assign("goods_list", $goods_list);
        $this->assign('page', $show);
        $this->display();
    }

    public function is_on_sale_ajax() {

        $data["is_on_sale"] = trim($_REQUEST["status"]);
        $where["goods_id"] = trim($_REQUEST["goods_id"]);
        if ($data["is_on_sale"] != "") {
            $result = $this->model->where($where)->save($data);
            if (false !== $result) {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    /* 删除 */

    function del() {
        $goods_id = $_REQUEST["id"];
        $result = $this->model->where("goods_id='" . $goods_id . "'")->delete();
        if ($result !== false) {
            $this->success("删除成功");
        }
    }

    /* 某个商品信息 */

    function edit() {
        $goods = M('goods');
        $goodsthumb = M('GoodsThumb');
        $goods_id = $_REQUEST["id"];
        $list = $this->model->where("goods_id='" . $goods_id . "'")->find();
        $list_thumb = $goodsthumb->where('goods_id=' . $goods_id)->select();
        $arr_shop = explode('/', $list['shop_id']);
        $arr_color = explode('/', $list['color']);
        $arr_color = array_filter($arr_color);

        $parent_shop_list = array();
        foreach ($arr_shop as $val) {
            $shop = M("shop");
            if (is_numeric($val)) {
                $rs = $shop->where("id = " . $val)->field('id,name')->find();
                $parent_shop_list[] = $rs;
            }
        }
        $this->assign("goods_attr", $this->goods_attr());
//        $this->assign('goods_attr', $this->get_attr_prop($goods_id));
        $this->assign('arr_color', $arr_color);
        $this->assign('list_thumb', $list_thumb);
        $this->assign('parent_shop_list', $parent_shop_list);
        $this->assign("list", $list);
        $this->display();
    }

    function ajax_change_checked() {
        $list = M("goods_attr")->where("goods_id='" . $_REQUEST[goods_id] . "'")->select();
        echo json_encode($list);
    }

    function edit__() {
        $goods_id = $_REQUEST["goods_id"];
        $data[goods_name] = $_REQUEST["goods_name"];
        /*  $data[goods_img] = $_REQUEST["goods_img"]; */
        $data[goods_stock] = $_REQUEST["goods_stock"];
        $data[is_on_sale] = $_REQUEST["is_on_sale"];
        $data["fee_price"] = $_REQUEST["fee_price"];
        $data["market_price"] = $_REQUEST["market_price"];
        $data["start_release_time"] = $_REQUEST["start_release_time"];
        $data["end_release_time"] = $_REQUEST["end_release_time"];
        $data[goods_desc] = $_REQUEST["goods_desc"];
        $shop_id = $_REQUEST['arr_shop_id'];
        $color = $_REQUEST['color'];

        if (!empty($_FILES['file']['name'][0])) {
            $res = $this->insert($goods_id);
        }
        foreach (array_filter($color) as $val) {
            $data['color'].=$val . '/';
        }

        if (count($_REQUEST[attr]) > 0) {
            M("goods_attr")->where("goods_id='" . $goods_id . "'")->delete();

            foreach ($_REQUEST["attr"] as $v) {
                $attr["goods_id"] = $goods_id;
                $attr["goods_attr_id"] = $v;
                M("goods_attr")->data($attr)->add();
            }
        }

        foreach (array_filter($shop_id) as $v) {
            $data["shop_id"].=$v . "/";
        }
        $result = $this->model->where("goods_id='" . $goods_id . "'")->save($data);
        /* echo '<pre>';
          print_r($_REQUEST);
          echo $this->model->getLastSql();
          die(); */
        if (false !== $result) {
            $this->success("更新成功");
        }
    }

    function add() {
        $this->assign("upload", UOLOADS_PATH);
        $this->assign("goods_attr", $this->goods_attr());
        $this->display();
    }

    function add_data() {
        $thumb = M("goods_thumb");
        $data["goods_name"] = $_REQUEST["goods_name"];
        $data["goods_stock"] = $_REQUEST["goods_stock"];
        $data["market_price"] = $_REQUEST["market_price"];
        $data["shop_price"] = $_REQUEST["shop_price"];
        $data["goods_desc"] = $_REQUEST["goods_desc"];
        $data["is_on_sale"] = $_REQUEST["is_on_sale"];

        $data["fee_price"] = $_REQUEST["fee_price"];
        $data["start_release_time"] = $_REQUEST["create_time"];
        $data["end_release_time"] = $_REQUEST["update_time"];


        $shop_id = $_REQUEST['arr_shop_id'];
        foreach (array_filter($shop_id) as $v) {
            $data["shop_id"].=$v . "/";
        }



        if ($data["shop_id"] == "") {
            $this->error("请输入合法的店铺");
        }
        if ($data["start_release_time"] == "" || $data["end_release_time"] == "") {
            $this->error("活动时间必须正确");
        }
        if (strtotime($data["start_release_time"]) > strtotime($data["end_release_time"])) {
            $this->error("活动时间必须正确");
        }


        $colordata = $_REQUEST["color"];
        foreach (array_filter($colordata) as $v) {
            $data["color"].=$v . "/";
        }
        $result = $this->model->data($data)->add();
        if (false !== $result) {
            foreach ($_REQUEST["attr"] as $v) {
                $attr["goods_id"] = $result;
                $attr["goods_attr_id"] = $v;
                M("goods_attr")->data($attr)->add();
            }
        }
        if (!empty($_FILES['file']['name'][0])) {
            $res = $this->insert($result);
        }
        $this->success('添加成功');
    }

    //店铺自动提示
    function shop_ajax_list() {
        $name = trim($_REQUEST["shop_name"]);
        $shop = M("shop");
        $where = "name like '" . $name . "%'";
        $list = $shop->where($where)->select();
        if ($list !== false && !empty($list)) {
            echo json_encode($list);
        }
    }

    function menu() {
        //一级城市
        if ($_REQUEST["id"]) {
            $cityname = $this->getcitybyid($_REQUEST["id"]);
            $proList = M("shop")->where("city='" . $cityname . "'")->select();
            foreach ($proList as $key => $v) {
                $proList[$key]["isParent"] = "false";
                $proList[$key]["shop_id"] = $v["id"];
            }
        } else {
            $proList = M("city")->where("firstchar<>''")->Field('cid as id,cname as name,pid as pId')->select();
            foreach ($proList as $key => $v) {
                $proList[$key]["isParent"] = "true";
                $proList[$key]["t"] = '0';
                $proList[$key]["nocheck"] = 'true';
            }
        }

        echo json_encode($proList);
    }

    function getShop() {
        $cityanme = $_REQUEST["cityname"];
        $shopList = M("shop")->where("city='" . $cityanme . "'")->getField("name");
        echo json_encode($shopList);
    }

    function getcitybyid($id) {
        $cityname = M("city")->where("cid='" . $id . "'")->find();
        return $cityname["cname"];
    }

    /*
     * 文件上传
     */

    public function insert($rs) {

        foreach ($_FILES as $key => $files) {


            if (empty($files['name'])) {

                $this->error('请选择需要上传的文件');
            } else {

                $data = $this->upload();

                if (isset($data)) {

                    //如果上传文件的信息不为空，我们就将这些信息保存到数据库中
                    $res = $this->db_img($data, $rs);
                    return true;
                } else {
                    $this->error('插入到数据库失败');
                    return false;
                }
            }
        }
    }

    /* 文件上传 */

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
        $file->thumbPath = '/Uploads/goods_img/';
        //如果上传的图片和原图一样，是否删除原图
        $file->thumbRemoveOrigin = false;
        // 上传文件保存路径
        $file->savePath = 'Uploads/goods_img/';
        // 存在同名是否覆盖
        $file->uploadReplace = true;

        if ($file->upload()) {
            $info = $file->getUploadFileInfo();

            return $info;
        } else {
            $this->error($file->getErrorMsg());
        }
    }

    /* 上传 */

    public function db_img($data, $rs) {
        $goods = M('Goods');
        $goods_thumb = M('GoodsThumb');

        foreach ($data as $key => $v) {
            if ($key == 0) {

                $con['goods_img'] = '/' . $v['savepath'] . $v['savename'];
                $goods->where('goods_id=' . $rs)->save($con);
            } else {
                $datas['goods_id'] = $rs;
                $datas['goods_thumb'] = '/' . $v['savepath'] . $v['savename'];
                $goods_thumb->data($datas)->add();
            }
        }
    }

    /* 删除图片附图 */

    public function dele_images() {
        $goodsthumb = M('GoodsThumb');
        $goods = M('Goods');
        $cont = $_REQUEST['con'];
        $val = $_REQUEST['val'];
        if ($cont) {
            $data['goods_img'] = null;
            $res = $goods->where('goods_id=' . $val)->save($data);
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            $res = $goodsthumb->where('id=' . $val)->delete();
            if ($res) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    function goods_attr() {
        $goods_attr_type = M("goods_attr_type");
//        $goods_attr_type->query("set names 'gb2312'"); //使用utf8编码;
        $attr_type = $goods_attr_type->select();
        if (count($attr_type) > 0) {
            foreach ($attr_type as $v) {
                $list[$v["attr_type_value"]] = $this->goods_attr_list($v[id]);
            }
            return $list;
        }
    }

    function goods_attr_list($typeid) {
        $goods_attr_value = M("goods_attr_value");
//        $goods_attr_value->query("set names 'gb2312'"); //使用utf8编码;
        $attr_value = $goods_attr_value->where("goods_attr_type_id='" . $typeid . "'")->select();
        return $attr_value;
    }

}
