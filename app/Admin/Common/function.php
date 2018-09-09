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
if (!function_exists('get_area_from_ip')) {
	function get_area_from_ip($ip = ''){  
	    if(empty($ip)){  
	        $ip = get_client_ip();  
	    }  
	    $res = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
	    if(empty($res)){ return false; }
	    $json = json_decode($res, true);
	    $data = $json['data'];
	    return $data['region'].'-'.$data['city'];
	}
} 
if (!function_exists('SafeFilter')) {
	function SafeFilter($string) 
	{
	   $arr = array('&lt;script&gt;','&lt;/script&gt;','&amp;lt;script&amp;gt;','&amp;lt;/script&amp;gt;');
	   $string = str_replace($arr, '', $string);

	   return $string;
	}
}