<?php
/*
 * 
 */
class MemberInfoViewModel extends ViewModel{
      public $viewFields = array(
        'User'=>array('user_id','account','password','true_name','email','status','is_spread','identity','sp_qd_id','_type'=>'LEFT'),
        'UserExtend'=>array('phone','sex','nick_name','head_icon','postcode','qq','question','answer','address','reg_time','reg_ip','last_time','last_ip','_on'=>'User.user_id=UserExtend.user_id','_type'=>'LEFT'),
        'UserScore'=>array('score_total','score','_on'=>'User.user_id=UserScore.user_id','_type'=>'LEFT'),
	'UserSpread'=>array('sp_user','group_id','sp_rate','_on'=>'User.user_id=UserSpread.user_id')
      );
} 
?>