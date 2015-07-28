<?php

class CustomerAction extends PublicAction
{
    public function index()
    {
        $code = $this->_get('code');
        check_openid($code);
        $openid = session('openid');
        if ($openid == null) {
            $openid = 0;
        }

        $reselect = $_REQUEST['reselect'];
        if ($reselect == null) {
            $reselect = 0;
        }

        $mhistory = M('Historyhouse');
        $historydata = $mhistory->where(" openid = '{$openid}' ")->order('id desc ')->select();

        if (!is_array($historydata) || count($historydata) <= 0) {
            $reselect = 1;
        }


        if ($reselect == 1)
        {
            //log::write("<br/>关注者openid" . session('openid'), "");
            $sheng = M('Area');
            $shenglist = $sheng->where(" ifnull(isdelete,'0') = '0' ")->Distinct(true)->field('sheng')->select();
            $this->assign('shenglist', $shenglist);
            $shi = M('Area');
            $shilist = $shi->where(" ifnull(isdelete,'0') = '0' and sheng = '湖南' ")->Distinct(true)->field('shi')->select();
            $this->assign('shilist', $shilist);
            $qu = M('Area');
            $qulist = $qu->where(" ifnull(isdelete,'0') = '0' and sheng = '湖南' and shi = '长沙' ")->Distinct(true)->field(array('name' => 'qu', 'id'))->select();
            $this->assign('qulist', $qulist);
            //log::write("<br/>" . dump($shenglist, false) . $sheng->getLastSql() . dump($shilist, false) . $shi->getLastSql() . dump($qulist, false) . $qu->getLastSql(), "");

            $m = M("customer");
            $data = $m->where('id = '.$_GET['cid'].' and isdelete=0')->field('id,xiaoqu')->find();
            //echo $m->getLastSql();
            $this->assign('data',$data);


            //默认小区
            $default_data = $m->where('isdefault = 1 and isdelete=0')->field('*')->find();

            //热点样板房推荐
            $tuijian_data = $m->where('isdelete = 0 and tuijian_house = 1')->order('tuijian_house_order')->limit(5)->select();
            foreach($tuijian_data as $k=>$v){
                $tuijian_data[$k]['newname'] = $v['xiaoqu'].($v['qi'] != ""?$v['qi'].'期':'').$v['dong']."栋".$v['lou']."单元".$v['fangjian']."房间";
            }
            //echo $flow->getLastSql();
            $this->assign('tuijian_data',$tuijian_data);

            if ($default_data) {
                $this->get_city($default_data['distinct_id']);

                //设置小区列表
                $xiaoqu_data = $m->group('xiaoqu')->where('province_id = '.$default_data['province_id'].' and city_id ='.$default_data['city_id'].' and distinct_id ='.$default_data['distinct_id'])->order('recommended_house desc')->select();

                if (!empty($default_data['qi']))
                {
                    $qi = 'and qi = "'.$default_data['qi'].'"';
                }

                $qi_data = $m->group('qi')->where('province_id = '.$default_data['province_id'].' and city_id ='.$default_data['city_id'].' and distinct_id ='.$default_data['distinct_id'].' and xiaoqu ="'.$default_data['xiaoqu'].'" '.$qi)->order('recommended_house desc')->select();

                //echo $m->getLastSql();
                //var_dump($qi_data);

                $dong_data = $m->group('dong')->where('province_id = '.$default_data['province_id'].' and city_id ='.$default_data['city_id'].' and distinct_id ='.$default_data['distinct_id'].' and xiaoqu ="'.$default_data['xiaoqu'].'" '.$qi)->order('recommended_house desc')->select();
                //echo $m->getLastSql();

                $lou_data = $m->group('lou')->where('province_id = '.$default_data['province_id'].' and city_id ='.$default_data['city_id'].' and distinct_id ='.$default_data['distinct_id'].' and xiaoqu ="'.$default_data['xiaoqu'].'"  and dong="'.$default_data['dong'].'" '.$qi)->order('recommended_house desc')->select();
                //echo $m->getLastSql();

                $fangjian_data = $m->group('fangjian')->where('province_id = '.$default_data['province_id'].' and city_id ='.$default_data['city_id'].' and distinct_id ='.$default_data['distinct_id'].' and xiaoqu ="'.$default_data['xiaoqu'].'"  and dong="'.$default_data['dong'].'" and lou="'.$default_data['lou'].'" '.$qi)->order('recommended_house desc')->select();


                $this->assign('xiaoqu_data',$xiaoqu_data);
                $this->assign('qi_data',$qi_data);
                $this->assign('dong_data',$dong_data);
                $this->assign('lou_data',$lou_data);
                $this->assign('fangjian_data',$fangjian_data);

                $this->assign('default_data',$default_data);
            }else{
                $this->get_city(0);
            }

            /*echo '<pre>';
            print_r($da);*/
            //$this->get_city(0);
            /*$this->assign('province_name', $province_name);
            $this->assign('city_name', $city_name);
            $this->assign('distinct_name', $distinct_name);*/
            /*echo '<pre>';
            print_r($province_name);*/

            $this->display("customer_index");
        } else {
            $this->redirect("/customer/housecenter/id/" . $historydata[0]['houseid']);
            //die('222222222');
        }
    }

