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
        if($this->authority($error) === false){
            return false;
        }

        $Category = M('Category');

        $res = $Category->add($data);
        if($res){
            return true;
        }
        $error = '添加分类失败！';
        return false;
    }
    
    public function update($data, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $Category = M('Category');
        $res = $Category->where("catid = '%s'", $data['catid'])->save($data);

        if($res){
            return true;
        }
        $error = '更新失败！';
        return false;
    }

    public function delete($id, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $Category = M('Category');
        $res = $Category->where("catid='%s'",$id)->delete();

        if($res){
            return true;
        }
        $error = '删除分类失败！';
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