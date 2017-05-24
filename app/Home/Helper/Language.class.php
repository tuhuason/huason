<?php
// 多语言支持
namespace Home\Helper;

use Think\Storage;

class Language
{
    // 设置
    static public function set($code) {
        $lang_file = DATA_PATH . 'lang.confi.data';
        return Storage::put($lang_file, $code);
    }

    // 获取
    static public function get() {
        $lang_file = DATA_PATH . 'lang.confi.data';
        if (Storage::has($lang_file)) {
            return Storage::read($lang_file);
        } else {
            $defaults = new Defaults();
            return $defaults->defaultLanguage;
        }
    }

    // 获取列表
    static public function getList() {
        return array(
            'zh-cn' => '简体中文',
            'zh-tw' => '繁體中文',
            'en-us' => 'English',
        );
    }
}