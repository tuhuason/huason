<?php
namespace Admin\Model;

class IndexModel extends BaseModel
{
    public function count_num(){
        //计算用户，文章，日记总数
        $role_id = session('role');
        $admin_id = session('admin_id');
        
    	$users = $role_id == 1 ? M('Admin')->count() : 1;
        $articles = M('Article')->count();
        $diarys = M('Diary')->where('admin_id ='.$admin_id)->count();

        $data = array(
            'user' => $users,
            'article' => $articles,
            'diary' => $diarys,
        );

        return $data;
    }
}