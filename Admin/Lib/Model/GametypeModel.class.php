<?php
class GametypeModel extends Model {

    // 自动验证设置
    protected $_validate = array(
        array('type_name', 'require', '标题必须！', 1),//1为必须验证 
        array('type_name', '', '标题已经存在', 0, 'unique', self::MODEL_INSERT),
        //0为存在字段就验证（默认）
        /* 'unique' 第五个参数为附加规则
          附加规则： 配合验证规则使用（可选），包括：
            regex 使用正则进行验证，表示前面定义的验证规则是一个正则表达式（默认）
            function 使用函数验证，前面定义的验证规则是一个函数名
            callback 使用方法验证，前面定义的验证规则是当前Model类的一个方法
            confirm 验证表单中的两个字段是否相同，前面定义的验证规则是一个字段名
            equal 验证是否等于某个值，该值由前面的验证规则定义
            in 验证是否在某个范围内，前面定义的验证规则必须是一个数组
            unique 验证是否唯一，系统会根据字段目前的值查询数据库来判断是否存在相同的值
            系统还内置了一些常用正则验证的规则，可以直接使用，包括：require 字段必须、email 邮箱、url URL地址、currency 货币、number 数字，这些验证规则可以直接使用。
        * 
        */
        
        /* self::MODEL_INSERT
            验证时间：（可选）
            Model:: MODEL_INSERT 或者1新增数据时候验证
            Model:: MODEL_UPDATE 或者2编辑数据时候验证
            Model:: MODEL_BOTH 或者3 全部情况下验证（默认）
        */

    ); 
}

?>