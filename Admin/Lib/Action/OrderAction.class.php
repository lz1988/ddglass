<?php
/**
 * Created by PhpStorm.
 * User: jackwei
 * Date: 2015/6/9
 * Time: 14:06
 */
Class OrderAction extends  CommonAction{
    public  function order_list(){
        import('@.ORG.Page');
        $arr='';
        if($_REQUEST['phone']){

             $arr['mobile']=array('like','%'.$_REQUEST['phone'].'%');
             $this->assign('phone',$_REQUEST['phone']);
        }
        if($_REQUEST['order_sn']){
             $arr['order_sn']=array('like','%'.$_REQUEST['order_sn'].'%');
             $this->assign('order_sn',$_REQUEST['order_sn']);
        }
        if($_REQUEST['consifnee']){
             $arr['consifnee']=array('like','%'.$_REQUEST['consifnee'].'%');
             $this->assign('consifnee',$_REQUEST['consifnee']);
        }
        if($_REQUEST['username']){
             $arr['cms_user.username']=array('like','%'.$_REQUEST['username'].'%');
             $this->assign('username',$_REQUEST['username']);
        }
        if($_REQUEST['datetime']){
             $arr['cms_order.fstcreate']=array('GT',$_REQUEST['datetime']);
             $this->assign('datetime',$_REQUEST['datetime']);
        }
        if(isset($_REQUEST['order_status'])){
             if($_REQUEST['order_status'] !=3) {
                 $order_status=intval($_REQUEST['order_status'])-1;
                 $arr['order_status'] = $order_status;
                 $this->assign('order_status', $_REQUEST['order_status']);
             }else{
                 $this->assign('order_status',$_REQUEST['order_status']);
             }
        }
        if(isset($_REQUEST['shipping_status'])){
            if($_REQUEST['shipping_status'] !=3) {
                $shipping_status=intval($_REQUEST['shipping_status'])-1;
                $arr['shipping_status'] = "$shipping_status";
                $this->assign('shipping_status', $_REQUEST['shipping_status']);
            }else{
                $this->assign('shipping_status',$_REQUEST['shipping_status']);
            }
        }
        if(isset($_REQUEST['pay_status'])){
            if($_REQUEST['pay_status'] !=3) {
                $pay_status=intval($_REQUEST['pay_status'])-1;
                $arr['pay_status'] ="$pay_status";
                $this->assign('pay_status', $_REQUEST['pay_status']);
            }else{
                $this->assign('pay_status',$_REQUEST['pay_status']);
            }
        }


        $order=M('Order');
        $count = $order->where($arr)->count();    //计算总数
        $p = new Page($count, 20);
        $res_order=$order
            ->join('LEFT JOIN cms_user ON cms_user.openid=cms_order.openid')
            ->field('cms_user.username,cms_order.*')
            ->limit($p->firstRow . ',' . $p->listRows)
            ->where($arr)
            ->select();
        //echo $order->getLastSql();
        $page = $p->show();
        $this->assign("page", $page);
        $this->assign('order',$res_order);
        $this->display();

    }
    public function order_detail(){
        $order_id=$_REQUEST['id'];
        $ordergoods=M('OrderGoods');
        $order=M('Order');
        $res_order=$order->where('order_id='.$order_id)->find();
        $res_goods=$ordergoods->where('order_id='.$order_id)->find();
        $this->assign('order',$res_order);
        $this->assign('good',$res_goods);
        $res=$this->track($order_id);


        $this->assign('res',$res);
        $this->display();
    }
    public function order_save(){
        $order_id=$_REQUEST['order_id'];
        $arr['consignee']=$_REQUEST['consignee'];
        $arr['mobile']=$_REQUEST['mobile'];
        $arr['address']=$_REQUEST['address'];
        $arr['zipcode']=$_REQUEST['zipcode'];
        $arr['remark']=$_REQUEST['remark'];
        $arr['order_status']=$_REQUEST['order_status'];
        $arr['shipping_status']=$_REQUEST['shipping_status'];
        $arr['tracking_no']=$_REQUEST['tracking_no'];
        $arr['logistics']=$_REQUEST['logistics'];
        $arr['process_remark']=$_REQUEST['process_remark'];
       

        if($_REQUEST['shipping_status']&&empty($_REQUEST['delivery_time'])){
            $arr['delivery_time']=date('Y-m-d-H-i-s');
        }
        if(!($_REQUEST['shipping_status'])){
            $arr['delivery_time']=NULL;
        }
        //$arr['delivery_time']=$_REQUEST['delivery_time'];
        $arr['fee_price']=$_REQUEST['shiping_fee'];

        //$arr['pay_time']=$_REQUEST['pay_time'];

       /* $data['goods_name']=$_REQUEST['good_name'];
        $data['goods_price']=$_REQUEST['good_price'];
        $data['goods_attr']=$_REQUEST['good_attr'];*/
        $order=M('Order');
      /*  $order_goods=M('OrderGoods');*/
        $res=$order->where('order_id='.$order_id)->save($arr);

      /*  $rs=$order_goods->where('order_id='.$order_id)->save($data);*/
        /*if($res){
            $this->success("修改成功");
        }else{
            $this->error('未修改');
        }*/
        $this->success('修改成功');
    }
    public function order_dele(){
        $order_id=$_REQUEST['id'];
        $order=M('Order');
        $ordergood=M('OrderGoods');
        $rs=M('Order')->where('order_id='.$order_id)->delete();
        $res=M('OrderGoods')->where('order_id='.$order_id)->delete();
        if($rs&&$res){
           /* $this->success('删除成功');*/
            echo 1;
        }else{
            echo 0;
        }
    }

    public function track($track_id){

        $order=M('Order');
        $res=$order->where('order_id='.$track_id)->field('logistics,tracking_no')->find();


        $log=$res['logistics'];
        $t_id=$res['tracking_no'];

        $rs=$this->kuai100($t_id);

        return $rs;

    }

    function kuai100($t_id){

        $url = "http://www.kuaidi100.com/query?type=shentong&postid=".$t_id;
       // echo $url;
        $kuai100list = file_get_contents($url);
        //var_dump($kuai100list);
        return json_decode($kuai100list,true);
//        echo "<pre>";
//        print_r(json_decode($kuai100list,true));

    }
}