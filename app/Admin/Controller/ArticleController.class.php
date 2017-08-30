<?php
namespace Admin\Controller;

class ArticleController extends BaseController {
    public function __construct()
    {
        $this->setWebTitle('博客文章')
            ->setIdentifier('article');
        //     ->setLicense(false)
        //     ->addCrumb(L('index'), U('Home/Index/index'));

        parent::__construct();
    }

    // 首页
    public function indexAction()
    {
        $data = D('Article')->findAll();
        $categorys = M('category')->select();

        $this->assign(array('identifier' => 'article.art', 'article' => $data, 'categorys' => $categorys));

        $this->display('index');
    }
    
    public function addArticleAction()
    {
        if(IS_POST){

            $data = I('post.data', '');
            // $catid = I('post.catid', '');
            // $tag = I('post.tag', '');
            // $content = I('post.content', '');

            $error = '';
            $success = D('Article')->add($data, $error);

            if ($success) {
                $this->successAjax('文章添加成功,等待审核。。。');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function editArticleAction()
    {
        if(IS_POST){
            $data = I('post.data', '');

            $error = '';
            if (count($data) == count($data, 1)) {
                $success = D('Article')->update($data, $error);
            } else {
                foreach ($data as $da) {
                    $success = D('Article')->update($da, $error);
                }
            }

            if ($success) {
                $this->successAjax('文章更新成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function deleteArticleAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            if(count($data) == count($data, 1)){
                $success = D('Article')->delete($data['id'], $data['catid'], $error);
            }else{
                foreach ($data as $da) {
                    $success = D('Article')->delete($da['id'], $da['catid'],$error);
                }
            }

            if ($success) {
                $this->successAjax('删除文章成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function findOneAction()
    {
        if(IS_POST){
            $id = I('post.id', '');

            $error = '';
            $data = D('Article')->findOne($id, $error);

            if ($data) {
                $this->successAjax($data);
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}