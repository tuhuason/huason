<?php
namespace Home\Controller;

class UserController extends BaseController {
    public function __construct()
    {
        if(!session('openid')){
            redirect('/');
            exit;
        }
        parent::__construct();
    }

    // 首页
    public function indexAction()
    {
        // 设置面包屑
        $tmp_id = I('get.id/s');
        $id = md5(session('openid'));
        if($tmp_id != $id){
            return $this->error404Page();
        }

        $user = M('qq_login')->where("openid = '%s'", session('openid'))->field('nickname, openid, lastip, lasttime')->find();

        $this->assign('data', $user);
        $this->display('index');
    }

    public function messageAction()
    {
        $user = M('qq_login')->where("openid = '%s'", session('openid'))->field('nickname')->find();

        $data = array('is_readed' => 1);
        M('reply_review')->where("reply_master = '%s'", $user['nickname'])->save($data);
        M('reply_message')->where("reply_master = '%s'", $user['nickname'])->save($data);

        $response = M('reply_review')->join('article on reply_review.article_id = article.id')->field('article.id as article_id,article.content as article_content,article.title,reply_review.content,reply_review.reply_reviewer,reply_review.reply_master,reply_review.addtime,reply_review.identifier')->where("reply_master = '%s'", $user['nickname'])->select();
        $reply_message = M('reply_message')->where("reply_master = '%s'", $user['nickname'])->select();

        $this->assign(array('reply' => $response,'reply_message' => $reply_message));
        $this->display('message');
    }
}