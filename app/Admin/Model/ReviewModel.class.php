<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;

class ReviewModel extends BaseModel
{
    protected $trueTableName  = 'review'; 

    // 
    public function findAll()
    {
        $Review = M('Review');
        $res = $Review->select();
        // var_dump($res);
        if($res){
            return $res;
        }
        return false;
    }

    //是否已经评论
    public function isCommented($name, $article_id){
        $Review = M('Review');
        $res = $Review->where("reviewer = '%s' and article_id = '%d'", $name, $article_id)->select();

        if(!empty($res)){
            return true;
        }
        return false;
    }

    public function add($data, &$error='')
    {
        $Review = M('Review');

        if($this->isCommented($data['reviewer'], $data['article_id'])){
            $error = '亲，您已经评论！';
            return false;
        }

        //开启事务
        M()->startTrans();
        $res = $Review->add($data);
        $num = M('Article')->where("id = '%s'", $data['article_id'])->setInc('comment');
        if($res && $num){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '评论失败';
        //回滚事务
        M()->rollback();
        return false;
    }
    
    public function delete($id, $article_id, &$error='')
    {

        $Review = M('Review');

        //开启事务
        M()->startTrans();
        $res = $Review->where("id='%s'",$id)->delete();
        $num = M('Article')->where("id = '%s'", $article_id)->setDec('comment');
        if($res && $num){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '删除评论失败！';
        //回滚事务
        M()->rollback();
        return false;
    }

    public function update($data, &$error='')
    {
        $Review = M('Review');

        $res = $Review->save($data);
        if($res){
            return true;
        }
        $error = '更新失败！';
        return false;
    }

    public function upvote($data, &$error='')
    {
        $Review = M('Review');
        if($data['type'] == 'add'){
            $res = $Review->where("identifier = '%s'", $data['identifier'])->setInc('upvote');
            if($res){
                return true;
            }
        }else{
            $res = $Review->where("identifier = '%s'", $data['identifier'])->setDec('upvote');
            if($res){
                return true;
            }
        }
        $error = '更新失败！';
        return false;
    }
}