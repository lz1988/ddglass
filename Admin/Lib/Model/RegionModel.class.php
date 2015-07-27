<?php
/*
 * 推广员业绩查询时使用了
 */
class RegionModel extends Model{
    protected $_validate = array(
        array('name', 'require', '城市名不能为空！', 1),//1为必须验证 
        array('name', '', '城市名已经存在', 0, 'unique', self::MODEL_INSERT),
    ); 
   
}
?>   