    public function getshi()
    {
        $shi = M('Area');
        $shilist = $shi->where(" ifnull(isdelete,'0') = '0' and sheng = '{$_REQUEST['sheng']}' ")->Distinct(true)->field('shi')->select();
        $this->ajaxReturn($shilist, "", 0);
    }

    public function getqu()
    {
        $qu = M('Area');
        $qulist = $qu->where(" ifnull(isdelete,'0') = '0' and sheng = '{$_REQUEST['sheng']}' and shi = '{$_REQUEST['shi']}' ")->Distinct(true)->field(array('name' => 'qu', 'id'))->select();
        $this->ajaxReturn($qulist, "", 0);
    }

    public function getshangquan()
    {
        $qu = M('Ring');
        $qulist = $qu->where(" ifnull(isdelete,'0') = '0' and aid = '{$_REQUEST['qu']}' ")->select();
        $this->ajaxReturn($qulist, "", 0);
    }

    public function getxiaoqu()
    {
       // $where[] = " ifnull(isdelete,'0') = '0' ";
        /*if (!empty($_REQUEST['qu'])) {
            $where[] = "  aid = '{$_REQUEST['qu']}'  ";
        }*/
       /* if (!empty($_REQUEST['shangquan'])) {
            $where[] = " rid = '{$_REQUEST['shangquan']}'";
        }
        if (count($where) > 1) {
            $where = join(" and ", $where);
        } else {
            $where = $where[0];
        }*/

       /* $qu = M('Community');
        $qulist = $qu->where($where)->select();*/
        $m = M('Customer');
        $qilist = $m->where(" isdelete = '0' and distinct_id = '{$_REQUEST['city_id']}' ")->group('xiaoqu')->field(array('xiaoqu' => 'name','recommended_house'=>'recommended_house'))->order('recommended_house desc')->select();
        
        foreach($qilist as $k=>$v){
            if ($v['recommended_house'] == 1)
            {
                $qilist[$k]['name'] = '[热]'.$v['name'];
            }
        }

        $this->ajaxReturn($qilist, "", 0);
    }

    public function getqi()
    {
        $m = M('Customer');
        if (strpos($_REQUEST['xiaoqu'],'[热]')!== false){
            $_REQUEST['xiaoqu'] = str_replace('[热]','',$_REQUEST['xiaoqu']);
        }
        $qilist = $m->where(" isdelete = '0' and xiaoqu = '{$_REQUEST['xiaoqu']}' ")->Distinct(true)->field(array('qi' => 'name'))->select();
        //echo $m->getLastSql();
        $this->ajaxReturn($qilist, "", 0);
    }

    public function getdong()
    {
        $m = M('Customer');
        if (strpos($_REQUEST['xiaoqu'],'[热]')!== false){
            $_REQUEST['xiaoqu'] = str_replace('[热]','',$_REQUEST['xiaoqu']);
        }
        $donglist = $m->where("ifnull(isdelete,'0') = '0' and xiaoqu = '{$_REQUEST['xiaoqu']}'  and qi = '{$_REQUEST['qi']}'   ")->Distinct(true)->field(array('dong' => 'name'))->select();
        $this->ajaxReturn($donglist, "", 0);
    }

    public function getdanyuan()
    {
        $m = M('Customer');
        if (strpos($_REQUEST['xiaoqu'],'[热]')!== false){
            $_REQUEST['xiaoqu'] = str_replace('[热]','',$_REQUEST['xiaoqu']);
        }
        $danyuan = $m->where("ifnull(isdelete,'0') = '0' and xiaoqu = '{$_REQUEST['xiaoqu']}'  and qi = '{$_REQUEST['qi']}'  and dong = '{$_REQUEST['dong']}'   ")->Distinct(true)->field(array('lou' => 'name'))->select();
        $this->ajaxReturn($danyuan, "", 0);
    }

