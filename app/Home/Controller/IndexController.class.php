<?php
namespace Home\Controller;

class IndexController extends BaseController {
    public function __construct(){
        $this->setWebTitle('首页')
            ->setIdentifier('index')
            ->addCrumb('首页', '/');

        parent::__construct();
    }

    // 首页
    public function indexAction(){
        // 设置面包屑
        // $this->setCrumbs();
        $data = M('Article')->join('category ON article.catid = category.catid')->where("admin_id='%d'",session('admin_id'))->order('tag desc,uptime desc')->limit(10)->select();
        
        $this->assign('data', $data);
        $this->display('index');
    }

    

    public function photoAction(){
        $this->display('photo');
    }

    public function DiaryAction(){
        $data = D('Index')->findAllDiary();

        $this->assign('data', $data);
        $this->display('diary');
    }

    public function aboutAction(){
        $this->addCrumb('关于')->setCrumbs();
        $this->display('about');
    }

    public function messageAction(){
        $this->addCrumb('留言')->setCrumbs();

        $meassage = M('Message')->select();
        $reply = M('reply_message')->where('auditing = 1')->select();
        $this->assign(
            array(
                'message' => $meassage,
                'reply' => $reply
            )
        );
        $this->display('message');
    }
}