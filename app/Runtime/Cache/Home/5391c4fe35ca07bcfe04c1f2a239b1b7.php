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
        
<!--     <div class="layui-breadcrumb crumbs shadow" lay-separator="/">         
        <a href="/">首页</a>
        <a>文章</a> 
    </div> -->
    <div class="page-left">
        <div id="article_list" data-name="<?php echo ($username); ?>">
            <?php if(empty($hot)): ?><div class="blog-box-empty shadow">
                <div class="l-content">没有文章，请添加文章。</div>
            </div><?php endif; ?>
        </div>
    </div>
    <div class="page-right topic">
        <div class="blog-tag shadow">
    <h2>分类</h2>
    <div class="category">
        <ol>
            <?php if(is_array($category)): foreach($category as $key=>$cate): ?><li><a href="<?php echo U('article/'.$cate['description']);?>" class="layui-btn layui-btn-primary"><?php echo ($cate["name"]); ?>(<?php echo ($cate["count"]); ?>)</a></li><?php endforeach; endif; ?>
        </ol>
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
page:"<?php echo U('article/page');?>"
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
    
<script src="/static/js/index.js"></script>
<script type="text/javascript">
    $(function(){
        Index.initialize({
        });
        Base.url('article_page',"<?php echo U('article/page');?>");
    });
</script>

    
</body>
</html>