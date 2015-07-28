<?php

class GoodsAction extends PublicAction {

    public $model;

    function __construct() {
        parent::__construct();
        $this->model = M("goods");
    }

    function index() {

        //通过历史推荐过来的goods_id
        if (intval($_GET['goods_id']))
        {
            $where = "is_on_sale = 1 and shop_id <>'' and goods_id=".intval($_GET['goods_id']);
        }
        else
        {
            $where = "is_on_sale=1 and shop_id<>'' and DATE_FORMAT(NOW(),'%Y-%m-%d') BETWEEN start_release_time and end_release_time";
        }

        $list = $this->model->where($where)->find();

        //echo $this->model->getLastSql();
        $colorList = explode("/", $list["color"]);
        $this->assign("colorList", $colorList);
        $this->assign("list", $list);
        $this->display();
    }

    function history() {
        $where = "is_on_sale=1 and TO_DAYS(end_release_time)<=TO_DAYS(CURDATE())";
        $list = $this->model->where($where)->select();
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * @title 加入购物车
     */
    function order() {
        session_start();
        if ($_REQUEST["goods_id"]) {
            $_SESSION['goods_id'] = $_REQUEST["goods_id"]; //商品id
            if ($_REQUEST["goods_name"]) {
                $_SESSION['goods_name'] = $_REQUEST["goods_name"]; //商品名
            }
            if ($_REQUEST["goods_number"]) {
                $_SESSION['goods_number'] = $_REQUEST["goods_number"]; //商品数量
            }
            if ($_REQUEST["market_price"]) {
                $_SESSION['market_price'] = $_REQUEST["market_price"]; //市场价 
            }
            if ($_REQUEST["goods_price"]) {
                $_SESSION['goods_price'] = $_REQUEST["goods_price"]; //商品价格
            }
            if ($_REQUEST["goods_attr"]) {
                $_SESSION['goods_attr'] = $_REQUEST["goods_attr"]; //商品属性 
            }
            if ($_REQUEST["fee_price"]) {
                $_SESSION['fee_price'] = $_REQUEST["fee_price"]; //商品属性 
            }
            $_SESSION['title']  = "您的订单提交成功";
        }
        $this->clearCart();
        $cart["openid"] = $_SESSION["openid"];
        $cart["goods_id"] = $_REQUEST["goods_id"];
        $cart["goods_name"] = $_REQUEST["goods_name"];
        $cart["goods_number"] = $_REQUEST["goods_number"];
        $cart["market_price"] = $_REQUEST["market_price"];
        $cart["goods_price"] = $_REQUEST["goods_price"];
        $cart["goods_attr"] = $_REQUEST["goods_attr"];
        $cart["fee_price"] = $_REQUEST["fee_price"];
        $cartModel = M("cart");
        $count = $this->checkOpenid($cart["openid"]);
        if ($count > 0) {
            $result = $cartModel->data($cart)->add();
            if (false !== $result) {
                echo "0";
            } else {
                $this->error("error");
            }
        }
    }

    //验证openid是否合法
    function checkOpenid($openid) {
        $where = "openid='" . $openid . "'";
        $user = M("user");
        $count = $user->where($where)->count();
        return $count;
    }

    /**
     * 清空以前的openid数据
     */
    function clearCart() {
        $cart["openid"] = $_SESSION["openid"];
        $cartModel = M("cart");
        $cartModel->where("openid='" . $cart["openid"] . "'")->delete();
    }

    /**
     * 加入购物车
     */
    function order_comfirm() {

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
        //订单信息 
        $openid = $_SESSION["openid"];
        $cart = M("cart");
        $goods = M("goods");
        $cartList = $cart->where("openid='" . $openid . "'")->find();
        //商品图片
        $goodslist = $goods->where("goods_id='" . $cartList[goods_id] . "'")->find();
        $this->assign('goods_img', $goodslist[goods_img]);
        $this->assign('totle', $cartList["goods_number"] * $cartList["goods_price"]);
        $this->assign('Parameters', $Parameters);
        $this->assign('cartList', $cartList);
        $this->assign('addrSign', $addrSign);
        $this->display();
    }

    /**
     * 
     * @param type $url
     * @return type
     * @title 提交订单
     * 
     */
    function order_submit() {

        if (session('openid') == '') {
            $code = $this->_get('code');
            if (!empty($code)) {
                $open_id = get_openid($code);
            } elseif (!empty($_GET['openid'])) {
                session('openid', $_GET['openid']);
            }
        }

        if (validate_userinfo($_SESSION['openid']) == false) {
            $this->error("对不起，用户信息存在问题！");
        }

        if (empty($_REQUEST['username']) && empty($_REQUEST['address']) && empty($_REQUEST['code']) && empty($_REQUEST['telNumber'])) {
            $this->error("对不起，收货信息错误！");
        }

        $order = M("order");
        $order_goods_model = M("order_goods");

        //收件人信息
        $data['consignee'] = $_REQUEST['username'];
        $data["address"] = $_REQUEST["address"];
        $data["consignee"] = $_REQUEST["userName"];
        $data["mobile"] = $_REQUEST["telNumber"];
        $data["zipcode"] = $_REQUEST["code"];
        $data["remark"] = $_REQUEST["mark"];

        //订单信息
        $data["openid"] = $_SESSION["openid"];
        $data["goods_count"] = $_SESSION["goods_number"];
        $data["goods_price"] = $_SESSION["goods_price"] * $data["goods_count"];
        $data['order_sn'] = order_no(6);
        $data['fee_price'] = $_SESSION["fee_price"];
        $data['fstcreate'] = date('Y-m-d H:i:s');
        $data['order_status'] = 0; //订单状态
        $data['shipping_status'] = 0; //物流状态
        $data['pay_status'] = 0; //支付状态


        $res = M("cart")->where("openid = '" . $_SESSION[openid] . "'")->find();
        if (count($res) > 0) {
            $order->startTrans();
            $result = $order->data($data)->add();

            $data_goods["order_id"] = $result;
            $data_goods["goods_id"] = $_SESSION['goods_id'];
            $data_goods["goods_name"] = $_SESSION['goods_name'];
            $data_goods["goods_number"] = $_SESSION['goods_number'];
            $data_goods["market_price"] = $_SESSION['market_price'];
            $data_goods["goods_price"] = $_SESSION['goods_price'];
            $data_goods["goods_attr"] = $_SESSION['goods_attr'];
            $data_goods["fee_price"] = $_SESSION['fee_price'];

            $result1 = $order_goods_model->data($data_goods)->add();
            if ($result && $result1) {
                $order->commit(); //成功则提交
            } else {
                // 事务回滚
                $order->rollback();
            }
            if (false !== $result) {
                $_SESSION["order_sn"] = $data['order_sn'];
                $this->redirect("/goods/weixin_pay");
            }
        }
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

    function p($star) {
        echo '<pre>';
        print_r($star);
        echo '</pre>';
    }

    function logtext($content) {
        $fp = fopen("json.ini", "a");
        fwrite($fp, "\r\n" . $content);
        fclose($fp);
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

    //微信支付
    public function weixin_pay() {
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
            $url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
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
        $unifiedOrder->setParameter("total_fee", $totle * 100); //总金额
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

    // 打印log
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
                $order = M("order");
                $rs = $order->where("order_sn = '" . $_REQUEST['order_sn'] . "'")->find();

                if ($rs) {
                    $save['trade_no'] = $notify->data["out_trade_no"];
                    $save['pay_status'] = 1;
                    $save['pay_time'] = date('Y-m-d H:i:s');
                    $save['transaction_id'] = $notify->data["transaction_id"];
                    $order->where("order_sn = '" . $_REQUEST['order_sn'] . "'")->save($save);
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

    /*
     * @name 商品列表
     */

    function goods() {
        $shopping = M("shop");
        $goods_id = $_REQUEST["id"];
        $data = $this->model->where("goods_id='" . $goods_id . "'")->find();
        if (count($data) > 0) {
            $data[shop_id_list] = explode("/", $data[shop_id]);
        }
        //店铺列表
        $shop_list = $this->shoplist($data[shop_id_list]);
        //缩略图
        $thumb = M("goods_thumb");
        $thumbList = $thumb->where("goods_id='" . $goods_id . "'")->select();
        $this->assign("thumbList", $thumbList);
        $this->assign("data", $data);
        $this->assign("shop_list", array_filter($shop_list));
        $this->display();
    }

    //所属店铺列表
//    function shoplist($arr) {
//        $shop = M();
//        if (count($arr) > 0) {
//            foreach ($arr as $v) {
//                if ($v != "") {
//                    $result = $shop->query("SELECT * FROM cms_shop AS a,cms_shop_images AS b WHERE a.id = b.shop_id and a.id='" . $v . "'");
//                }
//                $shopList[] = $result;
//            }
//        }
//        return $shopList;
//    }



    function get_goods_info($order_id) {
        $order_goods = M("order_goods");
        $list = $order_goods->where("order_id='" . $order_id . "'")->find();
        return $list;
    }

    function shoplist() {
        $goods_id = $_REQUEST["id"];
        $shop = M("goods");
        $shopModel = M("shop");
        //$where = 'fun_distance(lat,lon,"22.531179","113.935259") as juli';
        $list = $shop->where("goods_id='" . $goods_id . "'")->find();
        $data = explode("/", $list[shop_id]);

        foreach ($data as $v) {
            if ($v != "") {
                //备注：$lat = $_$_REQUEST["lat"];$lon = $_$_REQUEST["lon"];
                //$result["juli"] = $this->distanceBetween($lat,$lon, $result[lat], $result[lon]) / 1000;
                $result = $shopModel->where("id='" . $v . "'")->find();
                $result["juli"] = $this->distanceBetween("22.531179", "113.935259", $result[lat], $result[lon]) / 1000;
                $result["img"] = $this->shop_images($v);
            }
            if (count($result) > 0) {
                $shopList[] = $result;
            }
        }
        $this->assign("list", $shopList);
        $this->display();
    }

    function shop_images($shop_id) {
        $shop_images = M("shop_images");
        $rel = $shop_images->where("shop_id='" . $shop_id . "'")->find();
        return $rel["images_url"];
    }

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

    //店铺和商品详情
    function info() {

        $shop = M("shop");
        $goods = M("goods");
        $shopimg = M("shop_images");
        $goodsthumb = M("goods_thumb");

        $goods_id = $_REQUEST["goodsid"];
        $shop_id = $_REQUEST["shopid"];
        if ($goods_id != "" && $shop_id != "") {
            //商品详情
            $goodsinfo = $goods->where("goods_id='" . $goods_id . "'")->find();
            //商品缩略图
            $goodsthumbinfo = $goodsthumb->where("goods_id='" . $goods_id . "'")->select();

            //店铺详情
            $shopinfo = $shop->where("id='" . $shop_id . "'")->find();
            //店铺图片
            $shopimminfo = $shopimg->where("shop_id='" . $shop_id . "'")->select();
        }
        if (count($goodsinfo) > 0) {
            $this->assign("goodsinfo", $goodsinfo);
        }
        if (count($shopinfo) > 0) {
            $this->assign("shopinfo", $shopinfo);
        }

        $this->assign("shopimminfo", $shopimminfo);
        $this->assign("goodsthumbinfo", $goodsthumbinfo);
        echo "商品缩略图<pre>";
        print_r($goodsthumbinfo);
        echo "<hr>";

        echo "店铺缩略图<pre>";
        print_r($shopimminfo);
        echo "<hr>";
        $this->display();
    }

    /**
     * @title 店铺列表
     * @author lizhi
     * @create on 2015-06-27
     */
    public function shop_list()
    {
        $this->display('shop_list');
    }

}

?>