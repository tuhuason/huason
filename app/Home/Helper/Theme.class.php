<?php
// 多主题支持
namespace Home\Helper;

use Think\Storage;

class Theme
{
    // 设置
    static public function set($theme) {
        $lang_file = DATA_PATH . 'theme.confi.data';
        return Storage::put($lang_file, $theme);
    }

    // 获取
    static public function get() {
        $lang_file = DATA_PATH . 'theme.confi.data';
        if (Storage::has($lang_file)) {
            return Storage::read($lang_file);
        } else {
            $defaults = new Defaults();
            return $defaults->defaultSkin;
        }
    }

    // 获取列表
    static public function getList() {
        return array(
            'classic' => '经典色',
            'cerulean' => '宝蓝色',
            'spacelab' => '深灰色',
        );
    }
}