var Article = {
    initialize : function(settings) {
        layui.use(['form','element','layedit'], function(){
            var form = layui.form(),
                element = layui.element(),
                layedit = layui.layedit;
                

            $('#article').dataTable({
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

            form.on('checkbox(article)', function(data){
                //是否被选中，true或者false
                var child = $('#article').find('tbody input[type="checkbox"][name="select"]');
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
                    Article.auditing_art(dataId, 1);
                }else{
                    Article.auditing_art(dataId, 0);
                }
            });

            //添加文章    
            $('#add-article').click(function(){
                var editIndex = '';
                layer.open({
                    type : 1,
                    offset : '50px',
                    area : '700px',
                    title : '文章内容',
                    btn:false,
                    closeBtn:2,
                    content : $('#add_article_container').html(),
                    success : function(layero, index){
                        //,tool: ['face','left', 'center', 'right', '|','link','unlink']
                        form.render();
                        form.verify({
                        	title:function(value){
                        		if(value == ''){
                                    return '请输入文章标题';
                                }
                        	},
                        	catid:function(value){
                        		if(value == ''){
                                    return '请输入文章分类';
                                }
                        	},
                            content: function(value){
                            	value = $.trim(layedit.getText(editIndex));
                                if(value == ''){
                                    return '请输入文章内容';
                                }
                                layedit.sync(editIndex);//同步内容
                            }
                        });
                        editIndex = layedit.build('editor',{uploadImage: {url: Base.url('uploadImg'),type: 'post'}
                            ,height: 120});

                        form.on('submit(add-article)', function(data){
                            layer.confirm('你确定要添加文章吗？',{
                                icon:3,
                                offset:'120px',
                                btn:['确定','取消'],
                                yes: function(index){
                                    var title = data.field['title'],
                                        catid = data.field['catid'],
                                        tag = [],
                                        content = data.field['content'];

                                    $('form input:checkbox[name="tag"]:checked').each(function(index, dom){
                                        tag.push($(dom).val());
                                    });

                                    var datas = {title:title,catid: catid,tag:tag.toString(),content: content};

                                    Base.ajax({
                                        url :Base.url('addArticle'),
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
                    }
                });     
            });
        });
    },

    //删除文章
    delete_art : function(id, catid){
        var datas = {id:id,catid:catid};
        layer.confirm('你确定要删除文章吗？',{
            icon:3,
            offset:'120px',
            closeBtn:2,
            btn:['确定','取消'],
            yes: function(index){
                Base.ajax({
                    url :Base.url('deleteArticle'),
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
    },

    delete_arts : function(){
        var datas = [];
        $('#article input:checkbox[name="select"]:checked').each(function(index,dom){
            var val = $(dom).val().split(',');

            datas.push({id:val[0],catid:val[1]});
        });
        
        if(datas.length == 0){
            layer.msg('请选择要删除的文章',{offset:'120px',time:2000});
            return false;
        }

        layer.confirm('你确定要删除这些文章吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            closeBtn:2,
            yes: function(index){
                Base.ajax({
                    url :Base.url('deleteArticle'),
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
    },

    //是否审核
    auditing_art : function(id, audit){
        var audit = parseInt(audit),
            datas = {id:id,auditing:audit};
        if(audit){
            layer.load(3);
            Base.ajax({
                url :Base.url('editArticle'),
                type:'post',
                data : {data:datas},
                success : function(data) {
                    if (data.status == 'ok') {
                        layer.msg('更改成功',{offset:'120px',time:1000});
                        layer.closeAll('loading');
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
                url :Base.url('editArticle'),
                type:'post',
                data : {data:datas},
                success : function(data) {
                    if (data.status == 'ok') {
                        layer.msg('更改成功',{offset:'120px',time:1000});
                        layer.closeAll('loading');
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
    auditing_arts : function(){   
        var ids = [],
            datas = [];
        $('#article input:checkbox[name="select"]:checked').each(function(index,dom){
            var val = $(dom).val().split(',');

            datas.push({id:val[0],auditing:1});
        });

        if(datas.length == 0){
            layer.msg('请选择要审核的文章',{offset:'120px',time:2000});
            return false;
        }
        layer.confirm('你确定要审核这些文章吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            closeBtn:2,
            yes: function(index){
                layer.load(3);
                Base.ajax({
                    url :Base.url('editArticle'),
                    type:'post',
                    data : {data:datas},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.msg('审核成功',{offset:'120px',time:1000},function(){
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
    },

    //编辑文章
    edit_art : function(id){
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
                        title : '编辑文章',
                        btn:false,
                        closeBtn:2,
                        content : $('#edit_article_container').html(),
                        success : function(layero, index){
                            layui.use(['form','element','layedit'], function(){
                                var form = layui.form(),
                                    element = layui.element(),
                                    layedit = layui.layedit,
                                    tag = data.results.tag,
                                    content = data.results.content,
                                    tags = (tag.indexOf(",") == -1)? tag.split() : tag.split(",");

                                for(var i = 0;i < tags.length;i++){
                                    layero.find('input:checkbox[name="tag"][value="'+tags[i]+'"]').prop('checked',true);
                                }
                                layero.find('input:checkbox[name="auditing"]').prop('checked',data.results.auditing);
                                layero.find('input[name="title"]').val(data.results.title);
                                layero.find('select[name="catid"]').val(data.results.catid);
                                layero.find('textarea[name="content"]').val(content);

                                form.render();
                                layedit.set({
                                    uploadImage: {
                                        url: Base.url('uploadImg'),
                                        type: 'post'
                                    }
                                });
                                edIndex = layedit.build('editors',{height: 250});
                                form.verify({
                                    title:function(value){
                                        if(value == ''){
                                            return '请输入文章标题';
                                        }
                                    },
                                    catid:function(value){
                                        if(value == ''){
                                            return '请输入文章分类';
                                        }
                                    },
                                    content: function(value){
                                        value = $.trim(layedit.getText(edIndex));
                                        if(value == ''){
                                            return '请输入文章内容';
                                        }
                                        layedit.sync(edIndex);//同步内容
                                    }
                                });


                                form.on('submit(eidt_article)', function(data){
                                    layer.confirm('你确定要更新文章吗？',{
                                        icon:3,
                                        offset:'120px',
                                        btn:['确定','取消'],
                                        closeBtn:2,
                                        yes: function(index){
                                
                                            var tags = [];
                                            auditing = data.field['auditing'] == 'on' ? 1 : 0;
                                            title = data.field['title'];
                                            catid = data.field['catid'];
                                            content = data.field['content'];

                                            layero.find('form input:checkbox[name="tag"]:checked').each(function(index, dom){
                                                tags.push($(dom).val());
                                            });

                                            var datas = {id:id,title:title,catid:catid,tag:tags.toString(),auditing:auditing,content:content};
                                            Base.ajax({
                                                url :Base.url('editArticle'),
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