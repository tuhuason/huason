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

        if($res){
            return $res;
        }
        return false;
    }

    public function pages($id)
    {
        $ReplyReview = M('reply_review');
        $res = $ReplyReview->join('qq_login ON reply_review.reply_reviewer = qq_login.nickname')->where("auditing = 1 and article_id= '%s'",$id)->select();

        $data = [];
        if($res){
            foreach ($res as $reply_review) {
                $reply_review['content'] = htmlspecialchars_decode($reply_review['content']);
                $data[] = $reply_review;
            }
            return $data;
        }
        return false;
    }

    public function add($data, &$error='')
    {
        $ReplyReview = M('reply_review');

        if(!session('openid')){
            $error = '请登录后回复！';
            return false;
        }

        if($data['reply_reviewer'] == $data['reply_master']){
            $error = '亲，不能对自己回复！';
            return false;
        }

        //开启事务
        M()->startTrans();
        $res = $ReplyReview->add($data);
        $num = M('review')->where("identifier = '%s'", $data['master_identifier'])->setInc('count');
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
        if($this->authority($error) === false){
            return false;
        }

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
        if($this->authority($error) === false){
            return false;
        }

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

        if(!session('openid')){
            $error = '请登录后点赞！';
            return false;
        }
        
        if( strtolower($data['openid']) == strtolower(session('openid')) ){
            $error = '亲，不能对自己点赞';
            return false;
        }
        
        unset($data['openid']);
        
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