<?php
namespace Home\Controller;

class DiaryController extends BaseController {
    public function __construct(){
        $this->setWebTitle('首页')
        	->setIdentifier('diary')
            ->addCrumb('首页', '/');

        parent::__construct();
    }
	public function indexAction(){
        $this->addCrumb('日记')->setCrumbs();
        $data = D('Index')->findAllDiary();

        $this->assign('data', $data);
        $this->display('Index/diary');
    }
}