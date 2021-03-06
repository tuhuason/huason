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
    'DB_PWD' => '',
    'DB_NAME' => 'huason',
    'DB_PORT' => 3306,
    'DB_PREFIX' => '',
    'DB_CHARSET' =>  'utf8',

    //URL模式
    'URL_MODE' => 2,
    'URL_CASE_INSENSITIVE' =>true,

    // 开启路由
    'URL_ROUTER_ON'   => true, 
    'URL_ROUTE_RULES'=>array(
        'article/:id\d' =>   'Home/Article/article',
        'article$' => 'Home/Article/index',
        'search' => 'Home/Article/search',
        'feedback$' => 'Home/message/index',
        'qq_login$' => 'Home/Index/qqLogin',
        'qq_logout$' => 'Home/Index/qqLogout',
        'qqcallback$' => 'Home/Index/callback',
        'u/:id\s' => 'Home/user/index',
    ),

    //日志
    'LOG_RECORD' => false,
    'LOG_TYPE' => 'File',
    'LOG_LEVEL' => 'EMERG,ALERT,CRIT,ERR',
    'LOG_FILE_SIZE' => 2097152,
    'LOG_EXCEPTION_RECORD' => false,
);