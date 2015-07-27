<?php

/**
 * @title 用户评论
 * @author ranlinx
 * @create on  2015.4.15
 * 采集流程：1. 采集市级页面：格式：http://api.map.baidu.com/place/v2/search?ak=I5Szl96uWEjM7K7js6p3D0DI&output=json&query=%E7%9C%BC%E9%95%9C&page_size=1&scope=2&region=成都市
 * 
 * 2.分页 格式 总页数/每页条数 
 * 
 * 3.分页得到的子页面  ：格式：例如第一页面10条眼镜商城信息 
 * 
 * 4.数据重组：采集入库，重组详细页面格式，http://map.baidu.com/detail?qt=ninf&uid=" . $uid;
 * 
 * 5.循环每天商城子页面信息 getMorepage(),采集图片，判断是否被采集过 
 * 
 * 6.入库程序
 *
 */
class CommentAction extends CommonAction {

    public  $xmlAreapath; //地区xml路径
    public $sleep = 2; //随眠时间 
    public $imagesSavePath; //图片路径
    public $handleKey;

    public function __construct() {
        parent::__construct();
        $this->imagesSavePath = "";
        $this->sleep = "";
        $this->xmlAreapath = "";
    }

    //模块首页
    public function index() {
        $this->display();
    }

    function test() {
        echo "采集开始.......</br>";
        $d = "http://map.baidu.com/detail?qt=ninf&uid=b7021bf866cacce3f4e73bc9";
        // $d= "http://api.map.baidu.com/place/detail?uid=b7021bf866cacce3f4e73bc9&output=html&source=placeapi_v2";
        $this->http_get_da($d);
    }

