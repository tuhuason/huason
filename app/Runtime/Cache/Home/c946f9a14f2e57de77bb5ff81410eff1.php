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
                <button type="submit" class="search_btn"><i class="layui-icon" id="search">&#xe615;</i></button>
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
    <a href="<?php echo ($crumbs["url"]); ?>"><?php echo ($crumbs["title"]); ?></a> 
</div>
    <div id="photos" class="">
        <ul>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/1.jpg" lay-src="/static/img/small/1.png">
                <div class="mask"><a href="javascript:;">平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/2.jpg" lay-src="/static/img/small/2.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/3.jpg" lay-src="/static/img/small/3.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/4.jpg" lay-src="/static/img/small/4.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/5.jpg" lay-src="/static/img/small/5.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/6.jpg" lay-src="/static/img/small/6.png">
                <div class="mask"><a>青春飞扬</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/7.jpg" lay-src="/static/img/small/7.png">
                <div class="mask"><a href="javascript:;">平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/8.jpg" lay-src="/static/img/small/8.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/9.jpg" lay-src="/static/img/small/9.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/10.jpg" lay-src="/static/img/small/10.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/11.jpg" lay-src="/static/img/small/11.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/12.jpg" lay-src="/static/img/small/12.png">
                <div class="mask"><a>平潭</a></div>
            </li>
            <li class="container shadow">
                <img layer-pid="" layer-src="/static/img/big/13.jpg" lay-src="/static/img/small/13.png">
                <div class="mask"><a>平潭</a></div>
            </li>
        </ul>
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
        CyIndex.initialize({
           
        });

        $(".container").bind("mouseenter mouseleave",function(e) {
            var w = $(this).width();
            var h = $(this).height();
            var x = (e.pageX - this.offsetLeft - (w / 2)) * (w > h ? (h / w) : 1);
            var y = (e.pageY - this.offsetTop - (h / 2)) * (h > w ? (w / h) : 1);
            $('#x').html(this.offsetLeft);
            $('#y').html(this.offsetTop);
            var direction = Math.round((((Math.atan2(y, x) * (180 / Math.PI)) + 180) / 90) + 3) % 4;
            //direction的值为“0,1,2,3”分别对应着“上，右，下，左”
            $('#p').html(Math.atan2(y, x) * (180 / Math.PI));
            var eventType = e.type;
            //alert(e.type);
            if(e.type == 'mouseenter'){
                if(direction==0){
                    $(this).find('.mask').css({'display':'block','top':-h+'px','left':'0px'}).animate({'top':'0px'},200);
                }else if(direction==1){
                    $(this).find('.mask').css({'display':'block','left':w+'px','top':'0px'}).animate({'left':'0px'},200);
                }else if(direction==2){
                    $(this).find('.mask').css({'display':'block','top':h+'px','left':'0px'}).animate({'top':'0px'},200);
                }else if(direction==3){
                    $(this).find('.mask').css({'display':'block','left':-w+'px','top':'0px'}).animate({'left':'0px'},200);
                }
            }else{
                if(direction==0){
                    $(this).find('.mask').animate({'top':-h+'px'},50);
                }else if(direction==1){
                    $(this).find('.mask').animate({'left':w+'px'},50);
                }else if(direction==2){
                    $(this).find('.mask').animate({'top':h+'px'},50);
                }else if(direction==3){
                    $(this).find('.mask').animate({'left':-w+'px'},50);
                }
            }
        });
        layui.use(['layer','form','element','flow'], function(){
            var layer = layui.layer,
                form = layui.form(),
                element = layui.element(),
                $ = layui.jquery,
                flow = layui.flow;

            flow.lazyimg({
                elem: '#photos img'
            });

            layer.photos({
                photos: '#photos',
                anim:-1,
                shade:0.1,resize:false,
                tab: function(pic, layero){
                    console.log(pic) //当前图片的一些信息
                  }
            });
        });
    });
</script>

    
</body>
</html>