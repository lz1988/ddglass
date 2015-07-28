<?php

class TuchaoAction extends PublicAction {

    public $dianzhanNumber;
    public $commentNumber;
    public $openid;
    public $ridicule_model;
    public $ridicule_dianzan_model;
    public $ridicule_comment_model;
    public $user_model;
    public $user_tuchao_id;
    public $share_user_openid;

    function __construct() {
        parent::__construct();
        $this->ridicule_model = M("ridicule");
        $this->ridicule_dianzan_model = M("ridicule_dianzan");
        $this->ridicule_comment_model = M("ridicule_comment");
        $this->user_model = M("user");
    }

    function index() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        //微信参数
        //$appId = 'wx6665fe982e03a365';
        //$appSecret = 'b7afef65ba8d7dee39b15bfe1388dad9';

        $appId = C('APPID');
        $appSecret = C('SECRET');

        //获取get参数
        $code = $_GET['code'];

        //获取 code
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appId&redirect_uri=" . urlencode($redirect_uri) . "&response_type=code&scope=jsapi_address&state=cft#wechat_redirect";
        if (empty($code)) {
            header("location: $url");
        }

        //获取 access_token
        $access_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $appSecret . "&code=" . $code . "&grant_type=authorization_code";
        $access_token_json = $this->getUrl($access_token_url);
        $access_token = json_decode($access_token_json, true);


        $this->openid = $_SESSION["openid"];
        $this->share_user_openid = $_REQUEST['shareopenid'];
        $this->user_tuchao_id = $_REQUEST["tuchaoid"];