    public function getfangjian()
    {
        $m = M('Customer');
        if (strpos($_REQUEST['xiaoqu'],'[热]')!== false){
            $_REQUEST['xiaoqu'] = str_replace('[热]','',$_REQUEST['xiaoqu']);
        }
        $fangjian = $m->where("ifnull(isdelete,'0') = '0' and xiaoqu = '{$_REQUEST['xiaoqu']}'  and qi = '{$_REQUEST['qi']}'  and dong = '{$_REQUEST['dong']}'  and lou = '{$_REQUEST['danyuan']}'  ")->Distinct(true)->field(array('fangjian' => 'name'))->select();
        $this->ajaxReturn($fangjian, "", 0);
    }

    public function viewhouse()
    {

        $m = M('Customer');
        if (strpos($_REQUEST['xiaoqu'],'[热]')!== false){
            $_REQUEST['xiaoqu'] = str_replace('[热]','',$_REQUEST['xiaoqu']);
        }
        $customer = $m->where("ifnull(isdelete,'0') = '0' and xiaoqu = '{$_REQUEST['xiaoqu']}'  and qi = '{$_REQUEST['qi']}'  and dong = '{$_REQUEST['dong']}'  and lou = '{$_REQUEST['danyuan']}'  and fangjian = '{$_REQUEST['fangjian']}'  ")->find();
        /*echo '<pre>';var_dump($customer);
        die();*/
      /*  echo $m->getLastSql();
        echo '<pre>';print_r($customer);
        die();*/
        //log::write("<br/>" . dump($_REQUEST, false) . dump($customer, false) . $m->getLastSql(), "");
        if (!$customer)
            $this->redirect('/customer/index?reselect=1');
        else
            $this->redirect("/customer/housecenter/id/" . $customer['id']);
        //log::write("<br/>/index.php/customer/housecenter/?id=" . $customer['id']);
        //log::write("<br/>__ROOT__");
    }

