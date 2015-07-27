<?php
/* 
 * 
 */ 
class AnalysisDetailViewModel extends ViewModel{
      public $viewFields = array(
		'UserSpread'=>array('sp_user','_type'=>'LEFT'),
		'User'=>array('account','_on'=>'UserSpread.user_id=User.user_id','_type'=>'LEFT'),
		'Payorder'=>array('order_no','amount','server_id','pay_status','start_time','_on'=>'User.user_id=Payorder.user_id','_type'=>'LEFT')
      );
} 
?>