<?php

/**
 * @date 2012.7.23
 * @author IT部门dapeng.chen
 * @deprecated 橡树游戏平台，莱科版权所有
 * @abstract 会员管理
 */
class MemberAction extends CommonAction {

    public function member_list_ceshide() {
        //会员列表
        $user = M('user');
        import('@.ORG.Page');
        $arr = "";

        $count = $user->where($arr)->count(); //计算总数
        $p = new Page($count, 20);
        $user_arr = $user->join('as u LEFT JOIN cms_user_sum as s ON u.user_id=s.user_id')->field('s.*,u.openid,u.username,u.user_id,u.age,u.sex,u.city_name,u.headimgurl,u.create_time,u.code_id')->limit($p->firstRow . ',' . $p->listRows)->where($arr)->order('u.user_id DESC')->select();
        log::write($user->getLastSql(), "");
        $page = $p->show();
        $this->assign("page", $page);
        $this->assign('user_list', $user_arr);


        $user_label = M('user_label');
        $label_list = $user_label->select();
        foreach ($label_list as $list) {
            $label_arr[$list[id]] = $list[name];
        }
        $this->assign('label_arr', $label_arr);
        $this->assign('label_list', $label_list);

        $vip_define = M('vip_define');
        $vip_list = $vip_define->select();
        foreach ($vip_list as $list) {
            $vip_arr[$list[id]] = $list[name];
        }
        $this->assign('vip_arr', $vip_arr);
        $this->assign('vip_list', $vip_list);

        $code = M('code');
        $code_list = $code->select();
        foreach ($code_list as $list) {
            $code_arr[$list[id]] = $list[title];
        }
        $this->assign('code_arr', $code_arr);
        $this->assign('code_list', $code_list);

        $this->assign('date_list', array(date('Y-m-d', strtotime("-1 day")), date('Y-m-d', strtotime("-7 day")), date('Y-m-d', strtotime("-30 day"))));
        $this->display();
    }
    
     //会员列表

    public function member_list()
    {
        $Data = M('user');
        import('@.ORG.Page');
        if ($_REQUEST['username'])
        {
            $condition['username'] = array("like","%".$_REQUEST['username']."%");
        }
        if($_REQUEST['focustime']){
        	$condition['fstcreate']=array("like","%".$_REQUEST['focustime']."%");
        }
        if (isset($_REQUEST['sex']))
        {
            if($_REQUEST['sex']==="1")
            {
                $condition['sex']="1";
            }
            else if ($_REQUEST['sex'] == "0")
            {
                $condition['sex']="0";
            }
        }
        if(!empty($_REQUEST['datetime'])){
        	$condition['cms_user.fstcreate'] = array('GT',$_REQUEST['datetime']);
        	$this->assign("datatime", $_GET['datatime']);
        }

        $count = $Data->where($condition)->count(); 
        $Page = new Page($count); 
        $show = $Page->show(); 
        $list = $Data->where($condition)->limit($Page->firstRow . ',' . $Page->listRows)->order('user_id desc')->select();
        //echo $Data->getLastSql();
        $this->assign('list', $list);
        $this->assign('page', $show); 
        $this->display(); 
    }

    public function add_score() { //会员积分管理#编辑
        if ($_POST) {
            if ($this->_post('score') < 1) {
                $this->error("请填写积分!");
                exit;
            }
            $vipscoreup = M("vip_score");
            $add_date['update_time'] = time();
            $add_date['create_time'] = time();
            $add_date['uid'] = (int) $this->_post('user_id');
            $add_date['event_code'] = 'sys';
            $add_date['score'] = $this->_post('score');
            $add_date['descri'] = $this->_post('descri');
            $list = $vipscoreup->add($add_date);
            if ($list !== false) {
                $user = M('user');
                $user->where("user_id=$add_date[uid]")->setInc('score', $add_date['score']);
                $this->redirect("__APP__/Member/member_list/");
            } else {
                $this->error("没有更新任何数据!");
            }
            exit;
        }
        $this->display();
    }

    public function set_sorce() { //会员积分管理#编辑
        if ($_POST) {
            if ($this->_post('score') < 1) {
                $this->ajaxReturn('', '请填写积分', -1);
            }
            $vipscoreup = M("vip_score");
            $add_date['update_time'] = time();
            $add_date['create_time'] = time();
            $add_date['user_id'] = (int) $this->_post('user_id');
            $add_date['event_code'] = 'sys';
            $add_date['score'] = $this->_post('score');
            $add_date['descri'] = $this->_post('desc');
            $list = $vipscoreup->add($add_date);
            if ($list !== false) {
                $user = M('user');
                $user_score = M('user_score');
                $res = $user_score->where("user_id=$add_date[user_id]")->find();
                if ($res) {
                    $user_score->where("user_id=$add_date[user_id]")->setInc('score', $add_date['score']);
                    $user_score->where("user_id=$add_date[user_id]")->setInc('score_total', $add_date['score']);
                } else {
                    $sorce_data['user_id'] = $this->_post('user_id');
                    $sorce_data['score_total'] = $this->_post('score');
                    $sorce_data['score'] = $this->_post('score');
                    $user_score->setInc('score', $add_date['score']);
                }
                $vip_define = M('vip_define');
                $cur_num = (int) $res['score_total'] + $add_date['score'];
                $vip_where['min_score'] = array('egt', $cur_num);
                $vip_res = $vip_define->field('id,name')->where($vip_where)->order('min_score DESC')->find();
                if (empty($vip_res)) {
                    $vip_res = $vip_define->field('id,name')->order('min_score DESC')->find();
                }
                $user_sum = M('user_sum');
                $sum_data['level'] = $vip_res['id'];
                $user_sum->where("user_id=$add_date[user_id]")->save($sum_data);

                $this->ajaxReturn($vip_res, '数据更新成功', 1);
            } else {
                $this->ajaxReturn($vip_res, '没有更新任何数据', -2);
            }
            exit;
        }
        $this->display();
    }

