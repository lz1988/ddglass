<?php
/*
 * 订单管理
 */
class OrdermembeViewModel extends ViewModel{
      public $viewFields = array(
        'Orderlog'      =>array('id','order_no','true_name','user_id','name','money','deal_mode','deal_status','deal_time','create_time','admin_id','del_flag','_type'=>'LEFT'),
        'User'        =>array('region_id','_on'=>'Orderlog.user_id= User.user_id','_type'=>'LEFT'),
        'Roleadmin'   =>array('role_id','_on'=>'Orderlog.admin_id= Roleadmin.admin_id','_type'=>'LEFT'),
     );
} 
?>