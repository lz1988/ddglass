<?php
/*
 * 推广员业绩查询时使用了
 */
	class UserLableModel extends Model{
    protected $_validate = array(
        array('name', 'require', '标签名不能为空！', 1),//1为必须验证 
        array('name', '', '标签已经存在', 0, 'unique', self::MODEL_INSERT),
    ); 
   
}
?>   