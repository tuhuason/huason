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
            <a class="flash-btn" id="flush" href="/">前台首页</a>
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
<button class="layui-btn" onclick="Reply_message.auditings()"><i class="layui-icon" style="">&#xe605;</i>批量审核</button>
<button class="layui-btn layui-btn-danger" onclick="Reply_message.delete_messages()"><i class="layui-icon" style="">&#xe640;</i>批量删除</button>
</div>
<table class="layui-table layui-form" id="reply_message">
    <colgroup>
    <col width="30">
    </colgroup>
  	<thead>
	    <tr>
            <th><input type="checkbox" lay-skin="primary" lay-filter="reply_message" name="select_all"></th>
	      	<th>ID</th>
            <th>回复者</th>
	      	<th>回复时间</th>
            <th>被回复人</th>
            <th>回复标识</th>
            <th>回复内容</th>
            <th>点赞次数</th>
            <th>审核</th>
            <th>操作</th>
	    </tr> 
  	</thead>
  	<tbody>
        <?php if(is_array($reply)): foreach($reply as $key=>$re): ?><tr data-id="<?php echo ($re["id"]); ?>" data-content="<?php echo ($re["content"]); ?>">
            <td><input type="checkbox" lay-skin="primary" name="select" value="<?php echo ($re["id"]); ?>,<?php echo ($re["identifier"]); ?>"></td>
	      	<td><?php echo ($re["id"]); ?></td>
	      	<td><?php echo ($re["reply_commenter"]); ?></td>
            <td><?php echo (date('Y-m-d H:i:s',$re["addtime"])); ?></td>
            <td><?php echo ($re["reply_master"]); ?></td>
            <td><?php echo ($re["identifier"]); ?></td>
            <td><a>查看内容</a></td>
            <td><?php echo ($re["upvote"]); ?></td>
            <td data-id="<?php echo ($re["id"]); ?>"><input type="checkbox" name="auditing" lay-filter="auditing" lay-skin="switch" lay-text="是|否" <?php if($re['auditing']): ?>checked<?php endif; ?>></td>
            <td>
                <a class="layui-btn layui-btn-danger layui-btn-small delete_art" onclick="Reply_message.delete_message('<?php echo ($re["id"]); ?>','<?php echo ($re["identifier"]); ?>')"><i class="layui-icon" style="">&#xe640;</i></a>
            </td>
    	</tr><?php endforeach; endif; ?>
  	</tbody>
</table>

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
    reply_message : "<?php echo U('Admin/ReplyMessage/index');?>",
    delete_reply_message : "<?php echo U('Admin/ReplyMessage/deleteReplyMessage');?>",
    edit_reply_message : "<?php echo U('Admin/ReplyMessage/editReplyMessage');?>"
};
            layui.use(['form','element'], function(){
                var form = layui.form(),
                element = layui.element(),
                $ = layui.jquery;
            })
            
        });
    </script>
    
    <script type="text/javascript" src="/static/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/static/js/reply_message.js"></script>
    <script type="text/javascript">
    $(function(){
        Reply_message.initialize();
    });
    </script>

    
</body>
</html>