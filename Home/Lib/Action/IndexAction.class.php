<?php

/**
 * @author
 *
 */
// 本类由系统自动生成，仅供测试用途

header("Content-type:text/html;charset=utf-8");
define("TOKEN", "yzzs825528680");

class IndexAction extends PublicAction {
    #$lng=113.95843019;      #经度(必填) 113.951385      莱科：22.559142035979,113.958430192661
    #	$lat=22.559142;   #纬度(必填)  22.5538
    /*
     *  首页
     */

    private $d = array(
        array("a", -20319),
        array("ai", -20317),
        array("an", -20304),
        array("ang", -20295),
        array("ao", -20292),
        array("ba", -20283),
        array("bai", -20265),
        array("ban", -20257),
        array("bang", -20242),
        array("bao", -20230),
        array("bei", -20051),
        array("ben", -20036),
        array("beng", -20032),
        array("bi", -20026),
        array("bian", -20002),
        array("biao", -19990),
        array("bie", -19986),
        array("bin", -19982),
        array("bing", -19976),
        array("bo", -19805),
        array("bu", -19784),
        array("ca", -19775),
        array("cai", -19774),
        array("can", -19763),
        array("cang", -19756),
        array("cao", -19751),
        array("ce", -19746),
        array("ceng", -19741),
        array("cha", -19739),
        array("chai", -19728),
        array("chan", -19725),
        array("chang", -19715),
        array("chao", -19540),
        array("che", -19531),
        array("chen", -19525),
        array("cheng", -19515),
        array("chi", -19500),
        array("chong", -19484),
        array("chou", -19479),
        array("chu", -19467),
        array("chuai", -19289),
        array("chuan", -19288),
        array("chuang", -19281),
        array("chui", -19275),
        array("chun", -19270),
        array("chuo", -19263),
        array("ci", -19261),
        array("cong", -19249),
        array("cou", -19243),
        array("cu", -19242),
        array("cuan", -19238),
        array("cui", -19235),
        array("cun", -19227),
        array("cuo", -19224),
        array("da", -19218),
        array("dai", -19212),
        array("dan", -19038),
        array("dang", -19023),
        array("dao", -19018),
        array("de", -19006),
        array("deng", -19003),
        array("di", -18996),
        array("dian", -18977),
        array("diao", -18961),
        array("die", -18952),
        array("ding", -18783),
        array("diu", -18774),
        array("dong", -18773),
        array("dou", -18763),
        array("du", -18756),
        array("duan", -18741),
        array("dui", -18735),
        array("dun", -18731),
        array("duo", -18722),
        array("e", -18710),
        array("en", -18697),
        array("er", -18696),
        array("fa", -18526),
        array("fan", -18518),
        array("fang", -18501),
        array("fei", -18490),
        array("fen", -18478),
        array("feng", -18463),
        array("fo", -18448),
        array("fou", -18447),
        array("fu", -18446),
        array("ga", -18239),
        array("gai", -18237),
        array("gan", -18231),
        array("gang", -18220),
        array("gao", -18211),
        array("ge", -18201),
        array("gei", -18184),
        array("gen", -18183),
        array("geng", -18181),
        array("gong", -18012),
        array("gou", -17997),
        array("gu", -17988),
        array("gua", -17970),
        array("guai", -17964),
        array("guan", -17961),
        array("guang", -17950),
        array("gui", -17947),
        array("gun", -17931),
        array("guo", -17928),
        array("ha", -17922),
        array("hai", -17759),
        array("han", -17752),
        array("hang", -17733),
        array("hao", -17730),
        array("he", -17721),
        array("hei", -17703),
        array("hen", -17701),
        array("heng", -17697),
        array("hong", -17692),
        array("hou", -17683),
        array("hu", -17676),
        array("hua", -17496),
        array("huai", -17487),
        array("huan", -17482),
        array("huang", -17468),
        array("hui", -17454),
        array("hun", -17433),
        array("huo", -17427),
        array("ji", -17417),
        array("jia", -17202),
        array("jian", -17185),
        array("jiang", -16983),
        array("jiao", -16970),
        array("jie", -16942),
        array("jin", -16915),
        array("jing", -16733),
        array("jiong", -16708),
        array("jiu", -16706),
        array("ju", -16689),
        array("juan", -16664),
        array("jue", -16657),
        array("jun", -16647),
        array("ka", -16474),
        array("kai", -16470),
        array("kan", -16465),
        array("kang", -16459),
        array("kao", -16452),
        array("ke", -16448),
        array("ken", -16433),
        array("keng", -16429),
        array("kong", -16427),
        array("kou", -16423),
        array("ku", -16419),
        array("kua", -16412),
        array("kuai", -16407),
        array("kuan", -16403),
        array("kuang", -16401),
        array("kui", -16393),
        array("kun", -16220),
        array("kuo", -16216),
        array("la", -16212),
        array("lai", -16205),
        array("lan", -16202),
        array("lang", -16187),
        array("lao", -16180),
        array("le", -16171),
        array("lei", -16169),
        array("leng", -16158),
        array("li", -16155),
        array("lia", -15959),
        array("lian", -15958),
        array("liang", -15944),
        array("liao", -15933),
        array("lie", -15920),
        array("lin", -15915),
        array("ling", -15903),
        array("liu", -15889),
        array("long", -15878),
        array("lou", -15707),
        array("lu", -15701),
        array("lv", -15681),
        array("luan", -15667),
        array("lue", -15661),
        array("lun", -15659),
        array("luo", -15652),
        array("ma", -15640),
        array("mai", -15631),
        array("man", -15625),
        array("mang", -15454),
        array("mao", -15448),
        array("me", -15436),
        array("mei", -15435),
        array("men", -15419),
        array("meng", -15416),
        array("mi", -15408),
        array("mian", -15394),
        array("miao", -15385),
        array("mie", -15377),
        array("min", -15375),
        array("ming", -15369),
        array("miu", -15363),
        array("mo", -15362),
        array("mou", -15183),
        array("mu", -15180),
        array("na", -15165),
        array("nai", -15158),
        array("nan", -15153),
        array("nang", -15150),
        array("nao", -15149),
        array("ne", -15144),
        array("nei", -15143),
        array("nen", -15141),
        array("neng", -15140),
        array("ni", -15139),
        array("nian", -15128),
        array("niang", -15121),
        array("niao", -15119),
        array("nie", -15117),
        array("nin", -15110),
        array("ning", -15109),
        array("niu", -14941),
        array("nong", -14937),
        array("nu", -14933),
        array("nv", -14930),
        array("nuan", -14929),
        array("nue", -14928),
        array("nuo", -14926),
        array("o", -14922),
        array("ou", -14921),
        array("pa", -14914),
        array("pai", -14908),
        array("pan", -14902),
        array("pang", -14894),
        array("pao", -14889),
        array("pei", -14882),
        array("pen", -14873),
        array("peng", -14871),
        array("pi", -14857),
        array("pian", -14678),
        array("piao", -14674),
        array("pie", -14670),
        array("pin", -14668),
        array("ping", -14663),
        array("po", -14654),
        array("pu", -14645),
        array("qi", -14630),
        array("qia", -14594),
        array("qian", -14429),
        array("qiang", -14407),
        array("qiao", -14399),
        array("qie", -14384),
        array("qin", -14379),
        array("qing", -14368),
        array("qiong", -14355),
        array("qiu", -14353),
        array("qu", -14345),
        array("quan", -14170),
        array("que", -14159),
        array("qun", -14151),
        array("ran", -14149),
        array("rang", -14145),
        array("rao", -14140),
        array("re", -14137),
        array("ren", -14135),
        array("reng", -14125),
        array("ri", -14123),
        array("rong", -14122),
        array("rou", -14112),
        array("ru", -14109),
        array("ruan", -14099),
        array("rui", -14097),
        array("run", -14094),
        array("ruo", -14092),
        array("sa", -14090),
        array("sai", -14087),
        array("san", -14083),
        array("sang", -13917),
        array("sao", -13914),
        array("se", -13910),
        array("sen", -13907),
        array("seng", -13906),
        array("sha", -13905),
        array("shai", -13896),
        array("shan", -13894),
        array("shang", -13878),
        array("shao", -13870),
        array("she", -13859),
        array("shen", -13847),
        array("sheng", -13831),
        array("shi", -13658),
        array("shou", -13611),
        array("shu", -13601),
        array("shua", -13406),
        array("shuai", -13404),
        array("shuan", -13400),
        array("shuang", -13398),
        array("shui", -13395),
        array("shun", -13391),
        array("shuo", -13387),
        array("si", -13383),
        array("song", -13367),
        array("sou", -13359),
        array("su", -13356),
        array("suan", -13343),
        array("sui", -13340),
        array("sun", -13329),
        array("suo", -13326),
        array("ta", -13318),
        array("tai", -13147),
        array("tan", -13138),
        array("tang", -13120),
        array("tao", -13107),
        array("te", -13096),
        array("teng", -13095),
        array("ti", -13091),
        array("tian", -13076),
        array("tiao", -13068),
        array("tie", -13063),
        array("ting", -13060),
        array("tong", -12888),
        array("tou", -12875),
        array("tu", -12871),
        array("tuan", -12860),
        array("tui", -12858),
        array("tun", -12852),
        array("tuo", -12849),
        array("wa", -12838),
        array("wai", -12831),
        array("wan", -12829),
        array("wang", -12812),
        array("wei", -12802),
        array("wen", -12607),
        array("weng", -12597),
        array("wo", -12594),
        array("wu", -12585),
        array("xi", -12556),
        array("xia", -12359),
        array("xian", -12346),
        array("xiang", -12320),
        array("xiao", -12300),
        array("xie", -12120),
        array("xin", -12099),
        array("xing", -12089),
        array("xiong", -12074),
        array("xiu", -12067),
        array("xu", -12058),
        array("xuan", -12039),
        array("xue", -11867),
        array("xun", -11861),
        array("ya", -11847),
        array("yan", -11831),
        array("yang", -11798),
        array("yao", -11781),
        array("ye", -11604),
        array("yi", -11589),
        array("yin", -11536),
        array("ying", -11358),
        array("yo", -11340),
        array("yong", -11339),
        array("you", -11324),
        array("yu", -11303),
        array("yuan", -11097),
        array("yue", -11077),
        array("yun", -11067),
        array("za", -11055),
        array("zai", -11052),
        array("zan", -11045),
        array("zang", -11041),
        array("zao", -11038),
        array("ze", -11024),
        array("zei", -11020),
        array("zen", -11019),
        array("zeng", -11018),
        array("zha", -11014),
        array("zhai", -10838),
        array("zhan", -10832),
        array("zhang", -10815),
        array("zhao", -10800),
        array("zhe", -10790),
        array("zhen", -10780),
        array("zheng", -10764),
        array("zhi", -10587),
        array("zhong", -10544),
        array("zhou", -10533),
        array("zhu", -10519),
        array("zhua", -10331),
        array("zhuai", -10329),
        array("zhuan", -10328),
        array("zhuang", -10322),
        array("zhui", -10315),
        array("zhun", -10309),
        array("zhuo", -10307),
        array("zi", -10296),
        array("zong", -10281),
        array("zou", -10274),
        array("zu", -10270),
        array("zuan", -10262),
        array("zui", -10260),
        array("zun", -10256),
        array("zuo", -10254)
    );

