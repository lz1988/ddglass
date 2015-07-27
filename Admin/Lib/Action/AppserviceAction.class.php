<?php
/**
 * @title appservice接口提供方法
 * @author lizhi
 * @create on 2015-04-17
 */

class AppserviceAction extends Action{

    /**
     * @title 获取商铺列表信息
     * @author lizhi
     * @create on 2015-04-17
     */
    public function get_shop_list()
    {
        header( 'Access-Control-Allow-Origin:*' );
        $shop = M("shop");
        $data = $shop->select();
        echo json_encode($data);

    }

    public function set_session()
    {
        $_SESSION['name'] = 'kobe';
        print_r($_SESSION);
    }
}