    public function set_level() {
        if ($_POST) {
            $level = $this->_post('level');
            $user_id = $this->_post('user_id');
            $user_sum = M('user_sum');
            $where['user_id'] = array('eq', $user_id);
            $res = $user_sum->where($where)->find();
            $save_data['level'] = $level;
            $save_data['vip'] = $level;
            if ($res) {
                $res2 = $user_sum->where($where)->save($save_data);
            } else {
                $save_data['user_id'] = $user_id;
                $res2 = $user_sum->add($save_data);
            }
            if ($res2) {
                $this->ajaxReturn('', '设置成功', 1);
            } else {
                $this->ajaxReturn('', '设置失败', -1);
            }
        }
    }

    public function set_label() {
        if ($_POST) {
            $label = $this->_post('label');
            $user_id = $this->_post('user_id');
            $user_sum = M('user_sum');
            $where['user_id'] = array('eq', $user_id);
            $res = $user_sum->where($where)->find();
            $save_data['label'] = $label;
            if ($res) {
                $res2 = $user_sum->where($where)->save($save_data);
            } else {
                $save_data['user_id'] = $user_id;
                $res2 = $user_sum->add($save_data);
            }

            $user_label_rel = M('user_label_rel');
            $del_where['user_id'] = array('eq', $user_id);
            $del_res = $user_label_rel->where($del_where)->delete();
            $label_arr = explode(',', $label);
            $data_label = '';
            foreach ($label_arr as $list) {
                $data_label[] = array(
                    'user_id' => $user_id,
                    'label_id' => $list
                );
            }
            $res2 = $user_label_rel->addAll($data_label);

            if ($res2) {
                $this->ajaxReturn('', '设置成功', 1);
            } else {
                $this->ajaxReturn('', '设置失败', -1);
            }
        }
    }

    public function member_add() { //添加会员
        if ($this->isPost()) {
//			$data['account']   = $this->_post('account');
//			$data['password']  = md5($this->_post('password'));
            $data['true_name'] = $this->_post('true_name');
            $data['sex'] = $this->_post('sex');
            $data['birthday'] = strtotime(date($this->_post('year') . '-' . $this->_post('month') . '-' . $this->_post('day'))); #生日
            $data['phone'] = $this->_post('phone');
            $data['source'] = $this->_post('source');
            $data['source_id'] = 5;
            $data['user_label_id'] = $this->_post('user_label_id');
            $data['email'] = $this->_post('email');
            $data['city_id'] = $this->_post('city_id');
            $data['address'] = $this->_post('address');
            $data['remark'] = $this->_post('remark');
            $data['create_time'] = time();
            $data['status'] = 1;
            $data['region_id'] = $this->_post('region_id');
            $data['admin_id'] = $this->_post('admin_id');

            $user = D('User');
            if ($vo = $user->create()) {
                $list = $user->add($data);
                if ($list == true) {
                    $this->set_user_log($list, $this->curr_action, '添加客户,' . $data['remark']); #跟进记录
                    $this->redirect("__APP__/Member/member_list/");
                    exit;
                } else {
                    $this->error("数据写入错误!", "");
                    exit;
                }
            } else {
                $this->error($user->getError(), "");
            }
            exit;
        }

        $con = C('USERIMGURL');
        $year = range(2005, date('Y')); #年
        $month = range(1, 12); #月
        $day = range(1, 31); #日 date('t')
        $this->assign("year", $year);
        $this->assign("month", $month);
        $this->assign("day", $day);

        $user_label = M('user_label'); # 用户标签
        $user_label_list = $user_label->field('id,name,style')->where('is_del=0')->select();
        $this->assign("label_list", $user_label_list);

        $this->get_city(0);

        $this->get_region(0);

        $admin = M('admin');
        $admin_where['admin_type'] = array('eq', 'admin');
        $admin_where['status'] = array('eq', 1);
        $admin_where['is_del'] = array('eq', 0);
        $admin_list = $admin->field('admin_id,admin_name,account')->select();
        $this->assign("admin_list", $admin_list);

        $this->assign("info", array('status' => 1));
        $this->assign("userimgurl", $con);
        $this->assign('updivishide', "style='display:none;'");
        $this->assign('updivisshow', "style=''");
        $this->assign('typeName', "添加会员");
        $this->assign('userGroup', $user_group);
        $this->assign('typeUrl', "__APP__/Member/member_add/");
        $this->assign('qdlist', $qdlist);
        $this->display("Member:member_add");
    }

    public function member_edit() { //会员编辑
        if ($this->isPost()) {
            $user_id = $_POST['user_id'];
            $data['true_name'] = $this->_post('true_name');
            $data['sex'] = $this->_post('sex');
            $data['birthday'] = strtotime(date($this->_post('year') . '-' . $this->_post('month') . '-' . $this->_post('day'))); #生日
            $data['phone'] = $this->_post('phone');
            $data['source'] = $this->_post('source');
            $data['user_label_id'] = $this->_post('user_label_id');
            $data['email'] = $this->_post('email');
            $data['city_id'] = $this->_post('city_id');
            $data['address'] = $this->_post('address');
            $data['remark'] = $this->_post('remark');
            $data['region_id'] = $this->_post('region_id');
            $data['admin_id'] = $this->_post('admin_id');

            $user = D('user');
            if ($vo = $user->create()) {
                $list = $user->where("user_id = $user_id")->data($data)->save();
                if ($list == true) {
                    $this->set_user_log($user_id, $this->curr_action, '修改客户,' . $data['remark']); #跟进记录
                    $this->redirect("__APP__/Member/member_list/");
                    exit;
                } else {
                    $this->error("数据写入错误!", "");
                    exit;
                }
            } else {
                $this->error($user->getError(), "");
            }
            exit;
        }
        $model = M('user');
        $user_id = $_GET["_URL_"][2];
        $memberInfo = $model->where("user_id = $user_id")->find();

        $con = C('USERIMGURL');


        if (!empty($memberInfo['head_icon'])) {
            $this->assign('updivisshow', "style='display:none;'");
            $this->assign('updivishide', "style=''");
        } else {
            $this->assign('updivishide', "style='display:none;'");
            $this->assign('updivisshow', "style=''");
        }
        $birthday = $memberInfo['birthday'];
        $this->assign("y", date('Y', $birthday));
        $this->assign("m", date('m', $birthday));
        $this->assign("d", date('d', $birthday));

        $year = range(2005, date('Y')); #年
        $month = range(1, 12); #月
        $day = range(1, 31); #日 date('t')
        $this->assign("year", $year);
        $this->assign("month", $month);
        $this->assign("day", $day);

        $user_label = M('user_label'); # 用户标签
        $user_label_list = $user_label->field('id,name,style')->where('is_del=0')->select();
        $this->assign("label_list", $user_label_list);

        $this->get_city($memberInfo['city_id']);

        $this->get_region($memberInfo['region_id']);

        $admin = M('admin');
        $admin_where['admin_type'] = array('eq', 'admin');
        $admin_where['status'] = array('eq', 1);
        $admin_where['is_del'] = array('eq', 0);
        $admin_list = $admin->field('admin_id,admin_name,account')->select();
        $this->assign("admin_list", $admin_list);

        $this->assign('qdlist', $qdlist);
        $this->assign('userGroup', $user_group);
        $this->assign("userimgurl", $con);
        $this->assign('info', $memberInfo);
        $this->display("Member:member_add");
    }

