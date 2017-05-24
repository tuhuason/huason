<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;
use Think\Verify;
class ArticleModel extends BaseModel
{
    protected $trueTableName  = 'article'; 

    // 
    public function findAll()
    {
        $Art = M('Article');
        $res = $Art->where("admin_id='%d'",session('admin_id'))->select();
        
        if($res){
            return $res;
        }
        return false;
    }

    public function findOne($id, &$error='')
    {

        $Art = M('Article');
        $res = $Art->join('category ON article.catid = category.catid')->where("id='%d' and admin_id='%d'",$id,session('admin_id'))->find();

        if($res){
            return $res;
        }
        $error = '失败！';
        return false;
    }

    public function add($data, &$error='')
    {
        $Art = M('Article');
        $admin_id = session('admin_id');

        $data['addtime'] = time();
        $data['admin_id'] = $admin_id;
        $data['uptime'] = time();

        //开启事务
        M()->startTrans();
        $res = $Art->add($data);
        $re = D('category')->updateNum($data['catid'], 'add', $error);
        if($res && $re){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '添加文章失败！';
        //回滚事务
        M()->rollback();
        return false;
    }
    
    public function delete($id, $catid, &$error='')
    {
        $Art = M('Article');

        //开启事务
        M()->startTrans();
        $res = $Art->where("id='%d'",$id)->delete();
        $re = D('category')->updateNum($catid, 'delete', $error);
        if($res && $re){
            //提交事务
            M()->commit();
            return true;
        }
        $error = '删除文章失败！';
        //回滚事务
        M()->rollback();
        return false;
    }

    public function update($data, &$error='')
    {
        $Art = M('Article');
        $admin_id = session('admin_id');

        $data['uptime'] = time();
        $data['admin_id'] = $admin_id;

        $res = $Art->where("id='%s'",$data['id'])->save($data);
        if($res){
            return true;
        }
        $error = '更新文章失败！';
        return false;
    }

    public function updateNum($id, &$error='')
    {
        $Art = M('Article');
        // $admin = M('Admin')->where("adminuser='%s'",session('username'))->find();
        // $admin_id = $admin['id'];

        $res = $Art->where("id='%s'",$id)->setInc('hit');
        if($res){
            return true;
        }
        $error = '更新阅读次数失败！';
        return false;
    }
}