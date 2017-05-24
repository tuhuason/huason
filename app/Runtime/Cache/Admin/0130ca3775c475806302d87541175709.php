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
                    
<div class="" style="margin-bottom: 10px;">
<button class="layui-btn layui-btn-normal" id="add-diary">添加日记</button>
<button class="layui-btn layui-btn-danger" onclick="Diary.delete_diys()"><i class="layui-icon" style="">&#xe640;</i>批量删除</button>
</div>
<table class="layui-table layui-form" id="diary">
    <thead>
        <tr>
            <th><input type="checkbox" lay-skin="primary" lay-filter="diary" name="select_all"></th>
            <th>ID</th>
            <th>创建时间</th>
            <!-- <th>更新时间</th> -->
            <th>文本内容</th>
            <th>操作</th>
        </tr> 
    </thead>
    <tbody>
        <?php if(is_array($diary)): foreach($diary as $key=>$diy): ?><tr>
            <td><input type="checkbox" lay-skin="primary" name="select" value="<?php echo ($diy["id"]); ?>"></td>
            <td><?php echo ($diy["id"]); ?></td>
            <td><?php echo (date('Y-m-d H:i:s',$diy["addtime"])); ?></td>
            <td><?php echo (htmlspecialchars_decode($diy["content"])); ?></td>
            <td>
                <!-- <a class="layui-btn layui-btn-normal layui-btn-small" onclick="edit_diy('<?php echo ($diy["id"]); ?>')">编辑</a> -->
                <a class="layui-btn layui-btn-danger layui-btn-small delete_art" onclick="Diary.delete_diy('<?php echo ($diy["id"]); ?>')">删除</a>
            </td>
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>
<script type="text/template" id="add_diary_container">
    <div class="template-box">
        <form class="layui-form layui-form-pane">
            <div class="layui-form-item">
                <label class="layui-form-label">内容</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea layui-hide" name="content" lay-verify="content" id="editorDiary" placeholder="请输入日记内容">
                    </textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-btn" lay-submit="" lay-filter="add-diary">确定</button>
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
            Base.urls = {};
            layui.use(['form','element'], function(){
                var form = layui.form(),
                element = layui.element(),
                $ = layui.jquery;
            })
            
        });
    </script>
    
    <script type="text/javascript" src="/static/js/diary.js"></script>
    <script type="text/javascript" src="/static/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">

        $(function(){
            Diary.initialize();
            Base.urls = {diary:"<?php echo U('/Admin/diary/index');?>",addDiary:"<?php echo U('Admin/diary/addDiary');?>",deleteDiary:"<?php echo U('Admin/diary/deleteDiary');?>",findOne:"<?php echo U('Admin/diary/findOne');?>",editDiary:"<?php echo U('Admin/diary/editDiary');?>",};
            
        });
    </script>

    
</body>
</html>