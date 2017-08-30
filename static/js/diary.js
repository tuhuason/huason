var Diary = {
    initialize : function(settings) {
        layui.use(['form','element','layedit'], function(){
            var form = layui.form(),
                element = layui.element(),
                layedit = layui.layedit;

            $('#diary').dataTable({
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
                }
            });

            form.on('checkbox(diary)', function(data){
                //是否被选中，true或者false
                var child = $('#diary').find('tbody input[type="checkbox"][name="select"]');
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });   

            //添加日记    
            $('#add-diary').click(function(){
                var editIndexs = '';
                layer.open({
                    type : 1,
                    offset : '100px',
                    area : '700px',
                    title : '添加日记',
                    btn:false,
                    content : $('#add_diary_container').html(),
                    success : function(layero, index){
                        editIndexs = layedit.build('editorDiary',{height: 150,tool: ['face','left', 'center', 'right', '|','link','unlink']});
                        form.render();
                        form.verify({
                            content: function(value){
                                value = $.trim(layedit.getText(editIndexs));
                                if(value == ''){
                                    return '请输入日记内容';
                                }
                                layedit.sync(editIndexs);//同步内容
                            }
                        })

                        form.on('submit(add-diary)', function(data){
                            layer.confirm('你确定要添加日记吗？',{
                                icon:3,
                                offset:'120px',
                                btn:['确定','取消'],
                                yes: function(index){
                                    var content = data.field['content'];

                                    Base.ajax({
                                        url :Base.url('addDiary'),
                                        type:'post',
                                        data : {content: content},
                                        success : function(data) {
                                            if (data.status == 'ok') {
                                                layer.msg(data.results,{offset:'120px',time:1000},function(){
                                                    layer.closeAll();
                                                    Base.redirect(Base.url('diary'));
                                                });
                                            } else {
                                                layer.msg(data.errdesc,{offset:'120px',time:1500});
                                                return false;
                                            }
                                        }
                                    });
                                }
                            });              
                        });
                    }
                });     
            });    
            form.render();
            
        });
    },

    //删除日记
    delete_diy : function(id){
        layer.confirm('你确定要删除日记吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            yes: function(index){
                layer.load(3);
                Base.ajax({
                    url :Base.url('deleteDiary'),
                    type:'post',
                    data : {id:id},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.closeAll('loading');
                            layer.msg(data.results,{offset:'120px',time:1000},function(){
                                layer.closeAll();
                                Base.redirect(Base.url('diary'));
                            });
                        } else {
                            layer.msg(data.errdesc,{offset:'120px',time:1500});
                            layer.closeAll('loading');
                            return false;
                        }
                    }
                });
            }
        })
        
    },
        
    //批量删除
    delete_diys : function(){
        var ids = [];
        $('#diary input:checkbox[name="select"]:checked').each(function(index,dom){
            ids.push($(dom).val());
        });

        if(ids.length == 0){
            layer.msg('请选择要删除的日记',{offset:'120px',time:2000});
            return false;
        }

        layer.confirm('你确定要删除这些日记吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            yes: function(index){
                layer.load(3);
                Base.ajax({
                    url :Base.url('deleteDiary'),
                    type:'post',
                    data : {id:ids},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.closeAll('loading');
                            layer.msg(data.results,{offset:'120px',time:1000},function(){
                                layer.closeAll();
                                Base.redirect(Base.url('diary'));
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

    //编辑日记
    edit_diy : function(id){
        var edIndex = '';

        Base.ajax({
            url :Base.url('findOne'),
            type:'post',
            data : {id:id},
            success : function(data) {
                if (data.status == 'ok') {
                    layer.open({
                        type : 1,
                        offset : '50px',
                        area : '1000px',
                        title : '编辑日志',
                        btn:false,
                        closeBtn:2,
                        content : $('#edit_diary_container').html(),
                        success : function(layero, index){
                            layui.use(['form','element','layedit'], function(){
                                var form = layui.form(),
                                    element = layui.element(),
                                    layedit = layui.layedit,
                                    content = data.results.content;

                                layero.find('textarea[name="content"]').val(content);

                                form.render();
                                
                                edIndex = layedit.build('edit_editorDiary',{height: 250,tool: ['left', 'center', 'right', '|', 'face','code','link','unlink']});
                                form.verify({
                                    content: function(value){
                                        value = $.trim(layedit.getText(edIndex));
                                        if(value == ''){
                                            return '请输入文章内容';
                                        }
                                        layedit.sync(edIndex);//同步内容
                                    }
                                });


                                form.on('submit(edit-diary)', function(data){
                                    layer.confirm('你确定要更新日志吗？',{
                                        icon:3,
                                        offset:'120px',
                                        btn:['确定','取消'],
                                        closeBtn:2,
                                        yes: function(index){
                                            var content = data.field['content'],
                                                datas = {id:id,content:content};

                                            Base.ajax({
                                                url :Base.url('editDiary'),
                                                type:'post',
                                                data : {data:datas},
                                                success : function(data) {
                                                    if (data.status == 'ok') {
                                                        layer.msg(data.results,{offset:'120px',time:1000},function(){
                                                            layer.closeAll();
                                                            Base.redirect(Base.url('article'));
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
                                });
                            });
                        }
                    });
                } else {
                    layer.msg(data.errdesc,{offset:'120px',time:1500});
                    layer.closeAll('loading');
                    return false;
                }
            }
        });
    }
}