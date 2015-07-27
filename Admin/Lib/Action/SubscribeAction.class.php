<?php
/**
 * @title 我的预约
 * @author lizhi
 * @create on 2015-07-14
 */

class SubscribeAction extends  CommonAction{

    //预约列表
    public function subscribe_list()
    {
        import('@.ORG.Page');

        $name        = $_POST['username'];
        $create_time = $_POST['create_time'];

        if(!empty($name)){
            $arr['cms_user.username'] = array('like', "%" . $name . "%");
            $this->assign("username", $name);
        }

        if(!empty($create_time)){
            $arr['cms_subscribe.fstcreate'] = array('EGT',$create_time);
            $this->assign("create_time", $create_time);
        }

        $user = M("subscribe");
        $count = $user->where($arr)
            ->join("join cms_user on cms_user.openid=cms_subscribe.openid")
            ->join("join cms_optometrist on cms_optometrist.id=cms_subscribe.opid")
            ->join("join cms_shop on cms_shop.id=cms_optometrist.shop_id")
            ->count();
        $p = new Page($count, 100);
        $page = $p->show();

        $datalist = $user->where($arr)->field("cms_subscribe.openid,cms_subscribe.fstcreate,cms_subscribe.id,cms_subscribe.order_sn,cms_subscribe.pay_status,cms_subscribe.pay_time,cms_subscribe.isdone,cms_subscribe.isdone_time,cms_subscribe.name as sname,cms_subscribe.sex,cms_subscribe.mobile,cms_subscribe.price,cms_subscribe.secret_key,cms_optometrist.name,cms_optometrist.job,cms_shop.addr,cms_user.username")
            ->join("join cms_user on cms_user.openid=cms_subscribe.openid")
            ->join("join cms_optometrist on cms_optometrist.id=cms_subscribe.opid")
            ->join("join cms_shop on cms_shop.id=cms_optometrist.shop_id")
            ->limit($p->firstRow . ',' . $p->listRows)->order('cms_subscribe.id desc')->select();
        //echo $user->getLastSql();

        $this->assign("page", $page);
        $this->assign("datalist", $datalist);
        $this->display();
    }

    /**
     * @title 验证用户消费
     */
    public function check()
    {
        $subscribe = M("subscribe");
        $id = intval($_POST['id']);
        $data['isdone'] = 1;
        $data['isdone_time'] = date('Y-m-d H:i:s');
        $rs = $subscribe->where('id = '.$id)->save($data);
        if ($rs !== false){
            $this->ajaxReturn('', '操作成功！', 1);
        }else{
            $this->ajaxReturn('', '验证失败！', 0);
        }
    }

    /**
     * @title 填写视力档案
     */
    public function add_vision()
    {
        $openid = $_REQUEST['openid'];
        $user_vision = M("user_vision");
        $count = $user_vision->where('openid = "'.$openid.'"')->find();

        if ($this->isPost()) {

            $data['sph_l'] = $_POST['sph_l'];
            $data['sph_r'] = $_POST['sph_r'];
            $data['pd'] = $_POST['pd'];
            $data['cyl_l'] = $_POST['cyl_l'];
            $data['cyl_r'] = $_POST['cyl_r'];
            $data['axis_l'] = $_POST['axis_l'];
            $data['axis_r'] = $_POST['axis_r'];
            $data['xiajiaguang_l'] = $_POST['xiajiaguang_l'];
            $data['xiajiaguang_r'] = $_POST['xiajiaguang_r'];
            if ($count)
            {
                $user_vision->where('openid = "' . $openid . '"')->save($data);
            } else {
                $data['openid'] = $openid;
                $user_vision->add($data);
            }
            $this->redirect('/subscribe/subscribe_list');
        }

        $this->assign('data',$count);
        $this->assign('openid',$openid);
        $this->display();
    }
}