    public function housecenter()
    {
        /*$openid = session('openid');
        $houseid = $_REQUEST['id'];
        //log::write("<br/>" . dump($_REQUEST, false), "");
        $mfang = M('Customer');
        $dfang = $mfang->where(" ifnull(isdelete,'0') = '0' and id = '{$houseid}' ")->find();
        $this->assign('fangjian', $dfang);
        $mflow = M('Flow');
        $dflow = $mflow->where("  ifnull(isdelete,'0') = '0' and cid = '{$dfang['id']}' ")->find();
        if ($dflow == null || $dflow["id"] == null) {
            $df = array(
                "cid" => $dfang['id'],
                "title" => $dfang['xingming'] . $dfang['fangjian'],
                "content" => "",
                "createuser" => $_SESSION['home']['username'],
                "cname" => $dfang['xingming'],
                "address" => $dfang['xiaoqu'] . $dfang['qi'] . $dfang['dong'] . $dfang['lou'] . $dfang['fangjian'],
                "cnid" => 0,
                "cnadmin" => "",
                "isdelete" => 0
            );
            if ($insertedid = $mflow->add($df)) {
                M("Updatelog")->add(array(
                    "username" => $_SESSION['home']['username'],
                    "tablename" => $mflow->getModelName(),
                    "message" => "添加了一条记录",
                    "recordid" => $insertedid
                ));
            }
            $dflow = $mflow->where("  ifnull(isdelete,'0') = '0' and cid = '{$dfang['id']}' ")->find();
        }
        $this->assign('flow', $dflow);

        $mflownodes = M('Flownode');
        //pid asc,
        $dflownodes = $mflownodes->where("  ifnull( isdelete , '0' ) = '0' and fid = '{$dflow['id']}' ")->order("ordernumber asc")->select();
        if (!is_array($dflownodes) || count($dflownodes) <= 0)
        {
            $mflownodetemplate = M('Flownodetemplate');
            //and pid != 0
            //pid asc,
            $dflownodetemplate = $mflownodetemplate->where("  ifnull(isdelete,'0') = '0'  ")->order("ordernumber asc")->select();
            foreach ($dflownodetemplate as $k => $v) //循环excel表
            {
                $dfn["fid"] = $dflow['id'];
                $dfn["title"] = $v["title"];
                $dfn["content"] = $v["description"];
                $dfn["admin"] = "";
                $dfn["begintime"] = "";
                $dfn["endtime"] = "";
                $dfn["starttime"] = "";
                $dfn["closetime"] = "";
                $dfn["checkman"] = "";
                $dfn["gongqi"] = $v["gongqi"];
                $dfn["comments"] = "";
                $dfn["shijigongqi"] = 0;
                $dfn["isdelete"] = 0;
                $dfn["pid"] = $v["pid"];
                $dfn["ordernumber"] = $v["ordernumber"];
                $dfn["iconurl"] = $v["iconurl"];
                $dfn["status"] = 0;
                $dfn["templateid"] = $v["id"];
                $dfn["cid"] = $dflow['cid'];
                if ($insertedid = $mflownodes->add($dfn)) {
                    M("Updatelog")->add(array(
                        "username" => $_SESSION['home']['username'],
                        "tablename" => $mflownodes->getModelName(),
                        "message" => "添加了一条记录",
                        "recordid" => $insertedid
                    ));
                }
            }
            $dflownodes = $mflownodes->where("  ifnull(isdelete,'0') = '0' and fid = '{$dflow['id']}' ")->order(" ordernumber asc ")->select();
        }
        if ($openid == null) {
            $openid = 0;
        }
        //id, openid, houseid, ordernumber, favorite, authorited, lastvisitedtime, isdelete
        $mhistory = M('Historyhouse');
        $mhistory->where(" openid = '{$openid}' and houseid = '{$houseid}' ")->delete();
        $mhistory->add(array(
            "openid" => $openid,
            "houseid" => $houseid,
            "ordernumber" => '0',
            "favorite" => '0',
            "authorited" => '0',
            "isdelete" => '0',
            'address' => $dfang['freeaddress']
        ));
        log::write(dump($dfang, false) . $dfang['freeaddress'] . $mhistory->getLastSql(), "");
        die();*/
        /*   $historydata = $mhistory->where(" openid = '{$openid}' and houseid = '{$houseid}' ")->select();
           if (!is_array($historydata) || count($historydata) <= 0) {
               $mhistory->add(array(
                   "openid" => $openid,
                   "houseid" => $houseid,
                   "ordernumber" => '0',
                   "favorite" => '0',
                   "authorited" => '0',
                   "isdelete" => '0'
               ));
           } else {
               $historydata[0]['lastvisitedtime'] = strtotime(date('Y-m-d H:i:s', time()));
               $mhistory->where(" id = '{$historydata[0]['id']}' ")->save($historydata[0]);
               log::write(dump($historydata, false) . $mhistory->getLastSql() . strtotime(date('Y-m-d H:i:s', time())), "");
           }*/

        /**
         * @title 前台房间流程
         * @author lizhi
         * @create on 2015-03-26
         */
        $houseid = $_REQUEST['id'];
        $flow = M("flow");
        $datalist = $flow->field('cms_flownodetemplate.*,cms_flow.cid,cms_flow.node_id')
            ->join("left join cms_flownodetemplate on cms_flow.template_id = cms_flownodetemplate.tid")
            ->where('cid = '.$houseid)->select();
        echo $flow->getLastSql();

        $m = M("customer");
        $dfang = $m->where('id = '.$houseid)->field('*')->find();

        $house_title = $dfang['xiaoqu'].($dfang['qi'] != ""?$dfang['qi'].'期':'').$dfang['dong']."栋".$dfang['lou']."单元".$dfang['fangjian'];
        //echo $house_title;
        $this->assign('house_title',$house_title);
        $this->assign('cid',$houseid);

        //记录浏览记录
        $openid = session('openid');
        if ($openid)
        {
            $mhistory = M('Historyhouse');
            $mhistory->where(" openid = '{$openid}' and houseid = '{$houseid}' ")->delete();
            $mhistory->add(array(
                "openid" => $openid,
                "houseid" => $houseid,
                "ordernumber" => '0',
                "favorite" => '0',
                "authorited" => '0',
                "isdelete" => '0',
                'address' => $dfang['freeaddress']
            ));
            /* echo $mhistory->getLastSql();
             DIE();*/
            log::write(dump($dfang, false) . $dfang['freeaddress'] . $mhistory->getLastSql(), "");
        }

        $m = M('Attachments');
        $comment = M("comment");

        /*echo '<pre>';
        print_r($datalist);*/
        foreach($datalist as $key=>&$val)
        {

            $data = $m->field('*')->where("cid = ".$val['cid']." and fid=".$val['id'])->order('id ')->group('date_format(fstcreate,"%y-%m-%d")')->select();

            //$data_detail = $m->field('id,title,images,fstcreate')->where("cid = ".$val['cid']." and fid=".$val['id']." and fstcreate like '%".$data['fstcreate']."%'")->order('id desc')->select();
            //echo $m->getLastSql()."<br/>";
            //$comdata = $comment->field('content')->where('wid ='.$data_detail[0]['id'])->select();

            //if ($data) {
                $datalist[$key]['detail'] = $data;

                foreach($data as $kk=>&$vv){
                    if($vv['fid'])
                    {
                        $data_detail = $m->field('*')
                            ->where("cid = ".$vv['cid']." and fid=".$vv['fid']." and fstcreate like '%".date('Y-m-d',strtotime($vv['fstcreate']))."%'")
                            ->order('id desc')->select();

                        //echo $m->getLastSql()."<br/>";
                        $datalist[$key]['detail'][$kk]['detail_info'] = $data_detail;

                        foreach($data_detail as $kkk=>&$vvv){
                            $comdata = $comment->join('join cms_user on cms_user.user_id=cms_comment.uid')
                                ->field('cms_comment.id,username,content')
                                ->where('wid ='.$vvv['id'])
                                ->order('cms_comment.id asc')
                                ->select();
                            //echo $m->getLastSql()."<br/>";
                            if ($comdata){
                                $datalist[$key]['detail'][$kk]['detail_info'][$kkk]['comment_list'] = $comdata;
                                foreach($comdata as $keys=>&$vals){
                                    $reply_data = $comment->field('reply,username')
                                        ->join('join cms_user on cms_user.user_id=cms_comment.uid')
                                        ->where('wid = '.$vals['id'])->find();
                                    //echo $comment->getLastSql()."<BR/>";
                                    if ($reply_data)
                                    {
                                        $datalist[$key]['detail'][$kk]['detail_info'][$kkk]['comment_list'][$keys]['reply_list'] = $reply_data;
                                    }

                                }
                            }
                        }
                    }
                }
                //$datalist[$key]['detail'][$key]['detail_info'] = $data_detail;
                /*foreach($data_detail as $k=>$v){
                    $comdata = $comment->join('join cms_user on cms_user.user_id=cms_comment.uid')->field('username,content')->where('wid ='.$v['id'])->order('cms_comment.id desc')->select();
                    //echo $comment->getLastSql().'<br/>';
                    if ($comdata) {
                        $datalist[$key]['detail'][$key]['detail_info'][$k]['comment_list'] = $comdata;
                    }
                }*/
            //}
        }
/*
        echo '<pre>';
        print_r($datalist);*/
        $this->assign('flownodes',$datalist);

        $this->display("customer_simplecenter");


    }

