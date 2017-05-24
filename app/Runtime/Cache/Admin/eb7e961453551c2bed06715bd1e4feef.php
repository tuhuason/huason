<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台登录</title>
    <link rel="shortcut icon" href="/static/img/favicon.png">
    <link href="/static/layui/css/layui.css" rel="stylesheet" />
    <link href="/static/css/login.css" rel="stylesheet" />
</head>

<body>
    <div class="layui-header header" id="header">
        <div class="layui-main">
            <a class="logo" href="<?php echo U('admin/Account/index');?>" title="Huason"><img src="/static/img/logo.png"></a>
            <span class="title">后台管理</span>   
            <ul class="layui-nav">
                <li  class="layui-nav-item">
                <a href="<?php echo U('admin/Account/index');?>">登陆</a>
                </li>
                <li  class="layui-nav-item layui-this">
                <a href="<?php echo U('admin/Account/reg');?>">注册</a>
                </li>
            </ul>
        </div>
    </div>    
    <div class="layui-main">
    <h2 class="page-title">会员 注册</h2>
        <div class="">
            <form class="layui-form layui-form-pane" autocomplete="off">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="adminuser" lay-verify="user" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">请填写5到12位用户名</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" lay-verify="pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">请填写6到12位密码</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">验证码</label>
                    <div class="layui-input-inline">
                        <input type="text" name="code" lay-verify="code" placeholder="请输入验证码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">
                        <img id="verify_img" alt="点击更换" title="点击更换" src="<?php echo U('Admin/Account/verify',array());?>" class="verify">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="reg">注册</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    <span style="margin-left: 5px;">已有账号？<a href="<?php echo U('admin/Account/login');?>">点击登录</a></span>
                    </div>
                </div>
            </form>
        </div>
    <script src="/static/js/jquery-1.10.2.min.js"></script>
    <script src="/static/layui/layui.js"></script>
    <script src="/static/js/base.js"></script>
    <script type="text/javascript">
    $(function(){
        Base.initialize();
        Base.urls = {reg:"<?php echo U('admin/Account/reg');?>",verify:"<?php echo U('admin/Account/verify',array());?>"};
    });
    </script>
</body>
</html>