    public function member_detail() { //会员编辑
        $model = M('user');
        $user_id = $_GET["_URL_"][2];
        $memberInfo = $model->where("user_id = $user_id")->find();

        $con = C('USERIMGURL');

        $birthday = $memberInfo['birthday'];
        $this->assign("birthday", date('Y-m-d', $birthday));


        $user_label = M('user_label'); # 用户标签
        $user_label_list = $user_label->field('id,name,style')->where('is_del=0')->select();
        $this->assign("label_list", $user_label_list);

        $this->get_city($memberInfo['city_id']);

        $this->get_region($memberInfo['region_id']);

        $admin = M('admin');
        $admin_where['admin_type'] = array('eq', 'admin');
        $admin_where['status'] = array('eq', 1);
        $admin_where['is_del'] = array('eq', 0);
        $admin_list = $admin->field('admin_id,admin_name,account')->select();
        foreach ($admin_list as $list) {
            $admin_arr[$list[admin_id]] = $list[account] . '(' . $list[admin_name] . ')';
        }
        $this->assign("admin_arr", $admin_arr);

        $act_arr['is_del'] = array('eq', 0);
        $act_arr['user_id'] = array('eq', $user_id);
        $user_activity = M('user_activity'); #试听或活动用户
        $user_arr = $user_activity->field('id,type,course,create_time,pre_status,to_status')->where($act_arr)->order('create_time DESC')->select();
        $this->assign('activity_list', $user_arr);

        $orderlog = M('orderlog'); #订单记录
        $order_arr['del_flag'] = array('eq', 0);
        $order_arr['user_id'] = array('eq', $user_id);
        $order_list = $orderlog->field('order_no,deal_time,deal_mode,money,name')->where($order_arr)->select();
        $this->assign('order_list', $order_list);
        $this->assign('order_mode', C('ORDER_MODE')); #交易方式

        $user_log = M('user_log'); #跟进记录
        $log_where['user_id'] = array('eq', $user_id);
        $log_list = $user_log->field('action,content,action_time,admin_id')->where($log_where)->select();
        $this->assign('log_list', $log_list);

        $this->assign('info', $memberInfo);
        $this->display("Member:member_detail");
    }

    public function member_del() { //删除会员
        if ($_GET["_URL_"][2]) {
            $user_id = $_GET["_URL_"][2];
        } else {
            $user_id = $_POST['user_id'];
        }
        if (!empty($user_id)) {
            //$user = M("user");
            if (is_array($user_id)) {
                //$user_id=implode(",",$user_id);
                //$result = $user->where("user_id in($user_id)")->delete();
                $result = $this->add_recycle('user', 'user_id', $user_id);
            } else {
                //$result = $user->delete($user_id);
                $result = $this->add_recycle('user', 'user_id', array($user_id));
            }
            if (false !== $result) {
                $this->success('删除成功！', "");
            } else {
                $this->error('删除出错！', "");
            }
        } else {
            $this->error('删除项不存在！', "");
        }
        exit;
    }

    public function user_blacklist() { //加入黑名单
        if ($_POST) {
            $user = M('user');
            $user_id = $this->_post('user_id');
            $user_where['user_id'] = array('eq', $user_id);
            $data['status'] = 0;
            $data['remark'] = $this->_post('remark');
            $res = $user->where($user_where)->save($data);
            if ($res) {
                $this->set_user_log($user_id, $this->curr_action, $_GET['_URL_'][3] . '加入黑名单:' . $this->_post('remark')); #跟进记录
                $this->redirect("__APP__/Member/member_list/");
            } else {
                $this->error('加入黑名单失败！', "");
            }
            exit;
        }
        $this->assign('user_id', $_GET['_URL_'][2]);
        $this->assign('user_name', $_GET['_URL_'][3]);
        $this->display("Member:user_blacklist");
    }

