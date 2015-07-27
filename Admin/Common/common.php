<?php

function get_city_name($cid3)
{
    //die($cid3);
    $city = M('city');
    $res3 = get_city_pid($cid3);
    $pid3 = $res3['pid'];
    $name3 = $res3['cname'];
    $res2 = get_city_pid($pid3);
    $pid2 = $res2['pid'];
    $name2 = $res2['cname'];
    $res1 = get_city_pid($pid2);

    $name1 = $res1['cname'];
    return $name1 . '   ' . $name2 . '   ' . $name3 . '  ';
}

/**@  根据地区找到PID
 *    cid
 * */
/*function get_city_pid($cid)
{
    $region = M('region');
    $region_res = $region->query("SELECT pid,name FROM `cms_region` where id=$cid");


    if ($region_res[0]['pid'] != 0) {
        return get_city_pid($region_res[0]['pid']);
    } else {
        return $region_res[0]['name'];
    }

}*/
/**@  根据地区找到PID
 *    cid
 * */
function get_city_pid($cid){
    $city=M('city');
    $res=$city->field('pid,cname')->where("cid=$cid")->find();
    //echo $city->getLastSql();
    return $res;
}

/**
 * @param $cid
 * @return mixed
 * @title 获取省，市，区 名称
 * @author lizhi
 */
function get_p_c_d_region($cid)
{
    $city=M('city');
    $res=$city->field('cname')->where("cid=$cid")->find();
    //echo $city->getLastSql();
    return $res['cname'];
}

/**
 * @deprecated 密码加密
 * @param1    password
 * @author    dapeng.chen 2012.12.7
 * @return    加密串
 * **/
function sha1_password($string)
{
    return strtoupper(sha1(trim($string)));
}

/**
 * @deprecated 通过积分得到vip等级
 * @param1    score 积分
 * @author    youxiang.zhang 2012.12.13
 * @return    level vip等级
 * **/
function getVipLevel($score)
{
    $vip_define = M('vip_define');
    $de_where['min_score'] = array('gt', $score);
    $level = $vip_define->field('name')->where($de_where)->order('min_score ASC')->find();
    if (empty($level)) {
        $level = $vip_define->field('name')->order('min_score DESC')->find();
    }
    return $level['name'];
}

/**
 * @deprecated 通过vip等级得到积分区间
 * @param1    level vip等级
 * @author    youxiang.zhang 2012.12.14
 * @return    section 积分区间
 * **/
function getSectionByVipLevel($level)
{
    $model = M('vip_define');
    $vip = $model->select();
    $section = array();
    if ($level == $vip[0]['id']) {
        $section['min'] = 0;
        $section['max'] = $vip[0]['min_score'];
    }
    if ($level == $vip[1]['id']) {
        $section['min'] = $vip[0]['min_score'];
        $section['max'] = $vip[1]['min_score'];
    }
    if ($level == $vip[2]['id']) {
        $section['min'] = $vip[1]['min_score'];
        $section['max'] = $vip[2]['min_score'];
    }
    if ($level == $vip[3]['id']) {
        $section['min'] = $vip[2]['min_score'];
        $section['max'] = '';
    }
    return $section;
}

/**
 * @deprecated 通过user_id得到用户名
 * @param1    user_id 用户ID
 * @author    youxiang.zhang 2012.12.14
 * @return    userName 用户名
 * **/
function getUserNameByID($user_id)
{
    $model = M('user');
    $info = $model->field('account')->where("user_id = $user_id")->find();
    return $info['account'];
}

/**
 * @deprecated 获取当前登陆IP
 * @param1
 * @author
 * @return    IP
 * **/