    function http_get_da($output, $shopid) {
        $urlString = "http://map.baidu.com/detail?qt=ninf&uid=" . $output;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlString);
        curl_setopt($ch, CURLOPT_REFERER, "http://api.map.baidu.com");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        $ss = json_decode($data, true);
        foreach ($ss[content][ext][image][top] as $v) {
            $image[] = $v;
        }
        foreach ($image as $k => $v) {
            $this->gettest($v["imgUrl"], $k, $output, $shopid);
        }
    }

    function gettest($url, $k, $output, $shopid) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_REFERER, "http://api.map.baidu.com");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        if (strstr($url, ".jpg")) {
            $data = curl_exec($ch);
            if (!is_dir(UOLOADS_PATH . "shop/shop_images")) {
                $FLAG = mkdir(UOLOADS_PATH . "shop/shop_images", 0777, true);
            }
            $savePath = UOLOADS_PATH . "shop/shop_images/" . $shopid . "_" . $k . ".jpg";
            $this->svaeImgPath($savePath, $shopid);
            file_put_contents(UOLOADS_PATH . "shop/shop_images/" . $shopid . "_" . $k . ".jpg", $data);
        } else {
            $data = curl_exec($ch);
            if (!is_dir(UOLOADS_PATH . "shop/shop_images")) {
                $FLAG = mkdir(UOLOADS_PATH . "shop/shop_images", 0777, true);
            }
            $savePath = UOLOADS_PATH . "shop/shop_images/" . $shopid . "_" . $k . ".jpg";
            $this->svaeImgPath($savePath, $shopid);
            file_put_contents(UOLOADS_PATH . "shop/shop_images/" . $shopid . "_" . $k . ".jpg", $data);
        }
    }

    //保存图片路径
    function svaeImgPath($url, $shopid) {
        $Dao = M("shop_images");
        $data["images_url"] = $url;
        $data["shop_id"] = $shopid;
//       print_r($data);
        $Dao->add($data);
        //echo $Dao->getLastSql();
    }

    /*
     * 采集开始
     */

    public function caiji() {
        $region = trim($_GET["region"]);
        $num = trim($_GET["number"]) == "" ? 20 : $_GET["number"];
        if ($region != "") {
            include PUB_PATH . '/Admin/snoopy/Snoopy.class.php';
            $snoopy = new Snoopy();
            $url = "http://api.map.baidu.com/place/v2/search?ak=I5Szl96uWEjM7K7js6p3D0DI&output=json&query=%E7%9C%BC%E9%95%9C&page_size=1&scope=2&region=" . $region;
            //%E7%9C%BC%E9%95%9C  眼镜     眼科 %e7%9c%bc%e7%a7%91     视光 %e8%a7%86%e5%85%89
            $snoopy->proxy_host = "http://api.map.baidu.com"; //采集主机
            $snoopy->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)"; //用户代理伪装
            $snoopy->referer = $url; //来路信息
            $snoopy->fetchtext($url);
            //转换json 成为数组
            $shopMes = json_decode($snoopy->results, true);
            $size = $this->getConStruct($shopMes["total"]);
            $this->pageInfo($region, $size);
        }
    }

    //page分页信息
    function pageInfo($region, $size) {
        $snoopyInfo = new Snoopy();
        print_r($size);
        $size = $size > 75 ? 75 : $size;
        for ($i = 0; $i < $size - 1; $i++) {
            //开始采集分页
            //echo $i."<br/>";
            $url = "http://api.map.baidu.com/place/v2/search?ak=I5Szl96uWEjM7K7js6p3D0DI&output=json&query=%E7%9C%BC%E9%95%9C&page_num=" . $i . "&scope=2&region=" . $region;
            //如果超过75页，则加入filter=sort_name:price|sort_rule:0      及  filter=sort_name:price|sort_rule:1   即先按价格正序，再按价格倒序  filter=sort_name:overall_rating   comment_num
            $snoopyInfo->fetch($url);
            print_r("</br>第" . $i . "页");
            $data = json_decode($snoopyInfo->results, "true");
            //数组重组
            $this->fomatArr($data, $region);
            exit();
        }
    }

    //页面结构
    function getConStruct($pageMes) {
        if ($pageMes != "") {
            return ceil($pageMes / 10);
        } else {
            return 0;
        }
    }

    /**
     * 重写数组格式，便于重组url得到详情页
     */
    function fomatArr($arr, $region) {
        //       print_r($arr);
        $shop = array();
        if (!empty($arr)) {
            foreach ($arr["results"] as $v) {
                $shopMes["city"] = $region;
                if ($this->issetUid($v["uid"]) < 1) {
                    $shopMes["comment"] = $this->getMorePage($v["uid"]);
                    $shopMes["lat"] = $v["location"][lat];
                    $shopMes["lon"] = $v["location"][lng];
                    $shopMes["all_score"] = $v["detail_info"]["overall_rating"]; // 整体评分
                    $shopMes["service_score"] = $v["detail_info"]["service_rating"]; //服务分  
                    $shopMes["opt_score"] = $v["detail_info"]["environment_rating"]; //环境分
                    $shop[] = $shopMes;
                    $this->insertDb($shop);
//                    echo "本店没有采集过////" . $v["uid"];
                } else {
//                    echo "本店已经采集" . $v["uid"];
                }
            }
        }
    }

    function issetUid($uid) {
        if ($uid) {
            $shop = M("shop");
            $count = $shop->where("uid='" . $uid . "'")->count();
            return $count;
        }
    }

    /*     * *    getMorePage 和  getCommentInfo   返回店铺的详情数组 start    * */

    /**
     * 转到详情页获取店铺详细信息
     */
    function getMorePage($uid) {
        //地址重组
        $url = "http://map.baidu.com/detail?qt=ninf&uid=" . $uid;
        $snoopyComment = new Snoopy();
        $snoopyComment->fetch($url);
        $c = json_decode($snoopyComment->results, true);
        foreach ($c as $v) {

            $shopMes["shop_name"] = $v["name"];
            $shopMes["addr"] = $v["addr"];
            $shopMes["uid"] = $v["uid"];
            $shopMes["phone"] = $v["phone"];
            $shopMes["com"] = $this->getCommentInfo($v["ext"]["review"]); //评论详细列表

            $shopMes["all_score"] = $v["ext"][detail_info][overall_rating];
            $shopMes["service_score"] = $v["ext"][detail_info][service_rating];
            $shopMes["opt_score"] = $v["ext"][detail_info][environment_rating];
            $shopMes["goods_score"] = $v["ext"][detail_info][product_rating];

            $shop[] = $shopMes;
        }
        return $shop;
    }

    //得到详细评论
    function getCommentInfo($arr) {
        if (!empty($arr)) {
            foreach ($arr as $v) {
                $msg[content] = $v["content"];
                $msg[username] = $v["user_name"]; //点评人
                $msg[data] = $v["date"]; //点评时间
                $msg[user_logo] = $v["user_logo"]; //点评时间

                $msg[all_score] = $v["overall_rating"];
                $msg[service_score] = $v["service_rating"];
                $msg[opt_score] = $v["environment_rating"];
                $msg[goods_score] = $v[effect_rating];
                $list[] = $msg;
            }
            return $list;
        }
    }

    /*     * *    getMorePage 和  getCommentInfo   返回店铺的详情数组 end    * */

    /**
     *
     * 入库
     */
    function insertDb($D) {
        $Dao_c = M('comment');
        $Dao = M('shop');
        foreach ($D as $v) {
            $data["uid"] = $v["comment"][0]["uid"];
            $data["lat"] = $v["lat"];
            $data["lon"] = $v["lon"];
            $data["addr"] = $v["comment"][0]["addr"];
            $data["phone"] = $v["comment"][0]["phone"];
            $data["name"] = $v["comment"][0]["shop_name"];
            $data["city"] = $v["city"];
            $data["all_score"] = $v["comment"][0]["all_score"];
            $data["service_score"] = $v["comment"][0]["service_score"];
            $data["opt_score"] = $v["comment"][0]["opt_score"];
            $result = $Dao->add($data);
            $this->http_get_da($data["uid"], $result); // 采集图片
            $this->handleKey = $result;
            echo "<pre>";
            $userComList = $v["comment"][0]["com"];
            print_r($userComList);
            if (count($userComList) > 0) {
                echo $v["comment"][0]["uid"] . "这个店目前有有有评论";
                foreach ($userComList as $usercomval) {
                    $dataComment["comment"] = $usercomval[content];
                    $dataComment["username"] = $this->createphonenum();
                    $dataComment["user_logo"] = $usercomval[user_logo];
                    $dataComment["addtime"] = $usercomval[data];

                    $dataComment["comment_level"] = $usercomval["all_score"];
                    $dataComment["service_level"] = $usercomval["service_score"];
                    $dataComment["optometry_level"] = $usercomval["opt_score"];
                    $dataComment["product_level"] = $usercomval["goods_score"];
                    $dataComment["shop_id"] =  $this->handleKey;
                    $Dao_c->add($dataComment);
                    echo $Dao_c->getLastSql();
                }
            } else {
                echo "<br/>";
                echo $v["comment"][0]["uid"] . "这个店目前没有评论";
                echo "<br/>";
            }
        }
    }

    function createphonenum() {
        $twoArr = array(3, 5, 8);  //手机号的第二位
        $tArr = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);    //手机号第二位为3时，手机号的第3位数据集，以及手机号的第4位到第11位
        $ntArr = array(0, 1, 2, 3, 5, 6, 7, 8, 9);      //手机号第二位不为3时，手机号的第3位数据集
        $phone[0] = 1;                      //手机号第一位必须为1
        for ($j = 1; $j < 11; $j++) {
            if ($j == 1) {
                $t = rand(0, 2);          //随机生成手机号的第二位数字
                $phone[$j] = $twoArr[$t];
            } elseif ($j == 2 && $phone[1] != 3) {     //当第二位不为3时，随机生成其余手机号
                $th = rand(0, 8);
                $phone[$j] = $ntArr[$th];
            } else {                                         //当第二位为3时，随机生成其余手机号
                $th = rand(0, 9);
                $phone[$j] = $tArr[$th];
            }

            if (($j > 3) && ($j < 7)) {
                $phone[$j] = "*";
            }
        }

        return implode("", $phone);          //将手机号数组合并成字符串
    }

    function arrToStr($arr) {
        $str = "";
        if (!empty($arr)) {
            foreach ($arr as $v) {
                $str = $str . $v . "||";
            }
        }
        return $str;
    }

    /**
     * 图片文件存取
     */
