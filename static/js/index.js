/*首页*/
var Index = {
    // 初始化
    initialize : function(settings) {
        layui.use(['form','element','layedit','flow','laypage'], function(){
            var form = layui.form(),
                element = layui.element(),
                layedit = layui.layedit,
                flow = layui.flow,
                laypage = layui.laypage;

            var remarkIndex = layedit.build('remarkEditor',{height: 150,tool: ['face']}),
                openid = $('#header .login').find('span[type="openid"]').text(),
                img = $('#header .login').find('img').attr('src'),
                name = $('#header .login').find('a[type="nickname"]').text(),
                master_id = $('#header .login').find('a[type="master_id"]').text();
                
            form.render();
            form.verify({
                content: function(value){
                    value = $.trim(layedit.getText(remarkIndex));
                    if(value == ''){
                        return '至少一个字吧';
                    }
                    layedit.sync(remarkIndex);//同步内容
                }
            });
            
            form.on('submit(remark)', function(data){
                var img = $('#header .login').find('img').attr('src'),
                    content = data.field['content'],
                    articleId = $('.blog-detail').attr('data-id'),
                    masterID = $('.blog-detail').attr('data-mid'),
                    addtime = new Date().getTime(),
                    rand_str = Base.genNonDuplicateID(),
                    datas = {reviewer:name,openid:openid,content:content,article_id:articleId,master_id:master_id,identifier:rand_str,addtime:Math.floor(addtime/1000)},
                    comment = $('#comment');

                Base.ajax({
                    type: 'post',
                    url: Base.url('review'),
                    data: {data : datas},
                    success: function (res) {
                        if (res.status == 'ok') {
                            var html = '<dl class="list identifier" data-id="'+rand_str+'">';
                                html += '<img class="comment-avatar" src="'+img+'" alt=""/>';
                                html += '<div class="comment-body">';
                                html += '<div class="comment-header"><span class="name">'+((openid == '2D1DFA0DEA2990CF49AB2EDE8C371D16') ? '<a>'+name+'</a><span class="commenter_role">博主</span>' : '<a>'+name+'</a>')+'</a></span><span type="openid" class="layui-hide">'+openid+'</span><span class="date">'+Base.format_datetime(addtime/1000)+'</span></div>';
                                html += '<div class="comment-content">'+content+'</div>';
                                html += '<div class="comment-footer"><a class=""><i class="iconfont" style="font-size: 19px;">&#xe6ce;</i> (<em>0</em>)</a><a class=""><span>回复</span> (<em>0</em>)</a></div>';
                                html += '</div>';
                                html += '<dd class="children">';
                                html += '</dd>';
                                html += '</dl>';

                            comment.prepend(html);

                            $('#comment-form input[name="reviewer"]').val('');
                            $('#comment-form textarea[name="content"]').val('');
                            remarkIndex = layedit.build('remarkEditor',{height: 150,tool: ['face']});
                            layer.msg('评论成功',{time:1500});
                        } else {
                            layer.msg(res.errdesc,{offset:'120px',time:1500});
                            return false;
                        }
                    }
                });
            });

            flow.load({
                elem: '#article_list', //指定列表容器
                isAuto: false,
                end: '哥，这回真没了',
                mb: 200,
                done: function (page, next) {
                    var lis = [],
                        username = $('#article_list').attr('data-name');   
    
                    Base.ajax({
                        type: 'post',
                        url: Base.url('article_page'),
                        data: {page: page, num: 5},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $.each(res.results.data, function(index, art){
                                    var html = '<div class="blog-box shadow">';
                                    html += '<div class="l-img"><img src="http://q.qlogo.cn/qqapp/101399999/2D1DFA0DEA2990CF49AB2EDE8C371D16/100"></div>';
                                    html += '<div class="l-box">';
                                    html += '<div class="tab">'+Base.tags(art.tag)+'</div><div class="l-title"><a href="/article/'+art.id+'">'+art.title+'</a></div>';
                                    html += '<div class="l-content">'+art.content+'</div>';
                                    html += '</div>';
                                    html += '<div class="clear"></div>';
                                    html += '<div class="l-footer">';
                                    html += '<span title="时间"><i class="iconfont" style="font-size: 17px;">&#xe665;</i>'+Base.format_datetime(art.addtime)+'</span>';
                                    html += '<span title="作者"><i class="layui-icon">&#xe612;</i>'+username+'</span>';
                                    html += '<span title="标签"><a href="/article/'+art.description+'" class="comment"><i class="iconfont" style="font-size: 17px;">&#xe690;</i>'+art.name+'</a></span>';
                                    html += '<span class="info" title="浏览次数"><i class="iconfont" style="font-size: 21px;">&#xe71a;</i>'+art.hit+'</span>';
                                    html += '<span class="info" title="评论数"><a href="/article/'+art.id+'/#comment" class="comment"><i class="iconfont" style="font-size: 17px;">&#xe6ad;</i>'+art.comment+'</a></span>';
                                    html += '</div>';
                                    html += '</div>';
                                    lis.push(html);
                                }); 
                            
                                next(lis.join(''), page < res.results.total_page);    
                            } else {
                                layer.msg('获取数据失败', { icon: 2 });
                            }
                        }
                    });
                }
            });

            var art_id = $('.blog-detail').attr('data-id');

            if(art_id){
                var replyIndex = layedit.build('reply_review_from',{height: 60,tool: ['face']});
                form.render();
                form.verify({
                    reply_review: function(value){
                        value = $.trim(layedit.getText(replyIndex));
                        if(value == ''){
                            return '至少一个字吧';
                        }
                        layedit.sync(replyIndex);//同步内容
                    }
                });

                //文章评论分页
                flow.load({
                    elem: '#comment', //指定列表容器
                    isAuto: false,
                    end: '哥，这回真没了',
                    done: function (page, next) {
                        var lis = [];   
        
                        Base.ajax({
                            type: 'post',
                            url: Base.url('comment_page'),
                            data: {page: page, num: 4, id:art_id},
                            success: function (res) {
                                if (res.status == 'ok') {
                                    $.each(res.results.comment, function(index, comment){
                                        var html = '<dl class="list identifier" data-id="'+comment.identifier+'">';
                                            html += '<img class="comment-avatar" src="'+comment.avatar+'" alt=""/>';
                                            html += '<div class="comment-body">';
                                            html += '<div class="comment-header"><span class="name">'+((comment.openid == '2D1DFA0DEA2990CF49AB2EDE8C371D16') ? '<a>'+comment.reviewer+'</a><span class="commenter_role">博主</span>' : '<a>'+comment.reviewer+'</a>')+'</span><span type="openid" class="layui-hide">'+comment.openid+'</span><span class="date">'+Base.format_datetime(comment.addtime)+'</span></div>';
                                            html += '<div class="comment-content">'+comment.content+'</div>';
                                            html += comment.reviewer == name ? '<div class="comment-footer"><a class=""><i class="iconfont" style="font-size: 19px;">&#xe6ce;</i> (<em>'+comment.upvote+'</em>)</a><a class=""><span>回复</span> (<em>'+comment.count+'</em>)</a></div>' :'<div class="comment-footer"><a class="comment-upvote"><i class="iconfont" style="font-size: 19px;">&#xe6ce;</i> (<em>'+comment.upvote+'</em>)</a><a class="comment-reply"><span>回复</span> (<em>'+comment.count+'</em>)</a></div>';
                                            html += '</div>';
                                            html += '<dd class="children">';
                                            $.each(res.results.reply_review, function(index, reply){
                                                if(comment.identifier == reply.master_identifier){
                                                    html += '<dl class="list reply_identifier" data-id="'+reply.identifier+'">';
                                                    html += '<img class="comment-avatar" src="'+reply.avatar+'" alt=""/>';
                                                    html += '<div class="comment-body">';
                                                    html += '<div class="comment-header"><span class="user">'+((reply.openid == '2D1DFA0DEA2990CF49AB2EDE8C371D16') ? '<a>'+reply.reply_reviewer+'</a><span class="commenter_role">博主</span>' : '<a>'+reply.reply_reviewer+'</a>')+'</span><span type="openid" class="layui-hide">'+reply.openid+'</span> 回复 <span class="commenter">';
                                                    html += ( (reply.master_openid == '2D1DFA0DEA2990CF49AB2EDE8C371D16')? '<a>'+reply.reply_master+'</a><span class="commenter_role">博主</span>' : '<a>'+reply.reply_master+'</a>')+'</span><span type="openid" class="layui-hide">'+reply.master_openid+'</span><span class="date">'+Base.format_datetime(reply.addtime)+'</span></div>';
                                                    html += '<div class="comment-content">'+reply.content+'</div>';
                                                    html += reply.reply_reviewer == name ? '<div class="comment-footer"><a class=""><i class="iconfont" style="font-size: 19px;">&#xe6ce;</i> (<em>'+reply.upvote+'</em>)</a><a class=""><span>回复</span></a></div>' :'<div class="comment-footer"><a class="comment-upvote"><i class="iconfont" style="font-size: 19px;">&#xe6ce;</i> (<em>'+reply.upvote+'</em>)</a><a class="comment-reply"><span>回复</span></a></div>';
                                                    html += '</div>';
                                                    html += '</dl>';
                                                }
                                            });
                                            html += '</dd>';
                                            html += '</dl>';
                                        lis.push(html);
                                    }); 
                                
                                    next(lis.join(''), page < res.results.total_page);    
                                } else {
                                    layer.msg('获取数据失败', { icon: 2 });
                                }
                            }
                        });
                    }
                });
            }
            $('#comment_count').on('click',function(e){
                var comment_top = $('#comment').offset().top;
                $('html,body').animate({scrollTop:comment_top-100},500);
            });

            //点赞事件
            $('#comment').on('click','.comment-upvote',function(e){
                
                var $this = $(this),
                    upvote = parseInt($this.find('em').text()),
                    identifier = $(this).parents('.identifier').attr('data-id'),
                    reply_identifier = $(this).parents('.reply_identifier').attr('data-id'),
                    current_openid = $this.parent().parent().find('span[type="openid"]:eq(0)').text(),
                    children = $(this).parents('.children');

                if(children.length == 1){
                    var datas = {type:'add',identifier:reply_identifier,openid:current_openid};
                    Base.ajax({
                        type: 'post',
                        url: Base.url('upvote_reply'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $this.find('em').text(upvote+1);
                                $this.removeClass('comment-upvote').addClass('comment-upvoted');
                                layer.msg('点赞成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                }else{
                    var datas = {type:'add',identifier:identifier,openid:current_openid};
                    Base.ajax({
                        type: 'post',
                        url: Base.url('upvote'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $this.find('em').text(upvote+1);
                                $this.removeClass('comment-upvote').addClass('comment-upvoted');
                                layer.msg('点赞成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                }
            });

            //取消点赞事件
            $('#comment').on('click','.comment-upvoted',function(e){
                var $this = $(this),
                    upvote = parseInt($this.find('em').text()),
                    identifier = $(this).parents('.identifier').attr('data-id'),
                    reply_identifier = $(this).parents('.reply_identifier').attr('data-id'),
                    current_openid = $this.parent().parent().find('span[type="openid"]:eq(0)').text(),
                    children = $(this).parents('.children');

                if(children.length == 1){
                    var datas = {type:'delete',identifier:reply_identifier,openid:current_openid};
                    Base.ajax({
                        type: 'post',
                        url: Base.url('upvote_reply'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $this.find('em').text(upvote-1);
                                $this.addClass('comment-upvote').removeClass('comment-upvoted');
                                layer.msg('取消点赞成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                }else{
                    var datas = {type:'delete',identifier:identifier,openid:current_openid};
                    Base.ajax({
                        type: 'post',
                        url: Base.url('upvote'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $this.find('em').text(upvote-1);
                                $this.addClass('comment-upvote').removeClass('comment-upvoted');
                                layer.msg('取消点赞成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                }
            });

            //取消回复
            $('#comment').on('click','.close-reply',function(){
                $(this).removeClass('close-reply').addClass('comment-reply');
                $(this).find('span').text('回复');
                $('.comment-footer').css("padding-bottom", "10px");
                $("div.hf").css("display", "none");
            });

            //点击回复事件
            $('#comment').on('click','.comment-reply',function(e){
                e.stopPropagation();
                e.preventDefault();

                $('.close-reply').find('span').text('回复');
                $('.close-reply').removeClass('close-reply').addClass('comment-reply');
                $(this).addClass('close-reply').removeClass('comment-reply');

                // 点击当前回复显示
                $(".comment-footer").css("padding-bottom", "10px");
                var parent_top = $(this).parents('.blog-tag').offset().top,
                    top = $(this).offset().top;

                $("div.hf").css({ "top": top-parent_top+25 ,"display": "block", });
                $(this).parent().css("padding-bottom", "175px");

                //初始化内容
                $('.hf textarea[name="content"]').val('');
                replyIndex = layedit.build('reply_review_from',{height: 60,tool: ['face']});

                $(this).find('span').text('收起');

                var parents = $(this).parents('dl.list'),
                    master = $(this).parent().parent().find('span.name a').text(),
                    master_openid = $(this).parent().parent().find('span[type="openid"]').text(),
                    master_identifier = $(this).parents('.identifier').attr('data-id'),
                    user = $(this).parent().parent().find('span.user a').text(),
                    user_openid = $(this).parent().parent().find('span[type="openid"]').text(),
                    $num = $(this).parents('dl.identifier').find('em:eq(1)'),
                    div = parents.find('dd.children');

                //取消回复
                $("div.hf").find('.close-reply').on('click',function(){
                    $('.comment-footer').css("padding-bottom", "10px");
                    $("div.hf").css("display", "none");
                });

                //提交回复
                form.on('submit(reply_review)', function(data){

                    var content = data.field['content'],
                        rand_str = Base.genNonDuplicateID(),
                        addtime = new Date().getTime();

                    if(user){
                        datas = {reply_reviewer:name, reply_master:user, master_identifier: master_identifier, openid:openid, master_openid:user_openid, article_id: art_id, content:content, identifier:rand_str, addtime:Math.floor(addtime/1000)};
                    }else{
                        datas = {reply_reviewer:name, reply_master:master, master_identifier: master_identifier, openid:openid, master_openid:master_openid, article_id: art_id, content:content, identifier:rand_str, addtime:Math.floor(addtime/1000)};
                    }

                    Base.ajax({
                        type: 'post',
                        url: Base.url('reply_review'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                var html = '<dl class="list reply_identifier" data-id="'+rand_str+'">';
                                    html += '<img class="comment-avatar" src="'+img+'"/>';
                                    html += '<div class="comment-body">';
                                    html += '<div class="comment-header"><span class="user">'+((openid == '2D1DFA0DEA2990CF49AB2EDE8C371D16') ? '<a>'+name+'</a><span class="commenter_role">博主</span>' : '<a>'+name+'</a>')+'</span> 回复 <span class="commenter">';
                                    html += (user!= false?((user_openid == '2D1DFA0DEA2990CF49AB2EDE8C371D16') ? '<a>'+user+'</a><span class="commenter_role">博主</span>' : '<a>'+user+'</a>'):((master_openid == '2D1DFA0DEA2990CF49AB2EDE8C371D16') ? '<a>'+master+'</a><span class="commenter_role">博主</span>' : '<a>'+master+'</a>'))+'</span><span class="date">'+Base.format_datetime(addtime/1000)+'</span></div>';
                                    html += '<div class="comment-content">'+content+'</div>';
                                    html += '<div class="comment-footer"><a class=""><i class="iconfont" style="font-size: 19px;">&#xe6ce;</i> (<em>0</em>)</a><a class=""><span>回复</span></a></div>';
                                    html += '</div>';
                                    html += '</dl>';

                                (user == false)?div.prepend(html):div.append(html);
                                $('.hf textarea[name="content"]').val('');
                                replyIndex = layedit.build('reply_review_from',{height: 60,tool: ['face']});
                                var num = parseInt($num.text());
                                $num.text(num+1);
                                form.render();
                                layer.msg('回复成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                });
            });

            
        });
    }

    // 日记
    ,systole : function(){
        if(!$(".history").length){
            return;
        }
        var $warpEle = $(".history-date"),
            $targetA = $warpEle.find("h2 a,ul li dl dt a"),
            parentH,
            eleTop = [];
        
        parentH = $warpEle.parent().height();
        $warpEle.parent().css({"height":59});
        
        setTimeout(function(){
            
            $warpEle.find("ul").children(":not('h2:first')").each(function(idx){
                eleTop.push($(this).position().top);
                $(this).css({"margin-top":-eleTop[idx]}).children().hide();
            }).animate({"margin-top":0}, 800).children().fadeIn();

            $warpEle.parent().animate({"height":"100%"}, 800);

            $warpEle.find("ul").children(":not('h2:first')").addClass("animated").end().children("h2").css({"position":"relative"});
            
        }, 600);

        $targetA.click(function(){
            $(this).parent().css({"position":"relative"});
            $(this).parent().siblings().slideToggle();
            $warpEle.parent().removeAttr("style");
            return false;
        });
    }
};
