<?php
/**
 * APP配置
 */
defined('THINK_PATH') or exit();

return array(
    //模版替换
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => '/static',
        '__CSS__' => '/static/css',
        '__JS__' => '/static/js',
        '__IMG__' => '/static/img',
        '__PLUGIN__' => '/static/plugin',
        '__I18N__' => '/static/i18n',
        '__BRAND__' => '/static/brand'
    ),

    //模块
    'MODULE_ALLOW_LIST' => array('Home', 'Admin'),
    'DEFAULT_MODULE' => 'Home',
    'DEFAULT_CONTROLLER' => 'Index',
    'DEFAULT_ACTION' => 'index',
    'ACTION_SUFFIX' => 'Action',
    'DEFAULT_THEME' => 'default',
    'DEFAULT_AJAX_RETURN' => 'json',
    'DEFAULT_JSON_HANDLER'	=>	'callback',

    //会话和cookie
    'SESSION_OPTIONS' => array(
        'prefix' => 'huason_',
        'expire' => (30*24*60*60),
    ),
    'COOKIE_EXPIRE' => 0,
    'COOKIE_PATH'  => '/',
    'COOKIE_PREFIX' => 'huason_',

    //数据库配置
    'DB_TYPE' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_USER' => 'huason',
    'DB_PWD' => '658655',
    'DB_NAME' => 'huason',
    'DB_PORT' => 3306,
    'DB_PREFIX' => '',
    'DB_CHARSET' =>  'utf8',
    
    //多语言支持
    // 'LANG_SWITCH_ON' => true,
    // 'LANG_AUTO_DETECT' => false,
    // 'LANG_LIST' => array_keys(Language::getList()),
    // 'DEFAULT_LANG' => Language::get(),

    //URL模式
    'URL_MODE' => 2,
    'URL_CASE_INSENSITIVE' =>true,

    // 开启路由
    'URL_ROUTER_ON'   => true, 
    'URL_ROUTE_RULES'=>array(
        'article/:id\d' =>   'Home/Article/article',
        'article$' => 'Home/Article/index',
        'search' => 'Home/Article/search',
        'diary$' => 'Home/Index/diary',
        'photo$' => 'Home/Index/photo',
        'about$' => 'Home/Index/about',
        'feedback$' => 'Home/Index/message',
        'qq_login$' => 'Home/Index/qqLogin',
        'qqcallback$' => 'Home/Index/callback'
        // 'product/:category\d/:id\d'=>'Products/Show',
    ),

    //日志
    'LOG_RECORD' => false,
    'LOG_TYPE' => 'File',
    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR',
    'LOG_FILE_SIZE' => 2097152,
    'LOG_EXCEPTION_RECORD' => false,

    // 产品型号和版本
    // 'PRODUCT_ARCH' => $_->defaultArch,
    // 'PRODUCT_VERSION' => $_->defaultVersion,
    // 'PRODUCT_COMPANY' => $_->defaultEntity,
);