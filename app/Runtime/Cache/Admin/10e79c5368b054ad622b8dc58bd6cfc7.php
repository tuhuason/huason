<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>管理后台-<?php echo ($webtitle); ?></title>
    <link rel="shortcut icon" href="/static/img/favicon.png">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/admin.css" media="all">
    
    
</head>
<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header header">
            <a class="logo" href="<?php echo U('/Account/index/');?>" title="Huason"><img src="/static/img/logo.png"></a>
            <!-- <span class="title">后台管理</span> -->
            <ul class="layui-nav" lay-filter="top_nav">
                <li class="layui-nav-item">
                    <a href="/">前台首页</a>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><?php echo ($username); ?></a>
                    <dl class="layui-nav-child">
                        <dd><a href="<?php echo U('admin/Account/logout');?>">退出</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
        <div class="site-tree layui-side layui-bg-black" id="side-menu">
            <div class="layui-side-scroll">
                <ul class="layui-nav layui-nav-tree" lay-filter="leftnav">
                    <?php if(is_array($menu_list)): foreach($menu_list as $menu_identifier=>$menu): if(empty($menu['children'])): ?><li data-id="<?php echo ($menu["id"]); ?>" class="layui-nav-item <?php if($menu_identifier == $identifier): ?>layui-this<?php endif; ?>">
                    <a href="<?php echo ($menu["url"]); ?>" data-url="<?php echo ($menu["url"]); ?>" data-id="<?php echo ($menu["id"]); ?>"><span style="margin-left: 10px;"><?php echo ($menu["name"]); ?></span></a>
                    </li>
                    <?php else: ?>
                    <?php $ident = current(explode('.',$identifier)); ?>
                    <li class="layui-nav-item <?php if($menu_identifier == $ident): ?>layui-nav-itemed<?php endif; ?>">
                        <a href="javascript:;"><?php echo ($menu["name"]); ?></a>
                        <dl class="layui-nav-child">
                            <?php if(is_array($menu["children"])): foreach($menu["children"] as $childrenmenu_identifier=>$childmenu): ?><dd data-id="<?php echo ($childmenu["id"]); ?>" <?php if(($menu_identifier.'.'.$childrenmenu_identifier)== $identifier): ?>class="layui-this"<?php endif; ?>><a href="<?php echo ($childmenu["url"]); ?>" data-url="<?php echo ($childmenu["url"]); ?>" data-id="<?php echo ($childmenu["id"]); ?>"><i class="layui-icon">&#xe600;</i><span style="margin-left: 10px;"><?php echo ($childmenu["name"]); ?></span></a></dd><?php endforeach; endif; ?>
                        </dl>
                      </li><?php endif; endforeach; endif; ?>
                </ul>
            </div>
        </div>
        <div class="layui-body">
            <!-- <div style="margin:0;" class="layui-tab layui-tab-brief" lay-filter="tab" lay-allowclose="true">
                <ul class="layui-tab-title">
                    <li lay-id="0" <?php if('index' == $identifier): ?>class="layui-this"<?php endif; ?>>首页</li>
                </ul> -->
                <div class="layui-tab-content" style="overflow:auto;">
                    
<div class="layui-tab-item <?php if('index' == $identifier): ?>layui-show<?php endif; ?>">

    <p style="padding: 10px 15px; margin-bottom: 20px; margin-top: 10px; border:1px solid #ddd;display:inline-block;">
        <span style="padding-left:1em;">当前用户：<?php echo ($username); ?></span>
        <span style="padding-left:1em;">IP：<?php echo ($cur_user["lastip"]); ?></span>
        <span style="padding-left:1em;">地点：未知</span>
        <span style="padding-left:1em;">时间：<?php echo (date('Y-m-d H:i:s',$cur_user["lasttime"])); ?></span>
    </p>
    <div class="clear"></div>
    <?php if(!empty($data['user'])): ?><div class="pane-4">
		<section class="card">
			<div class="symbol blue">
                <i class="layui-icon pane-icon">&#xe613;</i>
            </div>
			<div class="value">
                <h1><?php echo ($data["user"]); ?></h1>
                <span>用户总量</span>
            </div>
		</section>
	</div><?php endif; ?>
	<div class="pane-4">
		<section class="card">
			<div class="symbol red">
                <i class="layui-icon pane-icon">&#xe63c;</i>
            </div>
            <div class="value">
                <h1><?php echo ($data["article"]); ?></h1>
                <span>文章总数</span>
            </div>
		</section>
	</div>
	<div class="pane-4">
		<section class="card">
			<div class="symbol green">
                <i class="layui-icon pane-icon">&#xe60e;</i>
            </div>
            <div class="value">
                <h1><?php echo ($data["diary"]); ?></h1>
                <span>日记总数</span>
            </div>
		</section>
	</div>
</div>

                </div>
            <!-- </div>  -->
        </div>
        <!-- <div class="layui-footer">
        </div> -->
        <div class="layui-fixbar" id="gotop" style="display:none;right:20px;">
            <li class="layui-icon layui-fixbar-top" style="display: list-item;background-color:rgba(0, 0, 0, 0.48);">&#xe604;</li>
        </div>
        <div class="site-tree-mobile layui-hide">
            <i class="layui-icon">&#xe602;</i>
        </div>
        <div class="site-mobile-shade"></div>
    </div>
    
    
    
    
    
    <script src="/static/js/jquery-1.10.2.min.js"></script>
    <script src="/static/layui/layui.js"></script>
    <script type="text/javascript" src="/static/js/base.js"></script>
    <script type="text/javascript">
        $(function(){
            Base.initialize();
            Base.urls = {};
            layui.use(['form','element'], function(){
                var form = layui.form(),
                element = layui.element(),
                $ = layui.jquery;
            })
            
        });
    </script>
    
    
</body>
</html>