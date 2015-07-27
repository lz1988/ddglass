<?php
/**
 * @title 产品管理
 * @author lizhi
 * @create on 2015-06-15
 */
class ProductAction extends CommonAction{

    /**
     * @title 产品列表
     * @author lizhi
     * @create on 2015-06-15
     */
    public function product_list()
    {
        import('@.ORG.Page');
        $model = M("product");
        if ($_REQUEST['product_name']) {
            $condition['product_name'] = array("like", "%" . $_REQUEST['product_name'] . "%");
        }
        if ($_REQUEST['is_on_sale'] != "") {
            $condition['is_on_sale'] = $_REQUEST['is_on_sale'];
        }
        $count = $model->where($condition)->count();
        $Page = new Page($count);
        $show = $Page->show();
        $goods_list = $model->where($condition)->limit($Page->firstRow . ',' . $Page->listRows)->order('product_id desc')->select();
        echo $model->getLastSql();

        $this->assign("goods_list", $goods_list);
        $this->assign('page', $show);
        $this->display();
    }

    public function product_edit()
    {
        $goods_id = $_REQUEST["id"];
        $model = M("product");
        $list = $model->where("product_id='" . $goods_id . "'")->find();

        $arr_shop = explode('/',$list['shop_id']);
        $parent_shop_list = array();
        foreach($arr_shop as $val){
            $shop = M("shop");
            if (is_numeric($val)) {
                $rs = $shop->where("id = " . $val)->field('id,name')->find();
                $parent_shop_list[] = $rs;
            }
        }
        //print_r($parent_shop_list);
        $color = $list['color'];
        $arr_color = explode("/",$color);
        $this->assign('arr_color',$arr_color);
        $this->assign('parent_shop_list',$parent_shop_list);
        $this->assign("list", $list);
        $this->display();
    }

    public function product_editmod(){
        echo '<pre>';print_r($_REQUEST);
        die();
    }
}