<?php

use Think\Storage;
use Home\Helper\Defaults;

if (!function_exists('check_code')) {
    //验证码
    function check_code($code, $id = ""){  
        $verify = new \Think\Verify();  
        return $verify->check($code, $id);  
    }

}