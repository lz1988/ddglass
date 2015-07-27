<?php
/*
 * 推广员业绩查询时使用了
 */
	class CourseModel extends Model{
    protected $_validate = array(
        array('name', 'require', '课程名不能为空！', 1),//1为必须验证 
        array('institution_id','require','请选择机构！',1), // 当值不为空的时候判断是否在一个范
    ); 
   
}
?>