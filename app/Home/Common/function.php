<?php

use Think\Storage;

if (!function_exists('signature_params')) {
    // 签名请求的参数
    function signature_params($params, $key)
    {
        // 按key升序
        ksort($params);

        // 签名的参数
        $need_sign_params = array();
        foreach ($params as $k => $v) {
            if (is_null($v) || 'sign' == strtolower($k) || !is_string($k) || '@' == $v[0]) {
                continue;
            }
            $need_sign_params[$k] = $v;
        }

        // 签名字符串
        $sign_str = $key . '&' . http_build_query($need_sign_params);
        return strtolower(md5($sign_str));
    }
}

if (!function_exists('post_upload_file')) {
    // 模拟POST文件上传
    function post_upload_file($file, $url, $filefield='file')
    {
        header("Content-Type:text/html;charset=UTF-8");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array($filefield => "@".$file));
        $raw_data = curl_exec($ch);
        curl_close($ch);
        return $raw_data;
    }
}

if (!function_exists('put_upload_file')) {
    // 模拟PUT文件
    function put_upload_file($fp, $url)
    {
        header("Content-Type:text/html;charset=UTF-8");

        $stat = fstat($fp);
        $file_size = $stat['size'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_INFILESIZE, $file_size);
        curl_setopt($ch, CURLOPT_INFILE, $fp);
        $raw_data = curl_exec($ch);
        curl_close($ch);
        return $raw_data;
    }
}

if (!function_exists('query_encode')) {
    // 生成Query字符串
    function query_encode($data) {
        $json_str = json_encode($data);
        $base64_str = base64_encode($json_str);
        return $base64_str;
    }
}

if (!function_exists('query_decode')) {
    // 解密Query字符串
    function query_decode($data) {
        $json_str = base64_decode($data);
        return json_decode($json_str, true);
    }
}
/**
 * 时间日期格式化为多少天前
 * @param sting|intval $date_time
 * @param intval $type 1、'Y-m-d H:i:s' 2、时间戳
 * @return string
 */
if (!function_exists('format_datetime')) {
    function format_datetime($date_time,$type=1,$format=null){
        if($type == 1){
            $timestamp = strtotime($date_time);
        }elseif($type == 2){
            $timestamp = $date_time;
        }
        if(isset($format)){
            return date($format,$timestamp);
        }
        $difference = time()-$timestamp;
        if($difference <= 180){
            return '刚刚';
        }elseif($difference <= 3600){
            return floor($difference/60).'分钟前';
        }elseif($difference <= 86400){
            return floor($difference/3600).'小时前';
        }elseif($difference <= 2592000){
            return floor($difference/86400).'天前';
        }elseif($difference <= 31536000){
            return floor($difference/2592000).'个月前';
        }else{
            return $date_time;
        }
    }
}

if (!function_exists('rand_str')) {
    function rand_str($len)
    {
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $string=time();
        for(;$len>=1;$len--)
        {
            $position=rand()%strlen($chars);
            $position2=rand()%strlen($string);
            $string=substr_replace($string,substr($chars,$position,1),$position2,0);
        }
        return $string;
    }
}

if (!function_exists('zero_num')) {
    function zero_num($num)
    {
        if($num < 10){
            return '0'.$num;
        }else{
            return $num;
        }
    }
}