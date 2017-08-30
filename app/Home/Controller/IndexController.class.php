<?php
namespace Home\Controller;

class IndexController extends BaseController {
    public function __construct(){
        $this->setWebTitle('首页')
            ->addCrumb('首页', '/');

        parent::__construct();
    }

    // 首页
    public function indexAction(){
        // 设置面包屑
        $this->setIdentifier('index');

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
        session('openid', $token['openid']);
        redirect(session('referer'));
        return;
    }

    public function qqLogoutAction(){
        session('openid',null);
        redirect(session('referer'));
        return;
    }
}
