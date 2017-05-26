<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;

class DiaryModel extends BaseModel
{
    protected $trueTableName  = 'diary'; 

    // 
    public function findAll()
    {
        $Diary = M('Diary');
        $res = $Diary->where("admin_id='%d'", session('admin_id'))->select();
        // var_dump($res);
        if($res){
            return $res;
        }
        return false;
    }

    public function findOne($id, &$error='')
    {

        $Diary = M('Diary');
        $res = $Diary->where("id='%d'",$id)->find();

        if($res){
            return $res;
        }
        $error = '失败！';
        return false;
    }

    public function add($content, &$error='')
    {
        $Diary = M('Diary');

        $data = array(
            'content' => $content,
            'addtime' => time(),
            'admin_id' => session('admin_id'),
            'uptime' => time()
        );

        $res = $Diary->add($data);
        if($res){
            return true;
        }
        $error = '添加日记失败！';
        return false;
    }
    
    public function delete($id, &$error='')
    {

        $Diary = M('Diary');
        $res = $Diary->where("id='%d'",$id)->delete();

        if($res){
            return true;
        }
        $error = '删除日记失败！';
        return false;
    }
}