function get_ip()
{
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

/**
 * @deprecated 游戏服状态
 * @param1
 * @author    dapeng.chen
 * @return    IP
 * **/
function getserver_status($status)
{
    $con_sta = C('GAME_SERVER_STATUS');
    if ($status == 0) {
        echo "<span style='color:red;'>$con_sta[$status]</span>";
    } elseif ($status == 1) {
        echo "<span style='color:#fff;background:#000;padding:2px;'>$con_sta[$status]</span>";
    } elseif ($status == 2) {
        echo "<span style='color:#fff;background:#000;padding:2px;'>$con_sta[$status]</span>";
    } elseif ($status == 3) {
        echo "<span >$con_sta[$status]</span>";
    } elseif ($status == 4) {
        echo "<span >$con_sta[$status]</span>";
    } elseif ($status == 5) {
        echo "<span >$con_sta[$status]</span>";
    } elseif ($status == 6) {
        echo "<span style='color:#fff;background:blue;padding:2px;'>$con_sta[$status]</span>";
    } elseif ($status == 7) {
        echo "<span style='color:#fff;background:green;padding:2px;'>$con_sta[$status]</span>";
    } else {
        echo '错误状态';
    }
}

/**
 * @deprecated IP定位
 * @param1
 * @author    dapeng.chen
 * @return    IP
 * **/
function getip_area($ipadd)
{
//	require_once("./Home/Lib/ORG/IpLocation.class.php");	# 加载充值接口文件
//	$classip = new IpLocation('qqwry.dat'); 
//
//	$area = $classip->getlocation($ipadd); 
//	//mb_convert_encoding($address['area1'],'utf-8','GBK'); 
//		print_r($area);exit;
    import('@.ORG.QQWry');
    $qqwry = new QQWry();
    $area = $qqwry->location($ipadd);
    $area[0] = mb_convert_encoding($area[0], 'utf-8', 'GBK');
    $area[1] = mb_convert_encoding($area[1], 'utf-8', 'GBK');
    return $area;
}

/**
 * @deprecated 删除缓存
 * @param1
 * @author    dapeng.chen
 * @return    删除缓存
 * **/
function del_run($dirUrl)
{
    if ($handle = opendir($dirUrl)) {
        while (false !== ($item = readdir($handle))) {
            if ($item != "." && $item != "..") {
                if (is_dir("$dirUrl/$item")) {
                    del_run("$dirUrl/$item");
                } else {
                    if (unlink("$dirUrl/$item")) {
                        echo "成功删除文件： $dirUrl/$item<br />\n";
                        flush();
                        ob_flush();
                        usleep(100000);
                    }
                }
            }
        }
        closedir($handle);
        if (rmdir($dirUrl)) {
            echo "成功删除目录： $dirUrl<br />\n";
            flush();
            ob_flush();
            usleep(100000);
        }
    }
}


/**
 * 发送Email方法
 * @param $address 收件人地址,可以是多个地址的数组
 * @param $subject 邮件标题
 * @param $body    邮件内容
 * @param $altbody 接收邮箱不兼容HTML时的替换内容
 * @return boolean
 */
function sendmail($address, $subject, $body, $altbody = '请使用兼容HTML格式邮箱.')
{
    vendor('PHPMailer_5_2_1.class#phpmailer');
    $mail = new PHPMailer();
    $mail->IsSMTP(); //设置PHPMailer应用SMTP发送Email
    $mail->CharSet = 'UTF-8';
    $mail->Host = C('LEG_MAIL_HOST'); // 指定邮件服务器
    $mail->Port = C('LEG_MAIL_PORT'); //指定邮件服务器端口
    $mail->SMTPAuth = true; // 开启 SMTP验证
    //设置SMTP用户名和密码
    $mail->Username = C('LEG_MAIL_USERNAME');
    $mail->Password = C('LEG_MAIL_PASSWORD');
    $mail->From = C('LEG_MAIL_ADDRESS_FROM'); //指定发送邮件地址
    $mail->FromName = C('LEG_MAIL_ADDRESS_FROM_NAME'); //为发送邮件地址命名
    if (is_array($address)) {
        foreach ($address as $val) {
            $mail->AddAddress($val);
        }
    } else {
        $mail->AddAddress($address);
    }
    $mail->AddReplyTo(C('LEG_MAIL_ADDRESS_FROM'), C('LEG_MAIL_ADDRESS_FROM_NAME'));

    $mail->WordWrap = C('LEG_MAIL_WORD_WRAP_SIZE'); // 设置自动换行的字符长度为 50
    $mail->IsHTML(C('LEG_MAIL_IS_HTML')); // 设置Email格式为HTML

    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AltBody = $altbody; //当收件人客户端不支持接收HTML格式email时的可替代内容;	
    //发送邮件。
    if (!$mail->Send()) {
        return false; //throw_exception("Mailer Error: " . $mail->ErrorInfo);提示邮箱发送不成功的错误信息
    } else {
        return true;
    }
}

//传入生日得到年龄
function get_age($birthday)
{
    if ($birthday == FALSE) {
        return "无法获取数据";
    }
    $birth = date("Y-n-j", $birthday);
    $day = date("Y-n-j", time());
    $birthList = split('-', $birth);
    $dayList = split('-', $day);
    $year = (int)$dayList[0] - $birthList[0];
    $month = (int)$dayList[1] - $birthList[1];
    $days = (int)$dayList[2] - $birthList[2];
    //如果月数为负数的时候 代表不满一年
    if ($year == 0 && $month == 0) {
        return $days . "天";
    } else {
        if ($month < 0) {
            $year--;
            $month = 12 + $month;
        }
        if ($days > 0) {
            $month++;
        }
        return $year . "年" . $month . "个月";
    }
}


//传入生日得到年龄
function get_orders_user($orders_id)
{
    $orders_user = M('orders_user');
    $user_list = $orders_user->where("orders_id=$orders_id")->select();
    $html = '';
    foreach ($user_list as $list) {
        $html .= '<div>(' . $list['username'] . '),(' . $list['identity'] . '),(' . $list['tel'] . ')</div>';
    }
    return $html;
}

/**
 *  获取项目名
 * return array
 *
 */
function get_project_name($id)
{
    $venues_project = M('venues_project');
    $arr = $venues_project->field('project')->where("venues_id=$id")->select();
    $arr_name = '';
    foreach ($arr as $list) {
        $arr_name[] = $list[project];
    }
    return $arr_name;
}

/**
 *  获取栏目下所有资讯的点击量
 * return array
 *
 */
function get_newstype_num($type_id)
{
    $news = M('news');
    $count = $news->where("type_id=$type_id")->sum('click_num');
    return intval($count);
}

function get_user_reply($openid)
{
    $user_reply = M('user_reply');
    $reply_where['openid'] = array('eq', "$openid");
    $reply_list = $user_reply->field('content,create_time')->where($reply_where)->order('id DESC')->find();
    return $reply_list;
}

function getGuid() {
    $charid = strtoupper(md5(uniqid(mt_rand(), true)));

    $hyphen = chr(45);// "-"
    $uuid = substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);

    return $uuid;
}

