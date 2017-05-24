<?php
// 基础Model类
namespace Admin\Model;

class BaseModel
{
    // 菜单列表
    public function getMenuList() {
        return array(
            'index' => array(
                'url' => U('Admin/Index/index'),
                'name' => '首页',
                'id' => '0'
            ),
            'article' => array(
                'url' => 'javascript:;',
                'name' => '内容管理',
                'children' => array(
                    'art' => array(
                        'url' => U('Admin/Article/index'),
                        'name' => '文章管理',
                        'id' => '1'
                    ),
                    'log' => array(
                        'url' => U('Admin/diary/index'),
                        'name' => '日记管理',
                        'id' => '2'
                    ),
                    'review' => array(
                        'url' => U('Admin/Review/index'),
                        'name' => '评论管理',
                        'id' => '3'
                    ),
                    'reply_review' => array(
                        'url' => U('Admin/ReplyReview/index'),
                        'name' => '回复评论管理',
                        'id' => '4'
                    ),
                    'message' => array(
                        'url' => U('Admin/Message/index'),
                        'name' => '留言管理',
                        'id' => '5'
                    ),
                    'reply_message' => array(
                        'url' => U('Admin/ReplyMessage/index'),
                        'name' => '回复留言管理',
                        'id' => '6'
                    )
                )
            ),
            'user' => array(
                'url' => '#navshare',
                'name' => '用户管理',
                'children' => array(
                    'all_user' => array(
                        'url' => U('Admin/admin/index'),
                        'name' => '全部用户',
                        'id' => '4'
                    ),
                )
            ),
            // 'about' => array(
            //     'url' => U('Admin/Index/about'),
            //     'name' => '关于',
            //     'id' => '5'
            // ),
        );
    }
}