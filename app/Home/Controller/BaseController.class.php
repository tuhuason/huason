<?php
namespace Home\Controller;

use Home\Helper\Language;
use Home\Helper\Theme;
use Think\Controller;
class BaseController extends Controller
{
    protected $_webtitle = ''; // 标题,子类必须设置
    protected $_license = false; //若受license限制则需子类必须设置
    protected $_identifier = ''; //当前控制器标示
    protected $_crumbs = array(); //面包屑
    protected $_menus = array(); //

    protected $_username;
    protected $_logfile;
    protected $_logformat = "%s visitor %s %s %s %s\n"; // 日志格式

    public function __construct()
    {
        parent::__construct();

        // //用户是否登录
        // if (!D('Account')->isLogined()) {
        //     if (IS_AJAX) {
        //         $this->errorAjax(L('not authorized'), -9999);
        //     }

        //     // 用户未登录, 跳转到登录界面
        //     if ('account' == strtolower(CONTROLLER_NAME)) {
        //         session('referer', U('Home/Index/index'));
        //     } else {
        //         session('referer', __SELF__);
        //     }
        //     redirect(U('Home/Account/login'));
        //     exit;
        // }

        // 设置公共属性
        $this->_username = session('username');

        $this->setIdentifier($this->_identifier);

        //  菜单项
        $menu_list = D('Base')->getMenuList();

        //获取当前用户的信息
        $cur_user = M('Admin')->where("adminuser='%s'",$this->_username)->find();
        session('admin_id',$cur_user['id']);
        session('role', $cur_user['role_id']);
        
        //主页获取最热和最新文章
        $hot = M('Article')->join('category ON article.catid = category.catid')->where("auditing = 1 and admin_id='%d'",session('admin_id'))->order('hit desc,addtime desc')->limit(10)->select();
        $new = M('Article')->join('category ON article.catid = category.catid')->where("auditing = 1 and admin_id='%d'",session('admin_id'))->order('comment desc')->limit(10)->select();
        //文章分类
        $category = M('category')->select();

        // 设置公共模版变量
        $this->assign(array(
            'username' => $this->_username,
            'webtitle' => $this->_webtitle,
            'identifier' => $this->_identifier,
            'menu_list' => $menu_list,
            'new' => $new,
            'hot' => $hot,
            'category' => $category
        ));
    }

    // 记录日志
    protected function log($nodename, $info, $message)
    {
        $this->_logfile = LOG_PATH.'operate.log';
        $ip = get_client_ip();
        $ip = '0.0.0.0' == $ip ? '127.0.0.1' : $ip;
        $content = sprintf($this->_logformat, date('y-m-d H:i:s'), $ip, $nodename, $info, $message);
        // $log = ($content);
        return error_log($content, 3, $this->_logfile);
    }

    // 添加面包屑
    protected function addCrumb($title, $url = '')
    {
        $this->_crumbs[] = array('title' => $title, 'url' => $url);
        return $this;
    }

    // 设置面包屑
    protected function setCrumbs($crumbs = null)
    {
        $crumbs = is_null($crumbs) ? $this->_crumbs : $crumbs;
        $this->assign('crumbs', $crumbs);
        return $this;
    }

    // 设置title
    protected function setWebTitle($title)
    {
        $this->_webtitle = L($title);
        return $this;
    }


    // 设置页面标示
    protected function setIdentifier($identifier = false)
    {
        if (empty($identifier)) {
            $identifier = strtolower(CONTROLLER_NAME);
        }
        $this->_identifier = $identifier;
        return $this;
    }

    // 
    protected function addMenus($name, $url = '')
    {
        $this->_menus[] = array('name' => $name, 'url' => $url);
        return $this;
    }
    // 
    protected function setMenus($menus= null)
    {
        $menus = is_null($menus) ? $this->_menus : $menus;
        $this->assign('menus', $menus);
        return $this;

    }


    // 404页面
    protected function error404Page()
    {
        send_http_status(404);
        if (IS_AJAX) {
            $this->errorAjax('找不到');
        }
        $this->assign(array(
            'error_title' => '找不到',
            'error_message' => 'NOT FOUND!',
            'username' => $this->_username
        ));
        $this->display('Error/404');
        exit;
    }

    // 常规错误页面
    protected function errorPage($message, $title = false)
    {
        if (IS_AJAX) {
            $this->errorAjax($message);
        }

        $this->addCrumb(L('error'))->setCrumbs();
        $this->assign(array(
            'error_title' => !$title ? L('error message') : $title,
            'error_message' => $message,
            'username' => $this->_username
        ));
        $this->display('Error/error');
        exit;
    }

    // 数据为空页面
    protected function emptyPage()
    {
        if (IS_AJAX) {
            $this->errorAjax(L('no data'));
        }
        $this->assign('username', $this->_username);
        $this->display('Error/empty');
        exit;
    }

    // ajax输出
    protected function outputAjax($data)
    {
        return $this->ajaxReturn($data, 'json');
    }

    // ajax错误
    protected function errorAjax($errdesc, $code = -1)
    {
        return $this->outputAjax(array(
            'status' => 'error',
            'errdesc' => $errdesc,
            'errcode' => $code,
            'results' => '',
        ));
    }

    // ajax成功
    protected function successAjax($data, $code = 0)
    {
        return $this->outputAjax(array(
            'status' => 'ok',
            'errdesc' => '',
            'errcode' => $code,
            'results' => $data
        ));
    }
}