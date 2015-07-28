<?php

/**
 * @author andi.chang
 * @uses 橡树平台首页文件
 *
 */
// 本类由系统自动生成，仅供测试用途
class PublicAction extends Action {

    public function _emtpy() {
        $this->redirect('index/index');
    }

    public function _initialize() {

//		
//        $this->assign("header_navigation", $this->header_navigation(C('HEADER_NAVIGATION_ID')));   #网站头部导航  dapeng.chen 2012.12.5
//        
//    	//网站底部的导航
//    	$bottom_navigation = $this->bottom_news();
//    	$this->assign('bottom_navigation',$bottom_navigation);
//        
//    	$news_faq=$this->get_news_faq();
//    	
//    	$this->assign('faq_list',$news_faq);   #faq 信息 2012.12.10 dapeng.chen
//    	
//    	
//    	//网站的客服信息
//    	$this->assign('customer_service',C('CUSTOMER_SERVICE'));//$CUSTOMER_SERVICE defined in /Common/common.php
//    	$this->site_config();
//    	$this->checkAllowedPages();
//    	$this->setReferer();
//    	$islogin=0;
//    	if(!empty($_SESSION['user_id']) AND $_SESSION['user_id']>=1){  #dapeng.chen 是否登陆
//    		$islogin=1;                          #已登陆 
//		    $user_info = $this->get_userinfo();   #获取用户信息
//		    $this->assign('user_info',$user_info);
//		    $this->recently_login_game();  #最近登陆的游戏 
//    	}
//	    $this->system_config();
//		$this->assign("islogin",$islogin);  #dapeng.chen 是否登陆，0未登陆 1 已登陆 
        //$list=get_news(16,5,'icon');

        /* session('openid','oWaRTuAoJ3cnWZEGAyRpwDUuKyK4');
          session('user_id',83);
          session('username','新闻志哥哥'); */


//
       /* session('openid','oZiSRt11N_sUUVCd4kNTzlqOR1Gg');
        session('user_id',666);
        session('username','新闻志哥哥');*/

        //session('openid','2344dd3d546dss1--');
        //session('user_id',1);
        //session('username','dapeng');


        $this->assign("seo_title", '滴滴配镜');

        /* $item_cart = M('item_cart');
          $sub_conut = $item_cart->where('sub_id=' . session('sub.sub_id'))->count();
          $this->assign("sub_conut", intval($sub_conut)); */

          $jssdk = new JSSDK(C('APPID'), C('SECRET'));
          $signPackage = $jssdk->GetSignPackage();
          $this->assign('signPackage', $signPackage);
    }

    /**/

    public function _empty() {
        $this->redirect('Index:index');
    }

    /*     * @  得到地区上面的城市和少省
     *    pid
     * */

    public function get_city($cid3) {
        $city = M('city');
        $pid3 = $this->get_city_pid($cid3);
        if ($pid3 != 0) {
            $city_list3 = $city->where("pid=$pid3 and status=1")->select();

            $cid2 = $city->where("cid=$pid3")->find();

            //$pid2=$this->get_city_pid($city_list3[0]['cid']);
            $city_list2 = $city->where("pid=$cid2[pid] and status=1")->select();
        }
        $city_list = $city->where("pid=1 and status=1")->select();

        $this->assign("city_list1", $city_list);
        $this->assign("city_list2", $city_list2);
        $this->assign("city_list3", $city_list3);
        $this->assign("cid3", $cid3);
        $this->assign("cid2", $pid3);
        $this->assign("cid1", $cid2['pid']);
        /* echo '<pre>';
          print_r($city_list2); */
        //	echo $city_list3[0]['pid'];exit;
    }

    /*     * @  Ajax得到地区上面的城市和少省
     *    pid
     * */

    public function ajaxGetCity($cid3) {
        $cid3 = $this->_post('pid');
        $city = M('city');
        $pid3 = $this->get_city_pid($cid3);
        if ($pid3 != 0) {
            $city_list3 = $city->where("pid=$pid3 and status=1")->select();

            $cid2 = $city->where("cid=$pid3")->find();

            //$pid2=$this->get_city_pid($city_list3[0]['cid']);
            $city_list2 = $city->where("pid=$cid2[pid] and status=1")->select();
        }
        $city_list = $city->where("pid=1 and status=1")->select();

        $this->assign("city_list1", $city_list);
        $this->assign("city_list2", $city_list2);
        $this->assign("city_list3", $city_list3);
        $this->assign("cid3", $cid3);
        $this->assign("cid2", $pid3);
        $this->assign("cid1", $cid2['pid']);
        $arr = array(
            array('1' => $city_list, '2' => $cid2['pid']),
            array('1' => $city_list2, '2' => $pid3),
            array('1' => $city_list3, '2' => $cid3),
        );
        echo json_encode($arr);
        //	echo $city_list3[0]['pid'];exit;
    }

