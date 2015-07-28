<?php
class UserModel extends Model {
	
	protected $_map = array(
	'userName'=>'account',
	'passWord'=>'password',
	
	
	
	);

    // 自动验证设置
    protected $_validate = array(
    /**/
        array('account', 'require', '邮箱不能为空！', 1),//1为必须验证
        array('account', 'email', '邮箱格式错误！', 1),//2为不为空时验证
        //array('account', 'isInvalidWord', '帐号不允许注册！', 0, 'function'),
        array('account', '', '帐号已经存在！', 1, 'unique'),
        
        array('password', 'require', '密码不能为空！', 1),
        array('password', '6,20', '密码长度错误！', 1, 'length'),
        
        array('confirm_password', 'password', '确认密码输入错误！', 1, 'confirm'),
        
       
        //array('email', '', '邮箱已经存在！', 1, 'unique'),
       
        //array('verify', 'require','验证码必须！'),
        array('verify', 'CheckVerify', '验证码错误！', 0, 'callback'),
        
        
        //array('true_name', 'require', '真实姓名不能为空！', 2),
        //array('true_name', '2,6', '真实姓名长度错误！', 2, 'length'),
         
        
        /**/
        
        //array('IDcard', 'require', '身份证号码不能为空！', 1),
        
        
        //array('content', 'require', '内容必须'),
        //array('userName', '', '用户名已经存在', 1, 'unique', self::MODEL_INSERT),
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
    // 自动填充设置
    protected $_auto = array(
        array('status', '1', self::MODEL_INSERT),
        array('is_del', '0', self::MODEL_INSERT),
        array('reg_time', 'time', self::MODEL_INSERT, 'function'),
        array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function'),
        array('password', 'encryptPassword', self::MODEL_INSERT, 'function'),
    );
    /*
     * $_auto =array(填充字段,填充内容,填充条件,附加规则)
        填充字段就是需要进行处理的表单字段，这个字段不一定是数据库字段，
        也可以是表单的一些辅助字段，例如确认密码和验证码等等。
        填充条件包括：
        Model:: MODEL_INSERT 或者1 新增数据的时候处理（默认）
        Model:: MODEL_UPDATE 或者2更新数据的时候处理
        Model:: MODEL_BOTH 或者3所有情况都进行处理
        附加规则包括：
        function ：使用函数，表示填充的内容是一个函数名 
        callback ：回调方法 ，表示填充的内容是一个当前模型的方法
        field ：用其它字段填充，表示填充的内容是一个其他字段的值
        string ：字符串（默认方式）
     * 
     */
   
	public function CheckVerify($verify) {
        if (md5($verify) != Session::get('verify')) return false;
        return true;
    }
}

?>