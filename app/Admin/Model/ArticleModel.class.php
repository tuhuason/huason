<?php
// 管理员相关
namespace Admin\Model;

use Think\Storage;
use Think\Verify;
use Common\XssHtml;
class ArticleModel extends BaseModel
{
    protected $trueTableName  = 'article'; 

    public function findAll()
    {
        $Art = M('Article');
        $res = $Art->select();

        if($res){
            return $res;
        }
        return false;
    }
    
    //分页 
    public function pages($current_page, $num)
    {
        $Art = M('Article');
        $res = $Art->join('category ON article.catid = category.catid')->where("auditing=1 and admin_id=1")->order('tag desc,addtime desc')->page($current_page.','.$num)->select();
        $data = [];
        if($res){
            foreach ($res as $article) {
                $article['content'] = mb_substr(strip_tags(htmlspecialchars_decode($article['content'])), 0,100);
                $data[] = $article;
            }
            return $data;
        }
        return false;
    }

    public function findOne($id, &$error='')
    {

        $Art = M('Article');
        $res = $Art->join('category ON article.catid = category.catid')->where("id='%d' and admin_id=1 and auditing =1",$id)->find();

        if($res){
            $res['content'] = htmlspecialchars_decode($res['content']);
            return $res;
        }
        $error = '失败！';
        return false;
    }

    public function add($data, &$error='')
    {
        if($this->authority($error) === false){
            return false;
        }

        $Art = M('Article');
        $admin_id = session('admin_id');

        $filter = new XssHtml(htmlspecialchars_decode($data['content']));
        $data['content'] = htmlspecialchars($filter->getHtml());
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
        if($this->authority($error) === false){
            return false;
        }

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
        if($this->authority($error) === false){
            return false;
        }

        $Art = M('Article');
        $admin_id = session('admin_id');

        $filter = new XssHtml(htmlspecialchars_decode($data['content']));
        $data['content'] = htmlspecialchars($filter->getHtml());
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

        $res = $Art->where("id='%s'",$id)->setInc('hit');
        if($res){
            return true;
        }
        $error = '更新阅读次数失败！';
        return false;
    }
}