    /*     * @  得到地区上面的城市和少省
     *    pid
     * */

    public function is_pid_get_city() {
        $pid = $this->_post('pid');
        $city = M('city');
        $city_list = $city->where("pid=$pid and status=1")->select();
        echo json_encode($city_list);
    }

    /*     * @  根据地区找到PID
     *    cid
     * */

    public function get_city_pid($cid) {
        $city = M('city');
        $res = $city->field('pid')->where("cid=$cid")->find();
        return $res['pid'];
    }

    function site_config() {
        $site_config = M('advert');
        $data['is_del'] = array('eq', '0');
        $data['status'] = array('eq', '1');
        $data['type_id'] = array('eq', '31');
        $data['open_time'] = array('lt', time());
        $site_info = $site_config->field('large_icon,url')->where($data)->order('sort')->find();
        $this->assign('headerimgurl', C('ADVERTIMGURL'));

        $this->assign("site_info", $site_info);  #dapeng.chen
    }

    public function verify() {
        $type = isset($_GET['type']) ? $_GET['type'] : 'gif';
        import("@.ORG.Image");
        Image::buildImageVerify(4, 1, $type);
    }

    //SEO部分
    public function SeoType($id) {
        $id = trim($id);
        $seo = M("newstype");
        $SEO = $seo->where("type_id=$id")->find();
        $page_SEO[page_title] = $SEO['type_name'];
        $page_SEO[page_keywords] = $SEO['keywords'];
        $page_SEO[page_description] = $SEO['description'];
        return $page_SEO;
    }

    /**
     * 友链
     */
    public function part_link() {
        $all_links = $this->getAllLinks();
        $this->assign("all_links", $all_links);
    }

    /**
     * @deprecated 得到登陆用户信息
     * @param      无
     * @author     dapeng.chen 2012.11.29
     * @return     array
     * * */
    public function get_userinfo() {
        $user_id = session('user_id');
        $user = M('user');
        $user_where['user_id'] = array('eq', $user_id);
        $user_info = $user->field('account,status')->where($user_where)->find();

        return $user_info;
    }

    /**
     * @deprecated 错误提示
     * @param      支付方式ID
     * @author     dapeng.chen 2012.12.1
     * @return     payway_name
     * * */
    public function message($text, $link, $jump) {
        $message['text'] = $text;
        $message['link'] = $link;
        $message['jump'] = $jump;
        $this->assign("message", $message);
        $this->display('Public:message');
    }

    /**
     * @deprecated 首部导航
     * @param      资讯类型
     * @author     dapeng.chen 2012.12.5
     * @return     array
     * * */
    public function header_navigation($type_id) {
        $news = M('news');
        $n_where['type_id'] = array('eq', $type_id);
        $n_where['is_del'] = array('eq', '0');
        $header_info = $news->field('id,title,news_url')->where($n_where)->select();
        return $header_info;
    }

    /**
     * @deprecated 根据新闻ID，找到新闻SEO信息
     * @param      news_id
     * @author     dapeng.chen 2012.12.5
     * @return     array
     * * */
    public function get_news_seo($id) {
        $news = M('news');
        $n_where['id'] = array('eq', $id);
        $n_where['is_del'] = array('eq', '0');
        $seo_info = $news->field('title,subtitle,seo_key,seo_desc')->where($n_where)->find();
        return $seo_info;
    }

    /**
     * @deprecated 判断用户是否登陆
     * @param     无
     * @author    dapeng.chen 2012.12.6
     * @return    true
     * * */
    public function user_is_login() {
        if (empty($_SESSION['user_id']) or $_SESSION['user_id'] < 1) {
            $this->redirect('User/registerOrlogin');
            exit;
        }
        return true;
    }

    /**
     * @deprecated 根据条件查询用户信息
     * @param1    field 要查询的字段 string
     * @param2    $user_where(array)查询条件
     * @param3    $num 查询的数量，多少条
     * @author    dapeng.chen 2012.11.29
     * @return    array
     * * */
    public function get_user_info($field, $user_where) {
        $user = M('user');
        $user_info = $user->field($field)->where($user_where)->find();
        print_r($user_info);
        return $user_info;
    }