    /**
     * @title 新增评论
     * @author lizhi
     * @create on 2015-03-27
     */
    public function addcomment()
    {

        $pid        = $_REQUEST['pid'];
        $content    = $_REQUEST['content'];
        $m = M("comment");
        $add['uid'] = $_SESSION['user_id'];
        $add['content'] = $content;
        $add['wid']     = $pid;
        $res = $m->add($add);

        $user = M("user");
        $userinfo = $user->where('user_id = '.$_SESSION['user_id'])->find();
        $data['username']   = $userinfo['username'];
        $data['content']    = $content;
        if ($res !== false)
        {
            $this->ajaxReturn($data,'提交成功',1);
        }
        else
        {
            $this->ajaxReturn('','提交失败！',0);
        }
    }

    /**
     * @title 获取浏览的记录
     * @author lizhi
     * 2create on 2015-03-28
     */
    public function latest()
    {
        $openid = session('openid');
        if ($openid == null) {
            $openid = 0;
        }
        $mhistory = M('Historyhouse');
        $historydata = $mhistory->join("left join cms_customer on cms_historyhouse.houseid = cms_customer.id")->where(" openid = '{$openid}' ")->select();
        //echo $mhistory->getLastSql();
        foreach($historydata as $k=>$v){
            $city_name = get_city_pid($v['city_id']);
            $historydata[$k]['newaddress'] = $city_name['cname'].$v['xiaoqu'].($v['qi'] != ""?$v['qi'].'期':'').$v['dong']."栋".$v['lou']."单元".$v['fangjian']."房间";
        }
        $this->assign("historydata", $historydata);
        log::write($mhistory->getLastSql());
        $this->display("customer_latest");
    }

    /**
     * @title 预订设计师
     * @author lizhi
     * @create on 2015-03-29
     */
    public function orderdesigner()
    {
        $cid = $_REQUEST["cid"];
        $openid = session('openid');
        $this->assign("openid", $openid);
        $this->assign("cid", $cid);

        $data = D('Customer')->where("id = {$cid} ")->find();
        $this->assign("house", $data);

        $user_arr = M('user')->order('user_id DESC')->select();
        $this->assign('users', $user_arr);

        log::write(dump($user_arr, false) . dump($data, false), "");
        $this->display();
    }

