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
        <?php if($art['auditing']): ?><div class="blog-detail shadow" data-id="<?php echo ($art["id"]); ?>" data-mid="<?php echo ($art["admin_id"]); ?>">
            <div class="blog-detail-title"><span><?php echo ($art["title"]); ?></span></div>
            <div class="blog-info">
                <span title="时间"><i class="iconfont" style="font-size: 17px;">&#xe665;</i><?php echo (format_datetime($art["addtime"],2)); ?></span>
                <span title="作者"><i class="layui-icon">&#xe612;</i><?php echo ($username); ?></span>
                <span title="标签"><i class="iconfont" style="font-size: 17px;">&#xe690;</i><?php echo ($art["name"]); ?></span>
                <span class="info" title="浏览次数"><i class="iconfont" style="font-size: 21px;">&#xe71a;</i><?php echo ($art["hit"]); ?></span>
                <span class="info" title="评论数"><a id="comment_count" href="#comment"><i class="iconfont" style="font-size: 17px;">&#xe6ad;</i><?php echo ($art["comment"]); ?></a></span>
            </div>
            <div class="blog-detail-content"><?php echo (htmlspecialchars_decode($art["content"])); ?></div>
            <div class="blog-detail-footer"> 
                <p>出自：Huason</p>
                <p>地址：<a href="<?php echo ($_SERVER['URL']); ?>" target="_blank"><?php echo ($art["title"]); ?></a></p>
                <p>转载请注明出处！</p>
            </div>
        </div><?php endif; ?>
        <div class="blog-tag shadow">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>评论</legend>
                <div class="layui-field-box">
                    <form class="layui-form blog-editor" id="comment-form">
                        <div class="layui-form-item">
                            <label class="layui-form-label box-label">名称：</label>
                            <div class="layui-input-inline">
                                <input type="text" name="reviewer" lay-verify="reviewer" placeholder="请输入名称" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <textarea class="layui-textarea layui-hide" name="content" lay-verify="content" id="remarkEditor" placeholder="请输入文章内容">
                            </textarea>
                        </div>
                        <div class="layui-form-item">
                            <button type="button" class="layui-btn layui-btn-normal" lay-submit="" lay-filter="remark">提交评论</button>
                        </div>
                    </form>
                </div>
            </fieldset>
            <h2>评论</h2>
            <div>
                <dd class="review" id="comment">
                </dd>
                <div class="hf">
                    <form class="layui-form"> 
                        <textarea id="reply_review_from" type="text" class="layui-textarea" name="content" autocomplete="off" maxlength="100" placeholder="请输入留言内容" lay-verify="reply_review" style="height:105px;"></textarea>
                        <button type="button" class="layui-btn layui-btn-normal" lay-submit="" lay-filter="reply_review" style="margin-top:10px;">回复</button>
                    </form>
                </div>
            </div>
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
        <div class="blog-tag shadow">
            <h2>热门文章</h2>
            <ul>
                <?php if(is_array($hot_list)): foreach($hot_list as $k=>$art): ?><li>
                <span class="num"><?php echo (zero_num($k+1)); ?></span><a title="<?php echo ($art["title"]); ?>" href="<?php echo U('/article/'.$art['id']);?>"><?php echo ($art["title"]); ?></a>
                <span class="info" title="浏览次数"><i class="iconfont" style="font-size: 16px;">&#xe71a;</i> <?php echo ($art['hit']); ?></span></li><?php endforeach; endif; ?>
            </ul>
        </div>
        <div class="blog-tag shadow">
            <h2>最新文章</h2>
            <ul>
                <?php if(is_array($new_list)): foreach($new_list as $k=>$art): ?><li>
                <span class="num"><?php echo (zero_num($k+1)); ?></span><a title="<?php echo ($art["title"]); ?>" href="<?php echo U('/article/'.$art['id']);?>"><?php echo ($art["title"]); ?></a>
                <span class="info" title="评论次数"><i class="iconfont" style="font-size: 15px;">&#xe6ad;</i> <?php echo ($art['comment']); ?></span><?php endforeach; endif; ?>
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
    review:"<?php echo U('review/addReview');?>",
    reply_review:"<?php echo U('Admin/ReplyReview/addReplyReview');?>",
    upvote:"<?php echo U('Admin/review/upvote');?>",
    upvote_reply:"<?php echo U('Admin/ReplyReview/upvote');?>",
    comment_page:"<?php echo U('review/page');?>"
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
    });
</script>

    
</body>
</html>