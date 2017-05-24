<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Huason博客</title>
    <link rel="shortcut icon" href="/static/img/favicon.png">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/global.css" media="all">
    
    
</head>
<body>
    <div class="layui-header header" id="header">
        <div class="layui-main">
            <a class="logo" href="/" title="Huason"><img src="/static/img/logo.png"></a>    
            <ul class="layui-nav" lay-filter="top_nav">
                <?php if(is_array($menu_list)): foreach($menu_list as $menu_identifier=>$menu): if(empty($menu['children'])): ?><li class="layui-nav-item">
                <a href="<?php echo ($menu["url"]); ?>"><?php echo ($menu["name"]); ?></a>
                </li>
                <?php else: ?>
                <li class="layui-nav-item">
                    <a href="<?php echo ($menu["url"]); ?>"><?php echo ($menu["name"]); ?></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($menu["children"])): foreach($menu["children"] as $childrenmenu_identifier=>$childmenu): ?><dd><a href="<?php echo ($childmenu["url"]); ?>"><?php echo ($childmenu["name"]); ?></a></dd><?php endforeach; endif; ?>
                    </dl>
                  </li><?php endif; endforeach; endif; ?>
            </ul>
            <div class="search">
                <form class="layui-form" action="<?php echo U('/search');?>" method="GET">
                <input type="text" class="search_input layui-input" id="search_val" name="param" placeholder="搜文章">
                <button type="submit" class="search_btn layui-btn-normal"><i class="layui-icon" id="search">&#xe615;</i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="site-tree layui-side layui-bg-black">
        <div class="layui-side-scroll" lay-filter="side">
            <ul class="layui-nav layui-nav-tree">
                <?php if(is_array($menu_list)): foreach($menu_list as $menu_identifier=>$menu): if(empty($menu['children'])): ?><li class="layui-nav-item">
                <a href="<?php echo ($menu["url"]); ?>"><?php echo ($menu["name"]); ?></a>
                </li>
                <?php else: ?>
                <li class="layui-nav-item">
                    <a href="javascript:;"><?php echo ($menu["name"]); ?></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($menu["children"])): foreach($menu["children"] as $childrenmenu_identifier=>$childmenu): ?><dd><a href="<?php echo ($childmenu["url"]); ?>" style="margin-left: 10px;"><?php echo ($childmenu["name"]); ?></a></dd><?php endforeach; endif; ?>
                    </dl>
                  </li><?php endif; endforeach; endif; ?>
            </ul>
        </div>
    </div>
    <div class="layui-main layui-clear main">
        
    <div class="layui-breadcrumb crumbs shadow" lay-separator="/">         
    <?php if(is_array($crumbs)): $crumb_index = 0; $__LIST__ = $crumbs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$crumb): $mod = ($crumb_index % 2 );++$crumb_index;?><a <?php if(!empty($crumb["url"])): ?>href="<?php echo ($crumb["url"]); ?>"<?php endif; ?>><?php echo ($crumb["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
    <div class="page-left">
        <div class="blog-tag shadow">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>留言</legend>
                <div class="layui-field-box">
                    <form class="layui-form blog-editor" id="message-form">
                        <div class="layui-form-item">
                            <label class="layui-form-label box-label">名称：</label>
                            <div class="layui-input-inline">
                                <input type="text" name="commenter" lay-verify="commenter" placeholder="请输入名称" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <textarea class="layui-textarea layui-hide" name="content" lay-verify="message_content" id="messageEditor" placeholder="请输入留言内容">
                            </textarea>
                        </div>
                        <div class="layui-form-item">
                            <button type="button" class="layui-btn layui-btn-normal" lay-submit="" lay-filter="message">提交留言</button>
                        </div>
                    </form>
                </div>
            </fieldset>
            <h2>留言</h2>
            <div>
                <dd class="review" id="message">
                </dd>
                <div class="hf">
                    <form class="layui-form"> 
                        <textarea id="reply_message_from" type="text" class="layui-textarea" name="content" autocomplete="off" maxlength="100" placeholder="请输入留言内容" lay-verify="reply_content" style="height:105px;"></textarea>
                        <button type="button" class="layui-btn layui-btn-normal" lay-submit="" lay-filter="reply_message" style="margin-top:5px;">回复</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="page-right topic">
        <div class="blog-tag shadow">
            <h2>博主资料</h2>
            <div class="introduce">
                <img src="/static/img/logo1.png" alt="Huason" width="100px" height="30px" style="padding: 10px">
            <p class="">90后程序员，PHP开发工程师</p>
            <p class=""><i class="fa fa-location-arrow"></i>&nbsp;福建 - 龙岩</p>
            </div>
        </div>
        <div class="blog-tag shadow" id="article_hot_list">
    <h2>热门文章</h2>
    <ul>
        <?php if(is_array($hot)): foreach($hot as $k=>$art): ?><li>
            <span class="num"><?php echo (zero_num($k+1)); ?></span><a title="<?php echo ($art["title"]); ?>" href="<?php echo U('/article/'.$art['id']);?>"><?php echo ($art["title"]); ?></a>
            <span class="info" title="浏览次数"><i class="iconfont" style="font-size: 16px;">&#xe71a;</i><?php echo ($art['hit']); ?>℃</span>
        </li><?php endforeach; endif; ?>
    </ul>
</div>
<div class="blog-tag shadow">
    <h2>近期热议</h2>
    <ul>
        <?php if(is_array($new)): foreach($new as $k=>$art): ?><li>
            <span class="num"><?php echo (zero_num($k+1)); ?></span><a title="<?php echo ($art["title"]); ?>" href="<?php echo U('/article/'.$art['id']);?>"><?php echo ($art["title"]); ?></a>
            <span class="info" title="评论次数"><i class="iconfont" style="font-size: 15px;">&#xe6ad;</i><?php echo ($art['comment']); ?>℃</span>
        </li><?php endforeach; endif; ?>
    </ul>
</div>
        <div class="blog-tag shadow" id="link">
    <h2>友情链接</h2>
    <div class="link">
        <a href="http://www.layui.com" target="_blank">Layui</a>
        <a href="http://www.baidu.com" target="_blank">百度</a>
    </div>
</div>
    </div>

    </div>
    
    <div class="footer">
        <p>Huason © <a class="site_url" href="###"></a></p>
    </div>

    <div class="layui-fixbar" id="gotop" style="display:none;right:20px;">
        <li class="layui-icon layui-fixbar-top" style="display: list-item;background-color:rgba(0, 0, 0, 0.48);">&#xe604;</li>
    </div>
    <div class="site-tree-mobile layui-hide">
        <i class="layui-icon">&#xe602;</i>
    </div>
    <div class="site-mobile-shade"></div>
    
    <script src="/static/js/jquery-1.10.2.min.js"></script>
    <script src="/static/layui/layui.js"></script>
    <script src="/static/js/calendar.js"></script>
    <script src="/static/js/base.js"></script>
    <script type="text/javascript">
    $(document).ready(function(e) {
        Base.initialize();
        Base.urls = {
    message:"<?php echo U('message/addMessage');?>",
    reply_message:"<?php echo U('Admin/ReplyMessage/addReplyMessage');?>",
    upvote:"<?php echo U('Admin/message/upvote');?>",
    reply_upvote:"<?php echo U('Admin/ReplyMessage/upvote');?>",
    page:"<?php echo U('message/page');?>"
};

        CalendarHandler.initialize();
    });
        layui.use(['form','element'], function(){
            var form = layui.form(),
            element = layui.element(),
            $ = layui.jquery;

            //gotop
            $(window).scroll(function(){ 
                var scrH = document.documentElement.scrollTop + document.body.scrollTop; 
                if(scrH > 60){
                    $('#header').addClass('header_fixed').fadeIn();
                }else{
                    $('#header').removeClass('header_fixed');
                }

                if(scrH > 150){ 
                    $('#gotop').fadeIn(400); 
                }else{ 
                    $('#gotop').stop().fadeOut(400); 
                } 
            });

            $("#gotop").click(function(e) {
                e.preventDefault();
                $("html,body").animate({scrollTop:0},80);
            });

            //移动设备
            var treeMobile = $('.site-tree-mobile'),
                shadeMobile = $('.site-mobile-shade');
            treeMobile.on('click', function() {
                $('body').addClass('site-mobile');
            });
            shadeMobile.on('click', function() {
                $('body').removeClass('site-mobile');
            });
        });

    </script>
    
<script src="/static/js/reply.js"></script>
<script type="text/javascript">
    $(function(){
        Reply.initialize();
    });
</script>

    
</body>
</html>