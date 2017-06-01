<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;

class ReplyMessageModel extends BaseModel
{
    protected $trueTableName  = 'reply_message'; 

    // 
    public function findAll()
    {
        $ReplyMessage = M('reply_message');
        $res = $ReplyMessage->select();

        if($res){
            return $res;
        }
        return false;
    }

    public function add($data, &$error='')
    {
        $ReplyMessage = M('reply_message');
        
        if(!isset($_COOKIE['openid'])){
            $error = '请登录后回复！';
            return false;
        }

        //开启事务
        M()->startTrans();
        $res = $ReplyMessage->add($data);
        $num = M('message')->where("commenter = '%s'", $data['reply_master'])->setInc('count');
        if($res && $num){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '留言失败！';
        //回滚事务
        M()->rollback();
        return false;
    }
    
    public function delete($data, &$error='')
    {
        $ReplyMessage = M('reply_message');

        //开启事务
        M()->startTrans();
        $res = $ReplyMessage->where("id='%s'",$data['id'])->delete();
        $num = M('message')->where("identifier = '%s'", $data['identifier'])->setDec('count');
        if($res && $num){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '删除留言失败！';
        //回滚事务
        M()->rollback();
        return false;
    }

    public function update($data, &$error='')
    {
        $ReplyMessage = M('reply_message');

        $res = $ReplyMessage->save($data);
        if($res){
            return true;
        }
        $error = '更新失败！';
        return false;
    }

    public function upvote($data, &$error='')
    {
        $ReplyMessage = M('reply_message');

        if(!isset($_COOKIE['openid'])){
            $error = '请登录后回复！';
            return false;
        }
        
        if($data['type'] == 'add'){
            $res = $ReplyMessage->where("identifier = '%s'", $data['identifier'])->setInc('upvote');
            if($res){
                return true;
            }
        }else{
            $res = $ReplyMessage->where("identifier = '%s'", $data['identifier'])->setDec('upvote');
            if($res){
                return true;
            }
        }
        $error = '更新失败！';
        return false;
    }
}