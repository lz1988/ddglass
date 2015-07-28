<?php
/**
 * @title 眼力测试报告
 * @author lizhi
 * @create on 2015-07-25
 */

class EyereportAction extends PublicAction{

    //欢迎页
    public function index()
    {
        if(session('openid')==''){
            $code=$this->_get('code');
            if(!empty($code)){
                $open_id=get_openid($code);
            }elseif(!empty($_GET['openid'])){
                session('openid',$_GET['openid']);
            }
        }

        $this->display();
    }

    public function result()
    {
       if(session('openid')==''){
            $code=$this->_get('code');
            if(!empty($code)){
                $open_id=get_openid($code);
            }elseif(!empty($_GET['openid'])){
                session('openid',$_GET['openid']);
            }
        }

        if (empty($_SESSION['openid']))
        {
            $this->error("对不起，当前用户权限错误！");
        }

        //获取试题答案
        $user_eyereport = M("user_eyereport");
        $count = $user_eyereport->field('answer')->where('openid = "'.$_SESSION['openid'].'"')->find();

        if ($count) {
            $str = $count['answer'];
        }else {
            $str = $_REQUEST['str'];
            if(empty($str) && strpos($str,',') === false)
            {
                $this->error("对不起，系统出现异常,请稍后再试！");
            }

            $str = substr($str, 0, -1);
            $data['openid'] = $_SESSION['openid'];
            $data['answer'] = $str;
            $user_eyereport->add($data);
        }

        $_str = explode(',', $str);
        foreach ($_str as $k => $v) {
            $k++;
            $result[$k] = strtolower(substr($v, -1, 1));
        }

        $m = M("eye_report");
        $rs = $m->select();
        $newarr = array();

        $num = 0;
        foreach($rs as $k=>$v){
            $newarr[$v['pid']][$v['option_letter']] = $v;
        }

        $a1 = '1';
        $a2 = '2';
        $a3 = '3';
        $a4 = '4';
        $a5 = '5';
        $a6 = '6';
        $a7 = '7';
        $a8 = '8';
        $a9 = '9';
        $a10 = '10';
        $a11 = '11';

        //计算分数
        $num =  $newarr[$a1][$result[$a1]]['score'] +
                $newarr[$a2][$result[$a2]]['score'] +
                $newarr[$a3][$result[$a3]]['score'] +
                $newarr[$a4][$result[$a4]]['score'] +
                $newarr[$a5][$result[$a5]]['score'] +
                $newarr[$a6][$result[$a6]]['score'] +
                $newarr[$a7][$result[$a7]]['score'] +
                $newarr[$a8][$result[$a8]]['score'] +
                $newarr[$a9][$result[$a9]]['score'] +
                $newarr[$a10][$result[$a10]]['score'] +
                $newarr[$a11][$result[$a11]]['score'];


        $chenghu = $newarr[$a11][$result[$a11]]['type2'];
        $pingfen = $num;
        $zonghegaishu = $newarr[$a2][$result[$a2]]['type3'];

        //验光方式
        $yangaungjianyi = $newarr[$a7][$result[$a7]]['type1'];
        $yanguangfangshi = $newarr[$a11][$result[$a11]]['type1'];
        $yanguangshijian = $newarr[$a11][$result[$a11]]['type3'];
        $yangunagchufang = $newarr[$a11][$result[$a11]]['type4'];
        $tuisonglianjie = $newarr[$a11][$result[$a11]]['type5'];//推送链接

        //镜框选择建议
        $jingkuangdaxiao = $newarr[$a2][$result[$a2]]['type2'];
        $jingkuangjiegou = $newarr[$a5][$result[$a5]]['type2'];
        $tuisonglianjie2 = $newarr[$a2][$result[$a2]]['type6'];

        //镜片选择建议
        $jingpianleixing = '22222';
        $jingpianzheshelv = $newarr[$a2][$result[$a2]]['type1'];
        $jingpiangongneng = $newarr[$a6][$result[$a6]]['type1'];
        $tuisonglianjie3 = $newarr[$a2][$result[$a2]]['type5'];

        //用眼习惯建议
        $yongyanshijian = $newarr[$a6][$result[$a6]]['type2'];
        $yongyanzishi = $newarr[$a5][$result[$a5]]['type1'];
        $yongyanhuanjing = '用眼环境';
        $tuisonglianjie4 = $newarr[$a6][$result[$a6]]['type5'];

        //饮食建议
        $tuisonglianjie5 = $newarr[$a9][$result[$a9]]['type5'];

        //猜想你想知道
        $tuisonglianjie6 = $newarr[$a10][$result[$a10]]['type5'];

        $this->assign('chenghu',$chenghu);
        $this->assign('pingfen',$pingfen);
        $this->assign('zonghegaishu',$zonghegaishu);

        $this->assign('yangaungjianyi',$yangaungjianyi);
        $this->assign('yanguangfangshi',$yanguangfangshi);
        $this->assign('yanguangshijian',$yanguangshijian);
        $this->assign('yangunagchufang',$yangunagchufang);
        $this->assign('tuisonglianjie',$tuisonglianjie);

        $this->assign('jingkuangdaxiao',$jingkuangdaxiao);
        $this->assign('jingkuangjiegou',$jingkuangjiegou);
        $this->assign('tuisonglianjie2',$tuisonglianjie2);


        $this->assign('jingpianleixing',$jingpianleixing);
        $this->assign('jingpianzheshelv',$jingpianzheshelv);
        $this->assign('jingpiangongneng',$jingpiangongneng);
        $this->assign('tuisonglianjie3',$tuisonglianjie3);


        $this->assign('yongyanshijian',$yongyanshijian);
        $this->assign('yongyanzishi',$yongyanzishi);
        $this->assign('yongyanhuanjing',$yongyanhuanjing);
        $this->assign('tuisonglianjie4',$tuisonglianjie4);

        $this->assign('tuisonglianjie5',$tuisonglianjie5);

        $this->assign('tuisonglianjie6',$tuisonglianjie6);

        $this->display();
    }

}