<?php

class RoleAction extends CommonAction
{
    public function role_list()
    {//角色列表
        $role = M("role");
        import('@.ORG.Page');
        $arr = "";
        if ($_GET['findsub']) {
            $role_name = trim($_GET['role_name']);

            if (!empty($role_name)) {
                $arr['role_name'] = array('LIKE', "%" . $role_name . "%");
                $this->assign("role_name", $_GET['role_name']);
            }
            if ($_GET['game_id'] != 0) {
                $arr['cms_orgtype.game_id'] = array('eq', $_GET['game_id']);
                $this->assign('game_id', $_GET['game_id']);
            }
        }
        $arr['is_del'] = array('eq', '0');
        $count = $role->where($arr)->count();    //计算总数 
        $p = new Page($count, 25);
        $role_list = $role->where($arr)->order('role_id DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
        $page = $p->show();
        $this->assign("page", $page);
        $this->assign('role_list', $role_list);

        $this->display("Manage:role_list");
    }

    public function role_add()
    {//添加角色
        if ($_POST) {
            $roleup = D("role");
            if ($vo = $roleup->create()) {
                $list = $roleup->add();
                if ($list !== false) {
                    $this->redirect("__APP__/Role/role_list/");
                } else {
                    $this->error("数据写入错误!", "__APP__/Role/role_list/");
                }
            } else {
                $this->error($roleup->getError());
            }
            exit;
        }

        $this->assign('typeName', "添加新角色");
        $this->assign('typeUrl', "__APP__/Role/role_add/");
        $this->display("Manage:role_add");
    }

    public function role_edit()
    {//角色编辑
        if ($_POST) {
            $roleup = D("role");
            if ($vo = $roleup->create()) {
                $list = $roleup->save();
                if ($list !== false) {
                    $this->redirect("__APP__/Role/role_list/");
                } else {
                    $this->error("没有更新任何数据!", "__APP__/Role/role_list/");
                }
            } else {
                $this->error($roleup->getError());
            }
            exit;
        }

        $role = M("role");
        $role_id = $_GET["_URL_"][2];
        $condition['role_id'] = $role_id; //使用查询条件
        $infoAll = $role->where($condition)->select();
        $this->assign('arr', $infoAll);

        $this->assign('typeName', "角色编辑");
        $this->assign('typeUrl', "__APP__/Role/role_edit/");
        $this->display("Manage:role_add");
    }

    public function role_del()
    {//删除角色
        if ($_GET["_URL_"][2]) {
            $role_id = $_GET["_URL_"][2];
        } else {
            $role_id = $_POST['role_id'];
        }
        if (!empty($role_id)) {
            $roleadmin = M("roleadmin");
            if (is_array($role_id)) {
                $whererole_id = implode(",", $role_id);
                $rawhere['role_id'] = array('in', $whererole_id);
                $roleadmin_info = $roleadmin->field('role_id')->where($rawhere)->find();

                if (empty($roleadmin_info)) {
                    $result = $this->add_recycle('role', 'role_id', $role_id);
                } else {
                    $this->error('您所选的角色有成员存在，不能删除！');
                }
            } else {
                $roleadmin_info = $roleadmin->field('role_id')->where("role_id=$role_id")->limit(1)->find();
                if (empty($roleadmin_info)) {
                    $result = $this->add_recycle('role', 'role_id', array($role_id));
                } else {
                    $this->error('您所选的角色有成员存在，不能删除！');
                }
            }
            if (false !== $result) {
                $this->success('删除成功！');
            } else {
                $this->error('删除出错！');
            }
        } else {
            $this->error('删除项不存在！');
        }
        exit;
    }

    public function member_manage()
    {//成员管理
        if ($_POST) {
            $roleadminup = M("roleadmin");
            $role_id = $_POST['role_id'];
            $admin_id = $_POST['admin_id'];
            if ($vo = $roleadminup->create()) {
                $log_arr = "给角色ID为:$role_id 组分配了管理员ID为：【";
                for ($i = 0; $i < count($admin_id); $i++) {
                    $arr['role_id'] = $role_id;
                    $arr['admin_id'] = $admin_id[$i];
                    $log_arr .= $arr['admin_id'] . ",";
                    $ra_id = $roleadminup->field('ra_id')->where($arr)->select();
                    if (empty($ra_id)) {
                        $list = $roleadminup->add($arr);
                    }
                }
                $log_arr .= "】成员";
                if (!empty($admin_id)) {
                    $del_id = implode(",", $admin_id);
                    $del['admin_id'] = array('NOT IN', $del_id);
                    $del['role_id'] = array('eq', $role_id);
                    $result = $roleadminup->where($del)->delete();
                } else {
                    $result = $roleadminup->where("role_id=$role_id")->delete();
                }
                if ($list !== false) {
                    $this->create_log('edit', "成员管理", $log_arr);
                    $this->redirect("__APP__/Role/role_list/");
                } else {
                    $this->error("数据写入错误!", "__APP__/Role/role_list/");
                }
            } else {
                $this->error($roleadminup->getError());
            }
            exit;
        }

        $role_id = $_GET["_URL_"][2];
        $role_name = $_GET["_URL_"][3];
        $admin = M("admin");
        $adminarr['cms_admin.status'] = array('eq', '1');
        $adminarr['cms_admin.is_del'] = array('eq', '0');

        $adminarr['cms_admin.admin_id'] = array('neq', 1);
        if ($role_id == 2) {
            //$adminarr['cms_admin.admin_type']=array('eq','member');//站长
        } else {
            $adminarr['cms_admin.admin_type'] = array('eq', 'admin');//管理员
        }
        $admin_list = $admin->where($adminarr)->select();

        $roleadmin = M("roleadmin");
        $roleadmin_list = $roleadmin->where("role_id=$role_id")->select();

        $this->assign('roleadmin_list', $roleadmin_list);
        $this->assign('admin_list', $admin_list);
        $this->assign('role_id', $role_id);
        $this->assign('role_name', $role_name);

        $this->display("Manage:member_manage");
    }

    public function rolepriv_allot()
    {//职权分配
        if ($_POST) {
            $roleprivup = M("rolepriv");
            $role_id = $_POST['role_id'];
            $modulemethods = $_POST['modulemethods'];
            //print_r($modulemethods);exit;
            $conment = C('MOD_NAME_ARR');
            $MOD_NAME_ACTION = C('MOD_NAME_ACTION');
            $log_arr = "给角色ID为:$role_id 组分配了：【";
            if ($vo = $roleprivup->create()) {
                for ($i = 0; $i < count($modulemethods); $i++) {
                    $arr['role_id'] = $role_id;
                    $arr['menu_id'] = $modulemethods[$i];
                    $act = explode("_", $arr['methods']);
                    if (!empty($act[1])) {
                        $log_arr .= $modulemethods[$i] . ",";
                    }

                    $rp_id = $roleprivup->field('rp_id')->where($arr)->select();
                    if (empty($rp_id)) {
                        $list = $roleprivup->add($arr);
                        $rp_idarr[] = $list;
                    } else {
                        $rp_idarr[] = $rp_id[0]['rp_id'];
                    }
                }
                $log_arr .= "】权限";

                if (!empty($modulemethods)) {
                    $del_id = implode(",", $rp_idarr);
                    for ($j = 0; $j < count($modulemethods); $j++) {
                        $del['rp_id'] = array('NOT IN', $del_id);
                        $del['role_id'] = array('eq', $role_id);
                        $result = $roleprivup->where($del)->delete();
                    }
                } else {
                    $result = $roleprivup->where("role_id=$role_id")->delete();
                }
                if ($list !== false) {
                    $this->create_log('edit', "职权分配", $log_arr);
                    $this->redirect("__APP__/Role/role_list/");
                } else {
                    $this->error("数据写入错误!", "__APP__/Role/role_list/");
                }
            } else {
                $this->error($roleprivup->getError());
            }
            exit;
        }

        $role_id = $_GET["_URL_"][2];
        $role_name = $_GET["_URL_"][3];
//    	$MODULES_MENU_ALL=C('MODULES_MENU_ALL');
//     	$MOD_NAME_ARR=C('MOD_NAME_ARR');  
//     	$this->assign('hello',$MODULES_MENU_ALL);
//     	$this->assign('MOD_NAME_ARR',$MOD_NAME_ARR);
        $admin_menu = M('admin_menu');
        $menu_where['status'] = array('eq', "1");  #一级菜单
        $menu_where['level'] = array('eq', "1");
        $menu_list = $admin_menu->field('menu_id,menu_title')->where($menu_where)->order('sort ASC')->select();
        $this->assign('hello', $menu_list);

        $menu_where2['status'] = array('eq', "1");  #二级菜单
        $menu_where2['level'] = array('eq', "2");
        $menu_list2 = $admin_menu->field('menu_id,menu_title,pid,func_name')->where($menu_where2)->order('sort ASC')->select();

        $this->assign('MOD_NAME_ARR', $menu_list2);

        $menu_where3['status'] = array('eq', "1");  #二级菜单
        $menu_where3['level'] = array('eq', "3");
        $menu_list3 = $admin_menu->field('menu_id,menu_title,pid,func_name')->where($menu_where3)->order('sort ASC')->select();
        $this->assign('menu_list3', $menu_list3);
        echo $admin_menu->getLastSql();


        $rolepriv = M("rolepriv");
        $rolepriv_list = $rolepriv->where("role_id=$role_id")->select();

        $this->assign('rolepriv_list', $rolepriv_list);
        $this->assign('role_name', $role_name);
        //print_r($rolepriv_list);exit;
        $this->assign('role_id', $role_id);
        $this->display("Manage:rolepriv_allot");
    }


}