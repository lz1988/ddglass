<?php
/**
 * @title 微信菜单测试
 * $author lizhi
 * @create on 2015-04-29
 */
define('EARTH_RADIUS', 6378.137);//地球半径，假设地球是规则的球体
define('PI', 3.1415926);

class TestAction extends Action{


    function appmenu()
    {
        header("Content-type: text/html; charset=utf-8");
        $APPID          = C('APPID');
        $APPSECRET      = C('SECRET');

        $TOKEN_URL      = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$APPID."&secret=".$APPSECRET;
        $json           = file_get_contents($TOKEN_URL);
        $result         = json_decode($json,true);
        $ACC_TOKEN      = $result['access_token'];

        $MENU_URL="https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$ACC_TOKEN;
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, $MENU_URL);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
        $menu_json = curl_exec($cu);
        $menu = json_decode($menu_json,true);
        curl_close($cu);
        echo '<pre>';
        print_r($menu);
    }


    function get()
    {
        ECHO $this->distanceBetween(22.531004776305,113.93501562155,22.54308744532,114.02894576129).PHP_EOL;
        echo $this->GetDistance(22.531004776305,113.93501562155,22.54308744532,114.02894576129,1).PHP_EOL;
        echo $this->getDistances(22.531004776305,113.93501562155,22.54308744532,114.02894576129);
    }
    /**
     * 计算两个坐标之间的距离(米)
     * @param float $fP1Lat 起点(纬度)
     * @param float $fP1Lon 起点(经度)
     * @param float $fP2Lat 终点(纬度)
     * @param float $fP2Lon 终点(经度)
     * @return int
     */
    function distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon){
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
        $fP = pow(sin($fD1/2), 2) +
            cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2/2), 2);
        return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
    }


    /**
     * 计算经纬度距离
     * @param $d
     */
    public function rad($d) {
        return $d * 3.1415926535898 / 180.0;
    }
    public function getDistances($lat1, $lng1, $lat2, $lng2)
    {
        $EARTH_RADIUS = 6378.137;
        $radLat1 = $this->rad($lat1);
//echo $radLat1;
        $radLat2 = $this->rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = $this->rad($lng1) - $this->rad($lng2);
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) +
                cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = $s * $EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return $s;
    }



        /**
     *  计算两组经纬度坐标 之间的距离
     *   params ：lat1 纬度1； lng1 经度1； lat2 纬度2； lng2 经度2； len_type （1:m or 2:km);
     *   return m or km
     */
    function GetDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2)
    {
        $radLat1 = $lat1 * PI ()/ 180.0;   //PI()圆周率
        $radLat2 = $lat2 * PI() / 180.0;
        $a = $radLat1 - $radLat2;
        $b = ($lng1 * PI() / 180.0) - ($lng2 * PI() / 180.0);
        $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
        $s = $s * EARTH_RADIUS;
        $s = round($s * 1000);
        if ($len_type --> 1)
        {
            $s /= 1000;
        }
        return round($s, $decimal);
    }

}