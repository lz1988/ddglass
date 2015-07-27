<?php
/*
 * 推广员业绩查询详细订单时使用了
 */
class PayorderViewModel extends ViewModel{
      public $viewFields = array(
        'Payorder'      =>array('pay_ip','description','id','user_id','order_no','amount','pay_status','server_status','is_del','game_id','server_id','start_time','finish_time','_type'=>'LEFT'),
        'Server'        =>array('server_name','_on'=>'Payorder.server_id= Server.server_id','_type'=>'LEFT'),
        'Game'          =>array('rate'=>'game_rate','game_name','_on'=>'Server.game_id= Game.game_id','_type'=>'LEFT'),
        'User'          =>array('account','_on'=>'Payorder.user_id= User.user_id'),
        'Payway'        =>array('rate','payway_name','_on'=>'Payorder.payway_id= Payway.payway_id'), 
     );
} 
?>
  