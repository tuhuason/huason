<?php
namespace Admin\Controller;

class DiaryController extends BaseController {
    public function __construct()
    {
        $this->setWebTitle('日记')
            ->setIdentifier('article');
        //     ->setLicense(false)
        //     ->addCrumb(L('index'), U('Home/Index/index'));

        parent::__construct();
    }

    // 首页
    public function indexAction()
    {
        $data = D('Diary')->findAll();
        
        $this->assign('diary', $data);
        $this->assign('identifier', 'article.diary');
       
        $this->display('index');
    }
    public function addDiaryAction()
    {
        if(IS_POST){

            $content = I('post.content', '');

            $error = '';
            $success = D('Diary')->add($content, $error);

            if ($success) {
                $this->successAjax('日记添加成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function editDiaryAction()
    {
        if(IS_POST){
            $data = I('post.data', '');

            $error = '';
            $success = D('Diary')->update($data, $error);

            if ($success) {
                $this->successAjax('日记更新成功');
            } else {
                $this->errorAjax($error);
            }    
        }
    }

    public function deleteDiaryAction()
    {
        if(IS_POST){

            $id = I('post.id', '');

            $error = '';
            if(is_array($id)){
                foreach ($id as $i) {
                    $success = D('Diary')->delete($i, $error);
                }
            }else{
                $success = D('Diary')->delete($id, $error);
            }

            if ($success) {
                $this->successAjax('删除日记成功');
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