<?php
/**
 * 默认配置\版权信息等
 */
namespace Home\Helper;

class Defaults
{
    public $defaultEntity; // 公司名
    public $defaultName; // 程序名
    public $defaultTitle; // web标题
    public $defaultHomepage; // 主页
    public $defaultCopyright; // 版权信息
    public $defaultSkin; // 默认皮肤
    public $defaultLanguage; // 默认语言

    public $defaultPhone; // 客服电话
    public $defaultSupportMail; // 客服邮件
    public $defaultAuthorizationMail; // license授权邮件

    public $defaultArch; // 产品体系
    public $defaultVersion; // 产品版本

    public $defaultGatewayIpaddress; // 默认请求网关IP
    public $defaultTimeout; // 默认请求超时

    public function __construct()
    {
        $this->defaultEntity = 'CYPHY';
        $this->defaultName = 'CYPHY Management System';
        $this->defaultTitle = 'CYPHY Management System';
        $this->defaultHomepage = 'http://www.cyphytech.com/';
        $this->defaultCopyright = sprintf('Copyrignt&copy;2011 - %s <a href="%s" target="_blank">%s</a>.All Rights Reserved', date('Y'), $this->defaultHomepage, $this->defaultEntity);
        $this->defaultSkin = 'classic';
        $this->defaultLanguage = 'zh-cn';

        $this->defaultPhone = '+86-0592-2936100';
        $this->defaultSupportMail = 'support@cyphytech.com';
        $this->defaultAuthorizationMail = 'support@cyphytech.com';

        $this->defaultArch = null; // 设置为null表示从接口获取
        $this->defaultVersion = null;  // 设置为null表示从接口获取

        $this->defaultGatewayIpaddress = 'localhost';
        $this->defaultTimeout = 300;
    }
}