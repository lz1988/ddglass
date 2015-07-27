<?php
/*
 * 订单管理
 */
class InstitutionViewModel extends ViewModel{
      public $viewFields = array(
        'Institution' =>array('id','name','contact','tel','city_id','account_way','end_time','admin_id','_type'=>'LEFT'),
        'region'        =>array('name'=>'cname','_on'=>'Institution.city_id = region.id','_type'=>'LEFT'),
        'Admin'   =>array('account','_on'=>'Admin.admin_id= Institution.admin_id','_type'=>'LEFT'),
     );
} 
?>