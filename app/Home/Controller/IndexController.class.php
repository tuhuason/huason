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

    public function qqLoginAction($type = 'qq'){
        empty($type) && $this->error('参数错误');
  
        $sns = \Org\ThinkSDK\ThinkOauth::getInstance($type);
      
         //跳转到授权页面  
        redirect($sns->getRequestCodeURL());
    }

    //授权回调地址
    public function callbackAction($type = 'qq', $code = null){
        empty($type) && $this->error('参数错误');
        
        //ThinkOauth类并实例化一个对象
        $sns = \Org\ThinkSDK\ThinkOauth::getInstance($type);

        //腾讯微博需传递的额外参数
        $extend = null;
        if($type == 'tencent'){
            $extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
        }

        //请妥善保管这里获取到的Token信息，方便以后API调用
        //调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
        //如： $qq = ThinkOauth::getInstance('qq', $token);
        $token = $sns->getAccessToken($code , $extend);

        //获取当前登录用户信息
        if(is_array($token)){
            $user_info = A('Type', 'Event')->$type($token);

            echo("<h1>恭喜！使用 {$type} 用户登录成功</h1><br>");
            echo("授权信息为：<br>");
            dump($token);
            echo("当前登录用户信息为：<br>");
            dump($user_info);
        }
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