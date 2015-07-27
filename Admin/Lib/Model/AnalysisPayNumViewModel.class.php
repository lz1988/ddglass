<?php
/*
 *  
 */
class AnalysisPayNumViewModel extends ViewModel{ 
      public $viewFields = array(
		'UserSpread'=>array('user_id','sp_user','_type'=>'LEFT'),
        'Payorder'=>array('game_id','order_no','server_id','amount','pay_status','start_time','_on'=>'UserSpread.user_id=Payorder.user_id','_type'=>'LEFT'),
		'User'=>array('account','_on'=>'UserSpread.user_id=User.user_id','_type'=>'LEFT'),
		'UserExtend'=>array('reg_time','reg_ip','last_time','_on'=>'UserSpread.user_id=UserExtend.user_id','_type'=>'LEFT'),
      );
} 
?>