    /**
     * @deprecated 查询新闻信息
     * @param      $field ,$where
     * @author     dapeng.chen 2012.12.7
     * @return     array
     * * */
    public function get_news($field, $n_where, $num) {
        $news = M('news');
        if ($num <= 1) {
            $news_info = $news->field($field)->order('sort ASC,create_time DESC')->where($n_where)->find();
        } else {
            $news_info = $news->field($field)->order('sort ASC,create_time DESC')->limit($num)->where($n_where)->select();
        }
        return $news_info;
    }

    /**
     * @deprecated 查询底部导航信息
     * @param
     * @author     dapeng.chen 2012.12.7
     * @return     array
     * * */
    public function bottom_news() {
        /*         * 底部导航 dapeng.chen 2012.12.7 begin* */
        $n_where['is_del'] = array('eq', '0');
        $n_where['status'] = array('eq', '1');
        $n_where['type_id'] = array('eq', C('BOTTOM_NEWS'));
        $top12_news = $this->get_news('title,news_url', $n_where, 8);
        /*         * 底部导航 dapeng.chen 2012.12.7 end* */
        return $top12_news;
    }

    /**
     * @deprecated faq信息
     * @param
     * @author     dapeng.chen 2012.12.10
     * @return     array
     * * */
    public function get_news_faq() {
        $n_where['is_del'] = array('eq', '0');
        $n_where['status'] = array('eq', '1');
        $n_where['type_id'] = array('eq', C('NEWS_FAQ'));
        $faq_news = $this->get_news('title,id', $n_where, 5);
        return $faq_news;
    }

    /**
     * @deprecated 系统信息
     * @param
     * @author     dapeng.chen 2012.12.20
     * @return     array
     * * */
    public function system_config() {
        $seo_info = $this->get_news_seo(C('SEO_INDEX'));    #seo config.php 设置
        $this->assign('seo_info', $seo_info);
    }

    /**
     * @deprecated 微信自动登陆OAuth2.0　
     * @param
     * @author     dapeng.chen 2013.11.20
     * @return     array
     * * */
    public function oauthLogin($redirect_uri) {
        //https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=http://crm.yeezoo.com/index.php/customer/index&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect
    }

    public function verify6() {
        $type = isset($_GET['type']) ? $_GET['type'] : 'gif';
        import("@.ORG.Image");
        Image::buildImageVerify(6, 1, $type);
        exit;
    }

}

//微信方法

class JSSDK {

    private $appId;
    private $appSecret;

    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        //$url = "http://dd.eyeku.com/";
		$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $timestamp = time();
        $nonceStr = $this->createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId" => $this->appId,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string,
            "str"       => $string,

        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("jsapi_ticket.json"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            //$url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
			///////////////////////////////////////////
			/*$fp = fopen("ticket.txt", "a");
            fwrite($fp, date('Y-m-d H:i:s',time()) . ",n");
            fclose($fp);*/
			///////////////////////////////////////////
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->my_time = date('Y-m-d H:i:s',time()+7000);
                $data->jsapi_ticket = $ticket;
				$fp = fopen("jsapi_ticket.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }
        return $ticket;
    }

    private function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("access_token.json"));
        if ($data->expire_time < time()) {
            //$url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
			///////////////
			$fp = fopen("access.txt", "a");
            fwrite($fp, date('Y-m-d H:i:s',time()) . ",n");
            fclose($fp);
			//////////////////////
            $access_token = $res->access_token;	
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->my_time = date('Y-m-d H:i:s',time()+7000);
                $data->access_token = $access_token;
                $fp = fopen("access_token.json", "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    /*     * *
     * POST CURL 数据
     * $gateway url连接  $req_data post数据
     * */

    public function post_curl($gateway, $req_data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $gateway); //配置网关地址
        curl_setopt($ch, CURLOPT_HEADER, 0); //过滤HTTP头
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1); //设置post提交
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req_data); //post传输数据
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //https
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /*     * *
     * get CURL 数据
     * $gateway url连接
     * */

    public function get_curl($url) {
        $curl = curl_init(); # 初始化一个 cURL 对象
        curl_setopt($curl, CURLOPT_URL, $url); # 设置你需要抓取的URL
        curl_setopt($curl, CURLOPT_HEADER, 0); # 设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); # 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //https
        curl_setopt($curl, CURLOPT_POST, 0); //设置post提交
        #ob_start(); # 打开缓冲区
        curl_setopt($ch, CURLOPT_TIMEOUT, 3600);
        $contents = curl_exec($curl);
        #ob_end_clean(); #（或程序执行完毕）之前不会被输出
        curl_close($curl);
        return $contents;
    }

}
