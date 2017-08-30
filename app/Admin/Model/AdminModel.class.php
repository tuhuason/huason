<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;
use Think\Verify;
class AdminModel extends BaseModel
{
    protected $trueTableName  = 'admin';

    // 校验管理员账号和密码
    public function checkPassword($username, $password, &$error='')
    {
        $User = M('Admin');

        $res = $User->where("adminuser='%s' and password='%s'",array($username,$password))->find();
        if(!empty($res)){
            return true;
        }
        $error ='用户名或者密码错误';
        return false;
    }

    //管理员登录
    public function login($username, $password, $code, &$error = '')
    {
        if ($this->checkPassword($username, $password, $error)) {

            //验证码
            if(check_code($code) === false){
                $error = '验证码错误';
                return false;
            }

            // 设置会话
            session('username', $username);

            $User = M('Admin');
            $data = array(
                'lastip' => get_client_ip(),
                'lasttime' => time()
            );
            $User->where("adminuser='%s'",$username)->save($data);

            return true;
        } else {
            // $error = '账号或者密码错误';
            return false;
        }
    }

    // 判断是否已登录
    public function isLogined()
    {
        $username = session('username');
        if (!empty($username)) {
            return true;
        } else {
            return false;
        }
    }

    //验证码
    public function checkCode($code, &$error=''){
        $verify = new \Think\Verify();
        $res = $verify->check($code, $id);
        if($res){
            return true;
        }
        $error = '验证码错误!';
        return false;
    }

    // 注销用户登录
    public function logout()
    {
        session('username',null);
        session('admin_id',null);
        session('role',null);
        return true;
    }

    //注册
    public function reg($data, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $User = M('Admin');
        $res = $this->findByUsername($data['adminuser'], $error);

        //验证码
        if($this->checkCode($data['code'], $error) === false){
            return false;
        }
        
        $data['role_id'] = isset($data['role_id']) ? $data['role_id'] : 0;
        $data['createtime'] = time();
        $data['lasttime'] = time();
        $data['lastip'] = get_client_ip();

        if($res){
            $res = $User->add($data);
            if($res){
                return true;
            }
            $error = '注册失败！';
            return false;
        }
        return false;
    }

    //
    public function findByUsername($username, &$error='')
    {
        $User = M('Admin');
        $res = $User->where("adminuser='%s'",$username)->find();
        
        if(empty($res)){
            return true;
        }

        $error ='用户名已注册';
        return false;
    }

    public function delete($id, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $Art = M('Admin');
        
        $res = $Art->where("id='%d'",$id)->delete();

        if($res){
            return true;
        }
        $error = '删除管理员或普通管理员失败！';
        return false;
    }

    public function role($data, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $User = M('Admin');

        $res = $User->save($data);
        if($res){
            return true;
        }
        $error = '更新失败！';
        return false;
    }
    
    public function update($data, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $User = M('Admin');

        $res = $User->save($data);
        if($res){
            return true;
        }
        $error = '更新失败！';
        return false;
    }
}