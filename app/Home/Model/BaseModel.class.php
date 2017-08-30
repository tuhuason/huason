<?php
// 基础Model类
namespace Home\Model;

class BaseModel
{
    // 菜单列表
    public function getMenuList() {
        return array(
            'index' => array(
                'url' => '/',
                'name' => '首页'
            ),
            'article' => array(
                'url' => U('/article/'),
                'name' => '文章',
                'children' => array(
                    'php' => array(
                        'url' => U('article/php'),
                        'name' => 'PHP'
                    ),
                    'web' => array(
                        'url' => U('article/webFrontend'),
                        'name' => 'web前端'
                    ),
                    'computer' => array(
                        'url' => U('article/computer'),
                        'name' => '计算机'
                    ),
                    'life' => array(
                        'url' => U('article/life'),
                        'name' => '生活百科'
                    ),
                    'mysql' => array(
                        'url' => U('article/mysql'),
                        'name' => 'Mysql'
                    )
                )
            ),
            // 'share' => array(
            //     'url' => '#navshare',
            //     'name' => '分享',
            //     'children' => array(
            //         'share1' => array(
            //             'url' => U('Home/Share/cifsManagment'),
            //             'name' => '源码分享'
            //         ),
            //         'jquery' => array(
            //             'url' => U('Home/Share/cifsManagment'),
            //             'name' => 'jquery特效'
            //         ),
            //     )
            // ),
            'diary' => array(
                'url' => U('/diary'),
                'name' => '日记'
            ),
            'about' => array(
                'url' => U('/about'),
                'name' => '关于'
            ),
            'message' => array(
                'url' => U('/feedback'),
                'name' => '留言'
            )
        );
    }

    // 判断是否成功
    public function isSuccess($data, &$error = '') {
        if ('ok' == $data['status']) {
            return true;
        } else {
            $error = $data['errdesc'];
            return false;
        }
    }

    // 返回结果
    public function getResults($data, $default = null)
    {
        if ($this->isSuccess($data)) {
            return $data['results'];
        }
        return $default;
    }

    // 获取数组指定健值
    public function getValueForKey($arr, $key, $default = null)
    {
        if (array_key_exists($key, $arr)) {
            return $arr[$key];
        }
        return $default;
    }

    // 设置license列表
    public function setLicenseList($license_list)
    {
        F('license_list', $license_list);
        return $this;
    }

    // 获取license列表
    public function getLicenseList()
    {
        return F('license_list');
    }

    // 是否有命令阻塞
    public function hasBlockCommand()
    {
        $data = D('Enclosure', 'Service')->hasBlockCommand();
        $no_has = $this->isSuccess($data);
        return !$no_has;
    }
}