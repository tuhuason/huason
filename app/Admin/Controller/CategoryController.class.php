<?php
namespace Admin\Controller;

class CategoryController extends BaseController {
    public function __construct()
    {
        $this->setWebTitle('分类')
            ->setIdentifier('article');
        //     ->setLicense(false)
        //     ->addCrumb(L('index'), U('Home/Index/index'));

        parent::__construct();
    }

    // 首页
    public function indexAction()
    {
        $data = D('Category')->findAll();

        $this->assign('category', $data);
        $this->assign('identifier', 'article.log');
       
        $this->display('index');
    }
    public function addCategoryAction()
    {
        if(IS_POST){

            $data = I('post.data', '');

            $error = '';
            $success = D('Category')->add($data, $error);

            if ($success) {
                $this->successAjax('添加分类成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function editCategoryAction()
    {
        if(IS_POST){
            $data = I('post.data', '');;

            $error = '';
            $success = D('Category')->update($data, $error);

            if ($success) {
                $this->successAjax('更新分类成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function deleteCategoryAction()
    {
        if(IS_POST){

            $id = I('post.id', '');

            $error = '';
            if(is_array($id)){
                foreach ($id as $i) {
                    $success = D('Category')->delete($i, $error);
                }
            }else{
                $success = D('Category')->delete($id, $error);
            }

            if ($success) {
                $this->successAjax('删除分类成功');
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
            $data = D('Diary')->findOne($id, $error);

            if ($data) {
                $this->successAjax($data);
            } else {
                $this->errorAjax($error);
            }    
        }
    }
}