    public function sendorder()
    {
        log::write("验证码：" . $_REQUEST['telcode'], "");
        $telcode = $_REQUEST['telcode'];
        //$code = session('code');
        $code = $_REQUEST['code'];

        //var_dump(array(md5($telcode),$code));

        if (md5($telcode) != $code){
            $this->error('验证码错误');
        }
         /*print_r($_SESSION['code']);
         die();*/
        /*$verify = md5(trim($_REQUEST['telcode']));
        if ($_SESSION['verify'] != $verify) {
            $this->error("验证码错误!");
        }*/

        $subscribe = M('subscribe');
        $add_data = $subscribe->create();
        /*$add_data["user_id"] = $_REQUEST['user_id'];
        $add_data["username"] = $_REQUEST['username'];*/
        $add_data["user_id"]    = $_SESSION['user_id'];
        $add_data["username"]   = $_SESSION['username'];
        $add_data["address"]    = $_REQUEST['address'];
        $add_data["openid"]     = $_REQUEST['openid'];
        $add_data["cid"]        = $_REQUEST['cid'];
        $add_data["tel"]        = $_REQUEST['tel'];
        $add_data["create_time"] = time();
        $add_data["sub_time"] = time();
        $res = $subscribe->add($add_data);
        log::write(dump($add_data, false), "");
        $this->redirect("/customer/housecenter/id/" . $add_data['cid']);
    }


    /**
     * @title 显示流程对应的图片和文本
     * @author lizhi
     * @create on 2015-03-26
     */
    public function flownode()
    {
        $cid = $_REQUEST["cid"];
        $fid = $_REQUEST["fid"];
        $fstcreate = date('Y-m-d',$_REQUEST['fsttitme']);

        $arr = array("cid" => $cid, "fid" => $fid);
        $m = M('Attachments');

        $where = '';
        if (!empty($_REQUEST['fsttitme']))
        {
            $where .= " and fstcreate like '%".$fstcreate."%'";
        }

        $data = $m->where(" cid = {$cid} and fid = {$fid}  {$where}")->select();
        echo $m->getLastSql();
        //log::write(dump($data, false) . $m->getLastSql(), "");
        $this->assign("data", $data);
        $this->assign("arr", $arr);
        $this->display("customer_flownode");
    }

    public function addfile()
    {
        $cid = $_REQUEST["cid"];
        $fid = $_REQUEST["fid"];
        $fnid = $_REQUEST["fnid"];
        $m = M('Flownode');
        $data = $m->where(" cid = {$cid} and fid = {$fid} and id = {$fnid} ")->find();
        $this->assign("data", $data);

        $mdiary = M('Diary');
        $ddiary = $mdiary->where(" customerid = {$cid} and fid = {$fid} and id = {$fnid} ")->order("ctime desc ")->select();
        $this->assign("diary", $ddiary);

        $mdiarycontent = M('Diary_content');
        $ddiarycontent = $mdiarycontent->where(" customerid = {$cid} and fid = {$fid} and id = {$fnid} ")->order("ctime desc ")->select();
        $this->assign("diarycontent", $ddiarycontent);

        $this->display("customer_addfile");

    }

    public function addarticle()
    {
        $cid = $_REQUEST["cid"];
        $fid = $_REQUEST["fid"];
        $fnid = $_REQUEST["fnid"];
        $m = M('Flownode');
        $data = $m->where(" cid = {$cid} and fid = {$fid} and id = {$fnid} ")->find();
        $this->assign("data", $data);

        $mdiary = M('Diary');
        $ddiary = $mdiary->where(" customerid = {$cid} and fid = {$fid} and id = {$fnid} ")->order("ctime desc ")->select();
        $this->assign("diary", $ddiary);

        $mdiarycontent = M('Diary_content');
        $ddiarycontent = $mdiarycontent->where(" customerid = {$cid} and fid = {$fid} and id = {$fnid} ")->order("ctime desc ")->select();
        $this->assign("diarycontent", $ddiarycontent);

        $this->display("customer_addarticle");
    }


