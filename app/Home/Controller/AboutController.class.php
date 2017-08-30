<?php
namespace Home\Controller;

class AboutController extends BaseController {
    public function __construct(){
        $this->setWebTitle('首页')
            ->setIdentifier('about')
            ->addCrumb('首页', '/');

        parent::__construct();
    }
    public function indexAction(){

       $this->addCrumb('关于')->setCrumbs();
        $this->display('Index/about');
    }
}