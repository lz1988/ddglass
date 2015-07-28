<?php
if (!defined('THINK_PATH')) exit();
$config = require './config.php';

$HTTP_HOST = "http://" . $_SERVER['HTTP_HOST'];
$HOST_DIR = dirname($_SERVER['PHP_SELF']);
if ($HOST_DIR != '/') {
    $HTTP_HOST = $HTTP_HOST . $HOST_DIR;
}
$mail_config['config']['smtp_server'] = 'mail.yx1758.com';
$mail_config['config']['smtp_port'] = '25';
$mail_config['config']['smtp_user'] = 'svc@yx1758.com';
$mail_config['config']['smtp_password'] = 'ZTdiYKol';


$partner_login_types = array('sina', 't', 'qq', 'reren', 'msn');

$array = array(
    'URL_CASE_INSENSITIVE' => true,
    'URL_MODEL' => 1,
    'URL_HTML_SUFFIX' => '.html',
    'HTTP_HOST' => $HTTP_HOST,

    'COOKIE_DOMAIN' => 'www.peixun.com', //cookie的有效域名
    'COOKIE_PATH' => '/Home', //保存路径
    //'COOKIE_PREFIX' => 'test_', //cookie的前缀

    'JS_REGEXP_USER_NAME' => '\/\^\[\\w\\d\\.@_]{4,16}\$\/i',
    'JS_REGEXP_PASSWORD' => '\/\^\\w\{6,12\}\$\/i',
    'PARTNER_LOGIN_TYPES' => $partner_login_types,

    'LAYOUT_ON' => true,

    'TMPL_STRIP_SPACE' => false,

    'VAR_PAGE' => 'p',

    'TMPL_EXCEPTION_FILE' => APP_PATH . '/Tpl/Theme/Public/exception.html',


    'EMAIL_CONFIG' => $mail_config,#邮件发送配制

    'PAGE_RECORDS_NUMBER' => '20',//分页，每页的记录数

    'DB_FIELD_CACHE' => false,
    'HTML_CACHE_ON' => false,
    'APP_DEBUG' => true,

    'SESSION_AUTO_START' => true,
    'APP_AUTOLOAD_PATH' => '@.TagLib,@.ORG',

    'APP_DEBUG' => true,
    'URL_CASE_INSENSITIVE' => true,
    'SHOW_PAGE_TRACE' => false,
    'DATA_CACHE_TYPE' => 'file',
    'APP_AUTOLOAD_PATH' => '@.TagLib,@.ORG',
    'TMPL_SWITCH_ON' => true,
    'TMPL_DETECT_THEME' => true,
    'DEFAULT_THEME' => 'default',

    'PAY_KEY' => 's@#d*&w8uy^s2ayo.pay',

    //上传配置
    'UPLOAD_PATH' => 'Uploads/',//文件上传路径
    'UPLOAD_IMAGE_MAX_SIZE' => 5242880,//2Mb,允许上传图片的最大尺寸(单位byte)
    'UPLOAD_FILE_MAX_SIZE' => 5242880,//5Mb,允许上传文件的最大尺寸(单位byte)
    'ITEM_THUMB' => array(
        array(
            '100',
            '100'
        ),
        array(
            '232',
            '232'
        ),
        array(
            '430',
            '430'
        ),
        array(
            '800',
            '800'
        )
    ),  //商品缩略图设置
    'ITEM_UPLOAD_DIR' => '/Uploads/Item/', //商品图片上传目录
    'ITEM_UPLOAD_SIZE' => 5,//商品上传图片大小限制2M
    'ATTACHMENTS_UPLOAD_DIR' => '/Uploads/Attachments/',


//    'HTML_CACHE_ON'=>true,
//    'HTML_CACHE_RULES'=> array(
//          'index:index'=>array('Index/index',3600, ''),
//          'index:newsCenter'=>array('Index/newsCenter',3600, ''),
//         //'Index:index'=>array('Index/{:action}','600'),
//    ),

);
//第三方登录配置参数
$oauthConfig = array(
    'qq' => array(
        'APIURL' => 'https://graph.qq.com/shuoshuo/add_topic',
        'AUTHORIZE_URL' => 'https://graph.qq.com/oauth2.0/authorize',
        'ACCESS_TOKEN_URL' => 'https://graph.qq.com/oauth2.0/token',
        'OPENID_TOKEN_URL' => 'https://graph.qq.com/oauth2.0/me',
        'GET_USERINFO_URL' => 'https://graph.qq.com/user/get_user_info',
        'APPID' => '100299306',
        'SECRET' => '699bb49dea940a9d2a53e39c4291ef0e',
        'SCOPE' => 'get_user_info,add_topic'
    ),
    'sina' => array(
        'APIURL' => 'https://api.weibo.com/2/statuses/update.json',
        'AUTHORIZE_URL' => 'https://api.weibo.com/oauth2/authorize',
        'ACCESS_TOKEN_URL' => 'https://api.weibo.com/oauth2/access_token',
        'GET_USERINFO_URL' => 'https://api.weibo.com/2/users/show.json',
        'APPID' => '3627684483',
        'SECRET' => '67ebe64f2d8c1d199d2174789992770e'
    ),
    'renren' => array(
        'APIURL' => 'feed.publishFeed',
        'AUTHORIZE_URL' => 'https://graph.renren.com/oauth/authorize',
        'ACCESS_TOKEN_URL' => 'http://graph.renren.com/oauth/token',//人人网可以得到昵称跟图片
        'APPID' => '210438',
        'APPKEY' => '34adfb82d12443dd924eeba8784c7f83',
        'SECRET' => 'ef39db2485854404801218601cc14eef',
        'SCOPE' => 'publish_feed'
    ),
    'qqweibo' => array(
        'APIURL' => 'https://open.t.qq.com/api/t/add',
        'AUTHORIZE_URL' => 'https://open.t.qq.com/cgi-bin/oauth2/authorize',
        'ACCESS_TOKEN_URL' => 'https://open.t.qq.com/cgi-bin/oauth2/access_token',
        'GET_USERINFO_URL' => 'https://open.t.qq.com/api/user/other_info',
        'APPID' => '801226208',
        'SECRET' => 'b488d9c75f006f0a70d2ea2fced794ed'
    ),
    'douban' => array(
        'APIURL' => 'https://api.douban.com/shuo/v2/statuses/',
        'AUTHORIZE_URL' => 'https://www.douban.com/service/auth2/auth',
        'ACCESS_TOKEN_URL' => 'https://www.douban.com/service/auth2/token',
        'GET_USERINFO_URL' => 'https://api.douban.com/v2/user/',//后面拼接UID：67798716
        'APPID' => '03d9267692374e4a0b8b7363b6a5eade',
        'SECRET' => '873577fb495c04e0',
        'SCOPE' => 'shuo_basic_w'
    )
);

return array_merge($config, $array, $oauthConfig);
?>