    /**
     * @title 上传图片
     * @author lizhi
     * @create on 2015-03-28
     */
    public function attachments_add()
    {
        $cid = $_REQUEST["cid"];
        $m = D('Attachments');

        $flow = M("flow");
        $flow_data = $flow->where('cid = '.$cid)->field('node_id')->find();

        //var_dump($flow_data['node_id']);die();
        if ($this->isPost())
        {
            $is_res = false;
            if ($data = $m->create())
            {

               /* echo '<pre>';
                print_r($data);
                die();*/
                $arr['fid'] = $flow_data['node_id'];
                //log::write("<br/>用户上传图片" . dump($data, false), "");
                $arr['cid'] = $data["cid"];
               /* echo '<pre>';
                print_r($data);
                die();*/
                $num = 0;
                foreach($data['images'] as $v){
                    $add['title']   = $data['title'];
                    $add['cid']     = $data['cid'];
                    $add['fid']     = $data['fid'];
                    $add['images']  = $v;
                    $add['type_id'] = 1; //1默认表示图文
                    $recordid       = $m->add($add);
                    if ($recordid === false) $num++;
                    /*echo $m->getLastSql();
                    die();*/
                }

                if ($num == 0) {
                    $is_res = true;
                } else {
                    $is_res = false;
                }
            } else {
                $is_res = false;
            }
            if ($is_res == true) {
                //?cid={$vo.cid}&fid={$vo.fid}&fnid={$vo.id}
                //$this->redirect("Customer/flownode/?cid=" . $cid."&fid=".$arr['fid']);
                $this->redirect("/customer/housecenter/id/{$cid}");
            } else {
                $this->error("数据写入错误!", "Customer/flownode/?cid=" . $cid."&fid=".$arr['fid']);
            }
            exit;
        } else {

            //$fid = $_REQUEST["fid"];
            $arr = array("cid" => $cid,"fid"=>$flow_data['node_id']);
            if ($arr["cid"] == null || $flow_data['node_id'] == null) {
                $this->error("非法操作，请从装修流程图上进行图片添加", "Customer/index/");
            }
        }
        $this->assign("arr", $arr);
        $this->display('attachments_add');
    }


