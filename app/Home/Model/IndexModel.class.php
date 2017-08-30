<?php
namespace Home\Model;

class IndexModel{
    
    public function findOneArticle($id, &$error=''){
        $Art = new \Admin\Model\ArticleModel();
        //开启事务
        M()->startTrans();
        $res = $Art->updateNum($id, $error);
        $data = $Art->findOne($id, $error);
        if($res && $data){
            //提交事务
            M()->commit();
            return $data;
        }
        $error = '查找文章失败！';
        //回滚事务
        M()->rollback();
        return false;
    }

    public function findAllDiary(){
        $data = M('Diary')->where("admin_id=1")->order('addtime desc')->select();
        $diary = array();
        
        foreach ($data as $diy) {
            $time = date('Y',$diy['addtime']);
            $diary[$time][] = array(
                'content' => $diy['content'],
                'addtime' => $diy['addtime'],
                'id' => $diy['id']
            );
        }
        return $diary;
    }

    public function search($param){
        $map['title|content'] = array('like','%'.$param.'%');
        $map['auditing'] = 1;
        $map['admin_id'] = 1;
        $data = M('Article')->join('category ON article.catid = category.catid')->where($map)->order('tag desc,addtime desc')->select();

        return $data;
    }
}