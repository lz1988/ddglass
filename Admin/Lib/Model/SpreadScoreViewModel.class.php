<?php
/*
 * 推广员业绩查询时使用了
 */
class SpreadScoreViewModel extends ViewModel{
//      public $viewFields = array(
//        'User'      =>array('user_id','account','true_name','status','is_spread','is_del','_type'=>'LEFT'),
//        'UserExtend'=>array('reg_time','_on'=>'User.user_id=UserExtend.user_id','_type'=>'LEFT'),
//        'UserSpread'=>array('(SELECT  count(DISTINCT user_id) FROM cms_payorder where user_id in (SELECT user_id from cms_user_spread where sp_user = User.user_id ) and pay_status = 1 and is_del = 0 )'=>'Recharge_count'
//            ,'(select count(*) from cms_user_spread where sp_user = User.user_id )'=>'sp_count'
//            ,'group_id','sp_money','sp_rate','sp_game_id','sp_user','_on'=>'UserSpread.user_id = User.user_id','_type'=>'LEFT'),
//        'UserGroup' =>array('group_name','_on'=>'UserSpread.group_id = UserGroup.group_id ','_type'=>'LEFT'),
//        'Game'      =>array('game_name','_on'=>'UserSpread.sp_game_id= Game.game_id')
//     );
      public $viewFields = array(
        'User'      =>array('user_id','account','true_name','status','is_spread','is_del','_type'=>'LEFT'),
        'UserExtend'=>array('reg_time','_on'=>'User.user_id=UserExtend.user_id','_type'=>'LEFT'),
        'UserSpread'=>array('group_id','sp_money','sp_rate','sp_game_id','sp_user','_on'=>'UserSpread.user_id = User.user_id','_type'=>'LEFT'),
        'UserGroup' =>array('group_name','_on'=>'UserSpread.group_id = UserGroup.group_id ','_type'=>'LEFT'),
        'Game'      =>array('game_name','_on'=>'UserSpread.sp_game_id= Game.game_id')
     );
} 
?>   