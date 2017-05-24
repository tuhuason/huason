<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title><?php echo ($error_title); ?></title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
	<style type="text/css">
		body{background-color: #f2f2f2}
        .pager{margin:auto;overflow:hidden;text-align: center;}
    </style>
</head>
<body>
    <div class="pager">
        <img src="/static/img/404.png">
    </div>
    <div style="text-align: center;">
    	<a href="/" class="layui-btn layui-btn-normal">返回首页</a>
    </div>
</body>
</html>