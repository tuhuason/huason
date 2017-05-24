var Reply_message = {
    initialize : function(settings) {
        layui.use(['form','element','layedit'], function(){
            var form = layui.form(),
                element = layui.element(),
                layedit = layui.layedit;
                
            $('#reply_message').dataTable({
                "oLanguage": {
                    "sInfo" : '显示第 _START_ 到 _END_ 条记录, 总共 _TOTAL_ 条记录',
                    "sInfoEmpty": '暂无记录',
                    "sInfoFiltered": '(由 _MAX_ 项结果过滤)',
                    "sZeroRecords": '没有匹配的记录',
                    "sSearchHolder": '搜索:',
                    "sSearchPlaceholder": '搜索',
                    "sLengthMenu": '显示_MENU_条记录',
                    "oPaginate": {
                        "sFirst" : '首页',
                        "sPrevious" : '上一页',
                        "sNext" : '下一页',
                        "sLast" : '末页'
                    }
                },
            });
            
            $('#reply_message tbody tr').each(function(){
                var content = $(this).attr('data-content');
                $(this).find('td:eq(6) a').hover(function(){
                    layer.tips('<span class="tips">'+Base.html_decode(content)+'</span>',this,{tips: [1, '#fff'],time:0});
                },function(){
                    layer.closeAll('tips');
                });
            });

            form.on('checkbox(reply_message)', function(data){
                //是否被选中，true或者false
                var child = $('#reply_message').find('tbody input[type="checkbox"][name="select"]');
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });   

            //是否审核
            form.on('switch(auditing)', function(data){
                var checkbox = data.elem,
                    dataId = (data.othis).parent().attr('data-id');
                if(checkbox.checked){
                    Reply_message.auditing(dataId, 1);
                }else{
                    Reply_message.auditing(dataId, 0);
                }
            });
        });
    },

    //删除评论
    delete_message : function(id, identifier){
        var datas = {id:id,identifier:identifier};
        layer.confirm('你确定要删除回复留言吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            yes: function(index){
                Base.ajax({
                    url :Base.url('delete_reply_message'),
                    type:'post',
                    data : {data:datas},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.msg(data.results,{offset:'120px',time:1000},function(){
                                layer.closeAll();
                                Base.redirect(Base.url('reply_message'));
                            });
                        } else {
                            layer.msg(data.errdesc,{offset:'120px',time:1500});
                            layer.closeAll('loading');
                            return false;
                        }
                    }
                });
            }
        });
    },

    delete_messages : function(){
        var datas = [];
        $('#reply_message input:checkbox[name="select"]:checked').each(function(index,dom){
            var val = $(dom).val().split(',');
            datas.push({id:val[0],identifier:val[1]});
        });

        if(datas.length == 0){
            layer.msg('请选择要删除的回复留言',{offset:'120px',time:2000});
            return false;
        }

        layer.confirm('你确定要删除这些回复留言吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            yes: function(index){
                Base.ajax({
                    url :Base.url('delete_reply_message'),
                    type:'post',
                    data : {data:datas},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.msg(data.results,{offset:'120px',time:1000},function(){
                                layer.closeAll();
                                Base.redirect(Base.url('reply_message'));
                            });
                        } else {
                            layer.msg(data.errdesc,{offset:'120px',time:1500});
                            layer.closeAll('loading');
                            return false;
                        }
                    }
                });
            }
        });
    },

    //是否审核
    auditing : function(id, audit){
        var audit = parseInt(audit),
            datas = {id:id,auditing:audit};
        if(audit){
            layer.load(3);
            Base.ajax({
                url :Base.url('edit_reply_message'),
                type:'post',
                data : {data:datas},
                success : function(data) {
                    if (data.status == 'ok') {
                        layer.msg('更改成功',{offset:'120px',time:1000});
                        layer.closeAll('loading');
                        // $('#review tbody td[data-id="'+article_id+'"]').find('input[type="checkbox"][name="auditing"]').prop('checked',false);
                        // form.render();
                        // $('td[data-id="'+id+'"]').find('input:checkbox[name="auditing"]').prop('checked',audit);
                    } else {
                        layer.msg(data.errdesc,{offset:'120px',time:1500});
                        layer.closeAll('loading');
                        return false;
                    }
                }
            });
        }else{
            layer.load(3);
            Base.ajax({
                url :Base.url('edit_reply_message'),
                type:'post',
                data : {data:datas},
                success : function(data) {
                    if (data.status == 'ok') {
                        layer.msg('更改成功',{offset:'120px',time:1000});
                        layer.closeAll('loading');
                        // $('td[data-id="'+id+'"]').find('input:checkbox[name="auditing"]').prop('checked',audit);
                    } else {
                        layer.msg(data.errdesc,{offset:'120px',time:1500});
                        layer.closeAll('loading');
                        return false;
                    }
                }
            });
        } 
        
    },

    //批量审核
    auditings : function(){   
        var ids = [],
            datas = [];

        var datas = [];
        $('#reply_message input:checkbox[name="select"]:checked').each(function(index,dom){
            var val = $(dom).val().split(',');
            datas.push({id:val[0],auditing:1});
        });

        if(datas.length == 0){
            layer.msg('请选择审核的回复留言',{offset:'120px',time:2000});
            return false;
        }

        layer.confirm('你确定要审核这些回复留言吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            closeBtn:2,
            yes: function(index){
                layer.load(3);
                Base.ajax({
                    url :Base.url('edit_reply_message'),
                    type:'post',
                    data : {data:datas},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.msg('审核成功',{offset:'120px',time:1000},function(){
                                layer.closeAll();
                                Base.redirect(Base.url('reply_message'));
                            });
                        } else {
                            layer.msg(data.errdesc,{offset:'120px',time:1500});
                            layer.closeAll('loading');
                            return false;
                        }
                    }
                });
            }
        });
    }
}