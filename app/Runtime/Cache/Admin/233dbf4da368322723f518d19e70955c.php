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
            <span class="title">后台管理</span>
<!--             <button class="layui-btn layui-btn-primary flash-btn" id="flush"><i class="layui-icon">&#x1002;</i></button> -->
            <ul class="layui-nav" lay-filter="top_nav">
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
                    
<div class="" style="margin-bottom: 10px;">
<button class="layui-btn layui-btn-normal" id="add-user"><i class="layui-icon" style="">&#xe654;</i>添加管理员或普通管理员</button>
<button class="layui-btn layui-btn-danger" onclick="Admin.delete_users()"><i class="layui-icon" style="">&#xe640;</i>批量删除</button>
</div>
<table class="layui-table layui-form" id="user">
    <colgroup>
    <col width="30">
    </colgroup>
  	<thead>
	    <tr>
            <th><input type="checkbox" lay-skin="primary" lay-filter="user" name="select_all"></th>
	      	<th>ID</th>
            <th>管理员名</th>
            <th>上次登录IP</th>
	      	<th>创建时间</th>
            <th>上次登录时间</th>
            <th>管理员</th>
            <th>操作</th>
	    </tr> 
  	</thead>
  	<tbody>
        <?php if(is_array($user)): foreach($user as $key=>$user): ?><tr data-id="<?php echo ($user["id"]); ?>">
            <td><input type="checkbox" lay-skin="primary" name="select" value="<?php echo ($user["id"]); ?>"></td>
	      	<td><?php echo ($user["id"]); ?></td>
            <td><a><?php echo ($user["adminuser"]); ?></a><?php if($user['adminuser'] == $username): ?><i class="layui-icon" title="当前管理员" style="margin-left: 5px;cursor: pointer;">&#xe600;</i><?php endif; ?></td>
	      	<td><?php echo ($user['lastip'] ? $user['lastip'] : '无'); ?></td>
            <td><?php echo (date('Y-m-d H:i:s',$user["createtime"])); ?></td>
            <td><?php $lasttime = $user['lasttime'] == 0 ? '无' : date('Y-m-d H:i:s', $user['lasttime']); echo ($lasttime); ?></td>
            <td data-id="<?php echo ($user["id"]); ?>"><input type="checkbox" name="role" lay-filter="role" lay-skin="switch" lay-text="是|否" <?php if($user['role_id']): ?>checked<?php endif; ?>></td>
            <td>
                <a class="layui-btn layui-btn-normal layui-btn-small" onclick="Admin.edit_user('<?php echo ($user["id"]); ?>')"><i class="layui-icon" style="">&#xe642;</i></a>
                <a class="layui-btn layui-btn-danger layui-btn-small delete_art" onclick="Admin.delete_user('<?php echo ($user["id"]); ?>')"><i class="layui-icon" style="">&#xe640;</i></a>
            </td>
    	</tr><?php endforeach; endif; ?>
  	</tbody>
</table>
<script type="text/template" id="edit_user_container">
    <div class="template-box">
        <form class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-block">
                    <input type="adminuser" name="adminuser" lay-verify="adminuser" autocomplete="off" class="layui-input" disabled="">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                    <input type="password" name="password" lay-verify="password" placeholder="请输入新密码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label">管理员</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="role" lay-skin="switch" lay-text="是|否">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="eidt_user">确定</button>
                    <button type="button" class="layui-btn layui-btn-primary btn-cancel">取消</button>
                </div>
            </div>
        </form>
    </div>
</script>

<script type="text/template" id="add_user_container">
    <div class="template-box">
        <form class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label class="layui-form-label">用户名</label>
                <div class="layui-input-block">
                    <input type="text" name="adminuser" lay-verify="username" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码</label>
                <div class="layui-input-block">
                    <input type="password" name="password" lay-verify="password" placeholder="请输入标题" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label">管理员</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="role" lay-skin="switch" lay-text="是|否">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">验证码</label>
                <div class="layui-input-inline">
                    <input type="text" name="code" lay-verify="code" placeholder="请输入验证码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <img id="verify" alt="点击更换" title="点击更换" src="<?php echo U('Admin/Account/verify',array());?>" class="verify">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="add-user">确定</button>
                    <button type="button" class="layui-btn layui-btn-primary btn-cancel">取消</button>
                </div>
            </div>
        </form>
    </div>
</script>

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
            Base.urls = {
    user:"<?php echo U('Admin/admin/index');?>",
    deleteUser:"<?php echo U('Admin/admin/deleteUser');?>",
    roleUser:"<?php echo U('Admin/admin/roleUser');?>",
    addUser:"<?php echo U('admin/Account/reg');?>",
    editUser:"<?php echo U('admin/admin/editUser');?>",
    verify:"<?php echo U('admin/Account/verify',array());?>"
};
            layui.use(['form','element'], function(){
                var form = layui.form(),
                element = layui.element(),
                $ = layui.jquery;
            })
            
        });
    </script>
    
    <script type="text/javascript" src="/static/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/static/js/admin.js"></script>
    <script type="text/javascript">
    $(function(){
        Admin.initialize();
    });
    </script>

    
</body>
</html>