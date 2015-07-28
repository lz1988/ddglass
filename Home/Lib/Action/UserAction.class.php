<?php

/**
 * @author  dapeng.chen
 * @data   2013-07-11
 * 
 */
// 本类由系统自动生成，仅供测试用途
class UserAction extends PublicAction {

    public function subscribe_index() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        $subscribe = M('subscribe');
        $sub_where['openid'] = array('eq', session('openid'));
        $sub_res = $subscribe->where($sub_where)->field('id')->find();
        if ($sub_res) {
            $this->redirect('/user/subscribe');
            exit;
        }
        $this->display();
    }

    /**
     * 在线预定
     * * */
    public function subscribe() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        if ($this->isPost()) {
            //"user_name="+user_name+"&usernameid="+usernameid+"&city_name="+city_name+"&address="+address+"&sub_time="+sub_time,
            $username = $this->_post('user_name');
            $usernameid = $this->_post('usernameid');
            $city_name = $this->_post('city_name');
            $address = $this->_post('address');
            $sub_time = $this->_post('sub_time');
            if ($usernameid == 0) {
                $username = session('username');
            }

            session('sub.sub_type', $usernameid);
            session('sub.username', $username);
            session('sub.city_name', $city_name);
            session('sub.address', $address);
            session('sub.sub_time', $sub_time);
            $this->ajaxReturn('', '预约成功', 1);
        }
        $date_list = '';
        $time = time();
        for ($i = 1; $i < 31; $i++) {
            $date_list[] = date('Y-m-d', $time + 24 * 3600 * $i);
        }
        $this->assign("date_list", $date_list); #
        $this->assign("seo_title", '在线预定');

        $this->get_city(0);

        $user = M('user');
        $openid = session('openid');
        $u_where['openid'] = array('eq', "$openid");
        $u_res = $user->where($u_where)->field('status')->find();
        $is_val = 'false';
        if ($u_res['status'] == 1) {

            $subscribe = M('subscribe');
            $s_where['openid'] = array('eq', "$openid");
            $s_where['tel'] = array('neq', '');
            $sub_res = $subscribe->where($s_where)->field('tel')->find();
            //echo $subscribe->getLastSql();exit;
            //print_r($sub_res);exit;
            if ($sub_res) {
                $is_val = 'true';
            }
            session('sub.phone', $sub_res[tel]);
        }
        $this->assign("is_val", $is_val);
        $this->display();
    }

    public function my_subscribe() {
        $subscribe = M('subscribe');
        $s_where['openid'] = array('eq', session('openid'));
        $sub_list = $subscribe->where($s_where)->order('id DESC')->select();
        $this->assign("sub_list", $sub_list);
        $this->display();
    }

    /*
     * 取消订单
     */

    public function cancel_sub() {
        $id = $this->_post('id');
        $where['id'] = array('eq', $id);
        $where['openid'] = array('eq', session('openid'));
        $subscribe = M('subscribe');
        $list = $subscribe->field('status')->where($where)->find();
        if ($list['status'] == 1) {
            $this->ajaxReturn('', "设计师已出发,不能取消！", -2);
            exit;
        } elseif ($list['status'] == 2) {
            $this->ajaxReturn('', "设计师已上门洽谈,不能取消！", -3);
            exit;
        }

        $save_data['status'] = -1;

        $res = $subscribe->where($where)->save($save_data);
        if ($res) {
            $this->ajaxReturn('', "取消成功！", 1);
            exit;
        } else {
            $this->ajaxReturn('', "取消失败！", -1);
            exit;
        }
        exit;
    }

    public function send() {
        if ($this->isPost()) {
            $phone = $this->_post('phone');
            if (empty($phone)) {
                $this->ajaxReturn('', '手机号码不能为空', -1);
            }
            require_once (APP_PATH . "Lib/ORG/nusoap/Client.php");
            $sms = C('SMS');
            $smsInfo['server_url'] = $sms['server_url'];
            $smsInfo['user_name'] = $sms['user_name'];
            $smsInfo['password'] = $sms['password'];
            $smsInfo['pszSubPort'] = $sms['pszSubPort'];
            $code = rand(100000, 999999);
            session('code', md5($code));
            $content = '艺筑装饰手机验证码:' . $code;
            $mobiles = array($phone);
            $smscls = new Client($smsInfo['server_url'], $smsInfo['user_name'], $smsInfo['password']);
            $smscls->pszSubPort = $smsInfo['pszSubPort'];
            $smscls->setOutgoingEncoding("UTF-8");
            $result = $smscls->sendSMS($mobiles, $content);
            if ($result['msg'] == '发送成功') {
                $user = M('user');
                $u_where['openid'] = array('eq', session('openid'));
                $u_data['status'] = 1;
                $res2 = $user->where($u_where)->save($u_data);
            }
            $this->ajaxReturn('', $result['msg'], 1);
        }
    }

    public function validation() {
        if ($this->isPost()) {
            $phone = $this->_post('phone');
            $code = $this->_post('code');
            if (session('code') == md5($code)) {
                $res = true;
            } else {
                $res = false;
            }
            if ($res) {
                session('sub.phone', $phone);
                $user = M('user');
                $u_where['openid'] = array('eq', session('openid'));
                $res = $user->field('tel')->where($u_where)->find();
                if ($res['tel'] == '') {
                    $tel_data['tel'] = $phone;
                    $user->where($u_where)->save($tel_data);
                }
                $this->ajaxReturn('', '验证成功', 1);
            } else {
                $this->ajaxReturn('', '验证失败', -1);
            }
        }
        $this->display();
    }

    public function sub_orders() {
        header("Content-type: text/html; charset=utf-8");
        if (session('sub.username') == '') {
            echo '链接已过期.';
            exit;
        }
        if (session('sub.phone') == '') {
            $u_where['openid'] = array('eq', session('openid'));
            $res = $user->field('tel')->where($u_where)->find();
            session('sub.phone', $res['tel']);
        }

        $subscribe = M('subscribe');
        $add_data['username'] = session('sub.username');
        $add_data['openid'] = session('openid');
        $add_data['user_id'] = (int) session('user_id');
        $add_data['address'] = session('sub.city_name') . session('sub.address');
        $add_data['sub_time'] = session('sub.sub_time');
        $add_data['sub_type'] = session('sub.sub_type');
        $add_data['tel'] = session('sub.phone') ? session('sub.phone') : ' ';
        $add_data['status'] = 0;
        $add_data['create_time'] = time();
        $res = $subscribe->add($add_data);
        if (!$res) {
            echo '链接已过期';
            exit;
        } else {
            session('sub.sub_id', $res);
            session('sub.phone', null);
            session('sub.sub_type', null);
            session('sub.sub_time', null);
            session('sub.city_name', null);
            session('sub.address', null);
            session('sub.username', null);

            $user_sum = M('user_sum');
            $sum_res = $user_sum->where('user_id=' . session('user_id'))->field('user_id')->find();

            if ($sum_res) {
                $user_sum->where('user_id=' . session('user_id'))->setInc('sub_num', 1);
            } else {
                $sum_data['user_id'] = session('user_id');
                $sum_data['sub_num'] = 1;
                $user_sum->add($sum_data);
            }
        }
        $this->display('success');
    }

    /**
     * 会员卡
     * * */
    /*public function index() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        $this->assign("seo_title", '用户中心');
        $this->display();
    }*/

    public function my_orders() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        $orders = M("orders");
        $orders_where['openid'] = array('eq', session('openid'));
        $orders_list = $orders->where($orders_where)->field('orders_id,orders_no,create_time,amount')->order('create_time desc')->select();

        $orders_item = M('orders_item');
        foreach ($orders_list as $key => $list) {
            $oi_where['o.orders_id'] = array('eq', $list['orders_id']);
            $oi_list = $orders_item->join('as o LEFT JOIN cms_item as i ON o.item_id=i.item_id')->where($oi_where)->field('o.buy_num,o.buy_price,i.item_name,i.icon')->select();
            $num = 0;
            $tatol_num = 0;
            foreach ($oi_list as $oi) {
                if ($num == 0) {
                    $orders_list[$key]['item_name'] = $oi['item_name'];
                    $orders_list[$key][buy_price] = $oi['buy_price'];
                    $orders_list[$key][icon] = $oi['icon'];
                }
                $tatol_num = $tatol_num + $oi['buy_num'];
                $num++;
            }
            $orders_list[$key][item_num] = $tatol_num;
        }
        $this->assign("orders_list", $orders_list);
        $this->display();
    }

    public function orders_detail() {
        $orders_id = $this->_get('orders_id');

        $this->display();
    }

    public function validation_orders() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        $user_validation = M('user_validation');
        $val_where['openid'] = array('eq', session('openid'));
        $val_list = $user_validation->where($val_where)->order('create_time desc')->select();
        $this->assign("val_list", $val_list);
        $this->display();
    }

    public function collection() {
        $item_collection = M('item_collection');
        if ($this->isPost()) {
            $col_id = $this->_post('col_id');
            $where['col_id'] = array('eq', $col_id);
            $res = $item_collection->where($where)->delete();
            if ($res) {
                $this->ajaxReturn('', '成功', 1);
            } else {
                $this->ajaxReturn('', '删除失败', -1);
            }
            exit;
        }

        $cart_where['c.openid'] = array('eq', session('openid'));
        $cart_list = $item_collection->join('as c LEFT JOIN cms_item i ON i.item_id=c.item_id')->field('i.*,c.col_id')->where($cart_where)->select();
        $this->assign('cart_list', $cart_list);
        $this->display();
    }

    /*
     * 提交订单
     */

    public function ajaxSubOrder() {
        //session('weixin_key','55');
        $username = $_POST['username'];
        $identity = $_POST['identity'];
        $tel = $_POST['tel'];
        $orders_data['project'] = $project = $this->_post('project');
        $orders_data['time_hour'] = $hour = $this->_post('hour');
        $orders_data['time_md'] = $mdate = $this->_post('mdate');
        $orders_data['venues_id'] = $venues_id = $this->_post('venues_id');
        $orders_data['weixin_key'] = $weixin_key = session('weixin_key');
        if (empty($weixin_key)) {
            $this->ajaxReturn('', "页面已超时,请从菜单重新进入！", -2);
            exit;
        }
        if (empty($project) or empty($hour) or empty($mdate) or $venues_id < 1) {
            $this->ajaxReturn('', "你提交的订单数据不完整！", -1);
            exit;
        } else {
            $orders = M('orders');
            $id = $orders->max('orders_id');
            $orders_data['orders_no'] = date('ymdHis') . rand(100, 999) . $id;
            $orders_data['time_ymd'] = date('Y') . '-' . $orders_data['time_md'];
            $orders_data['create_time'] = time();

            $time_hour = explode('-', $orders_data['time_hour']);
            $curr_time = strtotime($orders_data['time_ymd'] . ' ' . $time_hour[0] . ':00');
            if ($curr_time < time()) {
                $this->ajaxReturn('', "不可以预定以前的场地！", -8);
                exit;
            }

            $is_where['weixin_key'] = array('eq', $orders_data['weixin_key']);
            $is_where['time_ymd'] = array('eq', $orders_data['time_ymd']);
            //$is_where['project']=array('eq',$project);
            $is_where['status'] = array('eq', 1);
            $is_res = $orders->where($is_where)->find();
            if (!empty($is_res)) {
                $this->ajaxReturn('', $orders_data['time_ymd'] . "你已经预定过场地了！", -5);
                exit;
            }


            unset($is_where);
            $venues_project = M('venues_project');
            $v_where['venues_id'] = array('eq', $venues_id);
            $v_where['project'] = array('eq', $project);

            $v_res = $venues_project->field('project_code,project_num,project_time')->where($v_where)->find();
            if (!empty($v_res)) {
                $project_code_arr = json_decode($v_res[project_code]);
                $project_num_arr = json_decode($v_res[project_num]);
                $project_time_arr = json_decode($v_res[project_time]);
                if (!in_array($orders_data['time_hour'], $project_time_arr)) {
                    $this->ajaxReturn('', "对不起，该时间段没有可预定的信息", -18);
                    exit;
                }
                $orders_data[project_code] = get_project_code($project_code_arr, $project, $venues_id, $orders_data['time_ymd'], $orders_data['time_hour'], $project_num_arr);
                if (empty($orders_data[project_code])) {
                    $this->ajaxReturn('', "对不起，你预约的场地已经没有了", -7);
                    exit;
                }
            } else {
                $this->ajaxReturn('', "你提交的信息有误，请返回重新下单！", -6);
                exit;
            }
            $orders_data['status'] = 1;
            $orders_id = $orders->add($orders_data);
            if ($orders_id) {
                $orders_user = M('orders_user');
                $user_data['orders_id'] = $orders_id;
                for ($i = 0; $i < count($username); $i++) {
                    $user_data['username'] = $username[$i];
                    $user_data['identity'] = $identity[$i];
                    $user_data['tel'] = $tel[$i];
                    $orders_user->add($user_data);
                }
                unset($user_data);
                $this->ajaxReturn($orders_id, "预定成功！", 1);
                exit;
            } else {
                $this->ajaxReturn('', "预定失败！", -3);
                exit;
            }
        }

        $this->ajaxReturn(1, "新增成功！", 1);
    }

    /*
     * 我的订单
     */

    public function my_order() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        //session('weixin_key','55');
        $where['weixin_key'] = array('eq', session('weixin_key'));
        $orders = M('orders');
        $orders_list = $orders->where($where)->order('create_time DESC')->select();

        $this->assign("orders_list", $orders_list);
        $this->display();
    }

    public function orders_success() {
        $orders_id = $this->_get('orders_id');
        $where['orders_id'] = array('eq', $orders_id);

        $orders_user = M('orders_user');
        $user_list = $orders_user->where($where)->select();
        $this->assign("user_list", $user_list);

        $where['weixin_key'] = array('eq', session('weixin_key'));
        $orders = M('orders');
        $orders_list = $orders->where($where)->order('create_time DESC')->find();
        $this->assign("list", $orders_list);
        $this->display();
    }

    /*
     * 取消订单
     */

    public function cancel_orders() {
        $orders_no = $this->_get('orders_no');
        $where['orders_no'] = array('eq', $orders_no);
        $orders = M('orders');
        $list = $orders->field('time_ymd,time_hour,sign_status,status')->where($where)->find();
        if ($list['sign_status'] == 1) {
            $this->ajaxReturn('', "已经确认到场,不能取消！", -2);
            exit;
        } elseif ($list['status'] != 1) {
            $this->ajaxReturn('', "订单无效,不能取消！", -3);
            exit;
        }
        $curr_time = strtotime($list['time_ymd'] . ' ' . $list['time_hour'] . ':00');
        if ($curr_time < time()) {
            $this->ajaxReturn('', "订单已过期，不能取消！", -8);
            exit;
        }
        $save_data['status'] = 2;

        $res = $orders->where($where)->save($save_data);
        if ($res) {
            $this->ajaxReturn('', "取消成功！", 1);
            exit;
        } else {
            $this->ajaxReturn('', "取消失败！", -1);
            exit;
        }
        exit;
    }

    /*
     * 帐号绑定
     */

    public function bind() {

        $this->display();
    }

    /*
     * 我的订单
     */

    public function OrderList() {
        $this->user_is_login();
        $order = M('order');
        $order_where['cms_order.user_id'] = array('eq', session('user_id'));
        $order_where['cms_order.is_del'] = array('eq', 0);
        $order_list = $order->field('cms_order.order_id,cms_order.pay_way,cms_order.con_id,cms_order.order_no,cms_order.amount,cms_order.pay_status,cms_order.start_time,cms_user_consignee.consignee')
                        ->join('LEFT JOIN cms_user_consignee ON cms_user_consignee.con_id=cms_order.con_id')
                        ->where($order_where)->select();
        $this->assign("order_list", $order_list);
        $this->display('order_list');
    }

    /*
     * 查看订单
     */

    public function orderItem() {
        $this->user_is_login();
        $order_id = $_GET['_URL_'][2];
        $order = M('order');
        $order_where['cms_order.user_id'] = array('eq', session('user_id'));
        $order_where['cms_order.order_id'] = array('eq', $order_id);
        $order_where['cms_order.is_del'] = array('eq', 0);
        $order_list = $order->field('cms_order.order_id,cms_order.pay_way,cms_order.con_id,cms_order.order_no,cms_order.amount,cms_order.pay_status,cms_order.start_time,cms_user_consignee.consignee,cms_user_consignee.address,cms_user_consignee.city_id,cms_user_consignee.phone,cms_user_consignee.email,cms_user_consignee.mobile,cms_order.remark,cms_order.amount')
                        ->join('LEFT JOIN cms_user_consignee ON cms_user_consignee.con_id=cms_order.con_id')
                        ->where($order_where)->find();
        if (!$order_list) {
            $this->error('订单无效,或者订单已被删除');
        }
        $order_item = M('order_item');
        $item_list = $order_item->field('item_id,item_name,item_attr,item_price,item_num')->where("order_id=$order_list[order_id]")->select();
        $this->assign("item_list", $item_list);
        $this->assign("order_list", $order_list);
        $this->display('order_item');
    }


    /**
     * @title 个人视力档案
     * @author lizhi
     * @create on 2015-06-04
     */
    public function user_vision_info() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        if ($this->isPost()) {

            $data['vision_title'] = $_REQUEST['vision_title'];
            $data['sex'] = $_REQUEST['sex'];
            $data['face'] = $_REQUEST['facew'];
            $data['sph_r'] = $_REQUEST['sph_r'];
            $data['pd'] = $_REQUEST['pd'];
            $data['cyl_r'] = $_REQUEST['cyl_r'];
            $data['axis_r'] = $_REQUEST['axis_r'];
            $data['sph_l'] = $_REQUEST['sph_l'];
            $data['cyl_l'] = $_REQUEST['cyl_l'];
            $data['axis_l'] = $_REQUEST['axis_l'];

            if ($_REQUEST['id']) {

                $id = $_REQUEST['id'];
                $uservision = M('UserVision');
                $uservision->where('id=' . $id)->save($data);
            } else {
                $data['openid'] = $_SESSION['openid'];

                $uservision = M('UserVision');
                //$data['openid']='oZiSRtyLseAYrB693WjHXDfzyUa8';
                $uservision->data($data)->add();
            }
        }

        $user_vision = M('UserVision');

        $openid = $_SESSION['openid'];
        //$openid='oZiSRtyLseAYrB693WjHXDfzyUa8';
        $res_vision = $user_vision->where('openid=' . "'" . $openid . "'")->select();

        $this->assign('res_vision', $res_vision);

        $this->display('personal_vision_info');
    }

    /**
     * 新增视力档案
     */
    public function add_user_vision_info() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        $id = $_REQUEST['id'];
        $uservision = M('UserVision');
        $res_vision = $uservision->where('id=' . $id)->find();


        $this->assign('vo', $res_vision);
        $this->display();
    }

    /**
     * @title 删除视力档案
     */
    public function delete_vision() {
        $id = $_REQUEST['id'];
        $uservision = M('UserVision');
        $uservision->where('id=' . $id)->delete();
        $this->redirect("__APP__/User/user_vision_info/");
    }

    /* 收货地址 */

    public function address() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        if ($_POST) {

            $useraddress = M('UserAddress');
            $data['username'] = $_REQUEST['username'];
            $data['tel'] = $_REQUEST['tel'];
            $data['address'] = $_REQUEST['address'];

            if ($_REQUEST['id']) {

                $id = $_REQUEST['id'];
                $useraddress->where('id=' . $id)->save($data);
            } else {

                //$data['openid']='oZiSRtyLseAYrB693WjHXDfzyUa8';
                $data['openid'] = $_SESSION['openid'];
                $res = $useraddress->data($data)->add();
            }
            $this->redirect("__APP__/User/add_address/");
            exit();
        }


        $useraddress = M('UserAddress');
        $res = $useraddress->where('id=' . $_REQUEST['id'])->find();
        $this->assign('res', $res);

        $this->display();
    }

    /**
     * @title 新增收货地址
     */
    public function add_address() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }


        $user = M('User');

        $useraddress = M('UserAddress');
        $openid = $_SESSION['openid'];
        //$openid='oZiSRtyLseAYrB693WjHXDfzyUa8';
        $rs_user = $user->where('openid=' . "'" . $openid . "'")->field('default_address')->find();

        $this->assign('rs_user', $rs_user);
        $res_address = $useraddress->where('openid=' . "'" . $openid . "'")->select();
        /* echo $useraddress->getLastSql(); */
        $this->assign('rs', $res_address);
        //var_dump($res_address);
        $this->display();
    }

    /**
     * @title 删除收货地址
     */
    public function dele_address() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }


        $user = M('User');

        $useraddress = M('UserAddress');
        $openid = $_SESSION['openid'];
        //$openid='oZiSRtyLseAYrB693WjHXDfzyUa8';
        $rs_user = $user->where('openid=' . "'" . $openid . "'")->field('default_address')->find();

        $id = $_REQUEST['id'];
        if ($rs_user['default_address'] == $id) {
            $data['default_address'] = null;
            $res = $user->where('openid=' . "'" . $openid . "'")->save($data);
        }
        $useraddress = M('UserAddress');

        $res = $useraddress->where('id=' . $id)->delete();
        $this->redirect("__APP__/User/add_address/");
    }

    /**
     * @title 设置默认收货地址
     */
    public function defalut_address() {

        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }


        $id = $_REQUEST['cid'];
        $openid = $_SESSION['openid'];
        //$openid='oZiSRtyLseAYrB693WjHXDfzyUa8';
        $user = M('User');
        $rs = $user->where('openid=' . "'" . $openid . "'")->find();

        if ($rs['default_address'] != $id) {

            $data['default_address'] = intval($id);

            $res = $user->where('openid=' . "'" . $openid . "'")->save($data);
        } else {
            $data['default_address'] = null;
            $res = $user->where('openid=' . "'" . $openid . "'")->save($data);
        }

        if ($res) {
            echo '1';
        } else {
            echo '0';
        }
    }

    //修改个人中心用户手机
    public function update_mobile()
    {
        if ($this->isPost())
        {
            $user = M("user");
            $data['tel'] = $_REQUEST['tel'];
            $rs = $user->where('openid="'.$_SESSION['openid'].'"')->save($data);
            if ($rs !== false)
            {
                $this->redirect('/index/myInfo');
            }
        }

        $user = M("user");
        $result = $user->where('openid="'.$_SESSION['openid'].'"')->find();
        $this->assign('result', $result);

        $this->display('phonepage');
    }


}

?>