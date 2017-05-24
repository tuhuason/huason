<?php
namespace Admin\Controller;

class ReplyReviewController extends BaseController {
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
        $data = D('reply_review')->findAll();

        $this->assign('identifier', 'article.reply_review');
        $this->assign('reply', $data);

        $this->display('index');
    }
    
    public function addReplyReviewAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $success = D('ReplyReview')->add($data, $error);

            if ($success) {
                $this->successAjax('留言成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function deleteReplyReviewAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('ReplyReview')->delete($data, $error);
            }else{
                foreach ($data as $da) {
                    $success = D('ReplyReview')->delete($da, $error);
                }
            }

            if ($success) {
                $this->successAjax('删除留言成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function editReplyReviewAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('ReplyReview')->update($data, $error);
            }else{
                foreach ($data as $da) {
                    $success = D('ReplyReview')->update($da,$error);
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
            $success = D('ReplyReview')->upvote($data, $error);

            if ($success) {
                $this->successAjax('点赞成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}