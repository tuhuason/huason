<?php
namespace Home\Model;

class IndexModel{
    
    public function findOneArticle($id, &$error=''){
        $Art = new \Admin\Model\ArticleModel();
        $res = $Art->updateNum($id, $error);

        if(!$res){
            return false;
        }
        $data = $Art->findOne($id, $error);
        if(empty($data['auditing'])){
            return false;
        }
        
        return $data;
        
    }

    public function findAllDiary(){
        $data = M('Diary')->where("admin_id='%d'",session('admin_id'))->order('addtime desc')->select();
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
        $map['admin_id'] = session('admin_id');
        $data = M('Article')->join('category ON article.catid = category.catid')->where($map)->select();

        return $data;
    }
}