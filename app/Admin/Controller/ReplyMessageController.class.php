<?php
namespace Admin\Controller;

class ReplyMessageController extends BaseController {
    public function __construct()
    {
        $this->setWebTitle('博客文章')
            ->setIdentifier('article');
        //     ->setLicense(false)
        //     ->addCrumb(L('index'), U('Home/Index/index'));

        parent::__construct();
    }

    // 首页
    public function indexAction()
    {
        $data = D('ReplyMessage')->findAll();

        $this->assign('identifier', 'article.reply_message');
        $this->assign('reply', $data);

        $this->display('index');
    }
    
    public function addReplyMessageAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $success = D('ReplyMessage')->add($data, $error);

            if ($success) {
                $this->successAjax('留言成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function deleteReplyMessageAction()
    {
        if(IS_POST){
            $data = I('post.data', '');
            // var_dump($data);exit;
            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('ReplyMessage')->delete($data, $error);
            }else{
                foreach ($data as $da) {
                    $success = D('ReplyMessage')->delete($da,$error);
                }
            }

            if ($success) {
                $this->successAjax('删除留言成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function editReplyMessageAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('ReplyMessage')->update($data, $error);
            }else{
                foreach ($data as $da) {
                    $success = D('ReplyMessage')->update($da,$error);
                }
            }

            if ($success) {
                $this->successAjax('更新成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function upvoteAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $success = D('ReplyMessage')->upvote($data, $error);

            if ($success) {
                $this->successAjax('点赞成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}