function mergecustomerbyid($recordid)
{
    $uploaded = D("Customer_upload");
    $customer = D("Customer");
    $oldprect = D("Member_prect");
    $oldmember = D("Member");
    $oldCommunity = D("Community");
    $updata = $uploaded->where("id={$recordid}")->find();
    $data = $customer->where(" xiaoqu = '{$updata['xiaoqu']}' and  qi = '{$updata['qi']}' and dong = '{$updata['dong']}' and lou = '{$updata['lou']}' and fangjian = '{$updata['fangjian']}' ")->find();

    if ("customer" == "customer") {
        /*添加上传数据*/
        if (is_array($data) && count($data) > 0) {
            /*更新上传数据*/
            if (stripos($data['dianhua'], $updata['dianhua']) === false) {
                if (strlen($data['dianhua']) == 0) {
                    $data['dianhua'] = $updata['dianhua'];
                } else {
                    $data['dianhua'] = $data['dianhua'] . ',' . $updata['dianhua'];
                }
            }
            if (stripos($data['qq'], $updata['qq']) === false) {
                if (strlen($data['qq']) == 0) {
                    $data['qq'] = $updata['qq'];
                } else {
                    $data['qq'] = $data['qq'] . ',' . $updata['qq'];
                }
            }
            if (stripos($data['weixin'], $updata['weixin']) === false) {
                if (strlen($data['weixin']) == 0) {
                    $data['weixin'] = $updata['weixin'];
                } else {
                    $data['weixin'] = $data['weixin'] . ',' . $updata['weixin'];
                }
            }
            $data["id"] = $customer->where("id={$data['id']}")->save($data);

            if ($data["id"] || $data["id"] == 0) {
               //log::write("<br/>" . dump($data, false), "更新客户成功");
            } else {
               //log::write("<br/>" . $customer->getLastSql() . dump($data, false) . dump($updata, false), "更新客户失败");
                return false;
            }
        } else {
            /*添加上传数据*/
            $data['xiaoqu'] = $updata['xiaoqu']; // $v [0]; //创建二维数组
            $data['qi'] = $updata['qi'];
            $data['dong'] = $updata['dong'];
            $data['lou'] = $updata['lou'];
            $data['fangjian'] = $updata['fangjian'];
            $data['geju'] = $updata['geju'];
            $data['mianji'] = $updata['mianji'];
            $data['xingming'] = $updata['xingming'];
            $data['dianhua'] = $updata['dianhua'];
            $data['qq'] = $updata['qq'];
            $data['weixin'] = $updata['weixin'];
            $data["id"] = $customer->add($data);
            if ($data["id"] || $data["id"] == 0) {
               //log::write("<br/>" . dump($data, false), "保存资料成功");
            } else {
               //log::write("<br/>" . $customer->getLastSql() . dump($data, false) . dump($updata, false), "保存资料失败");
                return false;
            }
        }
    }
    $olddataCommunity = $oldCommunity->where(" name = '{$updata['xiaoqu']}' ")->find();
    if ("xiaoqu" == "xiaoqu") {
        /*小区记录*/
        if (is_array($olddataCommunity) && count($olddataCommunity) > 0) {
           //log::write("<br/>" . $olddataCommunity["name"] . "小区已存在", "");
            /*更新小区*/
        } else {
            /*添加小区*/
            $tempring = D("Ring")->find();
            $olddataCommunity['aid'] = $tempring['aid']; // $v [0]; //创建二维数组
            $olddataCommunity['rid'] = $tempring['id'];
            $olddataCommunity['name'] = $updata ['xiaoqu'];
            $olddataCommunity['sort'] = 0;
            $olddataCommunity['status'] = 1;
            $olddataCommunity["id"] = $oldCommunity->add($olddataCommunity);
            if ($olddataCommunity["id"] || $olddataCommunity["id"] == 0) {
               //log::write("<br/>" . dump($olddataCommunity, false), "导入小区成功");
            } else {
               //log::write("<br/>" . $olddataCommunity->getLastSql() . dump($olddataCommunity, false) . dump($updata, false), "导入小区失败");
                return false;
            }
        }
    }

    if ("kehu" == "kehu" && $updata['xingming'] . $updata['dianhua'] != "") {
        $olddatamember = $oldmember->where(" alias = '{$updata['xingming']}' ")->find(); //找到同名的用户
        /*客户记录*/
        if (is_array($olddatamember) && count($olddatamember) > 0) {
            /*更新客户*/
            if (stripos($olddatamember['tel'], $updata['dianhua']) === false) {
                if (strlen($olddatamember['tel']) == 0) {
                    $olddatamember['tel'] = $updata['dianhua'];
                } else {
                    $olddatamember['tel'] = $olddatamember['tel'] . ',' . $updata['dianhua'];
                }
            }
            if (stripos($olddatamember['qq'], $updata['qq']) === false) {
                if (strlen($olddatamember['qq']) == 0) {
                    $olddatamember['qq'] = $updata['qq'];
                } else {
                    $olddatamember['qq'] = $olddatamember['qq'] . ',' . $updata['qq'];
                }
            }
            if (stripos($olddatamember['weixin'], $updata['weixin']) === false) {
                if (strlen($olddatamember['weixin']) == 0) {
                    $olddatamember['weixin'] = $updata['weixin'];
                } else {
                    $olddatamember['weixin'] = $olddatamember['weixin'] . ',' . $updata['weixin'];
                }
            }
            $olddatamember["id"] = $oldmember->where("id={$olddatamember['id']}")->save($olddatamember);
            if ($olddatamember["id"] || $olddatamember["id"] == 0) {
               //log::write("<br/>" . dump($olddatamember, false), "更新客户成功");
            } else {
               //log::write("<br/>" . $oldmember->getLastSql() . dump($olddatamember, false) . dump($updata, false), "更新客户失败");
                return false;
            }
        } else {
            /*添加客户*/
            $olddatamember['username'] = $updata['xingming'] . $updata['qq']; // $v [0]; //创建二维数组
            $olddatamember['password'] = md5('123456');
            $olddatamember['alias'] = $updata ['xingming'];
            $olddatamember['sex'] = '男';
            $olddatamember['email'] = '';
            $olddatamember['tel'] = $updata ['dianhua'];
            $olddatamember['qq'] = $updata ['qq'];
            $olddatamember['weixin'] = $updata ['weixin'];
            $olddatamember['type'] = 1;
            $olddatamember["id"] = $oldmember->add($olddatamember);
            if ($olddatamember["id"] || $olddatamember["id"] == 0) {
               //log::write("<br/>" . dump($olddatamember, false), "导入客户成功");
            } else {
               //log::write("<br/>" . $oldmember->getLastSql() . dump($olddatamember, false) . dump($updata, false), "导入客户失败");
                return false;
            }
        }
        $olddataprect = $oldprect->where(" uid = '{$olddatamember['id']}' ")->find(); //找到同名的用户的订单
        if ("Yuyue" == "Yuyue") {
            /*预约记录*/
            if (is_array($olddataprect) && count($olddataprect) > 0) {
                /*更新预约*/
                if (stripos($olddataprect['tel'], $updata['dianhua']) === false) {
                    if (strlen($olddataprect['tel']) == 0) {
                        $olddataprect['tel'] = $updata['dianhua'];
                    } else {
                        $olddataprect['tel'] = $olddataprect['tel'] . ',' . $updata['dianhua'];
                    }
                }
                if (stripos($olddataprect['qq'], $updata['qq']) === false) {
                    if (strlen($olddataprect['qq']) == 0) {
                        $olddataprect['qq'] = $updata['qq'];
                    } else {
                        $olddataprect['qq'] = $olddataprect['qq'] . ',' . $updata['qq'];
                    }
                }
                if (stripos($olddataprect['weixin'], $updata['weixin']) === false) {
                    if (strlen($olddataprect['weixin']) == 0) {
                        $olddataprect['weixin'] = $updata['weixin'];
                    } else {
                        $olddataprect['weixin'] = $olddataprect['weixin'] . ',' . $updata['weixin'];
                    }
                }
                $olddataprect["id"] = $oldprect->where("id={$olddataprect['id']}")->save($olddataprect);
                if ($olddataprect["id"] || $olddataprect["id"] == 0) {
                   //log::write("<br/>" . dump($olddataprect, false), "导入预约成功");
                } else {
                   //log::write("<br/>" . $oldprect->getLastSql() . dump($olddataprect, false) . dump($updata, false), "导入预约失败");
                    return false;
                }
            } else {
                /*添加预约*/
                $olddataprect['uid'] = $olddatamember["id"]; // $v [0]; //创建二维数组
                $olddataprect['type'] = 1;
                $olddataprect['name'] = $updata ['xiaoqu'] . $olddatamember["username"] . "的预约申请";
                $olddataprect['tel'] = $updata ['dianhua'];
                $olddataprect['ip'] = "";
                $olddataprect['community'] = $updata ['xiaoqu'];
                $olddataprect['qi'] = $updata ['qi'];
                $olddataprect['dong'] = $updata ['dong'];
                $olddataprect['danyuan'] = $updata ['lou'];
                $olddataprect['fangjianhao'] = $updata ['fangjian'];
                $olddataprect['mianji'] = $updata ['mianji'];
                $olddataprect['address'] = $updata ['fangjian'];
                $olddataprect["id"] = $oldprect->add($olddataprect);
                if ($olddataprect["id"] || $olddataprect["id"] == 0) {
                   //log::write("<br/>" . dump($olddataprect, false), "导入预约成功");
                } else {
                   //log::write("<br/>" . $oldprect->getLastSql() . dump($olddataprect, false) . dump($updata, false), "导入预约失败");
                    return false;
                }
            }
        }
    }
   //log::write("<br/>记录" . $recordid, "");
    deletecustomerbyid($recordid);
    return true;
}

