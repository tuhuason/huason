<?php
namespace Admin\Controller;

class AdminController extends BaseController {
    public function __construct()
    {
        $this->setWebTitle('用户管理')
            ->setIdentifier('user');
        //     ->setLicense(false)
        //     ->addCrumb(L('index'), U('Home/Index/index'));

        parent::__construct();
    }

    // 首页
    public function indexAction()
    {
        $this->assign('identifier', 'user.all_user');
        
        if(session('role') != 1){
            $user = M('Admin')->where("adminuser = '%s'", session('username'))->select();
        }else{
            $user = M('Admin')->select();
        }

        $this->assign('user',$user);
        $this->display('index');
    }

    public function deleteUserAction()
    {
        if(IS_POST){
            $id = I('post.id','');

            $error = '';
            if(is_array($id)){
                foreach ($id as $i) {
                    $success = D('Admin')->delete($i, $error);
                }
            }else{
                $success = D('Admin')->delete($id, $error);
            }

            if ($success) {
                $this->successAjax('删除成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
    
    public function roleUserAction()
    {
        if(IS_POST){
            $data = I('post.data','');

            $error = '';
            $success = D('Admin')->role($data, $error);

            if ($success) {
                $this->successAjax('更新成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function editUserAction()
    {
        if(IS_POST){
            $data = I('post.data','');

            $error = '';
            $success = D('Admin')->update($data, $error);

            if ($success) {
                $this->successAjax('更新成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}