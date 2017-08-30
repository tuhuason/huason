var Category = {
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
                },
            });

            form.on('checkbox(category)', function(data){
                //是否被选中，true或者false
                var child = $('#category').find('tbody input[type="checkbox"][name="select"]');
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });   

            //添加日记    
            $('#add-category').click(function(){
                layer.open({
                    type : 1,
                    offset:'100px',
                    area : '400px',
                    title : '添加分类',
                    btn:false,
                    content : $('#add_category_container').html(),
                    success : function(layero, index){
                        form.render();
                        form.verify({
                            name:[/(.+){2,}$/, '分类名称必须2位以上'],
                            description:[/(.+){2,}$/, '分类描述必须2位以上']
                        });

                        form.on('submit(add-category)', function(data){
                            layer.confirm('你确定要添加分类吗？',{
                                icon:3,
                                btn:['确定','取消'],
                                yes: function(index){
                                    var name = data.field['name'],
                                    	description = data.field['description'],
                                    	datas = {name: name,description: description};
                                    Base.ajax({
                                        url :Base.url('addCategory'),
                                        type:'post',
                                        data : {data: datas},
                                        success : function(data) {
                                            if (data.status == 'ok') {
                                                layer.msg(data.results,{offset:'120px',time:1000},function(){
                                                    layer.closeAll();
                                                    Base.redirect(Base.url('category'));
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
    delete_cate : function(id){
        layer.confirm('你确定要删除分类吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            yes: function(index){
                layer.load(3);
                Base.ajax({
                    url :Base.url('deleteCategory'),
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
    delete_cates : function(){
        var ids = [];
        $('#category input:checkbox[name="select"]:checked').each(function(index,dom){
            ids.push($(dom).val());
        });

        if(ids.length == 0){
            layer.msg('请选择要删除的分类',{offset:'120px',time:2000});
            return false;
        }

        layer.confirm('你确定要删除这些分类吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            yes: function(index){
                layer.load(3);
                Base.ajax({
                    url :Base.url('deleteCategory'),
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

    //编辑分类
    edit_cate : function(id){
        layer.open({
            type : 1,
            offset:'100px',
            title : '编辑分类',
            btn:false,
            closeBtn:2,
            content : $('#edit_category_container').html(),
            success : function(layero, index){
                layui.use(['form','element','layedit'], function(){
                    var form = layui.form(),
                        element = layui.element(),
                        layedit = layui.layedit,
                        $category = $('#category').find('tbody tr[data-id="'+id+'"]')
                        name = $category.find('td:eq(2)').text(),
                        description = $category.find('td:eq(3)').text();

                    layero.find('input[name="name"]').val(name);
                    layero.find('input[name="description"]').val(description);

                    form.render();
                    form.verify({
                        name:[/(.+){2,}$/, '分类名称必须2位以上'],
                        description:[/(.+){2,}$/, '分类描述必须2位以上']
                    });


                    form.on('submit(edit-category)', function(data){
                        layer.confirm('你确定要更新分类吗？',{
                            icon:3,
                            offset:'120px',
                            btn:['确定','取消'],
                            closeBtn:2,
                            yes: function(index){

                                var name = data.field['name'],
                                    description = data.field['description'],
                                    datas = {catid: id,name: name,description: description};
                                Base.ajax({
                                    url :Base.url('editCategory'),
                                    type:'post',
                                    data : {data:datas},
                                    success : function(data) {
                                        if (data.status == 'ok') {
                                            layer.msg(data.results,{offset:'120px',time:1000},function(){
                                                layer.closeAll();
                                                Base.redirect(Base.url('category'));
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
    }
}