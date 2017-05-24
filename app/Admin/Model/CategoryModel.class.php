<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;

class CategoryModel extends BaseModel
{
    protected $trueTableName  = 'category'; 

    // 
    public function findAll()
    {
        $Category = M('Category');
        $res = $Category->select();
        // var_dump($res);
        if($res){
            return $res;
        }
        return false;
    }

    public function findOne($id, &$error='')
    {

        $Category = M('Category');
        $res = $Category->where("id='%s'",$id)->find();

        if($res){
            return $res;
        }
        $error = '失败！';
        return false;
    }

    public function add($data, &$error='')
    {
        $Category = M('Category');
        
        $data = array(
            'content' => $content,
            'addtime' => time(),
            'uptime' => time()
        );

        $res = $Diary->add($data);
        if($res){
            return true;
        }
        $error = '添加分类失败！';
        return false;
    }
    
    public function delete($id, &$error='')
    {

        $Diary = M('Diary');
        $res = $Diary->where("id='%s'",$id)->delete();

        if($res){
            return true;
        }
        $error = '删除日记失败！';
        return false;
    }

    public function updateNum($id, $type, &$error='')
    {
        $Category = M('Category');
        if($type == "add"){
            $res = $Category->where("catid='%s'",$id)->setInc('count');
        }else if($type == "delete"){
            $res = $Category->where("catid='%s'",$id)->setDec('count');
        }

        if($res){
            return true;
        }
        $error = '更新失败！';
        return false;
    }
}