    public function blacklist_confirm() { //黑名单确认或恢复
        $user = M('user');
        $user_id = $_GET['_URL_'][2];
        $status = $_GET['_URL_'][3];
        $user_where['user_id'] = array('eq', $user_id);
        if ($status == 0) {
            $data['status'] = 2;
        } elseif ($status == 2) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }
        $res = $user->where($user_where)->save($data);
        if ($res) {
            $true_name = $this->get_user_true_name($user_id);
            if ($status == 0) {
                $this->set_user_log($user_id, $this->curr_action, $true_name . '加入黑名单已确认'); #跟进记录
            } elseif ($status == 2) {
                $this->set_user_log($user_id, $this->curr_action, $true_name . '已经从黑名单恢复'); #跟进记录
            } else {
                $this->set_user_log($user_id, $this->curr_action, $true_name . '加入黑名单'); #跟进记录
            }
            $this->redirect("__APP__/Member/blacklist/");
        } else {
            $this->error('操作失败！', "");
        }
        exit;
    }

    public function member_log() { //会员操作日志
        if (!$_GET["_URL_"][2]) {
            $this->error('操作有误！', 'member_list');
        }
        $user_id = $_GET["_URL_"][2];
        if (!empty($user_id)) {
            $model = M('userlog');
            import('@.ORG.Page');
            $count = $model->where("user_id = $user_id")->count(); //计算总数
            $p = new Page($count, 15);
            $user_list = $userLog = $model->where("user_id = $user_id")->limit($p->firstRow . ',' . $p->listRows)->select();
            $page = $p->show();
            $this->assign('userLog', $userLog);
            $this->assign("page", $page);
            $this->display('member_log');
        } else {
            $this->error('该会员不存在！', 'member_list');
        }
    }

    public function updeteSpUser($user_id, $sp_account) {
        $UserSpread = M('UserSpread');
        $UserSpreadInfo = $UserSpread->where("user_id = $user_id")->find();
        if ($UserSpreadInfo == FALSE) {
            $data['user_id'] = $user_id;
            $UserSpread->add($data);
            $UserSpreadInfo = $UserSpread->where("user_id = $user_id")->find();
        }
        $RebatesLog = M('RebatesLog');
        if (empty($sp_account)) {
            //如果原来的值本身相等，不做任何操作，否者做修改sp_user等于0，并且返利日志删除
            if ($UserSpreadInfo['sp_user'] == 0) {
                return true;
            } else {
                $sp_user = $UserSpreadInfo['sp_user'];
                $row = $UserSpread->where("user_id = $user_id")->setField("sp_user", 0);
                if ($row === FALSE) {

                    return FALSE;
                } else {
                    $LogInfo = $RebatesLog->where("pay_user = $user_id")->select();
                    if (!empty($LogInfo)) {
                        foreach ($LogInfo as $key => $value) {
                            $rebates_money += $value['rebates_money'];
                            unset($date);
                            $oakSpreadLog = M('SpreadLog');
                            $date['user_id'] = $user_id;
                            $date['sp_user'] = 0;
                            $date['type'] = 1;
                            $date['content'] = serialize($value);
                            $date['amount'] = $value['rebates_money'];
                            $date['add_time'] = time();
                            $date['admin_id'] = session("USER_ID");
                            $oakSpreadLog->add($date);
                        }
                        $row = $RebatesLog->where("pay_user = $user_id")->delete();
                        $rows2 = $UserSpread->where("user_id = $sp_user")->setDec("sp_money", $rebates_money);
                        if ($row === FALSE || $rows2 === FALSE) {

                            return FALSE;
                        } else {
                            $oakSpreadLog = M('SpreadLog');
                            $date['user_id'] = $user_id;
                            $date['sp_user'] = 0;
                            $date['type'] = 4;
                            $date['content'] = serialize($value);
                            $date['amount'] = $value['rebates_money'];
                            $date['add_time'] = time();
                            $date['admin_id'] = session("USER_ID");
                            $oakSpreadLog->add($date);

                            return TRUE;
                        }
                    } else {

                        return TRUE;
                    }
                }
            }
        } else {
            $userInfo = $this->getUserInfo($sp_account);
            //如果原来的值本身相等，不做任何操作，否者做修改sp_user等于0，并且返利日志删除
            if ($UserSpreadInfo['sp_user'] == $userInfo['user_id']) {
                return true;
            } else {

                if ($userInfo['sp_qd_id'] == 0) {
                    return FALSE;
                } else {
                    //取到推广人基本信息
                    $SpreadInfo = $UserSpread->where("user_id = " . $userInfo['user_id'])->find();
                    if ($SpreadInfo === FALSE) {
                        return FALSE;
                    }
                    $row = $UserSpread->where("user_id = $user_id")->setField("sp_user", $userInfo['user_id']);
                    if ($row === FALSE) {
                        return FALSE;
                    } else {
                        $Payorder = M('Payorder');
                        $JiaRebates_money = 0;
                        $orderList = $Payorder->where("user_id = $user_id and pay_status = 1 and is_del=0 ")->select();
                        foreach ($orderList as $key => $value) {
                            $order_no = $value['order_no'];
                            $LogInfo = $RebatesLog->where("order_no = '$order_no'")->find();
                            if (empty($LogInfo)) {
                                unset($data);
                                $data['order_no'] = $order_no;
                                $data['rebates_user'] = $userInfo['user_id'];
                                $data['rebates_rate'] = $SpreadInfo['sp_rate'];
                                $data['pay_user'] = $user_id;
                                $data['pay_money'] = $value['amount'];
                                $data['rebates_money'] = $value['amount'] * $SpreadInfo['sp_rate'] / 100;
                                $data['add_time'] = time();
                                $data['is_del'] = 0;
                                $rows = $RebatesLog->add($data);
                                if ($rows === FALSE) {

                                    return FALSE;
                                }
                                $JiaRebates_money += $data['rebates_money'];
                            } else {
                                unset($data);
                                $rebates_money += $LogInfo['rebates_money'];
                                $data['log_id'] = $LogInfo['log_id'];
                                $data['rebates_user'] = $userInfo['user_id'];
                                $data['rebates_rate'] = $SpreadInfo['sp_rate'];
                                $data['rebates_money'] = $value['amount'] * $SpreadInfo['sp_rate'] / 100;
                                $data['add_time'] = time();
                                $rows = $RebatesLog->save($data);
                                if ($rows === FALSE) {

                                    return FALSE;
                                }
                                $JiaRebates_money += $data['rebates_money'];
                            }

                            if ($UserSpreadInfo['sp_user'] != 0) {
                                $oakSpreadLog = M('SpreadLog');
                                $date['user_id'] = $user_id;
                                $date['sp_user'] = $userInfo['user_id'];
                                $date['type'] = 2;
                                $date['content'] = serialize($value);
                                $date['amount'] = $LogInfo['rebates_money'];
                                $date['add_time'] = time();
                                $date['admin_id'] = session("USER_ID");
                                $oakSpreadLog->add($date);
                                $oakSpreadLog = M('SpreadLog');
                                $date['user_id'] = $user_id;
                                $date['sp_user'] = $UserSpreadInfo['sp_user'];
                                $date['type'] = 1;
                                $date['content'] = serialize($value);
                                $date['amount'] = $LogInfo['rebates_money'];
                                $date['add_time'] = time();
                                $date['admin_id'] = session("USER_ID");
                                $oakSpreadLog->add($date);
                            } else {
                                $oakSpreadLog = M('SpreadLog');
                                $date['user_id'] = $user_id;
                                $date['sp_user'] = $userInfo['user_id'];
                                $date['type'] = 2;
                                $date['content'] = serialize($value);
                                $date['amount'] = $LogInfo['rebates_money'];
                                $date['add_time'] = time();
                                $date['admin_id'] = session("USER_ID");
                                $oakSpreadLog->add($date);
                            }
                        }

                        if ($UserSpreadInfo['sp_user'] != 0) {
                            $rows = $UserSpread->where("user_id = " . $UserSpreadInfo['sp_user'])->setDec("sp_money", $rebates_money);
                            $oakSpreadLog = M('SpreadLog');
                            $date['user_id'] = $user_id;
                            $date['sp_user'] = $UserSpreadInfo['sp_user'];
                            $date['type'] = 4;
                            $date['content'] = serialize($value);
                            $date['amount'] = $rebates_money;
                            $date['add_time'] = time();
                            $date['admin_id'] = session("USER_ID");
                            $oakSpreadLog->add($date);
                        } else {
                            $rows = true;
                        }
                        $rows2 = $UserSpread->where("user_id = " . $userInfo['user_id'])->setInc("sp_money", $JiaRebates_money);

                        $oakSpreadLog = M('SpreadLog');
                        $date['user_id'] = $user_id;
                        $date['sp_user'] = $userInfo['user_id'];
                        $date['type'] = 3;
                        $date['content'] = serialize($value);
                        $date['amount'] = $JiaRebates_money;
                        $date['add_time'] = time();
                        $date['admin_id'] = session("USER_ID");
                        $oakSpreadLog->add($date);


                        if ($rows === FALSE || $rows2 === FALSE) {

                            return FALSE;
                        } else {

                            return TRUE;
                        }
                    }
                }
            }
        }
    }

    public function getUserAccount($user_id) {
        $user = M('User');
        $result = $user->field("account")->find($user_id);
        return $result['account'];
    }

    public function getUserInfo($account) {
        $user = M('User');
        $result = $user->where("account = '$account'")->find();
        return $result;
    }

    public function member_editsp() {
        if ($this->isPost()) {
            $user_id = $_REQUEST['user_id'];
            if (!empty($_POST['sp_user_account'])) {
                $userInfo = $this->getUserInfo($_POST['sp_user_account']);
                if ($userInfo['sp_qd_id'] == 0 || empty($userInfo)) {

                    $this->error("推广员账号不正确!");
                }
            }
            $result = $this->updeteSpUser($user_id, $_POST['sp_user_account']);
            if ($result) {
                $this->redirect("__APP__/Member/member_list/");
            } else {

                $this->error("推广员修改错误!");
            }
            exit();
        }
        $user_id = $_REQUEST['id'];
        $user_spread = M('user');
        $userInfo = $user_spread->field('cms_user.user_id,cms_user_spread.sp_user,cms_user.account')->join('cms_user_spread on cms_user_spread.user_id =cms_user.user_id ')->where("cms_user.user_id = $user_id")->find();
        if ($userInfo == FALSE) {
            $this->error('该会员不存在！', 'member_list');
        } else if ($userInfo['sp_user']) {
            $account = $this->getUserAccount($userInfo['sp_user']);
        }

        $this->assign("user", $userInfo);
        $this->assign('account', $account);
        $this->display("Member:member_editsp");
    }

    /**
     * 处理影片列表信息导出
     */
    public function member_export() {

        $user_label = M('user_label'); # 用户标签
        $labelList = $user_label->field('id,name,style')->where('is_del=0')->select();

        $user = M('user');
        import('@.ORG.Page');
        $arr = "";
        $true_name = trim($this->_get('true_name')); #宝宝名称
        if (!empty($true_name)) {
            $arr['true_name'] = array('LIKE', "%" . $true_name . "%");
            $this->assign("true_name", $this->_get('true_name'));
        }

        $user_label_id = intval($this->_get('user_label_id')); #标签
        if ($user_label_id > 0) {
            $arr['user_label_id'] = array('eq', $user_label_id);
            $this->assign("user_label_id", $this->_get('user_label_id'));
        }

        $region_id = intval($this->_get('region_id')); #城市
        if ($region_id > 0) {
            $region_list = $user->query("SELECT id FROM `cms_region` where pid=$region_id and status=1");
            foreach ($region_list as $rlist) {
                $arr_c1[] = $rlist['id'];
            }
            $str_c1 = implode(',', $arr_c1);
            $region_list = $user->query("SELECT id FROM `cms_region` where pid in($str_c1) and status=1");
            foreach ($region_list as $rlist2) {
                $arr_c1[] = $rlist2['id'];
            }
            $str_c2 = implode(',', $arr_c1);
            $arr['region_id'] = array('in', $str_c2);
            $this->assign("region_id", $this->_get('region_id'));
        }

        $admin_id = intval($this->_get('admin_id')); #所属客服
        if ($admin_id > 0) {
            $arr['admin_id'] = array('eq', $admin_id);
            $this->assign("admin_id", $this->_get('admin_id'));
        }

        $source_id = intval($this->_get('source_id')); #到店状态
        if ($source_id != 100) {
            $arr ['cms_user.source_id'] = array('eq', $source_id);
            $this->assign("source_id", $this->_get('source_id'));
        } else {
            $this->assign("source_id", 100);
        }

        if (!empty($_GET['start_time']) AND ! empty($_GET['end_time'])) {
            $arr['create_time'] = array(array('egt', strtotime($_GET['start_time'])), array('lt', strtotime($_GET['end_time']) + 24 * 3600));
            $this->assign("end_time", $_GET['end_time']);
            $this->assign("start_time", $_GET['start_time']);
        } elseif (!empty($_GET['start_time']) AND empty($_GET['end_time'])) {
            $arr['create_time'] = array('egt', strtotime($_GET['start_time']));
            $this->assign("start_time", $_GET['start_time']);
        } elseif (!empty($_GET['end_time']) AND empty($_GET['start_time'])) {
            $arr['create_time'] = array('lt', strtotime($_GET['end_time']));
            $this->assign("end_time", $_GET['end_time']);
        }

        $arr['status'] = array('eq', 1);
        $arr['is_del'] = array('eq', 0);
        $user_arr = $user->where($arr)->order('user_id DESC')->select();
        vendor('PHPExcel_1_7_8.Classes.PHPExcel');
        vendor('PHPExcel_1_7_8.Classes.PHPExcel.IOFactory');
        vendor('PHPExcel_1_7_8.Classes.PHPExcel.Worksheet');
        //创建Excel对象
        $objPHPExcel = new PHPExcel();
        //设置Excel数据缓存方式为磁盘文件缓存（适用于大数据量处理，以减少对PHP自身内存的占用）
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
        $cacheSettings = array('dir' => C('LEG_EXCEL_DATA_CACHE_DIR'));
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        //设置Excel元数据
        $objPHPExcel->getProperties()->setCreator("客服管理系统");
        $objPHPExcel->getProperties()->setLastModifiedBy("客服管理系统后台程序");
        $objPHPExcel->getProperties()->setTitle("客服管理系统后台导出影片列表");
        $objPHPExcel->getProperties()->setSubject("客户列表");
        $objPHPExcel->getProperties()->setDescription("Exported document for Office 2007 XLSX, generated using PHP classes.");
        $objPHPExcel->getProperties()->setKeywords("office 2007 php");
        $objPHPExcel->getProperties()->setCategory("Export result file");
        //填充数据到活动的电子表格中
        $objPHPExcel->setActiveSheetIndex(0);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $objWorksheet->setCellValueByColumnAndRow(0, 1, '用户ID');
        $objWorksheet->setCellValueByColumnAndRow(1, 1, '宝宝姓名');
        $objWorksheet->setCellValueByColumnAndRow(2, 1, '标签');
        $objWorksheet->setCellValueByColumnAndRow(3, 1, '宝宝年龄');
        $objWorksheet->setCellValueByColumnAndRow(4, 1, '城市');
        $objWorksheet->setCellValueByColumnAndRow(5, 1, '电话');
        $objWorksheet->setCellValueByColumnAndRow(6, 1, '来源');
        $objWorksheet->setCellValueByColumnAndRow(7, 1, '所属客服');
        $objWorksheet->setCellValueByColumnAndRow(8, 1, '记录时间');
        foreach ($user_arr as $key => $rs) {
            $key += 2;
            $objWorksheet->setCellValueByColumnAndRow(0, $key, $rs['user_id']);
            $objWorksheet->setCellValueByColumnAndRow(1, $key, $rs['true_name ']);
            $objWorksheet->setCellValueByColumnAndRow(2, $key, $labelList[$rs['user_label_id']]);
            $objWorksheet->setCellValueByColumnAndRow(3, $key, get_age($rs['birthday']));
            $objWorksheet->setCellValueByColumnAndRow(4, $key, $rs['city_id']);
            $objWorksheet->setCellValueByColumnAndRow(5, $key, $rs['phone']);
            $objWorksheet->setCellValueByColumnAndRow(6, $key, $rs['source']);
            $objWorksheet->setCellValueByColumnAndRow(7, $key, $rs['admin_id']);
            $objWorksheet->setCellValueByColumnAndRow(8, $key, date("Y-m-d H:i:s", $rs['create_time']));
        }

        //导出到文件中
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //直接输出到浏览器
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="UsersList.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    /**
     * 处理影片列表信息导入
     */
    public function member_import() {
        import("ORG.Net.UploadFile");
        $upload = new UploadFile(); // 实例化上传类
        $upload->maxSize = C('UPLOAD_FILE_MAX_SIZE'); // 设置附件上传大小
        $upload->allowExts = array('xls', 'xlsx'); // 设置附件上传类型
        $upload->saveRule = 'uniqid'; // 上传文件命名规则
        $upload->savePath = C('UPLOAD_PATH'); // 设置原始上传目录
        $upload->autoSub = true; //是否自动为上传文件生成子目录
        $upload->subType = 'date'; //子目录创建方式，目录名以日期的'Ymd'格式创建
        if (!$upload->upload()) { // 上传错误提示错误信息
            $this->ajaxReturn(null, '上传Excel文件出错:' . $upload->getErrorMsg(), 0);
        } else { // 上传成功 获取上传文件信息
            $uploadFileinfo = $upload->getUploadFileInfo();
            $fileURL = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . '/' . $uploadFileinfo[0]['savepath'] . $uploadFileinfo[0]['savename'];
        }

        vendor('PHPExcel_1_7_8.Classes.PHPExcel');
        vendor('PHPExcel_1_7_8.Classes.PHPExcel.IOFactory');
        vendor('PHPExcel_1_7_8.Classes.PHPExcel.Worksheet');
        $FileLast = explode(".", $fileURL);
        //判断文件类型，如果不是"xls"或者"xlsx"，则退出
        if ($FileLast[count($FileLast) - 1] == "xls") {
            $inputFileType = 'Excel5';
        } elseif ($FileLast[count($FileLast) - 1] == "xlsx") {
            $inputFileType = 'Excel2007';
        } else {
            $this->error("请传入 xls 或 xlsx 格式");
        }
        //设置php服务器可用内存，上传较大文件时可能会用到
        ini_set('memory_limit', '1024M');
        //创建导入对象
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        if (!$objReader->canRead($fileURL)) {
            $this->ajaxReturn(null, '不能正常读取上传的Excel文件', 0);
        }
        $objPHPExcel = $objReader->load($fileURL); //加载Excel文件
        $objWorksheet = $objPHPExcel->getActiveSheet(); //取得活动表
        $highestRow = $objWorksheet->getHighestRow(); // 获取数据最大行数
//		$highestColumn = $objWorksheet->getHighestColumn(); // 获取数据最大列名
//		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//取得数据最大列索引		

        $errRowNum = array(); //保存导入出错的行号
        //读取sheet表格中每一行数据,从第二行开始，不读取表的列头数据
        for ($row = 2; $row <= $highestRow; ++$row) {
            $data['user_id'] = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
            $data['email'] = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
            $data['status'] = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
            $data['user_label_id'] = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
            $data['sex'] = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
            //转换时间时间戳
            $data['birthday'] = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
//			if(empty($birthdayTime)){
//				$data['birthday']=time();
//			}
//			else{
//				$birthdayTimeArr=split('-',$birthdayTime);			
//				$data['birthday']=mktime(0,0,0,$birthdayTimeArr[1],$birthdayTimeArr[2],$birthdayTimeArr[0]);
//			}
            $data['phone'] = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
            $data['true_name'] = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
            $data['head_icon'] = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
            $data['city_id'] = $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();
            //$data['create_time']=time();
            $data['create_time'] = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();
            $data['source'] = $objWorksheet->getCellByColumnAndRow(11, $row)->getValue();
            $data['source_id'] = $objWorksheet->getCellByColumnAndRow(12, $row)->getValue();
            //$data['source_id']=4;
            $data['address'] = $objWorksheet->getCellByColumnAndRow(13, $row)->getValue();
            $data['admin_id'] = $objWorksheet->getCellByColumnAndRow(14, $row)->getValue();
            //$data['admin_id'] = session("USER_ID");
            $data['region_id'] = $objWorksheet->getCellByColumnAndRow(15, $row)->getValue();
            $data['remark'] = $objWorksheet->getCellByColumnAndRow(16, $row)->getValue();
            $data['is_del'] = $objWorksheet->getCellByColumnAndRow(17, $row)->getValue();

            $user = D('User');
            $user->startTrans();
            if (empty($data['user_id'])) {
                //添加新的记录
                $res = $user->add($data);
                if ($res === false) {
                    $user->rollback();
                    $errRowNum[] = $row;
                }
            } else { //修改影片记录
                //查找导入的ID是否存在
                $res = $user->find($data['movie_id']);
                if ($res === false) {
                    $user->rollback();
                    $errRowNum[] = $row;
                } elseif ($res == null) { //不存在创建新记录
                    $res = $user->add($data);
                    if ($res === false) {
                        $user->rollback();
                        $errRowNum[] = $row;
                    }
                } else { //存在则修改记录
                    $res = $user->save($data);
                    if ($res === false) {
                        $user->rollback();
                        $errRowNum[] = $row;
                    }
                }
            }
            if ($res !== false) {
                $user->commit();
            }
        }
        //删除上传的文件
        unlink($fileURL);
        if (sizeof($errRowNum) > 0) {
            $this->ajaxReturn(null, '以下行号的数据导入失败：' . join(',', $errRowNum), 0);
        } else {
            $this->ajaxReturn(null, null, 1);
        }
    }

    public function get_weixin_user() {
        $APPID = C('APPID');
        $SECRET = C('SECRET');
        $access_token = $this->get_curl("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$SECRET");

        $access_token = @get_object_vars(@json_decode($access_token));
        $get_url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token[access_token]";
        $user_result = $this->get_curl($get_url);
        $jsoninfo = json_decode($user_result, true);
        $user_arr = $jsoninfo[data][openid];


        $user = M('user');
        foreach ($user_arr as $openid) {
            $u_where['openid'] = array('eq', $openid);
            $res = $user->where($u_where)->field('user_id')->find();
            if (!$res) {
                $user_info = $this->get_curl("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token[access_token]&openid=$openid");
                $user_info = @get_object_vars(@json_decode($user_info));
                $add_data['openid'] = $openid;
                $add_data['username'] = $user_info[nickname];
                $add_data['tel'] = '';
                $add_data['sex'] = $user_info[sex];
                $add_data['headimgurl'] = $user_info[headimgurl];
                $add_data['city_name'] = $user_info[city];
                $add_data['create_time'] = $user_info[subscribe_time];
                $add_data['status'] = 0;
                $add_data['is_master'] = 0;
                $add_data['code_id'] = 0;
                $user_id = $user->add($add_data);
                unset($add_data);
            }
        }


        echo '完成';
        exit;
    }

    //会员分组  列表 
    //拉取微信分组，保存数据库
    //修改  更改 在数据库  同步到微信 入库
    //增加  先同步到微信，然后同步回来 入库
    //
	public function member_group() {
        $userGroupModel = M('user_group');
        $groupList = $userGroupModel->select();
        $this->assign('groupList', $groupList);

        $this->display('member_group');
    }

    //拉取分组到数据库
    public function fresh_group() {
        $appid = C('APPID');
        $secret = C('SECRET');

        $appidurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $html = file_get_contents($appidurl);
        $html = stripslashes($html);
        $html = json_decode($html, true);
        $token = $html["access_token"];

        $group_url = 'https://api.weixin.qq.com/cgi-bin/groups/get?access_token=' . $token;
        $groupRes = file_get_contents($group_url);
        $groupRes = stripslashes($groupRes);
        $groupRes = json_decode($groupRes, true);

        if (isset($groupRes['errcode'])) {
            echo $groupRes['errmsg'];
            exit;
        }

        $userGroupModel = M('user_group');
        $userGroupModel->where('1=1')->delete();

        $dataArr = array();
        foreach ($groupRes['groups'] as $val) {
            $dataArr[] = array(
                'group_id' => $val['id'],
                'group_name' => $val['name'],
                'count' => $val['count']
            );
        }
        $userGroupModel->addAll($dataArr);
        echo '刷新成功';
    }

    public function group_add_do() {
        $appid = C('APPID');
        $secret = C('SECRET');

        $appidurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $html = file_get_contents($appidurl);
        $html = stripslashes($html);
        $html = json_decode($html, true);
        $token = $html["access_token"];


        $dataTo = array(
            'group' => array(
                'name' => $_POST['group_name']
            )
        );
        $dataToStr = json_encode($dataTo);

        $return_data = $this->post_curl('https://api.weixin.qq.com/cgi-bin/groups/create?access_token=' . $token, $dataToStr);


        if ($return_data) {
            $return_data_arr = json_decode($return_data, true);

            if (!isset($return_data_arr['errcode'])) {
                $userGroupModel = M('user_group');
                $dataArr = array(
                    'group_id' => $return_data_arr['group']['id'],
                    'group_name' => $return_data_arr['group']['name'],
                    'count' => 0
                );
                $userGroupModel->add($dataArr);

                echo '添加成功';
            } else {
                echo $return_data_arr['errmsg'];
            }
        } else {
            echo '添加成功';
        }
    }

    public function group_edit() {
        $group_id = $_GET['_URL_'][2];
        $userGroupModel = M('user_group');
        $ug_where['group_id'] = $group_id;

        $groupInfo = $userGroupModel->where($ug_where)->select();

        $this->assign('group_id', $group_id);
        $this->assign('group_name', $groupInfo[0]['group_name']);
        $this->display('group_edit');
    }

    public function group_edit_do() {
        $group_id = $_POST['group_id'];
        $data['group_name'] = $_POST['group_name'];
        $userGroupModel = M('user_group');
        $ug_where['group_id'] = $group_id;

        $userGroupModel->where($ug_where)->save($data);


        $appid = C('APPID');
        $secret = C('SECRET');

        $appidurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $html = file_get_contents($appidurl);
        $html = stripslashes($html);
        $html = json_decode($html, true);
        $token = $html["access_token"];
        //{"group":{"id":108,"name":"test2_modify2"}}
        //{"group":{"id":"106","name":"aaaa"}}
        $dataTo = array(
            'group' => array(
                'id' => $group_id,
                'name' => $_POST['group_name']
            )
        );
        $dataToStr = '{"group":{"id":' . $group_id . ',"name":"' . $_POST['group_name'] . '"}}';

        $return_data = $this->post_curl('https://api.weixin.qq.com/cgi-bin/groups/update?access_token=' . $token, $dataToStr);

        if ($return_data) {
            $return_data_arr = json_decode($return_data, true);
            if ($return_data_arr['errcode'] == 0) {
                echo '更新成功';
            } else {
                echo $return_data_arr['errmsg'];
            }
        } else {
            echo '更新成功';
        }
    }

    public function group_change() {
        $to_group_id = $_POST['group_id'];
        $open_id = $_POST['open_id'];

        $userModel = M('user');

        $res = M()->query('update cms_user set group_id=' . $to_group_id . ' where openid=\'' . $open_id . '\'');
        #$userModel->where("openid='{$open_id}'")->setField( array('group_id'=>$to_group_id) ) ;

        $appid = C('APPID');
        $secret = C('SECRET');

        $appidurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $html = file_get_contents($appidurl);
        $html = stripslashes($html);
        $html = json_decode($html, true);
        $token = $html["access_token"];
        //{"group":{"id":108,"name":"test2_modify2"}}
        //{"group":{"id":"106","name":"aaaa"}}
        //{"openid":"oDF3iYx0ro3_7jD4HFRDfrjdCM58","to_groupid":108}
        $dataTo = array(
            'openid' => $open_id,
            'to_groupid' => $to_group_id
        );
        $dataToStr = json_encode($dataTo);

        $return_data = $this->post_curl('https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=' . $token, $dataToStr);

        if ($return_data) {
            $return_data_arr = json_decode($return_data, true);
            if ($return_data_arr['errcode'] == 0) {
                $msg = array(
                    'status' => 1,
                    'msg' => '更新成功'
                );
                echo json_encode($msg);
            } else {

                $msg = array(
                    'status' => 1,
                    'msg' => $return_data_arr['errmsg']
                );
                echo json_encode($msg);
            }
        } else {
            $msg = array(
                'status' => 1,
                'msg' => '更新成功'
            );
            echo json_encode($msg);
            echo '更新成功';
        }
    }

    public function my_customer() {
        $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
        if ($user_id) {
            $res = M('user_customer')->field('id,user_id,customer_id,create_time')->where('user_id=' . $user_id . ' and is_zhipai=0')->order('user_id desc ,create_time desc')->select();
        } else {
            $res = M('user_customer')->field('id,user_id,customer_id,create_time')->where('is_zhipai=0')->order('user_id desc ,create_time desc')->select();
        }

        $user_id_arr = array();
        $customer_id_arr = array();
        foreach ($res as $val) {
            $user_id_arr[] = $val['user_id'];
            $customer_id_arr[] = $val['customer_id'];
        }
        $users = array_merge($user_id_arr, $customer_id_arr);
        $users = array_unique($users);
        $users_str = implode(',', $users);
        $users_res = M()->query("select username,user_id from cms_user where user_id in({$users_str})");
        $usersArr = array();
        foreach ($users_res as $val) {
            $usersArr[$val['user_id']] = $val;
        }
        $this->assign('userArr', $usersArr);
        $this->assign('yonghu', array_unique($user_id_arr));
        $this->assign('customer', $res);
        $this->display('customer_list');
    }

}
