<?php
/**
 * 管理员登录和注销
 */
namespace Home\Controller;

use Think\Controller;

class AccountController extends Controller
{
    private $defaultPage; // 默认跳转页面

    // 构造函数
    public function __construct()
    {
        parent::__construct();

        // 默认登录到首页
        $this->defaultPage = U('Home/Index/index');
    }

    // 首页指向用户登录页面
    public function indexAction()
    {
        $this->loginAction();
    }

    // 用户登录页
    public function loginAction()
    {
        $referer = session('referer');
        $referer = empty($referer) ? $this->defaultPage : $referer;

        if (D('Account')->isLogined()) {
            // 已登录, 跳转指定页面
            redirect($referer);
            return;
        }

        if (IS_POST) {
            // 提交登录
            $username = I('post.username', '');
            $password = I('post.password', '');

            // 设置页面变量
            $this->assign('username', $username);
            $this->assign('password', $password);

            if (empty($username)) {
                // 用户名为空
                $this->assign('msg', L('please input a username'));
                $this->display('login');
                return;
            } elseif (empty($password)) {
                // 密码为空
                $this->assign('msg', L('please input a password'));
                $this->display('login');
                return;
            }

            // 登录
            $error = '';
            $success = D('Account')->login($username, $password, $error);
            if (!$success) {
                // 失败
                $this->assign('msg', L('invalid username or password'));
                $this->display('login');
                return;
            }

            //  成功, 跳转页面
            redirect($referer);
            return;
        }

        // 显示登录页面
        $this->display('login');
        return;
    }

    // 用户注销
    public function logoutAction()
    {
        D('Account')->logout();
        session('referer', $this->defaultPage);
        $this->redirect('Home/Account/login');
        return;
    }
}