<?php
// 管理员相关
namespace Home\Model;

use Think\Storage;

class AccountModel extends BaseModel
{
    // 多语言列表
    public function getLanguageList() {
        return array(
            'zh-cn' => '简体中文',
            'en-us' => 'English',
            'zh-tw' => '繁體中文',
        );
    }

    // 校验管理员账号和密码
    public function checkPassword($username, $password, &$error='')
    {
        // $data = D('Admin', 'Service')->validate($username, $password);
        // return $this->isSuccess($data, $error);
        if($username == 'admin' && $password == 'admin1'){
            return true;
        }
    }

    // 管理员登录
    public function login($username, $password, &$error = '')
    {
        if ($this->checkPassword($username, $password, $error)) {
            // 成功
            $sysinfo = D('Settings')->uname();

            $master = $this->getValueForKey($sysinfo, 'master', '127.0.0.1');
            if (in_array($master, array('127.0.0.1', 'localhost'))) {
                // 将master替换成API地址
                $_ = new \Home\Helper\Defaults;
                $master = $_->defaultGatewayIpaddress;
                unset($_);
            }
            if (in_array($master, array('127.0.0.1', 'localhost'))) {
                // 将master替换成当前服务器地址
                $master = I('server.SERVER_ADDR', 'localhost');
            }
            $arch = C('PRODUCT_ARCH');
            if (is_null($arch)) {
                // 从接口中获得arch
                $arch = $this->getValueForKey($sysinfo, 'arch', '');
            }
            $version = C('PRODUCT_VERSION');
            if (is_null($version)) {
                // 从接口中获得version
                $version = $this->getValueForKey($sysinfo, 'version', '');
            }
            $company = C('PRODUCT_COMPANY');
            if (is_null($company)) {
                // 从接口中获得company
                $company = $this->getValueForKey($sysinfo, 'company', '');
            }
            if ('cyphy' == strtolower($company)) {
                $company = 'CYPHY';
            }

            // 设置会话
            session('username', $username);
            session('guid', $this->getValueForKey($sysinfo, 'guid', ''));
            session('os', $this->getValueForKey($sysinfo, 'os', ''));
            session('arch', $arch);
            session('version', $version);
            session('platform', $this->getValueForKey($sysinfo, 'platform', ''));
            session('dp', $this->getValueForKey($sysinfo, 'dp', ''));
            session('cp', $this->getValueForKey($sysinfo, 'cp', ''));
            session('released_date', $this->getValueForKey($sysinfo, 'released_date', ''));
            session('company', $company);
            session('product', $this->getValueForKey($sysinfo, 'product', ''));
            session('master', $master);

            // 设置license列表
            $this->setLicenseList($this->getValueForKey($sysinfo, 'license_list', array()));

            // 设置登录时间和IP
            $this->setLoginTimeAndIP();

            // 设置GUIUD
            $this->setMasterGUID($master);

            return true;
        } else {
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

    // 注销用户登录
    public function logout()
    {
        session(null);
        session('[destory]');
        $this->setLicenseList(array());
        $this->cleanCacheFiles();

        return true;
    }

    // 修改管理员密码
    public function changePassword($username, $oldpassword, $newpassword, &$error='') {
        $data = D('Admin', 'Service')->changePassword($username, $oldpassword, $newpassword);
        return $this->isSuccess($data, $error);
    }

    // 设置登录时间和IP
    public function setLoginTimeAndIP()
    {
        $log_file = LOG_PATH.'last.log';

        $origin_data = $this->getLoginTimeAndIP();
        $ip = get_client_ip();
        $ip = '0.0.0.0' == $ip ? '127.0.0.1' : $ip;
        $this_login = array('time' => time(), 'ip' => $ip);
        $last_login = $origin_data['this_login'] ? $origin_data['this_login'] : array('time' => '-', 'ip' => '-');
        $content = serialize(array(
            'this_login' => $this_login,
            'last_login' => $last_login
        ));
        return Storage::put($log_file, $content);
    }

    // 获取登录时间和IP
    public function getLoginTimeAndIP()
    {
        $log_file = LOG_PATH.'last.log';
        if (!Storage::has($log_file)) {
            return array(
                'this_login' => array('time' => '-', 'ip' => '-'),
                'last_login' => array('time' => '-', 'ip' => '-')
            );
        } else {
            $raw_data = Storage::read($log_file);
            return unserialize($raw_data);
        }
    }

    // 清除配置缓存文件
    public function cleanCacheFiles() {
        foreach (glob(DATA_PATH . '*.data') as $filename) {
            Storage::unlink($filename);
        }
    }
}