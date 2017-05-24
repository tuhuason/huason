<?php
namespace Admin\Model;

class IndexModel extends BaseModel
{
    public function count_num(){
        //计算用户，文章，日记总数
        $role_id = session('role');
        $admin_id = session('admin_id');
    	if($role_id == 1){
            $users = M('Admin')->count();
            $articles = M('Article')->count();
            $diarys = M('Diary')->count();

            $data = array(
                'user' => $users,
                'article' => $articles,
                'diary' => $diarys,
            );
        }else{
            $articles = M('Article')->where('admin_id ='.$admin_id)->count();
            $diarys = M('Diary')->where('admin_id ='.$admin_id)->count();

            $data = array(
                'article' => $articles,
                'diary' => $diarys,
            );
        }

        return $data;
    }
}