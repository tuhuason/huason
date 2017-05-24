<?php
defined('THINK_PATH') or exit();

return array(
	//URL模式
    'URL_MODE' => 2,
    'URL_CASE_INSENSITIVE' =>true,

    // 'TMPL_EXCEPTION_FILE'=>'/404.html' // 定义公共错误模板
    // 'ERROR_MESSAGE'         =>  '页面错误！请稍后再试',//错误显示信息,非调试模式有效
    // 'ERROR_PAGE'            =>  '/404.html', // 错误定向页面
    'SHOW_ERROR_MSG'        =>  false,    // 显示错误信息
    // 'TRACE_MAX_RECORD'      =>  100,    // 每个级别的错误信息 最大记录数

    'THINK_SDK_QQ' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => '', //注册应用填写的callback
	)
);