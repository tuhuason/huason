<?php
namespace Home\Model;

class QqModel extends BaseModel

{

    // 校验管理员账号和密码
    public function exist($openid){
        $res = M('qq_login')->where("openid = '%s'", $openid)->select();
        // return $this->isSuccess($data, $error);
        if(!empty($res)){
            return true;
        }
        return false;
    }

    // 管理员登录
    public function login($token,&$error = ''){
        
        $qq = \Org\ThinkSDK\ThinkOauth::getInstance('qq', $token);
        $data = $qq->call('user/get_user_info');
        $openid = $token['openid'];
        if ($data['ret'] == 0) {
            $datas = array(
                'nickname' => $data['nickname'],
                'openid' => $openid,
                'createtime' => time(),
                'lastip' => get_client_ip(),
                'lasttime' => time(),
                'avatar' => $data['figureurl_qq_1']
            );

            $res = $this->exist($openid);
            if($res === false){
                return $this->add($datas, $error);
                
            }else{
                $datas['lastip'] = get_client_ip();
                $datas['lasttime'] = time();
                return $this->update($datas, $openid, $error);
            }
        } else {
            E("获取腾讯QQ用户信息失败：{$data['msg']}");
        }
    }

    //添加
    public function add($data, &$error=''){
        //开启事务
        M('qq_login')->startTrans();
        $res = M('qq_login')->add($data);
        if($res){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '添加文章失败！';
        //回滚事务
        M()->rollback();
        return false;
    }

    //更新
    public function update($data, $openid, &$error=''){
        //开启事务
        M('qq_login')->startTrans();
        $res = M('qq_login')->where("openid = '%s'", $openid)->save($data);
        if($res){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '添加文章失败！';
        //回滚事务
        M()->rollback();
        return false;
    }
}