    public function attachments_del()
    {
        $id = $this->_get('id');
        if (!empty($id)) {
            $m = M('Attachments');
            $del_where['id'] = array('eq', $id);
            $result = $m->where($del_where)->delete();
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


    public function attachments_edit()
    {
        $m = D('Attachments');
        if ($this->isPost()) {
            $is_res = false;
            if ($data = $m->create()) {
                //log::write("<br/>编辑表单" . dump($data, false), "");
                $arr["cid"] = $data["cid"];
                $arr["fid"] = $data["fid"];
                $arr["fnid"] = $data["fnid"];
                $recordid = $m->save();
                if ($recordid !== false) {
                    $is_res = true;
                } else {
                    $is_res = false;
                }
            } else {
                $is_res = false;
            }
            if ($is_res == true) {
                $this->redirect("/index.php/Customer/attachments_list/?fid=" . $arr . fid . "&cid=" . $arr . cid . "&fnid=" . $arr . fnid);
            } else {
                $this->error("数据写入错误!", "/index.php/Customer/attachments_list/?fid=" . $arr . fid . "&cid=" . $arr . cid . "&fnid=" . $arr . fnid);
            }
            exit;
        }
        $id = $this->_get('id');
        $arr = $m->where("id=$id")->find();
        $this->assign('arr', $arr);
        $this->display('attachments_add');
    }


    public function upload()
    {
        $action = $_GET['act'];
        $picname = $_FILES['mypic']['name'];
        $picsize = $_FILES['mypic']['size'];
        $msg = "";
        //log::write("<br/>上传图片信息" . $action . $picname . $picsize, "");
        if ($picname != "") {
            if ($picsize > C('ITEM_UPLOAD_SIZE') * 1024 * 1024) {
                echo '图片大小不能超过5M';
                exit;
            }
            $type = strstr($picname, '.');
            if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
                echo '图片格式不对！';
                exit;
            }
            $rand = rand(100, 999);
            $dirdate = date("Ymd");
            $dir = $_SERVER["DOCUMENT_ROOT"] . C('ATTACHMENTS_UPLOAD_DIR');
            log::write($dir, "上传文件目录：ATTACHMENTS_UPLOAD_DIR");
            $msg .= "上传文件目录：ATTACHMENTS_UPLOAD_DIR" . $dir;
            if (!file_exists($dir)) {
                mkdir($dir);
            }
            $dir = $_SERVER["DOCUMENT_ROOT"] . C('ATTACHMENTS_UPLOAD_DIR') . $dirdate;
            log::write($dir, "上传文件目录：ATTACHMENTS_UPLOAD_DIR加上了日期目录");
            $msg .= "上传文件目录：ATTACHMENTS_UPLOAD_DIR加上了日期目录" . $dir;
            if (!file_exists($dir)) {
                mkdir($dir);
            }
            $pics = date("YmdHis") . $rand . $type;
            //上传路径
            $pic_path = $dir . "/" . $pics;
            move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
            log::write($pic_path, "图片真实地址");
            $msg .= "图片真实地址" . $pic_path;
        }
        $size = round($picsize / 1024, 2);
        $arr = array(
            'name' => $picname,
            'pic' => $dirdate . "/" . $pics,
            'size' => $size,
            'msg' => $msg
        );
        log::write(dump($arr, false), "");
        echo json_encode($arr);
    }


    function image_uploadSSSSSSSSSSSSSS(){
        //$who=I('post.who',0,'int');
        // dump($who);die;
        //$zip=new ZipAction(); //返回两个url  url  picurl
        //$agenturl=$zip->agenturl($who);
        $who ='Customer';
        $ymd = date("Ymd"); //图片路径地址
        import('ORG.Net.UploadFile');
        $upload = new UploadFile();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->thumbType  = 0 ;
        $upload->thumb  = true ;
        $upload->thumbRemoveOrigin  = true ;
        $upload->thumbMaxWidth  = 320;
        $upload->thumbMaxHeight  = 320;
        $upload->zipImages  = true ;
        $upload->autoSub  = true ;
        $upload->subType  = 'date' ;
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->savePath =  '/uploads/'.$who.'/';// 设置附件上传目录.'/'.$ymd
        $upload->thumbPath =  '/uploads/'.$who.'/'.$ymd.'/';// 设置附件上传目录.
        if(!$upload->upload()) {// 上传错误提示错误信息
            //$this->error($upload->getErrorMsg());
            //$ary['success']=0;
            $this->ajaxreturn("","上传失败",0);
        }else{// 上传成功 获取上传文件信息
            $info =  $upload->getUploadFileInfo();
            //$ary['success']=1;
           /* echo '<pre>';
            print_r($info);*/
//$i=0;
//foreach($info as $val){
            //savename: "20150305/54f8362701bbf.jpeg"    缩略图加上了thumb_
            //$agenturl['picurl'] = "/Uploads/Customer";
            $info[0]['savename']=str_ireplace($ymd.'/',$ymd.'/thumb_',$info[0]['savename']);
            $ary['src']= $info[0]['savepath'].$info[0]['savename'];
            //$ary['ssss']=$info;
            //$i++;
//}
/*print_r($ary);
            die();*/
            $this->ajaxreturn($ary,"上传成功",1);
        }
    }

    /**
     * @title 推荐样板间
     * @author lizhi
     * @create on 2015-03-29
     */
    public function tuijian_house()
    {

        $code = $this->_get('code');
        check_openid($code);
        $openid = session('openid');

        //热点小区推荐
        $m = M("customer");
        $tuijian_data = $m->where('isdelete = 0 and tuijian_house = 1')->order('tuijian_house_order')->limit(5)->select();
        foreach($tuijian_data as $k=>$v){
            $tuijian_data[$k]['newname'] = $v['xiaoqu'].($v['qi'] != ""?$v['qi'].'期':'').$v['dong']."栋".$v['lou']."单元".$v['fangjian']."房间";
        }

        $this->assign('tuijian_data',$tuijian_data);
        $this->display();
    }

    function image_upload(){
        import("ORG.Net.UploadFile");
        $upload    = new UploadFile();
        //设置上传文件大小
        $upload->maxsize = 3145728;
        //设置上传文件类型
        $upload->allowExts = explode(',',"jpg,gif,jpeg,png");

        $ymd = date("Ymd"); //图片路径地址

        $upload->autoSub  = true ;

        $upload->thumbRemoveOrigin  = true ;
        //设置附近上传目录
        $upload->savePath = "Uploads/Attachments/"; //注意 目录为入口文件的相对路径
        $thumbPath ='Uploads/Attachments/'.$ymd.'/';//缩略图的路径
        $upload->thumbPath = $thumbPath;
        //设置需要生成缩略图他，仅对图片文件有效
        $upload->thumb = true;

        if(!mk_dir($thumbPath)) $this->error("缩略图目录创建失败");
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
            //捕获上传异常
            $this->error($upload->getErrorMsg());die();
            //$this->ajaxreturn("","error",0);
        }else{
            //取得成功上传文件信息
            $info   = $upload->getUploadFileInfo();
            /* echo '<pre>';*/
            //print_r($info);
            $info[0]['savename']=str_ireplace($ymd.'/',$ymd.'/thumb_',$info[0]['savename']);
            $ary['src']= "/".$info[0]['savepath'].''.$info[0]['savename'];
            $this->ajaxreturn($ary,"success",1);
            //return $info;
            //var_dump($info);die();
        }

    }

    /**
     * @title 回复评论
     * @author lizhi
     * create on 2015-04-06
     */
    public function addreply()
    {

    }
}

?>