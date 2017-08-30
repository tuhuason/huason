<?php
/**
 * 管理员登录和注销
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Verify;

class AccountController extends Controller
{
    private $defaultPage; // 默认跳转页面

    // 构造函数
    public function __construct()
    {
        parent::__construct();

        // 默认登录到首页
        $this->defaultPage = 'admin/Index/index';
    }

    // 首页指向用户登录页面
    public function indexAction()
    {
        
        $this->loginAction();
    }

    // 用户登录页
    public function loginAction()
    {
        if (D('Admin')->isLogined()) {
            // 已登录, 跳转指定页面
            $this->redirect($this->defaultPage);
            exit;
    
        }

        if(IS_POST){
            // 提交登录
            $username = I('post.adminuser', '');
            $password = I('post.password', '');
            $code = I('post.code', '');
            // 登录
            $error = '';
            $success = D('Admin')->login($username, $password, $code, $error);

            if ($success) {
                $data = array(
                    'status' => 'ok',
                    'errdesc' => '',
                    'errcode' => 1,
                    'results' => '登陆成功'
                );
                $this->ajaxReturn($data,'json');
            } else {
                $data = array(
                    'status' => 'error',
                    'errdesc' => $error,
                    'errcode' => 0,
                    'results' => ''
                );

                $this->ajaxReturn($data,'json');
            }    
        }
        $this->display('login');
    }

    // 用户注销
    public function logoutAction()
    {
        D('Admin')->logout();
        $this->redirect('Admin/account/index');
        return;
    }

    //注册操作
    public function regAction()
    {
        if (IS_POST) {
            // 提交登录
            $data = I('post.data', '');

            // 登录
            $error = '';
            $success = D('Admin')->reg($data, $error);

            if ($success) {
                $data = array(
                    'status' => 'ok',
                    'errdesc' => '',
                    'errcode' => 1,
                    'results' => '注册成功，请登录！'
                );
                $this->ajaxReturn($data,'json');
            } else {
                $data = array(
                    'status' => 'error',
                    'errdesc' => $error,
                    'errcode' => 0,
                    'results' => ''
                );
                $this->ajaxReturn($data,'json');
            }
        }

        $this->display('reg');
    }

    // 生成验证码
    public function verifyAction()
    {
        ob_clean(); 
        $config = [
            'fontSize' => 19, // 验证码字体大小
            'length' => 4, // 验证码位数
            'imageH' => 34
        ];
        $Verify = new Verify($config);
        $Verify->entry();
    }

}