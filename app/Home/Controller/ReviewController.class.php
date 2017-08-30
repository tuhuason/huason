<?php
namespace Home\Controller;

class ReviewController extends BaseController {
    public function __construct()
    {
        parent::__construct();
    }

    public function addReviewAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $Review = new \Admin\Model\ReviewModel();
            $success = $Review->add($data, $error);

            if ($success) {
                $this->successAjax('评论成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function pageAction(){
        if(IS_POST){
            $current_page = I('post.page/d');
            $num = I('post.num/d');
            $id = I('post.id/d');

            $Review = M('review');
            $reply_review = new \Admin\Model\ReplyReviewModel();
            $review = new \Admin\Model\ReviewModel();
            
            //加载分页
            $total_page = $Review->where("article_id= '%s' and auditing=1",$id)->count();
            $data['comment'] = $review->pages($current_page, $num, $id);
            $data['reply_review'] = $reply_review->pages($id);
            $data['total_page'] = ceil($total_page/$num);

            $this->successAjax($data);
        }
        return $this->error404Page();
    }

    //点赞或取消点赞
    public function upvoteAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $Review = new \Admin\Model\ReviewModel();
            $success = $Review->upvote($data, $error);

            if ($success) {
                $this->successAjax('点赞成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}