//	public function writePic($uid) {
//		$url = "http://map.baidu.com/detail?qt=ninf&uid=".$uid;
//		$snoopy_img = new Snoopy();
//		$snoopy_img->fetch($url);
//		$arr = json_decode($snoopy_img->results,"true");
//		echo '<pre>';
//		print_r($arr["content"]["ext"]["image"]);
//		foreach($arr["content"]["ext"]["image"]["top"] as $v){
//			//echo $v["imgUrl"];
//			$this->saveImgURL($v["link_mobilephone]"]);
//		}
//	}

    /*
     * 图片存储
     */

    //function saveImgURL($urlPath) {
//		$snoopyPage = new Snoopy();
//			$snoopyPage->proxy_host = "http://api.map.baidu.com"; //采集主机
//			$snoopyPage->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)"; //用户代理伪装
//			$snoopyPage->referer = $urlPath; //来路信息
//			$snoopyPage->fetch($urlPath);
//			print_r($snoopyPage->results);
//
//get_file_contents("http://i1.s2.dpfile.com/pc/f4e030b893d1935c357d5cd9dd461322(700x700)/thumb.jpg");
//
//
//    }


    function http_get_data($url) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();

        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $return_content;
    }

    /*     * 采集大众评网站对眼睛的评论信息
     *

      //采集大众评网站对眼睛的评论信息
      public function caiji() {
      include PUB_PATH . '/Admin/Snoopy/Snoopy.class.php';
      $snoopy = new Snoopy();
      $snoopy->proxy_host = "http://t.dianping.com/list/shanghai?q=%E7%9C%BC%E9%95%9C";
      $snoopy->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
      $snoopy->referer = "http://t.dianping.com/list/shanghai?q=%E7%9C%BC%E9%95%9C";
      $linkArr[] = array ();
      if ($snoopy->fetchlinks("http://t.dianping.com/list/shanghai?q=%E7%9C%BC%E9%95%9C")) {
      foreach (array_unique($snoopy->results) as $v) {
      //正则匹配是否包含有deal字符
      if (preg_match("/deal/", $v)) {
      $linkArr[] = $v;
      }
      }
      }
      foreach ($linkArr as $value) {
      if (preg_match("/deal.[0-9]{7}/", $value, $str)) {
      $number[] = str_replace("deal/", "", $str[0]);
      }
      }
      $snoopy1 = new Snoopy();
      $snoopy1->proxy_host = "http://t.dianping.com/ajax/dealGroupShopDetail";
      $snoopy1->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
      $snoopy1->referer = "http://t.dianping.com/";
      foreach ($number as $val) {
      $snoopy1->fetchtext("http://t.dianping.com/ajax/dealGroupShopDetail?dealGroupId=" . $val . "&cityId=1&action=shops&page=1&regionId=0");
      //转换json 数据成php数组
      $jsonCode = json_decode($snoopy1->results, true);
      $shopCommentList["msg"] = $jsonCode[msg][shops];
      $shopCommentList["com"] = $this->acquisitionComment($val);
      $this->acquisitionInsert($shopCommentList);
      }
      }

      //采集评论
      public function acquisitionComment($k) {
      ini_set("memory_limit", '128M');
      $url = 'http://t.dianping.com/ajax/detailDealRate?dealGroupId=' . $k . '&pageNo=1&filtEmpty=1&timestamp=1429154903123';
      $snoopy2 = new Snoopy();
      $snoopy2->proxy_host = "http://t.dianping.com/ajax/dealGroupShopDetail";
      $snoopy2->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
      $snoopy2->referer = "http://t.dianping.com/";
      $snoopy2->fetch($url);
      //开始正则匹配评论内容
      if (preg_match_all('/<div class=\"content\".*?>.*?<\/div>/ism', $snoopy2->results, $v)) {
      $result["comement"] = $v;
      }
      $result["shop_id"] = $k;
      return $result;
      }

      //采集数据入库
      function acquisitionInsert($arr) {
      $Dao = M("comment");
      //插入店面数据
      foreach($arr[msg] as $v ){
      $data["addr"] 	=  !empty($v['address'])?$v['address']:"";
      $data["shop_name"] = $v["branchName"];
      $data["phone"] = $v["contactPhone"];
      $data["comment"] = json_encode($arr["com"][comement][0]);
      $Dao->data($data)->add();
      }
      //插入店面评论数据
      if($lastInsId = $Dao->table("comment")->data($data)->add()){

      echo "插入数据 id 为：$lastInsId";
      } else {
      echo $Dao->getLastSql();

      }
     */


    /*     * **字典表地区服务****** */

    function getXmlArea() {
        $key = $_REQUEST["key"];
        $rank = $_REQUEST["rank"];
        if ($rank == "0") {
            //读取第一级别城市
            $this->xmlAreapath = PUB_PATH . "xml/Provinces.xml";
            $this->readXml($this->xmlAreapath);
        }
    }

    //读取xml
    function readXml($xmlpath) {
        if ($xmlpath) {
            $doc = new DOMDocument('1.0', 'utf-8');
            $doc->formatOutput = true;
            $doc->load($xmlpath);

            $list = simplexml_load_file($xmlpath);
            var_dump($list);
//            foreach ($list[Province] as $key=>$v){
//                //$key pid
//                
//            }
//            echo json_encode($list[Province]);
//        } else {
//            echo json_encode("路径有错误");
//        }
        }
    }

}

?>