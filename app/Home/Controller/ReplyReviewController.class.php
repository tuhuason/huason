<?php
namespace Home\Controller;

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
        $data = D('ReplyMessage')->findAll();

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

    public function deleteReplyMessageAction()
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
                $this->successAjax('删除留言成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}