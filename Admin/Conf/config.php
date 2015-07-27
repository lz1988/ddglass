<?php
//模块功能-   
if (!defined('THINK_PATH')) exit(); 
$config	= require './config.php';
$menu= array(
'SHOW_PAGE_TRACE' => false,
'DATA_CACHE_TYPE'=> 'file',// Eaccelerator --Memcache
//'MEMCACHE_HOST'   =>  'tcp://127.0.0.1:11211',  //memcache服务器地址和端口，这里为本机。
//'DATA_CACHE_TIME' => '60',  //过期的秒数
  'URL_MODEL'=>1,
'URL_CASE_INSENSITIVE'=>true,
'TMPL_STRIP_SPACE' =>false,
 //上传配置
    'UPLOAD_PATH'=>'Uploads/',//文件上传路径
    'UPLOAD_IMAGE_MAX_SIZE'=>2097152,//2Mb,允许上传图片的最大尺寸(单位byte)
    'UPLOAD_FILE_MAX_SIZE'=>5242880,//5Mb,允许上传文件的最大尺寸(单位byte)
    'ITEM_THUMB' => array (
				array (
						'100',
						'100' 
				),
				array (
						'232',
						'232' 
				),
				array (
						'430',
						'430' 
				),
				array (
						'800',
						'800' 
				) 
		),  //商品缩略图设置
    'ITEM_UPLOAD_DIR' => '/Uploads/Item/', //商品图片上传目录
	'ITEM_UPLOAD_SIZE'=> 2,//商品上传图片大小限制2M
    'ATTACHMENTS_UPLOAD_DIR'=>'/Uploads/Attachments/',
	
//邮件配置
        'LEG_MAIL_HOST'=>'mail.51oscar.com',//发送邮件的服务器	
		'LEG_MAIL_PORT'=>25,//发送邮件的服务器端口	
		'LEG_MAIL_USERNAME'=>'svc',//邮件系统验证用户名
		'LEG_MAIL_PASSWORD'=>'YTVhOTAy',//邮件系统验证密码
		'LEG_MAIL_ADDRESS_FROM'=>'svc@51oscar.com',//系统发送邮件的邮箱地址
		'LEG_MAIL_ADDRESS_FROM_NAME'=>'莱科',//系统发送邮件的邮箱地址名称
		'LEG_MAIL_WORD_WRAP_SIZE'=>50,  //邮件内容自动换行的字符数
		'LEG_MAIL_IS_HTML'=>true,  //邮件内容格式是否为HTML
		'LEG_EXCEL_DATA_CACHE_DIR'=>'/usr/local/tmp', //导出Excel数据时使用的磁盘缓存目录
		
		'CITY_NAME'=>array(#地区
		   '杭州'=>'杭州',
		   '上海'=>'上海',
		   '北京'=>'北京',
		   '天津'=>'天津',
		   '广州'=>'广州',
		   '深圳'=>'深圳',
		   '长沙'=>'长沙',
		   '南京'=>'南京',
		   '重庆'=>'重庆',
		   '成都'=>'成都',
		   '武汉'=>'武汉',
		),
		
		'SUB_NUM'=>array(#预约次数
		   1=>'1+',
		   2=>'2+',
		   3=>'3+',
		   4=>'4+',
		   5=>'5+',
		   10=>'10+',
		   20=>'20+',
		   30=>'30+',
		   50=>'50+',
		),
		'ORDERS_NUM'=>array(#订单笔数
		   1=>'1+',
		   2=>'2+',
		   3=>'3+',
		   4=>'4+',
		   5=>'5+',
		   6=>'6+',
		   7=>'7+',
		   8=>'8+',
		   9=>'9+',
		   10=>'10+',
		),
		'ORDERS_PRICE'=>array(#客单价
		   '150-200'=>array(array('egt',150),array('elt',200),'and'),#array(150,200),
		   '200-300'=>array(array('egt',200),array('elt',300),'and'),
		   '300-500'=>array(array('egt',300),array('elt',500),'and'),
		   '500-1000'=>array(array('egt',500),array('elt',1000),'and'),
		   '1000+'=>array('egt',1000),
		),
		
'MODULES_MENU_ALL'=>array(
     'Role'=>array(//职权
        'Role'=>array(//职权管理
            'url' =>"Role/role_list/",'role_list'=>"查看",'role_add' =>"添加",'role_del' =>"删除",'role_edit'=>"修改",'member_manage'=>"成员管理","rolepriv_allot"=>"职权分配",
        ),
        'Adminuser'=>array(//	管理员管理
            'url' =>"Adminuser/adminuser_list/",'adminuser_list'=>"查看",'adminuser_add' =>"添加",'adminuser_del' =>"删除",'adminuser_edit'=>"修改",
        ),
		'Menu'=>array(//菜单管理
			'url' =>"Menu/index/",'menu_list'=>"查看",'menu_add' =>"添加",'menu_del' =>"删除",'menu_edit'=>"修改",
		)
     ),
     'Member'=>array(//会员
        'Member'=>array(//会员管理
            'url' =>"Member/member_list/",'member_list'=>"查看",'member_add' =>"添加",'member_del' =>"删除",'member_edit'=>"修改",'member_log'=>"会员日志",'member_editsp'=>"修改推广员",
        )
     ),
    
     'Advert'=>array(
        'Advert'=>array(//广告列表
            'url' =>"Advert/advert_list/",'advert_list'=>"查看",'advert_add' =>"添加",'advert_del' =>"删除",'advert_edit'=>"修改",'advert_upall'=>"更新",
        ),
        'Adverttype'=>array(//广告组
            'url' =>"Adverttype/adverttype_list/",'adverttype_list'=>"查看",'adverttype_add' =>"添加",'adverttype_del' =>"删除",'adverttype_edit'=>"修改",
        ),
        'Friendlink'=>array(//友情链接列表
            'url' =>"Friendlink/friendlink_list/",'friendlink_list'=>"查看",'friendlink_add' =>"添加",'friendlink_del' =>"删除",'friendlink_edit'=>"修改",'friendlink_upall'=>"更新",
        ),
         
     ),
     'Message'=>array(//资讯管理
        'Messagetype'=>array(//资讯栏目
            'url' =>"Messagetype/messagetype_list/",'messagetype_list'=>"查看",'messagetype_add' =>"添加",'messagetype_del' =>"删除",'messagetype_edit'=>"修改", 'messagetype_upall'=>"更新",
        ),
        'Message'=>array(//资讯管理
            'url' =>"Message/message_list/",'message_list'=>"查看",'message_add' =>"添加",'message_del' =>"删除",'message_edit'=>"修改",'message_upall'=>"更新",
        ),
     ),
     'Log'=>array(
        'Logadmin'=>array(//管理员日志
            'url' =>"Logadmin/logadmin_list/",'logadmin_list'=>"查看",'logadmin_del' =>"删除",
        ),
        'Recycle'=>array(//数据回收站
            'url' =>"Recycle/recycle_list/",'recycle_list'=>"查看",'recycle_del' =>"删除",'recycle_restore' =>"恢复",
        ),
        'Siteconfig'=>array(//config
            'url' =>"Siteconfig/site_list/",'site_list' =>"修改",
        ),
     ),
       
),
'ITEM_COLOR_ARR'=>array(//产品颜色
    '5d762a'=>'军绿色',
	'1eddff'=>'天蓝色',
	'd2691e'=>'巧克力色',
	'ffa500'=>'桔色',
	'e4e4e4'=>'浅灰色',
	'98fb98'=>'浅绿色',
	'ffffb1'=>'浅黄色',
	'bdb76b'=>'深卡其布色',
	'666666'=>'深灰色',
	'4b0082'=>'深紫色',
	'041690'=>'浅蓝色',
	'ffffff'=>'白色',
	'ffb6c1'=>'粉色',
	'dda0dd'=>'紫罗兰',
	'800080'=>'紫色',
	'ff0000'=>'红色',
	'008000'=>'绿色',
	'0000ff'=>'蓝色',
	'855b00'=>'褐色',
	'990000'=>'酒红色',
	'ffff00'=>'黄色',
	'000000'=>'黑色',
),
'ITEM_SIZE_YF_ARR'=>array(//产品尺寸-衣服
    'XXS',
	'XS',
	'S',
	'M',
	'L',
	'XL',
	'XXL',
	'XXXL',
	'均码',
),

'ITEM_SIZE_KZ_ARR'=>array(//产品尺寸-库子  50-90厘米
    50,
	90,
),

'MOD_NAME_ACTION'=>array(//操作方法
'add'     =>'添加',
'edit'    =>'修改',
'del'     =>'删除',
'list'    =>'查看',
'log'     =>'日志',
'upall'   =>'更新',
'allot'   =>'分配权限',
'manage'  =>'成员管理',
'export'  =>'导出',
'import'  =>'导入',
'restore' =>'还原',
'maintenance'=>"维护",
'stop'    =>"停服",
'ratio'   =>'分红比例',
'paygame' =>'充值到游戏',
'data'    =>'数据分析',
'channel' =>'渠道数据分析',
'large'   =>'大类数据分析',
'audit'   =>'审核',
'detail'  =>'详情',
'effect'  =>'查看效果',
'addoption'=>'添加菜单选项',
'copy'    =>'复制',
'info'    =>'详细信息',
'newcard' =>'新手卡领取记录',
'user'    =>'用户',
'click'   =>'点击',
'optionlist'=>'菜单列表',
'optionadd'=>'添加菜单',
'option'=>'菜单',
'optionedit'=>'菜单修改',
'optiondel'=>'菜单修改',
'max'      =>'人数',
'shuju'    =>'数据',          
),
'NOT_DEL'=>array(//不可删除的项目,ALL所有不可删
    'Role'       =>array(1,2,4,5,17),//角色
    'Adminuser'  =>array(1,2),//admin用户
    //'Gametype'   =>'ALL',//游戏类型
    'Adverttype' =>'ALL',//广告组
    'Game'       =>array(1,2),//游戏
    'Logadmin'   =>array(10,11,12,13,14,15),//管理员日志
    'Messagetype'=>'ALL',//新闻栏目
    'Payway'     =>array(1),//支付渠道
),
'USER_SOURCE'=>array(  #用户来源 1自然注册 2活动用户 3试听用户  4批量导入
	0=>'其它',
    1=>'自然注册',
    2=>'活动用户',
    3=>'试听用户',
    4=>'批量导入',
    5=>'手动添加'
),

'ORDER_MODE'=>array(  #交易方式  0 未选择 1 报名试听 2 参与活动 3 线下成交　4 线上　5 注册
	0=>'未选择',
    1=>'报名试听',
    2=>'参与活动',
    3=>'线下成交',
    4=>'线上成交',
    5=>'注册'
),
);
return array_merge($config, $menu);

?>