    public function index() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        $myInfoData = M("user");
        //获取最近访问城市
        $newCity = F($_SESSION["openid"] . '/newCity');
        if ($newCity) {
            $this->assign("newCity", array_slice(array_reverse($newCity), 0, 6));
        }
        //最后一次访问记录
        $this->assign("lastCity", array_slice(array_reverse($newCity), 0, 1));
        //城市地区列表
        $city_list = $this->city_list();
        $this->assign("city_list", $city_list);
        $this->assign("seo_title", '滴滴配镜平台');
        $this->display();
    }

    /**
     * @title 店铺详情页
     * @author lizhi
     * @create on 2015-04-20
     */
    public function shop_detail() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        $id = intval($_REQUEST['id']);
        if (!$id)
            header("Location:/");

        $shop = M("shop");

        $data = $shop->where('id = ' . $id)->find();
        //店铺服务类型
        $by_shop_service = M("shop_service");
        $service_data = $by_shop_service->join("cms_by_shop_service on cms_by_shop_service.service_id = cms_shop_service.id")->where('shop_id = ' . $id)->select();

        //获取店铺的活动类型
        $by_shop_activity = M("by_shop_activity");
        $by_shop_activity_data = $by_shop_activity->field('activity_name,activity_info')->join('join cms_shop_activity on cms_by_shop_activity.activity_id=cms_shop_activity.id')->where('shop_id = ' . $id)->select();
        $this->assign('by_shop_activity_data', $by_shop_activity_data);

        //评论次数
        $comment = M("comment");
        //评论等级
        $level = $shop->where('id = ' . $id)->getField("all_score");

        $comment_count = $comment->where('shop_id = ' . $id)->count();
        //店铺图片


        $shop_images = M("shop_images");
        $data_images = $shop_images->where('shop_id = ' . $id)->select();

        //店铺所属验光师列表
        $optometrist = M("optometrist");
        $optometrist_detail = $optometrist->where("shop_id = ".$id)->select();

        $this->assign('optometrist_detail',$optometrist_detail);
        $this->assign('data_images', $data_images);
        $this->assign('comment_count', intval($comment_count));
        $this->assign('service_data', $service_data);
        $this->assign("level", round($level));
        $this->assign('shop_detail', $data);
        $this->display();
    }

    //验光师详情页
    public function optometrist_detail()
    {
        $id = $_GET['id'];
        //店铺所属验光师列表
        $optometrist = M("optometrist");
        $optometrist_detail = $optometrist->join('cms_shop on cms_shop.id=cms_optometrist.shop_id')->field('cms_optometrist.*,cms_shop.addr,cms_shop.lon,cms_shop.lat')->where("cms_optometrist.id = ".$id)->find();

        //评论展示
        $comment = M("comment");
        $count = $comment->where('op_id='.$id)->count('id');

        $this->assign('count',$count);
        $this->assign('data',$optometrist_detail);
        $this->display();
    }

    //预约验光师
    public function subscribe()
    {
        $id = $_GET['id'];

        $optometrist = M("optometrist");
        $rs = $optometrist->where('id = '.$id)->find();

        $this->assign('price',$rs['service_price']);
        $this->assign('id',$id);
        $this->display();
    }

    //预约验光师下单
    public function subscribemod()
    {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        if(!$_SESSION['openid'])
        {
            $this->error("对不起，用户身份有误");
        }

        $name   = $_POST['name'];
        $mobile = $_POST['mobile'];
        $sex    = $_POST['sex'];
        $opid   = $_POST['id'];

        $sms_code = M('sms_code');
        $flag_time = date('Y-m-d H:i:s',strtotime("-3 minute"));
        $sms_code_data = $sms_code->where('openid="'.$_SESSION['openid'].'" and sendtime >= "'.$flag_time.'"')->order('id desc')->find();

        if ($sms_code_data['phone_code'] != $_POST['msm_code'])
        {
            $this->error("输入的验证码错误");
        }

        $optometrist = M("optometrist");
        $rs_op = $optometrist->where('id = '.$opid)->find();
        if (!$rs_op)
        {
            $this->error("对不起，验光师不存在");
        }

        $subscribe = M("subscribe");
        $data['name']   = $name;
        $data['mobile'] = $mobile;
        $data['sex']    = $sex;
        $data['order_sn'] = order_no(6);
        $data['price']  = $rs_op['service_price'];
        $data['opid']   = $opid;
        $data['openid'] = $_SESSION['openid'];

        $rs = $subscribe->add($data);

        if ($rs !==  false)
        {
            $_SESSION['order_sn'] = $data['order_sn'];
            $this->redirect('/index/pay');
        }else{
            $this->error('预约失败，请稍后再试');
        }
    }

    //验光师评论列表
    public function op_comment_list()
    {
        $id = $_REQUEST['id'];
        $this->assign('id',$id);
        $this->display();
    }

    function op_sort_ajax_select() {
        $mod = $_REQUEST["mod"];
        $act = $_REQUEST["act"];
        $page = $_REQUEST["page"];

//       $shop_id = $_REQUEST["shop_id"];
        if ($act == "pingfen") {
            if ($mod == "0") {
                $order = 'order by optometry_level desc';
            } else {
                $order = 'order by optometry_level desc';
            }
        }
        if ($act == "addtime") {
            if ($mod == "0") {
                $order = 'order by addtime desc';
            } else {
                $order = 'order by addtime asc';
            }
        }
        $pageSize = 10;
        $start = $page * $pageSize;


        $limit = " limit " . $start . "," . $pageSize;
        $shop_id = $_REQUEST["id"];
        $Dao = M("comment");

        $sql = "select * from cms_optometrist as a ,cms_comment as b where b.op_id=a.id and b.op_id=" . $shop_id . " " . $order . $limit;
        //echo $sql;

        $data = $Dao->query($sql);
        foreach ($data as $v) {
            if ($v["openid"] != "") {
                $list["users"] = $this->searchUser($v["openid"]);
            } else {
                $list["users"] = $v["username"];
            }
            $list["addtime"] = $v["addtime"];
            $list["comment_level"] = $v["optometry_level"];//验光评分
            $list["comment"] = $v["comment"];
            $lists[] = $list;
        }

        if (count($data) > 0) {
            echo json_encode($lists);
        } else {
            echo "";
        }
    }

    //支付页面
    public function pay()
    {
        /**
         * JS_API支付demo
         * ====================================================
         * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
         * 成功调起支付需要三个步骤：
         * 步骤1：网页授权获取用户openid
         * 步骤2：使用统一支付接口，获取prepay_id
         * 步骤3：使用jsapi调起支付
         */
        //include_once("../WxPayPubHelper/WxPayPubHelper.php");
        //include_once("../WxPayPubHelper/WxPayPubHelper.php");
        import('@.ORG.wxpay.WxPayPubHelper.WxPayPubHelper');

        //使用jsapi接口
        $jsApi = new JsApi_pub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code'])) {
            //触发微信返回code码
            $url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL_dd);
            Header("Location: $url");
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
        }

        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();

        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        /* $openid = 'oEw2Ut0xvD3YjW8pQ4C5zoA75B6w';
          $out_trade_no = '123214511223214';
          $jiage=0.1; */

        $order_sn = $_SESSION["order_sn"];
        $list = M("subscribe")
                ->join("join cms_optometrist on cms_optometrist.id=cms_subscribe.opid")
                ->field('cms_subscribe.*,cms_optometrist.name as oname,cms_optometrist.job')
                ->where("order_sn='".$order_sn."'")
                ->find();
        //die(M("subscribe")->getLastSql());

        if (!$list) {
            $this->error("对不起，订单出现异常！");
        }

        $totle = $list['price'];

        $unifiedOrder->setParameter("openid", "$openid"); //openid
        $unifiedOrder->setParameter("body", "预约：".$list['oname'].$list['job'].""); //商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
        $unifiedOrder->setParameter("out_trade_no", "$out_trade_no"); //商户订单号
        $unifiedOrder->setParameter("total_fee", 0.1 * 100); //总金额
        $unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL_dd . "/order_sn/{$_SESSION['order_sn']}"); //通知地址
        $unifiedOrder->setParameter("trade_type", "JSAPI"); //交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID

        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);

        $jsApiParameters = $jsApi->getParameters();

        $this->assign('jsApiParameters', $jsApiParameters);
        $this->assign('list',$list);
        $this->display('success');
    }

    /**
     * @title 添加验光师评论
     */
    public function add_comment()
    {
        $id     = $_REQUEST['id'];
        $shopid = $_REQUEST['shopid'];

        $this->assign('shopid',$shopid);
        $this->assign('id',$id);

        $this->display();
    }


    /*
     * 评论店铺和验光师
     */

    public function add_commentmod() {

        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        $sharComment = trim($_REQUEST["sharComment"]);
        $sharShopid = trim($_REQUEST["shopid"]);
        $opid = $_REQUEST['opid'];

        $Dao = M("comment");

        //入库
        if ($sharComment && $sharShopid) {
            $data['op_id']              = $opid;
            $data["shop_id"]            = $sharShopid;
            $data["comment"]            = $sharComment;
            //店铺评分
            $data["comment_level"]      = $_REQUEST["allsorc"] == "" ? 0 : $_REQUEST["allsorc"];
            //验光分数
            $data["optometry_level"]    = $_REQUEST["yanguangsorc"] == "" ? 0 : $_REQUEST["yanguangsorc"];

            $data["addtime"]            = date('Y-m-d H:i:s');
            $data["openid"]             = $_SESSION[openid];
            $result = $Dao->add($data);
            if (false !== $result) {
                $this->sum_totleSort($data["shop_id"],$data['op_id']);
            } else {
                $this->ajaxReturn("发表失败");
            }
        } else {
            $this->ajaxReturn("发表失败");
        }
    }

    //计算总体评分
    function sum_totleSort($shop_id,$opid) {

        $S = M("shop");
        $com = M("comment");
        $op = M("optometrist");

        $sql_shop = " SELECT AVG(comment_level) as comment_level FROM cms_comment WHERE shop_id = ".$shop_id;

        $sql_op = " SELECT AVG(optometry_level) as optometry_level FROM cms_comment WHERE  op_id=".$opid;

        $result_shop = $com->query($sql_shop);

        $result_op = $op->query($sql_op);

        $data_shop["all_score"] = $result_shop[0]["comment_level"];

        $r1= $S->where("id='" . $shop_id . "'")->save($data_shop);


        $data_op["op_score"] = $result_op[0]["optometry_level"];
        $r2 = $op->where("id='" . $opid . "'")->save($data_op);

        if ($r1 && $r2) {
            $this->ajaxReturn("发表成功");
        } else {
            $this->ajaxReturn("发表失败");
        }
    }

    /**
     * 我的验光师列表
     */
    public function subscribe_detail()
    {
        $optometrist = M("optometrist");
        $optometrist_detail = $optometrist
            ->join('join cms_subscribe on cms_subscribe.opid=cms_optometrist.id')
            ->join('join cms_shop on cms_shop.id=cms_optometrist.shop_id')
            ->field('cms_optometrist.images_url,cms_optometrist.name as oname,cms_optometrist.job,cms_subscribe.*,cms_shop.addr,cms_shop.phone,cms_shop.lon,cms_shop.lat')
            ->where("cms_subscribe.openid = '".$_SESSION['openid']."'")
            ->order("cms_subscribe.id desc")
            ->find();

        $this->assign('detail',$optometrist_detail);
        $this->display();
    }

    //下单成功详情页
    public function subscribe_list()
    {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        $order_sn = $_REQUEST['order_sn'];
        $optometrist = M("optometrist");
        $optometrist_detail = $optometrist
            ->join('cms_subscribe on cms_subscribe.opid=cms_optometrist.id')
            ->field('cms_optometrist.images_url,cms_optometrist.name as oname,cms_optometrist.job,cms_optometrist.shop_id,cms_subscribe.*')
            ->where("cms_subscribe.openid = '".$_SESSION['openid']."'")
            ->order("cms_subscribe.id desc")
            ->select();
        //echo $optometrist->getLastSql();
        $this->assign('datalist', $optometrist_detail);
        $this->display();
    }

    function log_result($file, $word) {
        $fp = fopen($file, "a");
        flock($fp, LOCK_EX);
        fwrite($fp, "执行日期：" . strftime("%Y-%m-%d-%H：%M：%S", time()) . "\n" . $word . "\n\n");
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    //记录支付日志
    public function write_log() {
        /**
         * 通用通知接口demo
         * ====================================================
         * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
         * 商户接收回调信息后，根据需要设定相应的处理流程。
         *
         * 这里举例使用log文件形式记录回调信息。
         */
        //import('@.ORG.wxpay.WxPayPubHelper.demo.log_.php');
        import('@.ORG.wxpay.WxPayPubHelper.WxPayPubHelper');
        //include_once("./log_.php");
        //include_once("../WxPayPubHelper/WxPayPubHelper.php");
        //使用通用通知接口
        $notify = new Notify_pub();

        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if ($notify->checkSign() == FALSE) {
            $notify->setReturnParameter("return_code", "FAIL"); //返回状态码
            $notify->setReturnParameter("return_msg", "签名失败"); //返回信息
        } else {
            $notify->setReturnParameter("return_code", "SUCCESS"); //设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;

        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======
        //以log文件形式记录回调信息
        //$log_ = new Log_();
        $log_name = "./Home/Lib/ORG/wxpay/demo/notify_url.log"; //log文件路径
        $this->log_result($log_name, "【接收到的notify通知】:\n" . $xml . "\n");

        if ($notify->checkSign() == TRUE) {

            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                $this->log_result($log_name, "【通信出错】:\n" . $xml . "\n");
            } elseif ($notify->data["result_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                $this->log_result($log_name, "【业务出错】:\n" . $xml . "\n");
            } else {

                //更新商户订单号到order表,并修改订单状态
                $order = M("subscribe");
                $rs = $order->where("order_sn = '" . $_REQUEST['order_sn'] . "'")->find();

                if ($rs) {
                    $save['trade_no'] = $notify->data["out_trade_no"];
                    $save['pay_status'] = 1;
                    $save['pay_time'] = date('Y-m-d H:i:s');
                    $save['transaction_id'] = $notify->data["transaction_id"];
                    $save['secret_key'] = generate_code(6);
                    $result = $order->where("order_sn = '" . $_REQUEST['order_sn'] . "'")->save($save);
                    if ($result !== false)
                    {
                        send($rs['mobile'], '【滴滴配镜公众号】恭喜你预约成功，预约号为：' . $save['secret_key'] . '，请及时与验光师联系，预约服务时间。【滴滴配镜公众号服务热线0755-26669353】');
                    }
                }

                //此处应该更新一下订单状态，商户自行增删操作
                $this->log_result($log_name, "【支付成功】:" . $order->getLastSql() . "\n" . $xml . "\n");
            }

            //商户自行增加处理流程,
            //例如：更新订单状态
            //例如：数据库操作
            //例如：推送支付完成信息
        }
    }

    //发送手机验证码
    public function get_phone_code()
    {
        $mobile_phone = $_REQUEST['mobile'];
        $code  = send($mobile_phone);

        if ($code == '0')
        {
            echo '10002';//发送失败
        }
        else
        {
            $this->add_mobile_code($mobile_phone,$code);
            echo '10001';//发送成功
        }
    }

    //记录验证码的code
    public function add_mobile_code($mobile_phone,$code)
    {
        $sms_code = M("sms_code");
        $sms_code->add(array('openid'=>$_SESSION['openid'],'mobile_phone'=>$mobile_phone,'phone_code'=>$code));
    }


//    //显示相关店铺详细图片集
//    function showimg() {
//        $id = $_REQUEST["id"];
//        $shop_images = M("shop_images");
//        $data_images = $shop_images->where('shop_id = ' . $id)->select();
//        print_r($data_images);
//        $this->assign('data_images', $data_images);
//        $this->display();
//    }

    /**
     * @title 获取店铺列表
     */
    public function get_shop_seach_list($name) {
        $shop = M("shop");

        $p = $_REQUEST['p'];

        $end = 9;
        $start = $end * $p;

        $data = $shop->join('left JOIN cms_comment ON cms_shop.id=cms_comment.shop_id')
                        ->field('COUNT(cms_comment.shop_id) AS num,cms_shop.*')->where("name like '%" . $name . "%'")->order('cms_shop.id desc')
                        ->group('cms_shop.id')->limit($start . "," . $end)->select();
        $shop_images = M("shop_images");



        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['num'] = !empty($data[$i]['num']) ? $data[$i]['num'] : 0;

            $data_images = $shop_images->where('shop_id = ' . $data[$i]['id'])->find();
            if (!empty($data_images)) {
                $data[$i]['shop_images'] = $data_images['images_url'];
            }
        }

        return $data;
    }

    /**
     * 距离最近
     */
    public function getDitctShopList() {
        //得到当前用户经纬度
        $Dao = M("shop");
        $sort = $_REQUEST["sort"];
        $p = $_REQUEST['page'] == 0 ? 1 : $_REQUEST['page'];
        $lat = $_REQUEST['lat'];
        $lon = $_REQUEST['lon'];

        $this->getNearByIndex($lat, $lon);
        $size = 5;
        if ($sort == 0) {
            //远近排序
            $str = F('user/' . session('openid'));
            for ($i = ($p - 1) * 5; $i < (($p - 1) * 5) + $size; $i++) {
                $strArr[] = $str[$i];
            }
            foreach ($strArr as $v) {
                $condtion["id"] = $v;
                if ($condtion["id"] != "") {
                    $data = $Dao->table("cms_shop as a")->join("left join cms_comment as b on (a.id = b.shop_id) where a.id =" . $condtion["id"])->field("a.*,count(b.id) as num")->find();
                    $results[] = $data;
                }
            }
        }
        echo json_encode($results);
    }

//    /**
//     * 评价最高排序
//     */
//    function sortPingjia() {
//        $Dao = M("shop");
//        $sort = $_REQUEST["sort"];
//        $p = $_REQUEST['page'];
//        $city = $_REQUEST['city'];
//
//        $size = 5;
//
//        $start = ($p - 1) * $size;
//
//        if ($sort == 1) {
//            $d = $Dao->order("all_score desc")->limit($start . "," . $size)->select();
//            $sql = "select * from cms_shop as a ,cms_";
//            //echo $Dao->getLastSql();
//            echo json_encode($d);
//        }
//    }

    /**
     * @title 获取验光师列表
     * @author lizhi
     * @create on 2015-04-25
     */
    public function get_optometrist_list() {
        $shop = M("shop");
        $p = $_REQUEST['p'];

        $end = 9;
        $start = $end * $p;

        $service_id = $_REQUEST['serve'];
        $iscooperate = $_REQUEST['youhui'];
        $sort = $_REQUEST['sort'];
        $distribute = $_REQUEST['distribute'];
        $city = $_REQUEST["city"];
        $lat = $_REQUEST['lat'];
        $lon = $_REQUEST['lon'];

        $where = "cms_shop.city='" . $city . "'";
        $order = 'juli';
/*        if ($service_id) {
            $where .= ' and service_id=' . $service_id;
        }*/
        if ($iscooperate) {
            //$time=date('Y-m-d');
            //$where.=' and activity_id !=' . 10;
            /* $where.=' and start_time<='."'". $time."'" . ' and end_time>='."'" .$time."'"; */
        }

        /*if ($activity) {
            $activity = $activity - 1;
            $where.=' and activity_id=' . $activity;
        }*/

        //评分
        if ($distribute == '0')
        {
            $order = 'op_score desc,juli';
        }
        //资质
        elseif ($distribute == '1')
        {
            $order = 'job asc,juli';
        }
        //附近
        elseif ($distribute == '2')
        {
            $order = 'juli';
        }
        else{
            $order = 'num desc,juli';
        }

        $data = $shop   ->join(' join cms_optometrist on cms_optometrist.shop_id=cms_shop.id')
                        ->join('LEFT  JOIN cms_comment ON cms_optometrist.id=cms_comment.op_id')
                        ->field('cms_optometrist.id,cms_optometrist.name,cms_optometrist.op_score,cms_optometrist.service_price,cms_optometrist.job,cms_optometrist.images_url as op_images_url,cms_optometrist.skill,cms_shop.all_score,cms_shop.lat,cms_shop.lon,COUNT(distinct cms_comment.id) AS num,fun_distance(lat,lon,"' . $lat . '","' . $lon . '") as juli')->order($order)
                        ->where($where)
                        ->group('cms_optometrist.id')->limit($start . " , " . $end)->select();
        //echo $shop->getLastSql();


        //$shop_images = M("shop_images");
        //$by_shop_activity = M("ByShopActivity");
        for ($i = 0; $i < count($data); $i++)
        {

            $data[$i]['num'] = !empty($data[$i]['num']) ? $data[$i]['num'] : 0;
            $data[$i]['skill'] = msubstr($data[$i]['skill'],0,60);

            //$data_images = $shop_images->where('shop_id = ' . $data[$i]['id'])->find();

            $data[$i]['images_url'] = !empty($data['images_url']) ? $data['images_url'] : '';

            //$data_by_shop_activity = $by_shop_activity->where('shop_id=' . $data[$i]['id'])->select();
            //$data_by_shop_activity=$by_shop_activity->where('shop_id=' .$data[$i]['id'])->field('shop_activity')->find();

            //$data[$i]['shop_activity'] = '';
            //$time = date('Y-m-d');
            //foreach ($data_by_shop_activity as $val) {
                /* if($val['start_time']<=$time&&$val['end_time']>=$time)
                  {
                  $data[$i]['shop_activity'].=$val['activity_id'] . ',';
                  } */
                //$data[$i]['shop_activity'].=$val['activity_id'] . ',';
            //}
        }

        echo json_encode($data);
    }

    /**
     * @title 获取店铺列表
     * @author lizhi
     * @create on 2015-04-25
     */
    public function get_shop_list() {
        $shop = M("shop");
        $p = $_REQUEST['p'];

        $end = 9;
        $start = $end * $p;

        $service_id = $_REQUEST['serve'];
        $iscooperate = $_REQUEST['youhui'];
        $sort = $_REQUEST['sort'];
        $activity = $_REQUEST['distribute'];
        $city = $_REQUEST["city"];
        $lat = $_REQUEST['lat'];
        $lon = $_REQUEST['lon'];

        $where = "cms_shop.city='" . $city . "'";
        $order = 'oid desc,juli';

        if ($service_id) {
            $where .= ' and service_id=' . $service_id;
        }
        if ($iscooperate) {
            //$time=date('Y-m-d');
            $where.=' and activity_id !=' . 10;
            /* $where.=' and start_time<='."'". $time."'" . ' and end_time>='."'" .$time."'"; */
        }

        if ($activity) {
            $activity = $activity - 1;
            $where.=' and activity_id=' . $activity;
        }
        if ($sort == '0') {
            $order = 'all_score desc,juli';
        }elseif($sort == '1')
        {
            $order = 'juli';
        }else{
            $order = 'juli';
        }

        $data = $shop->join('left JOIN cms_comment ON cms_shop.id=cms_comment.shop_id')
            ->join(' left join cms_by_shop_service on cms_shop.id=cms_by_shop_service.shop_id')
            ->join(' left join cms_by_shop_activity on cms_shop.id=cms_by_shop_activity.shop_id')
            ->join(' left join (SELECT id as oid,shop_id,MIN(service_price) AS prices FROM cms_optometrist GROUP BY shop_id) as p on p.shop_id=cms_shop.id')
            ->field('p.oid,cms_shop.lat,prices,cms_shop.lon,COUNT(distinct cms_comment.id) AS num,cms_shop.*,fun_distance(lat,lon,"' . $lat . '","' . $lon . '") as juli')->order($order)
            ->where($where)
            ->group('cms_shop.id')->limit($start . " , " . $end)->select();
        //echo $shop->getLastSql();

        $shop_images = M("shop_images");
        $by_shop_activity = M("ByShopActivity");
        for ($i = 0; $i < count($data); $i++) {

            $data[$i]['num'] = !empty($data[$i]['num']) ? $data[$i]['num'] : 0;

            $data_images = $shop_images->where('shop_id = ' . $data[$i]['id'])->find();

            $data[$i]['shop_images'] = !empty($data_images['images_url']) ? $data_images['images_url'] : '';

            $data_by_shop_activity = $by_shop_activity->where('shop_id=' . $data[$i]['id'])->select();
            //$data_by_shop_activity=$by_shop_activity->where('shop_id=' .$data[$i]['id'])->field('shop_activity')->find();

            $data[$i]['shop_activity'] = '';
            $time = date('Y-m-d');
            foreach ($data_by_shop_activity as $val) {
                /* if($val['start_time']<=$time&&$val['end_time']>=$time)
                  {
                  $data[$i]['shop_activity'].=$val['activity_id'] . ',';
                  } */
                $data[$i]['shop_activity'].=$val['activity_id'] . ',';
            }
        }

        echo json_encode($data);
    }
    //获取城市列表
    public function get_city_list($pid = "") {
        //一级城市
        static $cityList = array();
        if ($pid == "") {
            $proList = M("city")->where("pid=1")->select();
            foreach ($proList as $v) {
                $this->get_city_list($v["cid"]);
            }
        } else {
            $cityList[] = M("city")->where("pid='" . $pid . "'")->select();
        }
        return $cityList;
    }

//    function update_city_list() {
//        $city = array();
//        $list = $this->get_city_list();
//        foreach ($list as $v) {
//            foreach ($v as $v1) {
//                $v1[pinyin] = $this->get_pinyin($v1[cname]);
//                $v1["firstChar"] = $this->getfirstchar($this->get_pinyin($v1[cname]));
//                array_push($city, $v1);
//                $city = M("city");
//                $data["pinyin"] = $this->get_pinyin($v1[cname]);
//                $data["firstchar"] = $this->getfirstchar($this->get_pinyin($v1[cname]));
//                $city->where("cid='" . $v1[cid] . "'")->save($data);
//            }
//        }
//    }

    function city_list() {
        $city = M();
        $list = $city->query("SELECT * FROM cms_city  WHERE pinyin<>'' and firstchar<>'' ORDER BY firstchar");
        foreach ($list as $v) {
            if ($v["firstchar"] == "A") {
                $reList["A"][] = $v;
            }
            if ($v["firstchar"] == "B") {
                $reList["B"][] = $v;
            }
            if ($v["firstchar"] == "C") {
                $reList["C"][] = $v;
            }
            if ($v["firstchar"] == "D") {
                $reList["D"][] = $v;
            }
            if ($v["firstchar"] == "E") {
                $reList["E"][] = $v;
            }
            if ($v["firstchar"] == "F") {
                $reList["F"][] = $v;
            }
            if ($v["firstchar"] == "G") {
                $reList["G"][] = $v;
            }
            if ($v["firstchar"] == "H") {
                $reList["H"][] = $v;
            }
            if ($v["firstchar"] == "I") {
                $reList["I"][] = $v;
            }
            if ($v["firstchar"] == "J") {
                $reList["J"][] = $v;
            }
            if ($v["firstchar"] == "K") {
                $reList["K"][] = $v;
            }
            if ($v["firstchar"] == "L") {
                $reList["L"][] = $v;
            }
            if ($v["firstchar"] == "M") {
                $reList["M"][] = $v;
            }
            if ($v["firstchar"] == "N") {
                $reList["N"][] = $v;
            }
            if ($v["firstchar"] == "O") {
                $reList["O"][] = $v;
            }
            if ($v["firstchar"] == "P") {
                $reList["P"][] = $v;
            }
            if ($v["firstchar"] == "Q") {
                $reList["Q"][] = $v;
            }
            if ($v["firstchar"] == "R") {
                $reList["A"][] = $v;
            }
            if ($v["firstchar"] == "T") {
                $reList["T"][] = $v;
            }
            if ($v["firstchar"] == "S") {
                $reList["S"][] = $v;
            }
            if ($v["firstchar"] == "U") {
                $reList["U"][] = $v;
            }
            if ($v["firstchar"] == "V") {
                $reList["V"][] = $v;
            }
            if ($v["firstchar"] == "W") {
                $reList["W"][] = $v;
            }
            if ($v["firstchar"] == "X") {
                $reList["X"][] = $v;
            }
            if ($v["firstchar"] == "Y") {
                $reList["Y"][] = $v;
            }
            if ($v["firstchar"] == "Z") {
                $reList["Z"][] = $v;
            }
        }
        return $reList;
    }

    function getfirstchar($s0) {
        $fchar = ord($s0{0});
        if ($fchar >= ord("A") and $fchar <= ord("z"))
            return strtoupper($s0{0});
        $s1 = iconv("UTF-8", "gb2312", $s0);
        $s2 = iconv("gb2312", "UTF-8", $s1);
        if ($s2 == $s0) {
            $s = $s1;
        } else {
            $s = $s0;
        }
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 and $asc <= -20284)
            return "A";
        if ($asc >= -20283 and $asc <= -19776)
            return "B";
        if ($asc >= -19775 and $asc <= -19219)
            return "C";
        if ($asc >= -19218 and $asc <= -18711)
            return "D";
        if ($asc >= -18710 and $asc <= -18527)
            return "E";
        if ($asc >= -18526 and $asc <= -18240)
            return "F";
        if ($asc >= -18239 and $asc <= -17923)
            return "G";
        if ($asc >= -17922 and $asc <= -17418)
            return "I";
        if ($asc >= -17417 and $asc <= -16475)
            return "J";
        if ($asc >= -16474 and $asc <= -16213)
            return "K";
        if ($asc >= -16212 and $asc <= -15641)
            return "L";
        if ($asc >= -15640 and $asc <= -15166)
            return "M";
        if ($asc >= -15165 and $asc <= -14923)
            return "N";
        if ($asc >= -14922 and $asc <= -14915)
            return "O";
        if ($asc >= -14914 and $asc <= -14631)
            return "P";
        if ($asc >= -14630 and $asc <= -14150)
            return "Q";
        if ($asc >= -14149 and $asc <= -14091)
            return "R";
        if ($asc >= -14090 and $asc <= -13319)
            return "S";
        if ($asc >= -13318 and $asc <= -12839)
            return "T";
        if ($asc >= -12838 and $asc <= -12557)
            return "W";
        if ($asc >= -12556 and $asc <= -11848)
            return "X";
        if ($asc >= -11847 and $asc <= -11056)
            return "Y";
        if ($asc >= -11055 and $asc <= -10247)
            return "Z";
        return null;
    }

    public function get_pinyin($str, $charset = "utf-8") {
        if ($charset != "gb2312") {
            $str = $this->set_char($str, $charset, "gb2312");
            $str = $this->c($str);
            $str = $this->set_char($str, "gb2312", $charset);
        } else {
            $str = $this->c($str);
        }
        return $str;
    }

    private function set_char($str, $charset = "utf-8", $charset_out = "gb2312") {
        if (function_exists('iconv')) {
            $str = iconv($charset, $charset_out, $str);
        } elseif (function_exists("mb_convert_encoding")) {
            $str = mb_convert_encoding($str, $charset_out, $charset);
        }
        return $str;
    }

    private function g($num) {
        if ($num > 0 && $num < 160) {
            return chr($num);
        } elseif ($num < -20319 || $num > -10247) {
            return "";
        } else {
            for ($i = count($this->d) - 1; $i >= 0; $i--) {
                if ($this->d[$i][1] <= $num)
                    break;
            }
            return $this->d[$i][0];
        }
    }

    function order_quxiao() {
        $order = M("order");
        $order_sn = $_REQUEST["goods_sn"];
        $data["order_status"] = 1;
        $order->where("order_sn='" . $order_sn . "' and openid='" . $_SESSION[openid] . "'")->save($data);
        $this->success("取消成功");
    }

    function add_user_vision_info() {
        $user_vision = M("user_vision");
        $img = $user_vision->where("openid='" . $_SESSION[openid] . "'")->find();
        $this->assign("img", array_filter(json_decode($img["images"], true)));
        $this->assign('yin', array_filter(json_decode($img['yinxing'], true)));
        $this->assign('images', $img);
        $this->display();
    }

    function delimg() {
        $time = $_REQUEST["img"];
        $user_vision = M("user_vision");
        $img = $user_vision->where("openid='" . $_SESSION[openid] . "'")->find();
        $list = json_decode($img[images], true);
        foreach ($list as $key => $v) {
            if ($v[time] == $time) {
                $list[$key] = array();
            }
        }
        $data["images"] = json_encode(array_filter($list));
        $img = $user_vision->where("openid='" . $_SESSION[openid] . "'")->save($data);
        if (false !== $img) {
            echo 1;
        }
    }

    function add_jia() {
        $user_vision = M("user_vision");
        $data[openid] = $_SESSION["openid"];
        $data[sph_r] = $_REQUEST["sph_r"];
        $data[sph_l] = $_REQUEST["sph_l"];
        $data[pd] = $_REQUEST["pd"];
        $data[cyl_r] = $_REQUEST["cyl_r"];
        $data[cyl_l] = $_REQUEST["cyl_l"];
        $data[axis_r] = $_REQUEST["axis_r"];
        $data[axis_l] = $_REQUEST["axis_l"];
        $data[xiajiaguang_l] = $_REQUEST["xiajiaguang_l"];
        $data[xiajaguang_r] = $_REQUEST['xiajiaguang_r'];
        $count = $user_vision->where("openid = '" . $data[openid] . "'")->count();
        if ($data[openid] != "") {
            if ($count < 1) {
                $user_vision->data($data)->add();
            } else {
                $user_vision->where("openid = '" . $data[openid] . "'")->save($data);
            }
            $this->success("保存成功 ");
        }
    }

    function add_yin() {
        $user_vision = M("user_vision");
        $data[openid] = $_SESSION["openid"];
        $count = $user_vision->where("openid = '" . $data[openid] . "'")->count();
        $data_y[y_sph_r] = $_REQUEST["y_sph_r"];
        $data_y[y_sph_l] = $_REQUEST["y_sph_l"];
        $data_y[y_cyl_r] = $_REQUEST["y_cyl_r"];
        $data_y[y_cyl_l] = $_REQUEST["y_cyl_l"];
        $data_y[y_axis_r] = $_REQUEST["y_axis_r"];
        $data_y[y_axis_l] = $_REQUEST["y_axis_l"];

        $data[yinxing] = json_encode($data_y);
        if ($data[openid]) {
            if ($count < 1) {
                $user_vision->data($data)->add();
            } else {
                $user_vision->where("openid = '" . $data[openid] . "'")->save($data);
            }
            $this->success("保存成功 ");
        }
    }

    public function upload() {
        if (!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload();
        }
    }

    // 文件上传
    protected function _upload() {
        $weijj = $_GET["_URL_"][2]; //文件夹
        $index_xm = $_GET["_URL_"][3]; //首字母
        import("@.ORG.UploadFile");
        //导入上传类
        $upload = new UploadFile();
        //设置上传文件大小
        $upload->maxSize = 3292200;
        //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg,txt,sql,swf');
        //设置附件上传目录
        $upload->savePath = "./Uploads/$weijj/";
        //设置需要生成缩略图，仅对图像文件有效
        if ($index_xm == 'ad') {
            $upload->thumb = false;
        } else {
            $upload->thumb = true;
        }

        // 设置引用图片类库包路径
        $upload->imageClassPath = '@.ORG.Image';
        //设置需要生成缩略图的文件后缀
        $upload->thumbPrefix = $index_xm . "_"; //生产2张缩略图
        //设置缩略图最大宽度
        $upload->thumbMaxWidth = '4000,1000';
        //设置缩略图最大高度
        $upload->thumbMaxHeight = '4000,1000';
        //设置上传文件规则
        $upload->saveRule = uniqid;
        //删除原图

        if ($index_xm == 'ad') {
            $upload->thumbRemoveOrigin = false;
        } else {
            $upload->thumbRemoveOrigin = true;
        }
        if (!$upload->upload()) {
            //捕获上传异常
            $this->error($upload->getErrorMsg());
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            import("@.ORG.Image");
            //给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
            #Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], '../Uploads/Images/logo2.png');
            $_POST['image'] = $uploadList[0]['savename'];
        }
        //保存当前数据对象
        $data['image'] = $_POST['image'];

        if ($data['image']) {
            if ($index_xm == 'ad') {
                echo $data['image'];
                exit;
            } else {
                echo $index_xm . "_" . $data['image'];
                exit;
            }
        } else {
            echo 0;
            exit; //上传失败
        }
    }

    private function c($str) {
        $ret = "";
        for ($i = 0; $i < strlen($str); $i++) {
            $p = ord(substr($str, $i, 1));
            if ($p > 160) {
                $q = ord(substr($str, ++$i, 1));
                $p = $p * 256 + $q - 65536;
            }
            $ret.=$this->g($p);
        }
        return $ret;
    }

    public function online() {
        $this->display();
    }

    /**
     * 计算两个坐标之间的距离(米)
     * @param float $fP1Lat
     * @param float $fP1Lon 起点(经度)
     * @param float $fP2Lat 终点(纬度)
     * @param float $fP2Lon 终点(经度)
     * @return int
     */
    function distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon) {
        $fEARTH_RADIUS = 6378137;
        //角度换算成弧度
        $fRadLon1 = deg2rad($fP1Lon);
        $fRadLon2 = deg2rad($fP2Lon);
        $fRadLat1 = deg2rad($fP1Lat);
        $fRadLat2 = deg2rad($fP2Lat);
        //计算经纬度的差值
        $fD1 = abs($fRadLat1 - $fRadLat2);
        $fD2 = abs($fRadLon1 - $fRadLon2);
        //距离计算
        $fP = pow(sin($fD1 / 2), 2) +
                cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2 / 2), 2);
        return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
    }

    //转换ID
    function translationToId($name) {
        $mode = M("city");
        $shop = M("shop");


        $results = $mode->where("cname='" . $name . "'")->find();

        if (FALSE !== $results) {
            $data["city_id"] = $results["cid"];
            $data["province_id"] = $results["pid"];

            $shop->where("city='" . $name . "'")->data($data)->save($data);
            $mode->startTrans();
            if ($results) {
                $shop->commit(); //成功则提交
            } else {
                $shop->rollback(); //成功则提交
            }
        }
    }

    /*
     *
     *  首页
     */

    public function news() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }
        $news_id = $this->_get('news_id');
        $this->assign("res", get_news_detail($news_id, 'content'));
        $this->assign("seo_title", '艺筑装饰');
        $this->display();
    }

    /*
     *  validation 验证
     */

    public function validation() {
        //$this->responseMsg();
        //exit;
        $this->TOKEN = 'yzzs825528680';
        //$this->TOKEN = C('TOKEN');
        $this->valid(); #验证
        exit;
        if (strlen($this->_get('key')) == 32) { #验证
            $key = $this->_get('key');
            $admin_id = intval($this->_get('id'));
            $admin = M('admin');
            $admin_res = $admin->field('account')->where("admin_id=$admin_id")->find();
            if ($admin_res) {
                $token = md5('leg3s' . $admin_res['account'] . $admin_id);
                if ($token == $key) {
                    $this->TOKEN = md5($admin_res['account']);
                    //log::write("<br/>TOKEN的值为[" . $this->TOKEN . "]");
                    $this->valid(); #验证
                } else {
                    echo 'illegality';
                }
            } else {
                echo 'error';
            }
            //exit;
        }
    }

    /*
     * 产品套餐
     */

    public function product() {
        $product_list = get_news_type(2, 1, 'type_id,type_name,keywords'); #产品套餐
        $news = M('news');
        $news_where['status'] = array('eq', 1);
        $news_where['is_del'] = array('eq', '0');
        foreach ($product_list as $key => $list) {
            $news_where['type_id'] = array('eq', $list['type_id']);
            $count = $news->where($news_where)->count();
            if ($count < 1) {
                unset($product_list[$key]);
            } else {
                $icon = get_news($list['type_id'], 1, 'icon');
                $product_list[$key]['images'] = C('NEWIMGURL') . $icon[0]['icon'];
                $product_list[$key]['count'] = $count;
            }
        }
        $this->assign("product_list", $product_list);
        $this->assign("seo_title", '产品套餐');
        $this->display();
    }

    public function product_list() {
        $this->assign("product_list", get_news($this->_get('type_id'), 50, 'icon,title'));
        $newstype = M('newstype');
        $type_list = $newstype->field('type_name,keywords,description')->where("type_id=" . $this->_get('type_id'))->find();
        $this->assign("type_list", $type_list);
        $this->assign("seo_title", '产品套餐');
        $this->display();
    }

    /*
     * 作品欣赏
     */

    public function works() {
        $product_list = get_news_type(5, 1, 'type_id,type_name,keywords'); #作品
        $news = M('news');
        $news_where['status'] = array('eq', 1);
        $news_where['is_del'] = array('eq', '0');
        foreach ($product_list as $key => $list) {
            $news_where['type_id'] = array('eq', $list['type_id']);
            $count = $news->where($news_where)->count();
            if ($count < 1) {
                unset($product_list[$key]);
            } else {
                $icon = get_news($list['type_id'], 1, 'icon');
                $product_list[$key]['images'] = C('NEWIMGURL') . $icon[0]['icon'];
                $product_list[$key]['count'] = $count;
            }
        }
        $this->assign("product_list", $product_list);
        $this->assign("seo_title", '作品欣赏');
        $this->display('product');
    }

    /*
     * 店内环境
     */

    public function environment() {
        $product_list = get_news_type(8, 1, 'type_id,type_name,keywords'); #店内环境
        $news = M('news');
        $news_where['status'] = array('eq', 1);
        $news_where['is_del'] = array('eq', '0');
        foreach ($product_list as $key => $list) {
            $news_where['type_id'] = array('eq', $list['type_id']);
            $count = $news->where($news_where)->count();
            if ($count < 1) {
                unset($product_list[$key]);
            } else {
                $icon = get_news($list['type_id'], 1, 'icon');
                $product_list[$key]['images'] = C('NEWIMGURL') . $icon[0]['icon'];
                $product_list[$key]['count'] = $count;
            }
        }
        $this->assign("product_list", $product_list);
        $this->assign("seo_title", '店内环境');
        $this->display('product');
    }

    /*
     * 店内环境
     */

    public function environment_yy() {
        $product_list = get_news_type(27, 1, 'type_id,type_name,keywords'); #店内环境
        $news = M('news');
        $news_where['status'] = array('eq', 1);
        $news_where['is_del'] = array('eq', '0');
        foreach ($product_list as $key => $list) {
            $news_where['type_id'] = array('eq', $list['type_id']);
            $count = $news->where($news_where)->count();
            if ($count < 1) {
                unset($product_list[$key]);
            } else {
                $icon = get_news($list['type_id'], 1, 'icon');
                $product_list[$key]['images'] = C('NEWIMGURL') . $icon[0]['icon'];
                $product_list[$key]['count'] = $count;
            }
        }
        $this->assign("product_list", $product_list);
        $this->assign("seo_title", '酷儿游泳');
        $this->display('product');
    }

    /*
     * 团队风采
     */

    public function team() {
        $product_list = get_news_type(11, 1, 'type_id,type_name,keywords'); #团队风采
        $news = M('news');
        $news_where['status'] = array('eq', 1);
        $news_where['is_del'] = array('eq', '0');
        foreach ($product_list as $key => $list) {
            $news_where['type_id'] = array('eq', $list['type_id']);
            $count = $news->where($news_where)->count();
            if ($count < 1) {
                unset($product_list[$key]);
            } else {
                $icon = get_news($list['type_id'], 1, 'icon');
                $product_list[$key]['images'] = C('NEWIMGURL') . $icon[0]['icon'];
                $product_list[$key]['count'] = $count;
            }
        }
        $this->assign("product_list", $product_list);
        $this->assign("seo_title", '团队风采');
        $this->display('product');
    }

    /*
     * 品牌介绍
     */

    public function brand() {
        $this->assign('brand_list', get_news(17, 10, 'id,title,content'));
        $this->assign("ad_list", get_news(20, 3, 'icon,title'));
        $this->assign("seo_title", '品牌介绍');
        $this->display();
    }

    /*
     * 资讯详情
     */

    public function detail() {
        $list = get_news_detail($this->_get('id'), 'create_time,content,icon,title');
        $this->assign("list", $list);
        $this->assign("seo_title", $list['title']);
        $this->display();
    }

    /*
     * 关于我们
     */

    public function about_us() {
        $code = $this->_get('code');
        if (!empty($code)) {
            $open_id = get_openid($code);
        } elseif (!empty($_GET['weixin_key'])) {
            session('weixin_key', $_GET['weixin_key']);
        }
        $list = get_news(11, 1, 'id,content');
        $this->assign('list', $list);
        $this->display();
    }

    /*
     * 常见问题
     */

    public function question() {
        $code = $this->_get('code');
        if (!empty($code)) {
            $open_id = get_openid($code);
        } elseif (!empty($_GET['weixin_key'])) {
            session('weixin_key', $_GET['weixin_key']);
        }
        $list = get_news(7, 30, 'id,title,content');
        $this->assign('list', $list);
        $this->display();
    }

    public function home() {
        $this->valid(); #验证
        //$this->responseMsg();
    }

    public function valid() {
        $echoStr = $_GET["echostr"];
        $this->TOKEN = 'yzzs825528680';
        //$this->TOKEN = C('TOKEN');
        //valid signature , option
        if ($this->checkSignature()) {
            #M('sign_log')->add(array('content'=>json_encode($_GET)));
            //echo $echoStr;
            $this->responseMsg();
        } else {
            echo 'error';
        }
        exit;
    }

    public function responseMsg() {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $getParam = json_encode($_GET);
        M('sign_log')->add(array('content' => $postStr . '      ' . $getParam));
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $Location_X = $postObj->Location_X;
            $Location_Y = $postObj->Location_Y;

            $time = time();
            $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[%s]]></MsgType><Content><![CDATA[%s]]></Content></xml>";


            $newsTpl = '<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime><![CDATA[%s]]></CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <ArticleCount>1</ArticleCount>
            <Articles>
            <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>
            </Articles>
            </xml> ';
            $event = $postObj->Event;
            if ($event == "LOCATION") {
                $Dao = M("user");
                // 需要更新的数据
                $data['lat'] = "$postObj->Latitude";
                $data['lon'] = "$postObj->Longitude";
                // 更新的条件
                $condition['openid'] = "$fromUsername";
                $Dao->where($condition)->save($data);
            }
            if ($event == "subscribe") { //首次关注
                if (isset($postObj->EventKey) && $postObj->EventKey) {
                    //调试发现，不是扫描二维码进来的数据也会设置eventkey字段，但此值为空
                    $event_key = $postObj->EventKey;
                    $key_arr = explode('_', $event_key);
                    $code_id = $key_arr[1];
                } else {
                    $code_id = 0;
                }

                //$APPID = C('APPID');
                //$SECRET = C('SECRET');
                // $access_token = curl_get("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$SECRET");
                //$access_token = @get_object_vars(@json_decode($access_token));
                $access_token_new = new_getAccessToken();
                //$testUrl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token[access_token]&openid=$fromUsername";
                $user_info = curl_get("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token_new&openid=$fromUsername");
                $user_info = @get_object_vars(@json_decode($user_info));
                $user = M('user');
                $u_where['openid'] = array('eq', "$fromUsername");
                $u_res = $user->field('user_id,tel')->where($u_where)->find();

                if (!$u_res) {
                    //用户不存在
                    $add_data['openid'] = "$fromUsername";
                    $add_data['username'] = $user_info[nickname];
                    $add_data['tel'] = '';
                    $add_data['sex'] = $user_info[sex];
                    $add_data['headimgurl'] = $user_info[headimgurl];
                    $add_data['city_name'] = $user_info[city];
                    //$user_data['nickname']=$ures[nickname];
                    $add_data['create_time'] = time();
                    $add_data['status'] = 0;
                    $user_id = $user->add($add_data);
                    //$contentStr = $user->getLastSql();
                } else {
                    //用户存在

                    $add_data['username'] = $user_info[nickname];
                    $add_data['sex'] = $user_info[sex];
                    $add_data['headimgurl'] = $user_info[headimgurl];
                    $add_data['city_name'] = $user_info[city];
                    $add_data['create_time'] = time();
                    $user->where("user_id=" . $u_res[user_id])->save($add_data);
                    $user_id = $u_res['user_id'];
                    //$contentStr = $user->getLastSql();
                }

                $replyContent = M('reply_config')->limit(1)->select();

                if ($code_id) {
                    $contentStr = $replyContent[0]['reply_code'];
                } else {
                    $contentStr = $replyContent[0]['reply_subscribe'];
                }


                //$contentStr = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$SECRET";
                /* $msgType = "text";
                  $contentStr = $contentStr;
                  echo sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr); */
                $msgType = 'news'; //$lng=114.177244;      #经度(必填  $lat
                $appcontent = '7月1日—7月15日，吐出自己在配镜过程中的各种不爽，吐得认真、吐得响亮、吐得伤心的童鞋将有可能获得土豪金iPhone6（国行16G版）。';
                $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, '『活动开始』千金买“吐”，口水换肾六！', $appcontent, 'http://dd.eyeku.com/Uploads/User/tucao.jpg?v=123456', "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6665fe982e03a365&redirect_uri=http://dd.eyeku.com/index.php/tuchao/shareopenid/{$fromUsername}&response_type=code&scope=snsapi_base&state=1#wechat_redirect");
                echo $resultStr;
            } elseif ($event == 'unsubscribe') {//取消关注，删除该公众号信息
                $user = M('user');
                $u_where['openid'] = array('eq', "$fromUsername");
                $user->where($u_where)->delete();
            } elseif ($event == 'CLICK') {
                $eventKey = $postObj->EventKey;
                $msgType = "text";
                $app_menu = M('app_menu');
                $app_where['key_url'] = array('eq', "$eventKey");
                $app_res = $app_menu->field('name,remark')->where($app_where)->find();
                $appcontent = trim($app_res['remark']);
                if ($eventKey == 'forum') {
                    $msgType = 'news'; //$lng=114.177244;      #经度(必填  $lat
                    $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, '『活动开始』千金买“吐”，口水换肾六！', $appcontent, 'http://dd.eyeku.com/Uploads/User/tucao.jpg?v=123456', "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx6665fe982e03a365&redirect_uri=http://dd.eyeku.com/Activity/show_share_activity/shareopenid/{$fromUsername}&response_type=code&scope=snsapi_base&state=1#wechat_redirect");
                    echo $resultStr;
                    exit;
                }
                if (!empty($appcontent)) {
                    //$contentStr = $appcontent;
                    //$name = $app_res['name'];
                    $contentStr = $appcontent;
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, '你好');
                echo $resultStr;
            } else {
                //处理关键词回复

                /* if (!empty($keyword))
                  { */

                /* $APPID = C('APPID');
                  $SECRET = C('SECRET');
                  $access_token = @curl_get("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$SECRET");
                  $access_token = @get_object_vars(@json_decode($access_token));
                  $send_url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$access_token[access_token]";

                  $contentStr = "1111111111111";
                  $data = '{
                  "touser":"' . $fromUsername . '",
                  "msgtype":"text",
                  "text":
                  {
                  "content":"1234567"
                  }
                  }';
                  //print_r($data);exit;
                  $news_res = @post_curl($send_url, $data); */

                /* $repay_data['content'] = $keyword;
                  $repay_data['openid'] = "$fromUsername";
                  $repay_data['create_time'] = time();
                  $user_reply = M('user_reply');
                  $user_reply->add($repay_data); */


                //}

                /* if (isset($postObj->EventKey)) {
                  $msgType = "text";
                  $contentStr = "ddddddddddddddddddddddddddddddddddddddd";
                  $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                  echo $resultStr;
                  } */

                $keyword = trim($postObj->Content);

                if (!empty($keyword)) {
                    if ($keyword == "街头") {
                        $msgType = 'news'; //$lng=114.177244;      #经度(必填  $lat
                        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType, '街头人体悬浮魔术揭秘↓↓↓', "街头人体悬浮魔术揭秘↓↓↓", 'http://dd.eyeku.com/Uploads/User/get.png', "http://mp.weixin.qq.com/s?__biz=MzA3OTc0MjU2Ng==&mid=206359896&idx=1&sn=774df6095e13911b1610553c3de4639c#rd");
                        echo $resultStr;
                    } else {
                        $result = $this->transmitService($postObj);
                        echo $result;
                    }
                }
            }
        } else {
            echo "";
            exit;
        }
    }

    public function getPersonLocation() {
        //获取个人经纬度
        $Dao = M("user");
        $openIdList = $Dao->where("openid='$_SESSION[openid]]'")->find();
        return $openIdList;
    }

    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = 'yzzs825528680';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    //----------------文本
    private function transmitText($object, $content) {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //-------------------回复多客服消息
    private function transmitService($object) {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    /*
     * 参与评论
     */

    public function comment() {
        if ($_REQUEST["id"]) {
            $Data = M();
            $query = "select * from cms_comment as a ,cms_shop as b where a.shop_id = b.id and b.id=" . $_REQUEST["id"];
            $list = $Data->query($query);
            //评论信息
            $commentData = explode("||", $list[0]["comment"]);
            $this->assign("commentList", $commentData);
            $this->assign("shopid", $_REQUEST["id"]);
            $this->assign("List", $list[0]);
            $this->display();
        }
    }

    /*
     * 分享内容
     */

    public function shar() {
        $sharComment = trim($_REQUEST["sharComment"]);
        $sharShopid = trim($_REQUEST["shopid"]);

        $Dao = M("comment");

        //入库
        if ($sharComment && $sharShopid) {
            $data["shop_id"] = $sharShopid;
            $data["comment"] = $sharComment;
            $data["comment_level"] = $_REQUEST["allsorc"] == "" ? 0 : $_REQUEST["allsorc"];
            $data["service_level"] = $_REQUEST["serversorc"] == "" ? 0 : $_REQUEST["serversorc"];
            $data["optometry_level"] = $_REQUEST["yanguangsorc"] == "" ? 0 : $_REQUEST["yanguangsorc"];
            $data["product_level"] = $_REQUEST["productsorc"] == "" ? 0 : $_REQUEST["productsorc"];
            $data["addtime"] = date('y-m-d h:i:s', time());
            $data["openid"] = $_SESSION[openid];
            $result = $Dao->add($data);
            if (false !== $result) {
                $this->totleSort($data["shop_id"]);
            } else {
                $this->ajaxReturn("发表失败");
            }
        } else {
            $this->ajaxReturn("发表失败");
        }
    }

    //计算总体评分
    function totleSort($shop_id) {
        $S = M("shop");
        $com = M("comment");
        $sql = " SELECT AVG(comment_level) as comment_level , AVG(service_level) as service_level , AVG(optometry_level) as optometry_level,AVG(product_level) as product_level FROM cms_comment WHERE shop_id = '" . $shop_id . "'";
        $result = $com->query($sql);

        $data["all_score"] = $result[0]["comment_level"];
        $data["goods_score"] = $result[0]["product_level"];
        $data["opt_score"] = $result[0]["optometry_level"];
        $data["service_score"] = $result[0]["service_level"];
        $S->where("id='" . $shop_id . "'")->save($data);
        if (false !== $res) {
            $this->ajaxReturn("发表成功");
        } else {
            $this->ajaxReturn("发表失败");
        }
    }

    /*
     * 个人信息
     */

    public function myInfo() {
        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        //微信共享收货地址
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

        // 定义参数
        $timestamp = time();
        $nonceStr = rand(100000, 999999);
        $Parameters = array();
        //===============下面数组 生成SING 使用=====================
        $Parameters['appid'] = $appId;
        $Parameters['url'] = $redirect_uri;
        $Parameters['timestamp'] = "$timestamp";
        $Parameters['noncestr'] = "$nonceStr";
        $Parameters['accesstoken'] = $access_token['access_token'];
        // 生成 SING
        $addrSign = $this->genSha1Sign($Parameters);

        $this->assign('Parameters', $Parameters);
        $this->assign('addrSign', $addrSign);


        $order_sn = $this->_get('order_sn');
        if (!empty($order_sn)) {
            $order = M("order");
            $rs = $order->where("order_sn ='" . $order_sn . "'")->find();
            if ($rs) {
                $wh['pay_status'] = 1;
                $order->save();
            }
        }

        $myInfoData = M("user");
        $data = $myInfoData->where("openid='" . $_SESSION[openid] . "'")->find();


        $sub = M('subscribe');
        $rs = $sub->where('openid = "'.$_SESSION['openid'].'"')->count();
        $this->assign('rs_count',$rs);

        //echo $myInfoData->getLastSql();
        if (false !== $data) {
            $this->assign("infodata", $data);
            $this->display();
        } else {
            $this->error("数据异常");
        }
    }

        function genSha1Sign($Parameters) {
        $signPars = '';
        ksort($Parameters);
        foreach ($Parameters as $k => $v) {
            if ("" != $v && "sign" != $k) {
                if ($signPars == '')
                    $signPars .= $k . "=" . $v;
                else
                    $signPars .= "&" . $k . "=" . $v;
            }
        }
        //$signPars = http_build_query($Parameters);
        $sign = SHA1($signPars);
        $Parameters['sign'] = $sign;
        return $sign;
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

    /*
     * 评论列表
     */

    public function comment_list() {
        // echo "sdfasd";
        $id = $_REQUEST["id"];
        $this->assign("id", $id);
        $this->display();
    }

    /*
     * 搜索
     */

    function search() {
        $this->display();
    }

    /*
     * 搜索Ajax 返回数据
     */

    function searchAjax() {
        $Dao = M();

        //保存个人搜索历史
        $hostory["openid"] = $_SESSION["openid"];
        $hostory["keywords"] = $_REQUEST["keywords"];

        $data = $Dao->query("select * from cms_shop where name like '%" . $_REQUEST["keywords"] . "%'");
        if ($data) {
            echo json_encode($data);
        } else {
            echo "没有找到";
        }
    }

    /*
     *
     */

    function sort_ajax_select() {
        $mod = $_REQUEST["mod"];
        $act = $_REQUEST["act"];
        $page = $_REQUEST["page"];

//       $shop_id = $_REQUEST["shop_id"];
        if ($act == "pingfen") {
            if ($mod == "0") {
                $order = 'order by comment_level desc';
            } else {
                $order = 'order by comment_level desc';
            }
        }
        if ($act == "addtime") {
            if ($mod == "0") {
                $order = 'order by addtime desc';
            } else {
                $order = 'order by addtime asc';
            }
        }
        $pageSize = 10;
        $start = $page * $pageSize;

        $limit = " limit " . $start . "," . $pageSize;
        $shop_id = $_REQUEST["id"];
        $Dao = M("comment");

        $sql = "select * from cms_shop as a ,cms_comment as b where b.shop_id=a.id and a.id=" . $shop_id . " " . $order . $limit;

        $data = $Dao->query($sql);
        foreach ($data as $v) {
            if ($v["openid"] != "") {
                $list["users"] = $this->searchUser($v["openid"]);
            } else {
                $list["users"] = $v["username"];
            }
            $list["addtime"] = $v["addtime"];
            $list["comment_level"] = $v["comment_level"];
            $list["comment"] = $v["comment"];
            $lists[] = $list;
        }

        if (count($data) > 0) {
            echo json_encode($lists);
        } else {
            echo "";
        }
    }

    /*     * ****************************************************************
     * PHP截取UTF-8字符串，解决半字符问题。
     * 英文、数字（半角）为1字节（8位），中文（全角）为3字节
     * @return 取出的字符串, 当$len小于等于0时, 会返回整个字符串
     * @param $str 源字符串
     * $len 左边的子串的长度
     * ************************************************************** */

    function utf_substr($str, $len) {
        for ($i = 0; $i < $len; $i++) {
            $temp_str = substr($str, 0, 1);
            if (ord($temp_str) > 127) {
                $i++;
                if ($i < $len) {
                    $new_str[] = substr($str, 0, 3);
                    $str = substr($str, 3);
                }
            } else {
                $new_str[] = substr($str, 0, 1);
                $str = substr($str, 1);
            }
        }
        return join($new_str);
    }

    function searchUser($openid) {
        $dao = M("user");
        if ($openid != "") {
            $data = $dao->where("openid = '" . $openid . "'")->find();
            return $this->utf_substr($data[username], 3) . "***";
        } else {
            return "未知用户";
        }
    }

    /*
     * 服务类别
     */

    public function service() {
        header("Content-type:text/html;charset=utf-8");
        $m = M('ShopService');
        $res = $m->select();
        /* var_dump($res);
          die('1111'); */
        echo json_encode($res);
    }

    /*
     * 根据服务类别筛选
     */

    public function shopService() {

        $service_id = $_REQUEST['val'];
        // $res=$m->where('service_id='.$service_id)->select();
        $shop = M("shop");
        $data = $shop->join('left JOIN cms_comment ON cms_shop.id=cms_comment.shop_id')->join('left JOIN cms_by_shop_service ON cms_shop.id=cms_by_shop_service.shop_id')->where('service_id=' . $service_id)
                        ->field('COUNT(cms_comment.shop_id) AS num,cms_shop.*')->order('cms_shop.id desc')
                        ->group('cms_shop.id')->select();
        $shop_images = M("shop_images");

        for ($i = 0; $i < count($data); $i++) {

            $data[$i]['num'] = !empty($data[$i]['num']) ? $data[$i]['num'] : 0;

            $data_images = $shop_images->where('shop_id = ' . $data[$i]['id'])->find();
            if (!empty($data_images)) {
                $data[$i]['shop_images'] = $data_images['images_url'];
            }
        }

        echo json_encode($data);
    }

    /*
     * 百度map
     */

    public function map() {
        $lon = $_GET['lon'];
        $lat = $_GET['lat'];
        $this->assign('lon', $lon);
        $this->assign('lat', $lat);

        $this->display();
    }

    /*
     * 周边搜索
     *
     */

    function searchMap() {
        //获取当前经纬度
        /* $localhostIp = $this->get_onlineip();
          $Url = "http://api.map.baidu.com/location/ip?ak=E4805d16520de693a3fe707cdc962045&ip=" . $localhostIp . "&coor=bd09ll";
          $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=I5Szl96uWEjM7K7js6p3D0DI&ip={$getIp}&coor=bd09ll");
          $json = json_decode($content);
          $data[lon] = $json->{'content'}->{'point'}->{'x'};
          $data[lat] = $json->{'content'}->{'point'}->{'y'};
          $data["serachKey"] = "眼镜店";
          $this->assign("data", $data); */
        $this->display('search_map_location');
    }

    /**
     * @title 获取周边店铺信息
     * @author lizhi
     * @create 2015-04-30
     */
    function get_search_map() {
        //生成描点缓存
        $shop = M('shop');
        $city = $_POST["city"];
        $lat = $_REQUEST['lat'];
        $lon = $_REQUEST['lon'];


        $result = $shop->field('name,lon,lat,addr,phone,id,fun_distance(lat,lon,"' . $lat . '","' . $lon . '") as juli')->order("juli asc")->limit(100)->select();
        echo json_encode($result);
    }

    function getNearByIndex($lat, $lon) {

        $Dao = M("shop");
        $data = $Dao->getField('id,lon,lat');
        if ($data !== FALSE) {
            //获取自己当前的经纬度
            //if ($openid != "") {
            // $localData = $Dao->table("user")->where("openid=" . $openid)->find();
            // $local["lon"] = $localData["lon"];
            // $local["lat"] = $localData["lat"];
            // }
            $local["lon"] = $lon;
            $local["lat"] = $lat;
            if (!empty($local)) {
                foreach ($data as $k => $v) {
                    $shopLoction["lon"] = $v["lon"];
                    $shopLoction["lat"] = $v["lat"];
                    $shopLoction["shopid"] = $k;
                    $sortArr[$k] = $this->getDistance($shopLoction, $local);
                }

                asort($sortArr);
                foreach ($sortArr as $k => $v) {
                    $indexArr[] = $k;
                }
                if (session('openid')) {
                    F("user/" . session('openid'), $indexArr);
                } else {
                    //没有设备id，不给于存储
                }
            }
        }
    }

    /**
     *  @desc 根据两点间的经纬度计算距离
     *  @param float $lat 纬度值
     *  @param float $lng 经度值
     */
//    function getDistance($shopLoction, $local) {
//        $earthRadius = 6367000;
//        $lat1 = ($shopLoction[lat] * pi() ) / 180;
//        $lng1 = ($shopLoction[lng] * pi() ) / 180;
//        $lat2 = ($local[lat] * pi() ) / 180;
//        $lng2 = ($local[lng] * pi() ) / 180;
//
//
//        $calcLongitude = $lng2 - $lng1;
//        $calcLatitude = $lat2 - $lat1;
//
//        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
//        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
//        $calculatedDistance = $earthRadius * $stepTwo;
//        return round($calculatedDistance) / 1000;
//    }

    function GetDistance($shopLoction, $local) {
        define('EARTH_RADIUS', 6378.137); //地球半径，假设地球是规则的球体
        define('PI', 3.1415926);
        $len_type = 1;
        $decimal = 2;
        $radLat1 = $shopLoction[lat] * PI() / 180.0;   //PI()圆周率
        $radLat2 = $local[lat] * PI() / 180.0;
        $a = $radLat1 - $radLat2;
        $b = ($shopLoction[lon] * PI() / 180.0) - ($local[lon] * PI() / 180.0);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * EARTH_RADIUS;
        $s = round($s * 1000);
        if ($len_type > 1) {
            $s /= 1000;
        }
        return round($s, $decimal);
    }

    //得到用户位置，获取经纬度
    function get_user_location() {
        $localhostIp = $this->get_onlineip();
        $Url = "http://api.map.baidu.com/location/ip?ak=E4805d16520de693a3fe707cdc962045&ip=" . $localhostIp . "&coor=bd09ll";
        $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=I5Szl96uWEjM7K7js6p3D0DI&ip={$getIp}&coor=bd09ll");
        $json = json_decode($content);
        $localtion[lon] = $json->{'content'}->{'point'}->{'x'};
        $localtion[lat] = $json->{'content'}->{'point'}->{'y'};
        setcookie("openid", $_SESSION["openid"]);
        setcookie("location", $localtion[lon] . "/" . $localtion[alt]);
    }

    function get_onlineip() {
        $onlineip = "";
        if (getenv(HTTP_CLIENT_IP) && strcasecmp(getenv(HTTP_CLIENT_IP), unknown)) {
            $onlineip = getenv(HTTP_CLIENT_IP);
        } elseif (getenv(HTTP_X_FORWARDED_FOR) && strcasecmp(getenv(HTTP_X_FORWARDED_FOR), unknown)) {
            $onlineip = getenv(HTTP_X_FORWARDED_FOR);
        } elseif (getenv(REMOTE_ADDR) && strcasecmp(getenv(REMOTE_ADDR), unknown)) {
            $onlineip = getenv(REMOTE_ADDR);
        } elseif (isset($_SERVER[REMOTE_ADDR]) && $_SERVER[REMOTE_ADDR] && strcasecmp($_SERVER[REMOTE_ADDR], unknown)) {
            $onlineip = $_SERVER[REMOTE_ADDR];
        }
        return $onlineip;
    }

    /* @author weiyuhuang
     * @method 减免送首页实现
     *   */

    Public function activity() {
        $shop_id = $_REQUEST['sid'];
        $activity = M('ByShopActivity');
        $data['shop_id'] = intval($shop_id);
        $actrs = $activity->where($data)->select();
        //echo $activity->getLastSql();
        echo json_encode($actrs);
    }

    function getCity() {
        $lng = $_REQUEST[lng];
        $lat = $_REQUEST[lat];

        if ($lng || $lat) {
            $mapapi = "http://api.map.baidu.com/geocoder?location=" . $lat . "," . $lng . "&coord_type=gcj02&output=json&ak=I5Szl96uWEjM7K7js6p3D0DI";
//            echo $mapapi;
            $addressMes = file_get_contents($mapapi);
            echo $addressMes;
        }
    }

    function newlyCitys() {
        $data[] = $_REQUEST["city"];
        if ($data != "") {
            $results = F($_SESSION[openid] . '/newCity');
            $is_exit = "0";
            foreach ($results as $v) {
                if ($v[0] == $_REQUEST["city"]) {
                    $is_exit = "1";
                }
            }
            if ($is_exit == "0") {
                $results[] = $data;
                F($_SESSION[openid] . '/newCity', $results);
            }
        }
    }

    function order_list() {
        $order = M();
        $openid = $_SESSION["openid"];
        $sql = "SELECT a.pay_status,a.shipping_status,a.fee_price,a.fstcreate,c.goods_img, a.order_sn,a.goods_count,a.goods_price ,b.goods_name,b.goods_id, b.goods_price AS danjia  FROM cms_goods as c ,cms_order AS a ,cms_order_goods AS b WHERE a.order_status='0' and a.openid='" . $openid . "' and a.order_id=b.order_id and c.goods_id = b.goods_id";
        //echo $sql;
        $orderList = $order->query($sql);
        $this->assign("orderList", $orderList);
        $this->display();
    }

    function order_details() {
        $order_sn = $_REQUEST["goods_sn"];
        $openid = $_SESSION["openid"];
        $order = M();
        $sql = "SELECT a.logistics,a.tracking_no,a.fstcreate,a.remark,a.consignee,a.fee_price,a.address,c.goods_img, a.order_sn,a.goods_count,a.goods_price ,b.goods_name,b.goods_id, b.goods_price AS danjia  FROM cms_goods AS c ,cms_order AS a ,cms_order_goods AS b WHERE a.order_sn ='" . $order_sn . "' and a.openid='" . $openid . "' AND a.order_id=b.order_id AND c.goods_id = b.goods_id limit 1";

        $order_details = $order->query($sql);

        $this->assign("kuailist", $this->kuai100($order_details[0][tracking_no]));
        $this->assign("order_details", $order_details);
        $this->display();
    }

    function kuai100($tracking_no) {
        $url = "http://www.kuaidi100.com/query?type=shentong&postid=" . $tracking_no;
        $kuai100list = file_get_contents($url);
        return json_decode($kuai100list, true);
    }

    public function weixin_pay_action() {
        /**
         * JS_API支付demo
         * ====================================================
         * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
         * 成功调起支付需要三个步骤：
         * 步骤1：网页授权获取用户openid
         * 步骤2：使用统一支付接口，获取prepay_id
         * 步骤3：使用jsapi调起支付
         */
        //include_once("../WxPayPubHelper/WxPayPubHelper.php");
        //include_once("../WxPayPubHelper/WxPayPubHelper.php");
        import('@.ORG.wxpay.WxPayPubHelper.WxPayPubHelper');

        //使用jsapi接口
        $jsApi = new JsApi_pub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code'])) {
            //触发微信返回code码
            $url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL_ACTION);
            Header("Location: $url");
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $order_sn = $_REQUEST["order_sn"];

            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
        }

        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();

        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        /* $openid = 'oEw2Ut0xvD3YjW8pQ4C5zoA75B6w';
          $out_trade_no = '123214511223214';
          $jiage=0.1; */

        $order_model = M();
        $sql = "select a.goods_price,a.fee_price,b.goods_name,a.remark from cms_order as a ,cms_order_goods as b where a.order_id = b.order_id and a.order_sn='" . $order_sn . "' limit 1";
        $list = $order_model->query($sql);
        if (!$list) {
            $this->error("对不起，订单出现异常！");
        }

        $totle = number_format($list[0][goods_price] + $list[0][fee_price], 2);

        $unifiedOrder->setParameter("openid", "$openid"); //openid
        $unifiedOrder->setParameter("body", $list[0][goods_name]); //商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
        $unifiedOrder->setParameter("out_trade_no", "$out_trade_no"); //商户订单号
        $unifiedOrder->setParameter("total_fee", 0.1 * 100); //总金额
        $unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL . "/order_sn/{$_SESSION['order_sn']}"); //通知地址
        $unifiedOrder->setParameter("trade_type", "JSAPI"); //交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID

        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);

        $jsApiParameters = $jsApi->getParameters();

        $this->assign('goods_sn', $order_sn);
        $this->assign('totle', $totle);
        $this->assign('remark', $list[0]["remark"]);
        $this->assign('jsApiParameters', $jsApiParameters);
        $this->display('weixin_pay');
    }

    function go_pay() {
        $order_sn = $_REQUEST["order_sn"];

        if ($order_sn) {
            $_SESSION['order_sn'] = $order_sn;
            $_SESSION['title'] = "去支付";
        }
        $this->redirect(" __APP__/goods/weixin_pay");
    }

    function updateImges() {
        $user_vision = M("user_vision");
        $openid = $_SESSION["openid"];
        $rel = $user_vision->where("openid='" . $openid . "'")->find();

        $data[img] = "/Uploads/goods_img/" . $_REQUEST[path];
        $data[time] = time();


        $list = json_decode($rel[images], true);
        $list[] = $data;
        $dataimg[images] = json_encode($list);

        if ($dataimg[images]) {
            $user_vision->where("openid='" . $openid . "'")->save($dataimg);
        }
    }

}
