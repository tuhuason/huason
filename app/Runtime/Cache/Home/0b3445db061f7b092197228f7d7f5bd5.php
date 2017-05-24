<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Huason博客</title>
    <link rel="shortcut icon" href="/static/img/logo_60_60.png">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/global.css" media="all">
    
<link rel="stylesheet" type="text/css" href="/static/css/hwSlide.css">

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
            <div class="login">
                <?php if(!isset($_COOKIE['openID']) || !isset($_COOKIE['openID'])): ?><a title="qq登录"><i class="iconfont qqlogin">&#xe631;</i></a>
                <?php else: ?>
                    <a></a><?php endif; ?>
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
        
    <div class="tips shadow">
        <span><i class="layui-icon" style="margin-right: 10px;color: #009688;font-size: 18px;">&#xe645;</i>感谢访问本站！</span>
    </div>
    <div class="page-left">
        <div class="shadow hwslider" id="motto">
            <ul>
                <li><img class="motto_img" src="/static/img/big/1.jpg"><div class="title">生来倔强，We are young!</div></li>
                <li><img class="motto_img" src="/static/img/big/2.jpg"></li>
                <li><img class="motto_img" src="/static/img/big/3.jpg"></li>
                <li><img class="motto_img" src="/static/img/big/4.jpg"></li>
                <li><img class="motto_img" src="/static/img/big/5.jpg"></li>
                <li><img class="motto_img" src="/static/img/big/6.jpg"></li>
            </ul>

            
        </div>
    
        <?php if(empty($data)): ?><div class="blog-box-empty shadow">
            <div class="l-content">没有文章，请添加文章。</div>
        </div><?php endif; ?>
        <?php if(is_array($data)): foreach($data as $k=>$art): if($art['auditing']): ?><div class="blog-box shadow">
    <div class="l-img"><img src="/static/img/small/<?php echo ($k+1); ?>.png"></div>
    <div class="l-box">
        <div class="tab">
            <?php switch($art['tag']): case "置顶": ?><span class="stick">置顶</span><?php break;?>
                <?php case "置顶,精贴": ?><span class="fine">精贴</span>
                    <span class="stick">置顶</span><?php break;?>
                <?php case "精贴": ?><span class="fine">精贴</span><?php break;?>    
                <?php default: endswitch;?>
        </div>
        <div class="l-title"><a href="<?php echo U('/article/'.$art['id']);?>"><?php echo ($art["title"]); ?></a></div>
        <div class="l-content"><?php echo (htmlspecialchars_decode($art["content"])); ?></div>
    </div>
    <div class="clear"></div>
    <div class="l-footer">
        <span title="时间"><i class="iconfont" style="font-size: 17px;">&#xe665;</i><?php echo (format_datetime($art["addtime"],2)); ?></span>
        <span title="作者"><i class="layui-icon">&#xe612;</i><?php echo ($username); ?></span>
        <span title="标签"><i class="iconfont" style="font-size: 17px;">&#xe690;</i><?php echo ($art["name"]); ?></span>
        <span class="info" title="浏览次数"><i class="iconfont" style="font-size: 21px;">&#xe71a;</i><?php echo ($art["hit"]); ?></span>
        <span class="info" title="评论数"><i class="iconfont" style="font-size: 17px;">&#xe6ad;</i><?php echo ($art["comment"]); ?></span>
    </div>
</div><?php endif; endforeach; endif; ?>
    </div>
    <div class="page-right">
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
            <span class="info" title="浏览次数"><i class="iconfont" style="font-size: 16px;">&#xe71a;</i> <?php echo ($art['hit']); ?></span>
        </li><?php endforeach; endif; ?>
    </ul>
</div>
<div class="blog-tag shadow">
    <h2>近期热议</h2>
    <ul>
        <?php if(is_array($new)): foreach($new as $k=>$art): ?><li>
            <span class="num"><?php echo (zero_num($k+1)); ?></span><a title="<?php echo ($art["title"]); ?>" href="<?php echo U('/article/'.$art['id']);?>"><?php echo ($art["title"]); ?></a>
            <span class="info" title="评论次数"><i class="iconfont" style="font-size: 15px;">&#xe6ad;</i> <?php echo ($art['comment']); ?></span>
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
<script src="/static/js/hwSlide.min.js"></script>
<script type="text/javascript">
    $(function(){
        Index.initialize({
           
        });
        $("#motto").hwSlider({
            height:385,
            autoPlay: false,
            arrShow: true,
            dotShow: true,
            touch: true
        });

        layui.use(['layer','form','element','flow'], function(){
            var layer = layui.layer,
                form = layui.form(),
                element = layui.element(),
                $ = layui.jquery,
                flow = layui.flow;

            flow.lazyimg({
                elem: '#motto img'
            });


            // layer.open({
            //     type: 2,
            //     title: false,
            //     area: ['630px', '360px'],
            //     shade: 0.8,
            //     closeBtn: 0,
            //     shadeClose: true,
            //     content: '//player.youku.com/embed/XMjY3MzgzODg0'
            // });
            // layer.open({
            //     type: 1
            //     ,title: false //不显示标题栏
            //     ,closeBtn: false
            //     ,area: '300px;'
            //     ,shade: 0.8
            //     ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
            //     ,btn: ['火速围观']
            //     ,moveType: 1 //拖拽模式，0或者1
            //     ,content: ''
            //     ,success: function(layero){
            //         var btn = layero.find('.layui-layer-btn');
            //         btn.css('text-align', 'center');
            //     }
            // });

        });
    });
</script>

    
</body>
</html>