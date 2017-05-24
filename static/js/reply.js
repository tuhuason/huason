var Reply = {
    initialize : function() {
        layui.use(['form','element','layedit','flow','laypage'], function(){
            var form = layui.form(),
                element = layui.element(),
                layedit = layui.layedit,
                flow = layui.flow,
                laypage = layui.laypage;

            var messageIndex = layedit.build('messageEditor',{height: 150,tool: ['face']});

            form.render();
            form.verify({
                commenter: [/(.+){2,12}$/, '名称必须2到12位'],
                message_content: function(value){
                    value = $.trim(layedit.getText(messageIndex));
                    if(value == ''){
                        return '至少一个字吧';
                    }
                    layedit.sync(messageIndex);//同步内容
                }
            });
            //提交留言
            form.on('submit(message)', function(data){
                var name = data.field['commenter'],
                    content = data.field['content'],
                    addtime = new Date().getTime(),
                    rand_str = Base.genNonDuplicateID(),
                    datas = {commenter:name,content:content,addtime:Math.floor(addtime/1000),identifier:rand_str},
                    comment = $('#message');

                Base.ajax({
                    type: 'post',
                    url: Base.url('message'),
                    data: {data : datas},
                    success: function (res) {
                        if (res.status == 'ok') {
                            var html = '<dl class="list identifier" data-id="'+rand_str+'">';
                                html += '<img class="comment-avatar" src="'+Base.paths.image+'/lufei.jpg" alt=""/>';
                                html += '<div class="comment-body">';
                                html += '<div class="comment-header"><span class="name">'+name+'</a></span><span class="date">'+Base.format_datetime(addtime/1000)+'</span></div>';
                                html += '<div class="comment-content">'+Base.html_decode(content)+'</div>';
                                html += '<div class="comment-footer"><a></a></div>';
                                html += '</div>';
                                html += '<dd class="children">';
                                html += '</dd>';
                                html += '</dl>';
                            comment.prepend(html);
                            $('#message-form input[name="commenter"]').val('');
                            $('#message-form textarea[name="content"]').val('');
                            messageIndex = layedit.build('messageEditor',{height: 150,tool: ['face']});
                            layer.msg('留言成功',{time:1500});
                        } else {
                            layer.msg(res.errdesc,{offset:'120px',time:1500});
                            return false;
                        }
                    }
                });
            });

            //留言分页
            flow.load({
                elem: '#message', //指定列表容器
                isAuto: false,
                end: '哥，这回真没了',
                done: function (page, next) {
                    var lis = [];   
    
                    Base.ajax({
                        type: 'post',
                        url: Base.url('page'),
                        data: {page: page, num: 4},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $.each(res.results.message, function(index, message){
                                    var html = '<dl class="list identifier" data-id="'+message.identifier+'">';
                                        html += '<img class="comment-avatar" src="'+Base.paths.image+'/lufei.jpg" alt=""/>';
                                        html += '<div class="comment-body">';
                                        html += '<div class="comment-header"><span class="name">'+message.commenter+'</a></span><span class="date">'+Base.format_datetime(message.addtime)+'</span></div>';
                                        html += '<div class="comment-content">'+Base.html_decode(message.content)+'</div>';
                                        html += '<div class="comment-footer">';
                                        if('我'==message.commenter){
                                            html += '<a></a>';
                                        }else{
                                            html += '<a class="comment-upvote"><i class="iconfont" style="font-size: 19px;">&#xe6ce;</i> (<em>'+message.upvote+'</em>)</a><a class="comment-reply"><span>回复</span> (<em>'+message.count+'</em>)</a>';
                                        }
                                        html += '</div>';
                                        html += '</div>';
                                        html += '<dd class="children">';
                                        $.each(res.results.reply_message, function(index, reply){
                                            if(message.commenter == reply.reply_master){
                                                html += '<dl class="list reply_identifier" data-id="'+reply.identifier+'">';
                                                html += '<img class="comment-avatar" src="'+Base.paths.image+'/lufei.jpg" alt=""/>';
                                                html += '<div class="comment-body">';
                                                html += '<div class="comment-header"><span class="user">我</span> 回复 <span class="commenter">'+reply.reply_master+'</span><span class="date">'+Base.format_datetime(reply.addtime)+'</span></div>';
                                                html += '<div class="comment-content">'+Base.html_decode(reply.content)+'</div>';
                                                html += '<div class="comment-footer">';
                                                // if('我'==reply.reply_commenter){
                                                //     html += '<a></a>';
                                                // }else{
                                                    html += '<a class="comment-upvote"><i class="iconfont" style="font-size: 19px;">&#xe6ce;</i> (<em>'+reply.upvote+'</em>)</a><a class="comment-reply"><span>回复</span></a>';
                                                // }
                                                html += '</div>';
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
            //end

            $('#message').on('click','.comment-upvote',function(e){
                
                var $em = $(this).find('em'),
                    upvote = parseInt($em.text()),
                    identifier = $(this).parents('.identifier').attr('data-id'),
                    reply_identifier = $(this).parents('.reply_identifier').attr('data-id'),
                    children = $(this).parents('.children');

                $(this).removeClass('comment-upvote').addClass('comment-upvoted');

                if(children.length == 1){
                    var datas = {type:'add',identifier:reply_identifier};
                    Base.ajax({
                        type: 'post',
                        url: Base.url('reply_upvote'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $em.text(upvote+1);
                                layer.msg('点赞成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                }else{
                    var datas = {type:'add',identifier:identifier};
                    Base.ajax({
                        type: 'post',
                        url: Base.url('upvote'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $em.text(upvote+1);
                                layer.msg('点赞成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                }
            });

            $('#message').on('click','.comment-upvoted',function(e){
                var $em = $(this).find('em'),
                    upvote = parseInt($em.text()),
                    identifier = $(this).parents('.identifier').attr('data-id'),
                    reply_identifier = $(this).parents('.reply_identifier').attr('data-id'),
                    children = $(this).parents('.children');

                $(this).addClass('comment-upvote').removeClass('comment-upvoted');

                if(children.length == 1){
                    var datas = {type:'delete',identifier:reply_identifier};
                    Base.ajax({
                        type: 'post',
                        url: Base.url('reply_upvote'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $em.text(upvote-1)
                                layer.msg('取消点赞成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                }else{
                    var datas = {type:'delete',identifier:identifier};
                    Base.ajax({
                        type: 'post',
                        url: Base.url('upvote'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                $em.text(upvote-1)
                                layer.msg('取消点赞成功',{time:1500});
                            } else {
                                layer.msg(res.errdesc,{offset:'120px',time:1500});
                                return false;
                            }
                        }
                    });
                }
            });

            var replyIndex = layedit.build('reply_message_from',{height: 60,tool: ['face']});

            form.verify({
                reply_content: function(value){
                    value = $.trim(layedit.getText(replyIndex));
                    if(value == ''){
                        return '至少一个字吧';
                    }
                    layedit.sync(replyIndex);//同步内容
                }
            });

            //取消回复
            $('#message').on('click','.close-reply',function(){
                $(this).removeClass('close-reply').addClass('comment-reply');
                $(this).find('span').text('回复');
                $('.comment-footer').css("padding-bottom", "10px");
                $("div.hf").css("display", "none");
            });

            //点击回复事件
            $('#message').on('click','.comment-reply',function(e){
                e.stopPropagation();
                e.preventDefault();

                $('.close-reply').find('span').text('回复');
                $('.close-reply').removeClass('close-reply').addClass('comment-reply');
                $(this).addClass('close-reply').removeClass('comment-reply');

                // 点击当前回复显示
                $(".comment-footer").css("padding-bottom", "10px");
                $("div.hf").css({ "top": $(this).offset().top -100, "display": "none"});
                $("div.hf").toggle();
                $(this).parent().css("padding-bottom", "175px");

                //初始化内容
                $("div.hf").find('textarea[name="content"]').val('');
                replyIndex = layedit.build('reply_message_from',{height: 60,tool: ['face']});

                var parents = $(this).parents('dl.list'),
                    name = $(this).parent().parent().find('span.name').text(),
                    user = $(this).parent().parent().find('span.user').text(),
                    div = parents.find('dd.children'),
                    $num = $(this).find('em');

                $(this).find('span').text('收起');

                //提交回复
                form.on('submit(reply_message)', function(data){
                    var content = data.field['content'],
                        rand_str = Base.genNonDuplicateID(),
                        addtime = new Date().getTime();

                    if(user){
                        datas = {reply_commenter:'我', reply_master:user, content:content, identifier:rand_str, addtime:Math.floor(addtime/1000)};
                    }else{
                        datas = {reply_commenter:'我', reply_master:name, content:content, identifier:rand_str, addtime:Math.floor(addtime/1000)};
                    }

                    Base.ajax({
                        type: 'post',
                        url: Base.url('reply_message'),
                        data: {data : datas},
                        success: function (res) {
                            if (res.status == 'ok') {
                                //获取每条留言的innerHTML结构，每次只替换textarea的输入内容和 当前发送时间
                                var html = '<dl class="list reply_identifier" data-id="'+rand_str+'">';
                                    html += '<img class="comment-avatar" src="'+Base.paths.image+'/lufei.jpg" alt=""/>';
                                    html += '<div class="comment-body">';
                                    html += '<div class="comment-header"><span class="user">我</span> 回复 <span class="commenter">'+(user!= false?user:name)+'</span><span class="date">'+Base.format_datetime(addtime/1000)+'</span></div>';
                                    html += '<div class="comment-content">'+Base.html_decode(content)+'</div>';
                                    html += '<div class="comment-footer"><a></a></div>';
                                    html += '</div>';
                                    html += '</dl>';

                                //把新留言插入到留言列表
                                div.append(html);
                                $('.hf textarea[name="content"]').val('');
                                replyIndex = layedit.build('reply_message_from',{height: 60,tool: ['face']});
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
}