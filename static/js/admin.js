var Admin={
	initialize : function(settings) {
        layui.use(['form','element','layedit'], function(){
            var form = layui.form(),
                element = layui.element(),
                layedit = layui.layedit;
                

            $('#user').dataTable({
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
            form.on('checkbox(user)', function(data){
                //是否被选中，true或者false
                var child = $('#user').find('tbody input[type="checkbox"][name="select"]');
                child.each(function(index, item){
                    item.checked = data.elem.checked;
                });
                form.render('checkbox');
            });   

            //是否审核
            form.on('switch(role)', function(data){
                var checkbox = data.elem,
                    dataId = (data.othis).parent().attr('data-id');
                if(checkbox.checked){
                    Admin.role_user(dataId, 1);
                }else{
                    Admin.role_user(dataId, 0);
                }
            });

            //添加管理员或普通管理员  
            $('#add-user').click(function(){
                layer.open({
                    type : 1,
                    offset : '100px',
                    area : '510px',
                    title : '添加管理员或普通管理员',
                    btn:false,
                    closeBtn:2,
                    content : $('#add_user_container').html(),
                    success : function(layero, index){
                    	$("#verify").on('click',function() {
				            $("#verify").attr({"src" : Base.url('verify')});
				        });
                        form.render();
                        form.verify({
                        	username:[/(.+){5,12}$/, '用户名必须5到12位'],
                        	password:[/(.+){6,12}$/, '密码必须6到12位']
                        });

                        form.on('submit(add-user)', function(data){
                            layer.confirm('你确定要添加管理员或普通管理员吗？',{
                                icon:3,
                                offset:'120px',
                                btn:['确定','取消'],
                                yes: function(index){
                                    var username = data.field['adminuser'],
                                        password = data.field['password'],
                                        code = data.field['code'],
                                        role = data.field['role'] == 'on' ? 1 : 0;
                                    var datas = {adminuser:username,password: password,role_id:role,code:code};
                                    Base.ajax({
                                        url :Base.url('addUser'),
                                        type:'post',
                                        data : {data:datas},
                                        success : function(data) {
                                            if (data.status == 'ok') {
                                                layer.msg('添加成功',{offset:'120px',time:1000},function(){
                                                    layer.closeAll();
                                                    Base.redirect(Base.url('user'));
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

    //删除管理员或普通管理员
    delete_user : function(id){
        layer.confirm('你确定要删除管理员吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            closeBtn:2,
            yes: function(index){
                Base.ajax({
                    url :Base.url('deleteUser'),
                    type:'post',
                    data : {id:id},
                    success : function(data) {
                        if (data.status == 'ok') {
                            layer.msg(data.results,{offset:'120px',time:1000},function(){
                                layer.closeAll();
                                Base.redirect(Base.url('user'));
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

    delete_users : function(){
        var ids = [];
        $('#user input:checkbox[name="select"]:checked').each(function(index,dom){
            ids.push($(dom).val());
        });

        if(ids.length == 0){
            layer.msg('请选择要删除的管理员',{offset:'120px',time:2000});
            return false;
        }

        layer.confirm('你确定要删除这些管理员吗？',{
            icon:3,
            offset:'120px',
            btn:['确定','取消'],
            closeBtn:2,
            yes: function(index){
                Base.ajax({
                    url :Base.url('deleteUser'),
                    type:'post',
                    data : {id:ids},
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
    role_user : function(id, role_id){
        var audit = parseInt(role_id),
            datas = {id:id,role_id:role_id};
        if(audit){
            layer.load(3);
            Base.ajax({
                url :Base.url('roleUser'),
                type:'post',
                data : {data:datas},
                success : function(data) {
                    if (data.status == 'ok') {
                        layer.msg('更改成功',{offset:'120px',time:1000});
                        layer.closeAll('loading');
                    } else {
                        layer.msg(data.errdesc,{offset:'120px',time:1500},function(){
                            
                        });
                        layer.closeAll('loading');
                        return false;
                    }
                }
            });
        }else{
            layer.load(3);
            Base.ajax({
                url :Base.url('roleUser'),
                type:'post',
                data : {data:datas},
                success : function(data) {
                    if (data.status == 'ok') {
                        layer.msg('更改成功',{offset:'120px',time:1000});
                        layer.closeAll('loading');
                    } else {
                        layer.msg(data.errdesc,{offset:'120px',time:1500},function(){
                            
                        });

                        layer.closeAll('loading');
                        return false;
                    }
                }
            });
        } 
        
    },

    //批量审核
    role_users : function(){   
        var ids = [],
            datas = [];
        $('#user input:checkbox[name="select"]:checked').each(function(index,dom){
            ids.push($(dom).val());
        });

        if(ids.length == 0){
            layer.msg('请选择要审核的管理员或普通管理员',{offset:'120px',time:2000});
            return false;
        }
        for(var i =0;i<ids.length;i++){
            datas.push({id:ids[i],auditing:1});
        }
        // alert(datas);
        layer.confirm('你确定要审核这些管理员或普通管理员吗？',{
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

    //编辑管理员或普通管理员
    edit_user : function(id){
        layer.open({
            type : 1,
            offset : '120px',
            area : '400px',
            title : '编辑管理员或普通管理员',
            btn:false,
            closeBtn:2,
            content : $('#edit_user_container').html(),
            success : function(layero, index){
                layui.use(['form','element','layedit'], function(){
                    var form = layui.form(),
                        element = layui.element(),
                        $user = $('#user').find('tbody tr[data-id="'+id+'"]'),
                        name = $user.find('td:eq(2) a').text(),
                        role = $user.find('td:eq(6) input[name="role"]:checked').val() == 'on' ? true : false;

                    layero.find('input:checkbox[name="role"]').prop('checked',role);
                    layero.find('input[name="adminuser"]').val(name);

                    form.render();
                    
                    form.verify({
                    	password:[/(.+){6,12}$/, '密码必须6到12位']
                    });


                    form.on('submit(eidt_user)', function(data){
                        layer.confirm('你确定要编辑管理员或普通管理员吗？',{
                            icon:3,
                            offset:'120px',
                            btn:['确定','取消'],
                            yes: function(index){
                                var password = data.field['password'],
                                role_id = data.field['role'] == 'on' ? 1 : 0;

                                var datas = {id:id,password:password,role_id:role_id};
                                Base.ajax({
                                    url :Base.url('editUser'),
                                    type:'post',
                                    data : {data:datas},
                                    success : function(data) {
                                        if (data.status == 'ok') {
                                            layer.msg(data.results,{offset:'120px',time:1000},function(){
                                                layer.closeAll();
                                                Base.redirect(Base.url('user'));
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