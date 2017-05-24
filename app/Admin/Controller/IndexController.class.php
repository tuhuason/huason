<?php
namespace Admin\Controller;

class IndexController extends BaseController {
    public function __construct()
    {
        $this->setWebTitle('首页')
            ->setIdentifier('index');
        //     ->setLicense(false)
        //     ->addCrumb(L('index'), U('Home/Index/index'));

        parent::__construct();
    }

    // 首页
    public function indexAction()
    {
        $data = D('Index')->count_num();

        $this->assign('data',$data);
        $this->display('index');
    }

    public function logAction()
    {
    

       
        $this->display('log');
    }
    public function timesAction()
    {
    

       
        $this->display('index');
    }
}