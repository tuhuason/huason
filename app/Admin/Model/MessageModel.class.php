<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;

class MessageModel extends BaseModel
{
    protected $trueTableName  = 'message'; 

    // 
    public function findAll()
    {
        $Message = M('Message');
        $res = $Message->select();

        if($res){
            return $res;
        }
        return false;
    }

    public function pages($current_page, $num)
    {
        $Message = M('Message');
        $res = $Message->page($current_page.','.$num)->join('qq_login ON message.commenter = qq_login.nickname')->order('addtime desc')->select();

        $data = [];
        if($res){
            foreach ($res as $message) {
                $message['content'] = htmlspecialchars_decode($message['content']);
                $data[] = $message;
            }
            return $data;
        }
        return false;
    }
    
    //是否已经留言
    public function isCommented($name){
        $Message = M('Message');
        $res = $Message->where("commenter = '%s'", $name)->select();

        if(!empty($res)){
            return true;
        }
        return false;
    }

    public function add($data, &$error='')
    {
        $Message = M('Message');

        if($this->isCommented($data['commenter'])){
            $error = '亲，您已经留言！';
            return false;
        }

        $res = $Message->add($data);
        if($res){
            return true;
        }
        $error = '留言失败！';
        return false;
    }
    
    public function delete($data, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $Message = M('Message');
        $res = $Message->where("id='%s'",$data['id'])->delete();

        if($res){
            return true;
        }
        $error = '删除留言失败！';
        return false;
    }

    public function update($data, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $Message = M('Message');
        $res = $Message->save($data);
        
        if($res){
            return true;
        }
        $error = '更新失败！';
        return false;
    }

    public function upvote($data, &$error='')
    {
        $Message = M('Message');

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
            $res = $Message->where("identifier = '%s'", $data['identifier'])->setInc('upvote');
            if($res){
                return true;
            }
        }else{
            $res = $Message->where("identifier = '%s'", $data['identifier'])->setDec('upvote');
            if($res){
                return true;
            }
        }
        $error = '更新失败！';
        return false;
    }
}