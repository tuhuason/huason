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
        $data = M('Article')->join('category ON article.catid = category.catid')->where("admin_id=1")->order('tag desc,uptime desc')->limit(10)->select();
        
        $this->assign('data', $data);
        $this->display('index');
    }

    public function qqLoginAction(){
        $type = 'qq';
        $referer = $_SERVER['HTTP_REFERER'];
        session('referer', $referer);
        $sns = \Org\ThinkSDK\ThinkOauth::getInstance($type);
      
        //跳转到授权页面  
        redirect($sns->getRequestCodeURL());
    }

    //授权回调地址
    public function callbackAction(){
        $type = 'qq';
        $code = $_GET['code'];

        //ThinkOauth类并实例化一个对象
        $sns = \Org\ThinkSDK\ThinkOauth::getInstance($type);

        //获取到的Token信息，方便API调用
        $token = $sns->getAccessToken($code);

        //获取当前登录用户信息
        $qq_login = D('Qq');
        $data = $qq_login->login($token);
        //设置cookie有效期
        setcookie('openid', $token['openid'], time()+86400);
        redirect(session('referer'));
        return;
    }

    public function qqLogoutAction(){
        setcookie ("openid", "", time() - 3600);
        redirect(session('referer'));
        return;
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