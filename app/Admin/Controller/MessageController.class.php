<?php
namespace Admin\Controller;

class MessageController extends BaseController {
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
        $data = D('Message')->findAll();

        $this->assign('identifier', 'article.message');
        $this->assign('message', $data);

        $this->display('index');
    }
    
    public function addMessageAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $success = D('Message')->add($data, $error);

            if ($success) {
                $this->successAjax('留言成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function deleteMessageAction()
    {
        if(IS_POST){

            $data = I('post.data', '');
            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('Message')->delete($data, $error);
            }else{
                foreach ($data as $da) {
                    $success = D('Message')->delete($da, $error);
                }
            }

            if ($success) {
                $this->successAjax('删除留言成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function editMessageAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('Message')->update($data, $error);
            }else{
                foreach ($data as $da) {
                    $success = D('Message')->update($da,$error);
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
            $success = D('Message')->upvote($data, $error);

            if ($success) {
                $this->successAjax('更新成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}