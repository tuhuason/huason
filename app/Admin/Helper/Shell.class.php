<?php

/**
 * 执行shell命令
 */

namespace Home\Helper;

class Shell {
    // 1. 重启backend服务
    static public function restartBackend() {
        $command = 'crm resource restart cp_backend';
        list ($code, $_) = self::execute($command);
        return $code == 0;
    }

    // 执行命令 (退出码, 结果)
    static public function execute($command) {
        $result = system($command, $code);
        return array($code, $result);
    }
}