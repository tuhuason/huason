<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Huason博客</title>
    <link rel="shortcut icon" href="/static/img/favicon.png">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/global.css" media="all">
    
<style type="text/css">
</style>

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
        <a href="/">首页</a>
        <a>日记</a> 
    </div>
    <div class="wrap">
        <?php if(empty($data)): ?><div class="blog-box-empty shadow">
            <div class="l-content">没有日记，请添加日记。</div>
        </div>
        <?php else: ?>
        <div class="box shadow">
            <div class="history">
                <h2>How time flies</h2>
                <div class="timeline-line"></div>
                <?php if(is_array($data)): foreach($data as $time=>$diys): ?><div class="history-date">
                    <ul>
                        <h2 class="first">
                            <a href="javascript:;"><?php echo ($time); ?>年<i class="layui-icon" style="vertical-align: middle;text-decoration:none;">&#xe625;</i></a>
                        </h2>
                        <?php if(is_array($diys)): foreach($diys as $key=>$diy): ?><li class="green">
                            <h3><?php echo (date('m-d',$diy["addtime"])); ?><span><?php echo (date('H:i:s',$diy["addtime"])); ?></span></h3>
                            <i class="layui-icon dot-circle">&#xe643;</i>
                            <div class="log-content">
                                <?php echo (htmlspecialchars_decode($diy["content"])); ?>
                            </div>
                            <div class="clear"></div>
                        </li><?php endforeach; endif; ?>
                    </ul>
                </div><?php endforeach; endif; ?>
            </div>
        </div><?php endif; ?>
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
        Index.systole();
    });
</script>

    
</body>
</html>