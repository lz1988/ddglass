<?php

// 本类由系统自动生成，仅供测试用途
class IndexAction extends CommonAction
{
    public function index()
    {//后台首首
        header("Content-Type:text/html; charset=utf-8");
        $this->display();
    }

    public function login()
    {
        //后台登陆页
        $config = M('config');
        $conf_res = $config->field('header_img')->order('id ASC')->find();
        $this->assign('header_img', $conf_res['header_img']);//登陆次数
        $this->display("Index:login");
    }

    public function left()
    {
        //左边菜单栏
        foreach ($_SESSION['ROLE'] as $arr => $key) {
            $role_idarr[] = $key['role_id'];
        }
        $role_idarr = implode(",", $role_idarr);
        $rolepriv = M("rolepriv");
        $privarr['role_id'] = array('IN', $role_idarr);
        $rolepriv_list = $rolepriv->field('menu_id')->where($privarr)->select();
        foreach ($rolepriv_list as $m3list) {
            $menu_id3[] = $m3list['menu_id'];
        }
        $admin_menu = M('admin_menu');
        if ($_SESSION['USER_ID'] == 1) {
            $menu_where1['status'] = array('eq', "1");  #一级菜单
            $menu_where1['level'] = array('eq', "1");
            $menu_where2['status'] = array('eq', "1");  #二级菜单
            $menu_where2['level'] = array('eq', "2");
            $menu_where3['status'] = array('eq', "1");  #二级菜单
            $menu_where3['level'] = array('eq', "3");
            $menu_list3 = $admin_menu->field('menu_id,menu_title,pid,func_name,iscollapse')->where($menu_where3)->order('sort ASC')->select();
            $menu_id2 = '';
            foreach ($menu_list3 as $m2list) {
                $menu_id2[] = $m2list['pid'];
            }
            $m2_pid = implode(",", $menu_id2);
            $menu_where2['menu_id'] = array('IN', $m2_pid);
            $menu_list2 = $admin_menu->field('menu_id,menu_title,pid,url,iscollapse')->where($menu_where2)->order('sort ASC')->select();
            $menu_id1 = '';
            $m2_info = '';
            foreach ($menu_list2 as $m1list) {
                $menu_id1[$m1list['pid']] = $m1list['pid'];
                $menu_1arr[$m1list['pid']][] = array($m1list['menu_title'], $m1list['url']);
            }
            $m1_pid = implode(",", $menu_id1);
            $menu_where1['menu_id'] = array('IN', $m1_pid);
            $menu_list1 = $admin_menu->field('menu_id,menu_title,url,iscollapse')->where($menu_where1)->order('sort ASC')->select();
            $menu_list = '';
            foreach ($menu_list1 as $list) {
                $menu_list[$list['menu_id']]['menu_id'] = $list['menu_id'];
                $menu_list[$list['menu_id']]['menu_title'] = $list['menu_title'];
                $menu_list[$list['menu_id']]['iscollapse'] = $list['iscollapse'];
                $menu_list[$list['menu_id']]['display'] = $list['iscollapse']==1?"display:none;":"display:block;";
                $menu_list[$list['menu_id']]['menu2'] = $menu_1arr[$list['menu_id']];
            }
            $this->assign('menu_list', $menu_list);
        } else {
            $menu_where1['status'] = array('eq', "1");  #一级菜单
            $menu_where1['level'] = array('eq', "1");
            $menu_where2['status'] = array('eq', "1");  #二级菜单
            $menu_where2['level'] = array('eq', "2");
            $menu_where3['status'] = array('eq', "1");  #二级菜单
            $menu_where3['level'] = array('eq', "3");
            $menu_where3['menu_id'] = array('IN', $menu_id3);
            $menu_list3 = $admin_menu->field('menu_id,menu_title,pid,func_name,iscollapse')->where($menu_where3)->order('sort ASC')->select();
            $menu_id2 = '';
            foreach ($menu_list3 as $m2list) {
                $menu_id2[] = $m2list['pid'];
            }
            $m2_pid = implode(",", $menu_id2);
            $menu_where2['menu_id'] = array('IN', $m2_pid);
            $menu_list2 = $admin_menu->field('menu_id,menu_title,pid,url,iscollapse')->where($menu_where2)->order('sort ASC')->select();
            $menu_id1 = '';
            $m2_info = '';
            foreach ($menu_list2 as $m1list) {
                $menu_id1[$m1list['pid']] = $m1list['pid'];
                $menu_1arr[$m1list['pid']][] = array($m1list['menu_title'], $m1list['url']);
            }
            $m1_pid = implode(",", $menu_id1);
            $menu_where1['menu_id'] = array('IN', $m1_pid);
            $menu_list1 = $admin_menu->field('menu_id,menu_title,url,iscollapse')->where($menu_where1)->order('sort ASC')->select();
            $menu_list = '';
            foreach ($menu_list1 as $list) {
                $menu_list[$list['menu_id']]['menu_id'] = $list['menu_id'];
                $menu_list[$list['menu_id']]['menu_title'] = $list['menu_title'];
                $menu_list[$list['menu_id']]['iscollapse'] = $list['iscollapse'];
                $menu_list[$list['menu_id']]['display'] = $list['iscollapse']==1?"display:none;":"display:block;";
                $menu_list[$list['menu_id']]['menu2'] = $menu_1arr[$list['menu_id']];
            }
            $this->assign('menu_list', $menu_list);
        }
        $this->assign('temp_style', session('temp_style'));
        $none = '';
        if (count($menu_list) >= 3) {
            $none = 'none;';
        } else {
            $none = 'block';
        }
        $this->assign("none", $none);
        $this->display();
    }

