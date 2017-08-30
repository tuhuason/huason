<?php
namespace Home\Controller;

class MessageController extends BaseController {
    public function __construct()
    {
        $this->setWebTitle('首页')
            ->setIdentifier('message')
            ->addCrumb('首页', '/');

        parent::__construct();
    }

    public function indexAction(){

        $this->addCrumb('留言')->setCrumbs();

        $meassage = M('Message')->select();
        $reply = M('reply_message')->where('auditing = 1')->select();
        $this->assign(
            array(
                'message' => $meassage,
                'reply' => $reply
            )
        );
        $this->display('Index/message');
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
            $message = new \Admin\Model\MessageModel();
            $reply_message = new \Admin\Model\ReplyMessageModel();

            //加载分页
            $total_page = $Message->where("auditing=1")->count();
            $data['message'] = $message->pages($current_page, $num);
            $data['reply_message'] = $reply_message->pages();
            $data['total_page'] = ceil($total_page/$num);


            $this->successAjax($data);
        }
        return $this->error404Page();
    }

    public function upvoteAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $Message = new \Admin\Model\MessageModel();
            $success = $Message->upvote($data, $error);

            if ($success) {
                $this->successAjax('更新成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}