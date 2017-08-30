<?php
namespace Admin\Controller;

class ReviewController extends BaseController {
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
        $data = D('Review')->findAll();

        $this->assign('identifier', 'article.review');
        $this->assign('review', $data);

        $this->display('index');
    }
    
    public function addReviewAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $success = D('Review')->add($data, $error);

            if ($success) {
                $this->successAjax('评论成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function deleteReviewAction()
    {
        if(IS_POST){

            $data = I('post.data', '');
            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('Review')->delete($data['id'], $data['article_id'], $error);
            }else{
                foreach ($data as $da) {
                    $success = D('Review')->delete($da['id'], $da['article_id'],$error);
                }
            }

            if ($success) {
                $this->successAjax('删除评论成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function editReviewAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('Review')->update($data, $error);
            }else{
                foreach ($data as $da) {
                    $success = D('Review')->update($da,$error);
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
            $success = D('Review')->upvote($data, $error);

            if ($success) {
                $this->successAjax('更新成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}