    public function top()
    {
        //顶部栏
        $this->assign('user_name', "欢迎您：" . $_SESSION['USER_NAME']);
        $this->assign('temp_style', session('temp_style'));
        $this->display();
    }

    public function home()
    {
        //test
        $this->assign('user_name', "欢迎您：" . $_SESSION['USER_NAME']);
        $role = M("role");
        $where['is_del'] = array('eq', '0');
        foreach ($_SESSION['ROLE'] as $arr => $key) {
            $role_id = $key['role_id'];
            /*
             * 魏玉煌加
             */
          
          if($role_id==11){
          	//var_dump($_SESSION['USER_NAME']);
          	$_SESSION['JACK']=$_SESSION['USER_NAME'];
          }
            /*
             * 结束
             */
            $where['role_id'] = array('eq', $role_id);
            $name = $role->field('role_name')->where($where)->find();
            if (!empty($name['role_name'])) {
                $role_list[] = $name['role_name'];
            }
        }
        $str_role = implode(',', $role_list);
        $this->assign('role', $str_role);//当前用户的角色

        $logadmin = M("logadmin");
        $where_log['admin_id'] = array('eq', $_SESSION['USER_ID']);
        $where_log['action'] = array('eq', 'login');
        $count = $logadmin->where($where_log)->count();    //计算总数

        $log_max_id = $logadmin->where($where_log)->max('log_id');
        $where_log['log_id'] = array('lt', $log_max_id);
        $log_login = $logadmin->where($where_log)->order('log_id DESC')->limit(1)->find();
        $this->assign('ip', $log_login['ip']);//最后一次登陆ip
        $this->assign('login_time', $log_login['action_time']);//最后一次登陆时间
        $this->assign('count', $count);//登陆次数

        $config = M('config');
        $conf_res = $config->field('site_title')->order('id ASC')->find();
        $this->assign('site_title', $conf_res['site_title']);//登陆次数
        $this->display();
    }


    //清除缓存
    public function clearcache()
    {
        $url = './Admin/Runtime';
        $urlhome = './Home/Runtime';
        del_run($url);
        del_run($urlhome);
        echo '………………………………………………………………………………………………………………………………………………缓存已经清除完了';
        exit;
    }


    //清除游戏官网缓存
    public function clearorgcache()
    {
        if ($this->isPost()) {
            $game_code = $_REQUEST['game_code'];
            if ($game_code != '0') {
                //$str = "rm -rf Org/".$game_code."/Runtime/*";
                //$rmexec = exec("rm -rf / varr/www/jleg3s/oak1758/Org/$game_code/Runtime/*",$out,$status);
                /*
            $url='./Org/'.$game_code.'/Runtime/';
                @mkdir('Runtime',0777,true);
                //读出文件夹名称
                $file_arr=array('Cache');//,'Logs','Temp','Data'
                foreach ($file_arr as $zval) {
              	  $handlefile=$url.$zval;
              	  $handle = opendir($handlefile);
                  while (false !== ($file = readdir($handle))){//遍历目录
        			 if ($file != "." && $file != "..") {//去掉..
        			    $filename= $handlefile.'/'.$file;//生曾数组
        			    unlink($filename);
        			 }
        	      }
               }
        	   $del_flie=unlink($url.'~runtime.php');

        	   if($del_flie){
        	       $this->success('缓存清除成功！','__APP__/Index/home/');exit;
        	   }else{
        	       $this->error("缓存清除失败!",'__APP__/Index/home/');exit;
        	   }*/
            } else {
                $this->error("请选择游戏!", '__APP__/Index/clearorgcache/');
                exit;
            }
        } else {
            $game_list = M('game')->field('game_id,code,game_name')->select();
            $this->assign('game_list', $game_list);
            $this->display('Index:clearorgcache');
        }
    }


    /**
     * 选择模板
     * **/
    public function select_style()
    {
        $temp = $_GET['_URL_'][2];
        $admin = M('admin');
        $data['temp_style'] = $temp;
        $wehre['admin_id'] = array('eq', session('USER_ID'));
        $con_res = $admin->where($wehre)->save($data);
        session('temp_style', $temp);
        echo "<script>if (top.location !== self.location){top.location='" . 'http://' . $_SERVER[SERVER_NAME] . ':' . $_SERVER[SERVER_PORT] . $_SERVER[SCRIPT_NAME] . '/Common/login' . "'; }else{document.location='" . 'http://' . $_SERVER[SERVER_NAME] . ':' . $_SERVER[SERVER_PORT] . $_SERVER[SCRIPT_NAME] . '/Common/login' . "';}</script>";
    }

}