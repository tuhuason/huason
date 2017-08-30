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
	    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);  
	    if(empty($res)){ return false; }  
	    $jsonMatches = array();  
	    preg_match('#\{.+?\}#', $res, $jsonMatches);  
	    if(!isset($jsonMatches[0])){ return false; }  
	    $json = json_decode($jsonMatches[0], true);  
	    if(isset($json['ret']) && $json['ret'] == 1){  
	        $json['ip'] = $ip;  
	        unset($json['ret']);  
	    }else{  
	        return false;  
	    }  
	    return $json['province'].' '.$json['city'];  
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