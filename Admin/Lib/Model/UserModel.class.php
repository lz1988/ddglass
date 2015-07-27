<?php
/*
 * 推广员业绩查询时使用了
 */
class UserModel extends Model{
    protected $_validate = array(
        array('true_name', 'require', '宝宝名称不能为空！', 1),//1为必须验证 
    ); 
   
}
?>   