<?php

function http_post_data($url, $data = null) {  
        $curl=curl_init();  
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

if(!empty($data)){
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
}


curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($curl);
curl_close($curl);
return $output;
}

if(!empty($_POST['appid'])){ //点击提交按钮后才执行   
	$appid = $_POST['appid'];
	$secret = $_POST['secret'];
        $mark =$_POST['mark'];

$appidurl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
$html = file_get_contents($appidurl);
$html = stripslashes($html);
$html = json_decode($html, true);
//var_dump

$token = $html["access_token"];


$url  = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$token ";

$data = json_encode(array('action_name'=>'QR_LIMIT_SCENE','action_info'=>array('scene'=>array('scene_id'=>$mark))));

$ch = http_post_data($url, $data);  
$ch = json_decode($ch,true);
$ticket = $ch["ticket"];
$src = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";

echo  "<img src='$src' />";

}


?>
<html>
<body>


<form action="" method="post">
Appid：<input type="text" name="appid" value="" /><br />
Secret：<input type="text" name="secret" value="" /><br />
标识：<input type="text" name="mark" value="" /><br />
<input type="submit" name="button" value="获取二维码" />
<img 
</form>

</body>
</html>