        if ($_REQUEST["tuchaoid"] != "" || $_REQUEST['shareopenid'] != "") {
            //已经吐槽
            if ($this->share_user_openid === $this->openid) {
                $this->redirect("index.php/tuchao/friendsComment?tuchaoid='" . $this->user_tuchao_id . "'");
            } else {
                $_SESSION["share_user_openid"] = $this->share_user_openid;
                $_SESSION["tuchaoid"] = $this->openid;
                $this->redirect("tuchao/showfenxiangpage?tuchaoid='" . $this->user_tuchao_id . "'");
            }
        } else {
            //还没吐槽
            if ("0" == $this->is_tuchao()) {
                $this->assign("openid", $_SESSION["openid"]);
                $this->display();
            } else {
                $this->redirect("index.php/tuchao/friendsComment?tuchaoid='" . $this->user_tuchao_id . "'");
            }
        }
    }

    function get_openid($code) {
        $openid = session('openid');
        if (empty($openid)) {
            $APPID = C('APPID');
            $SECRET = C('SECRET');
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$APPID&secret=$SECRET&code=$code&grant_type=authorization_code";
            $res = (array) json_decode(curl_get($url));
            session('openid', $res['openid']);

            //$access_token=$res['access_token'];
            $user = M('user');
            $u_where['openid'] = array('eq', $res['openid']);
            $res2 = $user->where($u_where)->field('user_id,username')->find();

            if (!$res2) {
                /* $access_token=curl_get("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$SECRET");
                  $access_token=@get_object_vars(@json_decode($access_token));
                  $get_user_info="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token[access_token]&openid=$res[openid]&lang=zh_CN";
                  $ures=(array)json_decode(curl_get($get_user_info));
                  $user_data['openid']=$res[openid];
                  $username=$user_data['username']=$ures[nickname];
                  $user_data['tel']='';
                  $user_data['sex']=$ures[sex];
                  $user_data['city_name']=$ures[city];
                  $add_data['headimgurl']=$ures[headimgurl];
                  //$user_data['nickname']=$ures[nickname];
                  $user_data['create_time']=time();
                  $user_data['status']=0;
                  //$user_data['is_master']=0;
                  $user_id=$user->add($user_data); */
            } else {
                $user_id = $res2[user_id];
                $username = $res2[username];
            }
            session('username', $username);
            session('user_id', $user_id);
        }
        return session('openid');
    }

    function my_tuchao() {
        if ($this->is_guanzhu() == "true") {
            if ($this->is_tuchao() > 0) {
                $this->error("我已经吐槽过");
            } else {
                $this->display("index");
            }
        } else {
            $this->error("您还没有关注公众号，点击右上角功能按钮关注公众号");
        }
    }

    function showfenxiangpage() {
        if ($_SESSION["share_user_openid"]) {
            $share_user_openid = $_SESSION["share_user_openid"];
        } else {
            $share_user_openid = $_REQUEST[shareopenid];
        }
        //得到赞相关的人，说的相关话
        $where = "openid='" . $share_user_openid . "'";
        $ridiculeList = $this->ridicule_model->where($where)->find();
        $this->assign("ridiculeList", $ridiculeList);
        $this->assign("username", $this->getPersonMes($share_user_openid));
        //是否关注过商城
        $this->assign("is_guanzhu", $this->is_guanzhu());

        //判断自己是否赞
        if ($this->is_zhan($ridiculeList[id]) == 0) {
            //没有点过赞
            $info = '<p class="invite has_tc" id="jack" tuchao_id="' . $ridiculeList['id'] . '" ><a style="color:red;" href="javascript:;">我要点赞</a></p>';
        } else {
            //点过赞
            $info = '<p class="invite has_tc" >您已经提过高见了</p>';
        }
		
		$info = '<p class="invite has_tc" >活动已经束</p>';
        if ($this->is_tuchao() < 1) {
            $this->assign("is_shar", "0");
        } else {
            $this->assign("is_shar", "1");
        }
        /* weiyuhuang jia 个人排行榜 */
        /* $user = M('User');
          $datalist = $user->field("count(DISTINCT cms_ridicule_dianzan.dianzan_id) as dianzancount,count(DISTINCT cms_ridicule_comment.comment_id) as commentcount,cms_user.username,cms_ridicule.id,cms_ridicule.openid,cms_ridicule.content,cms_ridicule.time")
          ->join("join cms_ridicule on cms_user.openid=cms_ridicule.openid")
          ->join("left join cms_ridicule_dianzan on cms_ridicule_dianzan.tuchao_id = cms_ridicule.id")
          ->join("left join cms_ridicule_comment on cms_ridicule_comment.tuchao_id = cms_ridicule.id")
          ->group("cms_ridicule.id")
          ->order('dianzancount desc')->select();
          foreach ($datalist as $key => $val) {
          if ($val['id'] == $ridiculeList[id]) {
          $flag = $key + 1;
          break;
          }
          } */
        $flag = $this->rank_person($ridiculeList[id]);
        $this->assign('flag', $flag);
        $this->assign("comment", $this->tuchaolist($_REQUEST["tuchaoid"]));
        $this->assign("info", $info);
        $this->display();
    }

    function getUrl($url) {
        $opts = array(
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        );
        /* 根据请求类型设置特定参数 */
        $opts[CURLOPT_URL] = $url;
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        return $data;
    }

    //根据openid得到个人信息
    function getPersonMes($openid) {
        $userMes = $this->user_model->where("openid='" . $openid . "'")->find();
        return $userMes["username"];
    }

    //发表吐槽
    function add_tuchao() {
        if ($this->is_tuchao() < 1) {
            $user = M("user");
            $userinfo = $user->field('openid,username')->where("openid = '" . $_SESSION[openid] . "'")->find();
            if ($userinfo) {
                if ($_SESSION["openid"] != "")
                {
                    $data["content"] = $_REQUEST["tucaoContent"];
                    $data["openid"] = $_SESSION["openid"];
                    $data["time"] = date("Y-m-d h:i:s", time());
                    if ($data["content"] != "") {
                        $result = $this->ridicule_model->data($data)->add();
                        if (false !== $result) {
                            $_SESSION["user_tuchao_id"] = $result;
                            $this->redirect("index.php/Tuchao/friendsComment?tuchaoid='" . $result . "'");
                        }
                    } else {
                        $this->error("内容不能为空");
                    }
                } else {
                    echo "openid为空";
                }
            } else {
                $this->error("您还没有关注公众号，点击右上角功能按钮关注公众号");
            }
        } else {
            $this->error("你已经吐槽过");
        }
    }

    //判断自己是否吐槽
    function is_tuchao() {
        $openid = $_SESSION["openid"];
        $where = "openid='" . $openid . "'";
        $count = $this->ridicule_model->where($where)->count();
        return $count;
    }

    //好友评论页
    function friendsComment() {
        //得到自己的吐槽id
        $user = M("user");
        $where = "openid='" . $_SESSION['openid'] . "'";
        $ridiculeList = $this->ridicule_model->where($where)->find();
        $userList = $user->where($where)->find();
        //得到吐槽的人的信息
//      var_dump(F('bank'));
        /* weiyuhuang jia 个人排行榜 */
        /* weiyuhuang jia 个人排行榜 */
        /* $user = M('User');
          $datalist = $user->field("count(DISTINCT cms_ridicule_dianzan.dianzan_id) as dianzancount,count(DISTINCT cms_ridicule_comment.comment_id) as commentcount,cms_user.username,cms_ridicule.id,cms_ridicule.openid,cms_ridicule.content,cms_ridicule.time")
          ->join("join cms_ridicule on cms_user.openid=cms_ridicule.openid")
          ->join("left join cms_ridicule_dianzan on cms_ridicule_dianzan.tuchao_id = cms_ridicule.id")
          ->join("left join cms_ridicule_comment on cms_ridicule_comment.tuchao_id = cms_ridicule.id")
          ->group("cms_ridicule.id")
          ->order('dianzancount desc')->select();
          foreach ($datalist as $key => $val) {
          if ($val['id'] == $ridiculeList[id]) {
          $flag = $key + 1;
          break;
          }
          } */
        $flag = $this->rank_person($ridiculeList[id]);
        $this->assign('flag', $flag);
        $this->assign("user", $userList);
        $this->assign("comment", $this->tuchaolist($_REQUEST[tuchaoid]));
        $this->assign("ridiculeList", $ridiculeList);
        //是否关注过商城
        $this->assign("is_guanzhu", $this->is_guanzhu());
        $this->display();
    }

    //所有的吐槽列表
    function alltuchaolist() {
        $ridicule = M("ridicule");
        $list = $ridicule->join("cms_user on cms_ridicule.openid = cms_user.openid")->select();
        $this->assign("list", $list);
        $this->display();
    }

    //得到吐槽有多少赞
    function countzan($tucaoid) {
        $ridicule_dianzan = M("ridicule_dianzan");
        $where = "tuchao_id='" . $tucaoid . "'";
        $count = $ridicule_dianzan->where($where)->count();
        return $count;
    }

    //得到吐槽有多少评论
    function countpinglu($tucaoid) {
        $ridicule_pinglu = M("ridicule_comment");
        $where = "tuchao_id='" . $tucaoid . "'";
        $count = $ridicule_pinglu->where($where)->count();
        return $count;
    }

    //关于某条吐槽的评论列表
    function tuchaolist($tuchaoid) {
        $ridicule_comment_list = $this->ridicule_comment_model->where("tuchao_id=" . $tuchaoid)->select();
        foreach ($ridicule_comment_list as $v) {
            $ridicule_comment["dianzhanNumber"] = $v["dianzhanNumber"];
            $ridicule_comment["commentNumber"] = $v["commentNumber"];
            $ridicule_comment["content"] = $v["comment"];
            $ridicule_comment["content_user"] = $this->getPersonMes($v["openid"]);
            $ridicule_comment["comment_id"] = $v["comment_id"];
            $ridicule_comment["tuchao_id"] = $v["tuchao_id"];
            $ridicule_comment["by_writer"] = $v["by_writer"];
            $ridicule_comment["writer"] = $v["writer"];
            if ($v[pid] == 0) {
                $ridicule_comment["rep"] = "";
            } else {
                $ridicule_comment["rep"] = $this->commentInfo($v["pid"]);
            }
            $comment[] = $ridicule_comment;
        }
        return $comment;
    }

    //获取评论几层信息
    function commentInfo($pid) {
        $rep = $this->ridicule_comment_model->where("pid='" . $pid . "'")->find();
        $repMes = $this->getPersonMes($rep["openid"]) . "：" . $rep['comment'] . " ";
        return $repMes;
    }

    //对某个吐槽发表评论
    function commenttuchao() {
        $user = M("user");
        $userinfo = $user->field('openid,username')->where("openid = '" . $_SESSION[openid] . "'")->find();
        if ($userinfo) {
            $ridicule_comment = M("ridicule_comment");
            $data["tuchao_id"] = $_REQUEST["tuchaoid"];
            $data["comment"] = $_REQUEST["comment"];
            $data["add_comment_time"] = date("Y-m-d h:i:s", time());
            $data["openid"] = $_SESSION["openid"];
            $res = $ridicule_comment->data($data)->add();
            if ($res !== false) {
                $this->success("评论成功");
            } else {
                $this->error("评论失败");
            }
        } else {
            $this->error("您还没有关注公众号，点击右上角功能按钮关注公众号");
        }
    }

    //对某个吐槽发表评论
    function dianzhantuchao() {
        $ridicule_dianzhan = M("ridicule_dianzhan");
        $data["tuchao_id"] = $_REQUEST["tuchaoid"];
        $data["dianzan_time"] = date("Y-m-d h:i:s", time());
        $data["openid"] = $_SESSION["openid"];
        $ridicule_dianzhan->data($data)->add();
    }

    //判断是否点过赞
    function is_zhan($tuchaoid) {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        $ridicule_dianzan = M("ridicule_dianzan");
        $openid = $_SESSION["openid"];
        $where = "openid='" . $openid . "' and tuchao_id='" . $tuchaoid . "'";
        $count = $ridicule_dianzan->where($where)->count();
        if ($count > 0) {
            // echo "点过赞";
            return 1;
        } else {
            //echo "没有点过赞";
            return 0;
        }
    }

    //判断是否评论guo
    function is_comment() {
        $ridicule_comment = M("ridicule_comment");
        $where = "openid='" . $openid . "' and tuchao_id=$tuchaoid";
        $count = $ridicule_comment->where($where)->count();
        if ($count > 0) {
            echo "评论过";
        } else {
            echo "没有评论过";
        }
    }

    /* @author:weiyuhuang
     * @title:dianzan
     * */
    /* 点赞页面 */

    public function dianzan() {
        $this->display('tuchaolist');
    }

    /* 添加点赞 */

    public function add_dianzan() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        $tuchao_id = $_REQUEST['val'];

        if(empty($_SESSION['openid']) || empty($tuchao_id))
        {
            echo '0';
            exit();
        }


        $dianzan = M('RidiculeDianzan');
        if ($tuchao_id) {
            if ($this->is_zhan($tuchao_id)) {
                echo 1;
            } else {
                $ridicule = M('Ridicule');
                $res = $ridicule->where('id=' . $_REQUEST['val'])->field('dianzhanNumber')->find();
							  

				$rs['dianzhanNumber'] = $res['dianzhanNumber'] + 1;
                $ridicule->where('id=' . $_REQUEST['val'])->save($rs);

                $data['openid'] = $_SESSION['openid'];
                $data['tuchao_id'] = $_REQUEST['val'];
				$data["dianzan_time"] = date("Y-m-d h:i:s", time());
				$result = $this->ridicule_dianzan_model->data($data)->add();


				if (false !== $result) {
					$count = $this->ridicule_dianzan_model->where("tuchao_id='" . $data["tuchao_id"] . "'")->count();
					$res['dianzhanNumber'] = $count;
				}


                /* 排行问题 */
                /*$user = M('User');
                $datalist = $user->field("count(DISTINCT cms_ridicule_dianzan.dianzan_id) as dianzancount,count(DISTINCT cms_ridicule_comment.comment_id) as commentcount,cms_user.username,cms_ridicule.id,cms_ridicule.openid,cms_ridicule.content,cms_ridicule.time")
                                ->join("join cms_ridicule on cms_user.openid=cms_ridicule.openid")
                                ->join("left join cms_ridicule_dianzan on cms_ridicule_dianzan.tuchao_id = cms_ridicule.id")
                                ->join("left join cms_ridicule_comment on cms_ridicule_comment.tuchao_id = cms_ridicule.id")
                                ->group("cms_ridicule.id")
                                ->order('dianzancount desc')->select();*/
                /* foreach ($datalist as $key => $val) {
                  if ($val['id'] == $tuchao_id) {
                  $flag = $key + 1;
                  break;
                  }
                  }
                  $j = array();
                  $j[0] = $flag;
                  $j[1] = $res['dianzhanNumber']; */

                echo 1;
            }
        }
    }

    /* 吐槽排行榜 */

    public function rank_list() {
        $user = M('User');
        $datalist = $user->field("count(DISTINCT cms_ridicule_dianzan.dianzan_id) as dianzancount,count(DISTINCT cms_ridicule_comment.comment_id) as commentcount,cms_user.username,cms_ridicule.id,cms_ridicule.openid,cms_ridicule.content,cms_ridicule.time")
                        ->join("join cms_ridicule on cms_user.openid=cms_ridicule.openid")
                        ->join("left join cms_ridicule_dianzan on cms_ridicule_dianzan.tuchao_id = cms_ridicule.id")
                        ->join("left join cms_ridicule_comment on cms_ridicule_comment.tuchao_id = cms_ridicule.id")
                        ->group("cms_ridicule.id")
                        ->order('dianzancount desc')->select();


        $this->assign('data', $datalist);
        $this->display('ranklist');
        /* $this->redirect("tuchao/tucao5"); */
    }

    /* 详情跳转  tuchao */

    public function detail() {
        $tuchao_id = $_REQUEST['tuchao_id'];
        $flag = $this->rank_person($tuchao_id);
        $this->assign('flag', $flag);
        if ($this->is_zhan($tuchao_id)) {
            $where['id'] = $tuchao_id;
            $ridiculeList = $this->ridicule_model->where($where)->find();
       //     $info = '<p class="invite has_tc">您已经提过高见了</p>';
			$info = '<p class="invite has_tc" >活动已经束</p>';
            $share_user_openid = $ridiculeList['openid'];
            $this->assign("username", $this->getPersonMes($share_user_openid));
            $this->assign('info', $info);
            $this->assign("ridiculeList", $ridiculeList);
            $this->assign("comment", $this->tuchaolist($tuchao_id));
            if ($ridiculeList["openid"] == $_SESSION["openid"]) {
                $this->display('friendscomment');
            } else {
                $this->display("showfenxiangpage");
            }
        } else {
            $where['id'] = $tuchao_id;
            $ridiculeList = $this->ridicule_model->where($where)->find();
            $share_user_openid = $ridiculeList['openid'];
            $this->assign("username", $this->getPersonMes($share_user_openid));
           // $info = '<p class="invite has_tc" id="jack" tuchao_id="' . $ridiculeList['id'] . '" ><a style="color:red;" href="javascript:;">我要点赞</a></p>';
			$info = '<p class="invite has_tc" >活动已经束</p>';
            $this->assign("ridiculeList", $ridiculeList);
            $this->assign('info', $info);
            $this->assign("comment", $this->tuchaolist($tuchao_id));
            if ($ridiculeList["openid"] == $_SESSION["openid"]) {
                $this->display('friendscomment');
            } else {
                $this->display("showfenxiangpage");
            }
        };
    }

    function add_addZans() {
        if ($this->is_zhan() < 1) {
            if (empty($_SESSION["openid"]) || empty($_REQUEST["tuchaoid"]))
            {
                echo '0';
            }

            $data["openid"] = $_SESSION["openid"];
            $data["tuchao_id"] = $_REQUEST["tuchaoid"];
            $data["dianzan_time"] = date("Y-m-d h:i:s", time());
            $result = $this->ridicule_dianzan_model->data($data)->add();

            if (false !== $result) {
                $count = $this->ridicule_dianzan_model->where("tuchao_id='" . $data["tuchao_id"] . "'")->count();
                echo $count;
            }
        } else {
            echo '0';
        }
    }

    /*
     * 添加评论
     */

    function comment_autor() {
        //评论者
        $user = M("user");
        $userinfo = $user->field('openid,username')->where("openid = '" . $_SESSION[openid] . "'")->find();
        if ($userinfo) {
            $data["comment"] = $_REQUEST["content"];
            $data["pid"] = $_REQUEST["pid"];
            $data["openid"] = $_SESSION["openid"];
            $data["time"] = date("Y-m-d h:i:s", time());
            $data["tuchao_id"] = $_REQUEST["tuchaoid"];
            $data["by_writer"] = $_REQUEST["by_writer"];
            $data["writer"] = $userinfo["username"];

            if ($data["writer"] != $data["by_writer"]) {
                if ($data["openid"] != "") {
                    $res = $this->ridicule_comment_model->data($data)->add();
                    if (false !== $res) {
                        $countNum = $this->countComment($data["tuchao_id"]);
                        $com["commentNumber"] = $this->countComment($data["tuchao_id"]);
                        //              $com["dianzhanNumber"] = $this->countZans($data["tuchao_id"]);
                        $this->ridicule_model->where("id='" . $data["tuchao_id"] . "'")->data($com)->save();
                        $this->success("评论成功");
                    } else {
                        $this->error("评论失败");
                    }
                }
            } else {
                $this->error("自己不能评论自己");
            }
        } else {
            $this->error("您还没有关注公众号，点击右上角功能按钮关注公众号");
        }
    }

    //得到自己的排行位
    function sort() {
        $user = M('User');
        $datalist = $user->field("count(DISTINCT cms_ridicule_dianzan.dianzan_id) as dianzancount,count(DISTINCT cms_ridicule_comment.comment_id) as commentcount,cms_user.username,cms_ridicule.id,cms_ridicule.openid,cms_ridicule.content,cms_ridicule.time")
                        ->join("join cms_ridicule on cms_user.openid=cms_ridicule.openid")
                        ->join("left join cms_ridicule_dianzan on cms_ridicule_dianzan.tuchao_id = cms_ridicule.id")
                        ->join("left join cms_ridicule_comment on cms_ridicule_comment.tuchao_id = cms_ridicule.id")
                        ->group("cms_ridicule.id")
                        ->order('dianzancount desc')->select();
        $list = array();
        foreach ($datalist as $key => $v) {
            $list[$v[openid]] = $key;
        }
        F('bank', $list);
    }

    //统计评论数
    function countComment($tuchaoid) {
        if ($tuchaoid != "") {
            $where = "tuchao_id='" . $tuchaoid . "'";
            $count = $this->ridicule_comment_model->where($where)->count();
            if ($count) {
                return $count;
            }
        }
    }

    /* 统计点赞数 */

    function countZans($tuchaoid) {
        if ($tuchaoid != "") {
            $where = "tuchao_id='" . $tuchaoid . "'";
            $count = $this->ridicule_dianzan_model->where($where)->count();
            if ($count) {
                return $count;
            }
        }
    }

    /* weiyuhuang jia 个人排行 */

    public function rank_person($id) {
        /* weiyuhuang jia 个人排行榜 */
        $user = M('User');
        $datalist = $user->field("count(DISTINCT cms_ridicule_dianzan.dianzan_id) as dianzancount,count(DISTINCT cms_ridicule_comment.comment_id) as commentcount,cms_user.username,cms_ridicule.id,cms_ridicule.openid,cms_ridicule.content,cms_ridicule.time")
                        ->join("join cms_ridicule on cms_user.openid=cms_ridicule.openid")
                        ->join("left join cms_ridicule_dianzan on cms_ridicule_dianzan.tuchao_id = cms_ridicule.id")
                        ->join("left join cms_ridicule_comment on cms_ridicule_comment.tuchao_id = cms_ridicule.id")
                        ->group("cms_ridicule.id")
                        ->order('dianzancount desc')->select();
        foreach ($datalist as $key => $val) {
            if ($val['id'] == $id) {
                $flag = $key + 1;
                break;
            }
        }
        return $flag;
    }

//是否关注过商城
    function is_guanzhu() {
        $user = M("user");
        $userinfo = $user->field('openid,username')->where("openid = '" . $_SESSION[openid] . "'")->find();
        if (count($userinfo) > 0) {
            return "true";
        } else {
            return "false";
        }
    }

}

?>