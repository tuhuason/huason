<?php
namespace Home\Controller;

class MessageController extends BaseController {
    public function __construct()
    {
        parent::__construct();
    }

    public function addMessageAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $Message = new \Admin\Model\MessageModel();
            $success = $Message->add($data, $error);

            if ($success) {
                $this->successAjax('留言成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function pageAction(){
        if(IS_POST){
            $current_page = I('post.page/d');
            $num = I('post.num/d');;

            $Message = M('message');
            $reply_message = M('reply_message');
            //加载分页
            $total_page = $Message->where("auditing=1")->count();
            $data['message'] = $Message->page($current_page.','.$num)->order('addtime desc')->select();
            $data['reply_message'] = $reply_message->where("auditing=1")->select();
            $data['total_page'] = ceil($total_page/$num);
// var_dump($data);exit;
            $this->successAjax($data);
        }
        return $this->error404Page();
    }
}