<?php
/**
 * @title 微信菜单测试
 * $author lizhi
 * @create on 2015-04-29
 */
header("Content-type:text/html;charset=utf-8");
class TestAction extends PublicAction{

    //修改username为空脚本
    function set_userinfo()
    {
        die();
        $APPID = C('APPID');
        $SECRET = C('SECRET');

        $user = M('user');
        $rs = $user->field('user_id,openid')->where('username is NULL and openid <> ""')->select();

        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("access_token.json"));
        $access_token = $data->access_token;

        foreach($rs as $v)
        {

            $user_info = curl_get("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$v[openid]");
            $user_info = @get_object_vars(@json_decode($user_info));

            if (!empty($user_info[nickname]))
            {
                $add_data['username'] = $user_info[nickname];
                $user->where("user_id=" . $v[user_id])->save($add_data);
                echo $user->getLastSql() . "<br/>";
            }

        }
    }

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



    public function index()
    {

        die();
        $user = M("come_order");
        $datalist = $user->order('id desc')->field('openid,weixin_key,username,tel,address,fstcreate')->select();

        $filename = time().".csv";

        $head_array = array('openid'=>'微信id','weixin_key'=>'微信号', 'username'=>'收件人','tel'=>'电话','address'=>'地址','fstcreate'=>'下单时间');

        download_csv($filename,$head_array,$datalist);


        die();


        $str = '1期200栋';
        preg_match('/((.*)期)*(.*)栋/',$str,$match);
        echo '<pre>';
        print_r($match);
        var_dump(!empty($match[1]));
        die();
        $time = time() - strtotime("2015-05-23 00:00:00");
        $get_gift_count = ceil(100 + ($time/60)/10);
        echo $get_gift_count;

        die();
        $str='中文a字1符';
        //计算如下
        echo (strlen($str) + mb_strlen($str,'UTF8')) / 2;

        //phpinfo();
        die();
        if(session('openid')==''){
            $code=$this->_get('code');
            if(!empty($code)){
                $open_id=get_openid($code);
            }elseif(!empty($_GET['openid'])){
                session('openid',$_GET['openid']);
            }
        }

        /*$a = $this->maopao(array(1,4,6,2));
        print_r($a);*/
        $this->assign('jssdk',$this->jssdk());
        $this->display();
    }

    function maopao($a)
    {
        for($i=0;$i<count($a)-1;$i++)
        {
            for($j=0;$j<count($a)-1;$j++)
            {
                if($a[$j]<$a[$j+1])
                {
                    $tmp=$a[$j+1];
                    $a[$j+1]=$a[$j];
                    $a[$j]=$tmp;
                }
            }
        }
        return $a;
    }


    function jssdk(){
        $appid  = C('APPID');
        $secret = C('SECRET');
        $_title = '微信';
        $code = $_GET['code'];//获取code
        $_SESSION['code'] = $code;//设置code缓存给微信付账使用
        $auth = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token
        $jsonauth = json_decode($auth); //对JSON格式的字符串进行编码
        $arrayauth = get_object_vars($jsonauth);//转换成数组
        $openid = $arrayauth['openid'];//输出openid
        $access_token = $arrayauth['access_token'];
        $_SESSION['openid'] = $openid;

        $accesstoken = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."");//获取access_token
        $token = json_decode($accesstoken); //对JSON格式的字符串进行编码
        $t = get_object_vars($token);//转换成数组
        $access_token = $t['access_token'];//输出access_token

        $jsapi = file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi");
        $jsapi = json_decode($jsapi);
        $j = get_object_vars($jsapi);
        $jsapi = $j['ticket'];//get JSAPI

        $time = 14999923234;
        $noncestr= $time;
        $jsapi_ticket= $jsapi;
        $timestamp=$time;
        $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $and = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$noncestr."&timestamp=".$timestamp."&url=".$url."";
        $signature = sha1($and);
        return $signature;
    }

    function images()
    {
        if(session('openid')==''){
            $code=$this->_get('code');
            if(!empty($code)){
                $open_id=get_openid($code);
            }elseif(!empty($_GET['openid'])){
                session('openid',$_GET['openid']);
            }
        }

        $this->assign('jssdk',$this->jssdk());
        $this->display();
    }
}