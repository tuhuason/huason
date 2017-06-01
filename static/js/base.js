/*基础JS*/
var Base = {
    // 路径设置
    paths : {
        static : '/static',
        brand : '/static/brand',
        css : '/static/css',
        // i18n : '/static/i18n',
        image : '/static/img',
        js : '/static/js',
        plugin : '/static/plugin'
    },

    // 当前页面标识符
    pageIdentifier : '',

    // 当前页面支持的URLs
    urls : {},
    
    // 初始化
    initialize : function(settings) {
        $("#verify_img").on('click',function() {
            $("#verify_img").attr({"src" : Base.url('verify')});
        });

        $('.layui-main .page-right .blog-tag').find('span.num:eq(0)').css('background-color','#009688');
        $('.layui-main .page-right .blog-tag').find('span.num:eq(1)').css('background-color','#2196f3');
        $('.layui-main .page-right .blog-tag').find('span.num:eq(2)').css('background-color','#5fb878');

        //移动设备
        var treeMobile = $('.site-tree-mobile'),
            shadeMobile = $('.site-mobile-shade');
        treeMobile.on('click', function() {
            $('body').addClass('site-mobile');
        });
        shadeMobile.on('click', function() {
            $('body').removeClass('site-mobile');
        });
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
        
        //mobile gotop
        $(window).scroll(function(){ 
            var scrH=document.documentElement.scrollTop+document.body.scrollTop; 
            if(scrH>200){ 
                $('#gotop').fadeIn(400); 
            }else{ 
                $('#gotop').stop().fadeOut(400); 
            }

        });

        $("#gotop").click(function(e) {
            e.preventDefault();
            $("html,body").animate({scrollTop:0},80);
        });

        layui.use(['layer','form','element'], function(){
            var form = layui.form(),
                layer = layui.layer,
                element = layui.element();

            $(document).on('click','.btn-cancel',function(){
                layer.closeAll();
            });

            //自定义验证规则
            form.verify({
                user: [/(.+){5,12}$/, '用户名必须5到12位']
                ,pass: [/(.+){6,12}$/, '密码必须6到12位']
                ,code: function(value){
                    if(value == ''){
                        return '请输入验证码';
                    }
                }
            });
      
            form.on('submit(reg)', function(data){

                var username = data.field['adminuser'],
                    password = data.field['password'],
                    code = data.field['code'];

                var datas = {adminuser:username,password:password,code:code}
                $.ajax({
                    url :Base.url('reg'),
                    type:'post',
                    data : {data:datas},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.msg(data.results,{offset:'70px',time:1000});
                        } else {
                            layer.msg(data.errdesc,{offset:'70px',time:1500});
                            return false;
                        }
                    },
                    error : function(xmlHttpRequest, status, errorThrow) {
                        layer.open(errorThrow);
                    }
                });
            });
        });

    },

    // 获取/设置URL
    url : function(name, value) {
        if (typeof value == 'undefined' || value == '') {
            // 获取
            return name in Base.urls ? Base.urls[name] : '';
        } else {
            // 设置
            Base.urls[name] = value;
            return Base;
        }
    },

    open : function (settings) {
        var defaults = {
            type: 1,
            title: '',
            area:'450px',
            shade: 0.3,
            anim: 4, 
            shadeClose :true,
            closeBtn: 1,
            success: function(layero, index){
            },
            btn: [Base.lang('confirm'), Base.lang('cancel')],
            cancel: function(index, layero){ 
                layer.close(index)
                return false ;
            }
        };
        settings = $.extend(defaults, settings);
        layer.open(settings);
    },

    // AJAX JSONP
    ajax : function(settings) {
        var defaults = {
            data : {},
            dataType : 'json',
            type : 'POST',
            timeout : 300 * 1000,
            complete : null,
            success : null,
            error : function(xmlHttpRequest, status, errorThrow) {
                // layer.closeAll();
                layer.closeAll('loading');
                layer.open(errorThrow);
            }
        };
        settings = $.extend(defaults, settings);
        $.ajax(settings);
    },

    // 确认框
    confirm : function(content, callback) {
        layer.confirm(
            content,
            {title:Base.lang('confirm'),btn: [Base.lang('confirm'), Base.lang('cancel')],icon:3,offset:'150px',area:'500px',shadeClose :true}
            ,function() {
                if ($.isFunction(callback)) {
                    callback.call(this);
                }
                return true;
            }
        );
    },

    // 错误消息提示框
    error : function(content, url) {
        // content = content || CyBase.lang('error');
        // var defaults = {icon:2,offset:'0px',time: 2000,shadeClose :true};
        // layer.msg(content,defaults,function(){
        //     if (url != "" && typeof url != 'undefined') {
        //             // 重新加载指定URL
        //             location.replace(url);
        //         }
        // });
        // return false;
    },

    // 成功消息提示框
    success : function(content, url) {
        // layer.msg(content,
        //     {icon:1,offset:'0px',time: 1000,shadeClose :true}, 
        //     function(){
        //         if (url != "" && typeof url != 'undefined') {
        //             // 重新加载指定URL
        //             location.replace(url);
        //         }
        //     }
        // );
    },

    // 公告栏
    board : function(type, log_number) {
        var $board = $('#crumb_board');
        if ('show' == type.toLowerCase()) {
            log_number = typeof log_number == 'number' ? log_number : 0;
            $('#crumb_board a span').html(log_number);
            $board.show();
            return;
        } else {
            $board.hide();
            return;
        }
    },

    // 加载未读日志
    loadUnreadLog : function(time) {
        if ('log' == Base.pageIdentifier.toLowerCase()) {
            // LOG页面不加载
            return;
        }

        var intTime = parseInt(time) * 1000, // 间隔时间(s)
            getUnreadLog = function() {
                Base.ajax({
                    url : Base.url('ajaxHasUnReadedLog'),
                    success : function(data) {
                        if (data.results > 0) {
                            // 有未读日志
                            Base.board('show', parseInt(data.results));
                            return;
                        } else {
                            // 没有未读日志
                            Base.board('hide');
                        }
                    },
                    error : null
                });
            };

        getUnreadLog();
        setInterval(getUnreadLog, intTime);
    },

    // 重定向到指定URL
    redirect : function(url) {
        window.location.href = url;
        return;
    },

    // 修改管理员的密码
    changeAdminPassword : function() {
       
    },

    // 用户注销
    logout : function() {
        Base.confirm(Base.lang('logout confirm'), function(){
            Base.redirect(Base.url('logout'));
        });
    },

    html_decode : function(str){   
        var s = "";   
        if (str.length == 0) return "";     
        s = str.replace(/&amp;/g, "&"); 
        s = s.replace(/&lt;/g, "<"); 
        s = s.replace(/&gt;/g, ">"); 
        s = s.replace(/&nbsp;/g, " "); 
        s = s.replace(/&#39;/g, "\'"); 
        s = s.replace(/&quot;/g, "\""); 
        s = s.replace(/<br\/>/g, "\n"); 
        return s;
    },

    tags : function(tag){
        switch(tag){
            case '置顶':
                return '<span class="stick">置顶</span>';
                break;
            case '置顶,精贴':
                return '<span class="fine">精贴</span><span class="stick">置顶</span>';
                break;
            case '精贴':
                return '<span class="fine">精贴</span>';
                break;
            default:
                return '';
        }
    },


    format_datetime : function(time){
        time = parseInt(time);
        var now = new Date(),
            difference = (now.getTime() - new Date(time*1000).getTime())/1000;

        switch(true){
            case difference<= 180:
                return '刚刚';
                break;
            case difference<= 3600:
                return Math.ceil(difference/60)+'分钟前';
                break;
            case difference<= 86400:
                return Math.ceil(difference/3600)+'小时前';
                break;
            case difference<= 2592000:
                return Math.ceil(difference/86400)+'天前';
                break;
            case difference<= 31536000:
                return Math.ceil(difference/2592000)+'个月前';
                break;
            default:
                return Math.ceil(difference/31536000)+'年前';
        }
        
    },

    //不重复的字符串
    genNonDuplicateID : function(length){
        return Number(Math.random().toString().substr(3,length) + Date.now()).toString(36)
    }
};