function deletecustomerbyid($recordid)
{
    $m = M("Customer_upload");
    $data = $m->find("id='{$recordid}'");
    $data["isdelete"] = "1";
    $olddata = $m->where("id='{$recordid}'")->find();
    if ($m->where("id='{$recordid}'")->save($data)) {
        $differstr = "";
        foreach ($olddata as $oldkey => $oldvalue) {
            if (array_key_exists($oldkey, $data) && $data[$oldkey] != $oldvalue) {
                $differstr .= "修改了[$oldkey]旧值[$oldvalue]新值[$data[$oldkey]]";
            }
        }
        M("Updatelog")->add(array(
            "username" => $_SESSION['home']['username'],
            "tablename" => $m->getModelName(),
            "message" => $differstr,
            "recordid" => $recordid
        ));
        return true;
    } else {
        return false;
    }
}

//后台获取token
function new_getAccessToken() {
    $APPID = C('APPID');
    $SECRET = C('SECRET');
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("access_token.json"));
    if ($data->expire_time < time()) {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$SECRET";
        $res = json_decode(new_httpGet($url));

        ///////////////////////////////
        $fp = fopen("access_admin.txt", "a");
        fwrite($fp, date('Y-m-d H:i:s',time()) . "\n\r");
        fclose($fp);
        ///////////////////////////////

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

function new_httpGet($url) {
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

