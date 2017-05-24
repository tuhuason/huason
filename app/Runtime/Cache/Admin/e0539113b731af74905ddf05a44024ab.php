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
                <li  class="layui-nav-item layui-this">
                <a href="<?php echo U('admin/Account/index');?>">登陆</a>
                </li>
                <li  class="layui-nav-item">
                <a href="<?php echo U('admin/Account/reg');?>">注册</a>
                </li>
            </ul>
        </div>
    </div>    
    <div class="layui-main">
    <h2 class="page-title">会员 登录</h2>
        <div class="">
            <form class="layui-form layui-form-pane" autocomplete="off">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="adminuser" lay-verify="user" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">请输入用户名</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" lay-verify="pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">请输入密码</div>
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
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="login">登录</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    <span style="margin-left: 5px;">没有账号？<a href="<?php echo U('admin/Account/reg');?>">点击注册</a></span>
                    </div>
                </div>
            </form>
        </div>
        </div>
    <script src="/static/js/jquery-1.10.2.min.js"></script>
    <script src="/static/layui/layui.js"></script>
    <script src="/static/js/base.js"></script>
    <script type="text/javascript">
    $(function(){
        Base.initialize();
        Base.urls = {login:"<?php echo U('admin/Account/login');?>",index:"<?php echo U('admin/Index/index');?>",verify:"<?php echo U('admin/Account/verify',array());?>"};
        layui.use(['layer','form'], function(){
            var form = layui.form()
            ,layer = layui.layer;
  
            //自定义验证规则
            form.verify({
                user: function(value){
                    if(value == ''){
                        return '请输入用户名';
                    }
                }
                ,pass: function(value){
                    if(value == ''){
                        return '请输入密码';
                    }
                }
                ,code: function(value){
                    if(value == ''){
                        return '请输入验证码';
                    }
                }
            });

            form.on('submit(login)', function(data){

                var username = data.field['adminuser'],
                    password = data.field['password'],
                    code = data.field['code'];
                $.ajax({
                    url :Base.url('login'),
                    type:'post',
                    data : {adminuser:username, password:password, code:code},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.msg(data.results,{offset:'70px',time:1000},function(){
                                Base.redirect(Base.url('index'));
                            });
                        } else {
                            layer.msg(data.errdesc,{offset:'70px',time:1500});
                            return false;
                        }
                    },
                    error : function(xmlHttpRequest, status, errorThrow) {
                        layer.open(errorThrow);
                    }
                });
            });
        });
    });
    </script>
</body>
</html>