<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;

class ReplyReviewModel extends BaseModel
{
    protected $trueTableName  = 'reply_review'; 

    // 
    public function findAll()
    {
        $ReplyReview = M('reply_review');
        $res = $ReplyReview->select();
        // var_dump($res);
        if($res){
            return $res;
        }
        return false;
    }

    public function add($data, &$error='')
    {
        $ReplyReview = M('reply_review');

        //开启事务
        M()->startTrans();
        $res = $ReplyReview->add($data);
        $num = M('review')->where("reviewer = '%s'", $data['reply_master'])->setInc('count');
        if($res && $num){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '回复失败！';
        //回滚事务
        M()->rollback();
        return false;
    }
    
    public function delete($data, &$error='')
    {

        $ReplyReview = M('reply_review');

        //开启事务
        M()->startTrans();
        $res = $ReplyReview->where("id='%s'",$data['id'])->delete();
        $num = M('review')->where("identifier = '%s'", $data['identifier'])->setDec('count');
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
        $ReplyReview = M('reply_review');

        $res = $ReplyReview->save($data);
        if($res){
            return true;
        }
        $error = '更新失败！';
        return false;
    }

    public function upvote($data, &$error='')
    {
        $ReplyReview = M('reply_review');
        if($data['type'] == 'add'){
            $res = $ReplyReview->where("identifier = '%s'", $data['identifier'])->setInc('upvote');
            if($res){
                return true;
            }
        }else{
            $res = $ReplyReview->where("identifier = '%s'", $data['identifier'])->setDec('upvote');
            if($res){
                return true;
            }
        }
        $error = '更新失败！';
        return false;
    }
}