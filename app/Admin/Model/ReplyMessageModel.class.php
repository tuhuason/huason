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

    public function pages()
    {
        $ReplyMessage = M('reply_message');
        $res = $ReplyMessage->join('qq_login ON reply_message.reply_commenter = qq_login.nickname')->where("auditing=1")->select();

        $data = [];
        if($res){
            foreach ($res as $reply_message) {
                $reply_message['content'] = htmlspecialchars_decode($reply_message['content']);
                $data[] = $reply_message;
            }
            return $data;
        }
        return false;
    }
    
    public function add($data, &$error='')
    {
        $ReplyMessage = M('reply_message');
        
        if(!session('openid')){
            $error = '请登录后回复！';
            return false;
        }

        if($data['reply_commenter'] == $data['reply_master']){
            $error = '亲，不能对自己回复！';
            return false;
        }
        
        //开启事务
        M()->startTrans();
        $res = $ReplyMessage->add($data);
        $num = M('message')->where("identifier = '%s'", $data['master_identifier'])->setInc('count');
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
        if($this->authority($error) === false){
            return false;
        }

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
        if($this->authority($error) === false){
            return false;
        }

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